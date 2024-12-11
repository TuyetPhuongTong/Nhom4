<!-- This is main configuration File -->
<?php
ob_start();
session_start();
include("admin/inc/config.php");
include("admin/inc/functions.php");
include("admin/inc/CSRF_Protect.php");
$csrf = new CSRF_Protect();
$error_message = '';
$success_message = '';
$error_message1 = '';
$success_message1 = '';

// Getting all language variables into array as global variable
$i=1;
$statement = $pdo->prepare("SELECT * FROM tbl_language");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
	define('LANG_VALUE_'.$i,$row['lang_value']);
	$i++;
}

$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row)
{
	$logo = $row['logo'];
	$favicon = $row['favicon'];
	$contact_email = $row['contact_email'];
	$contact_phone = $row['contact_phone'];
	$meta_title_home = $row['meta_title_home'];
    $meta_keyword_home = $row['meta_keyword_home'];
    $meta_description_home = $row['meta_description_home'];
    $before_head = $row['before_head'];
    $after_body = $row['after_body'];
}

// Checking the order table and removing the pending transaction that are 24 hours+ old. Very important
$current_date_time = date('Y-m-d H:i:s');
$statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_status=?");
$statement->execute(array('Pending'));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
	$ts1 = strtotime($row['payment_date']);
	$ts2 = strtotime($current_date_time);     
	$diff = $ts2 - $ts1;
	$time = $diff/(3600);
	if($time>24) {

		// Return back the stock amount
		$statement1 = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
		$statement1->execute(array($row['payment_id']));
		$result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
		foreach ($result1 as $row1) {
			$statement2 = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
			$statement2->execute(array($row1['product_id']));
			$result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);							
			foreach ($result2 as $row2) {
				$p_qty = $row2['p_qty'];
			}
			$final = $p_qty+$row1['quantity'];

			$statement = $pdo->prepare("UPDATE tbl_product SET p_qty=? WHERE p_id=?");
			$statement->execute(array($final,$row1['product_id']));
		}
		
		// Deleting data from table
		$statement1 = $pdo->prepare("DELETE FROM tbl_order WHERE payment_id=?");
		$statement1->execute(array($row['payment_id']));

		$statement1 = $pdo->prepare("DELETE FROM tbl_payment WHERE id=?");
		$statement1->execute(array($row['id']));
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>

	<!-- Meta Tags -->
	<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>

	<!-- Favicon -->
	<link rel="icon" type="image/png" href="assets/uploads/<?php echo $favicon; ?>">

	<!-- Stylesheets -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/css/owl.carousel.min.css">
	<link rel="stylesheet" href="assets/css/owl.theme.default.min.css">
	<link rel="stylesheet" href="assets/css/jquery.bxslider.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/rating.css">
	<link rel="stylesheet" href="assets/css/spacing.css">
	<link rel="stylesheet" href="assets/css/bootstrap-touch-slider.css">
	<link rel="stylesheet" href="assets/css/animate.min.css">
	<link rel="stylesheet" href="assets/css/tree-menu.css">
	<link rel="stylesheet" href="assets/css/select2.min.css">
	<link rel="stylesheet" href="assets/css/main.css">
	<link rel="stylesheet" href="assets/css/responsive.css">
	<link rel="stylesheet" href="assets/css/blog.css">
	<?php

	$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
	$statement->execute();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) {
		$about_meta_title = $row['about_meta_title'];
		$about_meta_keyword = $row['about_meta_keyword'];
		$about_meta_description = $row['about_meta_description'];
		$faq_meta_title = $row['faq_meta_title'];
		$faq_meta_keyword = $row['faq_meta_keyword'];
		$faq_meta_description = $row['faq_meta_description'];
		$blog_meta_title = $row['blog_meta_title'];
		$blog_meta_keyword = $row['blog_meta_keyword'];
		$blog_meta_description = $row['blog_meta_description'];
		$contact_meta_title = $row['contact_meta_title'];
		$contact_meta_keyword = $row['contact_meta_keyword'];
		$contact_meta_description = $row['contact_meta_description'];
		$pgallery_meta_title = $row['pgallery_meta_title'];
		$pgallery_meta_keyword = $row['pgallery_meta_keyword'];
		$pgallery_meta_description = $row['pgallery_meta_description'];
		$vgallery_meta_title = $row['vgallery_meta_title'];
		$vgallery_meta_keyword = $row['vgallery_meta_keyword'];
		$vgallery_meta_description = $row['vgallery_meta_description'];
	}

	$cur_page = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
	
	if($cur_page == 'index.php' || $cur_page == 'login.php' || $cur_page == 'registration.php' || $cur_page == 'cart.php' || $cur_page == 'checkout.php' || $cur_page == 'forget-password.php' || $cur_page == 'reset-password.php' || $cur_page == 'product-category.php' || $cur_page == 'product.php') {
		?>
		<title><?php echo $meta_title_home; ?></title>
		<meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
		<meta name="description" content="<?php echo $meta_description_home; ?>">
		<?php
	}

	if($cur_page == 'about.php') {
		?>
		<title><?php echo $about_meta_title; ?></title>
		<meta name="keywords" content="<?php echo $about_meta_keyword; ?>">
		<meta name="description" content="<?php echo $about_meta_description; ?>">
		<?php
	}
	if($cur_page == 'faq.php') {
		?>
		<title><?php echo $faq_meta_title; ?></title>
		<meta name="keywords" content="<?php echo $faq_meta_keyword; ?>">
		<meta name="description" content="<?php echo $faq_meta_description; ?>">
		<?php
	}
	if($cur_page == 'contact.php') {
		?>
		<title><?php echo $contact_meta_title; ?></title>
		<meta name="keywords" content="<?php echo $contact_meta_keyword; ?>">
		<meta name="description" content="<?php echo $contact_meta_description; ?>">
		<?php
	}
	if($cur_page == 'product.php')
	{
		$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
		$statement->execute(array($_REQUEST['id']));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
		foreach ($result as $row) 
		{
		    $og_photo = $row['p_featured_photo'];
		    $og_title = $row['p_name'];
		    $og_slug = 'product.php?id='.$_REQUEST['id'];
			$og_description = substr(strip_tags($row['p_description']),0,200).'...';
		}
	}

	if($cur_page == 'dashboard.php') {
		?>
		<title>Dashboard - <?php echo $meta_title_home; ?></title>
		<meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
		<meta name="description" content="<?php echo $meta_description_home; ?>">
		<?php
	}
	if($cur_page == 'customer-profile-update.php') {
		?>
		<title>Update Profile - <?php echo $meta_title_home; ?></title>
		<meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
		<meta name="description" content="<?php echo $meta_description_home; ?>">
		<?php
	}
	if($cur_page == 'customer-billing-shipping-update.php') {
		?>
		<title>Update Billing and Shipping Info - <?php echo $meta_title_home; ?></title>
		<meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
		<meta name="description" content="<?php echo $meta_description_home; ?>">
		<?php
	}
	if($cur_page == 'customer-password-update.php') {
		?>
		<title>Update Password - <?php echo $meta_title_home; ?></title>
		<meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
		<meta name="description" content="<?php echo $meta_description_home; ?>">
		<?php
	}
	if($cur_page == 'customer-order.php') {
		?>
		<title>Orders - <?php echo $meta_title_home; ?></title>
		<meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
		<meta name="description" content="<?php echo $meta_description_home; ?>">
		<?php
	}
	?>
	
	<?php if($cur_page == 'blog-single.php'): ?>
		<meta property="og:title" content="<?php echo $og_title; ?>">
		<meta property="og:type" content="website">
		<meta property="og:url" content="<?php echo BASE_URL.$og_slug; ?>">
		<meta property="og:description" content="<?php echo $og_description; ?>">
		<meta property="og:image" content="assets/uploads/<?php echo $og_photo; ?>">
	<?php endif; ?>

	<?php if($cur_page == 'product.php'): ?>
		<meta property="og:title" content="<?php echo $og_title; ?>">
		<meta property="og:type" content="website">
		<meta property="og:url" content="<?php echo BASE_URL.$og_slug; ?>">
		<meta property="og:description" content="<?php echo $og_description; ?>">
		<meta property="og:image" content="assets/uploads/<?php echo $og_photo; ?>">
	<?php endif; ?>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>

	<script type="text/javascript" src="//platform-api.sharethis.com/js/sharethis.js#property=5993ef01e2587a001253a261&product=inline-share-buttons"></script>

<?php echo $before_head; ?>

</head>
<body>

<?php echo $after_body; ?>
<!--
<div id="preloader">
	<div id="status"></div>
</div>-->

<!-- top bar -->
<div class="top" style="background-color: #7f572e; color: #f6dbab; padding: 10px 0;">
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-sm-4 col-xs-12">
				<div class="left" style="text-align: center;">
					<ul style="list-style: none; margin: 0; padding: 0;">
						<li style="display: inline-block; margin-right: 15px; color: #f6dbab;">
							<i class="fa fa-phone" style="margin-right: 5px; color: #f6dbab;"></i><?php echo $contact_phone; ?>
						</li>	
					</ul>
				</div>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-12">
				<div class="middle" style="text-align: center; color: #f6dbab; font-size: 14px;">
				         Đặt quà & Giao hàng miễn phí cho đơn từ 1.000.000 VND
				</div>
			</div>
			
			<div class="col-md-4 col-sm-4 col-xs-12">
				<div class="right" style="text-align: right;">
					<ul style="list-style: none; margin: 0; padding: 0;">
						<?php
						$statement = $pdo->prepare("SELECT * FROM tbl_social");
						$statement->execute();
						$result = $statement->fetchAll(PDO::FETCH_ASSOC);
						foreach ($result as $row) {
							?>
							<?php if($row['social_url'] != ''): ?>
							<li style="display: inline-block; margin-left: 15px;">
								<a href="<?php echo $row['social_url']; ?>" style="color: #f6dbab; text-decoration: none; font-size: 16px;">
									<i class="<?php echo $row['social_icon']; ?>"></i>
								</a>
							</li>
							<?php endif; ?>
							<?php
						}
						?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- header -->
<div class="header" style="background-color: #f6dbab; font-family: 'Roboto', serif; color: #7f572e; height:auto ">
    <div class="container">
        <div class="row inner headerHeight" style="display: flex; align-items: center; justify-content: space-between;">
            <!-- Đăng nhập và Đăng ký - Căn trái, cùng một dòng -->
            <div class="col-md-4" style="text-align: left;">
                <ul style="list-style: none; padding: 0; margin: 0; display: flex; align-items: center; gap:25px">
                    <?php
                    if(isset($_SESSION['customer'])) {
                        ?>
                        <li><i class="fa fa-user" style="font-size: 20px; font-weight: bold;"></i> Xin chào, <?php echo $_SESSION['customer']['cust_name']; ?></li>
                        <li><a href="dashboard.php" style="color: #7f572e; font-size: 18px; font-weight: bold; margin-left: 15px;"><i class="fa fa-home" style="font-size: 20px; font-weight: bold;"></i> Trang cá nhân</a></li>
                        <?php
                    } else {
                        ?>
                        <li><a href="login.php" style="color: #7f572e; font-size: 14px;  font-weight: bold; margin-right: 15px;"><i class="fa fa-sign-in" style="font-size: 20px;"></i> Đăng nhập</a></li>
                        <li><a href="registration.php" style="color: #7f572e; font-size: 14px; font-weight: bold"><i class="fa fa-user-plus" style="font-size: 20px;"></i> Đăng ký</a></li>
                        <?php	
                    }
                    ?>
                </ul>
            </div>
            
            <!-- Logo - Căn giữa, phóng to -->
            <div class="col-md-4 text-center logo" style="margin: 0; ">
                <a href="index.php">
                    <img src="https://i.pinimg.com/736x/22/c0/1f/22c01fe247baa414f9315311e987a035.jpg" alt="logo image" style="width: auto; height: 27dvh; margin: 0;">
                </a>
            </div>
            
            <!-- Giỏ hàng -->
            <div class="col-md-2 text-center"style="display: flex; justify-content: flex-end; align-items: center; gap: 15px;">
                <a href="cart.php" style="color: #7f572e; font-size: 14px; font-weight: bold;">
                    <i class="fa fa-shopping-cart" style="font-size: 20px;;"></i> Giỏ hàng 
                    (<?php
                    if(isset($_SESSION['cart_p_id'])) {
                        $table_total_price = 0;
                        $i = 0;
                        foreach($_SESSION['cart_p_qty'] as $key => $value) {
                            $i++;
                            $arr_cart_p_qty[$i] = $value;
                        }
                        $i = 0;
                        foreach($_SESSION['cart_p_current_price'] as $key => $value) {
                            $i++;
                            $arr_cart_p_current_price[$i] = $value;
                        }
                        for($i = 1; $i <= count($arr_cart_p_qty); $i++) {
                            $row_total_price = $arr_cart_p_current_price[$i] * $arr_cart_p_qty[$i];
                            $table_total_price = $table_total_price + $row_total_price;
                        }
                        echo $table_total_price;
                    } else {
                        echo '0.00';
                    }
                    ?><?php echo "₫"; ?>)
                </a>
            </div>
            
            <!-- Tìm kiếm (icon kính lúp và tô màu ô tìm kiếm) -->
            <div class="col-md-2 text-center search-area"style="display: flex; justify-content: flex-end; align-items: center; gap: 15px;">
                <form class="navbar-form navbar-left" role="search" action="search-result.php" method="get">
                    <?php $csrf->echoInputField(); ?>
                    <div class="form-group">
                        <input type="text" class="form-control search-top" placeholder="Tìm kiếm sản phẩm" name="search_text" style="color: #7f572e; border: 1px solid #7f572e; font-size: 14px; padding: 5px;">
                    </div>
                    <button type="submit" class="btn btn-danger" style="background-color: #7f572e; border: none; font-size: 12px;">
                        <i class="fa fa-search" style="font-size: 18px;"></i>
                    </button>
                </form>
            </div>
     
        </div>
    </div>
</div>

<!-- responsive -->
<style>
	.headerHeight {
		height: 27dvh !important;
	}
    /* Responsive - Màn hình nhỏ */
    @media (max-width: 767px) {
		.headerHeight {
			height: 50dvh !important; 

		}
        .header .row {
            flex-direction: column;
            align-items: center;
        }
        .header .col-md-12 {
            width: 100%;
            text-align: center;
        }
        .header .logo img {
            max-width: 200px;
        }
        .header .search-area {
            margin-top: 15px;
        }
        .header .search-top {
            width: 100%;
        }
        .header .btn-danger {
            width: auto;
        }

    }
    
    /* Responsive - Màn hình rất nhỏ */
    @media (max-width: 480px) {
        .header .search-area form .form-group input {
            font-size: 12px;
            padding: 5px;
        }
        .header .search-area button {
            font-size: 10px;
            padding: 5px;
        }
    }
</style>


<!-- under header -->

<div class="nav" style="background-color: #7f572e; color: #f6dbab;">
	<div class="container">
		<div class="row">
			<div class="col-md-12 pl_0 pr_0">
				<div class="menu-container" style="text-align: center;">
					<div class="menu">
						<ul style="list-style-type: none; padding: 0; margin: 0; background-color: #7f572e;">

							<li style="display: inline-block; margin-right: 10px; background-color: #7f572e;">
								<a href="index.php" style="color: #f6dbab; font-size: 16px; text-decoration: none; padding: 10px 15px; display: inline-block;">Trang chủ</a>

							</li>
							
							<?php
							$statement = $pdo->prepare("SELECT * FROM tbl_top_category WHERE show_on_menu=1");
							$statement->execute();
							$result = $statement->fetchAll(PDO::FETCH_ASSOC);
							foreach ($result as $row) {
								?>
								<li style="display: inline-block; margin-right: 20px; background-color: #7f572e;">
									<a href="product-category.php?id=<?php echo $row['tcat_id']; ?>&type=top-category" style="color: #f6dbab; font-size: 16px; text-decoration: none; padding: 10px 15px; display: inline-block;">
										<?php echo $row['tcat_name']; ?>
									</a>
									<ul style="list-style-type: none; padding: 0; background-color: #7f572e;">
										<?php
										$statement1 = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE tcat_id=?");
										$statement1->execute(array($row['tcat_id']));
										$result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
										foreach ($result1 as $row1) {
											?>
											<li style="display: inline-block; margin-right: 20px; background-color: #7f572e;">
												<a href="product-category.php?id=<?php echo $row1['mcat_id']; ?>&type=mid-category" style="color: #f6dbab; font-size: 16px; text-decoration: none; padding: 10px 15px; display: inline-block;">
													<?php echo $row1['mcat_name']; ?>
												</a>
												<ul style="list-style-type: none; padding: 0; background-color: #7f572e;">
													<?php
													$statement2 = $pdo->prepare("SELECT * FROM tbl_end_category WHERE mcat_id=?");
													$statement2->execute(array($row1['mcat_id']));
													$result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
													foreach ($result2 as $row2) {
														?>
														<li style="display: inline-block; margin-right: 20px; background-color: #7f572e;">
															<a href="product-category.php?id=<?php echo $row2['ecat_id']; ?>&type=end-category" style="color: #f6dbab; font-size: 16px; text-decoration: none; padding: 10px 15px; display: inline-block;">
																<?php echo $row2['ecat_name']; ?>
															</a>
														</li>
														<?php
													}
													?>
												</ul>
											</li>
											<?php
										}
										?>
									</ul>
								</li>
								<?php
							}
							?>

							<?php
							$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
							$statement->execute();
							$result = $statement->fetchAll(PDO::FETCH_ASSOC);		
							foreach ($result as $row) {
								$about_title = $row['about_title'];
								$faq_title = $row['faq_title'];
								$blog_title = $row['blog_title'];
								$contact_title = $row['contact_title'];
								$pgallery_title = $row['pgallery_title'];
								$vgallery_title = $row['vgallery_title'];
							}
							?>

							<li style="display: inline-block; margin-right: 20px; background-color: #7f572e;">
								<a href="about.php" style="color: #f6dbab; font-size: 16px; text-decoration: none; padding: 10px 15px; display: inline-block;">
									<?php echo $about_title; ?>
								</a>
							</li>
							<li style="display: inline-block; margin-right: 20px; background-color: #7f572e;">
								<a href="blog.php" style="color: #f6dbab; font-size: 16px; text-decoration: none; padding: 10px 15px; display: inline-block;">
									<?php echo $blog_title; ?>
								</a>
							</li>
							<li style="display: inline-block; margin-right: 20px; background-color: #7f572e;">
								<a href="faq.php" style="color: #f6dbab; font-size: 16px; text-decoration: none; padding: 10px 15px; display: inline-block;">
									<?php echo $faq_title; ?>
								</a>
							</li>

							<li style="display: inline-block; margin-right: 20px; background-color: #7f572e;">
								<a href="contact.php" style="color: #f6dbab; font-size: 16px; text-decoration: none; padding: 10px 15px; display: inline-block;">
									<?php echo $contact_title; ?>
								</a>
							</li>
							
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

