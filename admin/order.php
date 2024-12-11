<?php require_once('header.php'); ?>

<?php
$error_message = '';
if(isset($_POST['form1'])) {
    $valid = 1;
    if(empty($_POST['subject_text'])) {
        $valid = 0;
        $error_message .= 'Tiêu đề không được để trống\n';
    }
    if(empty($_POST['message_text'])) {
        $valid = 0;
        $error_message .= 'Nội dung tin nhắn không được để trống\n';
    }
    if($valid == 1) {

        $subject_text = strip_tags($_POST['subject_text']);
        $message_text = strip_tags($_POST['message_text']);

        // Lấy email của khách hàng
        $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=?");
        $statement->execute(array($_POST['cust_id']));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        foreach ($result as $row) {
            $cust_email = $row['cust_email'];
        }

         // Lấy email quản trị viên
        $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        foreach ($result as $row) {
            $admin_email = $row['contact_email'];
        }

        $order_detail = '';
        $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_id=?");
        $statement->execute(array($_POST['payment_id']));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        foreach ($result as $row) {
        	
        	if($row['payment_method'] == 'PayPal'):
        		$payment_details = '
Mã giao dịch:  '.$row['txnid'].'<br>
        		';
        	elseif($row['payment_method'] == 'Stripe'):
				$payment_details = '
Mã giao dịch:  '.$row['txnid'].'<br>
Số thẻ:  '.$row['card_number'].'<br>
CVV thẻ:'.$row['card_cvv'].'<br>
Tháng hết hạn: '.$row['card_month'].'<br>
Năm hết hạn: '.$row['card_year'].'<br>
        		';
        	elseif($row['payment_method'] == 'Bank Deposit'):
				$payment_details = '
Chi tiết giao dịch: <br>'.$row['bank_transaction_info'];
        	endif;

            $order_detail .= '
Tên khách hàng: '.$row['customer_name'].'<br>
Email khách hàng: '.$row['customer_email'].'<br>
Phương thức thanh toán: '.$row['payment_method'].'<br>
Ngày thanh toán:'.$row['payment_date'].'<br>
Chi tiết thanh toán: <br>'.$payment_details.'<br>
Số tiền đã thanh toán: '.$row['paid_amount'].'<br>
Trạng thái thanh toán: '.$row['payment_status'].'<br>
Trạng thái vận chuyển: '.$row['shipping_status'].'<br>
Mã thanh toán:'.$row['payment_id'].'<br>
            ';
        }

        $i=0;
        $statement = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
        $statement->execute(array($_POST['payment_id']));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        foreach ($result as $row) {
            $i++;
            $order_detail .= '
<br><b><u>Product Item '.$i.'</u></b><br>
Tên sản phẩm: '.$row['product_name'].'<br>
Kích thước: '.$row['size'].'<br>
Độ đậm Cacao: '.$row['color'].'<br>
Số lượng: '.$row['quantity'].'<br>
Giá mỗi sản phẩm: '.$row['unit_price'].'<br>
            ';
        }

        $statement = $pdo->prepare("INSERT INTO tbl_customer_message (subject,message,order_detail,cust_id) VALUES (?,?,?,?)");
        $statement->execute(array($subject_text,$message_text,$order_detail,$_POST['cust_id']));

        // Gửi email
        $to_customer = $cust_email;
        $message = '
<html><body>
<h3>Nội dung tin nhắn:  </h3>
'.$message_text.'
<h3>Chi tiết đơn hàng: </h3>
'.$order_detail.'
</body></html>
';
        $headers = 'From: ' . $admin_email . "\r\n" .
                   'Reply-To: ' . $admin_email . "\r\n" .
                   'X-Mailer: PHP/' . phpversion() . "\r\n" . 
                   "MIME-Version: 1.0\r\n" . 
                   "Content-Type: text/html; charset=ISO-8859-1\r\n";

       // Gửi email tới khách hàng                
        mail($to_customer, $subject_text, $message, $headers);
        
        $success_message = 'Email đã được gửi thành công tới khách hàng.';

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

<section class="content-header">
	<div class="content-header-left">
		<h1>Xem Đơn Hàng</h1>
	</div>
</section>


<section class="content">

  <div class="row">
    <div class="col-md-12">


      <div class="box box-info">
        
        <div class="box-body table-responsive">
          <table id="example1" class="table table-bordered table-hover table-striped">
			<thead>
			    <tr>
			        <th>#</th>
                    <th>Khách Hàng</th>
			        <th>Chi Tiết Sản Phẩm</th>
                    <th>
                    Thông Tin Thanh Toánn
                    </th>
                    <th>Số Tiền Đã Thanh Toán</th>
                    <th>Trạng Thái Thanh Toán</th>
                    <th>Trạng Thái Giao Hàng</th>
			        <th>Hành Động</th>
			    </tr>
			</thead>
            <tbody>
            	<?php
            	$i=0;
            	$statement = $pdo->prepare("SELECT * FROM tbl_payment ORDER by id DESC");
            	$statement->execute();
            	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
            	foreach ($result as $row) {
            		$i++;
            		?>
					<tr class="<?php if($row['payment_status']=='Pending'){echo 'bg-r';}else{echo 'bg-g';} ?>">
	                    <td><?php echo $i; ?></td>
	                    <td>
                            <b>Mã KH:</b> <?php echo $row['customer_id']; ?><br>
                            <b>Tên:</b><br> <?php echo $row['customer_name']; ?><br>
                            <b>Email:</b><br> <?php echo $row['customer_email']; ?><br><br>
                            <a href="#" data-toggle="modal" data-target="#model-<?php echo $i; ?>"class="btn btn-warning btn-xs" style="width:100%;margin-bottom:4px;">Gửi Tin Nhắn</a>
                            <div id="model-<?php echo $i; ?>" class="modal fade" role="dialog">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title" style="font-weight: bold;">Gửi Tin Nhắn</h4>
										</div>
										<div class="modal-body" style="font-size: 14px">
											<form action="" method="post">
                                                <input type="hidden" name="cust_id" value="<?php echo $row['customer_id']; ?>">
                                                <input type="hidden" name="payment_id" value="<?php echo $row['payment_id']; ?>">
												<table class="table table-bordered">
													<tr>
														<td>Chủ Đề</td>
														<td>
                                                            <input type="text" name="subject_text" class="form-control" style="width: 100%;">
														</td>
													</tr>
                                                    <tr>
                                                        <td>Nội Dung</td>
                                                        <td>
                                                            <textarea name="message_text" class="form-control" cols="30" rows="10" style="width:100%;height: 200px;"></textarea>
                                                        </td>
                                                    </tr>
													<tr>
														<td></td>
														<td><input type="submit" value="Gửi Tin Nhắn" name="form1"></td>
													</tr>
												</table>
											</form>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
										</div>
									</div>
								</div>
							</div>
                        </td>
                        <td>
                           <?php
                           $statement1 = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
                           $statement1->execute(array($row['payment_id']));
                           $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                           foreach ($result1 as $row1) {
                                echo '<b>Sản phẩm:</b> '.$row1['product_name'];
                                echo '<br>(<b>Kích thước:</b> '.$row1['size'];
                                echo ', <b>Độ đậm Cacao:</b> '.$row1['color'].')';
                                echo '<br>(<b>Số lượng:</b> '.$row1['quantity'];
                                echo ', <b>Đơn giá:</b> '.$row1['unit_price'].')';
                                echo '<br><br>';
                           }
                           ?>
                        </td>
                        <td>
                        	<?php if($row['payment_method'] == 'PayPal'): ?>
                        		<b>Phương Thức Thanh Toán:</b> <?php echo '<span style="color:red;"><b>'.$row['payment_method'].'</b></span>'; ?><br>
                        		<b>Mã Thanh Toán:</b> <?php echo $row['payment_id']; ?><br>
                        		<b>Ngày:</b> <?php echo $row['payment_date']; ?><br>
                        		<b>Mã Giao Dịch:</b> <?php echo $row['txnid']; ?><br>
                        	<?php elseif($row['payment_method'] == 'Stripe'): ?>
                        		<b>Phương Thức Thanh Toán:</b> <?php echo '<span style="color:red;"><b>'.$row['payment_method'].'</b></span>'; ?><br>
                        		<b>Mã Thanh Toán:</b> <?php echo $row['payment_id']; ?><br>
								<b>Ngày:</b> <?php echo $row['payment_date']; ?><br>
                        		<b>Mã Giao Dịch:</b> <?php echo $row['txnid']; ?><br>
                        		<b>Số Thẻ:</b> <?php echo $row['card_number']; ?><br>
                        		<b>Mã CVV:</b> <?php echo $row['card_cvv']; ?><br>
                        		<b>Tháng Hết Hạn:</b> <?php echo $row['card_month']; ?><br>
                        		<b>Năm Hết Hạn:</b> <?php echo $row['card_year']; ?><br>
                        	<?php elseif($row['payment_method'] == 'Bank Deposit'): ?>
                        		<b>Phương Thức Thanh Toán:</b> <?php echo '<span style="color:red;"><b>'.$row['payment_method'].'</b></span>'; ?><br>
                        		<b>Mã Thanh Toán:</b> <?php echo $row['payment_id']; ?><br>
								<b>Ngày:</b> <?php echo $row['payment_date']; ?><br>
                        		<b>Thông Tin Giao Dịch:</b> <br><?php echo $row['bank_transaction_info']; ?><br>
                        	<?php endif; ?>
                        </td>
                        <td><?php echo $row['paid_amount']; ?>₫</td>
                        <td>
                            <?php echo $row['payment_status']; ?>
                            <br><br>
                            <?php
                                if($row['payment_status']=='Pending'){
                                    ?>
                                    <a href="order-change-status.php?id=<?php echo $row['id']; ?>&task=Completed" class="btn btn-success btn-xs" style="width:100%;margin-bottom:4px;">Đánh Dấu Hoàn Thành</a>
                                    <?php
                                }
                            ?>
                        </td>
                        <td>
                            <?php echo $row['shipping_status']; ?>
                            <br><br>
                            <?php
                            if($row['payment_status']=='Completed') {
                                if($row['shipping_status']=='Pending'){
                                    ?>
                                    <a href="shipping-change-status.php?id=<?php echo $row['id']; ?>&task=Completed" class="btn btn-warning btn-xs" style="width:100%;margin-bottom:4px;">Đánh Dấu Hoàn Thành</a>
                                    <?php
                                }
                            }
                            ?>
                        </td>
	                    <td>
                            <a href="#" class="btn btn-danger btn-xs" data-href="order-delete.php?id=<?php echo $row['id']; ?>" data-toggle="modal" data-target="#confirm-delete" style="width:100%;">Xóa</a>
	                    </td>
	                </tr>
            		<?php
            	}
            	?>
            </tbody>
          </table>
        </div>
      </div>
  

</section>


<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Xác Nhận Xóa</h4>
            </div>
            <div class="modal-body">
            Bạn có chắc chắn muốn xóa mục này không?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                <a class="btn btn-danger btn-ok">Xóa</a>
            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php'); ?>
