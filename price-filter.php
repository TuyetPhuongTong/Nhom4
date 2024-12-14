<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root"; // Tên người dùng MySQL của bạn
$password = ""; // Mật khẩu MySQL của bạn
$dbname = "ecommerceweb"; // Tên cơ sở dữ liệu của bạn

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Lấy giá thấp nhất và cao nhất từ cơ sở dữ liệu
function get_min_max_price() {
    global $conn;
    
    // Truy vấn lấy giá sản phẩm thấp nhất và cao nhất
    $sql = "SELECT MIN(p_current_price) AS min_price, MAX(p_current_price) AS max_price FROM tbl_product";
    
    $result = $conn->query($sql);
    
    if (!$result) {
        die('Query failed: ' . $conn->error); // Nếu truy vấn không thành công, dừng và in lỗi
    }

    if ($result->num_rows > 0) {
        // Lấy giá trị từ kết quả truy vấn
        $row = $result->fetch_assoc();
        return [
            'min_price' => (int) $row['min_price'],
            'max_price' => (int) $row['max_price']
        ];
    }
    
    // Nếu không có sản phẩm, trả về giá mặc định
    return ['min_price' => 0, 'max_price' => 1000];
}

// Lọc sản phẩm theo phạm vi giá
function get_products_by_price_range($min_price, $max_price) {
    global $conn;
    
    // Truy vấn lấy các sản phẩm trong phạm vi giá
    $sql = "SELECT p_id, p_name, p_current_price, p_old_price, p_featured_photo 
            FROM tbl_product
            WHERE p_current_price BETWEEN $min_price AND $max_price";

    $result = $conn->query($sql);
    
    if (!$result) {
        die('Query failed: ' . $conn->error); // Nếu truy vấn không thành công, dừng và in lỗi
    }

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = [
            'id' => $row['p_id'],
            'name' => $row['p_name'],
            'price' => $row['p_current_price'],
            'old_price' => $row['p_old_price'],
            'photo' => $row['p_featured_photo']
        ];
    }

    return $products;
}

$price_range = get_min_max_price();
$min_price = $price_range['min_price'];
$max_price = $price_range['max_price'];

// Lọc sản phẩm theo giá (Nếu có GET min_price và max_price từ AJAX)
if (isset($_GET['min_price']) && isset($_GET['max_price'])) {
    $min_price = $_GET['min_price'];
    $max_price = $_GET['max_price'];
}

$products = get_products_by_price_range($min_price, $max_price);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Category</title>
    <style>
        /* CSS cho thanh lọc giá */
        .price-filter {
            position: fixed;
            top: 20px;
            left: 0;
            width: 250px;
            padding: 20px;
            background-color: #f4f4f4;
            margin-right: 30px;
            border: 1px solid #ccc;
            z-index: 9999;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .price-filter h3 {
            font-size: 18px;
            margin-bottom: 15px;
        }

        .price-filter input[type="range"] {
            width: 100%;
            margin: 10px 0;
        }

        .price-filter p {
            font-size: 16px;
        }

        /* Giới hạn chiều rộng cho thanh lọc giá */
        .price-filter {
            max-width: 250px;
        }

        /* Đảm bảo rằng danh sách sản phẩm không bị che khuất bởi thanh lọc giá */
        #product-list {
            margin-left: 300px;
        }

        /* Định dạng sản phẩm */
        .product {
            margin: 15px 0;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }

        .product img {
            max-width: 100px;
            max-height: 100px;
        }

        /* Định dạng giá cũ với gạch ngang */
        .old-price {
            text-decoration: line-through;
            color: #888;
        }

        .discount {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="price-filter">
        <h3>Filter by Price</h3>
        <input type="range" id="price-range" min="<?php echo $min_price; ?>" max="<?php echo $max_price; ?>" value="<?php echo $max_price; ?>" step="10" onchange="updatePriceRange()" />
        <p>Price: <span id="price-value"><?php echo $max_price; ?></span> VND</p>
    </div>

    <div id="product-list">
        <?php foreach ($products as $product): ?>
            <div class="product">
                <img src="<?php echo $product['photo']; ?>" alt="<?php echo $product['name']; ?>" />
                <p><?php echo $product['name']; ?></p>
                <p>
                    <?php if ($product['old_price'] > 0): ?>
                        <span class="old-price"><?php echo number_format($product['old_price'], 0, ',', '.') . ' VND'; ?></span>
                        <span class="discount"> - Giảm <?php echo round(100 * ($product['old_price'] - $product['price']) / $product['old_price']); ?>%</span>
                    <?php endif; ?>
                    <?php echo number_format($product['price'], 0, ',', '.') . ' VND'; ?>
                </p>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
        function updatePriceRange() {
            var priceValue = document.getElementById('price-range').value;
            document.getElementById('price-value').textContent = priceValue;

            // Gửi giá trị của thanh trượt tới server qua AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "product-category.php?min_price=0&max_price=" + priceValue, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Cập nhật danh sách sản phẩm với kết quả trả về từ server
                    document.getElementById('product-list').innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }
    </script>

</body>
</html>
