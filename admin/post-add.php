mới có ảnh
<?php require_once('header.php'); ?>

<?php
if (isset($_POST['form1'])) {
    $valid = 1;
    $error_message = '';

    // Kiểm tra tiêu đề
    if (empty($_POST['post_title'])) {
        $valid = 0;
        $error_message .= 'Tiêu đề không được để trống.<br>';
    }

    // Kiểm tra nội dung
    if (empty($_POST['post_content'])) {
        $valid = 0;
        $error_message .= 'Nội dung không được để trống.<br>';
    }

    // Kiểm tra hình ảnh
    $photo = '';
    if ($_FILES['photo']['name'] != '') {
        $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $allowed_extensions = ['jpg', 'png', 'jpeg', 'gif'];
        if (!in_array(strtolower($ext), $allowed_extensions)) {
            $valid = 0;
            $error_message .= 'Chỉ được phép tải lên tệp ảnh định dạng jpg, png, jpeg, hoặc gif.<br>';
        } else {
            $photo = 'post-' . time() . '.' . $ext;
            $upload_path = 'uploads/' . $photo;
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $upload_path)) {
                // Thành công
            } else {
                $valid = 0;
                $error_message .= 'Không thể tải ảnh lên. Vui lòng thử lại.<br>';
            }
        }
    }

    if ($valid == 1) {
        $statement = $pdo->prepare("
            INSERT INTO tbl_post 
            (post_title, post_slug, post_content, post_date, photo, total_view) 
            VALUES (?, ?, ?, NOW(), ?, ?)
        ");
        $statement->execute(array(
            $_POST['post_title'],
            $_POST['post_slug'],
            $_POST['post_content'],
            $photo,
            0
        ));

        $success_message = 'Bài viết đã được thêm thành công!';
        unset($_POST['post_title'], $_POST['post_slug'], $_POST['post_content']);
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Thêm Bài Viết</h1>
    </div>
    <div class="content-header-right">
        <a href="post.php" class="btn btn-primary btn-sm">Xem Tất Cả</a>
    </div>
</section>

<section class="content">

    <div class="row">
        <div class="col-md-12">

            <?php if ($error_message): ?>
            <div class="callout callout-danger">
                <p><?php echo $error_message; ?></p>
            </div>
            <?php endif; ?>

            <?php if ($success_message): ?>
            <div class="callout callout-success">
                <p><?php echo $success_message; ?></p>
            </div>
            <?php endif; ?>

            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="box box-info">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Tiêu đề <span>*</span></label>
                            <div class="col-sm-6">
                                <input type="text" autocomplete="off" class="form-control" name="post_title" value="<?php if (isset($_POST['post_title'])) echo $_POST['post_title']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Slug</label>
                            <div class="col-sm-6">
                                <input type="text" autocomplete="off" class="form-control" name="post_slug" value="<?php if (isset($_POST['post_slug'])) echo $_POST['post_slug']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Nội dung <span>*</span></label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="post_content" id="editor1" style="height:200px;"><?php if (isset($_POST['post_content'])) echo $_POST['post_content']; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Ảnh</label>
                            <div class="col-sm-6">
                                <input type="file" class="form-control" name="photo">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label"></label>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success pull-left" name="form1">Gửi</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</section>

<?php require_once('footer.php'); ?>
