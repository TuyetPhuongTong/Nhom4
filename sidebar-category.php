
<?php
// Bao gồm tệp kết nối cơ sở dữ liệu
include('db_config.php');
?>
<h3><?php echo "Danh mục sản phẩm "; ?></h3>
    <div id="left" class="span3">

        <ul id="menu-group-1" class="nav menu">
            <?php
                $i=0;
                $statement = $pdo->prepare("SELECT * FROM tbl_top_category WHERE show_on_menu=1");
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result as $row) {
                    $i++;
                    ?>
                    <li class="cat-level-1 deeper parent">
                        <a class="" href="product-category.php?id=<?php echo $row['tcat_id']; ?>&type=top-category">
                            <span data-toggle="collapse" data-parent="#menu-group-1" href="#cat-lvl1-id-<?php echo $i; ?>" class="sign"><i class="fa fa-plus"></i></span>
                            <span class="lbl"><?php echo $row['tcat_name']; ?></span>                      
                        </a>
                        <ul class="children nav-child unstyled small collapse" id="cat-lvl1-id-<?php echo $i; ?>">
                            <?php
                            $j=0;
                            $statement1 = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE tcat_id=?");
                            $statement1->execute(array($row['tcat_id']));
                            $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result1 as $row1) {
                                $j++;
                                ?>
                                <li class="deeper parent">
                                    <a class="" href="product-category.php?id=<?php echo $row1['mcat_id']; ?>&type=mid-category">
                                        <span data-toggle="collapse" data-parent="#menu-group-1" href="#cat-lvl2-id-<?php echo $i.$j; ?>" class="sign"><i class="fa fa-plus"></i></span>
                                        <span class="lbl lbl1"><?php echo $row1['mcat_name']; ?></span> 
                                    </a>
                                    <ul class="children nav-child unstyled small collapse" id="cat-lvl2-id-<?php echo $i.$j; ?>">
                                        <?php
                                            $k=0;
                                            $statement2 = $pdo->prepare("SELECT * FROM tbl_end_category WHERE mcat_id=?");
                                            $statement2->execute(array($row1['mcat_id']));
                                            $result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($result2 as $row2) {
                                                $k++;
                                                ?>
                                                <li class="item-<?php echo $i.$j.$k; ?>">
                                                    <a class="" href="product-category.php?id=<?php echo $row2['ecat_id']; ?>&type=end-category">
                                                        <span class="sign"></span>
                                                        <span class="lbl lbl1"><?php echo $row2['ecat_name']; ?></span>
                                                    </a>
                                                </li>
                                                <?php
                                            }
                                        ?>
                                    </ul>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </li>
                    <?php
                }
            ?>
        </ul>
<!-- Thanh lọc giá -->
<div id="price-filter">
    <h4>Filter by Price</h4>
    <input type="range" id="min-price" min="0" max="1000" value="0">
    <input type="range" id="max-price" min="0" max="1000" value="1000">
    <p id="price-range">0 - 1000</p>
    <form method="GET" action="sidebar-category.php">
        <input type="hidden" name="min_price" id="min-price-input" value="0">
        <input type="hidden" name="max_price" id="max-price-input" value="1000">
        <button type="submit">Apply Filter</button>
    </form>
</div>
    </div>
<!-- Chèn mã JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const minPrice = document.getElementById('min-price');
    const maxPrice = document.getElementById('max-price');
    const priceRange = document.getElementById('price-range');
    const minPriceInput = document.getElementById('min-price-input');
    const maxPriceInput = document.getElementById('max-price-input');

    function updatePriceRange() {
        priceRange.textContent = ${minPrice.value} - ${maxPrice.value};
        minPriceInput.value = minPrice.value;
        maxPriceInput.value = maxPrice.value;
    }

    minPrice.addEventListener('input', updatePriceRange);
    maxPrice.addEventListener('input', updatePriceRange);

    // Lần đầu tiên cập nhật giá
    updatePriceRange();
});
</script>

<?php

// Lấy giá trị min_price và max_price từ URL
$min_price = isset($_GET['min_price']) ? (int) $_GET['min_price'] : 0;
$max_price = isset($_GET['max_price']) ? (int) $_GET['max_price'] : 1000;

// Sửa đổi câu truy vấn SQL để lọc sản phẩm theo giá
$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_current_price BETWEEN ? AND ?");
$statement->execute([$min_price, $max_price]);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);

// Hiển thị sản phẩm lọc được
foreach ($result as $row) {
    echo "<div class='product'>";
    echo "<h4>" . $row['p_name'] . "</h4>";
    $price = floatval(str_replace(',', '', $row['p_current_price'])); // Loại bỏ dấu ',' và chuyển thành float
    echo "<p>Price: " . number_format($price, 0, ',', '.') . " VND</p>";
    echo "</div>";
}
?>

