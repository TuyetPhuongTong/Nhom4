<?php require_once('header.php'); ?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Kiểm tra ID có hợp lệ không
	$statement = $pdo->prepare("SELECT * FROM tbl_faq WHERE faq_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
?>

<?php
	// Xóa khỏi tbl_faq
	$statement = $pdo->prepare("DELETE FROM tbl_faq WHERE faq_id=?");
	$statement->execute(array($_REQUEST['id']));

	header('location: faq.php');
?>
