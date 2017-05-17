<?php
	ob_start();
	include "connect.php";
	include "includes/functions/functions.php";

	$pageTitle = "Admin Controller";
	include "includes/templates/header.php";

	include "includes/templates/navbar.php";
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage'; // Check if the $do is Exixets
?>

<link href="Layout/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<?php
if($do == 'allMembers'){?>
			<!--Start members-->
            <div class="mix members">
				<!--Start PHP CODE-->
                <?php
                $stmt = $conn->prepare("SELECT * FROM `users` WHERE GroupID != 3 ORDER BY userID ASC");
                $stmt->execute();
                $rows = $stmt->fetchAll();
                $count = $stmt->rowCount();
                ?>
                <!--End PHP CODE-->
                <div class="myprofile" style="margin-top: 20px;">
					<h2 class="text-center text-info">Members Manage</h2>
					<hr />
					<p style="color:#f00">This Record previwes The Last 30 Product</p>
                    <table class="table table-bordered main-table text-center">
                        <tr>
                            <td>#ID.</td>
                            <td>Name</td>
                            <td>Image</td>
                            <td>National ID</td>
                            <td>Email</td>
							<td>Action</td>
                        </tr>
                        <?php
                        if($count > 0){
                            foreach ($rows as $row) {?>
                                <tr>
                                    <td><?php echo $row['userID']; ?></td>
                                    <td><?php echo $row['username']; ?></td>
									<td><img width="64" height="64" src="Layout/img/users_image/<?php echo $row['userImg']; ?>"></td>
                                    <td><?php echo $row['National_ID']; ?></td>
                                    <td><?php echo $row['Email']; ?></td>
									<td>
										<?php if($row['GroupID'] == 0){ ?>
										<a href="?do=AppMember&userid=<?php echo $row['userID']; ?>" style="margin-bottom:5px;" class="btn btn-info btn-block confirm">Approve Members</a>
										<?php }elseif ($row['GroupID'] > 0 && $row['GroupID'] < 3){ ?>
										<a href="?do=BlockMember&userid=<?php echo $row['userID']; ?>" style="margin-bottom:5px;" class="btn btn-danger btn-block confirm">Block</a>
										<?php } ?>
										<a href="?do=AdminMember&userid=<?php echo $row['userID']; ?>" style="margin-bottom:5px;background-color: #9E9E9E;border-color: #9E9E9E;" class="btn btn-primary btn-block confirm">Set As Admin</a>
									</td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </table>
					<div class="clearfix"></div>
				</div>
			</div>
			<!--Start members-->
<?php
}
if($do == 'pendSeller'){?>
<!--Start pending sellers-->
            <div class="mix sellers">
				<!--Start PHP CODE-->
                <?php
                $stmt = $conn->prepare("SELECT * FROM `users` WHERE GroupID = 4 ORDER BY userID ASC");
                $stmt->execute();
                $rows = $stmt->fetchAll();
                $count = $stmt->rowCount();
                ?>
                <!--End PHP CODE-->
                <div class="myprofile" style="margin-top: 20px;">
					<h2 class="text-center text-info">Pending Sellers</h2>
					<hr />
					<p style="color:#f00">This Record previwes The the Users That wants to be sellers</p>
                    <table class="table table-bordered main-table text-center">
                        <tr>
                            <td>#ID.</td>
                            <td>Name</td>
                            <td>Image</td>
                            <td>National ID</td>
                            <td>Email</td>
							<td>Action</td>
                        </tr>
                        <?php
                        if($count > 0){
                            foreach ($rows as $row) {?>
                                <tr>
                                    <td><?php echo $row['userID']; ?></td>
                                    <td><?php echo $row['username']; ?></td>
									<td><img width="64" height="64" src="Layout/img/users_image/<?php echo $row['userImg']; ?>"></td>
                                    <td><?php echo $row['National_ID']; ?></td>
                                    <td><?php echo $row['Email']; ?></td>
									<td>
										<a href="?do=SellerMember&userid=<?php echo $row['userID']; ?>" style="margin-bottom:5px;" class="btn btn-primary btn-block">Set As Seller</a>
									</td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </table>
					<div class="clearfix"></div>
				</div>
			</div>
			<!--End pending sellers-->
<?php
}
if($do == 'allMassages'){?>
<!--Start massegs-->
            <div class="mix massges">
                <!--Start PHP CODE-->
                <?php
                $stmt = $conn->prepare("SELECT * FROM `msg`");
                $stmt->execute();
                $rows = $stmt->fetchAll();
                $count = $stmt->rowCount();
                ?>
                <!--End PHP CODE-->
                <div class="myprofile" style="margin-top: 20px;">
					<h2 class="text-center text-info">My Massegs</h2>
					<hr />
                    <table class="table table-bordered main-table text-center">
                        <tr>
                            <td>#NO.</td>
                            <td>User Name</td>
                            <td>Email</td>
                            <td>Content</td>
                            <td>Action</td>
                        </tr>
                        <?php
                        if($count > 0){
                            foreach ($rows as $row) {?>
                                <tr>
                                    <td><?php echo $row['ID']; ?></td>
                                    <td><?php echo $row['Username']; ?></td>
                                    <td><?php echo $row['Email']; ?></td>
                                    <td><?php echo $row['Content']; ?></td>
                                    <td>
        								<a href="?do=deleteMsg&msgid=<?php echo $row['ID']; ?>" class="btn btn-danger confirm"><i class='fa fa-close'></i>Delete</a>
        							</td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </table>
                    <div class="clearfix"></div>
                </div>
            </div>
			<!--End massages-->
<?php
}
if($do == 'Manage'){
?>
    <div class="container">
    <div class="row">
        <ul class="ul">
            <li class="selected filter" data-filter="all">all</li>
            <li class="filter" data-filter=".massges" >massges</li>
            <li class="filter" data-filter=".productApp">Product Approvements</li>
            <li class="filter" data-filter=".sellers">Pendding Sellers</li>
            <li class="filter" data-filter=".members">All Members</li>
			<li class="filter" data-filter=".Add_Product">Add Product</li>
	        <li class="filter" data-filter=".Add_Categoury">Add Categoury</li>
	        <li class="filter" data-filter=".Add_Offer">Add Offer</li>
	        <li class="filter" data-filter=".Add_Ads">Add Ads</li>
	        <li class="filter" data-filter=".Edit_Product">Edit Product</li>
	        <li class="filter" data-filter=".Edit_Categoury">Edit Categoury</li>
	        <li class="filter" data-filter=".Edit_Offer">Edit Offer</li>
        </ul>
        <div id="Container">
			<!--Start massegs-->
            <div class="mix massges">
                <!--Start PHP CODE-->
                <?php
                $stmt = $conn->prepare("SELECT * FROM `msg`");
                $stmt->execute();
                $rows = $stmt->fetchAll();
                $count = $stmt->rowCount();
                ?>
                <!--End PHP CODE-->
                <div class="myprofile">
					<h2 class="text-center text-info">My Massegs</h2>
					<hr />
                    <table class="table table-bordered main-table text-center">
                        <tr>
                            <td>#NO.</td>
                            <td>User Name</td>
                            <td>Email</td>
                            <td>Content</td>
                            <td>Action</td>
                        </tr>
                        <?php
                        if($count > 0){
                            foreach ($rows as $row) {?>
                                <tr>
                                    <td><?php echo $row['ID']; ?></td>
                                    <td><?php echo $row['Username']; ?></td>
                                    <td><?php echo $row['Email']; ?></td>
                                    <td><?php echo $row['Content']; ?></td>
                                    <td>
        								<a href="?do=deleteMsg&msgid=<?php echo $row['ID']; ?>" class="btn btn-danger confirm"><i class='fa fa-close'></i>Delete</a>
        							</td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </table>
                    <div class="clearfix"></div>
                </div>
            </div>
			<!--End massages-->
			<!--Start Product Approvements-->
            <div class="mix productApp">
				<!--Start PHP CODE-->
                <?php
                $stmt = $conn->prepare("SELECT * FROM `products` ORDER BY product_id DESC LIMIT 30");
                $stmt->execute();
                $rows = $stmt->fetchAll();
                $count = $stmt->rowCount();
                ?>
                <!--End PHP CODE-->
                <div class="myprofile">
					<h2 class="text-center text-info">My Products</h2>
					<hr />
					<p style="color:#f00">This Record previwes The Last 30 Product</p>
                    <table class="table table-bordered main-table text-center">
                        <tr>
                            <td>#ID.</td>
                            <td>Name</td>
                            <td>Description</td>
                            <td>Price</td>
                            <td>Date</td>
							<td>Image</td>
							<td>Cat</td>
							<td>Subcat</td>
							<td>Action</td>
                        </tr>
                        <?php
                        if($count > 0){
                            foreach ($rows as $row) {?>
                                <tr>
                                    <td><?php echo $row['product_id']; ?></td>
                                    <td><?php echo $row['model_name']; ?></td>
                                    <td><?php echo $row['Details']; ?></td>
                                    <td><?php echo $row['price']; ?></td>
									<td><?php echo $row['Date']; ?></td>
									<td><img width="64" height="64" src="Layout/img/product_image/<?php echo $row['Image']; ?>" /></td>
									<td><?php echo $row['Cat_ID']; ?></td>
									<td><?php echo $row['subCatId']; ?></td>
                                    <td>
										<?php
										if ($row['groupId'] == 0) { ?>
											<a href="?do=approvePro&proid=<?php echo $row['product_id']; ?>" class="btn btn-info"><i class="fa fa-close"></i>Approve</a>
										<?php
										}else {
										?>
										<a href="?do=hidePro&proid=<?php echo $row['product_id']; ?>" class="btn btn-danger confirm"><i class="fa fa-close"></i>Hide</a>
										<?php
										}
										?>
        							</td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </table>
                    <div class="clearfix"></div>
                </div>
			</div>
			<!--End Product Approvements-->
			<!--Start pending sellers-->
            <div class="mix sellers">
				<!--Start PHP CODE-->
                <?php
                $stmt = $conn->prepare("SELECT * FROM `users` WHERE GroupID = 4 ORDER BY userID ASC");
                $stmt->execute();
                $rows = $stmt->fetchAll();
                $count = $stmt->rowCount();
                ?>
                <!--End PHP CODE-->
                <div class="myprofile">
					<h2 class="text-center text-info">Pending Sellers</h2>
					<hr />
					<p style="color:#f00">This Record previwes The the Users That wants to be sellers</p>
                    <table class="table table-bordered main-table text-center">
                        <tr>
                            <td>#ID.</td>
                            <td>Name</td>
                            <td>Image</td>
                            <td>National ID</td>
                            <td>Email</td>
							<td>Action</td>
                        </tr>
                        <?php
                        if($count > 0){
                            foreach ($rows as $row) {?>
                                <tr>
                                    <td><?php echo $row['userID']; ?></td>
                                    <td><?php echo $row['username']; ?></td>
									<td><img width="64" height="64" src="Layout/img/users_image/<?php echo $row['userImg']; ?>"></td>
                                    <td><?php echo $row['National_ID']; ?></td>
                                    <td><?php echo $row['Email']; ?></td>
									<td>
										<a href="?do=SellerMember&userid=<?php echo $row['userID']; ?>" style="margin-bottom:5px;" class="btn btn-primary btn-block">Set As Seller</a>
									</td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </table>
					<div class="clearfix"></div>
				</div>
			</div>
			<!--End pending sellers-->
			<!--Start members-->
            <div class="mix members">
				<!--Start PHP CODE-->
                <?php
                $stmt = $conn->prepare("SELECT * FROM `users` WHERE GroupID != 3 ORDER BY userID ASC");
                $stmt->execute();
                $rows = $stmt->fetchAll();
                $count = $stmt->rowCount();
                ?>
                <!--End PHP CODE-->
                <div class="myprofile">
					<h2 class="text-center text-info">Members Manage</h2>
					<hr />
					<p style="color:#f00">This Record previwes The Last 30 Product</p>
                    <table class="table table-bordered main-table text-center">
                        <tr>
                            <td>#ID.</td>
                            <td>Name</td>
                            <td>Image</td>
                            <td>National ID</td>
                            <td>Email</td>
							<td>Action</td>
                        </tr>
                        <?php
                        if($count > 0){
                            foreach ($rows as $row) {?>
                                <tr>
                                    <td><?php echo $row['userID']; ?></td>
                                    <td><?php echo $row['username']; ?></td>
									<td><img width="64" height="64" src="Layout/img/users_image/<?php echo $row['userImg']; ?>"></td>
                                    <td><?php echo $row['National_ID']; ?></td>
                                    <td><?php echo $row['Email']; ?></td>
									<td>
										<?php if($row['GroupID'] == 0){ ?>
										<a href="?do=AppMember&userid=<?php echo $row['userID']; ?>" style="margin-bottom:5px;" class="btn btn-info btn-block confirm">Approve Members</a>
										<?php }elseif ($row['GroupID'] > 0 && $row['GroupID'] < 3){ ?>
										<a href="?do=BlockMember&userid=<?php echo $row['userID']; ?>" style="margin-bottom:5px;" class="btn btn-danger btn-block confirm">Block</a>
										<?php } ?>
										<a href="?do=AdminMember&userid=<?php echo $row['userID']; ?>" style="margin-bottom:5px;background-color: #9E9E9E;border-color: #9E9E9E;" class="btn btn-primary btn-block confirm">Set As Admin</a>
									</td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </table>
					<div class="clearfix"></div>
				</div>
			</div>
			<!--Start members-->
			<!--Start Add_Product-->
			<div class="mix Add_Product">
				<div class="myprofile">
					<h2 class="text-center text-info">Add Product</h2>
					<div class="describtion">
						<!--Write PHP CODE HERE PLEASE-->
						<?php
						if (isset($_POST['addProduct'])){
							// get the post value
							$title           = trim(strip_tags($_POST['title']));
							$description     = trim(strip_tags($_POST['description']));
							$price           = trim(strip_tags($_POST['price']));
							$cat 			 = trim(strip_tags($_POST['catSelect']));
							$subCat 		 = trim(strip_tags($_POST['subCatSelect']));
							$dir_name        = dirname(__FILE__) . "/Layout/img/product_image/";
							$path            = $_FILES['img']['tmp_name'];//temporary path
							$name            = $_FILES['img']['name'];
							$size            = $_FILES['img']['size'];
							$type            = $_FILES['img']['type']; //image/png
							$error           = $_FILES['img']['error'];

							/*Start Check the Image Type&Size*/

							if (!$error && is_uploaded_file($path) && in_array($type, array('image/png', 'image/gif', 'image/jpeg', 'image/jpg', 'image/pjpeg', 'image/x-png', 'image/png')) && $size < 200000){
									move_uploaded_file($path, $dir_name . $name);
							}else {
									echo 'error in upload file ' . $error;
							}
							/*End Check the Image Type&Size*/

							//validate the form

							$formErrors = array();
							if (empty($title)) {
									$formErrors[] = 'Title can\'t be empty';
							}
							if (empty($description)) {
									$formErrors[] = 'Description can\'t be empty';
							}
							if (empty($price)) {
									$formErrors[] = 'price can\'t be empty';
							}
							if (empty($name)) {
									$formErrors[] = 'image can\'t be empty';
							}

							if (empty($cat)) {
									$formErrors[] = 'image can\'t be empty';
							}

							if (empty($subCat)) {
									$formErrors[] = 'image can\'t be empty';
							}

							if(!empty($formErrors)){
									//start loop to get the errors
									foreach ($formErrors as $error) {
											echo '<div class="alert alert-danger">'.$error.'</div>';
									}//end loop
							}

							//if the array is empty compelete the query
							if (empty($formErrors)) {
									//check the count of name
									$check = checkItme('model_name', 'products', $title);
									if ($check > 0) {
											echo '<div class="alert alert-danger">the inserted product ( ' . $title . ' ) is exist </div>';
									} else {
											//insert category information into the database
											$stmt = $conn->prepare("INSERT INTO products(model_name, Details, price, Image, Date, groupId, userId, Cat_ID, subCatId) VALUES(:ztitle, :zdesc, :zprice, :zimg, now(), :grp, :user, :zcat, :zsubcat)");
											$stmt->execute(array(
															'ztitle'        => $title,
															'zdesc'         => $description,
															'zprice'        => $price,
															'zimg'          => $name,
															'grp'           => 1,
															'user'          => $_SESSION["userId"],
															'zcat' 			=> $cat,
															'zsubcat' 		=> $subCat
													));
											//echo success massage
											echo '<div class="alert alert-success">' .$stmt->rowCount() . " Recourd inserted the inserted product is ( ". $title ." )</div>";
									}
							}
						}
						?>
						<!--Write PHP CODE HERE PLEASE-->
						<form class="addproduct" action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post" enctype="multipart/form-data">
							<input type="text" class="form-control" name='title' placeholder="Title" required />
								<script>
									function user_info(str/*some thing will send here*/) {
									    if (str.length == 0) {
									        document.getElementById("txtHint").innerHTML = "";
									        return;
									    } else {
									        var xmlhttp = new XMLHttpRequest();


								        	xmlhttp.onreadystatechange = function() {
								            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
								                document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
								            }
								        }	//the way to request		//if page can make any thing to it during the function [true] or not[false]
									        xmlhttp.open("GET", "getSubCat.php?q="+str, true);
									        xmlhttp.send();
								    	}
									}
								</script>
							<?php
								//start show the categorie form database
								 comboSelect('catSelect', 'Select Categoury', 'Cat_ID, Name','categories', 'Cat_ID', 'Name','', 'user_info(this.value)');
							?>

							<div style='height: 0.5px'></div>
							<p id="txtHint"></p>
							<input type="file" class="form-control" name='img' required />
							<textarea class="form-control" name='description' placeholder="Describtion" style="resize:none"></textarea>
							<input type="number" class="form-control" name='price' placeholder="Price" required />
							<input type="submit" class="btn btn-block btn-primary" name='addProduct' value="Add Product">
						</form>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
			<!--End Add_Product-->
			<!--Start Add_Categoury-->
			<div class="mix Add_Categoury">
				<div class="myprofile">
					<h2 class="text-center text-info">Add Categoury</h2>
					<!--Write PHP CODE HERE PLEASE-->
					<?php
					if(isset($_POST['addCat'])){
						$cat        = trim(strip_tags($_POST['cat']));
						$formErrors = array();
						if (empty($cat)) {
							$formErrors[] = 'Categoury field can\'t be empty';
						}
						if(!empty($formErrors)){
							//start loop to get the errors
							foreach ($formErrors as $error) {
								echo '<div class="alert alert-danger"><strong>' . $error . '</strong></div>';
							}//end loop
						}
						if (empty($formErrors)) {
							//check the count of name
							$check = checkItme('Name', 'categories', $cat);
							if ($check > 0) {
								echo '<div class="alert alert-danger">the inserted category ( ' . $cat . ' ) is exist </div>';
							} else {
								//insert categry information into the database
								$stmt = $conn->prepare("INSERT INTO categories (Name, Date,UserID) VALUES (:zcat, now(),:zuser)");
								$stmt->execute(array(
									'zcat'  => $cat,
									'zuser' => $_SESSION['userId']
									));
								//echo success massage
								echo '<div class="alert alert-success">'.$stmt->rowCount()." category inserted the inserted Categoury is ( " . $cat . " ) Categoury</div>";
							}
						}
					}
					?>

					<?php
					if(isset($_POST['addSubCat'])){
						$subCatSelect 	= trim(strip_tags($_POST['subCatSelect']));
						$subCat        	= trim(strip_tags($_POST['subCat']));
						$formErrors = array();
						if (empty($subCat)) {
							$formErrors[] = 'sub Categoury field can\'t be empty';
						}
						if(!empty($formErrors)){
							//start loop to get the errors
							foreach ($formErrors as $error) {
								echo '<div class="alert alert-danger"><strong>' . $error . '</strong></div>';
							}//end loop
						}
						if (empty($formErrors)) {
							//check the count of name
							$st = $conn->prepare("SELECT subCatName, Cat_ID FROM subcategories WHERE subCatName = ? && Cat_ID = ?");
							$st->execute(array($subCat, $subCatSelect));

							$count = $st->rowCount();
							if ($count > 0) {
								echo '<div class="alert alert-danger">the inserted category ( ' . $subCat . ' ) is exist </div>';
							} else {
								//insert categry information into the database
								$stmt = $conn->prepare("INSERT INTO subcategories (subCatName, Cat_ID) VALUES (:zSubCat, :zcatid)");
								$stmt->execute(array(
									'zSubCat'  => $subCat,
									'zcatid' => $subCatSelect
									));
								//echo success massage
								echo '<div class="alert alert-success">'.$stmt->rowCount()." sub category inserted the inserted sub Categoury is ( " . $subCat . " ) </div>";
							}
						}
					}
					?>
					<!--Write PHP CODE HERE PLEASE-->
					<form class="addcategoury" action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
						<input type="text" class="form-control" placeholder="Categoury Name" name='cat' required />
						<input type="submit" class="btn btn-block btn-primary" name='addCat' value="Add categoury">
					</form>

					<form class="addcategoury" action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
					<?php
						//start show the categorie form database
						 comboSelect('subCatSelect', 'select Cagtegory', 'Cat_ID, Name','categories', 'Cat_ID', 'Name');
					?>
						<input type="text" class="form-control" placeholder="sub categoury Name" name='subCat' required />
						<input type="submit" class="btn btn-block btn-primary" name='addSubCat' value="Add Sub categoury">
					</form>
					<div class="clearfix"></div>
				</div>
			</div>
			<!--End Add_Categoury-->
			<!--Start Add_Offer-->
			<div class="mix Add_Offer">
				<div class="myprofile">
					<h2 class="text-center text-info">Post Offer</h2>
					<!--Write PHP CODE HERE PLEASE-->
					 <?php
					 if($_SERVER['REQUEST_METHOD'] == 'POST'){
						if(isset($_POST['submitoffer'])){
							$proId = $_POST["selectProOffer"];
							//get the post value
							$offername      = trim(strip_tags($_POST['offername']));
							$offerPrice     = trim(strip_tags($_POST['offerPrice']));
							//error array
							$formErrors = array();
							if(empty($offername)){
								$formErrors[] = "The Offer Name Must Not Be Empty";
							}
							if(empty($offerPrice)){
								$formErrors[] = "The Offer Price Must Not Be Empty";
							}
							if(!empty($formErrors)){
								foreach($formErrors as $err){
									echo "<div class='alert alert-danger'>".$err."</div>";
								}
							}else{
								$stmt = $conn->prepare("INSERT INTO `offers`(`offername`, offerPrice ,product_id) VALUES (:offername, :offerPrice, :product_id)");
								$stmt->execute(array(
									'offername'  => $offername,
									'offerPrice' => $offerPrice,
									'product_id' => $proId
								));
								$count =  $stmt->rowCount();
								echo "<div class='alert alert-success'>".$count. " Offer Inserted" ."</div>";
							}
						}
					}
					 ?>
					<!--Write PHP CODE HERE PLEASE-->
					<form class="addcategoury" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
						<input type="text" class="form-control" name="offername" placeholder="Offer Name" required />
						<input type="number" class="form-control" name="offerPrice" placeholder="Offer Price" required />
						<?php comboSelect("selectProOffer", "Select Product to make offer", "product_id, model_name", "products", "product_id", "model_name" ,"WHERE groupId = 1"); ?>
						<input type="submit" name="submitoffer" class="btn btn-block btn-primary" value="Add Offer">
					</form>
					<div class="clearfix"></div>
				</div>
			</div>
			<!--End Add_Offer-->
			<!--Start Add_Ads-->
			<div class="mix Add_Ads">
				<div class="myprofile">
					<h2 class="text-center text-info">Post Ads</h2>
					<!--Write PHP CODE HERE PLEASE-->
					<?php
					// get post value
					if ($_SERVER['REQUEST_METHOD'] == 'POST') {
						if (isset($_POST["submitAds"])) {

						$comName		 = trim(strip_tags($_POST["comName"]));
						$comEmail		 = trim(strip_tags($_POST["comEmail"]));
						$comDesc 		 = trim(strip_tags($_POST["comDesc"]));
						$dir_name        = dirname(__FILE__) . "/Layout/img/ads_image/";
						$path            = $_FILES['img']['tmp_name'];//temporary path
						$name            = $_FILES['img']['name'];
						$size            = $_FILES['img']['size'];
						$type            = $_FILES['img']['type']; //image/png
						$error           = $_FILES['img']['error'];

						/*Start Check the Image Type&Size*/

						if (!$error && is_uploaded_file($path) && in_array($type, array('image/png', 'image/gif', 'image/jpeg', 'image/jpg', 'image/pjpeg', 'image/x-png', 'image/png')) && $size < 200000){
								move_uploaded_file($path, $dir_name . $name);
						}else {
								echo 'error in upload file ' . $error;
						}
						/*End Check the Image Type&Size*/

						$formErrors = array();
							if(empty($comName)){
								$formErrors[] = "The company Name Must Not Be Empty";
							}
							if(empty($comEmail)){
								$formErrors[] = "The company email Must Not Be Empty";
							}
							if(empty($comDesc)){
								$formErrors[] = "The ads description Must Not Be Empty";
							}
							if(empty($name)){
								$formErrors[] = "The ads image Must Not Be Empty";
							}
							if(!empty($formErrors)){
								foreach($formErrors as $err){
									echo "<div class='alert alert-danger'>".$err."</div>";
								}
							}else{
								//prepare the insert the data
								$adsInsert = $conn->prepare("INSERT INTO advertisements(company_name, email, Adv_content, adsImage, userID) VALUES( :cname, :cemail, :cAds, :img, :user)");
								//bind and execute the data
								$adsInsert->execute(array(

									'cname'     => $comName,
									'cemail'    => $comEmail,
									'cAds'      => $comDesc,
									'img'       => $name,
									'user'      => $_SESSION["userId"]

									));
								//count rows
								$count =  $adsInsert->rowCount();
								//sucsses massage
								echo "<div class='alert alert-success'>".$count. " ads Inserted" ."</div>";
							}
						}//end isset if
					}//end server if
					?>
					<!--Write PHP CODE HERE PLEASE-->
					<form class="addcategoury" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
						<input type="text" class="form-control" name="comName" placeholder="company name" required />
						<input type="email" class="form-control" name="comEmail" placeholder="company Email" required />
						<textarea class="form-control" placeholder="Ads content" style="resize:none" name='comDesc' required></textarea>
						<input enctype="multipart/form-data" type="file"  name="img" class="form-control" />
						<input type="submit" name="submitAds" class="btn btn-block btn-primary" value="Add Ads">
					</form>
					<div class="clearfix"></div>
				</div>
			</div>
			<!--End Add_Ads-->
			<!--Start Edit_Product-->
			<div class="mix Edit_Product">
				<div class="myprofile">
					<h2 class="text-center text-info">Edit Product</h2>
					<!--Write PHP CODE HERE PLEASE-->
					<?php

					/*
					** select from product table && count rows to fetch
					** get product id from the select [ POST ]
					** upload and overwire [ img && description && price ]
					** delete the product by the Post of the select value that will be the [ ID ]
					** make update to the product if no need to change the description and price the old value still from **==>the hidden input that will get by the Post of the select value that will be the [ ID ]
					*/

					//start update query
					if (isset($_POST["editPro"])) {
						//value post
						$proId 			 = trim( strip_tags($_POST['selectProduct'] ));
						$newTitle		 = trim( strip_tags($_POST["newTitle"]));
						$newDesc 		 = trim( strip_tags($_POST["newDesc"]));
						$newPrice 		 = trim( strip_tags($_POST["newPrice"]));
						$dir_name        = dirname(__FILE__) . "/Layout/img/product_image/";
						$path            = $_FILES['img']['tmp_name'];//temporary path
						$name            = $_FILES['img']['name'];
						$size            = $_FILES['img']['size'];
						$type            = $_FILES['img']['type']; //image/png
						$error           = $_FILES['img']['error'];

						/*Start Check the Image Type&Size*/

						if (!$error && is_uploaded_file($path) && in_array($type, array('image/png', 'image/gif', 'image/jpeg', 'image/jpg', 'image/pjpeg', 'image/x-png', 'image/png')) && $size < 200000){
							move_uploaded_file($path, $dir_name . $name);
						}else {
							echo 'error in upload file ' . $error;
						}
						/*End Check the Image Type&Size*/

						//validate the form

							$formErrors = array();
							if (empty($newTitle)) {
								$formErrors[] = 'Title can\'t be empty';
							}
							if (empty($newDesc)) {
								$formErrors[] = 'Description can\'t be empty';
							}
							if (empty($newPrice)) {
								$formErrors[] = 'price can\'t be empty';
							}
							if (empty($name)) {
								$formErrors[] = 'image can\'t be empty';
							}

							if(!empty($formErrors)){
								//start loop to get the errors
								foreach ($formErrors as $error) {
									echo '<div class="alert alert-danger">'.$error.'</div>';
								}//end loop
							}

							//if the array is empty compelete the query
							if (empty($formErrors)) {
								 $check = checkItme('model_name', 'products', $newTitle);
								 if ($check > 0) {
											echo '<div class="alert alert-danger">the inserted product ( ' . $newTitle . ' ) is exist </div>';
									} else {

								//start update the query
								$proEdit = $conn->prepare("UPDATE products SET model_name = ?, Details = ?, price = ?, Image = ? WHERE product_id = ?");

								//execute the query
								$proEdit->execute(array($newTitle, $newDesc, $newPrice, $name, $proId));

								//echo success massage
								echo '<div class="alert alert-success">'.$proEdit->rowCount().' product updated the updated product is ('.$newTitle.') </div>';
							}
						}
					}
					//start delete query
					if (isset($_POST['deletePro'])) {
						//get post value
						$proId = $_POST['selectProduct'];
						//delete the product from the database
						$proDelete = $conn->prepare("DELETE FROM products WHERE product_id = :pId");
						// bind the parameter
						$proDelete->bindParam('pId', $proId);
						//execute the query
						$proDelete->execute();
						//echo success massage
						echo '<div class="alert alert-success">'.$proDelete->rowCount().' Recourd Deleted</div>';
					}

					//start select the product data
					$proSelect = $conn->prepare("SELECT * FROM products");
					//execute the data
					$proSelect->execute();
					?>
					<!--Write PHP CODE HERE PLEASE-->
					<form class="Editproject" action="" method="post" enctype="multipart/form-data">
					   <!-- <select class="form-control">
							<option>Select Categoury Of the product</option>
						</select> -->

						<?php //start loop
						//start show the categorie form database
								comboSelect('selectProduct', 'select product', 'product_id, model_name','products', 'product_id', 'model_name', 'WHERE groupId = 1');
						   ?>
						</select>
						<input type="text" class="form-control" placeholder="Here the title" name='newTitle' />
						<input type="file" class="form-control" name="img">
						<textarea class="form-control" placeholder="Here the Price " style="resize:none" name='newDesc'></textarea>
						<input type="number" class="form-control" placeholder="Here the Price Price" name='newPrice' />
						<input type="submit" class="btn btn-block btn-primary" value="Edit" name='editPro'>
						<input type="submit" class="btn btn-block btn-danger confirm" value="Delete" name='deletePro' >
					</form>
					<div class="clearfix"></div>
				</div>
			</div>
			<!--End Edit_Product-->
			<!--Start Edit_Categoury-->
			<div class="mix Edit_Categoury">
				<div class="myprofile">
					<h2 class="text-center text-info">Edit Categoury</h2>
					<!--Write PHP CODE HERE PLEASE-->
						<?php
						//start update function
						if(isset($_POST['editCat'])) {
							$catId 	= $_POST["catSelect"];
							$newCat = trim(strip_tags($_POST['newCat']));
							if (empty($newCat)) {
								echo "<div class='alert alert-danger'>this field mustn't be empty </div>";
							}else {
								$check = checkItme('Name', 'categories', $newCat);
								if ($check > 0) {
									  echo '<div class="alert alert-danger">the inserted product ( ' . $newCat . ' ) is exist </div>';
								} else {

									$stmt 	= $conn->prepare("UPDATE categories SET Name = ? WHERE  Cat_ID = ? ");
									$stmt->execute(array($newCat, $catId));
									//echo success massage
									echo '<div class="alert alert-success">'.$stmt->rowCount()." Categoury  updated the updated Categoury is ( " . $newCat . " ) Categoury</div>";
								}
							}
						}
						//start delete the categories
						if(isset($_POST['deleteCat'])){
							$catId = $_POST["catSelect"];
							$stmt  = $conn->prepare("DELETE FROM categories WHERE Cat_ID = :zcatid");
							$stmt->bindParam("zcatid", $catId);
							$stmt->execute();
							//echo success massage
							echo '<div class="alert alert-success">'.$stmt->rowCount().' Recourd Deleted</div>';
						}



					   ?>
					<!--Write PHP CODE HERE PLEASE-->
					<form class="Editproject" action='<?php echo $_SERVER["PHP_SELF"]?>' method="post">

							<?php
								//start show the categorie form database
								comboSelect('catSelect', 'select categoury', 'Cat_ID, Name','categories', 'Cat_ID', 'Name');
							?>

						<input type="text" class="form-control" placeholder="rename the category if want to edit right here the new category name after select it" name='newCat'>
						<input type="submit" class="btn btn-block btn-primary" name='editCat' value="Edit">
						<input type="submit" class="btn btn-block btn-danger confirm" name='deleteCat' value="Delete">
					</form>
							<div style='height: 0.5px'></div>
					<!--Write PHP CODE HERE PLEASE-->
						<?php
						//start update function
						if(isset($_POST['editSubCat'])) {
							$subcatId  = $_POST["subCatSelect"];
							$newSubCat = trim(strip_tags($_POST['newSubCat']));
							if (empty($newSubCat)) {
								echo "<div class='alert alert-danger'>this field mustn't be empty </div>";
							}else {

								$stmt   = $conn->prepare("UPDATE subcategories SET subCatName = ? WHERE  subCatId = ? ");
								$stmt->execute(array($newSubCat, $subcatId));
								 //echo success massage
								 echo '<div class="alert alert-success">'.$stmt->rowCount()." Categoury  updated the updated Categoury is ( " . $newSubCat . " ) Categoury</div>";
							}
						}
						//start delete the categories
						if(isset($_POST['deleteSubCat'])){
							$subcatId = $_POST["subCatSelect"];
							$stmt  = $conn->prepare("DELETE FROM subcategories WHERE subCatId = :zscatid");
							$stmt->bindParam("zscatid", $subcatId);
							$stmt->execute();
							//echo success massage
							echo '<div class="alert alert-success">'.$stmt->rowCount().' Recourd Deleted</div>';
						}



					   ?>
					<!--Write PHP CODE HERE PLEASE-->
					 <form class="Editproject" action='<?php echo $_SERVER["PHP_SELF"]?>' method="post">

							<?php
								//start show the sub categorie form database
								 comboSelect('subCatSelect', 'Select Sub Categoury', 'subCatId, subCatName','subcategories', 'subCatId', 'subCatName');


							?>
						<input type="text" class="form-control" placeholder="rename the category if want to edit right here the new category name after select it" name='newSubCat'>
						<input type="submit" class="btn btn-block btn-primary" name='editSubCat' value="Edit">
						<input type="submit" class="btn btn-block btn-danger confirm" name='deleteSubCat' value="Delete">
					</form>
					<div class="clearfix"></div>
				</div>
			</div>
			<!--End Edit_Categoury-->
			<!--Start Edit_Offer-->
			<div class="mix Edit_Offer">
				<div class="myprofile">
					<h2 class="text-center text-info">Edit or Delete Offer</h2>
					<!--Write PHP CODE HERE PLEASE-->
					<?php
					if($_SERVER['REQUEST_METHOD'] == 'POST'){
						if(isset($_POST['EditOffer'])){
							$offerid 	= $_POST['offerselect'];
							//get value post
							$newoffer 	= trim(strip_tags($_POST['newoffername']));
							$newofferPrice = trim(strip_tags($_POST['newofferPrice']));
							$stmt 		= $conn->prepare("UPDATE offers SET offername = ? , offerPrice = ? WHERE  id = ? ");
							$stmt->execute(array($newoffer, $newofferPrice, $offerid));
							// Success Msg
							echo '<div class="alert alert-success">'.$stmt->rowCount().' Record Updated</div>';
						}elseif(isset($_POST['DeleteOffer'])){
							$offerId 	= $_POST["offerselect"];
							$stmt  		= $conn->prepare("DELETE FROM offers WHERE id = :zofferid");
							$stmt->bindParam(":zofferid", $offerId);
							$stmt->execute();
							// Success Msg
							echo '<div class="alert alert-success">'.$stmt->rowCount().' Record Deleted</div>';
						}
					}

					?>
					<!--Write PHP CODE HERE PLEASE-->
					<form class="Editproject" action="" method="post">
							<?php
								//start show the categorie form database
								comboSelect('offerselect', 'select offer', 'id, offerPrice, offername','offers', 'id', 'offername');

							?>
						<input name="newoffername" type="text" class="form-control" placeholder="Offer Name">
						<input name="newofferPrice" type="number" class="form-control" placeholder="Offer Price">
						<input type="submit" class="btn btn-block btn-primary" name="EditOffer" value="Edit">
						<input name="DeleteOffer" type="submit" class="btn btn-block btn-danger confirm" value="Delete">
					</form>
					<div class="clearfix"></div>
				</div>
			</div>
			<!--End Edit_Offer-->

        </div>
    </div>
</div>
<?php
	}elseif($do == 'deleteMsg'){
	    echo '<h1 class="text-center Head">Delete page</h1>';

				echo '<div class="container">';

				// Check that the userid is numeric and exesits

				$msgid = isset($_GET['msgid']) && is_numeric($_GET['msgid']) ? intval($_GET['msgid']) : 0;

				// Select all data From the table of users

				$stmt = $conn->prepare("SELECT * FROM `msg` WHERE ID = ? LIMIT 1");

				// execute the data

				$stmt->execute(array($msgid));


				// Count the rows

				$count = $stmt->rowCount();

				// if there is such id show the form

				if ($count > 0) {

						$stmt = $conn->prepare("DELETE FROM msg WHERE ID = ?");

						$stmt->execute(array($msgid));

						$msg = '<div class="alert alert-success">' . $stmt->rowCount() . " Record Deleted </div>";

						redirect($msg, "AdminContoroller.php", $page = 'Admin Page', 5);


				}else{


					$msg = 'This id is not exesist';

					redirect($msg, "AdminContoroller.php", $page = 'Admin Page', 5);

				}

				echo "</div>";
	}elseif ($do == 'approvePro') {
				// Check that the userid is numeric and exesits

				$proid = isset($_GET['proid']) && is_numeric($_GET['proid']) ? intval($_GET['proid']) : 0;

				// Select all data From the table of users

				$stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ? LIMIT 1");

				// execute the data

				$stmt->execute(array($proid));


				// Count the rows

				$count = $stmt->rowCount();

				// if there is such id show the form

				if ($count > 0) {

					echo '<h1 class="text-center Head">Approve page</h1>';

					echo '<div class="container">';

					$stmt = $conn->prepare("UPDATE products SET groupId = 1 WHERE product_id = ?");

					$stmt->execute(array($proid));

					$msg = '<div class="alert alert-success">' . $stmt->rowCount() . " Record Activated </div>";

					redirect($msg, "AdminContoroller.php", $page = 'Admin', 5);

				}else{


					$msg = 'This id is not exesist';

					redirect($msg, "AdminContoroller.php", $page = 'Admin', 5);

				}

				echo "</div>";
	}elseif ($do == 'hidePro') {
		// Check that the userid is numeric and exesits

		$proid = isset($_GET['proid']) && is_numeric($_GET['proid']) ? intval($_GET['proid']) : 0;

		// Select all data From the table of users

		$stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ? LIMIT 1");

		// execute the data

		$stmt->execute(array($proid));


		// Count the rows

		$count = $stmt->rowCount();

		// if there is such id show the form

		if ($count > 0) {

			echo '<h1 class="text-center Head">Approve page</h1>';

			echo '<div class="container">';

			$stmt = $conn->prepare("UPDATE products SET groupId = 0 WHERE product_id = ?");

			$stmt->execute(array($proid));

			$msg = '<div class="alert alert-success">' . $stmt->rowCount() . " Record Hided </div>";

			redirect($msg, "AdminContoroller.php", $page = 'Admin', 5);

		}else{


			$msg = 'This id is not exesist';

			redirect($msg, "AdminContoroller.php", $page = 'Admin', 5);

		}

		echo "</div>";
	}elseif ($do == 'AppMember') {//approve members
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

			echo '<h1 class="text-center Head">Approve page</h1>';

			echo '<div class="container">';

			$stmt = $conn->prepare("UPDATE users SET groupId = 1 WHERE userID = ?");

			$stmt->execute(array($userid));

			$msg = '<div class="alert alert-success">' . $stmt->rowCount() . " Record Approved </div>";

			redirect($msg, "AdminContoroller.php", $page = 'Admin', 5);

		}else{

			$msg = 'This id is not exesist';

			redirect($msg, "AdminContoroller.php", $page = 'Admin', 5);

		}

		echo "</div>";
	}elseif ($do == 'BlockMember') {//block
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

			echo '<h1 class="text-center Head">Approve page</h1>';

			echo '<div class="container">';

			$stmt = $conn->prepare("UPDATE users SET groupId = 0 WHERE userID = ?");

			$stmt->execute(array($userid));

			$msg = '<div class="alert alert-success">' . $stmt->rowCount() . " Record Blocked </div>";

			redirect($msg, "AdminContoroller.php", $page = 'Admin', 5);

		}else{

			$msg = 'This id is not exesist';

			redirect($msg, "AdminContoroller.php", $page = 'Admin', 5);

		}

		echo "</div>";
	}elseif ($do == 'SellerMember') {//set as seller
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

			echo '<h1 class="text-center Head">Approve page</h1>';

			echo '<div class="container">';

			$stmt = $conn->prepare("UPDATE users SET groupId = 2 WHERE userID = ?");

			$stmt->execute(array($userid));

			$msg = '<div class="alert alert-success">' . $stmt->rowCount() . " Record Approved To Be Seller </div>";

			redirect($msg, "AdminContoroller.php", $page = 'Admin', 5);

		}else{

			$msg = 'This id is not exesist';

			redirect($msg, "AdminContoroller.php", $page = 'Admin', 5);

		}

		echo "</div>";
	}elseif ($do == 'AdminMember') {//set as admin
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

			echo '<h1 class="text-center Head">Approve page</h1>';

			echo '<div class="container">';

			$stmt = $conn->prepare("UPDATE users SET groupId = 3 WHERE userID = ?");

			$stmt->execute(array($userid));

			$msg = '<div class="alert alert-success">' . $stmt->rowCount() . " User Has Been Admin </div>";

			redirect($msg, "AdminContoroller.php", $page = 'Admin', 5);

		}else{

			$msg = 'This id is not exesist';

			redirect($msg, "AdminContoroller.php", $page = 'Admin', 5);

		}

		echo "</div>";
	}elseif ($do == 'BeaSeller') {
		// Check that the userid is numeric and exesits

		$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

		// Select all data From the table of users

		$stmt = $conn->prepare("SELECT * FROM users WHERE userID = ? LIMIT 1");

		// execute the data

		$stmt->execute(array($userid));


		// Count the rows

		$count = $stmt->rowCount();

		// if there is such id show the msg

		if ($count > 0) {

			echo '<h1 class="text-center Head">Sellers Upgrade page</h1>';

			echo '<div class="container">';

			$stmt = $conn->prepare("UPDATE users SET groupId = 4 WHERE userID = ?");

			$stmt->execute(array($userid));

			$msg = '<div class="alert alert-success">' . $stmt->rowCount() . " Request Sent Your REQUEST Will Be Processed And The Admins Will Accept Your Request 'Good Luck' </div>";

			redirect($msg, "profile.php", $page = 'profile', 25);

		}else{

			$msg = 'This id is not exesist';

			redirect($msg, "profile.php", $page = 'profile', 5);

		}

		echo "</div>";
	}
?>
<?php
	include "includes/templates/footer.php";

    ob_end_flush();

?>
