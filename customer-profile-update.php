<?php require_once('header.php'); ?>

<?php
// Kiểm tra khách hàng đăng nhập chưa
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

<?php
if (isset($_POST['form1'])) {

    $valid = 1;

    if(empty($_POST['cust_name'])) {
        $valid = 0;
        $error_message .= "Tên khách hàng không được để trống"."<br>";
    }

    if(empty($_POST['cust_phone'])) {
        $valid = 0;
        $error_message .= "Số điện thoại không được để trống"."<br>";
    }

    if(empty($_POST['cust_address'])) {
        $valid = 0;
        $error_message .= "Địa chỉ không được để trống"."<br>";
    }

    if(empty($_POST['cust_country'])) {
        $valid = 0;
        $error_message .= "Bạn phải chọn một quốc gia"."<br>";
    }

    if(empty($_POST['cust_city'])) {
        $valid = 0;
        $error_message .= "Thành phố không được để trống"."<br>";
    }

    if(empty($_POST['cust_state'])) {
        $valid = 0;
        $error_message .= "Tỉnh thành/Quận/Huyện không được để trống"."<br>";
    }

    if(empty($_POST['cust_zip'])) {
        $valid = 0;
        $error_message .= "Mã bưu điện không được để trống"."<br>";
    }

    if($valid == 1) {

        // cập nhật dữ liệu vào db
        $statement = $pdo->prepare("UPDATE tbl_customer SET cust_name=?, cust_cname=?, cust_phone=?, cust_country=?, cust_address=?, cust_city=?, cust_state=?, cust_zip=? WHERE cust_id=?");
        $statement->execute(array(
                    strip_tags($_POST['cust_name']),
                    strip_tags($_POST['cust_cname']),
                    strip_tags($_POST['cust_phone']),
                    strip_tags($_POST['cust_country']),
                    strip_tags($_POST['cust_address']),
                    strip_tags($_POST['cust_city']),
                    strip_tags($_POST['cust_state']),
                    strip_tags($_POST['cust_zip']),
                    $_SESSION['customer']['cust_id']
                ));  
       
        $success_message = "Thông tin hồ sơ cập nhật thành công";

        $_SESSION['customer']['cust_name'] = $_POST['cust_name'];
        $_SESSION['customer']['cust_cname'] = $_POST['cust_cname'];
        $_SESSION['customer']['cust_phone'] = $_POST['cust_phone'];
        $_SESSION['customer']['cust_country'] = $_POST['cust_country'];
        $_SESSION['customer']['cust_address'] = $_POST['cust_address'];
        $_SESSION['customer']['cust_city'] = $_POST['cust_city'];
        $_SESSION['customer']['cust_state'] = $_POST['cust_state'];
        $_SESSION['customer']['cust_zip'] = $_POST['cust_zip'];
    }
}
?>
<style>
    /* General Styling for Form Container */
.user-content {
    background-color: #f9f9f9;
    border: 1px solid #006666; /* Xanh đậm */
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Heading */
.user-content h3 {
    color: #006666; /* Xanh đậm */
    text-align: center;
    margin-bottom: 20px;
    font-weight: bold;
}

/* Input Fields */
.user-content .form-control {
    border: 1px solid #006666; /* Xanh đậm */
    border-radius: 4px;
    padding: 10px;
    font-size: 14px;
    color: #333333; /* Xám đậm */
}

.user-content .form-control:focus {
    border-color: #CC3300; /* Đỏ đậm */
    box-shadow: 0 0 5px rgba(204, 51, 0, 0.5); /* Hiệu ứng đổ bóng */
    outline: none;
}

/* Labels */
.user-content label {
    font-weight: bold;
    color: #006666; /* Xanh đậm */
    margin-bottom: 8px;
    display: block;
}

/* Submit Button */

.user-content .btn-primary {
    background-color: #006666; /* Màu xanh đậm ban đầu */
    border: none;
    color: #FFFFFF; /* Trắng */
    padding: 10px 20px;
    font-size: 16px;
    font-weight: bold;
    border-radius: 4px;
    transition: background-color 0.3s ease-in-out;
    cursor: pointer;
}

.user-content .btn-primary:hover {
    background-color: #CC3300; /* Đỏ đậm khi hover */
    color: #FFFFFF; /* Trắng */
}


/* Error and Success Messages */
.error {
    color: #CC3300; /* Đỏ đậm */
    border: 1px solid #CC3300;
    background-color: #FFE6E6; /* Nền đỏ nhạt */
    border-radius: 4px;
    padding: 10px;
    margin-bottom: 15px;
}

.success {
    color: #006666; /* Xanh đậm */
    border: 1px solid #006666;
    background-color: #E6F9F9; /* Nền xanh nhạt */
    border-radius: 4px;
    padding: 10px;
    margin-bottom: 15px;
}

/* Dropdown Styling */
.user-content select.form-control {
    background-color: #FFFFFF; /* Trắng */
    color: #333333; /* Xám đậm */
    padding: 10px;
    border: 1px solid #006666; /* Xanh đậm */
    border-radius: 4px;
    appearance: none;
    cursor: pointer;
}

/* Placeholder Styling */
.user-content ::placeholder {
    color: #999999; /* Xám nhạt */
    font-style: italic;
}

/* Additional Styling for Form Rows */
.user-content .row > div {
    margin-bottom: 15px;
}

</style>
<div class="page">
    <div class="container">
        <div class="row">            
            <div class="col-md-12"> 
                <?php require_once('customer-sidebar.php'); ?>
            </div>
            <div class="col-md-12">
                <div class="user-content">
                    <h3>
                        <?php echo"Cập nhật hồ sơ"; ?>
                    </h3>
                    <?php
                    if($error_message != '') {
                        echo "<div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$error_message."</div>";
                    }
                    if($success_message != '') {
                        echo "<div class='success' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$success_message."</div>";
                    }
                    ?>
                    <form action="" method="post">
                        <?php $csrf->echoInputField(); ?>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for=""><?php echo "Tên khách hàng"; ?> *</label>
                                <input type="text" class="form-control" name="cust_name" value="<?php echo $_SESSION['customer']['cust_name']; ?>">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for=""><?php echo "Tên công ty"; ?></label>
                                <input type="text" class="form-control" name="cust_cname" value="<?php echo $_SESSION['customer']['cust_cname']; ?>">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for=""><?php echo "Địa chỉ email"; ?> *</label>
                                <input type="text" class="form-control" name="" value="<?php echo $_SESSION['customer']['cust_email']; ?>" disabled>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for=""><?php echo "Số điện thoại"; ?> *</label>
                                <input type="text" class="form-control" name="cust_phone" value="<?php echo $_SESSION['customer']['cust_phone']; ?>">
                            </div>
                            <div class="col-md-12 form-group">
                                <label for=""><?php echo "Địa chỉ"; ?> *</label>
                                <textarea name="cust_address" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $_SESSION['customer']['cust_address']; ?></textarea>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for=""><?php echo "Quốc gia"; ?> *</label>
                                <select name="cust_country" class="form-control">
                                <?php
                                $statement = $pdo->prepare("SELECT * FROM tbl_country ORDER BY country_name ASC");
                                $statement->execute();
                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result as $row) {
                                    ?>
                                    <option value="<?php echo $row['country_id']; ?>" <?php if($row['country_id'] == $_SESSION['customer']['cust_country']) {echo 'selected';} ?>><?php echo $row['country_name']; ?></option>
                                    <?php
                                }
                                ?>
                                </select>                                    
                            </div>
                            
                            <div class="col-md-6 form-group">
                                <label for=""><?php echo "Thành phố "; ?> *</label>
                                <input type="text" class="form-control" name="cust_city" value="<?php echo $_SESSION['customer']['cust_city']; ?>">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for=""><?php echo "Tỉnh thành/Quận/Huyện"; ?> *</label>
                                <input type="text" class="form-control" name="cust_state" value="<?php echo $_SESSION['customer']['cust_state']; ?>">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for=""><?php echo "Mã bưu điện"; ?> *</label>
                                <input type="text" class="form-control" name="cust_zip" value="<?php echo $_SESSION['customer']['cust_zip']; ?>">
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary" value="<?php echo "Cập nhật"; ?>" name="form1">
                    </form>
                </div>                
            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php'); ?>