<?php require_once('header.php'); ?>

<?php
// Lấy thông tin từ bảng tbl_page
$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
$statement->execute();
$page = $statement->fetch(PDO::FETCH_ASSOC);

// Kiểm tra xem dữ liệu trang có tồn tại không
if ($page) {
    $blog_title = $page['blog_title'];
    $blog_meta_title = $page['blog_meta_title'];
} else {
    $blog_title = "Blog";
    $blog_meta_title = "Danh sách bài viết";
}
?>

<style>
    .post-item img {
        width: 100%;
        height: auto;
        object-fit: cover;
        max-height: 200px;
        border-radius: 5px;
    }

    .post-item .col-md-4 {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .post-item {
        margin-bottom: 20px;
    }

    .post-item h2 {
        font-size: 20px;
        margin-top: 10px;
    }

    .post-item p {
        font-size: 14px;
        line-height: 1.5;
    }
</style>

<div class="container">
    <h1 style="text-align: center; margin-bottom: 20px;"><?php echo htmlspecialchars($blog_title); ?></h1>
    <div class="posts-container">
        <?php
        if (!isset($_GET['post_slug'])) {
            // Danh sách bài viết
            $statement = $pdo->prepare("SELECT * FROM tbl_post ORDER BY post_date DESC");
            $statement->execute();
            $posts = $statement->fetchAll(PDO::FETCH_ASSOC);

            if ($posts) {
                foreach ($posts as $post) {
                    // Kiểm tra và xử lý nội dung
                    $post_title = htmlspecialchars($post['post_title']);
                    $post_slug = htmlspecialchars($post['post_slug']);
                    $post_content = htmlspecialchars($post['post_content']);
                    $short_content = mb_strimwidth(strip_tags($post_content), 0, 200, "...");
                    $post_photo = !empty($post['photo']) ? htmlspecialchars($post['photo']) : 'default.jpg';
                    ?>
                    <div class="post-item">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="assets/uploads/<?php echo $post_photo; ?>" class="img-fluid" alt="<?php echo $post_title; ?>">
                            </div>
                            <div class="col-md-8">
                                <h2><?php echo $post_title; ?></h2>
                                <p><?php echo $short_content; ?></p>
                                <a href="blog.php?post_slug=<?php echo $post_slug; ?>" class="btn btn-primary">Xem thêm</a>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <?php
                }
            } else {
                echo '<p>Không có bài viết nào để hiển thị.</p>';
            }
        } else {
            // Hiển thị chi tiết bài viết
            $post_slug = htmlspecialchars($_GET['post_slug']);
            $statement = $pdo->prepare("SELECT * FROM tbl_post WHERE post_slug = ?");
            $statement->execute([$post_slug]);
            $post = $statement->fetch(PDO::FETCH_ASSOC);

            if ($post) {
                $post_title = htmlspecialchars($post['post_title']);
                $post_content = htmlspecialchars($post['post_content']);
                $post_photo = !empty($post['photo']) ? htmlspecialchars($post['photo']) : 'default.jpg';
                ?>
                <div class="post-detail">
                    <h1><?php echo $post_title; ?></h1>
                    <img src="assets/uploads/<?php echo $post_photo; ?>" class="img-fluid" alt="<?php echo $post_title; ?>">
                    <p><?php echo $post_content; ?></p>
                    <a href="blog.php" class="btn btn-secondary">Quay lại</a>
                </div>
                <?php
            } else {
                echo '<div class="alert alert-danger">Bài viết không tồn tại!</div>';
                echo '<a href="blog.php" class="btn btn-secondary">Quay lại</a>';
            }
        }
        ?>
    </div>
</div>

<?php require_once('footer.php'); ?>
