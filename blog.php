<?php
require_once('header.php'); // Gọi tệp header hoặc các tệp cấu hình cần thiết
?>

<h1>Blog</h1>

<?php
// Truy vấn dữ liệu bài viết từ cơ sở dữ liệu
$statement = $pdo->prepare("SELECT * FROM tbl_posts ORDER BY created_at DESC");
$statement->execute();
$posts = $statement->fetchAll(PDO::FETCH_ASSOC);

// Hiển thị bài viết
if ($posts) {
    foreach ($posts as $post) {
        echo '<div class="blog-post">';
        echo '<h2>' . htmlspecialchars($post['title']) . '</h2>';
        echo '<p>' . nl2br(htmlspecialchars($post['content'])) . '</p>';
        echo '<p><small>Ngày đăng: ' . $post['created_at'] . '</small></p>';
        echo '</div>';
        echo '<hr>';
    }
} else {
    echo '<p>Hiện chưa có bài viết nào.</p>';
}
foreach ($posts as $post) {
    echo '<div class="blog-post">';
    echo '<h2>' . htmlspecialchars($post['title']) . '</h2>';
    echo '<p>' . nl2br(htmlspecialchars(substr($post['content'], 0, 200))) . '...</p>'; // Hiển thị 200 ký tự đầu tiên
    echo '<a href="blog-detail.php?id=' . $post['id'] . '">Đọc thêm</a>'; // Liên kết tới chi tiết bài viết
    echo '<p><small>Ngày đăng: ' . $post['created_at'] . '</small></p>';
    echo '</div>';
    echo '<hr>';
}
?>

<?php require_once('footer.php'); ?>
