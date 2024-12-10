<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
    $valid = 1;

    if(empty($_POST['post_title'])) {
        $valid = 0;
        $error_message .= 'Tiêu đề không được để trống<br>';
    }

    if(empty($_POST['post_content'])) {
        $valid = 0;
        $error_message .= 'Nội dung không được để trống<br>';
    }

    if($valid == 1) {
    
        // Thực hiện câu lệnh INSERT vào bảng tbl_posts
        $statement = $pdo->prepare("INSERT INTO tbl_posts (post_title, post_content) VALUES (?, ?)");
        $statement->execute(array($_POST['post_title'], $_POST['post_content']));
        
        // Thông báo thành công
        $success_message = 'Bài viết đã được thêm thành công!';
        
        // Xóa dữ liệu trong form sau khi thêm bài viết thành công
        unset($_POST['post_title']);
        unset($_POST['post_content']);
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Thêm Bài Viết</h1>
    </div>
    <div class="content-header-right">
        <a href="posts.php" class="btn btn-primary btn-sm">Xem Tất Cả Bài Viết</a>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">

            <?php if($error_message): ?>
            <div class="callout callout-danger">
                <p>
                    <?php echo $error_message; ?>
                </p>
            </div>
            <?php endif; ?>

            <?php if($success_message): ?>
            <div class="callout callout-success">
                <p><?php echo $success_message; ?></p>
            </div>
            <?php endif; ?>

            <form class="form-horizontal" action="" method="post">
                <div class="box box-info">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Tiêu đề <span>*</span></label>
                            <div class="col-sm-6">
                                <input type="text" autocomplete="off" class="form-control" name="post_title" value="<?php if(isset($_POST['post_title'])){echo $_POST['post_title'];} ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Nội dung <span>*</span></label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="post_content" id="editor1" style="height:200px;"><?php if(isset($_POST['post_content'])){echo $_POST['post_content'];} ?></textarea>
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
