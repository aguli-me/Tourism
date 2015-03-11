<?php
    require_once("RSSFeed.class.php");
    $name = "Bracelet";
    
    $instance = new createRSS();
    
    $instance->addItemSale($name,"155");
    
    $instance->deleteItemSale($name);

?>