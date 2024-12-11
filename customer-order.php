<?php require_once('header.php'); ?>

<?php
// Kiểm Tra Xem Khách Hàng Đã Đăng Nhập Hay Chưa
if(!isset($_SESSION['customer'])) {
    header('location: '.BASE_URL.'logout.php');
    exit;
} else {
    // Nếu Khách Hàng Đã Đăng Nhập Nhưng Bị Admin Vô Hiệu Hóa, Buộc Khách Hàng Đăng Xuất
    $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=? AND cust_status=?");
    $statement->execute(array($_SESSION['customer']['cust_id'],0));
    $total = $statement->rowCount();
    if($total) {
        header('location: '.BASE_URL.'logout.php');
        exit;
    }
}
?>
<style>
    /* Màu tiêu đề */
h3 {
    color: #006666; /* Màu xanh đậm */
    font-weight: bold;
}

/* Bảng */
.table {
    border: 2px solid #006666; /* Viền bảng */
}

.table th {
    background-color: #006666; /* Nền tiêu đề cột */
    color: #FFFFFF; /* Chữ màu trắng */
    text-align: center;
}

.table td {
    border: 1px solid #006666;
    color: #333333; /* Màu chữ mặc định */
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color: #f9f9f9; /* Sọc nền */
}

.table-hover tbody tr:hover {
    background-color: #FF9966; /* Màu đỏ cam khi hover */
    color: #FFFFFF;
}

/* Phân trang */
.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 20px;
}

.pagination a {
    color: #006666;
    border: 1px solid #006666;
    padding: 8px 12px;
    text-decoration: none;
    margin: 0 5px;
    border-radius: 5px;
}

.pagination a:hover {
    background-color: #CC3300;
    color: #FFFFFF;
}

.pagination span.current {
    background-color: #006666;
    color: #FFFFFF;
    padding: 8px 12px;
    border-radius: 5px;
    margin: 0 5px;
}

.pagination span.disabled {
    color: #CCCCCC; /* Màu chữ khi không tương tác */
}

/* Sidebar hoặc nội dung khác */
.user-content {
    background-color: #F5F5F5;
    border: 1px solid #006666;
    padding: 15px;
    border-radius: 5px;
}

</style>
<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php require_once('customer-sidebar.php'); ?>
            </div>
            <div class="col-md-12">
                <div class="user-content">
                    <h3><?php echo "Lịch sử giao dịch"; ?></h3>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th><?php echo "STT" ?></th>
                                    <th><?php echo "Chi tiết sản phẩm"; ?></th>
                                    <th><?php echo "Thời gian thanh toán"; ?></th>
                                    <th><?php echo "ID giao dịch"; ?></th>
                                    <th><?php echo "Giá trị giao dịch"; ?></th>
                                    <th><?php echo "Trạng thái thanh toán"; ?></th>
                                    <th><?php echo "Phương thức thanh toán"; ?></th>
                                    <th><?php echo "ID thanh toán "; ?></th>
                                </tr>
                            </thead>
                            <tbody>

            <?php
            /* ===================== Bắt Đầu Phân Trang ================== */
            $adjacents = 5;

            $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE customer_email=? ORDER BY id DESC");
            $statement->execute(array($_SESSION['customer']['cust_email']));
            $total_pages = $statement->rowCount();

            $targetpage = BASE_URL.'customer-order.php';
            $limit = 10;
            $page = @$_GET['page'];
            if($page) 
                $start = ($page - 1) * $limit;
            else
                $start = 0;
            
            
            $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE customer_email=? ORDER BY id DESC LIMIT $start, $limit");
            $statement->execute(array($_SESSION['customer']['cust_email']));
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
           
            
            if ($page == 0) $page = 1;
            $prev = $page - 1;
            $next = $page + 1;
            $lastpage = ceil($total_pages/$limit);
            $lpm1 = $lastpage - 1;   
            $pagination = "";
            if($lastpage > 1)
            {   
                $pagination .= "<div class=\"pagination\">";
                if ($page > 1) 
                    $pagination.= "<a href=\"$targetpage?page=$prev\">&#171; Trang Trước</a>";
                else
                    $pagination.= "<span class=\"disabled\">&#171; Trang Trước</span>";    
                if ($lastpage < 7 + ($adjacents * 2))
                {   
                    for ($counter = 1; $counter <= $lastpage; $counter++)
                    {
                        if ($counter == $page)
                            $pagination.= "<span class=\"current\">$counter</span>";
                        else
                            $pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";                 
                    }
                }
                elseif($lastpage > 5 + ($adjacents * 2))
                {
                    if($page < 1 + ($adjacents * 2))        
                    {
                        for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
                        {
                            if ($counter == $page)
                                $pagination.= "<span class=\"current\">$counter</span>";
                            else
                                $pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";                 
                        }
                        $pagination.= "...";
                        $pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
                        $pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";       
                    }
                    elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
                    {
                        $pagination.= "<a href=\"$targetpage?page=1\">1</a>";
                        $pagination.= "<a href=\"$targetpage?page=2\">2</a>";
                        $pagination.= "...";
                        for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
                        {
                            if ($counter == $page)
                                $pagination.= "<span class=\"current\">$counter</span>";
                            else
                                $pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";                 
                        }
                        $pagination.= "...";
                        $pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
                        $pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";       
                    }
                    else
                    {
                        $pagination.= "<a href=\"$targetpage?page=1\">1</a>";
                        $pagination.= "<a href=\"$targetpage?page=2\">2</a>";
                        $pagination.= "...";
                        for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
                        {
                            if ($counter == $page)
                                $pagination.= "<span class=\"current\">$counter</span>";
                            else
                                $pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";                 
                        }
                    }
                }
                if ($page < $counter - 1) 
                    $pagination.= "<a href=\"$targetpage?page=$next\">Trang Sau &#187;</a>";
                else
                    $pagination.= "<span class=\"disabled\">Trang Sau &#187;</span>";
                $pagination.= "</div>\n";       
            } 
            /* ===================== Kết Thúc Phân Trang ================== */
            ?>

                                <?php
                                $tip = $page*10-10;
                                foreach ($result as $row) {
                                    $tip++;
                                    ?>
                                    <tr>
                                        <td><?php echo $tip; ?></td>
                                        <td>
                                            <?php
                                            $statement1 = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
                                            $statement1->execute(array($row['payment_id']));
                                            $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($result1 as $row1) {
                                                echo 'Tên Sản Phẩm: '.$row1['product_name'];
                                                echo '<br>Kích Cỡ: '.$row1['size'];
                                                echo '<br>Độ đậm Cacao: '.$row1['color'];
                                                echo '<br>Số Lượng: '.$row1['quantity'];
                                                echo '<br>Đơn Giá: đ'.$row1['unit_price'];
                                                echo '<br><br>';
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $row['payment_date']; ?></td>
                                        <td><?php echo $row['txnid']; ?></td>
                                        <td><?php echo 'đ'.$row['paid_amount']; ?></td>
                                        <td><?php echo $row['payment_status']; ?></td>
                                        <td><?php echo $row['payment_method']; ?></td>
                                        <td><?php echo $row['payment_id']; ?></td>
                                    </tr>
                                    <?php
                                } 
                                ?>                               
                                
                            </tbody>
                        </table>
                        <div class="pagination" style="overflow: hidden;">
                        <?php 
                            echo $pagination; 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>
