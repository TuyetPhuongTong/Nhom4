<?php
ob_start();
session_start();
include("inc/config.php");
include("inc/functions.php");
include("inc/CSRF_Protect.php");
$csrf = new CSRF_Protect();
$error_message = '';
$success_message = '';
$error_message1 = '';
$success_message1 = '';

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if(!isset($_SESSION['user'])) {
	header('location: login.php');
	exit;
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Trang Quản Trị</title>

	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/ionicons.min.css">
	<link rel="stylesheet" href="css/datepicker3.css">
	<link rel="stylesheet" href="css/all.css">
	<link rel="stylesheet" href="css/select2.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.css">
	<link rel="stylesheet" href="css/jquery.fancybox.css">
	<link rel="stylesheet" href="css/AdminLTE.min.css">
	<link rel="stylesheet" href="css/_all-skins.min.css">
	<link rel="stylesheet" href="css/on-off-switch.css"/>
	<link rel="stylesheet" href="css/summernote.css">
	<link rel="stylesheet" href="style.css">
	<style>
/* Reset mặc định */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif;
    background-color: #f0f9f9; /* Nền xanh nhạt */
    color: #333;
    font-size: 16px;
    line-height: 1.8;
    overflow-x: hidden; /* Không cho cuộn ngang */
}

/* Header */
.main-header {
    background-color: #006666; /* Màu xanh đậm */
    color: #FF6600; /* Chữ màu cam */
    padding: 15px 20px;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    z-index: 1000;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
}

.main-header .logo {
    font-size: 24px;
    font-weight: 700;
    text-transform: uppercase;
    color: #FF6600; /* Chữ màu cam */
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
}

.main-header .navbar-custom-menu a {
    color: #FF6600; /* Chữ màu cam */
    margin-left: 20px;
    font-weight: 600;
    transition: color 0.3s ease;
}

.main-header .navbar-custom-menu a:hover {
    color: #fff; /* Chữ màu trắng khi hover */
}

/* Sidebar */
.sidebar {
    width: 240px;
    background-color: #006666; /* Thanh màu xanh */
    color: #FF6600; /* Chữ màu cam */
    position: fixed;
    top: 65px; /* Đẩy xuống dưới header */
    left: 0;
    bottom: 0;
    padding-top: 20px;
    overflow-y: auto; /* Chỉ cuộn dọc */
    box-shadow: 2px 0px 8px rgba(0, 0, 0, 0.2);
}

.sidebar-menu {
    list-style: none;
    padding: 0 10px;
}

.sidebar-menu li {
    margin-bottom: 15px;
}

.sidebar-menu li a {
    display: block;
    padding: 12px 20px;
    text-decoration: none;
    color: #FF6600; /* Chữ màu cam */
    border-radius: 6px;
    font-weight: 500;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.sidebar-menu li a:hover {
    background-color: #FF6600; /* Nền cam khi hover */
    color: #fff; /* Chữ màu trắng */
    transform: translateX(10px); /* Hiệu ứng di chuyển */
}

/* Nội dung */
.content-wrapper {
    margin-left: 240px; /* Chừa không gian cho sidebar */
    margin-top: 80px; /* Đẩy nội dung xuống dưới header */
    padding: 30px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    min-height: calc(100vh - 80px); /* Đảm bảo nội dung không bị đè */
    overflow-y: auto; /* Cuộn nội dung nếu cần */
}

.content-wrapper h1 {
    font-size: 30px;
    color: #FF6600; /* Chữ màu cam */
    font-weight: 700;
    margin-bottom: 20px;
    text-align: center;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* Nút bấm */
.btn {
    display: inline-block;
    padding: 12px 20px;
    font-size: 14px;
    font-weight: 600;
    text-align: center;
    border-radius: 5px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-primary {
    background-color: #006666; /* Màu xanh */
    color: #FF6600; /* Chữ màu cam */
}

.btn-primary:hover {
    background-color: #004d4d; /* Xanh đậm hơn */
    color: #fff; /* Chữ màu trắng khi hover */
    transform: scale(1.05); /* Hiệu ứng phóng to */
}

/* Footer */
.main-footer {
    background-color: #006666; /* Thanh màu xanh */
    color: #FF6600; /* Chữ màu cam */
    text-align: center;
    padding: 20px;
    position: fixed;
    bottom: 0;
    left: 0;
    width: calc(100% - 240px); /* Tránh bị sidebar đè lên */
    font-size: 14px;
    margin-left: 240px; /* Chừa không gian cho sidebar */
}

.main-footer a {
    color: #FF6600; /* Chữ màu cam */
    text-decoration: none;
    font-weight: bold;
}

.main-footer a:hover {
    text-decoration: underline;
    color: #fff; /* Trắng khi hover */
}
</style>

</head>

<body class="hold-transition fixed skin-blue sidebar-mini">

	<div class="wrapper">

		<header class="main-header">

			<a href="index.php" class="logo">
				<span class="logo-lg">Đô Si La Mi</span>
			</a>

			<nav class="navbar navbar-static-top">
				
				<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
					<span class="sr-only">Chuyển đổi điều hướng</span>
				</a>

				<span style="float:left;line-height:50px;color:#fff;padding-left:15px;font-size:18px;">Bảng điều khiển quản trị</span>
    <!-- Thanh trên cùng ... Thông tin người dùng .. Khu vực Đăng nhập/Đăng xuất -->
				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<img src="../assets/uploads/<?php echo $_SESSION['user']['photo']; ?>" class="user-image" alt="User Image">
								<span class="hidden-xs"><?php echo $_SESSION['user']['full_name']; ?></span>
							</a>
							<ul class="dropdown-menu">
								<li class="user-footer">
									<div>
										<a href="profile-edit.php" class="btn btn-default btn-flat">Chỉnh sửa hồ sơ</a>
									</div>
									<div>
										<a href="logout.php" class="btn btn-default btn-flat">Đăng xuất</a>
									</div>
								</li>
							</ul>
						</li>
					</ul>
				</div>

			</nav>
		</header>

  		<?php $cur_page = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1); ?>
<!-- Thanh bên để quản lý hoạt động của cửa hàng -->
  		<aside class="main-sidebar">
    		<section class="sidebar">
      
      			<ul class="sidebar-menu">

			        <li class="treeview <?php if($cur_page == 'index.php') {echo 'active';} ?>">
			          <a href="index.php">
			            <i class="fa fa-dashboard"></i> <span>Bảng điều khiển</span>
			          </a>
			        </li>

					
			        <li class="treeview <?php if( ($cur_page == 'settings.php') ) {echo 'active';} ?>">
			          <a href="settings.php">
			            <i class="fa fa-sliders"></i> <span>Cài đặt trang web</span>
			          </a>
			        </li>

                    <li class="treeview <?php if( ($cur_page == 'size.php') || ($cur_page == 'size-add.php') || ($cur_page == 'size-edit.php') || ($cur_page == 'color.php') || ($cur_page == 'color-add.php') || ($cur_page == 'color-edit.php') || ($cur_page == 'country.php') || ($cur_page == 'country-add.php') || ($cur_page == 'country-edit.php') || ($cur_page == 'shipping-cost.php') || ($cur_page == 'shipping-cost-edit.php') || ($cur_page == 'top-category.php') || ($cur_page == 'top-category-add.php') || ($cur_page == 'top-category-edit.php') || ($cur_page == 'mid-category.php') || ($cur_page == 'mid-category-add.php') || ($cur_page == 'mid-category-edit.php') || ($cur_page == 'end-category.php') || ($cur_page == 'end-category-add.php') || ($cur_page == 'end-category-edit.php') ) {echo 'active';} ?>">
                        <a href="#">
                            <i class="fa fa-cogs"></i>
                            <span>Cài đặt cửa hàng</span>
                            <span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="size.php"><i class="fa fa-circle-o"></i> Kích cỡ</a></li>
                            <li><a href="color.php"><i class="fa fa-circle-o"></i> Độ đậm Cacao</a></li>
                            <li><a href="country.php"><i class="fa fa-circle-o"></i> Quốc gia</a></li>
                            <li><a href="shipping-cost.php"><i class="fa fa-circle-o"></i>Phí vận chuyển</a></li>
                            <li><a href="top-category.php"><i class="fa fa-circle-o"></i> Danh mục sản phẩm</a></li>
                            <li><a href="mid-category.php"><i class="fa fa-circle-o"></i> Danh mục sản phẩm con</a></li>
                            <li><a href="end-category.php"><i class="fa fa-circle-o"></i> Danh mục sản phẩm phụ</a></li>
                        </ul>
                    </li>


                    <li class="treeview <?php if( ($cur_page == 'product.php') || ($cur_page == 'product-add.php') || ($cur_page == 'product-edit.php') ) {echo 'active';} ?>">
                        <a href="product.php">
                            <i class="fa fa-shopping-bag"></i> <span>Quản lý sản phẩm</span>
                        </a>
                    </li>


                    <li class="treeview <?php if( ($cur_page == 'order.php') ) {echo 'active';} ?>">
                        <a href="order.php">
                            <i class="fa fa-sticky-note"></i> <span>Quản lý đơn hàng</span>
                        </a>
                    </li>


                     <li class="treeview <?php if( ($cur_page == 'slider.php') ) {echo 'active';} ?>">
			          <a href="slider.php">
			            <i class="fa fa-picture-o"></i> <span>Quản lý Sliders</span>
			          </a>
			        </li>
					<li class="treeview <?php if( ($cur_page == 'post.php') ) {echo 'active';} ?>">
                        <a href="post.php">
                            <i class="fa fa-sticky-note"></i> <span>Quản lý bài viết</span>
                        </a>
                    </li>
                    <!-- Biểu tượng sẽ được hiển thị trên Shop -->
			        <li class="treeview <?php if( ($cur_page == 'service.php') ) {echo 'active';} ?>">
			          <a href="service.php">
			            <i class="fa fa-list-ol"></i> <span>Dịch vụ</span>
			          </a>
			        </li>

			      			        <li class="treeview <?php if( ($cur_page == 'faq.php') ) {echo 'active';} ?>">
			          <a href="faq.php">
			            <i class="fa fa-question-circle"></i> <span>FAQ</span>
			          </a>
			        </li>

						<li class="treeview <?php if( ($cur_page == 'customer.php') || ($cur_page == 'customer-add.php') || ($cur_page == 'customer-edit.php') ) {echo 'active';} ?>">
			          <a href="customer.php">
			            <i class="fa fa-user-plus"></i> <span>Khách hàng đã đăng ký</span>
			          </a>
			        </li>

			        <li class="treeview <?php if( ($cur_page == 'page.php') ) {echo 'active';} ?>">
			          <a href="page.php">
			            <i class="fa fa-tasks"></i> <span>Cài đặt trang</span>
			          </a>
			        </li>

			        <li class="treeview <?php if( ($cur_page == 'social-media.php') ) {echo 'active';} ?>">
			          <a href="social-media.php">
			            <i class="fa fa-globe"></i> <span>Social Media</span>
			          </a>
			        </li>

			        <li class="treeview <?php if( ($cur_page == 'subscriber.php')||($cur_page == 'subscriber.php') ) {echo 'active';} ?>">
			          <a href="subscriber.php">
			            <i class="fa fa-hand-o-right"></i> <span>Người theo dõi</span>
			          </a>
			        </li>
					

      			</ul>
    		</section>
  		</aside>

  		<div class="content-wrapper">  