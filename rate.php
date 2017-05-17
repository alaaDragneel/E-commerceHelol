<?php 
session_start();
include "connect.php";
include "includes/functions/functions.php";
	function rating(){

		global $conn;
		 $select = $conn->prepare("SELECT * FROM rating WHERE product_id = ? && userId = ?");
        
                                $select->execute(array( $_SESSION["proId"], $_SESSION["userId"]));
        
                                $row = $select->fetch();
        if($row["ratingLike"] == 0 && $row["ratingDisLike"] == 0) {                        
		
			$q = isset($_GET['q']) && is_numeric($_GET['q']) ? intval($_GET['q']) : 0;
			
				//start insert part
				$stmtSub = $conn->prepare("INSERT INTO `rating`(`ratingLike`, `userId`, `product_id`) VALUES(:rate, :user, :pro)");

				$stmtSub->execute(array(

					'rate'		=> $q,
					'user'		=> $_SESSION["userId"],
					'pro'		=> $_SESSION["proId"]

					));
		}
		if($row["ratingLike"] == 0 && $row["ratingDisLike"] > 0) {
			$q = 1;
			//start insert part
			$stmtSub = $conn->prepare("UPDATE `rating` SET `ratingLike`= ? ,`ratingDisLike`= ? WHERE `userId`= ? && `product_id`= ? ");

			$stmtSub->execute(array(
			 $q,0,
			 $_SESSION["userId"],
			$_SESSION["proId"]

				));
		}
	}
	rating();
	echo '<button class="btn btn-danger" name="DisLike" onClick="DisLike(this.value)"> <i class="fa fa-thumbs-o-down"></i> DisLike '.countLikes('ratingDisLike', 'rating', 1, 'ratingDisLike',$_SESSION["proId"]).'</button>';

	
	?>

	

