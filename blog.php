<?php require_once('header.php'); ?>

<?php
// Lấy thông tin từ bảng tbl_page
$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
$statement->execute();
$page = $statement->fetch(PDO::FETCH_ASSOC);
$blog_title = $page['blog_title'];
$blog_meta_title = $page['blog_meta_title'];
?>
<style>
    .post-item img {
        width: 100%; /* Đảm bảo ảnh chiếm toàn bộ chiều rộng của cột */
        height: auto; /* Tự động điều chỉnh chiều cao để giữ tỉ lệ */
        object-fit: cover; /* Cắt ảnh nếu cần để giữ hình ảnh cân đối */
        max-height: 200px; /* Đặt chiều cao tối đa để ảnh không quá lớn */
        border-radius: 5px; /* Bo góc ảnh cho đẹp hơn */
    }

    .post-item .col-md-4 {
        display: flex; /* Đảm bảo nội dung ảnh được căn giữa */
        justify-content: center;
        align-items: center;
    }

    .post-item {
        margin-bottom: 20px; /* Thêm khoảng cách giữa các bài viết */
    }

    .post-item h2 {
        font-size: 20px; /* Đặt kích thước chữ tiêu đề */
        margin-top: 10px;
    }

    .post-item p {
        font-size: 14px; /* Làm nội dung mô tả nhỏ gọn hơn */
        line-height: 1.5;
    }
</style>

<div class="post-item">
    <div class="row">
        <div class="col-md-4">
            <img src="assets/uploads/<?php echo $post_photo; ?>" class="img-fluid" alt="<?php echo $post['post_title']; ?>">
        </div>
        <div class="col-md-8">
            <h2><?php echo $post['post_title']; ?></h2>
            <p><?php echo $short_content; ?></p>
            <a href="blog.php?post_slug=<?php echo $post['post_slug']; ?>" class="btn btn-primary">Xem thêm</a>
        </div>
    </div>
</div>

<div class="container">
    <h1 style="text-align: center; margin-bottom: 20px;"><?php echo $blog_title; ?></h1>
    <div class="posts-container">
        <div class="page">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <?php if (!isset($_GET['post_slug'])) { ?>
                            <!-- Danh sách bài viết -->
                            <div class="post-list">
                                <?php
                                $statement = $pdo->prepare("SELECT * FROM tbl_post ORDER BY post_date DESC");
                                $statement->execute();
                                $posts = $statement->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($posts as $post) {
                                    // Cắt bớt nội dung để hiển thị phần mô tả ngắn
                                    $short_content = mb_strimwidth(strip_tags($post['post_content']), 0, 200, "...");
                                    // Kiểm tra ảnh, nếu không có ảnh thì sử dụng ảnh mặc định
                                    $post_photo = !empty($post['photo']) ? $post['photo'] : 'default.jpg';
                                    ?>
                                    <div class="post-item">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <img src="assets/uploads/<?php echo $post_photo; ?>" class="img-fluid" alt="<?php echo $post['post_title']; ?>">
                                            </div>
                                            <div class="col-md-8">
                                                <h2><?php echo $post['post_title']; ?></h2>
                                                <p><?php echo $short_content; ?></p>
                                                <a href="blog.php?post_slug=<?php echo $post['post_slug']; ?>" class="btn btn-primary">Xem thêm</a>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                <?php } ?>
                            </div>
                        <?php } else { 
                            // Hiển thị chi tiết bài viết
                            $post_slug = $_GET['post_slug'];
                            $statement = $pdo->prepare("SELECT * FROM tbl_post WHERE post_slug = ?");
                            $statement->execute([$post_slug]);
                            $post = $statement->fetch(PDO::FETCH_ASSOC);

                            if ($post) {
                                // Kiểm tra ảnh, nếu không có ảnh thì sử dụng ảnh mặc định
                                $post_photo = !empty($post['photo']) ? $post['photo'] : 'default.jpg';
                                ?>
                                <div class="post-detail">
                                    <h1><?php echo $post['post_title']; ?></h1>
                                    <img src="assets/uploads/<?php echo $post_photo; ?>" class="img-fluid" alt="<?php echo $post['post_title']; ?>">
                                    <p><?php echo $post['post_content']; ?></p>
                                    <a href="blog.php" class="btn btn-secondary">Quay lại</a>
                                </div>
                            <?php } else { ?>
                                <div class="alert alert-danger">
                                    Bài viết không tồn tại!
                                </div>
                                <a href="blog.php" class="btn btn-secondary">Quay lại</a>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>
