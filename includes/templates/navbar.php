<?php

    session_start();
 include "connect.php";
    //==========================================
    // Start SignUP

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['SignUp'])){

            // Get the data From the Form

            $username        = trim(strip_tags($_POST['username']));
            $email           = trim(strip_tags($_POST['email']));
            $pass            = trim(strip_tags($_POST['pass']));
            $con_pass        = trim(strip_tags($_POST['con_pass']));
            $natId           = trim(strip_tags($_POST['natId']));
            $dir_name        = dirname(__FILE__) . "../../../Layout/img/users_image/";
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

            $Errors     = array();

            if(empty($username)){

                $Errors[] = 'You Must Enter The User Name';

            }
            if(empty($email)){

                $Errors[] = 'You Must Enter The Email';

            }
            if(empty($pass)){

                $Errors[] = 'You Must Enter The Password';

            }
            if(strval($pass) !== strval($con_pass)){

                $Errors[] = 'The passwoed Dosen\'t match';

            }
            if(empty($natId)){

                $Errors[] = 'The National Id Is Important';

            }

            if(!empty($Errors)){
                //loop to see the errors
                foreach($Errors as $err){
                    echo "<div class='container'>";
                         echo "<div style='position: absolute;top: 171px;width: 100%;background-color: #F2F1FF;box-shadow: 6px 4px 52px #ccc;padding: 20px;border-radius: 5px;'>";
                             echo '<h1 style="color: #888;text-align: center;font-family: cursive;margin: 30px auto;margin-top: 0;border-bottom: 1px solid #f8dede;width: 476px;">Errors in Your Inputs Please check</h1>';
                            echo "<div class='alert alert-danger'>".$err."</div>";
                        echo "</div>";
                    echo "</div>";

                }
            }

            if(empty($Errors)){
               $check = checkItme("username", "users", $username);
               if ($check > 0) {
                        echo '<div class="alert alert-danger">the inserted username ( ' . $username . ' ) is exist </div>';
                } else {
                    // Insert
                    $stmt = $conn->prepare("INSERT INTO `users`(`National_ID`, `username`, `Email`, `Password`, userImg, GroupID) VALUES(:nationalID, :userName, :email, :pass, :img, :grp)");
                    $stmt->execute(array(
                                        "nationalID"    => $natId,

                                        "userName"      => $username,

                                        "email"         => $email,

                                        "pass"          => $pass,

                                        "img"          => $name,
                                        'grp'          => 1

                                        ));

                    // Sucess

                    $theMsg = '<div> Hello '.$username.' You Will Be Redirected To the home page in 5 Seconds</div>';
                    echo '<div
                                style="
                                        position: absolute;
                                        z-index: 999;
                                        background-color: #f5f5f5;
                                        width: 500px;
                                        padding: 20px;
                                        box-shadow: 1px 3px 42px #999;
                                        margin: 170px 384px;
                                        text-align: center;
                                        border-radius: 5px;
                                      ">';
                    echo '<div class="alert alert-success" >' . $theMsg . '</div>';

                    echo "</div>";

                    header('refresh:5;url=index.php');

                }    exit();
            }
       }
    }

    // End SignUP
    //=======================================================
?>
<?php if(isset($_SESSION['username']) && $_SESSION['logged'] == 'yes'){ ?>
<div class="ui left vertical menu sidebar">
    <div class="ui styled fluid accordion">
        <?php
        $stmt = $conn->prepare("SELECT * FROM categories");
        $stmt->execute();
        $cats = $stmt->fetchAll();
        $count = $stmt->rowCount();
        if($count > 0){foreach($cats as $cat){?>
        <!--Categoury start-->
        <div class="title">
            <i class="dropdown icon"></i>
            <?php echo $cat['Name']; ?>
        </div>
        <!--Categoury End-->

        <!--Sub Cat Start-->
        <div class="content">
            <div class="title">
                <?php
                $stmt = $conn->prepare("SELECT * FROM subcategories WHERE Cat_ID = ?");
                $stmt->execute(array($cat['Cat_ID']));
                $subcats = $stmt->fetchAll();
                $count = $stmt->rowCount();
                if($count > 0){foreach($subcats as $subcat){
                ?>
                <a href='products.php?do=viewProduct&brandId=<?php echo $subcat['subCatId'] ?>&cayegoryId=<?php echo $cat['Cat_ID'] ?>' style="font-weight:normal;padding:6px;"><?php echo $subcat['subCatName'] ?></a> <br> <hr>
                <?php }} ?>
            </div>
        </div>
        <!--Sub Cat End-->
        <?php }}?>
    </div>
</div>
<div class="pusher">
    <!--***********************************
                NAVBAR SECTION
    ************************************-->
        <nav id="navbar">

            <!--***********************************
                        TOP NAV
            ************************************-->
            <div id="top-nav">
                <div class="container">

                    <div class="float-left"id="top-nav-left">
                        <ul>
                            <li><a href=""><span>Call : </span>01127946754</a></li>
                            <li>Welcome <strong><?php echo $_SESSION['username'] ?></strong></li>
                        </ul>
                    </div>
                    <div class="float-right" id="top-nav-right">
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <li><a href="products.php">Products</a></li>
                            <li><a href="about.php">About</a></li>
                            <li><a href="contact-us.php">Contact Us</a></li>
                            <li><a href="profile.php">Profile</a></li>
                            <li><a href="logOut.php">LogOut</a></li>
                        </ul>
                    </div>

                </div> <!-- CONTAINER END -->
            </div> <!-- TOP NAV END -->

            <!--***********************************
                        BOTTOM NAV
            ************************************-->
            <div id="bottom-nav">
                <div class="container">

                    <!--***********************************
                                LOGO SECTION
                    ************************************-->

                    <div id="logo" class="float-left">
                        <img src="Layout/img/logo.png" alt="">
                    </div>

                    <!--***********************************
                            NVBAR CONTENT SECTION
                    ************************************-->

                    <div id="nav-content" class="float-left">
                        <div id="search-input" class="float-left">
                            <form action="search.php" method="get">
                                <div style="width:100%">
                                    <input name="s_result" style="width:75%" type="text" name="search" placeholder="Search..">
                                    <input class="search_btn" style="width:20%" type="submit" name="submit" value="search" />
                                </div>
                            </form>
                        </div>

                        <div id="nav-card" class="float-left">
                            <a style="color:#232323" href="profile.php?do=check"><i class="fa fa-shopping-cart fa-2x" aria-hidden="true"></i>
                            <?php $countCart = countItem('basket_ID' , 'shopping_basket', $_SESSION['userId']);?>
                            <span class="<?php if($countCart > 0) {echo 'countCart';} ?>" >
                            <?php
                            if($countCart > 0) {
                                echo $countCart;
                            }else{
                                echo'';
                            }

                            ?>
                            </span>
                            </a>
                        </div>

                        <div id="categ-menu">
                            <a style="color:#232323" id="category-menu"><i class="fa fa-bars fa-2x" aria-hidden="true"></i></a>
                        </div>
                    </div>

                </div> <!-- CONTAINER END -->
            </div><!-- NAVBAR BOTTOM END -->

    </nav><!-- NAVBAR END -->


<?php }else{ ?>
<div class="ui left vertical menu sidebar">
    <div class="ui styled fluid accordion">
        <?php
        $stmt = $conn->prepare("SELECT * FROM categories");
        $stmt->execute();
        $cats = $stmt->fetchAll();
        $count = $stmt->rowCount();
        if($count > 0){foreach($cats as $cat){?>
        <!--Categoury start-->
        <div class="title">
            <i class="dropdown icon"></i>
            <?php echo $cat['Name']; ?>
        </div>
        <!--Categoury End-->

        <!--Sub Cat Start-->
        <div class="content">
            <div class="title">
                <?php
                $stmt = $conn->prepare("SELECT * FROM subcategories WHERE Cat_ID = ?");
                $stmt->execute(array($cat['Cat_ID']));
                $subcats = $stmt->fetchAll();
                $count = $stmt->rowCount();
                if($count > 0){foreach($subcats as $subcat){
                ?>
                <a href='products.php?do=viewProduct&brandId=<?php echo $subcat['subCatId'] ?>&cayegoryId=<?php echo $cat['Cat_ID'] ?>' style="font-weight:normal;padding:6px;"><?php echo $subcat['subCatName'] ?></a> <br><hr>
                <?php }} ?>
            </div>
        </div>
        <!--Sub Cat End-->
        <?php }}?>
    </div>
</div>
<div class="pusher">
    <!--***********************************
                MODALS SECTION
    ************************************-->

    <div id="modals">
        <!-- ***********************
                Sign In Modal
        ************************ -->
        <div id="sign-in-modals">
            <div class="ui modal small sign-in-modal">
              <div class="header">Sign In</div>
                <div class="content">
                <form action="login.php" method="post">
                    <input type="text" placeholder="Username" name="name">
                    <input type="password" placeholder="Password" name="pass">
                    <div class="actions">
                        <input type="submit" class="ui approve button" value="Sign In" name="Sign In">
                        <div class="ui cancel button">Cancel</div>
                    </div>
                </form>
                </div>
            </div>
        </div>

        <!-- ***********************
                Sign UP Modal
        ************************ -->
        <div id="sign-up-modals">
            <div class="ui modal small sign-up-modal">
              <div class="header">Sign Up</div>
              <div class="content">
                <form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                    <input type="text" placeholder="Username *" name="username" required autocomplete="off">
                    <input type="email" placeholder="Email *" name="email" required autocomplete="off">
                    <input type="password" placeholder="Password *" name="pass" required autocomplete="off">
                    <input type="password" placeholder="Confirm Password *" name="con_pass" required autocomplete="off">
                    <input type="text" placeholder="National ID *" name="natId" required autocomplete="off">
                    <input type="file" name="img">
                    <div class="actions">
                        <input type="submit" class="ui approve button" value="SignUp" name="SignUp">
                        <div class="ui cancel button">Cancel</div>
                    </div>
                </form>
              </div>
            </div>
        </div>
    </div>


    <!--***********************************
                NAVBAR SECTION
    ************************************-->
        <nav id="navbar">

            <!--***********************************
                        TOP NAV
            ************************************-->
            <div id="top-nav">
                <div class="container">
                    <div class="float-right" id="top-nav-right">
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <li><a href="about.php">About</a></li>
                            <li><a href="contact-us.php">Contact Us</a></li>
                        </ul>
                    </div>
                </div> <!-- CONTAINER END -->
            </div> <!-- TOP NAV END -->

            <!--***********************************
                        BOTTOM NAV
            ************************************-->
            <div id="bottom-nav">
                <div class="container">

                    <!--***********************************
                                LOGO SECTION
                    ************************************-->

                    <div id="logo" class="float-left">
                        <img src="Layout/img/logo.png" alt="">
                    </div>

                    <!--***********************************
                            NVBAR CONTENT SECTION
                    ************************************-->

                    <div id="nav-content" class="float-left">

                            <div id="nav-regester" class="float-left">
                                <ul>
                                    <li><a href="#" id="signin-modal">Log In</a></li>
                                    <li>|</li>
                                    <li><a href="#" id="regest-modal">Regester</a></li>
                                </ul>
                            </div>

                            <div id="search-input" class="float-left">
                                <form action="search.php" method="get">
                                    <div style="width:100%">
                                        <input name="s_result" style="width:75%" type="text" name="search" placeholder="Search..">
                                        <input class="search_btn" style="width:20%" type="submit" name="submit" value="search" />
                                    </div>
                                </form>
                            </div>

                            <div id="nav-card" class="float-left">
                                <a href="#"><i class="fa fa-shopping-cart fa-2x" aria-hidden="true"></i></a>
                            </div>

                            <div id="categ-menu">
                                <a href="#" id="category-menu"><i class="fa fa-bars fa-2x" aria-hidden="true"></i></a>
                            </div>

                    </div>

                </div> <!-- CONTAINER END -->
            </div><!-- NAVBAR BOTTOM END -->

    </nav><!-- NAVBAR END -->
<?php } ?>
