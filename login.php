<?php
	ob_start();
	session_start();
	include "connect.php";
	include "includes/functions/functions.php";
     $pageTitle = "";
	include "includes/templates/header.php";
	//==========================================
	//Start Log In

	if(isset($_SESSION['username'])){

		header("Location: profile.php");

		exit();

	}

	//check the request method

	if($_SERVER['REQUEST_METHOD'] == 'POST'){

		// Get the data from the form

		$nameToTogin = trim(strip_tags($_POST['name']));

		$passToLogin = trim(strip_tags($_POST['pass']));

		$Errors = array();

		if(empty($nameToTogin)){

            $Errors[] = 'You Must Enter The username';

        }
        if(empty($passToLogin)){

            $Errors[] = 'You Must Enter The password';

        }
        if(!empty($Errors)){
	        //loop to see the errors
	            echo "<div class='container'>";
	           		 echo "<div style='position: absolute;top: 171px;width: 100%;background-color: #F2F1FF;box-shadow: 6px 4px 52px #ccc;padding: 20px;border-radius: 5px;'>";
	           			 echo '<h1 style="color: #888;text-align: center;font-family: cursive;margin: 30px auto;margin-top: 0;border-bottom: 1px solid #f8dede;width: 476px;">Errors in Your Inputs Please check</h1>';
	        foreach($Errors as $err){
	            		echo "<div class='alert alert-danger text-center'>".$err."</div>";

	        }
	            	echo "</div>";
	            echo "</div>";
	    }

        if(empty($Errors)){
			// check the data

			$stmt = $conn->prepare("SELECT userID, username, Password, GroupID FROM users WHERE username = ? AND Password = ?");

			$stmt->execute(array($nameToTogin, $passToLogin));

			$row = $stmt->fetch();

			$count = $stmt->rowCount();

			if($count > 0){
				if($row["GroupID"] == 3) {

				//if count > 0 this mean the database have he information for this user name
					$_SESSION["userId"] = $row['userID'];// register session id
					$_SESSION['username'] = $nameToTogin;//register session name
					$_SESSION['logged'] = 'yes';
					$_SESSION['logged_as_admin'] = 'yes';

					header("Location: ".$_SERVER['HTTP_REFERER']."");

					exit();

				} elseif($row["GroupID"] == 2) {
					//if count > 0 this mean the database have he information for this user name
					$_SESSION["userId"] = $row['userID'];// register session id
					$_SESSION['username'] = $nameToTogin;//register session name
					$_SESSION['logged'] = 'yes';
					$_SESSION['logged_as_seller'] = 'yes';

					header("Location: " . $_SERVER['HTTP_REFERER'] . "");

					exit();

				} elseif($row["GroupID"] == 1 || $row["GroupID"] == 4) {
					//if count > 0 this mean the database have he information for this user name
					$_SESSION["userId"] = $row['userID'];// register session id
					$_SESSION['username'] = $nameToTogin;//register session name
					$_SESSION['logged'] = 'yes';
					$_SESSION['logged_as_user'] = 'yes';

					header("Location: ".$_SERVER['HTTP_REFERER']."");

					exit();

				} elseif($row["GroupID"] == 0) {
					//if count > 0 this mean the database have he information for this user name
					$_SESSION["userId"] = $row['userID'];// register session id
					$_SESSION['username'] = $nameToTogin;//register session name
					$_SESSION['logged'] = 'yes';
					$_SESSION['logged_as_blocker'] = 'yes';
					header("Location: blocked.php");

					exit();
				}
			}else{
				echo "<div class='container'>";
	           		echo "<div style='position: absolute;top: 171px;width: 100%;background-color: #F2F1FF;box-shadow: 6px 4px 52px #ccc;padding: 20px;border-radius: 5px;'>";
	           			echo '<h1 style="color: #888;text-align: center;font-family: cursive;margin: 30px auto;margin-top: 0;border-bottom: 1px solid #f8dede;width: 476px;">Errors in Your Inputs Please check</h1>';
						$msg = "<div class='alert alert-danger text-center '> no user name is found please try again or signUp</div>";
						redirect($msg, '', 'home', 5);
					echo "</div>";
				echo "</div>";
			}
		}
	}
	ob_end_flush();

	//End Log In
	//==========================================
