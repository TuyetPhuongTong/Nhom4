<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
		
    // cập nhật vào cơ sở dữ liệu
	foreach($_POST['lang_value'] as $key=>$val) {
		$arr[$key] = $val;
	}

	for($i=1;$i<=count($arr);$i++) {
		$statement = $pdo->prepare("UPDATE tbl_language SET lang_value=? WHERE lang_id=?");
		$statement->execute(array($arr[$i],$i));
	}
	$success_message = 'Cài đặt ngôn ngữ đã được cập nhật thành công.';
}

$i=0;
$statement = $pdo->prepare("SELECT * FROM tbl_language");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
	$i++;
	$lang_ids[$i] = $row['lang_value'];
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Thiết lập ngôn ngữ</h1>
	</div>
</section>


<?php
$statement = $pdo->prepare("SELECT * FROM tbl_language");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {

}
?>

<section class="content">

  <div class="row">
    <div class="col-md-12">

		<?php if($error_message): ?>
		<div class="callout callout-danger">	
    		<p>
    		  <?php echo $error_message; ?>
    		</p>
		</div>
		<?php endif; ?>

		<?php if($success_message): ?>
		<div class="callout callout-success">
		    <p><?php echo $success_message; ?></p>
		</div>
		<?php endif; ?>

        <form class="form-horizontal" action="" method="post">
        
        <h3 style="font-size:20px;font-weight:500;">Cơ bản</h3>
		<div class="box box-info">
            <div class="box-body">
            	<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Tiền tệ <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[1]" value="<?php echo $lang_ids[1]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Tìm kiếm sản phẩm <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[2]" value="<?php echo $lang_ids[2]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Tìm kiếm <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[3]" value="<?php echo $lang_ids[3]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label"> Gửi <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[4]" value="<?php echo $lang_ids[4]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label"> Cập nhật <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[5]" value="<?php echo $lang_ids[5]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Đọc thêm <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[6]" value="<?php echo $lang_ids[6]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Hàng loạt <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[7]" value="<?php echo $lang_ids[7]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Ảnh <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[8]" value="<?php echo $lang_ids[8]; ?>">
                    </div>
                </div>
            </div>
        </div>

        <h3 style="font-size:20px;font-weight:500;">Đăng nhập</h3>
		<div class="box box-info">
            <div class="box-body">
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Đăng nhập <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[9]" value="<?php echo $lang_ids[9]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Khách hàng đăng nhập <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[10]" value="<?php echo $lang_ids[10]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Click ở đây để Đăng nhập<span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[11]" value="<?php echo $lang_ids[11]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Trở lại trang Đăng nhập <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[12]" value="<?php echo $lang_ids[12]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Đã đăng nhập <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[13]" value="<?php echo $lang_ids[13]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Đăng xuất<span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[14]" value="<?php echo $lang_ids[14]; ?>">
                    </div>
                </div>
            </div>
        </div>
		
		<h3 style="font-size:20px;font-weight:500;">Đăng ký</h3>
        <div class="box box-info">
            <div class="box-body">
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Đăng ký <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[15]" value="<?php echo $lang_ids[15]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Khách hàng đăng ký <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[16]" value="<?php echo $lang_ids[16]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Đăng ký thành công<span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[17]" value="<?php echo $lang_ids[17]; ?>">
                    </div>
                </div>
            </div>
        </div>
		
		<h3 style="font-size:20px;font-weight:500;">Giỏ hàng và Thanh toán</h3>
        <div class="box box-info">
            <div class="box-body">
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Giỏ hàng <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[18]" value="<?php echo $lang_ids[18]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Xem Giỏ hàng <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[19]" value="<?php echo $lang_ids[19]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Cập nhật Giỏ hàng <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[20]" value="<?php echo $lang_ids[20]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Thêm vào Giỏ hàng <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[154]" value="<?php echo $lang_ids[154]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Quay về Giỏ hàng <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[21]" value="<?php echo $lang_ids[21]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Thanh toán<span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[22]" value="<?php echo $lang_ids[22]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Tiến hành thanh toán <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[23]" value="<?php echo $lang_ids[23]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Vui lòng đăng nhập để thanh toán <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[160]" value="<?php echo $lang_ids[160]; ?>">
                    </div>
                </div>

            </div>
        </div>

		<h3 style="font-size:20px;font-weight:500;">Thanh toán</h3>
        <div class="box box-info">
            <div class="box-body">
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Đơn hàng <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[24]" value="<?php echo $lang_ids[24]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Lịch sử mua hàng <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[25]" value="<?php echo $lang_ids[25]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Chi tiết đơn hàng <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[26]" value="<?php echo $lang_ids[26]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Ngày và giờ thanh toán <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[27]" value="<?php echo $lang_ids[27]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Mã giao dịch <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[28]" value="<?php echo $lang_ids[28]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Số tiền đã thanh toán <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[29]" value="<?php echo $lang_ids[29]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Trạng thái thanh toán <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[30]" value="<?php echo $lang_ids[30]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Phương thức thanh toán <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[31]" value="<?php echo $lang_ids[31]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Mã số thanh toán<span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[32]" value="<?php echo $lang_ids[32]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Phần thanh toán <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[33]" value="<?php echo $lang_ids[33]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Lựa chọn Phương thức thanh toán<span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[34]" value="<?php echo $lang_ids[34]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Lựa chọn 1 phương thức<span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[35]" value="<?php echo $lang_ids[35]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">PayPal <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[36]" value="<?php echo $lang_ids[36]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Stripe <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[37]" value="<?php echo $lang_ids[37]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Ngân hàng<span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[38]" value="<?php echo $lang_ids[38]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Số thẻ <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[39]" value="<?php echo $lang_ids[39]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">CVV <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[40]" value="<?php echo $lang_ids[40]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Tháng <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[41]" value="<?php echo $lang_ids[41]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Năm <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[42]" value="<?php echo $lang_ids[42]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Gửi Chi tiết <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[43]" value="<?php echo $lang_ids[43]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Thông tin giao dịch <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[44]" value="<?php echo $lang_ids[44]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Bao gồm ID giao dịch và thông tin khác một cách chính xác<span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[45]" value="<?php echo $lang_ids[45]; ?>">
                    </div>
                </div>				
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Thanh toán ngay <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[46]" value="<?php echo $lang_ids[46]; ?>">
                    </div>
                </div>
            </div>
        </div>
		
		<h3 style="font-size:20px;font-weight:500;">Sản phẩm</h3>
        <div class="box box-info">
            <div class="box-body">				
                
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Tên sản phẩm<span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[47]" value="<?php echo $lang_ids[47]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Chi tiết sản phẩm <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[48]" value="<?php echo $lang_ids[48]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Sản phẩm liên quan <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[155]" value="<?php echo $lang_ids[155]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Xem tất cả các sản phẩm liên quan bên dưới <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[156]" value="<?php echo $lang_ids[156]; ?>">
                    </div>
                </div>			
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Danh mục sản phẩm <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[49]" value="<?php echo $lang_ids[49]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Danh mục <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[50]" value="<?php echo $lang_ids[50]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Tất cả sản phẩm dưới<span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[51]" value="<?php echo $lang_ids[51]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Lựa chọn kích cỡ <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[52]" value="<?php echo $lang_ids[52]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Kích cỡ<span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[157]" value="<?php echo $lang_ids[157]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Lựa chọn màu sắc <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[53]" value="<?php echo $lang_ids[53]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Màu sắc <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[158]" value="<?php echo $lang_ids[158]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Giá <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[159]" value="<?php echo $lang_ids[159]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Giá Sản phẩm <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[54]" value="<?php echo $lang_ids[54]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Số lượng<span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[55]" value="<?php echo $lang_ids[55]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Hết hàng <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[56]" value="<?php echo $lang_ids[56]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Chia sẻ <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[57]" value="<?php echo $lang_ids[57]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Chia sẻ sản phẩm này <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[58]" value="<?php echo $lang_ids[58]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Mô tả sản phẩm <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[59]" value="<?php echo $lang_ids[59]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Không tìm thấy sản phẩm <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[153]" value="<?php echo $lang_ids[153]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Tính năng<span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[60]" value="<?php echo $lang_ids[60]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Điều kiện <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[61]" value="<?php echo $lang_ids[61]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Chính sách đổi trả <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[62]" value="<?php echo $lang_ids[62]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Những đánh giá <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[63]" value="<?php echo $lang_ids[63]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Đánh giá<span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[64]" value="<?php echo $lang_ids[64]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Để lại đánh giá<span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[65]" value="<?php echo $lang_ids[65]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Viết bình luận của bạn (Tùy chọn) <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[66]" value="<?php echo $lang_ids[66]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Gửi đánh giá <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[67]" value="<?php echo $lang_ids[67]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Bạn đã đánh giá rồi! <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[68]" value="<?php echo $lang_ids[68]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Đánh giá đã được gửi thành công! <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[163]" value="<?php echo $lang_ids[163]; ?>">
                    </div>
                </div>	
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Bạn phải đăng nhập để đưa ra đánh giá <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[69]" value="<?php echo $lang_ids[69]; ?>">
                    </div>
                </div>					
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Không tìm thấy mô tả <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[70]" value="<?php echo $lang_ids[70]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Không tìm thấy tính năng nào <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[71]" value="<?php echo $lang_ids[71]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Không tìm thấy điều kiện <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[72]" value="<?php echo $lang_ids[72]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Không tìm thấy chính sách đổi trả<span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[73]" value="<?php echo $lang_ids[73]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Không tìm thấy bài đánh giá  <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[74]" value="<?php echo $lang_ids[74]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Tên khách hàng <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[75]" value="<?php echo $lang_ids[75]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Bình luận<span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[76]" value="<?php echo $lang_ids[76]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Những bình luận <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[77]" value="<?php echo $lang_ids[77]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Đánh giá<span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[78]" value="<?php echo $lang_ids[78]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Trước đó<span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[79]" value="<?php echo $lang_ids[79]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Tiếp theo <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[80]" value="<?php echo $lang_ids[80]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Tổng cộng <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[81]" value="<?php echo $lang_ids[81]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Tổng <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[82]" value="<?php echo $lang_ids[82]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Hành động<span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[83]" value="<?php echo $lang_ids[83]; ?>">
                    </div>
                </div>
            </div>
        </div>
		
		<h3 style="font-size:20px;font-weight:500;">Thanh toán và Vận chuyển</h3>
        <div class="box box-info">
            <div class="box-body">
            	<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Phí vận chuyển<span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[84]" value="<?php echo $lang_ids[84]; ?>">
                    </div>
                </div>
            	<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Đang vận chuyển<span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[85]" value="<?php echo $lang_ids[85]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Địa chỉ thanh toán<span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[161]" value="<?php echo $lang_ids[161]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Cập nhật địa chỉ thanh toán <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[86]" value="<?php echo $lang_ids[86]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Địa chỉ giao hàng <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[162]" value="<?php echo $lang_ids[162]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Cập nhật địa chỉ giao hàng <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[87]" value="<?php echo $lang_ids[87]; ?>">
                    </div>
                </div>				
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Cập nhật thông tin thanh toán và vận chuyển <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[88]" value="<?php echo $lang_ids[88]; ?>">
                    </div>
                </div>				
            </div>
        </div>
		
		<h3 style="font-size:20px;font-weight:500;">Bảng điều khiển</h3>
        <div class="box box-info">
            <div class="box-body">
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Bảng điều khiển <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[89]" value="<?php echo $lang_ids[89]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Chào mừng đến với Bảng điều khiển <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[90]" value="<?php echo $lang_ids[90]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Quay lại Bảng điều khiển<span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[91]" value="<?php echo $lang_ids[91]; ?>">
                    </div>
                </div>
            </div>
        </div>
		

		<h3 style="font-size:20px;font-weight:500;">Theo dõi</h3>
        <div class="box box-info">
            <div class="box-body">
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Theo dõi <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[92]" value="<?php echo $lang_ids[92]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Đăng ký nhận bản tin của chúng tôi <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[93]" value="<?php echo $lang_ids[93]; ?>">
                    </div>
                </div>
            </div>
        </div>
		
		<h3 style="font-size:20px;font-weight:500;">Địa chỉ email</h3>
        <div class="box box-info">
            <div class="box-body">
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Địa chỉ email <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[94]" value="<?php echo $lang_ids[94]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Nhập email của bạn <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[95]" value="<?php echo $lang_ids[95]; ?>">
                    </div>
                </div>
            </div>
        </div>
		
		<h3 style="font-size:20px;font-weight:500;">Mật khẩu</h3>
        <div class="box box-info">
            <div class="box-body">
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Mật khẩu <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[96]" value="<?php echo $lang_ids[96]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Quên mật khẩu<span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[97]" value="<?php echo $lang_ids[97]; ?>">
                    </div>
                </div>				
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Nhập lại mật khẩu<span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[98]" value="<?php echo $lang_ids[98]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Cập nhật mật khẩu<span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[99]" value="<?php echo $lang_ids[99]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Mật khẩu mới<span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[100]" value="<?php echo $lang_ids[100]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Nhập lại mật khẩu<span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[101]" value="<?php echo $lang_ids[101]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Thay đổi mật khẩu<span>*</span></label>
                    <div class="col-sm-6">
                        <textarea name="lang_value[149]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_ids[149]; ?></textarea>
                    </div>
                </div>
            </div>
        </div>

       
		
		<h3 style="font-size:20px;font-weight:500;">Khách hàng</h3>
        <div class="box box-info">
            <div class="box-body">
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Tên đầy đủ <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[102]" value="<?php echo $lang_ids[102]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Tên công ty<span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[103]" value="<?php echo $lang_ids[103]; ?>">
                    </div>
                </div>                
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Số điện thoại<span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[104]" value="<?php echo $lang_ids[104]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Địa chỉ<span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[105]" value="<?php echo $lang_ids[105]; ?>">
                    </div>
                </div>               
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Quốc gia <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[106]" value="<?php echo $lang_ids[106]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Thành phố <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[107]" value="<?php echo $lang_ids[107]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Quận <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[108]" value="<?php echo $lang_ids[108]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Mã bưu chính<span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[109]" value="<?php echo $lang_ids[109]; ?>">
                    </div>
                </div>
            </div>
        </div>
		
		<h3 style="font-size:20px;font-weight:500;">Thông tin khác</h3>
        <div class="box box-info">
            <div class="box-body">
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Về chúng tôi <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[110]" value="<?php echo $lang_ids[110]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Bài viết nổi bật <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[111]" value="<?php echo $lang_ids[111]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Bài viết phổ biến <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[112]" value="<?php echo $lang_ids[112]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Bài viết gần đây <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[113]" value="<?php echo $lang_ids[113]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Liên hệ <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[114]" value="<?php echo $lang_ids[114]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Biểu mẫu liên hệ <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[115]" value="<?php echo $lang_ids[115]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Văn phòng của chúng tôi<span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[116]" value="<?php echo $lang_ids[116]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Cập nhật hồ sơ <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[117]" value="<?php echo $lang_ids[117]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Gửi tin nhắn <span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[118]" value="<?php echo $lang_ids[118]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Tin nhắn<span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[119]" value="<?php echo $lang_ids[119]; ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Tìm Chúng Tôi Trên Bản Đồ<span>*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lang_value[120]" value="<?php echo $lang_ids[120]; ?>">
                    </div>
                </div>
            </div>
        </div>


        
        

        <h3 style="font-size:20px;font-weight:500;">Thông báo lỗi</h3>
        <div class="box box-info">
            <div class="box-body">
            	<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Xin chúc mừng! Thanh toán thành công. <span>*</span></label>
                    <div class="col-sm-6">
                        <textarea name="lang_value[121]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_ids[121]; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Thông tin thanh toán và vận chuyển đã được cập nhật thành công.<span>*</span></label>
                    <div class="col-sm-6">
                        <textarea name="lang_value[122]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_ids[122]; ?></textarea>
                    </div>
                </div>
            	<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Tên khách hàng không được để trống <span>*</span></label>
                    <div class="col-sm-6">
                        <textarea name="lang_value[123]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_ids[123]; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Số điện thoại không được để trống <span>*</span></label>
                    <div class="col-sm-6">
                        <textarea name="lang_value[124]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_ids[124]; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Địa chỉ không được để trống <span>*</span></label>
                    <div class="col-sm-6">
                        <textarea name="lang_value[125]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_ids[125]; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Bạn phải chọn một quốc gia <span>*</span></label>
                    <div class="col-sm-6">
                        <textarea name="lang_value[126]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_ids[126]; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Thành phố không được để trống <span>*</span></label>
                    <div class="col-sm-6">
                        <textarea name="lang_value[127]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_ids[127]; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Quận không được để trống <span>*</span></label>
                    <div class="col-sm-6">
                        <textarea name="lang_value[128]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_ids[128]; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Mã bưu chính không được để trống <span>*</span></label>
                    <div class="col-sm-6">
                        <textarea name="lang_value[129]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_ids[129]; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Thông tin hồ sơ cập nhật thành công <span>*</span></label>
                    <div class="col-sm-6">
                        <textarea name="lang_value[130]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_ids[130]; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Email không được để trống <span>*</span></label>
                    <div class="col-sm-6">
                        <textarea name="lang_value[131]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_ids[131]; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Email hoặc Mật khẩu không được để trống. <span>*</span></label>
                    <div class="col-sm-6">
                        <textarea name="lang_value[132]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_ids[132]; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Địa chỉ email không đúng <span>*</span></label>
                    <div class="col-sm-6">
                        <textarea name="lang_value[133]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_ids[133]; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Địa chỉ email phải hợp lệ. <span>*</span></label>
                    <div class="col-sm-6">
                        <textarea name="lang_value[134]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_ids[134]; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Địa chỉ email đã tồn tại. <span>*</span></label>
                    <div class="col-sm-6">
                        <textarea name="lang_value[147]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_ids[147]; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Địa chỉ email của bạn không có trong hệ thống của chúng tôi. <span>*</span></label>
                    <div class="col-sm-6">
                        <textarea name="lang_value[135]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_ids[135]; ?></textarea>
                    </div>
                </div>                
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Vui lòng kiểm tra email và xác nhận đăng ký của bạn. <span>*</span></label>
                    <div class="col-sm-6">
                        <textarea name="lang_value[136]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_ids[136]; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Email của bạn đã được xác minh thành công. Bây giờ bạn có thể đăng nhập vào trang web của chúng tôi. <span>*</span></label>
                    <div class="col-sm-6">
                        <textarea name="lang_value[137]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_ids[137]; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Mật khẩu không được để trống <span>*</span></label>
                    <div class="col-sm-6">
                        <textarea name="lang_value[138]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_ids[138]; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Mật khẩu không đúng<span>*</span></label>
                    <div class="col-sm-6">
                        <textarea name="lang_value[139]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_ids[139]; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Vui lòng nhập mật khẩu mới và nhập lại mật khẩu. <span>*</span></label>
                    <div class="col-sm-6">
                        <textarea name="lang_value[140]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_ids[140]; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Mật khẩu đã được cập nhật thành công. <span>*</span></label>
                    <div class="col-sm-6">
                        <textarea name="lang_value[141]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_ids[141]; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Để đặt lại mật khẩu, vui lòng nhấp vào liên kết bên dưới. <span>*</span></label>
                    <div class="col-sm-6">
                        <textarea name="lang_value[142]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_ids[142]; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">YÊU CẦU ĐẶT LẠI MẬT KHẨU - WEBSITE.COM CỦA BẠN<span>*</span></label>
                    <div class="col-sm-6">
                        <textarea name="lang_value[143]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_ids[143]; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Thời gian gửi email đặt lại mật khẩu (24 giờ) đã hết hạn. Vui lòng thử đặt lại mật khẩu của bạn một lần nữa. <span>*</span></label>
                    <div class="col-sm-6">
                        <textarea name="lang_value[144]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_ids[144]; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Một liên kết xác nhận sẽ được gửi đến địa chỉ email của bạn. Bạn sẽ nhận được thông tin đặt lại mật khẩu ở đó.<span>*</span></label>
                    <div class="col-sm-6">
                        <textarea name="lang_value[145]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_ids[145]; ?></textarea>
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-4 control-label">Mật khẩu đã được đặt lại thành công. Bây giờ bạn có thể đăng nhập. <span>*</span></label>
                    <div class="col-sm-6">
                        <textarea name="lang_value[146]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_ids[146]; ?></textarea>
                    </div>
                </div>    
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Xin lỗi! Tài khoản của bạn không hoạt động. Vui lòng liên hệ với quản trị viên.<span>*</span></label>
                    <div class="col-sm-6">
                        <textarea name="lang_value[148]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_ids[148]; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Email xác nhận đăng ký cho TRANG WEB CỦA BẠN. <span>*</span></label>
                    <div class="col-sm-6">
                        <textarea name="lang_value[150]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_ids[150]; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Cảm ơn bạn đã đăng ký! Tài khoản của bạn đã được tạo. Để kích hoạt tài khoản của bạn, hãy nhấp vào liên kết bên dưới: <span>*</span></label>
                    <div class="col-sm-6">
                        <textarea name="lang_value[151]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_ids[151]; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Đăng ký của bạn đã hoàn tất. Vui lòng kiểm tra địa chỉ email của bạn để làm theo quy trình xác nhận đăng ký của bạn. <span>*</span></label>
                    <div class="col-sm-6">
                        <textarea name="lang_value[152]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_ids[152]; ?></textarea>
                    </div>
                </div>
                              
            </div>
        </div>



        <div class="box box-info">
            <div class="box-body">
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label"></label>
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