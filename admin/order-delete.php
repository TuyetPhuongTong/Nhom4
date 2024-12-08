<?php require_once('header.php'); ?>

<?php
if(!isset($_REQUEST['id'])) {
	 // Nếu không có tham số 'id' trong yêu cầu, chuyển hướng đến trang đăng xuất
	header('location: logout.php');
	exit;
} else {
	// Kiểm tra xem id có hợp lệ hay không
	$statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		// Nếu không tìm thấy, chuyển hướng đến trang đăng xuất
		header('location: logout.php');
		exit;
	} else {
		// Lấy dữ liệu liên quan đến thanh toán
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
		foreach ($result as $row) {
			$payment_id = $row['payment_id'];
			$payment_status = $row['payment_status'];
			$shipping_status = $row['shipping_status'];
		}
	}
}
?>

<?php
// Nếu thanh toán và vận chuyển đã hoàn tất, không hoàn lại số lượng sản phẩm
	if( ($payment_status == 'Completed') && ($shipping_status == 'Completed') ):
		// Không hoàn lại số lượng sản phẩm
	else:
		// Hoàn lại số lượng sản phẩm vào kho
		$statement = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
		$statement->execute(array($payment_id));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
		foreach ($result as $row) {
			$statement1 = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
			$statement1->execute(array($row['product_id']));
			$result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);							
			foreach ($result1 as $row1) {
				$p_qty = $row1['p_qty'];
			}
			$final = $p_qty + $row['quantity'];
			$statement1 = $pdo->prepare("UPDATE tbl_product SET p_qty=? WHERE p_id=?");
			$statement1->execute(array($final,$row['product_id']));
		}	
	endif;	

	// Xóa dữ liệu liên quan khỏi bảng tbl_order
	$statement = $pdo->prepare("DELETE FROM tbl_order WHERE payment_id=?");
	$statement->execute(array($payment_id));

	// Xóa dữ liệu thanh toán khỏi bảng tbl_payment
	$statement = $pdo->prepare("DELETE FROM tbl_payment WHERE id=?");
	$statement->execute(array($_REQUEST['id']));
    // Chuyển hướng đến trang đơn hàng
	header('location: order.php');
?>//