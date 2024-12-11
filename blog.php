<?php
// Kết nối file header.php
require_once('header.php');

// Kết nối đến cơ sở dữ liệu
$pdo = new PDO('mysql:host=localhost;dbname=your_database', 'username', 'password');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
    <style>
        .img-fluid {
            max-width: 100%;
            height: auto;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .post-item img {
            width: 100%;
            object-fit: cover;
        }

        .post-detail img {
            width: 100%;
            object-fit: cover;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

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
                                    <p><?php echo htmlspecialchars($post['post_content'], ENT_QUOTES, 'UTF-8'); ?></p>
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
