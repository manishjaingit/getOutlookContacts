<?php
echo '<pre>';
print_r( $_GET );
echo 11111111111111111111111111111111111111111111111111111111111111;
print_r( $_POST );
echo 22222222222222222222222222222222222222222222222222222222222222;
print_r( $_REQUEST );

define("OUTLOOK_CLIENT_ID", "xxxxxxxxxx-xxxxxxxxxx-x-xxx");
define("OUTLOOK_CLIENT_SECRET", "xxxxxxxxxxx=");

$redirect_uri = urlencode('https://441cd908.ngrok.io/test/outlook1com/oauth-hotmail.php');

$code = $_GET['code'];

var_dump($code);

$curl = curl_init();
curl_setopt_array($curl, array(
	CURLOPT_URL => "https://login.microsoftonline.com/common/oauth2/v2.0/token",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_SSL_VERIFYHOST => 0,
	CURLOPT_SSL_VERIFYPEER => 0,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_POSTFIELDS => "client_id=".OUTLOOK_CLIENT_ID."&grant_type=authorization_code&scope=User.Read&20Contacts.Read.Shared%20Contacts.Read&code=".$code."&redirect_uri=".$redirect_uri."&client_secret=".OUTLOOK_CLIENT_SECRET,
	CURLOPT_HTTPHEADER => array(
		"cache-control: no-cache",
		"content-type: application/x-www-form-urlencoded"
	)
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
}
else{
	//accesstoke and boat token
	$resArr = (array) json_decode($response, true);
	print_r($resArr);

	$access_token = $resArr['access_token'];
	$refresh_token = $resArr['refresh_token'];
	$state = $_GET['state'];

	$httpHeader = array(
		"authorization: Bearer $access_token",
		"cache-control: no-cache",
		// "Prefer : outlook.timezone = \"".$deviceTimeZoneFromDB."\""
	);
	//Get user list to get bot user ID
	$curl = curl_init();
	curl_setopt_array($curl, array(
		  // CURLOPT_URL => 'https://outlook.office.com/api/v2.0/me/contacts',
		  // CURLOPT_URL => 'https://outlook.office.com/api/v2.0/me/contacts?$select=EmailAddresses,GivenName,Surname',
		  // CURLOPT_URL => 'https://outlook.office.com/api/v2.0/me',
		  CURLOPT_URL => 'https://graph.microsoft.com/v1.0/me/contacts',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  // CURLOPT_SSL_VERIFYHOST => 0,
		  // CURLOPT_SSL_VERIFYPEER => 0,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => $httpHeader,
		)
	);
	$curlResponse = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	$responseNew = (array) json_decode($curlResponse, true);

	echo "succss here.";
	var_dump($responseNew); die;




}
