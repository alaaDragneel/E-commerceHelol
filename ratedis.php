<?php
session_start();
include "connect.php";
include "includes/functions/functions.php";
	function ratingDis(){

		global $conn;

		$s = isset($_GET['s']) && is_numeric($_GET['s']) ? intval($_GET['s']) : 0;

			//start insert part
			$stmtSub = $conn->prepare("UPDATE `rating` SET `ratingLike`= ?,`ratingDisLike`= ? WHERE `userId`= ? && `product_id`= ? ");

			$stmtSub->execute(array(
			 0, $s,
			 $_SESSION["userId"],
			 $_SESSION["proId"]

				));
	}
	ratingDis();
	echo '<button class="btn btn-success like" onClick="likeDisLike(this.value)" name="like"> <i class="fa fa-thumbs-o-up"></i> Like '.countLikes('ratingLike', 'rating', 1, 'ratingLike',$_SESSION["proId"]).' </button>';

	?>
