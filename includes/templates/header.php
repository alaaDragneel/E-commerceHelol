<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- IE Combitability Meta -->
            <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Mobile First Meta -->

					 <title><?php getTitle(); ?></title>
                     
			<link rel="stylesheet" href="Layout/css/semantic.min.css"> <!-- semantic.css File -->
            <link rel="stylesheet" href="Layout/css/bootstrap.min.css">
			<link rel="stylesheet" href="Layout/font-awesome/css/font-awesome.min.css"> <!-- font awesome.css file -->
			<link rel="stylesheet" href="Layout/css/animate.css"> <!-- Animate.CSS File -->
            <link rel="stylesheet" href="Layout/css/owl.carousel.css"> <!-- Owl Carousel.CSS File -->
			<link href="Layout/css/hover.css" rel="stylesheet" media="all"> <!-- Hover.CSS File -->
			<link rel="stylesheet" href="Layout/css/jquery-ui-1.10.4.custom.css"> <!-- jquery-ui Query File -->
			<link rel="stylesheet" href="Layout/css/jquery.selectBoxIt.css"> <!-- selectBoxIt Query File -->
			<link rel="stylesheet" href="Layout/css/style.css"> <!-- CSS File -->
            <link rel="stylesheet" href="Layout/css/style2.css"> <!-- SECOND CSS File /*this file has all new features style*/ -->
			<link rel="stylesheet" href="Layout/css/media.css"> <!-- Media Query File -->
			<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet"> <!-- Font -->
	        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	        <!--[if lt IE 9]>
	        <script src="js/html5shiv.min.js"></script>
	        <script src="js/respond.min.js"></script>
	    	<![endif]-->

        </head>
        <script>
            function likeDisLike() {
      
                    var xmlhttp = new XMLHttpRequest();
                
                
                    xmlhttp.onreadystatechange = function() {   
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
                    }
                }   //the way to request        //if page can make any thing to it during the function [true] or not[false]
                    xmlhttp.open("GET", "rate.php?q=1", true);
                    xmlhttp.send();
                  
            }

            function DisLike() {
      
                    var xmlhttp = new XMLHttpRequest();
                
                
                    xmlhttp.onreadystatechange = function() {   
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
                    }
                }   //the way to request        //if page can make any thing to it during the function [true] or not[false]
                    xmlhttp.open("GET", "ratedis.php?s=1", true);
                    xmlhttp.send();
                  
            }
        </script>
        <body style="position: relative;">