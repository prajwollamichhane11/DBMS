<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title><?php echo $page_title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="Resturant website" /> 
<meta name="keywords" content="Resturant, food, free, cheap" /> 
<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" />

<!--Scripts-->



<!--[if lt IE 7]>
   <script type="text/javascript" src="ie_png.js"></script>
   <script type="text/javascript">
       ie_png.fix('.png, .logo h1, .box .left-top-corner, .box .right-top-corner, .box .left-bot-corner, .box .right-bot-corner, .box .border-left, .box .border-right, .box .border-top, .box .border-bot, .box .inner, .special dd, #contacts-form input, #contacts-form textarea');
   </script>
<![endif]-->
</head>
	
<body id="page1">

   <!-- header -->
   <div id="header">
      <div class="container">
         <div class="wrapper">
             
            <p class="welcome-top"><?php // welcome message:<!---->
             function greet ($name, $msg){
             	
                if ( (isset($_SESSION['employee_id'])) && (!strpos($_SERVER['PHP_SELF'], 'logout.php')) ) {
		 	$name="{$_SESSION['first_name']}"
			;
		 	
			} else {
			$name="Guest";
                }
             echo "Hi $name, $msg";
             }
?>
             			
		 	
		
			</p>
              <ul class="top-links">            
             <li><a href="index.php" class="first"><img alt="" src="images/icon-home.gif" /></a></li>
               <li><a href="contact.php"><img alt="" src="images/icon-mail.gif" /></a></li>
               <li><a href="#"><img alt="" src="images/icon-map.gif" /></a></li>
			   <li><?php // Create a login/logout link:<!---->
			if ( (isset($_SESSION['employee_id'])) && (!strpos($_SERVER['PHP_SELF'], 'logout.php')) ) {
		 	echo ' <a href="admin_panel.php"><img src="./images/user_accept.png" alt="" width="32" height="32" longdesc="admin_menu.php" /></a>';
			} else {
			echo '';
                }
			?>
		        		        </li>
            </ul>
           
         </div>
         <ul class="nav">
            <li><a href="index.php" class="first current">Home</a></li>
            <li><a href="about.php">About</a></li>
           
            <li><a href="contact.php">Contact</a></li>
			<li><a href="browse_menu.php">Menu</a></li>
			<li><?php // Create a login/logout link:<!--<a href="admin_panel.php">Admin</a>-->
			if ( (isset($_SESSION['employee_id'])) && (!strpos($_SERVER['PHP_SELF'], 'logout.php')) ) {
		 	echo ' <a href="logout.php">Logout</a>';
			} else {
			echo '<a href="login.php">Login</a>';
			}
			?></li>
           
         </ul>
      </div>
   </div>
  	
   <!-- content -->