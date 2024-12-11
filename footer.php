<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row)
{
	$footer_about = $row['footer_about'];
	$contact_email = $row['contact_email'];
	$contact_phone = $row['contact_phone'];
	$contact_address = $row['contact_address'];
	$footer_copyright = $row['footer_copyright'];
	$total_recent_post_footer = $row['total_recent_post_footer'];
    $total_popular_post_footer = $row['total_popular_post_footer'];
    $newsletter_on_off = $row['newsletter_on_off'];
    $before_body = $row['before_body'];
}
?>


<a href="#" class="scrollup">
	<i class="fa fa-angle-up"></i>
</a>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $stripe_public_key = $row['stripe_public_key'];
    $stripe_secret_key = $row['stripe_secret_key'];
}
?>

<script src="assets/js/jquery-2.2.4.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="https://js.stripe.com/v2/"></script>
<script src="assets/js/megamenu.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/owl.animate.js"></script>
<script src="assets/js/jquery.bxslider.min.js"></script>
<script src="assets/js/jquery.magnific-popup.min.js"></script>
<script src="assets/js/rating.js"></script>
<script src="assets/js/jquery.touchSwipe.min.js"></script>
<script src="assets/js/bootstrap-touch-slider.js"></script>
<script src="assets/js/select2.full.min.js"></script>
<script src="assets/js/custom.js"></script>
<script>
	function confirmDelete()
	{
	    return confirm("Sure you want to delete this data?");
	}
	$(document).ready(function () {
		advFieldsStatus = $('#advFieldsStatus').val();

		$('#paypal_form').hide();
		$('#stripe_form').hide();
		$('#bank_form').hide();

        $('#advFieldsStatus').on('change',function() {
            advFieldsStatus = $('#advFieldsStatus').val();
            if ( advFieldsStatus == '' ) {
            	$('#paypal_form').hide();
				$('#stripe_form').hide();
				$('#bank_form').hide();
            } else if ( advFieldsStatus == 'PayPal' ) {
               	$('#paypal_form').show();
				$('#stripe_form').hide();
				$('#bank_form').hide();
            } else if ( advFieldsStatus == 'Stripe' ) {
               	$('#paypal_form').hide();
				$('#stripe_form').show();
				$('#bank_form').hide();
            } else if ( advFieldsStatus == 'Bank Deposit' ) {
            	$('#paypal_form').hide();
				$('#stripe_form').hide();
				$('#bank_form').show();
            }
        });
	});


	$(document).on('submit', '#stripe_form', function () {
        // createToken returns immediately - the supplied callback submits the form if there are no errors
        $('#submit-button').prop("disabled", true);
        $("#msg-container").hide();
        Stripe.card.createToken({
            number: $('.card-number').val(),
            cvc: $('.card-cvc').val(),
            exp_month: $('.card-expiry-month').val(),
            exp_year: $('.card-expiry-year').val()
            // name: $('.card-holder-name').val()
        }, stripeResponseHandler);
        return false;
    });
    Stripe.setPublishableKey('<?php echo $stripe_public_key; ?>');
    function stripeResponseHandler(status, response) {
        if (response.error) {
            $('#submit-button').prop("disabled", false);
            $("#msg-container").html('<div style="color: red;border: 1px solid;margin: 10px 0px;padding: 5px;"><strong>Error:</strong> ' + response.error.message + '</div>');
            $("#msg-container").show();
        } else {
            var form$ = $("#stripe_form");
            var token = response['id'];
            form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
            form$.get(0).submit();
        }
    }
</script>
<!-- Mở và đóng popup -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const popup = document.getElementById("promo-popup");
    const closeBtn = document.getElementById("close-popup");

    // Hiển thị popup sau khi tải trang
    setTimeout(() => {
        popup.style.display = "block";
    }, 1000); // Hiển thị sau 1 giây

    // Đóng popup khi nhấn nút đóng
    closeBtn.addEventListener("click", () => {
        popup.style.display = "none";
    });

    // Đóng popup khi nhấp ra ngoài vùng popup
    window.addEventListener("click", (e) => {
        if (e.target === popup) {
            popup.style.display = "none";
        }
    });
});
</script>

<?php echo $before_body; ?>
</body>
</html>

<!-- footer nè -->
<footer style="background-color: #7f572e; color: #f6dbab; padding: 20px 0; font-family: Arial, sans-serif;">
  <div style="display: flex; justify-content: space-between; gap: 20px; max-width: 1200px; margin: 0 auto; padding: 0 20px;">
    <!-- Cột 1: Liên hệ -->
    <div style="flex: 1;">
	<h3 style="margin-bottom: 10px; font-size: 18px; color: #f6dbab; border-bottom: 1.5px solid #f6dbab; padding-bottom: 10px;">Liên hệ</h3>
      <p>Địa chỉ: 123 Đường ABC, TP. Hồ Chí Minh</p>
      <p>Email: contact@chocolatestore.com</p>
      <p>Hotline: 0909 123 456</p>
    </div>

    <!-- Cột 2: Theo dõi chúng tôi -->
    <div style="flex: 1;">
	<h3 style="margin-bottom: 10px; font-size: 18px; color: #f6dbab; border-bottom: 1.5px solid #f6dbab; padding-bottom: 10px;">Theo dõi chúng tôi</h3>
      <ul style="list-style: none; padding: 0;">
        <li style="margin-bottom: 5px;"><a href="#" style="text-decoration: none; color: #f6dbab;">Facebook</a></li>
        <li style="margin-bottom: 5px;"><a href="#" style="text-decoration: none; color: #f6dbab;">Instagram</a></li>
        <li style="margin-bottom: 5px;"><a href="#" style="text-decoration: none; color: #f6dbab;">Twitter</a></li>
        <li style="margin-bottom: 5px;"><a href="#" style="text-decoration: none; color: #f6dbab;">YouTube</a></li>
      </ul>
    </div>

    <!-- Cột 3: Liên kết nhanh -->
    <div style="flex: 1;">
	<h3 style="margin-bottom: 10px; font-size: 18px; color: #f6dbab; border-bottom: 1.5px solid #f6dbab; padding-bottom: 10px;">Liên kết nhanh</h3>
      <ul style="list-style: none; padding: 0;">
        <li style="margin-bottom: 5px;"><a href="#" style="text-decoration: none; color: #f6dbab;">Trang chủ</a></li>
        <li style="margin-bottom: 5px;"><a href="http://localhost/Nhom4/product-category.php?id=3&type=top-category" style="text-decoration: none; color: #f6dbab;">Sản phẩm</a></li>
        <li style="margin-bottom: 5px;"><a href="http://localhost/Nhom4/about.php" style="text-decoration: none; color: #f6dbab;">Về chúng tôi</a></li>
        <li style="margin-bottom: 5px;"><a href="http://localhost/Nhom4/faq.php" style="text-decoration: none; color: #f6dbab;">FAQ</a></li>
      </ul>
    </div>

    <!-- Cột 4: Đăng ký nhận tin -->
    <!-- <div style="flex: 1;">
      <h3 style="margin-bottom: 10px; font-size: 18px; color: #fefaf4;">Đăng ký nhận tin</h3>
      <p>Nhận thông tin ưu đãi và sản phẩm mới nhất!</p>
      <form style="display: flex; flex-direction: column;">
        <input type="email" placeholder="Nhập email của bạn" required 
          style="padding: 10px; margin-bottom: 10px; border: 1px solid #fefaf4; border-radius: 5px; outline: none;" />
        <button type="submit" 
          style="padding: 10px; background-color: #ff9f68; color: #fefaf4; border: none; border-radius: 5px; cursor: pointer;">
          Đăng ký
        </button>
      </form>
    </div> -->
	
	<?php if($newsletter_on_off == 1): ?>

				<div style="flex: 1;">
					<?php
			if(isset($_POST['form_subscribe']))
			{

				if(empty($_POST['email_subscribe'])) 
			    {
			        $valid = 0;
			        $error_message1 .= LANG_VALUE_131;
			    }
			    else
			    {
			    	if (filter_var($_POST['email_subscribe'], FILTER_VALIDATE_EMAIL) === false)
				    {
				        $valid = 0;
				        $error_message1 .= LANG_VALUE_134;
				    }
				    else
				    {
				    	$statement = $pdo->prepare("SELECT * FROM tbl_subscriber WHERE subs_email=?");
				    	$statement->execute(array($_POST['email_subscribe']));
				    	$total = $statement->rowCount();							
				    	if($total)
				    	{
				    		$valid = 0;
				        	$error_message1 .= LANG_VALUE_147;
				    	}
				    	else
				    	{
				    		// Sending email to the requested subscriber for email confirmation
				    		// Getting activation key to send via email. also it will be saved to database until user click on the activation link.
				    		$key = md5(uniqid(rand(), true));

				    		// Getting current date
				    		$current_date = date('Y-m-d');

				    		// Getting current date and time
				    		$current_date_time = date('Y-m-d H:i:s');

				    		// Inserting data into the database
				    		$statement = $pdo->prepare("INSERT INTO tbl_subscriber (subs_email,subs_date,subs_date_time,subs_hash,subs_active) VALUES (?,?,?,?,?)");
				    		$statement->execute(array($_POST['email_subscribe'],$current_date,$current_date_time,$key,0));

				    		// Sending Confirmation Email
				    		$to = $_POST['email_subscribe'];
							$subject = 'Subscriber Email Confirmation';
							
							// Getting the url of the verification link
							$verification_url = BASE_URL.'verify.php?email='.$to.'&key='.$key;

							$message = '
	Thanks for your interest to subscribe our newsletter!<br><br>
	Please click this link to confirm your subscription:
						'.$verification_url.'<br><br>
	This link will be active only for 24 hours.
					';

							$headers = 'From: ' . $contact_email . "\r\n" .
								   'Reply-To: ' . $contact_email . "\r\n" .
								   'X-Mailer: PHP/' . phpversion() . "\r\n" . 
								   "MIME-Version: 1.0\r\n" . 
								   "Content-Type: text/html; charset=ISO-8859-1\r\n";

							// Sending the email
							mail($to, $subject, $message, $headers);

							$success_message1 = LANG_VALUE_136;
				    	}
				    }
			    }
			}
			if($error_message1 != '') {
				echo "<script>alert('".$error_message1."')</script>";
			}
			if($success_message1 != '') {
				echo "<script>alert('".$success_message1."')</script>";
			}
			?>
				<form style="display: flex; flex-direction: column;" action="" method="post">
					<?php $csrf->echoInputField(); ?>
					<h3 style="margin-bottom: 10px; font-size: 18px; color: #f6dbab; border-bottom: 1.5px solid #f6dbab; padding-bottom: 10px;">Đăng ký nhận tin</h3>
					<p>Nhận thông tin ưu đãi và sản phẩm mới nhất!</p>
					<div class="input-group" style="display:flex; flex-direction:row; align-items:center; justify-content:between; width:100%;">
			        	<input type="email" class="form-control" placeholder="Nhập email của bạn" name="email_subscribe"  style="padding: 10px; margin-right:5px; border: 1px solid #fefaf4; border-radius: 5px; outline: none; width:60%; height:40px;">
			         	<span style="width:30%">
			         	<button class="btn btn-theme" type="submit" name="form_subscribe" style="padding: 10px; background-color: #f6dbab; color: #7f572e; border: none; border-radius: 5px; cursor: pointer; height:40px;">Đăng ký</button>
			         	</span>
			        </div>
				</div>
				</form>
				


<?php endif; ?>

  </div>
  <hr style="border: 1px solid #f6dbab; margin-top: 20px; margin-bottom: 20px; width: 100%; margin-left: auto; margin-right: auto;"/>
  <div style="text-align: center; margin-top: 20px; font-size: 14px;">
    <p>© 2024 Đô Si La Mi. All rights reserved.</p>
  </div>
</footer>
