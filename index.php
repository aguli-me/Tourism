<?php
	$title = 'HOME PAGE';
	include("header.inc.php");
	include("LIB_project1.php");
	
?>

<form method=POST action="index.php">

<div id="sale" >
	
	
<?php
	
    if(!array_key_exists("item",$_GET)){			
	$dom = getFileContent("catalog.xml");
	$str='';
	$butName ="cart";
	
	
	$str = dispSale($dom,$butName);
	echo($str);
	?>
	
	<?php
		if(isset($_POST['cart'])){
		  $select = $_POST['cart'];
			       
			 $dom = getFileContent('catalog.xml');
			
			 /** find the product details from the catalog file */
			 $productInfo=findProductDetails($dom,$select);
			  
			 
			  /** add the product info to the cart */
			  $status=addToFile("cart.xml",$productInfo);
			  
			  if(strpos($status,"CART")){
				 echo(displayAddMsg("ADDED TO THE CART !!"));
			 }
			  
			  /** edit the catalog quantity */
			  $prev=$productInfo[3];
			  $productInfo[3]=$prev-1;  
			 
			 editItemCatalog($productInfo);
		}
	
	?>
	
	
</div>
</form>


 
<div id="catalog">
		<form action="index.php" method="get">	
		No of items per Page : <select name="dispCount">
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
			<option value="6">6</option>
			<option value="7">7</option>
			<option value="7">8</option>
			<option value="7">9</option>
			<option value="7">10</option>
			<option value="7">11</option>
		</select>
		<button type="submit" name='pButton'>click</button>
		</form>
		
		<?php
		if(isset($_GET['pButton'])){
                        $per_page=$_GET['dispCount'];
                        
                }
                else{
                    $per_page=5;
                }
                
			if(isset($_GET['page'])){
                            $pageNo=$_GET['page'];
                        }
                        else{
                        $pageNo=1;
                        }
                        
			$domList = $dom->getElementsByTagName("product");
			$pages =ceil($domList->length/$per_page)-1;
			?>
                
<form method=POST action="index.php">		
		<?php
		
				
		
		$i = ($pageNo-1)*$per_page;
		
		$butName="but";
		echo dispItem($i,$per_page,$dom,$butName);
		
		?>
		
		
 
		<?php
			     if(isset($_POST['but'])){
			     
					$select = $_POST['but'];
				   
					$dom = getFileContent('catalog.xml');
				   
				    /** find the product details from the catalog file */
				    
				    $productInfo=findProductDetails($dom,$select);
				    
				     /** add the product info to the cart */
				     $status = addToFile("cart.xml",$productInfo);
				     
				     if(strpos($status,"CART")){
						echo(displayAddMsg("ADDED TO THE CART"));
					}
					
				    /** edit the catalog quantity */
					$prev = $productInfo[3];
					$productInfo[3]=$prev - 1;   
					
					
					editItemCatalog($productInfo); 
		       
			     } 
		?>
		
		<div id="pagination">
			<?php
				if($pageNo > $pages){
					header("Location:index.php");
                                      
				}
                             
				$str = pagination($pages,$pageNo,$per_page);
				echo ($str);
                
    
	?>
<?php
}
    else{
		
		$id = $_GET['item'];
		
		$dom=getFileContent("catalog.xml");
		$productName = getProductName($dom,$id);
		$ar=findProductDetails($dom,$productName);
		
		
		$str  ="<div class='perm'><img src='images/".$ar[4]."' alt='".$ar[1]."' width='200' height='150' class='permImg'/>";
                $str .= "<br/> <strong> NAME : </strong>".$ar[0]."<br/> <strong> DESCRIPTION : </strong>".$ar[1]."<br/> <strong> QUANTITY : </strong>".$ar[3]."<br/> ";
		
		if($ar[5]== 0){
			$str .="<strong> RETAIL PRICE : $".$ar[2]."</strong>!<br/>";
		}
		else{
			$str .="<strong> RETAIL PRICE : $</strong>".$ar[5] ."-- Previously $".$ar[2]." !<br/>";
		}
                
		$str.="</div><div class='clear'></div><br/><h2><a href='index.php'>GO BACK TO THE PREVIOUS PAGE !</a></h2>";
		
		echo($str);
        }
?>
		
		</div>
</form>		
		
</div>


 
 <?php
 
	include('footer.inc.php');
?>