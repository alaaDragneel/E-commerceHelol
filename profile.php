<?php
    ob_start();
	include "connect.php";

	include "includes/functions/functions.php";
     $pageTitle = "Profile";

    include "includes/templates/header.php";

    include "includes/templates/navbar.php";

?>
<link href="Layout/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<div class="clearfix"></div>
<div>
<?php
    if (@$_SESSION["logged_as_admin"] == 'yes') {// srtart admin Profile
             @$do = $_GET['do'];
        if ($do == 'check') {?>
            <!--start show cart-->
                <div class="mix Cart" style="margin-top: 10px;">
                    <div class="myprofile">
                         <h2 class="text-center text-info">Shopping Cart</h2>
                         <!--Write PHP CODE HERE PLEASE-->
                         <?php
                            @$do = $_GET['do'];
                            @$id = $_GET['proId'];
                            if($do == 'delete') {
                                $deletePay = $conn->prepare("DELETE FROM shopping_basket WHERE Product_id = ? AND UserID = ?");
                                $deletePay->execute(array($id, $_SESSION['userId']));
                                header("location:".$_SERVER["PHP_SELF"]."");
                            }
                            /*
                            ** select payment from the shopping_basket table by the user id
                            ** delete the order after set the clear button by the user id
                            ** compelete buying the order after set the clear button by the user id
                             */
                            //start select the payment
                            $selectPay = $conn->prepare("SELECT * FROM products JOIN shopping_basket ON shopping_basket.Product_id = products.product_id AND shopping_basket.UserID = ?");
                            $selectPay->execute(array($_SESSION["userId"]));
                            $rows = $selectPay->fetchAll();
                         ?>
                            <div class='table-responsive'>
                            <table class='main-table text-center table table-bordered table-hover'>
                                <tr>
                                    <td>Product Name</td>
                                    <td>Product Details</td>
                                    <td>Product Price</td>
                                    <td>Product Image</td>
                                    <td>Date</td>
                                    <td>Actions</td>
                                </tr>
                                <?php
                                    foreach($rows as $row) {
                                        echo "<tr>";
                                            echo "<td>".$row["model_name"]."</td>";
                                            echo "<td>".$row["Details"]."</td>";
                                            echo "<td>".$row["price"]."</td>";
                                            echo "<td><img height='350' width='250' src='layout/img/product_image/".$row["Image"]."'</td>";
                                            echo "<td>".$row["Date"]."</td>";
                                            echo "<td><a href=''><input type='submit' name='pay' value='Compelete Payment' class='btn btn-primary btn-block' ></a>";
                                            echo "<a href='".$_SERVER["PHP_SELF"]."?do=delete&proId=".$row["product_id"]."' class='btn btn-danger btn-block confirm' name='deletePay'> clear </a></td>";
                                        echo "</tr>";

                                    }
                                ?>
                            <!--Write PHP CODE HERE PLEASE-->
                            </table>
                        </div>
                    </div>
                </div>
                <!--end show cart-->
        <?php
            }else{
        ?>
  <div class="container">
    <div class="row">
      <ul class="ul">
        <li class="selected filter" data-filter="all">all</li>
        <li class="filter" data-filter=".adminprofile" >Profile</li>
        <li class="filter" data-filter=".View">View</li>
        <li class="filter" data-filter=".Cart">Cart</li>
        <li class="filter" data-filter=".Wish">Wish List</li>
        <li class="filter" data-filter=".Edit_Profile">Edit Profile</li>
      </ul>
      <div id="Container">
      <?php
        //start prepare statment
        $stmt = $conn->prepare("SELECT * FROM users WHERE userID = ?");
        //execute the statment
        $stmt->execute(array($_SESSION['userId']));
        //row count
        $count = $stmt->rowCount();
        //if there is such id show form
        if ($count > 0) { //start if
            $rows = $stmt->fetchAll();
            //loop to get the data
            foreach ($rows as $row) { //start loop
            ?>

                <!--Start Profile-->
                <div class="mix adminprofile">
                    <div class="myprofile2">
                    	<h2 class="text-center text-info">My Profile</h2>
                        <section id="user-profile-content">
                            <div class="container">
                                <div class="row">
                                    <div class='user-information col-xs-12 col-md-12'>
                                        <div id='user-face' >
                                            <img alt='user image' style = 'width:350px; height:350px;' src='layout/img/users_image/<?php echo $row['userImg']; ?>'>
                                            <h2><?php echo $row['username']; ?></h2>
                                        </div>
                                        <div id='user-info'>
                                            <div class='lable'>
                                                <p><b>user name:</b><span><?php echo $row['username']; ?></span></p>
                                            </div>
                                            <div>
                                                <p><b>National ID:</b><span><?php echo $row['National_ID']; ?></span></p>
                                            </div>
                                            <div class='lable'>
                                                <p><b>E-mail:</b><span><?php echo $row['Email']; ?></span></p>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </section>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <!--End Profile-->

        <?php       }//end loop
                } //end if ?>

                <!--Start View-->
        		<div class="mix View">
                    <div class="myprofile">
                        <div class="panel">
                            <h2 class="text-center">My Admin Panel</h2>
                            <hr />
                            <p>The Admin Panel Of the Web Site Is Usually Used To Control Every Thing In The Web Site Such AS (ADD, Update, Delete, Insert)[ Offer, Categoury, Subcategoury, Products, Ads, Masseges ]</p>
                            <a class="btn btn-block btn-info" href="AdminContoroller.php">Go To My Admin Panel</a>
                        </div>
                        <div class="home-stats">
                            <div class="row">
                				<div class="col-md-3">
                					<div class="stats st-members">
                						Totla Members
                                        <?php
                                        $stmt = $conn->prepare("SELECT * FROM users");
                                        $stmt->execute();
                                        $count = $stmt->rowCount();
                                        ?>
                						<span><a href="AdminContoroller.php?do=allMembers"><?php echo $count; ?></a></span>
                					</div>
                				</div>
                				<div class="col-md-3">
                					<div class="stats st-bending">
                						Bending Sellers
                                        <?php
                                        $stmt = $conn->prepare("SELECT * FROM users WHERE GroupID = 4");
                                        $stmt->execute();
                                        $count = $stmt->rowCount();
                                        ?>
                						<span><a href="AdminContoroller.php?do=pendSeller"><?php echo $count; ?></a></span>
                					</div>
                				</div>
                				<div class="col-md-3">
                					<div class="stats st-items">
                						Totla Products
                                        <?php
                                        $stmt = $conn->prepare("SELECT * FROM products WHERE groupId = 1");
                                        $stmt->execute();
                                        $count = $stmt->rowCount();
                                        ?>
                						<span><a href="products.php"><?php echo $count; ?></a></span>
                					</div>
                				</div>
                				<div class="col-md-3">
                					<div class="stats st-comments">
                						Totla Massegs
                                        <?php
                                        $stmt = $conn->prepare("SELECT * FROM msg");
                                        $stmt->execute();
                                        $count = $stmt->rowCount();
                                        ?>
                						<span><a href="AdminContoroller.php?do=allMassages"><?php echo $count; ?></a></span>
                					</div>
                				</div>
                			</div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <!--End View-->
                 <!--start show cart-->
                <div class="mix Cart">
                    <div class="myprofile">
                         <h2 class="text-center text-info">Shopping Cart</h2>
                         <!--Write PHP CODE HERE PLEASE-->
                         <?php
                            @$do = $_GET['do'];
                            @$id = $_GET['proId'];
                            if($do == 'delete') {
                                $deletePay = $conn->prepare("DELETE FROM shopping_basket WHERE Product_id = ? AND UserID = ?");
                                $deletePay->execute(array($id, $_SESSION['userId']));
                                header("location:".$_SERVER["PHP_SELF"]."");
                            }
                            /*
                            ** select payment from the shopping_basket table by the user id
                            ** delete the order after set the clear button by the user id
                            ** compelete buying the order after set the clear button by the user id
                             */
                            //start select the payment
                            $selectPay = $conn->prepare("SELECT * FROM products JOIN shopping_basket ON shopping_basket.Product_id = products.product_id AND shopping_basket.UserID = ? ");
                            $selectPay->execute(array($_SESSION["userId"]));
                            $rows = $selectPay->fetchAll();
                         ?>
                            <div class='table-responsive'>
                            <table class='main-table text-center table table-bordered table-hover'>
                                <tr>
                                    <td>Product Name</td>
                                    <td>Product Details</td>
                                    <td>Product Price</td>
                                    <td>Product Image</td>
                                    <td>Date</td>
                                    <td>Actions</td>
                                </tr>
                                <?php
                                    foreach($rows as $row) {
                                        echo "<tr>";
                                            echo "<td>".$row["model_name"]."</td>";
                                            echo "<td>".$row["Details"]."</td>";
                                            echo "<td>".$row["price"]."</td>";
                                            echo "<td><img height='350' width='250' src='layout/img/product_image/".$row["Image"]."'</td>";
                                            echo "<td>".$row["Date"]."</td>";
                                            echo "<td><a href=''><input type='submit' name='pay' value='Compelete Payment' class='btn btn-primary btn-block' ></a>";
                                            echo "<a href='".$_SERVER["PHP_SELF"]."?do=delete&proId=".$row["product_id"]."' class='btn btn-danger btn-block confirm' name='deletePay' > clear </a></td>";
                                        echo "</tr>";

                                    }
                                ?>
                            <!--Write PHP CODE HERE PLEASE-->
                            </table>
                        </div>
                    </div>
                </div>
                <!--end show cart-->
                <!--start show wish list-->
                <div class="mix Wish">
                    <div class="myprofile">
                         <h2 class="text-center text-info">wish list</h2>
                         <!--Write PHP CODE HERE PLEASE-->
                         <?php

                            @$do = $_GET['do'];
                            @$id = $_GET['proId'];
                            if($do == 'delete') {
                                $deletePay = $conn->prepare("DELETE FROM whishlist WHERE Product_id = ? AND UserID = ?");
                                $deletePay->execute(array($id, $_SESSION['userId']));
                               header("location:".$_SERVER["PHP_SELF"]."");
                            }
                            /*
                            ** select payment from the shopping_basket table by the user id
                            ** delete the order after set the clear button by the user id
                            ** compelete buying the order after set the clear button by the user id
                             */
                            //start select the payment
                            $selectWish = $conn->prepare("SELECT * FROM products JOIN whishlist ON whishlist.Product_id = products.product_id AND whishlist.UserID = ?");
                            $selectWish->execute(array($_SESSION["userId"]));
                            $rows = $selectWish->fetchAll();
                         ?>
                            <div class='table-responsive'>
                            <table class='main-table text-center table table-bordered table-hover'>
                                <tr>
                                    <td>Product Name</td>
                                    <td>Product Details</td>
                                    <td>Product Price</td>
                                    <td>Product Image</td>
                                    <td>Date</td>
                                    <td>Actions</td>
                                </tr>
                                <?php
                                    foreach($rows as $row) {
                                        echo "<tr>";
                                            echo "<td>".$row["model_name"]."</td>";
                                            echo "<td>".$row["Details"]."</td>";
                                            echo "<td>".$row["price"]."</td>";
                                            echo "<td><img height='350' width='250' src='layout/img/product_image/".$row["Image"]."'</td>";
                                            echo "<td>".$row["Date"]."</td>";
                                            echo "<td><a href=''><input type='submit' name='pay' value='Compelete Payment' class='btn btn-primary btn-block' ></a>";
                                            echo "<a href='".$_SERVER["PHP_SELF"]."?do=delete&proId=".$row["product_id"]."' class='btn btn-danger btn-block confirm' name='deletePay'  > clear </a></td>";
                                        echo "</tr>";

                                    }
                                ?>
                            <!--Write PHP CODE HERE PLEASE-->
                            </table>
                        </div>
                    </div>
                </div>
                <!--end show Wish list-->
                <!--Start Edit_Profile-->
                <div class="mix Edit_Profile">
                    <div class="myprofile">
                        <h2 class="text-center text-info">Edit Profile</h2>
                        <!--Write PHP CODE HERE PLEASE-->
                        <?php
                        /*Start Update Code*/
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            if(isset($_POST['editprofilesubmit'])){
                                // get the data from the form
                                $id 			= $_POST['id'];
                                $username 		= trim(strip_tags($_POST['username']));
                                $email 			= trim(strip_tags($_POST['email']));
                                $National_ID 	= trim(strip_tags($_POST['National_ID']));
                                $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : $_POST['newpassword'];
                                $dir_name        = dirname(__FILE__) . "/Layout/img/users_image/";
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

                                // validation array

                                $formValidation = array();

                                if (strlen($username) < 4) {

                                    $formValidation[] = 'Username is less than <strong>4 chars</strong>';

                                }

                                if (strlen($username) > 16) {

                                    $formValidation[] = 'Username is more than 16 chars';

                                }

                                if (empty($username)) {

                                    $formValidation[] = 'You Must Enter the Username';

                                }

                                if (empty($email)) {

                                    $formValidation[] = 'You Must Enter the Email';

                                }

                                if (empty($National_ID)) {

                                    $formValidation[] = 'You Must Enter the National_ID';

                                }
                                if (empty($name)) {

                                    $formValidation[] = 'you must choose image';

                                }

                                // Loop into Error Array

                                foreach ($formValidation as $error) {
                                    echo "<div class='alert alert-danger'>".$error."</div>";
                                }

                                if (empty($formValidation)) {
                                    // Update the database
                                    $stmt = $conn->prepare("UPDATE `users` SET username = ?, Email = ?, Password = ?, National_ID = ?, userImg = ? WHERE userID = ?");
                                    $stmt->execute(array($username, $email, $pass, $National_ID, $name, $id));
                                    echo "<div class='alert alert-success'>".$stmt->rowCount()." Record Updated</div>";
                                }
                            }
                        }
                        /*End Update Code*/

                        // Show the data in the form using select

                        // Check that the userid is numeric and exesits

                        $userid = isset($_SESSION['userId']) && is_numeric($_SESSION['userId']) ? intval($_SESSION['userId']) : 0;

                        // Select all data From the table of users

                        $stmt = $conn->prepare("SELECT * FROM users WHERE userID = ? LIMIT 1");

                        // execute the data

                        $stmt->execute(array($userid));

                        // Fetch all the data of the user id

                        $row = $stmt->fetch();

                        // Count the rows

                        $count = $stmt->rowCount();

                        // if there is such id show the form

                        if ($count > 0){
                        ?>
                        <!--Write PHP CODE HERE PLEASE-->
                        <form class="Editpro" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <input name="id" type="hidden" value="<?php echo $row['userID']; ?>"/>
                            <input name="username" type="text" value="<?php echo $row['username']; ?>" class="form-control" placeholder="Username" required />
                            <input name="oldpassword" type="hidden" value="<?php echo $row['Password']; ?>"/>
                            <input name="newpassword" type="password" class="form-control" placeholder="Leave Blank If you want to change"/>
                            <input name="email" type="email" value="<?php echo $row['Email']; ?>" class="form-control" placeholder="Email">
                            <input name="National_ID" type="text" value="<?php echo $row['National_ID']; ?>" class="form-control" placeholder="National ID" required />
                            <input type="file" name="img" required>
                            <input type="submit" name="editprofilesubmit" class="btn btn-block btn-primary" value="Edit">
                        </form>
                        <?php
                        }
                        ?>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <!--End Edit_Profile-->
            </div>
        </div>
    </div>
</div>

<?php
      }
	} elseif (@$_SESSION["logged_as_seller"] == 'yes') { // start seller user page
        @$do = $_GET['do'];
        if ($do == 'check') {?>
            <!--start show cart-->
                <div class="mix Cart" style="margin-top: 10px;">
                    <div class="myprofile">
                         <h2 class="text-center text-info">Shopping Cart</h2>
                         <!--Write PHP CODE HERE PLEASE-->
                         <?php
                            @$do = $_GET['do'];
                            @$id = $_GET['proId'];
                            if($do == 'delete') {
                                $deletePay = $conn->prepare("DELETE FROM shopping_basket WHERE Product_id = ? AND UserID = ?");
                                $deletePay->execute(array($id, $_SESSION['userId']));
                                header("location:".$_SERVER["PHP_SELF"]."");
                            }
                            /*
                            ** select payment from the shopping_basket table by the user id
                            ** delete the order after set the clear button by the user id
                            ** compelete buying the order after set the clear button by the user id
                             */
                            //start select the payment
                            $selectPay = $conn->prepare("SELECT * FROM products JOIN shopping_basket ON shopping_basket.Product_id = products.product_id AND shopping_basket.UserID = ?");
                            $selectPay->execute(array($_SESSION["userId"]));
                            $rows = $selectPay->fetchAll();
                         ?>
                            <div class='table-responsive'>
                            <table class='main-table text-center table table-bordered table-hover'>
                                <tr>
                                    <td>Product Name</td>
                                    <td>Product Details</td>
                                    <td>Product Price</td>
                                    <td>Product Image</td>
                                    <td>Date</td>
                                    <td>Actions</td>
                                </tr>
                                <?php
                                    foreach($rows as $row) {
                                        echo "<tr>";
                                            echo "<td>".$row["model_name"]."</td>";
                                            echo "<td>".$row["Details"]."</td>";
                                            echo "<td>".$row["price"]."</td>";
                                            echo "<td><img height='350' width='250' src='layout/img/product_image/".$row["Image"]."'</td>";
                                            echo "<td>".$row["Date"]."</td>";
                                            echo "<td><a href=''><input type='submit' name='pay' value='Compelete Payment' class='btn btn-primary btn-block' ></a>";
                                            echo "<a href='".$_SERVER["PHP_SELF"]."?do=delete&proId=".$row["product_id"]."' class='btn btn-danger btn-block confirm' name='deletePay'> clear </a></td>";
                                        echo "</tr>";

                                    }
                                ?>
                            <!--Write PHP CODE HERE PLEASE-->
                            </table>
                        </div>
                    </div>
                </div>
                <!--end show cart-->
        <?php
            }else{
        ?>

<div class="container">
    <div class="row">
      <ul class="ul">
        <li class="selected filter" data-filter="all">all</li>
        <li class="filter" data-filter=".adminprofile" >Profile</li>
        <li class="filter" data-filter=".Add_Product">Add Product</li>
        <li class="filter" data-filter=".Edit_Profile">Edit Profile</li>
        <li class="filter" data-filter=".Cart">Cart</li>
        <li class="filter" data-filter=".Wish">Wish List</li>
        <li class="filter" data-filter=".Edit_Product">Edit Product</li>
      </ul>
      <div id="Container">
      <?php
        //start prepare statment
        $stmt = $conn->prepare("SELECT * FROM users WHERE userID = ?");
        //execute the statment
        $stmt->execute(array($_SESSION['userId']));
        //row count
        $count = $stmt->rowCount();
        //if there is such id show form
        if ($count > 0) { //start if
            $rows = $stmt->fetchAll();
            //loop to get the data
            foreach ($rows as $row) { //start loop
            ?>

                <!--Start Profile-->
                <div class="mix adminprofile">
                    <div class="myprofile2">
                        <h2 class="text-center text-info">My Profile</h2>
                        <section id="user-profile-content">
                            <div class="container">
                                <div class="row">
                                    <div class='user-information col-xs-12 col-md-12'>
                                        <div id='user-face' >
                                            <img alt='user image' style = 'width:350px; height:350px;' src='layout/img/users_image/<?php echo $row['userImg']; ?>'>
                                            <h2><?php echo $row['username']; ?></h2>
                                        </div>
                                        <div id='user-info'>
                                            <div class='lable'>
                                                <p><b>user name:</b><span><?php echo $row['username']; ?></span></p>
                                            </div>
                                            <div>
                                                <p><b>National ID:</b><span><?php echo $row['National_ID']; ?></span></p>
                                            </div>
                                            <div class='lable'>
                                                <p><b>E-mail:</b><span><?php echo $row['Email']; ?></span></p>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </section>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <!--End Profile-->

        <?php       }//end loop
                } //end if ?>

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
                                $cat             = $_POST['catSelect'];
                                $subCat          = $_POST['subCatSelect'];
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
                                                //insert product information into the database
                                                $stmt = $conn->prepare("INSERT INTO products(model_name, Details, price, Image, userId, Date) VALUES(:ztitle, :zdesc, :zprice, :zimg, :user,now()) ");
                                                $stmt->execute(array(
                                                                'ztitle'        => $title,
                                                                'zdesc'         => $description,
                                                                'zprice'        => $price,
                                                                'zimg'          => $name,
                                                                'user'          =>$_SESSION['userId']
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

                                <?php
                                    //start show the categorie form database
                                     comboSelect('catSelect', 'Select Categoury', 'Cat_ID, Name','categories', 'Cat_ID', 'Name');
                                ?>
                                <div style='height: 0.5px'></div>
                                <?php
                                    //start show the categorie form database
                                     comboSelect('subCatSelect', 'Select Sub Categoury', 'subCatId, subCatName','subcategories', 'subCatId', 'subCatName');
                                ?>
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
                <!--start show cart-->
                <div class="mix Cart">
                    <div class="myprofile">
                         <h2 class="text-center text-info">Shopping Cart</h2>
                         <!--Write PHP CODE HERE PLEASE-->
                         <?php
                            @$do = $_GET['do'];
                            @$id = $_GET['proId'];
                            if($do == 'delete') {
                                $deletePay = $conn->prepare("DELETE FROM shopping_basket WHERE Product_id = ? AND UserID = ?");
                                $deletePay->execute(array($id, $_SESSION['userId']));
                                header("location:".$_SERVER["PHP_SELF"]."");
                            }
                            /*
                            ** select payment from the shopping_basket table by the user id
                            ** delete the order after set the clear button by the user id
                            ** compelete buying the order after set the clear button by the user id
                             */
                            //start select the payment
                            $selectPay = $conn->prepare("SELECT * FROM products JOIN shopping_basket ON shopping_basket.Product_id = products.product_id AND shopping_basket.UserID = ?");
                            $selectPay->execute(array($_SESSION["userId"]));
                            $rows = $selectPay->fetchAll();
                         ?>
                            <div class='table-responsive'>
                            <table class='main-table text-center table table-bordered table-hover'>
                                <tr>
                                    <td>Product Name</td>
                                    <td>Product Details</td>
                                    <td>Product Price</td>
                                    <td>Product Image</td>
                                    <td>Date</td>
                                    <td>Actions</td>
                                </tr>
                                <?php
                                    foreach($rows as $row) {
                                        echo "<tr>";
                                            echo "<td>".$row["model_name"]."</td>";
                                            echo "<td>".$row["Details"]."</td>";
                                            echo "<td>".$row["price"]."</td>";
                                            echo "<td><img height='350' width='250' src='layout/img/product_image/".$row["Image"]."'</td>";
                                            echo "<td>".$row["Date"]."</td>";
                                            echo "<td><a href=''><input type='submit' name='pay' value='Compelete Payment' class='btn btn-primary btn-block' ></a>";
                                            echo "<a href='".$_SERVER["PHP_SELF"]."?do=delete&proId=".$row["product_id"]."' class='btn btn-danger btn-block confirm' name='deletePay' > clear </a></td>";
                                        echo "</tr>";

                                    }
                                ?>
                            <!--Write PHP CODE HERE PLEASE-->
                            </table>
                        </div>
                    </div>
                </div>
                <!--end show cart-->
                <!--start show wish list-->
                <div class="mix Wish">
                    <div class="myprofile">
                         <h2 class="text-center text-info">wish list</h2>
                         <!--Write PHP CODE HERE PLEASE-->
                         <?php

                            @$do = $_GET['do'];
                            @$id = $_GET['proId'];
                            if($do == 'delete') {
                                $deletePay = $conn->prepare("DELETE FROM whishlist WHERE Product_id = ? AND UserID = ?");
                                $deletePay->execute(array($id, $_SESSION['userId']));
                               header("location:".$_SERVER["PHP_SELF"]."");
                            }
                            /*
                            ** select payment from the shopping_basket table by the user id
                            ** delete the order after set the clear button by the user id
                            ** compelete buying the order after set the clear button by the user id
                             */
                            //start select the payment
                            $selectWish = $conn->prepare("SELECT * FROM products JOIN whishlist ON whishlist.Product_id = products.product_id AND whishlist.UserID = ?");
                            $selectWish->execute(array($_SESSION["userId"]));
                            $rows = $selectWish->fetchAll();
                         ?>
                            <div class='table-responsive'>
                            <table class='main-table text-center table table-bordered table-hover'>
                                <tr>
                                    <td>Product Name</td>
                                    <td>Product Details</td>
                                    <td>Product Price</td>
                                    <td>Product Image</td>
                                    <td>Date</td>
                                    <td>Actions</td>
                                </tr>
                                <?php
                                    foreach($rows as $row) {
                                        echo "<tr>";
                                            echo "<td>".$row["model_name"]."</td>";
                                            echo "<td>".$row["Details"]."</td>";
                                            echo "<td>".$row["price"]."</td>";
                                            echo "<td><img height='350' width='250' src='layout/img/product_image/".$row["Image"]."'</td>";
                                            echo "<td>".$row["Date"]."</td>";
                                            echo "<td><a href=''><input type='submit' name='pay' value='Compelete Payment' class='btn btn-primary btn-block' ></a>";
                                            echo "<a href='".$_SERVER["PHP_SELF"]."?do=delete&proId=".$row["product_id"]."' class='btn btn-danger btn-block confirm' name='deletePay'  > clear </a></td>";
                                        echo "</tr>";

                                    }
                                ?>
                            <!--Write PHP CODE HERE PLEASE-->
                            </table>
                        </div>
                    </div>
                </div>
                <!--end show Wish list-->
                <!--Start Edit_Profile-->
                <div class="mix Edit_Profile">
                    <div class="myprofile">
                        <h2 class="text-center text-info">Edit Profile</h2>
                        <!--Write PHP CODE HERE PLEASE-->
                        <?php
                        /*Start Update Code*/
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            if(isset($_POST['editprofilesubmit'])){
                                // get the data from the form
                                $id             = $_POST['id'];
                                $username       = trim(strip_tags($_POST['username']));
                                $email          = trim(strip_tags($_POST['email']));
                                $National_ID    = trim(strip_tags($_POST['National_ID']));
                                $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : $_POST['newpassword'];
                                $dir_name        = dirname(__FILE__) . "/Layout/img/users_image/";
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

                                // validation array

                                $formValidation = array();

                                if (strlen($username) < 4) {

                                    $formValidation[] = 'Username is less than <strong>4 chars</strong>';

                                }

                                if (strlen($username) > 16) {

                                    $formValidation[] = 'Username is more than 16 chars';

                                }

                                if (empty($username)) {

                                    $formValidation[] = 'You Must Enter the Username';

                                }

                                if (empty($email)) {

                                    $formValidation[] = 'You Must Enter the Email';

                                }

                                if (empty($National_ID)) {

                                    $formValidation[] = 'You Must Enter the National_ID';

                                }
                                if (empty($name)) {

                                    $formValidation[] = 'you must choose image';

                                }

                                // Loop into Error Array

                                foreach ($formValidation as $error) {
                                    echo "<div class='alert alert-danger'>".$error."</div>";
                                }

                                if (empty($formValidation)) {
                                    // Update the database
                                    $stmt = $conn->prepare("UPDATE `users` SET username = ?, Email = ?, Password = ?, National_ID = ?, userImg = ? WHERE userID = ?");
                                    $stmt->execute(array($username, $email, $pass, $National_ID, $name, $id));
                                    echo "<div class='alert alert-success'>".$stmt->rowCount()." Record Updated</div>";
                                    header("location:".$_SERVER["PHP_SELF"]."");
                                }
                            }
                        }
                        /*End Update Code*/

                        // Show the data in the form using select

                        // Check that the userid is numeric and exesits

                        $userid = isset($_SESSION['userId']) && is_numeric($_SESSION['userId']) ? intval($_SESSION['userId']) : 0;

                        // Select all data From the table of users

                        $stmt = $conn->prepare("SELECT * FROM users WHERE userID = ? LIMIT 1");

                        // execute the data

                        $stmt->execute(array($userid));

                        // Fetch all the data of the user id

                        $row = $stmt->fetch();

                        // Count the rows

                        $count = $stmt->rowCount();

                        // if there is such id show the form

                        if ($count > 0){
                        ?>
                        <!--Write PHP CODE HERE PLEASE-->
                        <form class="Editpro" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <input name="id" type="hidden" value="<?php echo $row['userID']; ?>"/>
                            <input name="username" type="text" value="<?php echo $row['username']; ?>" class="form-control" placeholder="Username" required />
                            <input name="oldpassword" type="hidden" value="<?php echo $row['Password']; ?>"/>
                            <input name="newpassword" type="password" class="form-control" placeholder="Leave Blank If you want to change"/>
                            <input name="email" type="email" value="<?php echo $row['Email']; ?>" class="form-control" placeholder="Email">
                            <input name="National_ID" type="text" value="<?php echo $row['National_ID']; ?>" class="form-control" placeholder="National ID" required />
                            <input type="file" name="img" required>
                            <input type="submit" name="editprofilesubmit" class="btn btn-block btn-primary" value="Edit">
                        </form>
                        <?php
                        }
                        ?>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <!--End Edit_Profile-->
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
                            $proId           = trim( strip_tags($_POST['selectProduct'] ));
                            $newTitle        = trim( strip_tags($_POST["newTitle"]));
                            $newDesc         = trim( strip_tags($_POST["newDesc"]));
                            $newPrice        = trim( strip_tags($_POST["newPrice"]));
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

                                    //start update the query
                                    $proEdit = $conn->prepare("UPDATE products SET model_name = ?, Details = ?, price = ?, Image = ? WHERE product_id = ?");

                                    //execute the query
                                    $proEdit->execute(array($newTitle, $newDesc, $newPrice, $name, $proId));

                                    //echo success massage
                                    echo '<div class="alert alert-success">'.$proEdit->rowCount().' product updated the updated product is ('.$newTitle.') </div>';
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
                                    $catSelect = $conn->prepare("SELECT * FROM products WHERE  groupId = ? && userId = ?");
                                    $catSelect->execute(array( 1, $_SESSION["userId"]));
                                    $rows = $catSelect->fetchAll();?>
                            <select class="form-control" name='selectProduct'>
                                <option>-----select product-----</option>
                                <?php foreach ($rows as $row) {
                                    echo "<option value='".$row["product_id"]."' >".$row["model_name"]."</option>";
                                }?>
                               ?>
                            </select>
                            <input type="text" class="form-control" placeholder="Price leave it if you want to change it" name='newTitle' />
                            <input type="file" class="form-control" name="img">
                            <textarea class="form-control" placeholder="Descirbtion leave it if you want to change it" style="resize:none" name='newDesc'></textarea>
                            <input type="number" class="form-control" placeholder="Price leave it if you want to change it" name='newPrice' />
                            <input type="submit" class="btn btn-block btn-primary" value="Edit" name='editPro'>
                            <input type="submit" class="btn btn-block btn-danger confirm" value="Delete" name='deletePro' >
                        </form>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <!--End Edit_Product-->
            </div>
        </div>
    </div>
</div>
<?php
        }
    }elseif (@$_SESSION["logged_as_user"] == 'yes') { // start user user page
         @$do = $_GET['do'];
        if ($do == 'check') {?>
            <!--start show cart-->
                <div class="mix Cart" style="margin-top: 10px;">
                    <div class="myprofile">
                         <h2 class="text-center text-info">Shopping Cart</h2>
                         <!--Write PHP CODE HERE PLEASE-->
                         <?php
                            @$do = $_GET['do'];
                            @$id = $_GET['proId'];
                            if($do == 'delete') {
                                $deletePay = $conn->prepare("DELETE FROM shopping_basket WHERE Product_id = ? AND UserID = ?");
                                $deletePay->execute(array($id, $_SESSION['userId']));
                                header("location:".$_SERVER["PHP_SELF"]."");
                            }
                            /*
                            ** select payment from the shopping_basket table by the user id
                            ** delete the order after set the clear button by the user id
                            ** compelete buying the order after set the clear button by the user id
                             */
                            //start select the payment
                            $selectPay = $conn->prepare("SELECT * FROM products JOIN shopping_basket ON shopping_basket.Product_id = products.product_id AND shopping_basket.UserID = ?");
                            $selectPay->execute(array($_SESSION["userId"]));
                            $rows = $selectPay->fetchAll();
                         ?>
                            <div class='table-responsive'>
                            <table class='main-table text-center table table-bordered table-hover'>
                                <tr>
                                    <td>Product Name</td>
                                    <td>Product Details</td>
                                    <td>Product Price</td>
                                    <td>Product Image</td>
                                    <td>Date</td>
                                    <td>Actions</td>
                                </tr>
                                <?php
                                    foreach($rows as $row) {
                                        echo "<tr>";
                                            echo "<td>".$row["model_name"]."</td>";
                                            echo "<td>".$row["Details"]."</td>";
                                            echo "<td>".$row["price"]."</td>";
                                            echo "<td><img height='350' width='250' src='layout/img/product_image/".$row["Image"]."'</td>";
                                            echo "<td>".$row["Date"]."</td>";
                                            echo "<td><a href=''><input type='submit' name='pay' value='Compelete Payment' class='btn btn-primary btn-block' ></a>";
                                            echo "<a href='".$_SERVER["PHP_SELF"]."?do=delete&proId=".$row["product_id"]."' class='btn btn-danger btn-block confirm' name='deletePay' > clear </a></td>";
                                        echo "</tr>";

                                    }
                                ?>
                            <!--Write PHP CODE HERE PLEASE-->
                            </table>
                        </div>
                    </div>
                </div>
                <!--end show cart-->
        <?php
            }else{
        ?>

<div class="container">
    <div class="row">
      <ul class="ul">
        <li class="selected filter" data-filter="all">all</li>
        <li class="filter" data-filter=".adminprofile" >Profile</li>
        <li class="filter" data-filter=".Edit_Profile">Edit Profile</li>
        <li class="filter" data-filter=".Cart">Cart</li>
        <li class="filter" data-filter=".Wish">Wish List</li>
        <li class="filter" data-filter=".Seller">Be Seller</li>
      </ul>
      <div id="Container">
      <?php
        //start prepare statment
        $stmt = $conn->prepare("SELECT * FROM users WHERE userID = ?");
        //execute the statment
        $stmt->execute(array($_SESSION['userId']));
        //row count
        $count = $stmt->rowCount();
        //if there is such id show form
        if ($count > 0) { //start if
            $rows = $stmt->fetchAll();
            //loop to get the data
            foreach ($rows as $row) { //start loop
            ?>

                <!--Start Profile-->
                <div class="mix adminprofile">
                    <div class="myprofile2">
                        <h2 class="text-center text-info">My Profile</h2>
                        <section id="user-profile-content">
                            <div class="container">
                                <div class="row">
                                    <div class='user-information col-xs-12 col-md-12'>
                                        <div id='user-face' >
                                            <img alt='user image' style = 'width:350px; height:350px;' src='layout/img/users_image/<?php echo $row['userImg']; ?>'>
                                            <h2><?php echo $row['username']; ?></h2>
                                        </div>
                                        <div id='user-info'>
                                            <div class='lable'>
                                                <p><b>user name:</b><span><?php echo $row['username']; ?></span></p>
                                            </div>
                                            <div>
                                                <p><b>National ID:</b><span><?php echo $row['National_ID']; ?></span></p>
                                            </div>
                                            <div class='lable'>
                                                <p><b>E-mail:</b><span><?php echo $row['Email']; ?></span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <?php if ($row['GroupID'] != 4): ?>
                            <a class="btn btn-info btn-block" href="AdminContoroller.php?do=BeaSeller&userid=<?php echo $row['userID']; ?>">Be A Seller And Sell Your Own Things</a>
                        <?php endif; ?>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <!--End Profile-->
        <?php       }//end loop
                } //end if ?>

                <!--start show cart-->
                <div class="mix Cart">
                    <div class="myprofile">
                         <h2 class="text-center text-info">Shopping Cart</h2>
                         <!--Write PHP CODE HERE PLEASE-->
                         <?php
                            @$do = $_GET['do'];
                            @$id = $_GET['proId'];
                            if($do == 'delete') {
                                $deletePay = $conn->prepare("DELETE FROM shopping_basket WHERE Product_id = ? AND UserID = ?");
                                $deletePay->execute(array($id, $_SESSION['userId']));
                                header("location:".$_SERVER["PHP_SELF"]."");
                            }
                            /*
                            ** select payment from the shopping_basket table by the user id
                            ** delete the order after set the clear button by the user id
                            ** compelete buying the order after set the clear button by the user id
                             */
                            //start select the payment
                            $selectPay = $conn->prepare("SELECT * FROM products JOIN shopping_basket ON shopping_basket.Product_id = products.product_id AND shopping_basket.UserID = ?");
                            $selectPay->execute(array($_SESSION["userId"]));
                            $rows = $selectPay->fetchAll();
                         ?>
                            <div class='table-responsive'>
                            <table class='main-table text-center table table-bordered table-hover'>
                                <tr>
                                    <td>Product Name</td>
                                    <td>Product Details</td>
                                    <td>Product Price</td>
                                    <td>Product Image</td>
                                    <td>Date</td>
                                    <td>Actions</td>
                                </tr>
                                <?php
                                    foreach($rows as $row) {
                                        echo "<tr>";
                                            echo "<td>".$row["model_name"]."</td>";
                                            echo "<td>".$row["Details"]."</td>";
                                            echo "<td>".$row["price"]."</td>";
                                            echo "<td><img height='350' width='250' src='layout/img/product_image/".$row["Image"]."'</td>";
                                            echo "<td>".$row["Date"]."</td>";
                                            echo "<td><a href=''><input type='submit' name='pay' value='Compelete Payment' class='btn btn-primary btn-block' ></a>";
                                            echo "<a href='".$_SERVER["PHP_SELF"]."?do=delete&proId=".$row["product_id"]."' class='btn btn-danger btn-block confirm' name='deletePay' > clear </a></td>";
                                        echo "</tr>";

                                    }
                                ?>
                            <!--Write PHP CODE HERE PLEASE-->
                            </table>
                        </div>
                    </div>
                </div>
                <!--end show cart-->
                <!--start show wish list-->
                <div class="mix Wish">
                    <div class="myprofile">
                         <h2 class="text-center text-info">wish list</h2>
                         <!--Write PHP CODE HERE PLEASE-->
                         <?php
                            @$do = $_GET['do'];
                            @$id = $_GET['proId'];
                            if($do == 'delete') {
                                $deletePay = $conn->prepare("DELETE FROM whishlist WHERE Product_id = ? AND UserID = ?");
                                $deletePay->execute(array($id, $_SESSION['userId']));
                               header("location:".$_SERVER["PHP_SELF"]."");
                            }
                            /*
                            ** select payment from the shopping_basket table by the user id
                            ** delete the order after set the clear button by the user id
                            ** compelete buying the order after set the clear button by the user id
                             */
                            //start select the payment
                            $selectWish = $conn->prepare("SELECT * FROM products JOIN whishlist ON whishlist.Product_id = products.product_id AND whishlist.UserID = ?");
                            $selectWish->execute(array($_SESSION["userId"]));
                            $rows = $selectWish->fetchAll();
                         ?>
                            <div class='table-responsive'>
                            <table class='main-table text-center table table-bordered table-hover'>
                                <tr>
                                    <td>Product Name</td>
                                    <td>Product Details</td>
                                    <td>Product Price</td>
                                    <td>Product Image</td>
                                    <td>Date</td>
                                    <td>Actions</td>
                                </tr>
                                <?php
                                    foreach($rows as $row) {
                                        echo "<tr>";
                                            echo "<td>".$row["model_name"]."</td>";
                                            echo "<td>".$row["Details"]."</td>";
                                            echo "<td>".$row["price"]."</td>";
                                            echo "<td><img height='350' width='250' src='layout/img/product_image/".$row["Image"]."'</td>";
                                            echo "<td>".$row["Date"]."</td>";
                                            echo "<td><a href=''><input type='submit' name='pay' value='Compelete Payment' class='btn btn-primary btn-block' ></a>";
                                            echo "<a href='".$_SERVER["PHP_SELF"]."?do=delete&proId=".$row["product_id"]."' class='btn btn-danger btn-block confirm' name='deletePay' > clear </a></td>";
                                        echo "</tr>";

                                    }
                                ?>
                            <!--Write PHP CODE HERE PLEASE-->
                            </table>
                        </div>
                    </div>
                </div>
                <!--end show Wish list-->
                <!--Start Edit_Profile-->
                <div class="mix Edit_Profile">
                    <div class="myprofile">
                        <h2 class="text-center text-info">Edit Profile</h2>
                        <!--Write PHP CODE HERE PLEASE-->
                        <?php
                        /*Start Update Code*/
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            if(isset($_POST['editprofilesubmit'])){
                                // get the data from the form
                                $id             = $_POST['id'];
                                $username       = trim(strip_tags($_POST['username']));
                                $email          = trim(strip_tags($_POST['email']));
                                $National_ID    = trim(strip_tags($_POST['National_ID']));
                                $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : $_POST['newpassword'];
                                $dir_name        = dirname(__FILE__) . "/Layout/img/users_image/";
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

                                // validation array

                                $formValidation = array();

                                if (strlen($username) < 4) {

                                    $formValidation[] = 'Username is less than <strong>4 chars</strong>';

                                }

                                if (strlen($username) > 16) {

                                    $formValidation[] = 'Username is more than 16 chars';

                                }

                                if (empty($username)) {

                                    $formValidation[] = 'You Must Enter the Username';

                                }

                                if (empty($email)) {

                                    $formValidation[] = 'You Must Enter the Email';

                                }

                                if (empty($National_ID)) {

                                    $formValidation[] = 'You Must Enter the National_ID';

                                }
                                if (empty($name)) {

                                    $formValidation[] = 'you must choose image';

                                }

                                // Loop into Error Array

                                foreach ($formValidation as $error) {
                                    echo "<div class='alert alert-danger'>".$error."</div>";
                                }

                                if (empty($formValidation)) {
                                    // Update the database
                                    $stmt = $conn->prepare("UPDATE `users` SET username = ?, Email = ?, Password = ?, National_ID = ?, userImg = ? WHERE userID = ?");
                                    $stmt->execute(array($username, $email, $pass, $National_ID, $name, $id));
                                    echo "<div class='alert alert-success'>".$stmt->rowCount()." Record Updated</div>";
                                    header("location:".$_SERVER["PHP_SELF"]."");
                                }
                            }
                        }
                        /*End Update Code*/

                        // Show the data in the form using select

                        // Check that the userid is numeric and exesits

                        $userid = isset($_SESSION['userId']) && is_numeric($_SESSION['userId']) ? intval($_SESSION['userId']) : 0;

                        // Select all data From the table of users

                        $stmt = $conn->prepare("SELECT * FROM users WHERE userID = ? LIMIT 1");

                        // execute the data

                        $stmt->execute(array($userid));

                        // Fetch all the data of the user id

                        $row = $stmt->fetch();

                        // Count the rows

                        $count = $stmt->rowCount();

                        // if there is such id show the form

                        if ($count > 0){
                        ?>
                        <!--Write PHP CODE HERE PLEASE-->
                        <form class="Editpro" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <input name="id" type="hidden" value="<?php echo $row['userID']; ?>"/>
                            <input name="username" type="text" value="<?php echo $row['username']; ?>" class="form-control" placeholder="Username" required />
                            <input name="oldpassword" type="hidden" value="<?php echo $row['Password']; ?>"/>
                            <input name="newpassword" type="password" class="form-control" placeholder="Leave Blank If you want to change"/>
                            <input name="email" type="email" value="<?php echo $row['Email']; ?>" class="form-control" placeholder="Email">
                            <input name="National_ID" type="text" value="<?php echo $row['National_ID']; ?>" class="form-control" placeholder="National ID" required />
                            <input type="file" name="img" required>
                            <input type="submit" name="editprofilesubmit" class="btn btn-block btn-primary" value="Edit">
                        </form>
                        <?php
                        }
                        ?>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <!--End Edit_Profile-->
                <!--Start BE seller-->
                <div class="mix Seller">
                    <div class="myprofile">
                        <h2 class="text-center text-info">BE seller</h2>
                        <!--Write PHP CODE HERE PLEASE-->
                        <?php
                            if(isset($_POST["seller"])) {
                                $stmt = $conn->prepare("UPDATE users SET groupId = 4 WHERE userID = ?");

                                $stmt->execute(array($_SESSION["userId"]));
                            }
                        ?>
                        <!--Write PHP CODE HERE PLEASE-->
                        <form class="Editpro" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <?php 
                            $stmtSelector = $conn->prepare("SELECT * FROM users WHERE userID = ?");
                            $stmtSelector->execute(array($_SESSION["userId"]));
                            $rows = $stmtSelector->fetchAll();
                            foreach($rows as $row){
                                if($row["GroupID"] == 4){
                                    echo "<div class='alert alert-info text-center '> your request to be seller is send to the admin to approve on it</div>";
                                }elseif($row["GroupID"] == 1) {

                                echo '<input type="submit" name="seller" class="btn btn-block btn-primary confirm" value="Be Seller">';
                                }
                             }
                        ?>
                        </form>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <!--End Edit_Profile-->
            </div>
        </div>
    </div>
</div>
<?php
        }
    }elseif (@$_SESSION["logged_as_blocker"] == 'yes') {
        header("Location: blocked.php");
        exit();
    }
	include "includes/templates/footer.php";
    ob_end_flush();

?>
