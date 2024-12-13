<?php require_once('header.php'); ?>
<?php
// Fetch settings
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id = 1");
$statement->execute();
$result = $statement->fetch(PDO::FETCH_ASSOC);
$banner_product_category = $result['banner_product_category'] ?? '';

// Check if parameters are set in the URL
if (!isset($_REQUEST['id']) || !isset($_REQUEST['type']) || !in_array($_REQUEST['type'], ['top-category', 'mid-category', 'end-category'])) {
    header('location: index.php');
    exit;
}

// Fetch categories based on the type
$type = $_REQUEST['type'];
$id = $_REQUEST['id'];

if ($type == 'top-category') {
    $statement = $pdo->prepare("SELECT * FROM tbl_top_category WHERE tcat_id = ?");
    $statement->execute([$id]);
    $category = $statement->fetch(PDO::FETCH_ASSOC);
    $title = $category ? $category['tcat_name'] : '';
} elseif ($type == 'mid-category') {
    $statement = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE mcat_id = ?");
    $statement->execute([$id]);
    $category = $statement->fetch(PDO::FETCH_ASSOC);
    $title = $category ? $category['mcat_name'] : '';
} elseif ($type == 'end-category') {
    $statement = $pdo->prepare("SELECT * FROM tbl_end_category WHERE ecat_id = ?");
    $statement->execute([$id]);
    $category = $statement->fetch(PDO::FETCH_ASSOC);
    $title = $category ? $category['ecat_name'] : '';
}

// If no valid category found, redirect to index
if (!$title) {
    header('location: index.php');
    exit;
}
?>

<style>
/* General styling */
.page-banner {
    background-size: cover;
    background-position: center;
    text-align: center;
    padding: 100px 0;
    color: #ffffff;
}
.page-banner .inner h1 {
    font-size: 36px;
    font-weight: bold;
    color: #CC3300;
}
.container {
    padding: 30px;
}
.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}
.product-item {
    border: 1px solid #e1e1e1;
    border-radius: 10px;
    overflow: hidden;
    background-color: #ffffff;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.product-item:hover {
    transform: translateY(-5px);
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
}
.product-item img {
    width: 100%;
    height: 250px;
    object-fit: cover;
}
.product-item .content {
    padding: 15px;
    text-align: center;
}
.product-item h3 {
    font-size: 18px;
    font-weight: bold;
    color: #006666;
    margin-bottom: 10px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.product-item h3 a {
    text-decoration: none;
    color: inherit;
    transition: color 0.3s ease;
}
.product-item h3 a:hover {
    color: #CC3300;
}
.product-item .price {
    font-size: 16px;
    color: #CC3300;
    margin-top: 5px;
}
.product-item .price del {
    color: #999;
    margin-left: 10px;
}
.product-item .add-to-cart {
    margin-top: 15px;
    display: inline-block;
    padding: 10px 20px;
    background-color: #CC3300;
    color: #ffffff;
    border-radius: 5px;
    text-decoration: none;
    font-size: 14px;
    transition: background-color 0.3s ease;
}
.product-item .add-to-cart:hover {
    background-color: #006666;
}
</style>

<div class="page-banner" style="background-image: url('https://i.pinimg.com/736x/94/a9/9c/94a99cb922ebf9bfe925b2a191080a7b.jpg');">
    <div class="inner">
        <h1>Danh mục: <?php echo htmlspecialchars($title); ?></h1>
    </div>
</div>

<div class="container">
    <h3>Tất cả sản phẩm thuộc danh mục: "<?php echo htmlspecialchars($title); ?>"</h3>
    <div class="product-grid">
        <?php
        // Fetch products based on category type and ID
        if ($type == 'top-category') {
            $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE tcat_id = ? AND p_is_active = 1");
        } elseif ($type == 'mid-category') {
            $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE mcat_id = ? AND p_is_active = 1");
        } elseif ($type == 'end-category') {
            $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE ecat_id = ? AND p_is_active = 1");
        }
        $statement->execute([$id]);
        $products = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (count($products) > 0) {
            foreach ($products as $product) {
                ?>
                <div class="product-item">
                    <img src="assets/uploads/<?php echo $product['p_featured_photo']; ?>" alt="<?php echo htmlspecialchars($product['p_name']); ?>">
                    <div class="content">
                        <h3><a href="product.php?id=<?php echo $product['p_id']; ?>"><?php echo htmlspecialchars($product['p_name']); ?></a></h3>
                        <div class="price">
                            <?php echo number_format($product['p_current_price']); ?>₫
                            <?php if ($product['p_old_price']): ?>
                                <del><?php echo number_format($product['p_old_price']); ?>₫</del>
                            <?php endif; ?>
                        </div>
                        <a href="product.php?id=<?php echo $product['p_id']; ?>" class="add-to-cart">Thêm vào giỏ hàng</a>
                    </div>
                </div>
                <?php
            }
        } else {
            echo '<p>Không có sản phẩm nào trong danh mục này.</p>';
        }
        ?>
    </div>
</div>

<?php require_once('footer.php'); ?>
