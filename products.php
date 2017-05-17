<?php
	ob_start();
	include "connect.php";
	include "includes/functions/functions.php";

	$pageTitle = "products Page";
	include "includes/templates/header.php";

	include "includes/templates/navbar.php";

	if (@$_SESSION["logged_as_blocker"] == 'yes') {
        header("Location: blocked.php");
        exit();
    }

	$do = isset($_GET['do']) ? $_GET['do'] : 'Manage'; // Check if the $do is Exixets

?>
<?php if($do == 'Manage'){?>
<link href="Layout/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <div class="myproducts">
          <div class="container">
                <h1 class="text-center">Products With Out Offer</h1>
                <?php
                $stmt = $conn->prepare("SELECT * FROM `products` WHERE groupId = 1 ORDER BY product_id DESC");
                $stmt->execute();
                $pros = $stmt->fetchAll();
                $count = $stmt->rowCount();
                if($count > 0){
                    foreach($pros as $pro){
                ?>
                <div class="col-md-3">
                    <div class="item">
                        <p class="productName"><?php echo $pro['model_name']; ?></p>
                        <div class="img-container">
                          <img class="img-responsive" src="Layout/img/product_image/<?php echo $pro['Image']; ?>"/>
                        </div>
                      <div class="detals">
                            <p>Price: <?php echo $pro['price']; ?>$</p>
                            <a class='btn' href="?do=details&proid=<?php echo $pro['product_id']; ?>">Details</a>
                      </div>
                    </div>
                </div>
            <?php 	}//endloop
                }//endif
            ?>
          </div>
        </div>
        <hr class="hr"/>
        <div class="myproducts">
          <div class="container">
                <h1 class="text-center">Products With Offer</h1>
                <?php
                $stmt = $conn->prepare("SELECT * FROM `products` JOIN offers ON offers.product_id = products.product_id WHERE groupId = 1");
                $stmt->execute();
                $pros = $stmt->fetchAll();
                $count = $stmt->rowCount();
                if($count > 0){
                    foreach($pros as $pro){
                ?>
                <div class="col-md-3">
                    <div class="item">
                        <p class="productName"><?php echo $pro['model_name']; ?></p>
                        <div class="img-container">
                          <img class="img-responsive" src="Layout/img/product_image/<?php echo $pro['Image']; ?>"/>
                        </div>
                      <div class="detals">
                            <h2>Offer:  <?php echo $pro["offerPrice"]?></h2>
                            <p><del>Price: <?php echo $pro['price']; ?>$</del></p>
                            <a class='btn' href="?do=detailsOffer&proid=<?php echo $pro['product_id']; ?>&offerid=<?php echo $pro['id']; ?>">Details</a>
                      </div>
                    </div>
                </div>
            <?php   }//endloop
                }//endif
            ?>
          </div>
        </div>
<?php } ?>
<?php
if($do == 'detailsOffer'){
        // Check that the userid is numeric and exesits
        $proid      = isset($_GET['proid']) && is_numeric($_GET['proid']) ? intval($_GET['proid']) : 0;
        $offerid    = isset($_GET['offerid']) && is_numeric($_GET['offerid']) ? intval($_GET['offerid']) : 0;

        $stmt = $conn->prepare("SELECT
                                     *
                                FROM products
                                JOIN
                                    offers
                                ON offers.product_id = products.product_id
                                JOIN
                                    users
                                ON users.userID =  products.userId
                                WHERE products.product_id = ? && offers.id = ?
                        ");

        $stmt->execute(array($proid, $offerid));

        $row = $stmt->fetch();
        $priceOffer = $row['price'] - $row['offerPrice'];
        $count = $stmt->rowCount();
        $_SESSION["proId"] = $row["product_id"];
        if($count > 0){

       echo '<h2 class="text-center h2">Products With Offer by '. $row['offerPrice'] .' From '. $row['price'] .' </h2>';
            ?>
            <div class="container">
                <div class="mydetails">
                    <div class="product">
                        <h2 class="text-center h2"><?php echo $row['model_name'] ?></h2>
                        <span class="alert alert-info rat">liked by <?php echo countLikes('ratingLike', 'rating', 1,'ratingLike',$_SESSION["proId"])?></span>
                        <span class="alert alert-danger rat">disliked by <?php echo countLikes('ratingDisLike', 'rating', 1,'ratingDisLike',$_SESSION["proId"])?></span>
                        <hr>
                        <div class="img-container">
                            <img class="img-responsive" src="Layout/img/product_image/<?php echo $row['Image']; ?>" width="300">
                        </div>
                        <div class="details">
                            <h2>describtion</h2>
                            <p><?php echo $row['Details'] ?></p>
                            <h4>Addition Date: <?php echo $row['Date'] ?></h4>
                             <?php if(isset($_SESSION["username"]) && $_SESSION["logged"] == 'yes') {?>
                            <a href="cart.php?do=cart&id=<?php echo $proid ?>&offerId=<?php echo $offerid ?>" class="btn btn-block" name="addCart"> <i class="fa fa-shopping-cart"></i> Add To Cart</a>
                            <a href="cart.php?do=wish&id=<?php echo $proid ?>" class="btn btn-block" name="addCart"> <i class="fa fa-shopping-cart"></i> Add To Wish List</a>
                            <a href="cart.php?do=pay&id=<?php echo $proid ?>" class="btn btn-block">Buy Now after offer For <?php echo $priceOffer ?> $ only</a>
                            <?php
                                }else{
                                    echo "<div class='alert alert-danger' > You Must LogIn to Can buy this product</div>";
                                }

                             ?>
                            <div class="sellerInfo">
                                <legend>Seller Information</legend>
                                <span class="userimg"><img class="img-thumbnail" src="Layout/img/users_image/<?php echo $row['userImg'] ?>" /></span>
                                <span class="usrname">Seller Name: <span><?php echo $row['username'] ?></span></span>
                                <span class="usrmail">Seller Email: <span> <?php echo $row['Email'] ?></span></span>
								<span class="usrrate">Seller Rating: <span> <?php if($row['GroupID'] == 3){echo 'trusted';}elseif($row['GroupID'] == 2){if($row['Rate'] > 0){echo 'trusted';}else{echo 'not Trusted';}} ?></span></span>
								<?php if ($row['Rate'] = 0): ?>
									<span class="usrerare2"><a class="btn" style="display:block;margin-top:5px;" href="products.php?do=sellerrating&userid=<?php echo $row['userID'] ?>">Rate This Seller</a></span>
								<?php endif; ?>
                            </div>
                            <div class="proRating">
                             <?php if(isset($_SESSION["username"]) && $_SESSION["logged"] == 'yes') {?>
                                <?php
                                    $select = $conn->prepare("SELECT * FROM rating WHERE product_id = ? && userId = ?");

                                    $select->execute(array( $_SESSION["proId"], $_SESSION["userId"]));

                                    $row = $select->fetch();
                                    if($row["ratingLike"] > 0  && $row["ratingDisLike"] == 0 && $row["userId"] == $_SESSION["userId"]){
                                        echo ' <span id="txtHint" ><button class="btn btn-danger" name="DisLike" onClick="DisLike(this.value)"> <i class="fa fa-thumbs-o-down"></i> DisLike '.countLikes('ratingDisLike', 'rating', 1,'ratingDisLike', $_SESSION["proId"]).'</button></span';
                                    }
                                    if($row["ratingLike"] == 0 && $row["ratingDisLike"] == 0){
                                ?>
                                  <span id="txtHint" > <button class="btn btn-success like" onClick="likeDisLike(this.value)" name="like"> <i class="fa fa-thumbs-o-up"></i> Like <?php countLikes('ratingLike', 'rating', 1,'ratingLike', $_SESSION["proId"]);?></button></span>
                                   <?php
                                        }
                                        if($row["ratingLike"] == 0 && $row["ratingDisLike"] > 0){
                                              echo ' <span id="txtHint" ><button class="btn btn-success like" onClick="likeDisLike(this.value)" name="like"> <i class="fa fa-thumbs-o-up"></i> Like '.countLikes('ratingLike', 'rating', 1,'ratingLike', $_SESSION["proId"]).'</button></span';
                                        }

                                    }else{
                                    echo "<div class='alert alert-danger'style='margin-top: 10px;' > You Must LogIn to Can rate this product</div>";
                                }?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

<?php
    	}
    }
    if($do == 'details'){
    // Check that the userid is numeric and exesits

    $proid = isset($_GET['proid']) && is_numeric($_GET['proid']) ? intval($_GET['proid']) : 0;

    $stmt = $conn->prepare("SELECT *

                            FROM products JOIN users ON users.userID =  products.userId

                             WHERE `product_id` = ?");

    $stmt->execute(array($proid));

    $row = $stmt->fetch();
	$_SESSION["proId"] = $row["product_id"];
    $count = $stmt->rowCount();
    if($count > 0){ ?>
        <div class="container">
            <div class="mydetails">
                <div class="product">
                    <h2 class="text-center h2"><?php echo $row['model_name'] ?></h2>
                   <span class="alert alert-info rat">liked by <?php echo countLikes('ratingLike', 'rating', 1,'ratingLike',$_SESSION["proId"])?></span>
                        <span class="alert alert-danger rat">disliked by <?php echo countLikes('ratingDisLike', 'rating', 1,'ratingDisLike',$_SESSION["proId"])?></span>
                    <hr>
                    <div class="img-container">
                        <img class="img-responsive" src="Layout/img/product_image/<?php echo $row['Image']; ?>" width="300">
                    </div>
                    <div class="details">
                        <h2>describtion</h2>
                        <p><?php echo $row['Details'] ?></p>
                        <h4>Addition Date: <?php echo $row['Date'] ?></h4>
                        <?php if(isset($_SESSION["username"]) && $_SESSION["logged"] == 'yes') {?>
                        <a href="cart.php?do=cart&id=<?php echo $proid ?>" class="btn btn-block" name="addCart"> <i class="fa fa-shopping-cart"></i> Add To Cart</a>
                         <a href="cart.php?do=wish&id=<?php echo $proid ?>" class="btn btn-block" name="addCart"> <i class="fa fa-shopping-cart"></i> Add To Wish List</a>
                        <a href="cart.php?do=pay&id=<?php echo $proid ?>" class="btn btn-block">Buy Now For <?php echo $row['price'] ?> $ only</a>
                        <?php
                            }else{
                                echo "<div class='alert alert-danger' > You Must LogIn to Can buy this product</div>";
                            }

                        ?>
                        <div class="sellerInfo">
                            <legend>Seller Information</legend>
                            <span class="userimg"><img class="img-thumbnail" src="Layout/img/users_image/<?php echo $row['userImg'] ?>" /></span>
                            <span class="usrname">Seller Name: <span><?php echo $row['username'] ?></span></span>
                            <span class="usrmail">Seller Email: <span> <?php echo $row['Email'] ?></span></span>
							<span class="usrrate">Seller Rating: <span> <?php if($row['GroupID'] == 3){echo 'trusted';}elseif($row['GroupID'] == 2){if($row['Rate'] > 0){echo 'trusted';}else{echo 'not Trusted';}} ?></span></span>
							<?php if ($row['Rate'] = 0): ?>
								<span class="usrerare2"><a class="btn" style="display:block;margin-top:5px;" href="products.php?do=sellerrating&userid=<?php echo $row['userID'] ?>">Rate This Seller</a></span>
							<?php endif; ?>
						</div>
                        <div class="proRating">
                        <?php if(isset($_SESSION["username"]) && $_SESSION["logged"] == 'yes') {?>
                            <?php
                                $select = $conn->prepare("SELECT * FROM rating WHERE product_id = ? && userId = ?");

                                $select->execute(array( $_SESSION["proId"], $_SESSION["userId"]));

                                $row = $select->fetch();
                                if($row["ratingLike"] > 0  && $row["ratingDisLike"] == 0 && $row["userId"] == $_SESSION["userId"]){
                                    echo ' <span id="txtHint" ><button class="btn btn-danger" name="DisLike" onClick="DisLike(this.value)"> <i class="fa fa-thumbs-o-down"></i> DisLike '.countLikes('ratingDisLike', 'rating', 1,'ratingDisLike',$_SESSION["proId"]).'</button></span';
                                }
                                if($row["ratingLike"] == 0 && $row["ratingDisLike"] == 0){
                            ?>
                              <span id="txtHint" > <button class="btn btn-success like" onClick="likeDisLike(this.value)" name="like"> <i class="fa fa-thumbs-o-up"></i> Like <?php countLikes('ratingLike', 'rating', 1,'ratingLike',$_SESSION["proId"]);?></button></span>
                               <?php
                                    }
                                    if($row["ratingLike"] == 0 && $row["ratingDisLike"] > 0){
                                          echo ' <span id="txtHint" ><button class="btn btn-success like" onClick="likeDisLike(this.value)" name="like"> <i class="fa fa-thumbs-o-up"></i> Like '.countLikes('ratingLike', 'rating', 1,'ratingLike',$_SESSION["proId"]).'</button></span';
                                    }

                                 }else{
                                    echo "<div class='alert alert-danger'style='margin-top: 10px;' > You Must LogIn to Can rate this product</div>";
                                }?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
        }
    }

    if($do == 'viewProduct'){
        // Check that the userid is numeric and exesits
        $catId       = isset($_GET['cayegoryId']) && is_numeric($_GET['cayegoryId']) ? intval($_GET['cayegoryId']) : 0;
        $subCatId    = isset($_GET['brandId']) && is_numeric($_GET['brandId']) ? intval($_GET['brandId']) : 0;

        // start select statment to  get the product by the brand
        /*
        ** select from the products table the data
        ** use the $catId to can select the category
        ** use the $subCatId to can select the subcateegory for the products
        */

        $proSelect = $conn->prepare("SELECT
                                            *
                                    FROM
                                        products
                                    JOIN
                                        categories
                                    JOIN
                                        subcategories
                                    ON
                                        categories.Cat_ID = products.Cat_ID
                                    &&
                                        categories.Cat_ID = ?
                                    &&
                                        subcategories.subCatId = products.subCatId
                                    &&
                                        subcategories.subCatId = ?
                                    WHERE
                                        groupId = 1

                                 ");

        $proSelect->execute(array( $catId, $subCatId));
        $count = $proSelect->rowCount();
        if($count > 0) {
        $rows = $proSelect->fetchAll();
        ?>
        <div class="myproducts">
          <div class="container">
                <h1 class="text-center">Our Products</h1>
                <?php foreach($rows as $row) {?>
                <div class="col-md-3">
                    <div class="item">
                        <p class="productName"><?php echo $row['model_name']; ?></p>
                        <div class="img-container">
                          <img class="img-responsive" src="Layout/img/product_image/<?php echo $row['Image']; ?>"/>
                        </div>
                      <div class="detals">
                            <p>Price: <?php echo $row['price']; ?>$</p>
                            <a class='btn' href="?do=details&proid=<?php echo $row['product_id']; ?>">Details</a>
                      </div>
                    </div>
                </div>
                <?php
                    }
                   }else{
                    echo "<div class='alert alert-danger text-center' style='margin-top:42px;' >Sorry there are no Products In This Brand</div>";
                   }
                ?>
          </div>
        </div>
        <hr class="hr"/>

<?php
    }
?>
</div>
<!--Start Seller Rating-->
<?php
	if($do == 'sellerrating'){
		// Check that the userid is numeric and exesits

		$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

		// Select all data From the table of users

		$stmt = $conn->prepare("SELECT * FROM users WHERE userID = ? LIMIT 1");

		// execute the data

		$stmt->execute(array($userid));

		// Count the rows

		$count = $stmt->rowCount();

		// if there is such id show the form

		if ($count > 0) {

			echo '<h1 class="text-center Head">Seller Rating Page</h1>';

			echo '<div class="container">';

			$sel = $conn->prepare("SELECT Rate FROM users WHERE userID = ?");

			$sel->execute(array($userid));

			$c = $sel->rowCount();

			$rate = $c + 1;

			$stmt = $conn->prepare("UPDATE users SET Rate = $rate WHERE userID = ?");

			$stmt->execute(array($userid));

			$msg = '<div class="alert alert-success">' . $stmt->rowCount() . " User Rated Thank You</div>";

			redirect($msg, "back", $page = 'prev', 5);


		}else{

			$msg = 'This id is not exesist';

			redirect($msg, "back", $page = 'prev', 5);

		}

		echo "</div>";
	}
?>
<!--End Seller Rating-->
<?php
	include "includes/templates/footer.php";

    ob_end_flush();

?>
