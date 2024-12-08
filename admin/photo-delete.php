<?php require_once('header.php'); ?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Kiểm tra xem id có hợp lệ không
	$statement = $pdo->prepare("SELECT * FROM tbl_photo WHERE id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
	
// Lấy ID ảnh để xóa khỏi thư mục
$statement = $pdo->prepare("SELECT * FROM tbl_photo WHERE id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
	$photo = $row['photo'];
}

// Xóa ảnh khỏi thư mục
if($photo!='') {
	unlink('../assets/uploads/'.$photo);
}

// Xóa ảnh khỏi bảng tbl_photo
$statement = $pdo->prepare("DELETE FROM tbl_photo WHERE id=?");
$statement->execute(array($_REQUEST['id']));

header('location: photo.php');
?>
/HIHI