<?php require_once('header.php'); ?>

<?php
// Ngăn chặn truy cập trực tiếp vào trang này.
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Kiểm tra xem id có hợp lệ hay không
	$statement = $pdo->prepare("SELECT * FROM tbl_color WHERE color_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
?>

<?php

	// Xóa khỏi bảng tbl_color
	$statement = $pdo->prepare("DELETE FROM tbl_color WHERE color_id=?");
	$statement->execute(array($_REQUEST['id']));

	header('location: color.php');
?>
