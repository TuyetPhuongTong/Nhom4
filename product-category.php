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
/* General Page Styling */
.page-banner {
    background-size: cover; /* Ảnh nền sẽ phủ toàn bộ vùng chứa mà không bị co giãn sai tỷ lệ */
    background-position: center; /* Căn giữa ảnh nền */
    text-align: center; /* Căn giữa toàn bộ nội dung bên trong theo chiều ngang */
    padding: 100px 0; /* Tạo khoảng cách trên và dưới của banner */
    color: #ffffff; /* Đặt màu chữ trắng */
}

.page-banner .inner h1 {
    font-size: 36px; /* Cỡ chữ lớn cho tiêu đề */
    font-weight: bold; /* In đậm tiêu đề */
    color: #CC3300; /* Màu đỏ cho tiêu đề */
}

.page .container {
    padding: 30px; /* Tạo khoảng cách giữa nội dung và viền container */
}

.product-cat h3 {
    font-size: 28px; /* Cỡ chữ lớn cho tiêu đề danh mục */
    color: #006666; /* Màu xanh cho tiêu đề danh mục */
    margin-bottom: 20px; /* Tạo khoảng cách dưới tiêu đề */
    height: 50px; /* Chiều cao cố định (tùy chỉnh theo ý bạn) */
    line-height: 50px; /* Đảm bảo văn bản căn giữa theo chiều dọc */
    overflow: hidden; /* Ẩn nội dung nếu dài hơn chiều cao */
    text-overflow: ellipsis; /* Thêm dấu "..." nếu nội dung bị cắt */
    white-space: nowrap; /* Không cho phép văn bản xuống dòng */
}

/* Product Listing */
/* Container của từng khối sản phẩm */
.product-cat .item-product-cat {
    flex: 0 0 calc(33.333% - 20px); /* Mỗi khối sản phẩm chiếm 1/3 hàng, trừ khoảng cách giữa các khối */
    box-sizing: border-box; /* Bao gồm cả padding và border trong chiều rộng/chiều cao */
    display: flex; /* Áp dụng flexbox cho các phần tử con */
    flex-direction: column; /* Các phần tử con xếp theo chiều dọc */
    justify-content: space-between; /* Căn đều nội dung đầu và cuối */
    align-items: stretch; /* Kéo giãn các phần tử con theo chiều ngang */
    height: 100%; /* Đặt chiều cao đồng nhất cho tất cả các khối sản phẩm */
    border: 1px solid #e1e1e1; /* Đặt viền màu xám nhạt */
    border-radius: 10px; /* Bo tròn góc của khối */
    margin-bottom: 20px; /* Tạo khoảng cách dưới mỗi khối sản phẩm */
    overflow: hidden; /* Ẩn nội dung vượt ra ngoài khối */
    transition: all 0.3s ease; /* Hiệu ứng chuyển đổi mượt mà khi hover */
}
.product-cat .item-product-cat:hover {
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1); /* Hiệu ứng bóng khi hover */
    transform: translateY(-5px); /* Khối sản phẩm nâng lên khi hover */
}

.product-cat .thumb .photo {
    height: 250px; /* Đặt chiều cao cố định cho hình ảnh */
    background-size: cover; /* Ảnh nền phủ toàn bộ khối */
    background-position: center; /* Căn giữa ảnh nền */
}
  
.product-cat .text {
    padding: 20px; /* Khoảng cách bên trong khối nội dung */
    background-color: #f9f9f9; /* Màu nền nhạt */
    text-align: center; /* Căn giữa nội dung theo chiều ngang */
    flex-grow: 1; /* Phần nội dung sẽ tự động mở rộng để lấp đầy không gian */
    display: flex;
    flex-direction: column; /* Xếp các phần tử con theo chiều dọc */
    justify-content: space-between; /* Căn đều phần trên và dưới */
}

.product-cat .text h3 a {
    font-size: 18px; /* Cỡ chữ cho tên sản phẩm */
    font-weight: bold; /* In đậm tên sản phẩm */
    color: #006666; /* Màu xanh cho tiêu đề */
    text-decoration: none; /* Xóa gạch chân */
    transition: color 0.3s ease; /* Hiệu ứng đổi màu mượt khi hover */
}
.product-cat .text h3 a:hover {
    color: #CC3300; /* Đổi sang màu đỏ khi hover */
}

.product-cat .text h4 {
    font-size: 16px; /* Cỡ chữ giá sản phẩm */
    color: #CC3300; /* Màu đỏ cho giá */
    margin-top: 10px; /* Khoảng cách phía trên */
}

.product-cat .rating {
    margin-top: 10px;
    color: #f39c12;
}

/* Ensuring uniform button alignment */
.product-cat .text p {
    margin-top: auto;
}

.product-cat .text p a {
    display: inline-block;
    width: 100%; /* Nút bấm chiếm toàn bộ chiều ngang */
    padding: 10px 20px; /* Kích thước nút bấm */
    background-color: #CC3300; /* Màu đỏ nền nút */
    color: #ffffff; /* Màu trắng chữ */
    border-radius: 5px; /* Bo tròn nút bấm */
    text-decoration: none; /* Xóa gạch chân */
    font-size: 16px; /* Cỡ chữ */
    text-align: center; /* Căn giữa chữ */
    transition: background-color 0.3s ease; /* Hiệu ứng đổi màu nút bấm */
}
.product-cat .text p a:hover {
    background-color: #006666; /* Đổi sang màu xanh khi hover */
}
/* Đảm bảo các khối sản phẩm có chiều cao đồng nhất */
.product-cat .row {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 20px;
}

.product-cat .item-product-cat {
    flex: 0 0 calc(33.333% - 20px); /* Chia đều các khối sản phẩm */
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%; /* Đặt chiều cao đồng nhất */
}

.product-cat .thumb .photo {
    height: 250px;
    background-size: cover;
    background-position: center;
}

.product-cat .text {
    flex-grow: 1; /* Đảm bảo phần text chiếm toàn bộ không gian còn lại */
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    background-color: #f9f9f9;
    text-align: center;
    padding: 20px;
}

.product-cat .text h3 {
    min-height: 50px; /* Đảm bảo chiều cao tiêu đề đồng nhất */
    font-size: 18px;
    font-weight: bold;
    color: #006666;
    margin-bottom: 10px;
}

.product-cat .text h4 {
    font-size: 16px;
    color: #CC3300;
    margin-top: 10px;
}

.product-cat .text p {
    margin-top: auto; /* Đẩy nút xuống cuối khối */
}

.product-cat .text p a {
    display: inline-block;
    padding: 10px 20px;
    background-color: #CC3300;
    color: #ffffff;
    border-radius: 5px;
    text-decoration: none;
    font-size: 16px;
    text-align: center;
    transition: background-color 0.3s ease;
}

.product-cat .text p a:hover {
    background-color: #006666;
}

@media (max-width: 768px) {
    .product-cat .item-product-cat {
        flex: 0 0 calc(50% - 20px); /* For smaller screens, display 2 items per row */
    }
}

@media (max-width: 480px) {
    .product-cat .item-product-cat {
        flex: 0 0 100%; /* For mobile screens, display 1 item per row */
    }
}
   
</style>
<div class="page-banner" style="background-image: url(assets/uploads/<?php echo $banner_product_category; ?>)">
    <div class="inner">
        <h1><?php echo "Danh mục"; ?> <?php echo $title; ?></h1>
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