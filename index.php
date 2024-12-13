<?php require_once('header.php'); ?>


<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row)
{
    $cta_title = $row['cta_title'];
    $cta_content = $row['cta_content'];
    $cta_read_more_text = $row['cta_read_more_text'];
    $cta_read_more_url = $row['cta_read_more_url'];
    $cta_photo = $row['cta_photo'];
    $featured_product_title = $row['featured_product_title'];
    $featured_product_subtitle = $row['featured_product_subtitle'];
    $latest_product_title = $row['latest_product_title'];
    $latest_product_subtitle = $row['latest_product_subtitle'];
    $popular_product_title = $row['popular_product_title'];
    $popular_product_subtitle = $row['popular_product_subtitle'];
    $total_featured_product_home = $row['total_featured_product_home'];
    $total_latest_product_home = $row['total_latest_product_home'];
    $total_popular_product_home = $row['total_popular_product_home'];
    $home_service_on_off = $row['home_service_on_off'];
    $home_welcome_on_off = $row['home_welcome_on_off'];
    $home_featured_product_on_off = $row['home_featured_product_on_off'];
    $home_latest_product_on_off = $row['home_latest_product_on_off'];
    $home_popular_product_on_off = $row['home_popular_product_on_off'];

}


?>

<div id="bootstrap-touch-slider" class="carousel bs-slider fade control-round indicators-line" data-ride="carousel" data-pause="hover" data-interval="false" >

    <!-- Indicators -->
    <ol class="carousel-indicators">
        <?php
        $i=0;
        $statement = $pdo->prepare("SELECT * FROM tbl_slider");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        foreach ($result as $row) {            
            ?>
            <li data-target="#bootstrap-touch-slider" data-slide-to="<?php echo $i; ?>" <?php if($i==0) {echo 'class="active"';} ?>></li>
            <?php
            $i++;
        }
        ?>
    </ol>

    <!-- Wrapper For Slides -->
    <div class="carousel-inner" role="listbox">

        <?php
        $i=0;
        $statement = $pdo->prepare("SELECT * FROM tbl_slider");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        foreach ($result as $row) {            
            ?>
            <div class="item <?php if($i==0) {echo 'active';} ?>" style="background-image:url(assets/uploads/<?php echo $row['photo']; ?>);">
                <div class="bs-slider-overlay"></div>
                <div class="container">
                    <div class="row">
                        <div class="slide-text <?php if($row['position'] == 'Left') {echo 'slide_style_left';} elseif($row['position'] == 'Center') {echo 'slide_style_center';} elseif($row['position'] == 'Right') {echo 'slide_style_right';} ?>">
                            <h1 data-animation="animated <?php if($row['position'] == 'Left') {echo 'zoomInLeft';} elseif($row['position'] == 'Center') {echo 'flipInX';} elseif($row['position'] == 'Right') {echo 'zoomInRight';} ?>"><?php echo $row['heading']; ?></h1>
                            <p data-animation="animated <?php if($row['position'] == 'Left') {echo 'fadeInLeft';} elseif($row['position'] == 'Center') {echo 'fadeInDown';} elseif($row['position'] == 'Right') {echo 'fadeInRight';} ?>"><?php echo nl2br($row['content']); ?></p>
                            <a href="<?php echo $row['button_url']; ?>" target="_blank"  class="btn btn-primary" data-animation="animated <?php if($row['position'] == 'Left') {echo 'fadeInLeft';} elseif($row['position'] == 'Center') {echo 'fadeInDown';} elseif($row['position'] == 'Right') {echo 'fadeInRight';} ?>"><?php echo $row['button_text']; ?></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $i++;
        }
        ?>
    </div>

    <!-- Slider Left Control -->
    <a class="left carousel-control" href="#bootstrap-touch-slider" role="button" data-slide="prev">
        <span class="fa fa-angle-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>

    <!-- Slider Right Control -->
    <a class="right carousel-control" href="#bootstrap-touch-slider" role="button" data-slide="next">
        <span class="fa fa-angle-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>

</div>

<?php if($home_service_on_off == 1): ?>
<div class="service bg-light" style="padding: 60px 0; background-color: #f5f7fa; font-family: 'Arial', sans-serif;">
    <div class="container">
        <div class="row">
            <?php
                $statement = $pdo->prepare("SELECT * FROM tbl_service");
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
                foreach ($result as $row) {
                    ?>
                    <div class="col-md-4" style="margin-bottom: 40px; display: flex; justify-content: center;">
                        <div class="item" style="text-align: center; background: #ffffff; border: 1px solid #e0e0e0; border-radius: 15px; padding: 30px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); transition: transform 0.3s ease, box-shadow 0.3s ease; overflow: hidden; width: 100%; max-width: 320px;">
                            <div class="photo" style="margin-bottom: 20px; padding: 15px; background-color: #f8f9fa; border-radius: 50%; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); transition: all 0.3s ease;">
                                <img src="assets/uploads/<?php echo $row['photo']; ?>" width="150px" alt="<?php echo $row['title']; ?>" style="max-width: 100%; border-radius: 50%; transition: transform 0.3s ease;">
                            </div>
                            <h3 style="font-size: 22px; font-weight: 700; color: #333; margin-top: 20px;"><?php echo $row['title']; ?></h3>
                            <p style="font-size: 15px; color: #666; line-height: 1.8; margin-top: 15px; padding: 0 10px;">
                                <?php echo nl2br($row['content']); ?>
                            </p>
                            <a href="#" style="display: inline-block; margin-top: 20px; padding: 12px 25px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 25px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; transition: background-color 0.3s ease, transform 0.3s ease;">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                    <?php
                }
            ?>
        </div>
    </div>
</div>
<?php endif; ?>



<!-- banner quảng cáo -->
<div class="container" style="margin-top: 40px;">
       

        <!-- Phần CTA -->
        <div class="row section" style="background-image:url(https://i.pinimg.com/736x/b4/a8/bb/b4a8bbc3e705d16e996ad161d692eca5.jpg); " >
            <div class="col-md-7" style="text-align: right; color:#f7f7f7;">
                <h2 style="text-align: center; margin-top:4.5dvh; color:#fcd53f"> 🎄Mang Hương Vị Giáng Sinh Về Nhà!🌟</h2>
                <h3 style="text-align:left; margin-left:10px"> Trải nghiệm món quà ngọt ngào và tinh tế từ thiên nhiên với Hộp Quà Tặng 6 Thanh Single Origin từ Đô Si La Mi.</h3>

                <p style="margin-top: 15px; text-align:justify; margin-left:10px">
                Giáng Sinh này, hãy trao gửi yêu thương qua món quà đầy ý nghĩa từ Đô Si La Mi – sự kết hợp hoàn hảo giữa chất lượng thượng hạng và hương vị tinh tế, được chế tác từ những hạt cacao nguyên bản tại các vùng đất nổi tiếng.   
                </p>
                <p style="text-align:justify;margin-left:10px">✨ Độc quyền mùa lễ hội: Mỗi thanh socola là một hành trình hương vị khác biệt, từ đắng nhẹ nhàng đến ngọt ngào cuốn hút.</p>
                <p style="text-align:justify;margin-left:10px">🎁 Món quà sang trọng: Thiết kế hộp quà tinh xảo, phù hợp để tặng cho gia đình, bạn bè hay đối tác.</p>
                <p style="text-align:justify;margin-left:10px">🍫 Chất lượng đỉnh cao: 100% nguyên liệu tự nhiên, không chỉ ngon mà còn tốt cho sức khỏe.</p>
                <p style="text-align:justify;margin-left:10px"> Không chỉ là một món quà, đây còn là cách để bạn sẻ chia những khoảnh khắc ấm áp bên những người yêu thương.</p>
                <a href="http://localhost/Nhom4/product.php?id=95" class="btn btn-primary" style="border:none; background-color:#fcd53f; color:#7f572e; text-align:left; margin-bottom:5px ">MUA NGAY</a>
            </div>
            <div class="col-md-5">
                <img src="https://maisonmarou.com/wp-content/uploads/2023/11/6-single-origin-chocolate-bars-gift-box-christmas-edition-2048x2048.webp" alt="Hạt Cacao" class="img-fluid" style="height:auto; width:100%; ;">
            </div>
        </div>
</div>
<!DOCTYPE html>
    <style>
       @keyframes pulse {
        0%, 100% {
            transform: scale(1);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        50% {
            transform: scale(1.05);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
        }
        }

        a.btn-primary {
        display: inline-block;
        border: none;
        background-color: #fcd53f;
        color: #7f572e;
        text-align: center;
        text-decoration: none;
        font-size: 18px;
        font-weight: bold;
        padding: 15px 30px;
        border-radius: 8px;
        margin-top: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06);
        animation: pulse 2s infinite; /* Hiệu ứng động */
        transition: all 0.3s ease; /* Mượt mà khi hover */
        }

        a.btn-primary:hover {
        background-color: #e8c12e;
        color: #5f3d1e;
        transform: scale(1.1); /* Phóng to thêm khi hover */
        box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15), 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        a.btn-primary:active {
        transform: scale(1.05);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

    </style>




<!-- carousel số 1 -->
<?php if($home_featured_product_on_off == 1): ?>    
<div class="product pt_70 pb_70">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="headline">
                    <h2><?php echo $featured_product_title; ?></h2>
                    <h3><?php echo $featured_product_subtitle; ?></h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="product-carousel">
                    
                    <?php
                    $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_is_featured=? AND p_is_active=? LIMIT ".$total_featured_product_home);
                    $statement->execute(array(1,1));
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
                    foreach ($result as $row) {
                        ?>
                        <div class="item">
                            <div class="thumb">
                                <div class="photo" style="background-image:url(assets/uploads/<?php echo $row['p_featured_photo']; ?>);"></div>
                                <div class="overlay"></div>
                            </div>
                            <div class="text">
                                <h3>
                                <a href="product.php?id=<?php echo $row['p_id']; ?>">
                                    <?php 
                                        $productName = $row['p_name'];
                                        if (strlen($productName) > 7) 
                                        {
                                            echo substr($productName, 0, 15) . '...';
                                        } 
                                        else 
                                        {
                                        echo $productName;
                                        }
                                    ?>
                                </a>
                                </h3>
                                <h4>
                                <?php echo $row['p_current_price']; ?>₫
                                    <?php if($row['p_old_price'] != ''): ?>
                                    <del>
                                        <?php echo $row['p_old_price']; ?>₫
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
                                    <p><a href="product.php?id=<?php echo $row['p_id']; ?>"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</a></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>


<?php if($home_latest_product_on_off == 1): ?>
<style>
/* General styles for the product section */
.product.bg-gray {
    background-color: #f7f7f7; /* Light gray background */
}

.product .headline h2,
.product .headline h3 {
    color: #006666; /* Blue-green color for the headlines */
}

/* Product carousel container */
.product-carousel {
    display: flex;
    overflow: auto;
}

/* Individual product item */
.product-carousel .item {
    margin-right: 15px;
    border: 1px solid #ddd;
    border-radius: 10px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    justify-content: space-between; /* Distribute content evenly */
    height: 100%; /* Ensure uniform height for all items */
}

/* Product image styling */
.product-carousel .thumb .photo {
    background-size: cover;
    background-position: center;
    height: 200px;
}

/* Overlay effect on the product image */
.product-carousel .thumb .overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.3);
}

/* Text area for the product name and price */
.product-carousel .text {
    padding: 15px;
    background-color: #fff;
    text-align: center;
    display: flex;
    flex-direction: column;
    justify-content: space-between; /* Ensures text and button spacing */
    height: 100%;
}

/* Product name styling */
.product-carousel .text h3 {
    margin: 0;
    flex-grow: 1; /* Allow product name to take available space */
    display: flex;
    align-items: center; /* Center vertically */
    justify-content: center; /* Center horizontally */
}

.product-carousel .text h3 a {
    color: #006666; /* Blue-green color for the product name */
    font-size: 18px;
    font-weight: bold;
    text-decoration: none;
    display: inline-block;
}

.product-carousel .text h3 a:hover {
    color: #CC3300; /* Orange-red hover color for the product name */
}

/* Price styling */
.product-carousel .text h4 {
    color: #CC3300; /* Orange-red color for the price */
    font-size: 16px;
    margin-bottom: 15px;
}

/* Strikethrough styling for old price */
.product-carousel .text h4 del {
    color: #999;
}

/* Rating stars */
.product-carousel .text .rating {
    margin-top: 10px;
}

/* 'Add to Cart' button styling */
.product-carousel .text p {
    margin: 0;
    padding: 10px 0; /* Add padding for spacing */
    flex-shrink: 0; /* Prevent shrinking of the button */
    min-height: 50px; /* Fixed height for consistent button size */
    display: flex;
    align-items: center; /* Vertically align the button */
    justify-content: center; /* Horizontally align the button */
}

.product-carousel .text p a {
    color: #fff;
    background-color: #CC3300; /* Orange-red background for 'Add to Cart' */
    padding: 10px 15px;
    text-decoration: none;
    border-radius: 5px;
    display: inline-block;
    width: 100%; /* Full width button */
    text-align: center;
    font-weight: bold;
}

.product-carousel .text p a:hover {
    background-color: #006666; /* Blue-green background on hover */
}

/* Ensure 'Add to Cart' buttons are the same height */
.product-carousel .item {
    display: flex;
    flex-direction: column;
}

.product-carousel .item .text {
    display: flex;
    flex-direction: column;
    justify-content: space-between; /* Ensure equal spacing */
    height: 100%;
}

.product-carousel .item .text p {
    margin-top: auto; /* Push the "Add to Cart" button to the bottom */
}

/* Out of stock styling */
.product-carousel .out-of-stock .inner {
    background-color: #CC3300; /* Orange-red background for out-of-stock */
    color: #fff;
    font-size: 14px;
    padding: 10px;
    text-align: center;
}

/* Hover effects for product items */
.product-carousel .item:hover {
    transform: scale(1.05);
    transition: all 0.3s ease;
}

</style>

<!-- carousel số 2 -->
<div class="product bg-gray pt_70 pb_30">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="headline">
                    <h2><?php echo $latest_product_title; ?></h2>
                    <h3><?php echo $latest_product_subtitle; ?></h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="product-carousel">

                    <?php
                    $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_is_active=? ORDER BY p_id DESC LIMIT ".$total_latest_product_home);
                    $statement->execute(array(1));
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
                    foreach ($result as $row) {
                        ?>
                        <div class="item">
                            <div class="thumb">
                                <div class="photo" style="background-image:url(assets/uploads/<?php echo $row['p_featured_photo']; ?>);"></div>
                                <div class="overlay"></div>
                            </div>
                            <div class="text">
                                <h3>
                                    <a href="product.php?id=<?php echo $row['p_id']; ?>">
                                        <?php 
                                        $productName = $row['p_name'];
                                        if (strlen($productName) > 7) {
                                            echo substr($productName, 0, 15) . '...';
                                        } else {
                                            echo $productName;
                                        }
                                        ?>
                                    </a>
                                </h3>
                                <h4>
                                    <?php echo $row['p_current_price']; ?> ₫
                                    <?php if($row['p_old_price'] != ''): ?>
                                    <del>
                                        <?php echo $row['p_old_price']; ?>₫
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
                                    <p><a href="product.php?id=<?php echo $row['p_id']; ?>"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</a></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>

                </div>


            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- carousel số 3 -->
<?php if($home_popular_product_on_off == 1): ?>
<div class="product pt_70 pb_70">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="headline">
                    <h2><?php echo $popular_product_title; ?></h2>
                    <h3><?php echo $popular_product_subtitle; ?></h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="product-carousel">

                    <?php
                    $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_is_active=? ORDER BY p_total_view DESC LIMIT ".$total_popular_product_home);
                    $statement->execute(array(1));
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
                    foreach ($result as $row) {
                        ?>
                        <div class="item">
                            <div class="thumb">
                                <div class="photo" style="background-image:url(assets/uploads/<?php echo $row['p_featured_photo']; ?>);"></div>
                                <div class="overlay"></div>
                            </div>
                            <div class="text">
                            <h3>
                                    <a href="product.php?id=<?php echo $row['p_id']; ?>">
                                        <?php 
                                        $productName = $row['p_name'];
                                        if (strlen($productName) > 7) {
                                            echo substr($productName, 0, 15) . '...';
                                        } else {
                                            echo $productName;
                                        }
                                        ?>
                                    </a>
                                </h3>
                                <h4>
                                    <?php echo $row['p_current_price']; ?>₫
                                    <?php if($row['p_old_price'] != ''): ?>
                                    <del>
                                        <?php echo $row['p_old_price']; ?>₫
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
                                    <p><a href="product.php?id=<?php echo $row['p_id']; ?>"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</a></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>

                </div>

            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php require_once('footer.php'); ?>