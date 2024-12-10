<?php
require_once('header.php'); // Gọi tệp header hoặc các tệp cấu hình cần thiết

// Kiểm tra ID bài viết
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo '<p>Bài viết không tồn tại.</p>';
    require_once('footer.php');
    exit;
}

// Truy vấn bài viết từ cơ sở dữ liệu
$statement = $pdo->prepare("SELECT * FROM tbl_posts WHERE id = ?");
$statement->execute([$_GET['id']]);
$post = $statement->fetch(PDO::FETCH_ASSOC);

// Hiển thị nội dung bài viết
if ($post) {
    echo '<div class="blog-detail">';
    echo '<h1>' . htmlspecialchars($post['title']) . '</h1>';
    echo '<p>' . nl2br(htmlspecialchars($post['content'])) . '</p>';
    echo '<p><small>Ngày đăng: ' . $post['created_at'] . '</small></p>';
    echo '</div>';
} else {
    echo '<p>Bài viết không tồn tại.</p>';
}

require_once('footer.php');
?>
