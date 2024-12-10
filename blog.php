<?php
require_once('header.php');

// Kiểm tra slug có trong URL hay không
if (isset($_GET['slug'])) {
    $slug = $_GET['slug'];

    // Kết nối database và tìm bài viết theo slug
    $statement = $pdo->prepare("SELECT * FROM tbl_post WHERE post_slug = ?");
    $statement->execute([$slug]);
    $post = $statement->fetch(PDO::FETCH_ASSOC);

    if ($post) {
        // Hiển thị bài viết
        ?>
        <div class="container">
            <h1><?php echo htmlspecialchars($post['post_title']); ?></h1>
            <p><?php echo nl2br(htmlspecialchars($post['post_content'])); ?></p>
        </div>
        <?php
    } else {
        echo "<p>Bài viết không tồn tại.</p>";
    }
} else {
    echo "<p>Không có thông tin bài viết.</p>";
}

require_once('footer.php');
?>
