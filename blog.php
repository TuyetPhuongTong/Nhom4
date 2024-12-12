<?php
// Kết nối file header.php
require_once('header.php');

// Lấy thông tin trang từ bảng tbl_page
$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
$statement->execute();
$page = $statement->fetch(PDO::FETCH_ASSOC);
$blog_title = $page['blog_title'];
$blog_meta_title = $page['blog_meta_title'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($blog_meta_title, ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="blog.css">
</head>
<body>
<style>
/* Đặt nền và màu chữ chính */
body {
    background-color: #f4f4f4;
    color: #333;
    font-family: Arial, sans-serif;
}

/* Tiêu đề blog */
h1 {
    color: #006666;
}

/* Nút */
.btn-primary {
    background-color: #006666;
    border: none;
    color: #fff;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.btn-primary:hover {
    background-color: #004d4d;
    color: #f0f0f0;
}

.btn-secondary {
    background-color: #CC3300;
    border: none;
    color: #fff;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.btn-secondary:hover {
    background-color: #992600;
    color: #f0f0f0;
}

/* Các bài viết */
.post-item {
    background-color: #ffffff;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 15px;
    margin-bottom: 20px;
    transition: box-shadow 0.3s ease, transform 0.3s ease;
}

.post-item:hover {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transform: translateY(-5px);
}

.post-item h2 {
    color: #006666;
    transition: color 0.3s ease;
}

.post-item h2:hover {
    color: #004d4d;
}

.post-item p {
    color: #333;
}

.post-item img {
    border-radius: 5px;
    transition: transform 0.3s ease;
}

.post-item img:hover {
    transform: scale(1.05);
}

/* Bài viết chi tiết */
.post-detail h1 {
    color: #006666;
    margin-bottom: 20px;
}

.post-detail img {
    width: 100%;
    max-width: 600px;
    margin-bottom: 20px;
    border-radius: 5px;
    transition: transform 0.3s ease;
}

.post-detail img:hover {
    transform: scale(1.05);
}

.alert-danger {
    background-color: #CC3300;
    color: #fff;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 20px;
}

/* Đường kẻ ngang */
hr {
    border: 1px solid #006666;
    margin: 20px 0;
}

/* Liên kết */
a {
    color: #006666;
    text-decoration: none;
    transition: color 0.3s ease;
}

a:hover {
    color: #CC3300;
}
/* Nút "Xem thêm" */
.btn-primary {
    background-color: #006666;
    border: none;
    color: #fff;
    padding: 10px 15px;
    border-radius: 5px;
    text-transform: uppercase;
    transition: background-color 0.3s ease, color 0.3s ease, transform 0.3s ease;
}

.btn-primary:hover {
    background-color: #CC3300; /* Chuyển sang màu đỏ cam khi hover */
    color: #fff; /* Đảm bảo chữ trắng vẫn rõ ràng */
    transform: scale(1.05); /* Hiệu ứng phóng to nhẹ */
}

</style>
<div class="container">
    <!-- Tiêu đề của Blog -->
    <h1 style="text-align: center; margin-bottom: 20px;">
        <?php echo htmlspecialchars($blog_title, ENT_QUOTES, 'UTF-8'); ?>
    </h1>

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
                                    $short_content = mb_strimwidth(strip_tags($post['post_content']), 0, 200, "...");
                                    $post_photo = !empty($post['photo']) ? $post['photo'] : 'default.jpg';
                                    ?>
                                    <div class="post-item">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <img src="assets/uploads/<?php echo htmlspecialchars($post_photo, ENT_QUOTES, 'UTF-8'); ?>" 
                                                     class="img-fluid" 
                                                     alt="<?php echo htmlspecialchars($post['post_title'], ENT_QUOTES, 'UTF-8'); ?>">
                                            </div>
                                            <div class="col-md-8">
                                                <h2><?php echo htmlspecialchars($post['post_title'], ENT_QUOTES, 'UTF-8'); ?></h2>
                                                <p><?php echo htmlspecialchars($short_content, ENT_QUOTES, 'UTF-8'); ?></p>
                                                <a href="blog.php?post_slug=<?php echo urlencode($post['post_slug']); ?>" 
                                                   class="btn btn-primary">Xem thêm</a>
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
                                $post_photo = !empty($post['photo']) ? $post['photo'] : 'default.jpg';
                                ?>
                                <div class="post-detail">
                                    <h1><?php echo htmlspecialchars($post['post_title'], ENT_QUOTES, 'UTF-8'); ?></h1>
                                    <img src="assets/uploads/<?php echo htmlspecialchars($post_photo, ENT_QUOTES, 'UTF-8'); ?>" 
                                         class="img-fluid" 
                                         alt="<?php echo htmlspecialchars($post['post_title'], ENT_QUOTES, 'UTF-8'); ?>">
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

<?php
// Kết nối file footer.php
require_once('footer.php');
?>

</body>
</html>
