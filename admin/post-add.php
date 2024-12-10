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
        // Kiểm tra lỗi tải ảnh
        if ($_FILES['photo']['error'] != UPLOAD_ERR_OK) {
            $valid = 0;
            $error_message .= 'Lỗi tải ảnh: ' . $_FILES['photo']['error'] . '<br>';
        } else {
            // Kiểm tra định dạng ảnh
            $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $allowed_extensions = ['jpg', 'png', 'jpeg', 'gif'];
            if (!in_array(strtolower($ext), $allowed_extensions)) {
                $valid = 0;
                $error_message .= 'Chỉ được phép tải lên tệp ảnh định dạng jpg, png, jpeg, hoặc gif.<br>';
            } else {
                $photo = 'post-' . time() . '.' . $ext;
                $upload_path = 'uploads/' . $photo;

                // Kiểm tra nếu thư mục uploads không tồn tại thì tạo
                if (!file_exists('uploads/')) {
                    mkdir('uploads/', 0777, true);
                }

                // Di chuyển ảnh
                if (move_uploaded_file($_FILES['photo']['tmp_name'], $upload_path)) {
                    // Thành công
                } else {
                    $valid = 0;
                    $error_message .= 'Không thể tải ảnh lên. Vui lòng thử lại.<br>';
                }
            }
        }
    }

    if ($valid == 1) {
        // Cập nhật bài viết vào cơ sở dữ liệu
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
            0 // Total view mặc định là 0
        ));

        $success_message = 'Bài viết đã được thêm thành công!';
        unset($_POST['post_title'], $_POST['post_slug'], $_POST['post_content']);
    }
}
?>
