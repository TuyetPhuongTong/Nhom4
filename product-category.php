<?php require_once('header.php'); ?>
<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $banner_product_category = $row['banner_product_category'];
}
?>

<?php
if( !isset($_REQUEST['id']) || !isset($_REQUEST['type']) ) {
    header('location: index.php');
    exit;
} else {

    if( ($_REQUEST['type'] != 'top-category') && ($_REQUEST['type'] != 'mid-category') && ($_REQUEST['type'] != 'end-category') ) {
        header('location: index.php');
        exit;
    } else {

        $statement = $pdo->prepare("SELECT * FROM tbl_top_category");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        foreach ($result as $row) {
            $top[] = $row['tcat_id'];
            $top1[] = $row['tcat_name'];
        }

        $statement = $pdo->prepare("SELECT * FROM tbl_mid_category");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        foreach ($result as $row) {
            $mid[] = $row['mcat_id'];
            $mid1[] = $row['mcat_name'];
            $mid2[] = $row['tcat_id'];
        }

        $statement = $pdo->prepare("SELECT * FROM tbl_end_category");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        foreach ($result as $row) {
            $end[] = $row['ecat_id'];
            $end1[] = $row['ecat_name'];
            $end2[] = $row['mcat_id'];
        }

        if($_REQUEST['type'] == 'top-category') {
            if(!in_array($_REQUEST['id'],$top)) {
                header('location: index.php');
                exit;
            } else {

                // Getting Title
                for ($i=0; $i < count($top); $i++) { 
                    if($top[$i] == $_REQUEST['id']) {
                        $title = $top1[$i];
                        break;
                    }
                }
                $arr1 = array();
                $arr2 = array();
                // Find out all ecat ids under this
                for ($i=0; $i < count($mid); $i++) { 
                    if($mid2[$i] == $_REQUEST['id']) {
                        $arr1[] = $mid[$i];
                    }
                }
                for ($j=0; $j < count($arr1); $j++) {
                    for ($i=0; $i < count($end); $i++) { 
                        if($end2[$i] == $arr1[$j]) {
                            $arr2[] = $end[$i];
                        }
                    }   
                }
                $final_ecat_ids = $arr2;
            }   
        }

        if($_REQUEST['type'] == 'mid-category') {
            if(!in_array($_REQUEST['id'],$mid)) {
                header('location: index.php');
                exit;
            } else {
                // Getting Title
                for ($i=0; $i < count($mid); $i++) { 
                    if($mid[$i] == $_REQUEST['id']) {
                        $title = $mid1[$i];
                        break;
                    }
                }
                $arr2 = array();        
                // Find out all ecat ids under this
                for ($i=0; $i < count($end); $i++) { 
                    if($end2[$i] == $_REQUEST['id']) {
                        $arr2[] = $end[$i];
                    }
                }
                $final_ecat_ids = $arr2;
            }
        }

        if($_REQUEST['type'] == 'end-category') {
            if(!in_array($_REQUEST['id'],$end)) {
                header('location: index.php');
                exit;
            } else {
                // Getting Title
                for ($i=0; $i < count($end); $i++) { 
                    if($end[$i] == $_REQUEST['id']) {
                        $title = $end1[$i];
                        break;
                    }
                }
                $final_ecat_ids = array($_REQUEST['id']);
            }
        }
        
    }   
}
?>
<style>
/* PHẦN 1: Định dạng chung cho trang */
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

.page .container {
    padding: 30px;
}

/* PHẦN 2: Định dạng tiêu đề danh mục sản phẩm */
.product-cat h3 {
    font-size: 28px;
    color: #006666;
    margin-bottom: 20px;
    line-height: 1.4;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

/* PHẦN 3: Hiển thị danh sách sản phẩm */
.product-cat .row {
    display: grid;
    grid-template-columns: repeat(3, minmax(500px, 1fr));

    gap: 10px; /* Tăng khoảng cách giữa các khối */
}

/* Từng khối sản phẩm */
.product-cat .item-product-cat {
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    height: auto; /* Khung tự điều chỉnh chiều cao dựa trên nội dung */
    min-height: 450px; /* Chiều cao tối thiểu lớn hơn */
    border: 1px solid #e1e1e1;
    border-radius: 10px;
    overflow: hidden;
    transition: all 0.3s ease;
    background-color: #ffffff;
}
.product-cat .item-product-cat:hover {
    box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.1); /* Tăng độ bóng khi hover */
    transform: translateY(-5px);
}

/* PHẦN 4: Định dạng hình ảnh */
.product-cat .thumb .photo {
    width: 100%;
    height: 250px; /* Tăng chiều cao của ảnh để phù hợp khung */
    background-size: cover;
    background-position: center;
}

/* PHẦN 5: Nội dung sản phẩm */
.product-cat .text {
    padding: 25px; /* Tăng padding nội dung */
    background-color: #f9f9f9;
    text-align: center;
    display: flex;
    flex-direction: column;
    gap: 15px; /* Khoảng cách giữa các phần tử con */
}

.product-cat .text h3 a {
    font-size: 20px; /* Tăng cỡ chữ tiêu đề */
    font-weight: bold;
    color: #006666;
    text-decoration: none;
    transition: color 0.3s ease;
    overflow-wrap: break-word;
}
.product-cat .text h3 a:hover {
    color: #CC3300;
}

.product-cat .text h4 {
    font-size: 18px; /* Tăng cỡ chữ giá */
    color: #CC3300;
    margin-top: 10px;
}

.product-cat .rating {
    margin-top: 10px;
    color: #f39c12;
}

/* Nút bấm */
.product-cat .text p {
    text-align: center;
}
.product-cat .text p a {
    display: inline-block;
    width: 100%;
    padding: 15px 25px; /* Tăng kích thước nút bấm */
    background-color: #CC3300;
    color: #ffffff;
    border-radius: 5px;
    text-decoration: none;
    font-size: 18px; /* Tăng cỡ chữ nút */
    transition: background-color 0.3s ease;
}
.product-cat .text p a:hover {
    background-color: #006666;
}

/* PHẦN 6: Responsive (Tương thích thiết bị) */
@media (max-width: 768px) {
    .product-cat .row {
        grid-template-columns: repeat(2, 1fr); /* Hiển thị 2 sản phẩm mỗi hàng */
    }
}

@media (max-width: 480px) {
    .product-cat .row {
        grid-template-columns: 1fr; /* Hiển thị 1 sản phẩm mỗi hàng */
    }
}



</style>

<div class="page-banner" style="background-image: url(https://i.pinimg.com/736x/94/a9/9c/94a99cb922ebf9bfe925b2a191080a7b.jpg)">
    <div class="inner">
        <h1 style="color:#f6dbab;"><?php echo "Danh mục"; ?> <?php echo $title; ?></h1>
    </div>
</div>

<div class="page">
    <div class="container">
        <div class="row">
          <div class="col-md-3">
                <?php require_once('sidebar-category.php'); ?>
            </div>
            <div class="col-md-9">
                
                <h3><?php echo "Tất cả sản phẩm"; ?> "<?php echo $title; ?>"</h3>
                <div class="product product-cat">

                    <div class="row">
                        <?php
                        // Checking if any product is available or not
                        $prod_count = 0;
                        $statement = $pdo->prepare("SELECT * FROM tbl_product");
                        $statement->execute();
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $row) {
                            $prod_table_ecat_ids[] = $row['ecat_id'];
                        }

                        for($ii=0;$ii<count($final_ecat_ids);$ii++):
                            if(in_array($final_ecat_ids[$ii],$prod_table_ecat_ids)) {
                                $prod_count++;
                            }
                        endfor;

                        if($prod_count==0) {
                            echo '<div class="pl_15">'."Không tìm thấy sản phẩm".'</div>';
                        } else {
                            for($ii=0;$ii<count($final_ecat_ids);$ii++) {
                                $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE ecat_id=? AND p_is_active=?");
                                $statement->execute(array($final_ecat_ids[$ii],1));
                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result as $row) {
                                    ?>
                                    <div class="col-md-4 item item-product-cat">
                                        <div class="inner">
                                            <div class="thumb">
                                                <div class="photo" style="background-image:url(assets/uploads/<?php echo $row['p_featured_photo']; ?>);"></div>
                                                <div class="overlay"></div>
                                            </div>
                                            <div class="text">
                                                <h3><a href="product.php?id=<?php echo $row['p_id']; ?>"><?php echo $row['p_name']; ?></a></h3>
                                                <h4>
                                                   <?php echo $row['p_current_price']; ?>  <?php echo"₫"; ?>
                                                    <?php if($row['p_old_price'] != ''): ?>
                                                    <del>
                                                        <?php echo $row['p_old_price']; ?><?php echo "₫"; ?>
                                                    </del>
                                                    <?php endif; ?>
                                                </h4>
                                                <div class="rating">
                                                    <?php
                                                    $t_rating = 0;
                                                    $statement1 = $pdo->prepare("SELECT * FROM tbl_rating WHERE p_id=?");
                                                    $statement1->execute(array($row['p_id']));
                                                    $tot_rating = $statement1->rowCount();
                                                    if($tot_rating == 0) {
                                                        $avg_rating = 0;
                                                    } else {
                                                        $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach ($result1 as $row1) {
                                                            $t_rating = $t_rating + $row1['rating'];
                                                        }
                                                        $avg_rating = $t_rating / $tot_rating;
                                                    }
                                                    ?>
                                                    <?php
                                                    if($avg_rating == 0) {
                                                        echo '';
                                                    }
                                                    elseif($avg_rating == 1.5) {
                                                        echo '
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star-half-o"></i>
                                                            <i class="fa fa-star-o"></i>
                                                            <i class="fa fa-star-o"></i>
                                                            <i class="fa fa-star-o"></i>
                                                        ';
                                                    } 
                                                    elseif($avg_rating == 2.5) {
                                                        echo '
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star-half-o"></i>
                                                            <i class="fa fa-star-o"></i>
                                                            <i class="fa fa-star-o"></i>
                                                        ';
                                                    }
                                                    elseif($avg_rating == 3.5) {
                                                        echo '
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star-half-o"></i>
                                                            <i class="fa fa-star-o"></i>
                                                        ';
                                                    }
                                                    elseif($avg_rating == 4.5) {
                                                        echo '
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star-half-o"></i>
                                                        ';
                                                    }
                                                    else {
                                                        for($i=1;$i<=5;$i++) {
                                                            ?>
                                                            <?php if($i>$avg_rating): ?>
                                                                <i class="fa fa-star-o"></i>
                                                            <?php else: ?>
                                                                <i class="fa fa-star"></i>
                                                            <?php endif; ?>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                                <?php if($row['p_qty'] == 0): ?>
                                                    <div class="out-of-stock">
                                                        <div class="inner">
                                                            Hết hàng
                                                        </div>
                                                    </div>

                                                <?php else: ?>
                                                    <p><a href="product.php?id=<?php echo $row['p_id']; ?>"><i class="fa fa-shopping-cart"></i> <?php echo "Thêm vào Giỏ hàng"; ?></a></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>