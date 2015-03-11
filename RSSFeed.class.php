<?php

    
    class createRSS{
        
        public $filename="project2.rss";
        
        /**function that adds an item to sale
         *basically sets the sale price of the item to the value specified by $salePrice*/
        function createProjectRss($productInfo){
               $dom=$this->loadFile();
               $domList = $dom->getElementsByTagName('channel')->item(0);
				//$len = $domList->getElementsByTagName('product')->length;
				$product = $dom->createElement('item');
				$i=0;
				$name = $dom->createElement("title",$productInfo[$i]);
				$name = $product->appendChild($name);
				$url = "http://people.rit.edu/axg4202/739/project2/index.php?item=".$productInfo[6];
				$link = $dom->createElement("link",$url);
				$link = $product->appendChild($link);
				$i++;
				$desc =  $dom->createElement("description",$productInfo[$i]);
				$desc = $product->appendChild($desc);
				$i++;
				$price =  $dom->createElement("price",$productInfo[$i]);
				$price = $product->appendChild($price);
				$i++;
				$i++;
				$i++;
				$sale = $dom->createElement("salePrice",$productInfo[$i]);
				$sale =$product->appendChild($sale);
				
				$date=date('l F j, Y, g:i a');
				$pub = $dom->createElement("pubDate",$date);
				$pub =$product->appendChild($pub);
				
				$domList = $domList->appendChild($product);
				$dom->save($this->filename);

        }
        
        
        /** function that takes an item off sale .
         * basically makes the item's salePrice = 0 */
//        function deleteItemSale($item){
//             
//              $dom=$this->loadFile();
//               $domList = $dom->getElementsByTagName('channel')->item(0);
//				//$len = $domList->getElementsByTagName('product')->length;
//				$product = $dom->createElement('item');
//				$i=0;
//				$name = $dom->createElement("title",$productInfo[$i]);
//				$name = $product->appendChild($name);
//				$url = "http://people.rit.edu/axg4202/739/project2/index.php?item=".$productInfo[6];
//				$link = $dom->createElement("link",$url);
//				$link = $product->appendChild($link);
//				$i++;
//				$desc =  $dom->createElement("description",$productInfo[$i]);
//				$desc = $product->appendChild($desc);
//				$i++;
//				$price =  $dom->createElement("price",$productInfo[$i]);
//				$price = $product->appendChild($price);
//				$i++;
//				$i++;
//				$i++;
//				$sale = $dom->createElement("salePrice",$productInfo[$i]);
//				$sale =$product->appendChild($sale);
//				
//				$date=date('l F j, Y, g:i a');
//				$pub = $dom->createElement("pubDate",$date);
//				$pub =$product->appendChild($pub);
//				
//				$domList = $domList->appendChild($product);
//				$dom->save($this->filename);
//        }
        
	
        /**function that loads the file */
        function loadFile(){
                $dom = new DomDocument();
               $dom->load($this->filename);
               return $dom;
        }
    }
?>