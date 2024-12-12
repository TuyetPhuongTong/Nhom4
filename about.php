<?php require_once('header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
   $about_title = $row['about_title'];
    $about_content = $row['about_content'];
    $about_banner = $row['about_banner'];
}
?>

<div class="page-banner" style="background-image: url('https://maisonmarou.com/wp-content/uploads/2022/03/mm_ourchocolate_1.jpg');">
    <div class="inner">
        <h1>LÀM NÊN LOẠI SÔ-CÔ-LA NGON NHẤT CÓ THỂ</h1>
    </div>
</div>

<div class="page">
    <div class="container">
       

        <!-- Phần: Tất cả đều bắt đầu từ hạt cacao -->
        <div class="row section" >
            <div class="col-md-6" style="text-align: center;">
                <h2 style="text-align: center;">     TẤT CẢ ĐỀU BẮT ĐẦU TỪ HẠT CACAO</h2>
                <p>
                    <?php echo $about_content; ?>
                </p>
                <a href="#" class="btn btn-primary" style="background-color: #7f572e; color: #f6dbab; text-align:center;margin-top: 20px; ">Tìm hiểu thêm về sô-cô-la của chúng tôi</a>
            </div>
            <div class="col-md-6">
                <img src="https://maisonmarou.com/wp-content/uploads/2022/03/mm_ourchocolate_2.jpg" alt="Hạt Cacao" class="img-fluid" style="max-height:480px; width:auto;">
            </div>
        </div>

        <!-- Phần: 6 Cacao Origins -->
        <div class="row section" style="background-color: #f7f2e8; padding: 20px; margin-top: 40px;">
            <div class="col-md-6">
                <h2>6 CACAO ORIGINS OF SOUTHERN VIETNAM</h2>
                <p>Các thanh sô-cô-la của Marou được làm từ những hạt cacao chọn lọc từ 6 tỉnh thành...</p>
            </div>
            <div class="col-md-6">
                <img src="https://path-to-your-image2.jpg" alt="Bản đồ Cacao Origins" class="img-fluid">
            </div>
        </div>

        <!-- Phần: Chocolate Bars & More -->
        <div class="row section">
            <h2 class="text-center">CHOCOLATE BARS, & MORE!</h2>
            <div class="col-md-4">
                <img src="https://path-to-your-image3.jpg" alt="Single Origin" class="img-fluid">
                <h3>SINGLE ORIGIN</h3>
                <p>Mỗi thanh sô-cô-la Single Origin được làm từ hạt cacao chọn lọc...</p>
            </div>
            <div class="col-md-4">
                <img src="https://path-to-your-image4.jpg" alt="Maroubars" class="img-fluid">
                <h3>MAROUBARS</h3>
                <p>Ra đời với mục tiêu mang đến hương vị sô-cô-la nguyên bản thơm ngon...</p>
            </div>
            <div class="col-md-4">
                <img src="https://path-to-your-image5.jpg" alt="Hộp Marou" class="img-fluid">
                <h3>SẢN PHẨM ĐÓNG HỘP MAROU</h3>
                <p>Dòng sản phẩm cao cấp...</p>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>
