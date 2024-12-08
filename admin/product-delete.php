<?php require_once('header.php'); ?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Kiểm tra ID có hợp lệ không
	$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
?>

<?php
	// Lấy ID ảnh để xóa khỏi thư mục
	$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
	$statement->execute(array($_REQUEST['id']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) {
		$p_featured_photo = $row['p_featured_photo'];
		unlink('../assets/uploads/'.$p_featured_photo);
	}

	// Lấy ID ảnh khác để xóa khỏi thư mục
	$statement = $pdo->prepare("SELECT * FROM tbl_product_photo WHERE p_id=?");
	$statement->execute(array($_REQUEST['id']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) {
		$photo = $row['photo'];
		unlink('../assets/uploads/product_photos/'.$photo);
	}


	// Xóa trong bảng tbl_photo
	$statement = $pdo->prepare("DELETE FROM tbl_product WHERE p_id=?");
	$statement->execute(array($_REQUEST['id']));

	// Xóa trong bảng tbl_product_photo
	$statement = $pdo->prepare("DELETE FROM tbl_product_photo WHERE p_id=?");
	$statement->execute(array($_REQUEST['id']));

	// Xóa trong bảng tbl_product_size
	$statement = $pdo->prepare("DELETE FROM tbl_product_size WHERE p_id=?");
	$statement->execute(array($_REQUEST['id']));

	// Xóa trong bảng tbl_product_color
	$statement = $pdo->prepare("DELETE FROM tbl_product_color WHERE p_id=?");
	$statement->execute(array($_REQUEST['id']));

	// Xóa trong bảng tbl_rating
	$statement = $pdo->prepare("DELETE FROM tbl_rating WHERE p_id=?");
	$statement->execute(array($_REQUEST['id']));

	// Xóa trong bảng tbl_payment
	$statement = $pdo->prepare("SELECT * FROM tbl_order WHERE product_id=?");
	$statement->execute(array($_REQUEST['id']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) {
		$statement1 = $pdo->prepare("DELETE FROM tbl_payment WHERE payment_id=?");
		$statement1->execute(array($row['payment_id']));
	}

	// Xóa trong bảng tbl_order
	$statement = $pdo->prepare("DELETE FROM tbl_order WHERE product_id=?");
	$statement->execute(array($_REQUEST['id']));

	header('location: product.php');
?>
