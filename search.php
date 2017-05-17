<?php
	ob_start();
	include "connect.php";
	include "includes/functions/functions.php";

	$pageTitle = "Search Page";
	include "includes/templates/header.php";

	include "includes/templates/navbar.php";

	if (@$_SESSION["logged_as_blocker"] == 'yes') {

        header("Location: blocked.php");

        exit();
    }
?>
<div class="myproducts">
	<div style="margin-bottom:100px;" class="container">
		<h1 class="text-center">Products With Out Offer</h1>
		<?php
		@$s_result = $_GET['s_result'];
		$terms = explode(" ", $s_result);
		$query = "SELECT * FROM products WHERE ";
		foreach ($terms as $term) {
			@$i++;
			if ($i == 1) {
				$query .= "model_name LIKE '%$term%' && groupId = 1";
			}else{
				$query .= "OR model_name LIKE '%$term%' && groupId = 1";
			}
		}
		$stmt = $conn->prepare($query);
		$stmt->execute();
		$pros = $stmt->fetchAll();
		$count = $stmt->rowCount();
		if ($count > 0) {
			foreach ($pros as $pro) {?>
			<div class="col-md-3">
		        <div class="item">
		        	<p class="productName"><?php echo $pro['model_name']; ?></p>
		            <div class="img-container">
		              <img class="img-responsive" src="Layout/img/product_image/<?php echo $pro['Image']; ?>"/>
		            </div>
		          <div class="detals">
		                <p>Price: <?php echo $pro['price']; ?>$</p>
		                <a class='btn' href="products.php?do=details&proid=<?php echo $pro['product_id']; ?>">Details</a>
		          </div>
		        </div>
		    </div>
	<?php	}
		}else{
			echo "<div style='margin-top:100px;' class='alert alert-danger'><h2>Sorry</h2>No Results Found \"$s_result\"</div>";
		}
	?>

	</div>
</div>
 <hr class="hr" />
 <div class="myproducts">
          <div class="container">
                <h1 class="text-center">Products With Offer</h1>
                <?php
                @$s_result = $_GET['s_result'];
				$terms = explode(" ", $s_result);
				$query = "SELECT * FROM `products` JOIN offers ON offers.product_id = products.product_id AND products.model_name LIKE '%$term%' && groupId = 1";
				$stmt = $conn->prepare($query);
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
                            <a class='btn' href="products.php?do=detailsOffer&proid=<?php echo $pro['product_id']; ?>&offerid=<?php echo $pro['id']; ?>">Details</a>
                      </div>
                    </div>
                </div>
            <?php   }//endloop
                }else{
					echo "<div style='margin-top:100px;' class='alert alert-danger'><h2>Sorry</h2>No Offer Results Found \"$s_result\"</div>";
				}
            ?>
          </div>
        </div>

<?php

	include "includes/templates/footer.php";

    ob_end_flush();

?>
