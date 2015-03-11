<?php
require_once( 'anet_php_sdk/AuthorizeNet.php');


class P2_Utils{


static function project2_process_authorize(){
   $url = "http://people.rit.edu/axg4202/739/project2/cart.php";
   $api_login_id = '3WhN7e5Bf'; // your api login
   $md5_setting = '3WhN7e5Bf'; // Your MD5 Setting - use your api login id

   $response = new AuthorizeNetSIM($api_login_id, $md5_setting);
if ($response->isAuthorizeNet()) {
   if ($response->approved) {
      // Do your processing here.
      $redirect_url = $url . 
		'?response_code=1&transaction_id=' .
	 	$response->transaction_id; 
   } else {
       // Redirect to error page.
       $redirect_url = $url . 
		'?response_code='.$response->response_code .
		 '&response_reason_text=' . 
		$response->response_reason_text;
    }
   	// Send the Javascript back to AuthorizeNet, which
	// will redirect user back to your site.
     return AuthorizeNetDPM::getRelayResponseSnippet($redirect_url);
} else {
    return "Error -- not AuthorizeNet. Check your MD5 Setting.";
}

}
//Then the project2_process_authorize_response():

static function project2_process_authorize_response(){
     if ($_GET['response_code'] == 1) {
           //empty cart on success
            P2_Utils::emptyFile();
           return "<br /><span class='good'>Thank you for your purchase! Transaction id: " . htmlentities($_GET['transaction_id'])."</span><br />";
     } else {
              return "<br /><span class='error'>Sorry, an error occurred: " . htmlentities($_GET['response_reason_text'])."</span></br >";
     }
}

/** clear the cart.xml file */
static function emptyFile(){
       $dom = new DomDocument();
       $dom->load('cart.xml');
       
       $domList = $dom->getElementsByTagName('products')->item(0);
       
       $dom->removeChild($domList);
       
       $pro = $dom->createElement('products');
       $pro=$dom->appendChild($pro);
       
       $dom->save('cart.xml');
}


static function getStatusCode($url) {
     			$ch = curl_init($url); 
				curl_setopt($ch, CURLOPT_NOBODY, true); 
				curl_exec($ch); 
				$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
				curl_close($ch); 
				//$status_code contains the HTTP status: 200, 404, etc. 
			return $status_code;		
		} 


}
?>