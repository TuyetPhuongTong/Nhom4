<?php require_once('header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $faq_title = $row['faq_title'];
    $faq_banner = $row['faq_banner'];
}
?>
<style>
    /* Style cho banner của trang */
.page-banner {
    background-color: #006666; /* Màu nền teal cho banner */
    color: #FFFFFF; /* Màu chữ trắng */
    padding: 60px 0; /* Thêm khoảng cách để banner trông đẹp hơn */
    text-align: center; /* Căn giữa chữ */
}

.page-banner h1 {
    font-size: 36px; /* Kích thước chữ lớn cho tiêu đề */
    font-weight: bold;
}

/* Style cho accordion FAQ */
.panel-default {
    border-color: #CC3300; /* Màu viền đỏ cho mỗi panel */
    margin-bottom: 15px;
}

.panel-heading {
    background-color: #006666; /* Màu nền teal cho tiêu đề panel */
    color: #FFFFFF; /* Màu chữ trắng */
    padding: 15px;
    border-radius: 4px;
    cursor: pointer; /* Thêm hiệu ứng con trỏ khi hover */
}

.panel-heading:hover {
    background-color: #004d4d; /* Màu nền teal tối hơn khi hover */
}

.panel-title {
    font-size: 18px;
    font-weight: bold;
    margin: 0;
}

.panel-body {
    background-color: #f9f9f9; /* Màu nền xám nhạt cho nội dung */
    padding: 20px;
    font-size: 16px;
    color: #333333; /* Màu chữ xám đậm */
}

.panel-body h5 {
    font-size: 18px;
    margin-bottom: 10px;
}

.label-primary {
    background-color: #CC3300; /* Màu nền đỏ cho nhãn */
    color: #FFFFFF; /* Màu chữ trắng */
    font-size: 14px;
    padding: 5px 10px;
    border-radius: 3px;
}

/* Đảm bảo thêm style responsive */
@media (max-width: 768px) {
    .page-banner h1 {
        font-size: 28px; /* Kích thước chữ nhỏ hơn cho thiết bị di động */
    }

    .panel-body {
        font-size: 14px; /* Chữ nhỏ hơn một chút cho thiết bị di động */
    }
}

</style>
<div class="page-banner" style="background-image: url(assets/uploads/<?php echo $faq_banner; ?>);">
    <div class="inner">
        <h1><?php echo $faq_title; ?></h1>
    </div>
</div>

<div class="page">
    <div class="container">
        <div class="row">            
            <div class="col-md-12">
                
                <div class="panel-group" id="faqAccordion">                    

                    <?php
                    $statement = $pdo->prepare("SELECT * FROM tbl_faq");
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
                    foreach ($result as $row) {
                        ?>
                        <div class="panel panel-default">
                            <div class="panel-heading accordion-toggle question-toggle collapsed" data-toggle="collapse" data-parent="#faqAccordion" data-target="#question<?php echo $row['faq_id']; ?>">
                                <h4 class="panel-title">
                                    "Nhạc trưởng" hỏi: <?php echo $row['faq_title']; ?>
                                </h4>
                            </div>
                            <div id="question<?php echo $row['faq_id']; ?>" class="panel-collapse collapse" style="height: 0px;">
                                <div class="panel-body">
                                    <h5><span class="label label-primary">Đô Si La Mi xin trả lời</span></h5>
                                    <p>
                                        <?php echo $row['faq_content']; ?>
                                    </p>
                                </div>
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

<?php require_once('footer.php'); ?>