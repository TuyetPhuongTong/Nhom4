<?php require_once('header.php'); ?>

<?php
// Kết nối tới cơ sở dữ liệu và lấy dữ liệu từ bảng tbl_post
$statement = $pdo->prepare("SELECT post_id, post_title, post_slug, post_content, post_date, photo, category_id, total_view, meta_title FROM tbl_post ORDER BY post_date DESC");
$statement->execute();
$posts = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="page">
    <div class="container">
        <div class="row">
            <?php if (count($posts) > 0): ?>
                <?php foreach ($posts as $post): ?>
                    <div class="col-md-4 mb-4">
                        <!-- Hiển thị hình ảnh bài viết -->
                        <div class="post-thumbnail">
                            <img src="assets/uploads/<?php echo htmlspecialchars($post['photo']); ?>" alt="<?php echo htmlspecialchars($post['post_title']); ?>" class="img-responsive img-thumbnail">
                        </div>
                        
                        <!-- Tiêu đề và nội dung ngắn -->
                        <div class="post-content mt-3">
                            <h3 class="post-title">
                                <?php echo htmlspecialchars($post['post_title']); ?>
                            </h3>
                            <p class="post-excerpt">
                                <?php echo mb_substr(strip_tags($post['post_content']), 0, 120, 'UTF-8'); ?>...
                            </p>
                            
                            <!-- Nút Xem Thêm -->
                            <a href="post.php?slug=<?php echo urlencode($post['post_slug']); ?>" class="btn btn-primary">Xem Thêm</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">Không có bài viết nào để hiển thị.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>
