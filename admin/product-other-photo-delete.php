<?php require_once('header.php'); ?>

<?php
// Kiểm tra xem tham số `id` và `id1` có được gửi qua URL không
if( !isset($_REQUEST['id']) || !isset($_REQUEST['id1']) ) {
	header('location: logout.php');
	exit;
} else {
	// Kiểm tra tính hợp lệ của `id`
	$statement = $pdo->prepare("SELECT * FROM tbl_product_photo WHERE pp_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');// Nếu `id` không hợp lệ, chuyển hướng đến trang đăng xuất
		exit;
	}
}
?>

<?php

	// Lấy thông tin ảnh cần xóa khỏi thư mục
	$statement = $pdo->prepare("SELECT * FROM tbl_product_photo WHERE pp_id=?");
	$statement->execute(array($_REQUEST['id']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) {
		$photo = $row['photo'];// Lấy tên file ảnh
	}

	// Xóa ảnh khỏi thư mục
	if($photo!='') {
		unlink('../assets/uploads/product_photos/'.$photo);	
	}

	// Xóa ảnh khỏi cơ sở dữ liệu tbl_testimonial
	$statement = $pdo->prepare("DELETE FROM tbl_product_photo WHERE pp_id=?");
	$statement->execute(array($_REQUEST['id']));
    // Chuyển hướng quay lại trang chỉnh sửa sản phẩm
	header('location: product-edit.php?id='.$_REQUEST['id1']);
?>//HIHI