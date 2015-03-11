<?php
	$title = 'CONTACT US';
	include('header.inc.php');
	include('LIB_project1.php');
?>

<div id="con">
	<h2>THANK YOU FOR VISITING OUR WEBSITE !</h2>
	Please contact us if you need any assistance or for any sort of enquiry .
	<br/><br/>
	<form method="POST" action="contact.php">
		Name : <input type="text" name="name" /><br/>
		Email: <input type="text" name="email" /><br/>
		Comments/Enquiry :<br/>
		<textarea rows="8" cols="40" name="comm" ></textarea><br/>
		<button type="submit" name="submit">submit</button><br/><br/>
	</form>
</div>	
	
	<?php
		
		if(isset($_POST['submit'])){
			
			
			
			if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['comm'])) {
				$com = "feedback taken successfully !";
				echo("<br/><strong>$com</strong>");
				
				$comments[] = sanitizer($_POST['name']);
				$comments[] = sanitizer($_POST['email']);
				$comments[] = sanitizer($_POST['comm']);
				
				$commInfo = implode('|',$comments);
				$commInfo .= "\n";
				
				appendFile($commInfo,'comments.txt');	
			}
		}
		
	?>


<?php
	include('footer.inc.php');
?>