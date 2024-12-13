<?php require_once('header.php'); ?>

<?php
if ( (!isset($_REQUEST['email'])) || (isset($_REQUEST['token'])) )
{
    $var = 1;

    // check if the token is correct and match with database.
    $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_email=?");
    $statement->execute(array($_REQUEST['email']));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
    foreach ($result as $row) {
        if($_REQUEST['token'] != $row['cust_token']) {
            header('location: '.BASE_URL);
            exit;
        }
    }

    // everything is correct. now activate the user removing token value from database.
    if($var != 0)
    {
        $statement = $pdo->prepare("UPDATE tbl_customer SET cust_token=?, cust_status=? WHERE cust_email=?");
        $statement->execute(array('',1,$_GET['email']));

        $success_message = '<p style="color:green;">Tài khoản email của bạn được xác thực thành công. Bạn có thể đăng nhập vào trang web của chúng tôi bất cứ lúc nào.</p><p><a href="'.BASE_URL.'login.php" style="color:#167ac6;font-weight:bold;">Bấm vào để đăng nhập</a></p>';     
    }
}
?>

<div class="page-banner" style="background-image:url(https://i.pinimg.com/736x/82/cd/4a/82cd4a8c262b9c774f0638d7fd88997a.jpg)">
    <div class="inner">
        <h1>Đăng ký thành công</h1>
    </div>
</div>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="user-content">
                    <?php 
                        echo $error_message;
                        echo $success_message;
                    ?>
                </div>                
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>