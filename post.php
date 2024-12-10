<?php require_once('header.php'); ?>

<?php
// Lấy ID bài viết từ URL
$post_id = $_GET['id'];

// Truy vấn lấy thông tin bài viết từ bảng tbl_post theo ID
$statement = $pdo->prepare("SELECT * FROM tbl_post WHERE post_id = ?");
$statement->execute([$post_id]);
$post = $statement->fetch(PDO::FETCH_ASSOC);

if ($post) {
    $post_title = $post['post_title'];
    $post_content = $post['post_content'];
    $post_date = $post['post_date'];
} else {
    echo "Bài viết không tồn tại.";
    exit;
}
?>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1><?php echo $post_title; ?></h1>
                <p class="post-date"><?php echo date('F j, Y', strtotime($post_date)); ?></p>
                <div class="post-content">
                    <p><?php echo nl2br($post_content); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>
