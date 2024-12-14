<?php
// Thông tin kết nối cơ sở dữ liệu
$host = 'localhost'; // Địa chỉ máy chủ cơ sở dữ liệu
$dbname = 'ecommerceweb'; // Tên cơ sở dữ liệu
$username = 'root'; // Tên người dùng MySQL
$password = ''; // Mật khẩu của MySQL, nếu root không có mật khẩu

try {
    // Kết nối đến cơ sở dữ liệu MySQL sử dụng PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Thiết lập chế độ báo lỗi cho PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Kết nối cơ sở dữ liệu thất bại: " . $e->getMessage();
}
?>
