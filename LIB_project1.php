<?php
include('P2_Utils.class.php');

/** explode and get the file content in array */
function getFileContent($fileName){
        
        $dom=new DomDocument();
	$dom->load($fileName);
        
        return $dom;
}

/** sanitise the input data */
function sanitizer($var){
    $var = trim($var);
    $var = stripslashes($var);
    $var = htmlentities($var);
    $var = strip_tags($var);
    return $var;
    }
    
/** that function that edits item in catalog.xml */
function editItemCatalog($itemEdit){
	
	
	
	$dom = getFileContent("catalog.xml");
	
	$domList = $dom->getElementsByTagName("product");
	
	foreach($domList as $d){
		$name= $d->getElementsByTagName("name")->item(0)->nodeValue;
		
		if($name === $itemEdit[0]){
			
			$d->getElementsByTagName("name")->item(0)->nodeValue=$itemEdit[0];
			$d->getElementsByTagName("description")->item(0)->nodeValue=$itemEdit[1];
			$d->getElementsByTagName("price")->item(0)->nodeValue=$itemEdit[2];
			$d->getElementsByTagName("qty")->item(0)->nodeValue=$itemEdit[3];
			$d->getElementsByTagName("image")->item(0)->nodeValue=$itemEdit[4];
			$d->getElementsByTagName("sale")->item(0)->nodeValue=$itemEdit[5];
			
			$dom->save("catalog.xml");
		}
	}
}

/**displays the items in the catalog */

function dispItem($i,$per_page,$dom,$butName){
        $str ="";
	$domList = $dom->getElementsByTagName("product");
	$count = 0;
	$i= $i+1;
	$startCount = 1;
	
        foreach($domList as $d){    
		$sale=$d->getElementsByTagName("sale")->item(0)->nodeValue;
		$num = $d->getAttribute("num");	
		if($startCount < $i && $sale ==0){
			$startCount++;
		}
		else{
	
	       
			 if($sale == 0){
				if($count < $per_page){
			
					$str .="<div class='item'><img src='images/".$d->getElementsByTagName('image')->item(0)->nodeValue."' alt='".$d->getElementsByTagName('name')->item(0)->nodeValue."' width='200' height='150' class='left'/>";
					$str .= "<br/> <strong> NAME : </strong><a href='index.php?item=".$num."'>".$d->getElementsByTagName('name')->item(0)->nodeValue."</a><br/> <strong> DESCRIPTION : </strong>".$d->getElementsByTagName('description')->item(0)->nodeValue."<br/> <strong> QUANTITY : </strong>".$d->getElementsByTagName('qty')->item(0)->nodeValue."<br/> ";
					
					$str .="<strong> RETAIL PRICE : $</strong>".$d->getElementsByTagName('price')->item(0)->nodeValue ."<br/> <button type='submit' name='".$butName."' value='".$d->getElementsByTagName('name')->item(0)->nodeValue."'>Add To Cart</button> <br/><br/></div><div class='clear'></div>";
					
					$count++;
				}
			}
		}
		
        }
       return $str;
}


/** display the page nos */
function pagination($pages,$pageNo,$per_page){
        $str = "";
        if($pages >=1 && $pageNo<=$pages){
                for($j=1;$j<=$pages;$j++){
                        if($j == $pageNo){
                                $str .="<strong>";
                        }
                        $str .= "<a href='?dispCount=".$per_page."&amp;page=".$j."&amp;pButton='>".$j."</a> ";
                        if($j == $pageNo){
                                $str.="</strong>";
                        }
			
                }
		//echo "<br/>$str <br/>";
	}
        return $str;
}









/** function that displays the items up for sale */

function dispSale($dm,$butName){
       
        $str ="";
       
        $domList = $dm->getElementsByTagName("product");
			
		foreach($domList as $d){
			
		$sale=$d->getElementsByTagName("sale")->item(0)->nodeValue;
		$num = $d->getAttribute("num");	
                if($sale != 0){
                        
			$str .="<div class='item'><img src='images/".$d->getElementsByTagName('image')->item(0)->nodeValue."' alt='".$d->getElementsByTagName('description')->item(0)->nodeValue."' width='200' height='150' class='left'/>";
			$str .= "<br/> <strong> NAME : </strong><a href='index.php?item=$num'>".$d->getElementsByTagName('name')->item(0)->nodeValue."</a><br/> <strong> DESCRIPTION : </strong>".$d->getElementsByTagName('description')->item(0)->nodeValue."<br/> <strong> QUANTITY : </strong>".$d->getElementsByTagName('qty')->item(0)->nodeValue."<br/> ";
			$str .="<strong> RETAIL PRICE : $</strong>".$d->getElementsByTagName('sale')->item(0)->nodeValue ."-- Previously $".$d->getElementsByTagName('price')->item(0)->nodeValue." !<br/> <button type='submit' name='".$butName."' value='".$d->getElementsByTagName('name')->item(0)->nodeValue."'>Add To Cart</button> <br/><br/></div><div class='clear'></div>";
		}
        }       
        
        return $str;
}


/** function that displays the message that product is added to the cart*/
function displayAddMsg($str){
	$str="<div id='msg'>".$str."</div>";
	return $str;
	
}

/** function finds the details of the product specified by the product name specified by $select parameter from the catalog.xml*/
function findProductDetails($dom,$select){

	$domList = $dom->getElementsByTagName('product');
	
		foreach($domList as $d){
		
	
		       $title = $d->getElementsByTagName('name')->item(0)->nodeValue;
		       
		       if($title == $select){
			       $qty = $d->getElementsByTagName('qty')->item(0)->nodeValue;
			       $desc = $d->getElementsByTagName('description')->item(0)->nodeValue;
			       $sale=$d->getElementsByTagName('sale')->item(0)->nodeValue;
			       $price = $d->getElementsByTagName('price')->item(0)->nodeValue;
			       $image = $d->getElementsByTagName('image')->item(0)->nodeValue;
				   $attr = $d->getAttribute('num');
			       
			       $product[0]=$title;
			       $product[1]=$desc;
			       $product[2]=$price;
			       $product[3]=$qty;
			       $product[4]=$image;
			       $product[5]=$sale;
				   $product[6]=$attr;
			       
			       return $product;
		       }
			
		}
				
}

/** function to add items to the  : $product is the array containing the information regarding the product
i.e., name , description, retail price and quantity . */
function addToFile($file,$productInfo){
	
	$dom = new DomDocument();
	$dom->load($file);
	$i=0;
	
	if($file ==="catalog.xml"){
			if($productInfo[5] != 0){
						
				$count = countSales();	
				if(($count==5) || ($count>5)) {
					$msg="CANNOT PUT THE PRODUCT ON SALE !!";
					return $msg;
				}
			}
	}
	
	
	$domList = $dom->getElementsByTagName('products')->item(0);
	$len = $domList->getElementsByTagName('product')->length;
	$product = $dom->createElement('product');
	
	$name = $dom->createElement("name",$productInfo[$i]);
	$name = $product->appendChild($name);
	$i++;
	$desc =  $dom->createElement("description",$productInfo[$i]);
	$desc = $product->appendChild($desc);
	$i++;
	$price =  $dom->createElement("price",$productInfo[$i]);
	$price = $product->appendChild($price);
	$i++;
	
	
	
	
	if($file == "catalog.xml"){
		$qty=  $dom->createElement("qty",$productInfo[$i]);
		$qty = $product->appendChild($qty);
		$i=4;
		$image =$dom->createElement("image",$productInfo[$i]);
		$image = $product->appendChild($image);
		$i++;
		$sale=$dom->createElement("sale",$productInfo[$i]);
		$sale = $product->appendChild($sale);
		$len = $len+1;
		$attr = $dom->createAttribute("num");
		$attr->value = $len;
		$product->appendChild($attr);
		$str="ADDED TO THE CATALOG !!";
	}
	
	else{
		$qty=  $dom->createElement("qty","1");
		$qty = $product->appendChild($qty);
		$str="ADDED TO THE CART !!";
	}
	$product = $domList->appendChild($product);
	$dom->save($file);
	return $str;
}

/** disp cart contents */
function dispCart(){
	$dom = new DOMDocument();
	$dom->load("cart.xml");
	
	$domList = $dom->getElementsByTagName('product');
	$str="";
	$tot = 0;
	foreach($domList as $d){
		
		$str.="<div class='cartItem'><strong> ".$d->getElementsByTagName('name')->item(0)->nodeValue;
		$str.="</strong> - ".$d->getElementsByTagName('description')->item(0)->nodeValue;
		$str.="<br/> Quantity  ".$d->getElementsByTagName('qty')->item(0)->nodeValue;
		$str.=" for  $".$d->getElementsByTagName('price')->item(0)->nodeValue;
		$str .=" each !</div>";
		$sum = $d->getElementsByTagName('price')->item(0)->nodeValue;
		$tot=$tot+$sum;
	}
	$arr[0]=$str;
	$arr[1]=$tot;
	return $arr;
}


function countSales(){
	$file="catalog.xml";
	$dom2 = new DomDocument();
	$dom2->load($file);
	$domList2 = $dom2->getElementsByTagName('product');
	$count =0;
	foreach($domList2 as $d){
		
		$sale = $d->getElementsByTagName('sale')->item(0)->nodeValue;
		if($sale !=0){
			$count = $count +1;
		}
	}
	return $count;
}


/** function that finds the product name by taking id as the input*/
function getProductName($dom,$id){
	$domList=$dom->getElementsByTagName('product');
	
	foreach($domList as $d ){
		$number=$d->getAttribute('num');
		
		if($number == $id){
			$name = $d->getElementsByTagName('name')->item(0)->nodeValue;
			return $name;
		}
	}
}

function getRssUrls($dom){
	
	$domList = $dom->getElementsByTagName('student');
	$url=array();
	foreach($domList as $it){
		$attr = $it->getAttribute('selected');
		
		if($attr == "yes"){
			$url = $it->getElementsByTagName('url')->item(0)->nodeValue;
			$fst = $it->getElementsByTagName('first')->item(0)->nodeValue;
			$lst = $it->getElementsByTagName('last')->item(0)->nodeValue;
			
			echo ("<h2>$fst $lst</h2>");
			$url = trim($url);
			$status = P2_Utils::getStatusCode($url);
			
			if($status ==200){
				
				$dom2 = new DomDocument();
				$dom2->load($url);
				$domList2 = $dom2->getElementsByTagName('item');
				$count =0;
				$str ="";
				foreach($domList2 as $d){
				
					if($count<3){
						$title = $d->getElementsByTagName('title')->item(0)->nodeValue;
						$link =$d->getElementsByTagName('link')->item(0)->nodeValue;
						$desc=$d->getElementsByTagName('description')->item(0)->nodeValue;
						$price=$d->getElementsByTagName('price')->item(0)->nodeValue;
						$sale=$d->getElementsByTagName('salePrice')->item(0)->nodeValue;
						$pubDate =$d->getElementsByTagName('pubDate')->item(0)->nodeValue;
						
						$str.= "<p class='info'><a href='".$link."'>".$title."</a><br/><br/>";
						$str.=$desc."<br/>Original Price : $".$price."<br/>Sale Price : $".$sale."<br/>".$pubDate."</p>";
						$count = $count +1;
						
					}
				}
				echo $str;
			 }
			 else{
				echo("<p class='info'>Cannot Load RSS !</p>");	
			 }
		}
	}
}






function saleStatus($itemEdit){
	
	$dom = getFileContent("catalog.xml");
	
	$domList = $dom->getElementsByTagName("product");
	
	foreach($domList as $d){
		$name= $d->getElementsByTagName("name")->item(0)->nodeValue;
		
		if($name === $itemEdit[0]){
			
			$prevSale=$d->getElementsByTagName("qty")->item(0)->nodeValue;
			
			
			if(($prevSale == 0)&&($itemEdit[3] !=0)){
				$saleCount = countSales();
				
				if($saleCount>4){
					$str = "CANNOT PUT ITEM ON SALE !!";
				}
				else{
					$str = "success";
				}
				return $str;
			}
			
			if(($prevSale != 0)&&($itemEdit[3] ==0)){
				$saleCount = countSales();
				
				 echo(displayAddMsg($saleCount));
				
				if($saleCount==3 || $saleCount<3){
					$str = "CANNOT PUT ITEM OFF SALE !!";
				}
				else{
					$str = "success";
				}
				return $str;
			}
			
			else{
				$str = "success";
				return $str;
			}
		}
	}
	
}

function editRss($url){
	
	
	$dom=getFileContent("rss_class.xml");
	
	$domList = $dom->getElementsByTagName("student");
	
	foreach($domList as $d){
		$dUrl = $d->getElementsByTagName("last")->item(0)->nodeValue;
	
		if($dUrl == $url){
			$d->setAttribute("selected","yes");
			$dom->save("rss_class.xml");
			return "RSS ADDED !!";
		}
	}
	//return "CANNOT ADD RSS !!";
}


function delRss($del){
	
	
	$dom=getFileContent("rss_class.xml");
	
	
	$domList = $dom->getElementsByTagName("student");
	
	foreach($domList as $d){
		$dUrl = $d->getElementsByTagName("last")->item(0)->nodeValue;
		
		if($dUrl == $del){
			$d->setAttribute("selected","no");
			$dom->save("rss_class.xml");
			return "RSS DELETED !!";
		}
	}
	///return "CANNOT DELETE RSS !!";
}
?>