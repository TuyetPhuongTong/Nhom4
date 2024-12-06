<?php require_once('header.php'); ?>

<?php

if(isset($_POST['form_about'])) {
    
    $valid = 1;

    if(empty($_POST['about_title'])) {
        $valid = 0;
        $error_message .= 'Tiêu đề không được để trống<br>';
    }

    if(empty($_POST['about_content'])) {
        $valid = 0;
        $error_message .= 'Nội dung không được để trống<br>';
    }

    $path = $_FILES['about_banner']['name'];
    $path_tmp = $_FILES['about_banner']['tmp_name'];

    if($path != '') {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
            $valid = 0;
            $error_message .=  'Bạn phải tải lên tệp jpg, jpeg, gif hoặc png<br>';
        }
    }

    if($valid == 1) {

        if($path != '') {
            // Xóa ảnh hiện tại
            $statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
            foreach ($result as $row) {
                $about_banner = $row['about_banner'];
                unlink('../assets/uploads/'.$about_banner);
            }

            // Cập nhật dữ liệu
            $final_name = 'about-banner'.'.'.$ext;
            move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );

           // Cập nhật cơ sở dữ liệu
            $statement = $pdo->prepare("UPDATE tbl_page SET about_title=?,about_content=?,about_banner=?,about_meta_title=?,about_meta_keyword=?,about_meta_description=? WHERE id=1");
            $statement->execute(array($_POST['about_title'],$_POST['about_content'],$final_name,$_POST['about_meta_title'],$_POST['about_meta_keyword'],$_POST['about_meta_description']));
        } else {
            // Cập nhật cơ sở dữ liệu
            $statement = $pdo->prepare("UPDATE tbl_page SET about_title=?,about_content=?,about_meta_title=?,about_meta_keyword=?,about_meta_description=? WHERE id=1");
            $statement->execute(array($_POST['about_title'],$_POST['about_content'],$_POST['about_meta_title'],$_POST['about_meta_keyword'],$_POST['about_meta_description']));
        }

        $success_message =  'Thông tin trang "Giới thiệu" đã được cập nhật thành công.';
        
    }
    
}



if(isset($_POST['form_faq'])) {
    
    $valid = 1;// Biến xác định trạng thái hợp lệ

    if(empty($_POST['faq_title'])) {
        $valid = 0;// Đặt trạng thái không hợp lệ
        $error_message .= 'Tiêu đề không được để trống<br>';
    }

    $path = $_FILES['faq_banner']['name'];// Đường dẫn file tải lên
    $path_tmp = $_FILES['faq_banner']['tmp_name']; // Đường dẫn tạm của file


    if($path != '') {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );// Lấy phần mở rộng của file
        $file_name = basename( $path, '.' . $ext );// Tên file không có phần mở rộng
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
            $valid = 0;// Đặt trạng thái không hợp lệ nếu định dạng không đúng
            $error_message .= 'Bạn chỉ được tải lên file jpg, jpeg, gif hoặc png<br>';
        }
    }

    if($valid == 1) {// Nếu tất cả dữ liệu hợp lệ

        if($path != '') {
           // Xóa ảnh hiện tại
            $statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
            foreach ($result as $row) {
                $faq_banner = $row['faq_banner'];
                unlink('../assets/uploads/'.$faq_banner);// Xóa file hiện tại
            }

            // Cập nhật dữ liệu mới
            $final_name = 'faq-banner'.'.'.$ext;// Tên file mới
            move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name ); // Di chuyển file tới thư mục đích

            // Cập nhật cơ sở dữ liệu
            $statement = $pdo->prepare("UPDATE tbl_page SET faq_title=?,faq_banner=?,faq_meta_title=?,faq_meta_keyword=?,faq_meta_description=? WHERE id=1");
            $statement->execute(array($_POST['faq_title'],$final_name,$_POST['faq_meta_title'],$_POST['faq_meta_keyword'],$_POST['faq_meta_description']));
        } else {
            // Cập nhật cơ sở dữ liệu (không thay đổi ảnh)
            $statement = $pdo->prepare("UPDATE tbl_page SET faq_title=?,faq_meta_title=?,faq_meta_keyword=?,faq_meta_description=? WHERE id=1");
            $statement->execute(array($_POST['faq_title'],$_POST['faq_meta_title'],$_POST['faq_meta_keyword'],$_POST['faq_meta_description']));
        }

        $success_message = 'Thông tin trang FAQ đã được cập nhật thành công.';
        
    }
    
}



if(isset($_POST['form_contact'])) {// Kiểm tra nếu form đã được gửi
    
    $valid = 1;// Biến kiểm tra tính hợp lệ
    // Kiểm tra tiêu đề liên hệ (contact_title)
    if(empty($_POST['contact_title'])) {
        $valid = 0;// Không hợp lệ nếu tiêu đề trống
        $error_message .= 'Tiêu đề không được để trống<br>';
    }
    // Kiểm tra file banner được tải lên
    $path = $_FILES['contact_banner']['name'];// Lấy tên file
    $path_tmp = $_FILES['contact_banner']['tmp_name']; // Lấy đường dẫn tạm của file

    if($path != '') {// Nếu có file được tải lên
        $ext = pathinfo( $path, PATHINFO_EXTENSION );// Lấy phần mở rộng của file
        $file_name = basename( $path, '.' . $ext );// Lấy tên file không bao gồm phần mở rộng
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {// Kiểm tra định dạng file
            $valid = 0;// Không hợp lệ nếu định dạng file không phù hợp
            $error_message .= 'Bạn chỉ được tải lên file jpg, jpeg, gif hoặc png<br>';
        }
    }

    if($valid == 1) {// Nếu dữ liệu hợp lệ

        if($path != '') {// Nếu có file banner được tải lên
            //Xóa ảnh hiện tại
            $statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
            foreach ($result as $row) {
                $contact_banner = $row['contact_banner'];
                unlink('../assets/uploads/'.$contact_banner);// Xóa file ảnh cũ
            }

            // Cập nhật dữ liệu mới
            $final_name = 'contact-banner'.'.'.$ext;
            move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );

           // Cập nhật cơ sở dữ liệu
            $statement = $pdo->prepare("UPDATE tbl_page SET contact_title=?,contact_banner=?,contact_meta_title=?,contact_meta_keyword=?,contact_meta_description=? WHERE id=1");
            $statement->execute(array($_POST['contact_title'],$final_name,$_POST['contact_meta_title'],$_POST['contact_meta_keyword'],$_POST['contact_meta_description']));
        } else {
           // Nếu không tải lên banner, chỉ cập nhật các trường khác
            $statement = $pdo->prepare("UPDATE tbl_page SET contact_title=?,contact_meta_title=?,contact_meta_keyword=?,contact_meta_description=? WHERE id=1");
            $statement->execute(array($_POST['contact_title'],$_POST['contact_meta_title'],$_POST['contact_meta_keyword'],$_POST['contact_meta_description']));
        }

        $success_message = 'Thông tin trang Liên hệ đã được cập nhật thành công.'; // Thông báo thành công
        
        
    }
    
}


?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Cấu Hình Trang</h1>
    </div>
</section>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
foreach ($result as $row) {
    $about_title = $row['about_title'];// Tiêu đề trang About
    $about_content = $row['about_content'];// Nội dung trang About
    $about_banner = $row['about_banner'];// Banner trang About
    $about_meta_title = $row['about_meta_title']; // Meta title trang About
    $about_meta_keyword = $row['about_meta_keyword'];// Meta keyword trang About
    $about_meta_description = $row['about_meta_description'];// Meta description trang About
    $faq_title = $row['faq_title'];// Tiêu đề trang FAQ
    $faq_banner = $row['faq_banner'];// Banner trang FAQ
    $faq_meta_title = $row['faq_meta_title']; // Meta title trang FAQ
    $faq_meta_keyword = $row['faq_meta_keyword'];// Meta keyword trang FAQ
    $faq_meta_description = $row['faq_meta_description'];// Meta description trang FAQ
    $contact_title = $row['contact_title'];// Tiêu đề trang Contact
    $contact_banner = $row['contact_banner']; // Banner trang Contact
    $contact_meta_title = $row['contact_meta_title'];// Meta title trang Contact
    $contact_meta_keyword = $row['contact_meta_keyword'];// Meta keyword trang Contact
    $contact_meta_description = $row['contact_meta_description'];// Meta description trang Contact

}
?>


<section class="content" style="min-height:auto;margin-bottom: -30px;">
    <div class="row">
        <div class="col-md-12">
            <?php if($error_message): ?>
            <div class="callout callout-danger">
            
            <p>
            <?php echo $error_message; ?>
            </p>
            </div>
            <?php endif; ?>

            <?php if($success_message): ?>
            <div class="callout callout-success">
            
            <p><?php echo $success_message; ?></p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="content">

    <div class="row">
        <div class="col-md-12">
                            
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1" data-toggle="tab">Giới Thiệu</a></li>
                        <li><a href="#tab_2" data-toggle="tab">Câu Hỏi Thường Gặp</a></li>
                        <li><a href="#tab_4" data-toggle="tab">Liên Hệ</a></li>

                    </ul>

                    <!-- Nội dung trang Giới thiệu -->

                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="box box-info">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Tiêu Đề Trang * </label>
                                        <div class="col-sm-5">
                                            <input class="form-control" type="text" name="about_title" value="<?php echo $about_title; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Nội Dung Trang * </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="about_content" id="editor1"><?php echo $about_content; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Ảnh Banner Hiện Tại</label>
                                        <div class="col-sm-6" style="padding-top:6px;">
                                            <img src="../assets/uploads/<?php echo $about_banner; ?>" class="existing-photo" style="height:80px;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Ảnh Banner Mới</label>
                                        <div class="col-sm-6" style="padding-top:6px;">
                                            <input type="file" name="about_banner">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Tiêu Đề Meta</label>
                                        <div class="col-sm-8">
                                            <input class="form-control" type="text" name="about_meta_title" value="<?php echo $about_meta_title; ?>">
                                        </div>
                                    </div>             
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Từ Khóa Meta</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="about_meta_keyword" style="height:100px;"><?php echo $about_meta_keyword; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Mô Tả Meta </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="about_meta_description" style="height:100px;"><?php echo $about_meta_description; ?></textarea>
                                        </div>
                                    </div>                                    
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label"></label>
                                        <div class="col-sm-6">
                                            <button type="submit" class="btn btn-success pull-left" name="form_about">Cập Nhật</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>

        <!-- Nội dung trang FAQ -->

                        <div class="tab-pane" id="tab_2">
                            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="box box-info">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Tiêu Đề Trang  * </label>
                                        <div class="col-sm-5">
                                            <input class="form-control" type="text" name="faq_title" value="<?php echo $faq_title; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Ảnh Banner Hiện Tại</label>
                                        <div class="col-sm-6" style="padding-top:6px;">
                                            <img src="../assets/uploads/<?php echo $faq_banner; ?>" class="existing-photo" style="height:80px;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Ảnh Banner Mới</label>
                                        <div class="col-sm-6" style="padding-top:6px;">
                                            <input type="file" name="faq_banner">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Tiêu Đề Meta</label>
                                        <div class="col-sm-8">
                                            <input class="form-control" type="text" name="faq_meta_title" value="<?php echo $faq_meta_title; ?>">
                                        </div>
                                    </div>             
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Từ Khóa Meta </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="faq_meta_keyword" style="height:100px;"><?php echo $faq_meta_keyword; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Mô Tả Meta</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="faq_meta_description" style="height:100px;"><?php echo $faq_meta_description; ?></textarea>
                                        </div>
                                    </div>                                    
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label"></label>
                                        <div class="col-sm-6">
                                            <button type="submit" class="btn btn-success pull-left" name="form_faq">Cập Nhật</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>

                       <!-- Kết thúc nội dung trang FAQ -->

                        <div class="tab-pane" id="tab_4">
                            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="box box-info">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Tiêu Đề Trang * </label>
                                        <div class="col-sm-5">
                                            <input class="form-control" type="text" name="contact_title" value="<?php echo $contact_title; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Ảnh Banner Hiện Tại</label>
                                        <div class="col-sm-6" style="padding-top:6px;">
                                            <img src="../assets/uploads/<?php echo $contact_banner; ?>" class="existing-photo" style="height:80px;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Ảnh Banner Mới</label>
                                        <div class="col-sm-6" style="padding-top:6px;">
                                            <input type="file" name="contact_banner">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Tiêu Đề Meta</label>
                                        <div class="col-sm-8">
                                            <input class="form-control" type="text" name="contact_meta_title" value="<?php echo $contact_meta_title; ?>">
                                        </div>
                                    </div>             
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Từ Khóa Meta </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="contact_meta_keyword" style="height:100px;"><?php echo $contact_meta_keyword; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Mô Tả Meta </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="contact_meta_description" style="height:100px;"><?php echo $contact_meta_description; ?></textarea>
                                        </div>
                                    </div>                                    
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label"></label>
                                        <div class="col-sm-6">
                                            <button type="submit" class="btn btn-success pull-left" name="form_contact">Cập Nhật</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>



                

            </form>
        </div>
    </div>

</section>

<?php require_once('footer.php'); ?>