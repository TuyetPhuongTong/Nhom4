<?php require_once('header.php'); ?>

<?php
// Ngăn chặn truy cập trực tiếp vào trang này.
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Kiểm tra xem ID có hợp lệ không
	$statement = $pdo->prepare("SELECT * FROM tbl_country WHERE country_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
?>

<?php

	// Xóa khỏi bảng tbl_country
	$statement = $pdo->prepare("DELETE FROM tbl_country WHERE country_id=?");
	$statement->execute(array($_REQUEST['id']));

	header('location: country.php');
?>
