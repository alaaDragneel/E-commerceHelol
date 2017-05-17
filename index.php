<?php
	ob_start();
	include "connect.php";
	include "includes/functions/functions.php";

	$pageTitle = "Home Page";
	include "includes/templates/header.php";

	include "includes/templates/navbar.php";

	if (@$_SESSION["logged_as_blocker"] == 'yes') {
        header("Location: blocked.php");

                exit();
            }
?>
<!--Main Slider SECTION-->
<header id="header">
	<div class="container-fluid">
		<div id="header-left" class="float-left">
			<div class="lg-add float-left">
				<img src="Layout/img/header-add.jpg" alt="addvertisment">
			</div>
		</div>
		<div id="header-right" class="float-left">
			<!--OWL CAROUSEL SECTION-->
			<div class="header-carousel">
			<?php
				$slider = 1;
				$selectPro = $conn->prepare("SELECT * FROM products JOIN offers ON offers.product_id = products.product_id WHERE groupId = 1 ORDER BY id DESC LIMIT 6");
				$selectPro->execute();
				$rows = $selectPro->fetchAll();
				foreach($rows as $row) {
			?>
				<div class="item" style="background-size:863px 405px; background-repeat: no-repeat; background-image: url('layout/img/product_image/<?php echo $row["Image"]?>');" id="slide-<?php echo $slider++;?>" >

					<div class="offer-lable">Offer for : <?php echo $row["model_name"]?></div>
					<h1><?php echo $row["offername"]?></h1>
					<p>shop with us and get <?php echo $row["offerPrice"]?> discound and more</p>
					<a href='products.php?do=detailsOffer&proid=<?php echo $row['product_id']?>&offerid=<?php echo $row['id']?>' class='btn'>Shop Now</a>
				</div>
				<?php }?>
			</div>
		</div>
		<div style="clear:both;"></div>
	</div>
</header>

<!--OFFERS SECTION-->
<section id="offers">
	<div class="container-fluid">
		<div class="offers-carousel">
			<!--CAROUSEL ITEMS-->
			<?php
				$selectPro = $conn->prepare("SELECT * FROM products JOIN offers ON offers.product_id = products.product_id WHERE groupId = 1 ORDER BY id DESC LIMIT 6");

				$selectPro->execute();
				$rows = $selectPro->fetchAll();
				foreach($rows as $row) {?>
			<div class="item">
				<img width="350" height="309" src="layout/img/product_image/<?php echo $row["Image"]?> " alt="<?php echo $row["model_name"]?> " title="<?php echo $row["model_name"]?>" />
				<div class="offer-item">
					<?php if($row["offername"] !== '') {
						echo '<h2>'. $row["model_name"].'</h2>';
						echo '<h2>Offer: '. $row["offerPrice"].'</h2>';
						echo '<p><del>Price: '. $row["price"].'</del></p>';
						echo "<a href='products.php?do=detailsOffer&proid=".$row['product_id']."&offerid=" . $row['id'] . "' class='btn'>Shop Now</a>";
					}

				echo "</div>";
				echo "</div>";
				}
					?>
		</div>
	</div>
</section>



<!--MOST RECENT SECTION-->
<section id="most-recent">
	<div class="container-fluid">
		<div class="most-recent-carousel">
			<!--CAROUSEL ITEMS-->
			<?php
				$selectPro = $conn->prepare("SELECT * FROM products WHERE groupId = 1 ORDER BY product_id DESC LIMIT 6");

				$selectPro->execute();
				$rows = $selectPro->fetchAll();
				foreach($rows as $row) {
			echo '<div class="item">';
				echo '<img width="350" height="309" src="layout/img/product_image/'. $row["Image"] .' " alt="'. $row["model_name"].'" title="'. $row["model_name"].'"/>';
				echo '<div class="most-recent-item">';
				echo'<h2>Most recent</h2>';
				echo '<h2>'. $row["model_name"].'</h2>';
				echo "<a href='products.php?do=details&proid=".$row['product_id']."' class='btn'>Shop Now</a>";
				echo "</div>";
			echo "</div>";
		}
		?>
		</div>
	</div>
</section>



<?php

	include "includes/templates/footer.php";

    ob_end_flush();

?>
