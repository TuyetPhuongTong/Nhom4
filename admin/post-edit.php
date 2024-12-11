<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
    $valid = 1;
    $error_message = ''; // Khởi tạo biến lỗi

    // Kiểm tra tiêu đề
    if(empty($_POST['post_title'])) {
        $valid = 0;
        $error_message .= 'Tiêu đề không được để trống<br>';
    }

    // Kiểm tra nội dung
    if(empty($_POST['post_content'])) {
        $valid = 0;
        $error_message .= 'Nội dung không được để trống<br>';
    }

    if($valid == 1) {
        // Nếu có ảnh mới được upload
        if(!empty($_FILES['photo']['name'])) {
            $path = $_FILES['photo']['name'];
            $path_tmp = $_FILES['photo']['tmp_name'];

            // Lấy phần mở rộng của file
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');

            // Kiểm tra định dạng ảnh
            if(!in_array($ext, $allowed_ext)) {
                $valid = 0;
                $error_message .= 'Bạn chỉ được upload file ảnh có định dạng jpg, jpeg, png hoặc gif<br>';
            } else {
                // Xóa ảnh cũ
                $statement = $pdo->prepare("SELECT photo FROM tbl_post WHERE post_id=?");
                $statement->execute(array($_REQUEST['id']));
                $result = $statement->fetch(PDO::FETCH_ASSOC);

                if($result['photo'] != '') {
                    unlink('assets/uploads/'.$result['photo']);
                }

                // Upload ảnh mới
                $final_name = 'post-'.time().'.'.$ext;
                if (move_uploaded_file($path_tmp, 'assets/uploads/'.$final_name)) {
                    // Cập nhật bài viết với ảnh mới
                    $statement = $pdo->prepare("UPDATE tbl_post SET post_title=?, post_content=?, photo=? WHERE post_id=?");
                    $statement->execute(array($_POST['post_title'], $_POST['post_content'], $final_name, $_REQUEST['id']));
                } else {
                    $valid = 0;
                    $error_message .= 'Lỗi khi tải ảnh lên.<br>';
                }
            }
        } else {
            // Nếu không có ảnh mới, chỉ cập nhật tiêu đề và nội dung
            $statement = $pdo->prepare("UPDATE tbl_post SET post_title=?, post_content=? WHERE post_id=?");
            $statement->execute(array($_POST['post_title'], $_POST['post_content'], $_REQUEST['id']));
        }
        
        // Nếu không có lỗi, thông báo thành công
        if ($valid == 1) {
            $success_message = 'Bài viết đã được cập nhật thành công!';
        }
    }
}
?>

<?php
if(!isset($_REQUEST['id'])) {
    header('location: logout.php');
    exit;
} else {
    $statement = $pdo->prepare("SELECT * FROM tbl_post WHERE post_id=?");
    $statement->execute(array($_REQUEST['id']));
    $total = $statement->rowCount();
    if($total == 0) {
        header('location: logout.php');
        exit;
    }
}

$statement = $pdo->prepare("SELECT * FROM tbl_post WHERE post_id=?");
$statement->execute(array($_REQUEST['id']));
$row = $statement->fetch(PDO::FETCH_ASSOC);
$post_title = $row['post_title'];
$post_content = $row['post_content'];
$photo = $row['photo'];
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Chỉnh sửa Bài Viết</h1>
    </div>
    <div class="content-header-right">
        <a href="post.php" class="btn btn-primary btn-sm">Xem tất cả</a>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">

            <?php if($error_message): ?>
            <div class="callout callout-danger">
                <p><?php echo $error_message; ?></p>
            </div>
            <?php endif; ?>

            <?php if($success_message): ?>
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
                                <input type="text" class="form-control" name="post_title" value="<?php echo htmlspecialchars($post_title); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Ảnh</label>
                            <div class="col-sm-6">
                                <input type="file" class="form-control" name="photo">
                                <?php if($photo): ?>
                                <img src="assets/uploads/<?php echo $photo; ?>" alt="Ảnh bài viết" style="width:200px; margin-top:10px;">
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Nội dung <span>*</span></label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="post_content" id="editor1" style="height:140px;"><?php echo htmlspecialchars($post_content); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label"></label>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success pull-left" name="form1">Cập nhật</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
