<?php require_once('header.php'); ?>

<?php
// Lấy thông tin từ bảng tbl_page
$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
$statement->execute();
$page = $statement->fetch(PDO::FETCH_ASSOC);
$blog_title = $page['blog_title'] ?? 'Blog';
$blog_meta_title = $page['blog_meta_title'] ?? '';

// Lấy ảnh từ bảng tbl_post (bài viết mới nhất)
$statement = $pdo->prepare("SELECT photo FROM tbl_post ORDER BY post_date DESC LIMIT 1");
$statement->execute();
$post = $statement->fetch(PDO::FETCH_ASSOC);

$blog_banner = (!empty($post['photo']) && file_exists('assets/uploads/' . $post['photo'])) ? $post['photo'] : 'default.jpg';
?>

<div class="page-banner" style="background-image: url(assets/uploads/<?php echo htmlspecialchars($blog_banner); ?>); background-size: cover; background-position: center center; height: 300px;">
    <p>URL của ảnh nền: assets/uploads/<?php echo htmlspecialchars($blog_banner); ?></p>
</div>

<div class="container">
    <h1 style="text-align: center; margin-bottom: 20px;">Bài viết nổi bật</h1>
    <div class="posts-container">
        <?php
        // Kiểm tra nếu không có tham số post_slug (hiển thị danh sách bài viết)
        if (!isset($_GET['post_slug'])) {
            $statement = $pdo->prepare("SELECT * FROM tbl_post ORDER BY post_date DESC");
            $statement->execute();
            $posts = $statement->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($posts)) {
                foreach ($posts as $post) {
                    $short_content = mb_strimwidth(strip_tags($post['post_content']), 0, 200, "...");
        ?>
                    <div class="post-item">
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <?php if (!empty($post['photo']) && file_exists('assets/uploads/' . $post['photo'])) { ?>
                                    <img src="assets/uploads/<?php echo htmlspecialchars($post['photo']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($post['post_title']); ?>">
                                <?php } else { ?>
                                    <img src="assets/uploads/default.jpg" class="img-fluid" alt="Ảnh mặc định">
                                <?php } ?>
                            </div>
                            <div class="col-md-8">
                                <h2><?php echo htmlspecialchars($post['post_title']); ?></h2>
                                <p><?php echo $short_content; ?></p>
                                <a href="blog.php?post_slug=<?php echo htmlspecialchars($post['post_slug']); ?>" class="btn btn-primary">Xem thêm</a>
                            </div>
                        </div>
                    </div>
                    <hr>
        <?php
                }
            } else {
                echo '<div class="alert alert-warning text-center">Hiện tại không có bài viết nào.</div>';
            }
        } else {
            // Hiển thị chi tiết bài viết
            $post_slug = $_GET['post_slug'];
            $statement = $pdo->prepare("SELECT * FROM tbl_post WHERE post_slug = ?");
            $statement->execute([$post_slug]);
            $post = $statement->fetch(PDO::FETCH_ASSOC);

            if ($post) {
        ?>
                <div class="post-detail">
                    <h1><?php echo htmlspecialchars($post['post_title']); ?></h1>
                    <?php if (!empty($post['photo']) && file_exists('assets/uploads/' . $post['photo'])) { ?>
                        <img src="assets/uploads/<?php echo htmlspecialchars($post['photo']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($post['post_title']); ?>">
                    <?php } else { ?>
                        <img src="assets/uploads/default.jpg" class="img-fluid" alt="Ảnh mặc định">
                    <?php } ?>
                    <p><?php echo nl2br($post['post_content']); ?></p>
                    <a href="blog.php" class="btn btn-secondary">Quay lại</a>
                </div>
        <?php
            } else {
                echo '<div class="alert alert-danger text-center">Bài viết không tồn tại!</div>';
                echo '<a href="blog.php" class="btn btn-secondary">Quay lại</a>';
            }
        }
        ?>
    </div>
</div>

<?php require_once('footer.php'); ?>
