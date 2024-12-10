<?php require_once('header.php'); ?>

<?php
// Kết nối tới cơ sở dữ liệu và lấy dữ liệu từ bảng tbl_post
$statement = $pdo->prepare("SELECT post_id, post_title, post_slug, post_content, post_date, photo FROM tbl_post ORDER BY post_date DESC");
$statement->execute();
$posts = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h1 style="text-align: center; margin-bottom: 20px;">Bài viết nổi bật</h1>
    <div class="posts-container">
        <?php if (count($posts) > 0): ?>
            <?php foreach ($posts as $post): ?>
                <div class="post-card">
                    <div class="post-thumbnail">
                        <img src="assets/uploads/<?php echo htmlspecialchars($post['photo']); ?>" alt="<?php echo htmlspecialchars($post['post_title']); ?>">
                    </div>
                    <div class="post-content">
                        <h3 class="post-title"><?php echo htmlspecialchars($post['post_title']); ?></h3>
                        <p><?php echo mb_substr(strip_tags($post['post_content']), 0, 100, 'UTF-8'); ?>...</p>
                    </div>
                    <a href="post.php?slug=<?php echo urlencode($post['post_slug']); ?>" class="btn">Xem Thêm</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">Không có bài viết nào để hiển thị.</p>
        <?php endif; ?>
    </div>
</div>

<?php require_once('footer.php'); ?>
