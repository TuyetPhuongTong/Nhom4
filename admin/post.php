<?php require_once('header.php'); ?>

<?php
$error_message = '';
$success_message = '';

if (isset($_POST['form_add_post'])) {
    $valid = 1;

    // Kiểm tra tiêu đề bài viết
    if (empty($_POST['post_title'])) {
        $valid = 0;
        $error_message .= 'Tiêu đề không được để trống<br>';
    }

    // Kiểm tra nội dung bài viết
    if (empty($_POST['post_content'])) {
        $valid = 0;
        $error_message .= 'Nội dung không được để trống<br>';
    }

    // Kiểm tra file upload
    $path = $_FILES['post_banner']['name'];
    $path_tmp = $_FILES['post_banner']['tmp_name'];

    if ($path != '') {
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'png', 'jpeg', 'gif'];
        if (!in_array($ext, $allowed_extensions)) {
            $valid = 0;
            $error_message .= 'Bạn phải tải lên tệp jpg, jpeg, gif hoặc png<br>';
        }
    }

    if ($valid == 1) {
        $final_name = '';

        if ($path != '') {
            // Xóa ảnh hiện tại
            $statement = $pdo->prepare("SELECT photo FROM tbl_post WHERE id=1");
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            if (!empty($result['photo']) && file_exists('../assets/uploads/' . $result['photo'])) {
                unlink('../assets/uploads/' . $result['photo']);
            }

            // Lưu ảnh mới
            $final_name = 'banner-' . time() . '.' . $ext;
            move_uploaded_file($path_tmp, '../assets/uploads/' . $final_name);
        }

        // Cập nhật cơ sở dữ liệu
         $statement = $pdo->prepare("UPDATE tbl_post SET post_id=?, post_title=?,post_lug=?,post_content=?,post_day=?,photo=?,category_id=?,total_view=?,meta_title=? WHERE post_id=1");
         $statement->execute(array($_POST['post_id'],$_POST['post_title'],$_POST['post_content'],$final_name,$_POST['photo'],$_POST['post_day'],$_POST['category_id'],$_POST['total_view'],$_POST['meta_title']));
     } else {
//CẬP NHẬT DỮ LIỆU
          $statement = $pdo->prepare("UPDATE tbl_post SET post_id=?, post_title=?,post_lug=?,post_content=?,post_day=?,photo=?,category_id=?,total_view=?,meta_title=? WHERE post_id=1");
          $statement->execute(array($_POST['post_id'],$_POST['post_title'],$_POST['post_content'],$_POST['photo'],$_POST['post_day'],$_POST['category_id'],$_POST['total_view'],$_POST['meta_title']));


     }

        $success_message = 'Thông tin bài viết đã được cập nhật thành công.';
    }
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Quản lý bài viết</h1>
    </div>
</section>

<?php
// Lấy dữ liệu bài viết
$statement = $pdo->prepare("SELECT * FROM tbl_post WHERE post_id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);  

$post_title = $result['post_title'] ?? '';
$post_slug = $result['post_slug'] ?? '';
$post_content = $result['post_content'] ?? '';
$post_date = $result['post_date'] ?? '';
$photo = $result['photo'] ?? '';
$category_id = $result['category_id'] ?? '';
$total_view = $result['total_view'] ?? '';
$meta_title = $result['meta_title'] ?? '';
?>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger">
                <p><?php echo $error_message; ?></p>
            </div>
            <?php endif; ?>

            <?php if (!empty($success_message)): ?>
            <div class="alert alert-success">
                <p><?php echo $success_message; ?></p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
        <div class="box box-info">
            <div class="box-body">
                <div class="form-group">
                    <label class="col-sm-3 control-label">Tiêu Đề Bài Viết *</label>
                    <div class="col-sm-5">
                        <input class="form-control" type="text" name="post_title" value="<?php echo htmlspecialchars($post_title); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Slug *</label>
                    <div class="col-sm-5">
                        <input class="form-control" type="text" name="post_slug" value="<?php echo htmlspecialchars($post_slug); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Nội Dung Bài Viết *</label>
                    <div class="col-sm-8">
                        <textarea class="form-control" name="post_content" rows="5"><?php echo htmlspecialchars($post_content); ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Ảnh Banner Hiện Tại</label>
                    <div class="col-sm-6">
                        <?php if ($photo): ?>
                        <img src="../assets/uploads/<?php echo $photo; ?>" alt="" style="height:80px;">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Ảnh Banner Mới</label>
                    <div class="col-sm-6">
                        <input type="file" name="post_banner">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Ngày Đăng *</label>
                    <div class="col-sm-5">
                        <input class="form-control" type="date" name="post_date" value="<?php echo $post_date; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Thể Loại *</label>
                    <div class="col-sm-5">
                        <input class="form-control" type="number" name="category_id" value="<?php echo $category_id; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Lượt Xem *</label>
                    <div class="col-sm-5">
                        <input class="form-control" type="number" name="total_view" value="<?php echo $total_view; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Tiêu Đề Meta *</label>
                    <div class="col-sm-8">
                        <input class="form-control" type="text" name="meta_title" value="<?php echo htmlspecialchars($meta_title); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"></label>
                    <div class="col-sm-6">
                        <button type="submit" class="btn btn-success" name="form_add_post">Cập Nhật</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>

<?php require_once('footer.php'); ?>
