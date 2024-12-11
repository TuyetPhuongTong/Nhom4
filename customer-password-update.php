<?php require_once('header.php'); ?>

<?php
// Kiểm tra khách hàng đã đăng nhập chưa
if(!isset($_SESSION['customer'])) {
    header('location: '.BASE_URL.'logout.php');
    exit;
} else {
    // Nếu khách hàng đã đăng nhập nhưng quản trị viên không hoạt động thì buộc người dùng này đăng xuất.
    $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=? AND cust_status=?");
    $statement->execute(array($_SESSION['customer']['cust_id'],0));
    $total = $statement->rowCount();
    if($total) {
        header('location: '.BASE_URL.'logout.php');
        exit;
    }
}
?>
<style>
    /* Kiểu dáng chung cho khung chứa biểu mẫu */
.user-content {
    background-color: #f9f9f9; /* Màu nền nhạt */
    border: 1px solid #006666; /* Đường viền màu xanh lam đậm */
    padding: 20px; /* Khoảng cách bên trong */
    border-radius: 8px; /* Bo góc */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Đổ bóng nhẹ */
}

/* Tiêu đề */
.user-content h3 {
    color: #006666; /* Màu xanh lam đậm */
    text-align: center; /* Căn giữa */
    margin-bottom: 20px; /* Khoảng cách bên dưới */
    font-weight: bold; /* Chữ đậm */
}

/* Ô nhập liệu */
.user-content .form-control {
    border: 1px solid #006666; /* Đường viền màu xanh lam đậm */
    border-radius: 4px; /* Bo góc nhẹ */
    padding: 10px; /* Khoảng cách bên trong */
    font-size: 14px; /* Kích thước chữ */
}

.user-content .form-control:focus {
    border-color: #CC3333; /* Đổi màu viền sang đỏ khi được chọn */
    box-shadow: 0 0 5px rgba(204, 51, 51, 0.5); /* Đổ bóng đỏ nhẹ */
    outline: none; /* Xóa đường viền mặc định của trình duyệt */
}

/* Nhãn (label) */
.user-content label {
    font-weight: bold; /* Chữ đậm */
    color: #006666; /* Màu xanh lam đậm */
    margin-bottom: 8px; /* Khoảng cách bên dưới nhãn */
    display: block; /* Hiển thị dạng khối để nằm trên ô nhập */
}

/* Nút gửi */
.user-content .btn-primary {
    background-color: #006666; /* Màu nền đỏ */
    border: none; /* Xóa đường viền mặc định */
    color: #FFFFFF; /* Màu chữ trắng */
    padding: 10px 20px; /* Khoảng cách bên trong nút */
    font-size: 16px; /* Kích thước chữ */
    font-weight: bold; /* Chữ đậm */
    border-radius: 4px; /* Bo góc nhẹ */
    transition: background-color 0.3s; /* Hiệu ứng chuyển đổi màu nền */
}

.user-content .btn-primary:hover {
    background-color: #CC3300; /* Đổi màu nền sang đỏ đậm khi di chuột qua */
    color: #FFFFFF; /* Giữ màu chữ trắng */
}

/* Thông báo lỗi và thành công */
.error {
    color: #CC3333; /* Màu chữ đỏ */
    border: 1px solid #CC3333; /* Đường viền đỏ */
    background-color: #FFE6E6; /* Nền đỏ nhạt */
    border-radius: 4px; /* Bo góc nhẹ */
    padding: 10px; /* Khoảng cách bên trong */
    margin-bottom: 15px; /* Khoảng cách bên dưới */
}

.success {
    color: #006666; /* Màu chữ xanh lam đậm */
    border: 1px solid #006666; /* Đường viền xanh lam đậm */
    background-color: #E6F9F9; /* Nền xanh lam nhạt */
    border-radius: 4px; /* Bo góc nhẹ */
    padding: 10px; /* Khoảng cách bên trong */
    margin-bottom: 15px; /* Khoảng cách bên dưới */
}

</style>
<?php
if (isset($_POST['form1'])) {

    $valid = 1;

    if( empty($_POST['cust_password']) || empty($_POST['cust_re_password']) ) {
        $valid = 0;
        $error_message .= "Mật khẩu không được để trống"."<br>";
    }

    if( !empty($_POST['cust_password']) && !empty($_POST['cust_re_password']) ) {
        if($_POST['cust_password'] != $_POST['cust_re_password']) {
            $valid = 0;
            $error_message .= "Mật khẩu không đúng"."<br>";
        }
    }
    
    if($valid == 1) {

        // cập nhật dữ liệu vào db

        $password = strip_tags($_POST['cust_password']);
        
        $statement = $pdo->prepare("UPDATE tbl_customer SET cust_password=? WHERE cust_id=?");
        $statement->execute(array(md5($password),$_SESSION['customer']['cust_id']));
        
        $_SESSION['customer']['cust_password'] = md5($password);        

        $success_message = "Mật khẩu đã được cập nhật thành công";
    }
}
?>

<div class="page">
    <div class="container">
        <div class="row">            
            <div class="col-md-12"> 
                <?php require_once('customer-sidebar.php'); ?>
            </div>
            <div class="col-md-12">
                <div class="user-content">
                    <h3 class="text-center">
                        <?php echo "Cập nhật mật khẩu"; ?>
                    </h3>
                    <form action="" method="post">
                        <?php $csrf->echoInputField(); ?>
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <?php
                                if($error_message != '') {
                                    echo "<div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$error_message."</div>";
                                }
                                if($success_message != '') {
                                    echo "<div class='success' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$success_message."</div>";
                                }
                                ?>
                                <div class="form-group">
                                    <label for=""><?php echo "Mật khẩu mới"; ?> *</label>
                                    <input type="password" class="form-control" name="cust_password">
                                </div>
                                <div class="form-group">
                                    <label for=""><?php echo "Nhập lại mật khẩu"; ?> *</label>
                                    <input type="password" class="form-control" name="cust_re_password">
                                </div>
                                <input type="submit" class="btn btn-primary" value="<?php echo "Cập nhật"; ?>" name="form1">
                            </div>
                        </div>
                        
                    </form>
                </div>                
            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php'); ?>