<?php require_once('header.php'); ?>
<!-- Lấy Dữ Liệu Banner Đăng Nhập -->
<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $banner_login = $row['banner_login'];
}
?>
<!-- Form Đăng Nhập -->
<?php
if(isset($_POST['form1'])) {
        
    if(empty($_POST['cust_email']) || empty($_POST['cust_password'])) {
        $error_message = "Email hoặc Mật khẩu không được để trống".'<br>';
    } else {
        
        $cust_email = strip_tags($_POST['cust_email']);
        $cust_password = strip_tags($_POST['cust_password']);

        $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_email=?");
        $statement->execute(array($cust_email));
        $total = $statement->rowCount();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $row) {
            $cust_status = $row['cust_status'];
            $row_password = $row['cust_password'];
        }

        if($total == 0) {
            $error_message .= "Địa chỉ email không đúng".'<br>';
        } else {
            // Sử Dụng Mã Hóa MD5
            if($row_password != md5($cust_password)) {
                $error_message .= "Mật khẩu không đúng".'<br>';
            } else {
                if($cust_status == 0) {
                    $error_message .= "Xin lỗi! Tài khoản của bạn không hoạt động. Vui lòng liên hệ với quản trị viên".'<br>';
                } else {
                    $_SESSION['customer'] = $row;
                    header("location: ".BASE_URL."dashboard.php");
                }
            }
            
        }
    }
}
?>
<style>
    /* Phong cách nền và tiêu đề */
.page-banner {
    background-color: #006666; /* Màu xanh lam đậm */
    color: #fff;
    text-align: center;
    padding: 60px 0;
}

.page-banner h1 {
    font-size: 36px;
    margin: 0;
}

/* Phong cách container đăng nhập */
.user-content {
    background-color: #f9f9f9;
    border: 1px solid #e0e0e0;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* Phong cách các input */
.form-group label {
    font-size: 14px;
    font-weight: bold;
    color: #333;
}

.form-control {
    border: 1px solid #ccc;
    padding: 10px;
    border-radius: 5px;
    font-size: 14px;
    width: 100%;
    margin-bottom: 10px;
    transition: border-color 0.3s ease;
}

.form-control:focus {
    border-color: #006666; /* Màu xanh lam đậm khi focus */
    box-shadow: 0 0 5px rgba(0, 102, 102, 0.4);
}

/* Phong cách nút đăng nhập */
.btn-success {
    background-color: #006666;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.btn-success:hover {
    background-color: #CC3300; /* Màu đỏ cam khi hover */
    transform: scale(1.05); /* Phóng to nhẹ khi hover */
}

/* Liên kết Quên mật khẩu */
a {
    text-decoration: none;
    color: #CC3300;
    font-size: 14px;
    transition: color 0.3s ease;
}

a:hover {
    color: #006666; /* Đổi màu khi hover */
}

/* Phong cách thông báo lỗi */
.error {
    background-color: #f8d7da;
    color: #842029;
    border: 1px solid #f5c2c7;
    border-radius: 5px;
}

.success {
    background-color: #d1e7dd;
    color: #0f5132;
    border: 1px solid #badbcc;
    border-radius: 5px;
}

</style>
<div class="page-banner" style="background-color:#444;background-image: url(https://i.pinimg.com/736x/82/cd/4a/82cd4a8c262b9c774f0638d7fd88997a.jpg);">
    <div class="inner">
        <h1><?php echo "Trang Đăng Nhập"; ?></h1>
    </div>
</div>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="user-content">

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
                                    <label for=""><?php echo "Email Của Bạn"; ?> *</label>
                                    <input type="email" class="form-control" name="cust_email">
                                </div>
                                <div class="form-group">
                                    <label for=""><?php echo "Mật Khẩu Của Bạn"; ?> *</label>
                                    <input type="password" class="form-control" name="cust_password">
                                </div>
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="submit" class="btn btn-success" value="<?php echo "Đăng Nhập"; ?>" name="form1">
                                </div>
                                <a href="forget-password.php" style="color:#e4144d;"><?php echo "Quên Mật Khẩu?"; ?></a>
                            </div>
                        </div>                        
                    </form>
                </div>                
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>
