<?php
require_once('header.php');
////he
if (isset($_POST['form_add_post'])) {
    $valid = 1;

    if (empty($_POST['post_title'])) {
        $valid = 0;
        $error_message .= 'Tiêu đề bài viết không được để trống.<br>';
    }

    if (empty($_POST['post_content'])) {
        $valid = 0;
        $error_message .= 'Nội dung bài viết không được để trống.<br>';
    }

    if ($valid == 1) {
        $statement = $pdo->prepare("INSERT INTO tbl_posts (title, content, created_at) VALUES (?, ?, NOW())");
        $statement->execute([$_POST['post_title'], $_POST['post_content']]);
        $success_message = 'Bài viết đã được thêm thành công!';
    }
}
?>
<form method="post">
    <h1>Thêm bài viết</h1>
    <?php if ($error_message): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <?php if ($success_message): ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php endif; ?>
    <label>Tiêu đề</label>
    <input type="text" name="post_title" class="form-control">
    <label>Nội dung</label>
    <textarea name="post_content" class="form-control"></textarea>
    <button type="submit" name="form_add_post" class="btn btn-primary">Thêm bài viết</button>
</form>
