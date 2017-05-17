<?php
	ob_start();
	include "connect.php";
	include "includes/functions/functions.php";

	$pageTitle = "Admin Controller";
	include "includes/templates/header.php";

	include "includes/templates/navbar.php";
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage'; // Check if the $do is Exixets
?>
<!--about SECTION-->
<div class="about">
	<div class="container">
		<div class="pic">
			<img style="text-align:center;border-radius:5px;margin-bottom:35px;margin-left:35%" src="Layout/img/slide-4.jpg" alt="">
		</div>
		<div class="lorem">
			<p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
				dolorin reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>
		</div>
	</div>
</div>
<?php

	include "includes/templates/footer.php";

?>
