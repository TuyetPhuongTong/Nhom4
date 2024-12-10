<?php
require_once('header.php');

// Kiểm tra nếu `id` không tồn tại
if(!isset($_REQUEST['id'])) {
    header('location: logout.php');
    exit;
} else {
    // Lấy thông tin bài viết từ `post_id`
    $statement = $pdo->prepare("SELECT * FROM tbl_post WHERE post_id=?");
    $statement->execute(array($_REQUEST['id']));
    $total = $statement->rowCount();
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    if($total == 0) {
        // Nếu không tìm thấy bài viết, chuyển hướng về trang khác
        header('location: logout.php');
        exit;
    } else {
        // Lưu thông tin ảnh của bài viết nếu có
        $photo = $result['photo'];
    }
}

// Xóa bài viết
$statement = $pdo->prepare("DELETE FROM tbl_post WHERE post_id=?");
$statement->execute(array($_REQUEST['id']));

// Xóa ảnh nếu tồn tại
if($photo != '' && file_exists('uploads/'.$photo)) {
    unlink('uploads/'.$photo);
}

// Chuyển hướng về trang danh sách bài viết với thông báo thành công
header('location: post.php?message=delete_success');
exit;

?>
