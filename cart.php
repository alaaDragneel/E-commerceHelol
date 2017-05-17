<?php
	ob_start();
	include "connect.php";
	include "includes/functions/functions.php";
	
	$pageTitle = "products Page";
	include "includes/templates/header.php";
	
	include "includes/templates/navbar.php";

	@$do 	  = $_GET['do'];
	@$id 	  = $_GET["id"];
	@$offerId = $_GET["offerId"];
	if($do == 'wish') {
		echo "<h1 class='text-center' >insert wish list page</h1>";
	    $insertWish = $conn->prepare("INSERT INTO whishlist(Product_id, UserID) VALUES( :pro, :user)");
	    $insertWish->execute(array(

	        'pro'   => $id,
	        'user'  => $_SESSION['userId']

	        ));
	    //echo success massage
	     $msg = '<div class="alert alert-success"> Recourd inserted the inserted product</div>';

	     redirect($msg, 'prev', 'prev');
	} 

	if($do == 'cart') {

		echo "<h1 class='text-center' >insert cart page</h1>";
	    $insertCart = $conn->prepare("INSERT INTO shopping_basket(Product_id, UserID) VALUES( :pro, :user)");
	    $insertCart->execute(array(

	        'pro'   => $id,
	        'user'  => $_SESSION['userId']

	        ));
	    //echo success massage
	     $msg = '<div class="alert alert-success"> Recourd inserted the inserted product</div>';

	     redirect($msg, 'prev', 'prev');

 	}

 	if($do == 'pay'){
 		echo"welcime to pay";
 	}
 	include "includes/templates/footer.php";
    ob_end_flush(); 