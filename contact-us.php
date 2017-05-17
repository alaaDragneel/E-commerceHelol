<?php
	ob_start();
	include "connect.php";
	include "includes/functions/functions.php";

	$pageTitle = "contact us Page";
	include "includes/templates/header.php";

	include "includes/templates/navbar.php";
	$do = isset($_GET['do']) ? $_GET['do'] : 'Manage'; // Check if the $do is Exixets
?>
<!--***********************************
	CONTACT SECTION
************************************-->
<?php if($do == "Manage"){ ?>
<section id="contact-us">
	<div class="container">
		<div class="form-header">
			<h1>Contact Us</h1>
			<h2>We Wanna hear from you</h2>
		</div>
		<!-- <div style="clear:both;"></div> -->
		<div class="contact-form">
			<form action="?do=send" method="POST">
				<input name="username" type="text" placeholder="Name" name="username" required="required">
				<input name="email" type="email" placeholder="Email" required="required">
				<textarea name="content" name="message" placeholder="Message" rows="5" required="required"></textarea>
				<input type="submit" class="btn" name="Send" value="Send"></button>
			</form>
		</div>
	</div>
</section>
<?php } ?>
<!--Start PHP Code-->
<?php
if($do == 'send'){
	echo "<div class='container'>";
	echo "<h2>Sending</h2>";
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if (isset($_POST['Send'])){
			$username = trim(strip_tags($_POST['username']));
			$email	  =	trim(strip_tags($_POST['email']));
			$content  = trim(strip_tags($_POST['content']));

			$valid = array();

			if(empty($username)){
				$valid[] = "<div class='alert alert-danger'>The UserName Is Required</div>";
			}
			if(empty($email)){
				$valid[] = "<div class='alert alert-danger'>The Email Is Required</div>";
			}
			if(empty($content)){
				$valid[] = "<div class='alert alert-danger'>The Massge Content Is Required</div>";
			}
			foreach ($valid as $error) {
				echo $error;
			}
			if(empty($valid)){
				$sql = "INSERT INTO `msg`(`Username`, `Email`, `Content`) VALUES (:name, :email, :content)";
				$stmt = $conn->prepare($sql);
				$stmt->execute(array(
					'name' => $username,
					'email' => $email,
					'content' => $content
				));
				$msg = "<div class='alert alert-success'>The Massge Has Been Sent Sucessfully</div>";
				redirect($msg, 5);
			}
		}
	}else {
		echo "<div class='alert alert-danger'>Sorry The req Method is not POST</div>";
	}
	echo "</div>";
}
?>
<!--End PHP Code-->
<?php

	include "includes/templates/footer.php";
	ob_end_flush();
?>
