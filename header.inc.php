<?php
	$mobile = $_SERVER['HTTP_USER_AGENT'];
	if (stristr($mobile,"iPhone") || stristr($mobile, "Windows CE") || stristr($mobile, "AvantGo") || stristr($mobile, "Mobile") || stristr($mobile, "Android") ) {
				$CSS="css/mob.css";
			}
	else{
			$CSS="css/style.css";
	}
?>


<!DOCTYPE html>

<html>
<head>
	<title>SHOPPING - <?php echo($title); ?></title>
	<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="<?= $CSS ?>" />
</head>
<body>  

	
<div id="header">
	<img src="css/website.gif" alt="image of website name" style="float:left;"/>
	<img src="css/HEIDI.gif" alt="image of a gal" />
</div>

<div id="wrap">	
	<div id="top">
		<ul>
			<li><a <?php if (strpos($_SERVER['PHP_SELF'], 'index.php')) echo 'class="current"'?> href="index.php">HOME</a></li>
			<li><a <?php if (strpos($_SERVER['PHP_SELF'], 'cart.php')) echo 'class="current"'?> href="cart.php">CART</a></li>
			<li><a <?php if (strpos($_SERVER['PHP_SELF'], 'admin.php')) echo 'class="current"'?> href="admin.php">ADMIN</a></li>
			<li><a <?php if (strpos($_SERVER['PHP_SELF'], 'contact.php')) echo 'class="current"'?> href="contact.php">CONTACT</a></li>
			<li><a <?php if (strpos($_SERVER['PHP_SELF'], 'services.php')) echo 'class="current"'?> href="services.php">SERVICES</a></li>
			<li><a <?php if (strpos($_SERVER['PHP_SELF'],'project2.rss')) echo 'class="current"'?> href="project2.rss">RSS FEED</a></li>
		</ul>
	 </div>
	<div id="content">
	
	
	
