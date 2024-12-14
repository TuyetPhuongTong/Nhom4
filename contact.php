<?php require_once('header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $contact_title = $row['contact_title'];
    $contact_banner = $row['contact_banner'];
}
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $contact_map_iframe = $row['contact_map_iframe'];
    $contact_email = $row['contact_email'];
    $contact_phone = $row['contact_phone'];
    $contact_address = $row['contact_address'];
}
?>

<div class="page-banner" style="background-image: url(https://i.pinimg.com/736x/82/cd/4a/82cd4a8c262b9c774f0638d7fd88997a.jpg);">
    <div class="inner">
        <h1><?php echo $contact_title; ?></h1>
    </div>
</div>

<div class="page">
    <div class="container">
        <div class="row">            
            <div class="col-md-12">
                <h3>Biểu Mẫu Liên Hệ</h3>
                <div class="row cform">
                    <div class="col-md-8">
                        <div class="well well-sm">
                            
<?php
// Xử Lý Khi Biểu Mẫu Liên Hệ Được Gửi
if(isset($_POST['form_contact']))
{
    $error_message = '';
    $success_message = '';
    $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
    foreach ($result as $row) 
    {
        $receive_email = $row['receive_email'];
        $receive_email_subject = $row['receive_email_subject'];
        $receive_email_thank_you_message = $row['receive_email_thank_you_message'];
    }

    $valid = 1;

    if(empty($_POST['visitor_name']))
    {
        $valid = 0;
        $error_message .= 'Vui Lòng Nhập Tên Của Bạn.\n';
    }

    if(empty($_POST['visitor_phone']))
    {
        $valid = 0;
        $error_message .= 'Vui Lòng Nhập Số Điện Thoại.\n';
    }

    if(empty($_POST['visitor_email']))
    {
        $valid = 0;
        $error_message .= 'Vui Lòng Nhập Địa Chỉ Email.\n';
    }
    else
    {
        // Kiểm Tra Định Dạng Email
        if(!filter_var($_POST['visitor_email'], FILTER_VALIDATE_EMAIL))
        {
            $valid = 0;
            $error_message .= 'Vui Lòng Nhập Email Hợp Lệ.\n';
        }
    }

    if(empty($_POST['visitor_message']))
    {
        $valid = 0;
        $error_message .= 'Vui Lòng Nhập Nội Dung Tin Nhắn.\n';
    }

    if($valid == 1)
    {
    
        $visitor_name = strip_tags($_POST['visitor_name']);
        $visitor_email = strip_tags($_POST['visitor_email']);
        $visitor_phone = strip_tags($_POST['visitor_phone']);
        $visitor_message = strip_tags($_POST['visitor_message']);

   // Gửi Email
   $to_admin = 'phuongtong.31221023099@st.ueh.edu.vn';
   $subject = $receive_email_subject;
   $message = '
<html><body>
<table>
<tr>
<td>Tên</td>
<td>'.$visitor_name.'</td>
</tr>
<tr>
<td>Email</td>
<td>'.$visitor_email.'</td>
</tr>
<tr>
<td>Số Điện Thoại</td>
<td>'.$visitor_phone.'</td>
</tr>
<tr>
<td>Nội Dung</td>
<td>'.nl2br($visitor_message).'</td>
</tr>
</table>
</body></html>
';
   $headers = 'From: ' . $visitor_email . "\r\n" .
              'Reply-To: ' . $visitor_email . "\r\n" .
              'X-Mailer: PHP/' . phpversion() . "\r\n" . 
              "MIME-Version: 1.0\r\n" . 
              "Content-Type: text/html; charset=ISO-8859-1\r\n";

   // Gửi Email Đến Quản Trị Viên                  
   mail($to_admin, $subject, $message, $headers); 
   
   $success_message = $receive_email_thank_you_message;
}
}
?>
<?php
           if($error_message != '') {
               echo "<script>alert('".$error_message."')</script>";
           }
           if($success_message != '') {
               echo "<script>alert('".$success_message."')</script>";
           }
           ?>
<style>
 /* Thiết kế chung cho biểu mẫu liên hệ */
.cform .form-control {
    border: 1px solid #CC3300;
    border-radius: 4px;
    color: #006666;
}

.cform .form-control:focus {
    border-color: #006666;
    box-shadow: 0 0 5px rgba(0, 102, 102, 0.5);
}

.cform label {
    color: #006666;
    font-weight: bold;
}

.cform .btn-primary {
    background-color: #CC3300;
    border-color: #CC3300;
    color: #fff;
    transition: background-color 0.3s, border-color 0.3s;
}

.cform .btn-primary:hover {
    background-color: #006666;
    border-color: #006666;
    color: #fff;
}

.cform .btn-primary:focus {
    background-color: #CC3300;
    border-color: #CC3300;
}

/* Thiết kế phần thông tin văn phòng */
address {
    color: #006666;
    font-style: normal;
    line-height: 1.5;
}

address strong {
    color: #CC3300;
}

address a {
    color: #006666;
    text-decoration: none;
}

address a:hover {
    text-decoration: underline;
}

/* Thiết kế phần bản đồ */
.page .container h3 {
    color: #CC3300;
    border-bottom: 2px solid #006666;
    padding-bottom: 5px;
    margin-bottom: 15px;
}

/* Thiết kế tiêu đề trang */
.page-banner {
    color: #fff;
    background-size: cover;
    text-align: center;
    padding: 50px 0;
}

.page-banner h1 {
    color: #CC3300;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
}

/* Thiết kế hộp thông báo */
.well {
    border: 1px solid #006666;
    background-color: #f9f9f9;
    padding: 20px;
}

.well-sm {
    border: 1px solid #CC3300;
    background-color: #fff8f5;
}


</style>           


                            <form action="" method="post">
                            <?php $csrf->echoInputField(); ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Họ Và Tên</label>
                                        <input type="text" class="form-control" name="visitor_name" placeholder="Nhập Họ Và Tên">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Địa Chỉ Email</label>
                                        <input type="email" class="form-control" name="visitor_email" placeholder="Nhập Địa Chỉ Email">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Số Điện Thoại</label>
                                        <input type="text" class="form-control" name="visitor_phone" placeholder="Nhập Số Điện Thoại">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Nội Dung</label>
                                        <textarea name="visitor_message" class="form-control" rows="9" cols="25" placeholder="Nhập Nội Dung"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <input type="submit" value="Gửi Tin Nhắn" class="btn btn-primary pull-right" name="form_contact">
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <legend><span class="glyphicon glyphicon-globe"></span> Văn Phòng Của Chúng Tôi</legend>
                        <address>
                            <?php echo nl2br($contact_address); ?>
                        </address>
                        <address>
                            <strong>Số Điện Thoại:</strong><br>
                            <span><?php echo $contact_phone; ?></span>
                        </address>
                        <address>
                            <strong>Email:</strong><br>
                            <a href="mailto:<?php echo $contact_email; ?>"><span><?php echo $contact_email; ?></span></a>
                        </address>
                    </div>
                </div>

                <h3>Tìm Chúng Tôi Trên Bản Đồ</h3>
                <?php echo $contact_map_iframe; ?>
                
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>
