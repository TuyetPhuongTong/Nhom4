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
                <a href="#" class="btn btn-primary" style="background-color: #d3ad57; color:aliceblue; text-align:center;margin-top: 20px; ">Tìm hiểu thêm về sô-cô-la của chúng tôi</a>
            </div>
            <div class="col-md-6">
                <img src="https://maisonmarou.com/wp-content/uploads/2022/03/mm_ourchocolate_2.jpg" alt="Hạt Cacao" class="img-fluid" style="max-height:480px; width:auto;">
            </div>
        </div>

        <!-- Phần: 6 Cacao Origins -->
        <div class="row section" style="background-color:#d3ad57; padding: 20px; margin-top: 40px;">
        <div class="col-md-6" >
                <div style="text-align: center;">
                    <!-- Thẻ chứa hình ảnh -->
                    <img src="https://maisonmarou.com/wp-content/uploads/2022/03/mm_ourchocolate_3.png" alt="Bản đồ 6 tỉnh cacao" style="max-width: 250px; height: auto; margin-bottom: 15px;">
                    <!-- Thẻ chứa đoạn văn -->
                    <p style="font-family: sans-serif; color:aliceblue">CÁC THANH SÔ-CÔ-LA CỦA MAROU ĐƯỢC LÀM TỪ NHỮNG
                        HẠT CACAO CHỌN LỌC TỪ 6 TỈNH THÀNH Ở MIỀN NAM VIỆT NAM:
                        ĐẮK LẮK, LÂM ĐỒNG, ĐỒNG NAI, BÀ RỊA, TIỀN GIANG &
                        BẾN TRE.

                        MỖI VÙNG CACAO LẠI CÓ NHỮNG ĐẶC ĐIỂM RIÊNG NHƯ ĐỘ
                        TRÙ PHÚ CỦA ĐẤT, TẦN SUẤT MƯA, KHÍ HẬU CỦA TỪNG
                        VÙNG ĐẤT MANG LẠI HƯƠNG VỊ ĐẶC TRƯNG CHO CACAO
                        TRỒNG Ở VÙNG ĐẤT ĐÓ. CHÚNG TÔI MONG MUỐN MANG
                        ĐẾN CHO BẠN TẤT CẢ NHỮNG ĐIỂM NHẤN TINH TẾ CỦA
                        CACAO TRONG DÒNG SẢN PHẨM SÔ-CÔ-LA XUẤT XỨ
                        HOÀN TOÀN TỪ VIỆT NAM CỦA CHÚNG TÔI.</p>
                </div>
            </div>

            <div class="col-md-6">
                <img src="https://maisonmarou.com/wp-content/uploads/2024/03/so-map-for-web_240329_960-x-770.webp" alt="Bản đồ Cacao Origins" class="img-fluid "style="max-height:450px; width:auto;">
            </div>
        </div>

        <!-- Phần: Chocolate Bars & More -->
        <div class="row section" style="margin-top: 40px; text-align:center;">
            <h2 class="text-center">CHOCOLATE BARS, & MORE!</h2>
            <div class="col-md-4" style="margin-top: 20px; font-family:sans-serif;"> 
                <img src="https://maisonmarou.com/wp-content/uploads/2022/03/mm_ourchocolate_5.jpg" alt="Single Origin" class="img-fluid" style="max-width: 350px; height: auto;">
                <h3 style="color: #d3ad57;">SINGLE ORIGIN</h3>
                <p style="font-weight:bold;">MỖI THANH SÔ-CÔ-LA SINGLE ORIGIN ĐƯỢC LÀM TỪ HẠT CACAO CHỌN LỌC KĨ LƯỠNG TỪ MỖI VÙNG TRỒNG CACAO, NẮM BẮT ĐƯỢC ĐẶC ĐIỂM CỦA TỪNG TỈNH THÀNH RIÊNG BIỆT.</p>
            </div>
            <div class="col-md-4" style="margin-top: 20px; font-family:sans-serif;">
                <img src="https://maisonmarou.com/wp-content/uploads/2022/03/mm_ourchocolate_8.jpg" alt="Maroubars" class="img-fluid" style="max-width: 350px; height: auto;">
                <h3 style="color: #d3ad57;">SiLaBars</h3>
                <p style="font-weight:bold;">RA ĐỜI VỚI MỤC TIÊU ĐEM ĐẾN HƯƠNG VỊ SÔ-CÔ-LA NGUYÊN BẢN THƠM NGON, CÓ THỂ TẬN HƯỞNG Ở BẤT CỨ NƠI ĐÂU! SẢN PHẨM LÀ SỰ KẾT HỢP HOÀN HẢO GIỮA SÔ-CÔ-LA ĐEN MAROU VỚI CÁC LOẠI HẠT VÀ TRÁI CÂY THU HOẠCH NGON NHẤT VIỆT NAM.</p>
            </div>
            <div class="col-md-4" style="margin-top: 20px; font-family:sans-serif;">
                <img src="https://maisonmarou.com/wp-content/uploads/2022/03/mm_ourchocolate_9.jpg" alt="Hộp Marou" class="img-fluid" style="max-width: 350px; height: auto;">
                <h3 style="color: #d3ad57;">ĐôBox</h3>
                <p style="font-weight:bold;">DÒNG SẢN PHẨM CAO CẤP DÀNH CHO NHỮNG TÂM HỒN YÊU THÍCH PHIÊU LƯU. DÙ LÀ TRONG CĂN BẾP CỦA BẠN HAY TRÊN CHUYẾN THÁM HIỂM RỪNG RẬM, BẠN ĐỀU CÓ THỂ TẬN HƯỞNG NHỮNG SẢN PHẨM MAROU CAO CẤP MỘT CÁCH
                TRỌN VẸN.</p>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>
