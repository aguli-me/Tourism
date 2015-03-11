<?php
	$title = 'CART';
	include('header.inc.php');
	include('LIB_project1.php');
	//require_once( 'anet_php_sdk/AuthorizeNet.php');
	//include('P2_Utils.class.php');
	
	$fp_sequence = time(); // Any sequential number like an invoice number.
	$url = "http://people.rit.edu/axg4202/739/project2/cart.php";
	$api_login_id = '3WhN7e5Bf'; // your api login
	$transaction_key = '95S43Tfp5WpZ2675'; //Your transaction Key
	$md5_setting = '3WhN7e5Bf'; // Your MD5 Setting - use your api login id

?>

<form action="cart.php" method="POST">
<?php
     
    $arr = dispCart();
    echo($arr[0]);
    $total = $arr[1];
    echo ("<br/>Final Price = $total");

?>
<br/><br/>
<button type="submit" name="click" value="empty">Empty Cart</button>
</form>

<?php
        
//this assumes that the function you are calling to create 
//the form is returning a string called $string and
//$totalCost is the total amount of your cart.

$string = AuthorizeNetDPM::getCreditCardForm($total, $fp_sequence, $url, $api_login_id, $transaction_key);

//Then in cart.php process requests replacing my function names with yours:

if ($_SERVER['REQUEST_METHOD'] == "POST" && 
	isset($_POST['empty'])) {
		P2_Utils::emptyFile();
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$string .= "<div>".P2_Utils::project2_process_authorize()."</div>";
} else if ($_SERVER['REQUEST_METHOD'] && 
		isset($_GET['response_code']) ) {
	$string2= "<div>".P2_Utils::project2_process_authorize_response()."</div>";
}

echo($string);
if(isset($string2)){
	echo(displayAddMsg($string2));
}
?>

<?php
	if(isset($_POST['click'])){
		P2_Utils::emptyFile();
	}
?>




<?php
 
	include('footer.inc.php');
?>