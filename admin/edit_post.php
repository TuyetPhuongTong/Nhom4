<?php
require_once('header.php');

if (isset($_GET['id'])) {
    $statement = $pdo->prepare("SELECT * FROM tbl_posts WHERE id=?");
    $statement->execute([$_GET['id']]);
    $post = $statement->fetch(PDO::FETCH_ASSOC);
}

if (isset($_POST['form_edit_post'])) {
    $valid = 1;

    if (empty($_POST['post_title'])) {
        $valid = 0;
        $error_message .= 'Tiêu đề không được để trống.<br>';
    }

    if (empty($_POST['post_content'])) {
        $valid = 0;
        $error_message .= 'Nội dung không được để trống.<br>';
    }

    if ($valid == 1) {
        $statement = $pdo->prepare("UPDATE tbl_posts SET title=?, content=? WHERE id=?");
        $statement->execute([$_POST['post_title'], $_POST['post_content'], $_GET['id']]);
        $success_message = 'Bài viết đã được cập nhật thành công!';
    }
}
?>
<form method="post">
    <h1>Chỉnh sửa bài viết</h1>
    <?php if ($error_message): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <?php if ($success_message): ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php endif; ?>
    <label>Tiêu đề</label>
    <input type="text" name="post_title" value="<?php echo $post['title']; ?>" class="form-control">
    <label>Nội dung</label>
    <textarea name="post_content" class="form-control"><?php echo $post['content']; ?></textarea>
    <button type="submit" name="form_edit_post" class="btn btn-primary">Cập nhật bài viết</button>
</form>
