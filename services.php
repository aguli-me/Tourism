<?php
	$title = 'HOME PAGE';
	include("header.inc.php");
	include("LIB_project1.php");
	
?>


<?php

	$dom = new DOMDocument();
	$dom->load("rss_class.xml");
	
	
	$url = getRssUrls($dom);
	

?>


<?php
 
	include('footer.inc.php');
?>