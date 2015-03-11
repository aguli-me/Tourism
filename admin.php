<?php
	$title = 'ADMIN';
	include('header.inc.php');
	include('LIB_project1.php');	
	include('RSSFeed.class.php');
?>

<h2>ADMINISTRATOR PAGE</h2>
<?php
	if(isset($_POST['submit'])){
	   if($_POST['pswd'] === "pass"){
	   
			// if(empty($_POST['name']) || empty($_POST['desc']) || empty($_POST['price']) || empty($_POST['qty']) || empty($_POST['sale']) || empty($_POST['image'])){
				
				// echo(displayAddMsg("Add Form Input Fields Invalid!!"));
		
			// }
			// else{
			
				$pic = $_FILES['image']['name'];
				$tmp = $_FILES['image']['tmp_name'];
				$loc = 'images/'.$pic;
				move_uploaded_file($tmp,$loc);
				chmod($loc, 0755);			
				
				$pInfo[0] = sanitizer($_POST['name']);
				$pInfo[1] = sanitizer($_POST['desc']);
				$pInfo[2] = sanitizer($_POST['price']);
				$pInfo[3] = sanitizer($_POST['qty']);
				$pInfo[4] = $pic;
				$pInfo[5] = sanitizer($_POST['sale']);
				
				$status=addToFile("catalog.xml",$pInfo);
				echo(displayAddMsg($status));
				
				if((strpos($status,"CATALOG"))&&($pInfo[5] !=0)){
					$rss=new createRSS();
					$dom = getFileContent("catalog.xml");
					$pro = findProductDetails($dom,$pInfo[0]);
					$rss->createProjectRss($pro);
				}
			
		}
	   else{
			echo(displayAddMsg("INVALID PASSWORD !!"));
		}
	}


?>


<div id="add">
	<h3>ADD AN ITEM : </h3>
	<form action="admin.php" method="POST" name="myForm" enctype="multipart/form-data">
	  <table>
	      <tr>
			<td>Name : </td>
			<td> <input type="text" name="name" /> <br/></td>
	      </tr>
		<tr>
			<td>Description : </td>
			<td><textarea name="desc" ></textarea> <br/></td>
		</tr>
		<tr>
			<td>Price : </td>
			<td><input type="text" name="price"/> <br/></td>
		</tr>
		
		<tr>
			<td>Quantity : </td>
			<td><input type="text" name="qty" /> <br/></td>
		</tr>
		<tr>
			<td>Sale Price : </td>
			<td><input type="text" name="sale" /> <br/></td>
		</tr>
		<tr>
			<td>Image :</td>
			<td><input type="file" name="image" /></td>
			
		</tr>
		
		<tr>
			<td>Password : </td>
			<td><input type="password" name="pswd" /> <br/></td>
		</tr>
	  </table>
	  <br/>
	  <button type="reset" name="reset">RESET FORM</button> &emsp;
	  <button type="submit" name="submit">SUBMIT FORM</button>
	  <br/>
	</form>
</div>


<?php
	$disp = "hide";
	if(isset($_POST['list'])){
		
		$disp = "show";
		$select = $_POST['list'];
		$dom=getFileContent("catalog.xml");
		$pro=findProductDetails($dom,$select);
		
		$prodName = $pro[0];
		$prodDesc = $pro[1];
		$prodPrice = $pro[2];
		$prodQty = $pro[3];
		$prodSale = $pro[5];
		
	}
	else{
		$disp = "hide";
		$prodName = "";
		$prodDesc = "";
		$prodPrice = "";
		$prodQty = "";
		$prodSale = "";
	}
?>


<div id="edit">
	<h3>CHOOSE AN ITEM TO EDIT : </h3>
	<form action="admin.php" method="POST" enctype="multipart/form-data">
		<select name="list">
			<?php
				$dom=getFileContent("catalog.xml");
				$domProducts = $dom->getElementsByTagName('product');
				foreach($domProducts as $domP){
					
					$proName = $domP->getElementsByTagName('name')->item(0)->nodeValue;
					$proDesc=$domP->getElementsByTagName('description')->item(0)->nodeValue;
					
			?>
			<option value="<?=$proName?>" ><?php echo("$proName - $proDesc"); ?></option>
			<?php
		
			}
			?>
		</select>
		
		<button type="submit" name="selectButton">select</button>
		<br/><br/>
		
		<table class="<?= $disp ?>">
			<tr>
				  <td>Name : </td>
				  <td> <input type="text" name="nameEdit" value="<?= $prodName?>" /></td>
			</tr>
			  <tr>
				  <td>Description : </td>
				  <td><textarea name="descEdit"><?= $prodDesc?></textarea> </td>
			  </tr>
			  <tr>
				  <td>Price : </td>
				  <td><input type="text" name="priceEdit" value="<?= $prodPrice?>" /> </td>
			  </tr>
			  
			  <tr>
				  <td>Quantity : </td>
				  <td><input type="text" name="qtyEdit" value="<?= $prodQty?>" /> </td>
			  </tr>
			  <tr>
				  <td>Sale Price : </td>
				  <td><input type="text" name="saleEdit" value="<?= $prodSale?>" /> </td>
			  </tr>
			  <tr>
				  <td>Image :</td>
				  <td><input type="file" name="img"/></td>
			  </tr>
			  
			  <tr>
				  <td>Password : </td>
				  <td><input type="password" name="pswd" /> </td>
			  </tr>
			
			<tr>
			<td colspan="2"><button type="submit" name="submitSec">SUBMIT FORM</button></td>
			</tr>
		</table>
	</form>
</div>
<?php
if(isset($_POST['submitSec'])){
	if($_POST['pswd'] === "pass"){
		// if ((empty($_POST['nameEdit'])) || (empty($_POST['img'])) || (empty($_POST['descEdit'])) || (empty($_POST['priceEdit'])) || (empty($_POST['qtyEdit'])) || (empty($_POST['saleEdit']))) {
		
			// echo(displayAddMsg("Edit Form Input Fields Invalid!!"));
		// }
		// else	
		// {
		
			
			
			$pic2 = $_FILES['img']['name'];
			$tmp2 = $_FILES['img']['tmp_name'];
			$loc2 = 'images/'.$pic2;
			move_uploaded_file($tmp2,$loc2);
			chmod($loc2, 0755);
			
			
			$it[0]= sanitizer($_POST['nameEdit']);
			$it[1]=sanitizer($_POST['descEdit']);
			$it[2]=sanitizer($_POST['priceEdit']);
			$it[3]=sanitizer($_POST['qtyEdit']);
			$it[4]=$pic2;
			$it[5]=sanitizer($_POST['saleEdit']);
		
			$saleStatus = saleStatus($it);
			
			if(countSales()>3){
				
				$val =editItemCatalog($it);
				echo(displayAddMsg($val));
				$rss2=new createRSS();
				$dom2 = getFileContent("catalog.xml");
				$pro2 = findProductDetails($dom,$it[0]);
				$rss2->createProjectRss($pro2);
			}
			else{
					echo(displayAddMsg("Cannot put off sale"));
			}
	}
}

?>

<div id='services'>
	<?php
	
		if(isset($_POST['stuSubmit'])){
			if($_POST['stu'] === "pass"){
				$selectRss = $_POST['stores'];
				
				$strRss = editRss($selectRss);
				echo (displayAddMsg($selectRss." ".$strRss));
			}
		}
		
		if(isset($_GET['remove'])){
			$rem = $_GET['remove'];
			$strDel = delRss($rem);
			echo(displayAddMsg($rem." ".$strDel));
			
		}
	?>
	<form action='admin.php' method='POST'>
		<strong>CHOOSE UP TO 10 STUDENTS' STORES :</strong>
		<select name='stores'>
			<?php
				$domR=getFileContent("rss_class.xml");
				
				$domRList = $domR->getElementsByTagName('student');
				foreach($domRList as $r){
					
					$fst = $r->getElementsByTagName('first')->item(0)->nodeValue;
					$lst = $r->getElementsByTagName('last')->item(0)->nodeValue;
					$url = $r->getElementsByTagName('url')->item(0)->nodeValue;
			?>
			<option value='<?= $lst ?>'><?php echo($fst ." " .$lst); ?></option>
			<?php
				}
			?>
		</select>
	
	
		<div id='dispStudents'>
			<?php
				
				$domR=getFileContent("rss_class.xml");
					
				$domRList = $domR->getElementsByTagName('student');
				$student = "<table>";
				foreach($domRList as $r){
					$dispVal = $r->getAttribute("selected");
					
					if($dispVal === "yes"){
						$fst = $r->getElementsByTagName('first')->item(0)->nodeValue;
						$lst = $r->getElementsByTagName('last')->item(0)->nodeValue;
						
						$student.="<tr><td><div class='stuItem'>".$fst."  ".$lst."  -  <a href='http://people.rit.edu/axg4202/739/project2/admin.php?remove=".$lst."'>Remove</a></div></td></tr>";
					}
				}
				$student.="</table>";
				echo($student);
			?>
			
		</div>
		
		Password : <input type="text" name="stu"/>
		<button type="submit" name="stuSubmit">Save</button>
	</form>
</div>

<?php
	include('footer.inc.php');
?>