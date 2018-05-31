<?php

define("OUTLOOK_CLIENT_ID", "xxxxxxxx-xxxxxxxxxxxx-xxxxxxxx");
define("OUTLOOK_CLIENT_SECRET", "xxxxxxxxxxxxx=");

$redirect_uri = urlencode('https://441cd908.ngrok.io/test/outlook1com/oauth-hotmail.php');

$baseUrl = 'https://login.microsoftonline.com/common/oauth2/v2.0/authorize?';
// $state = $_GET['id'];
$state = 1111;
$scope = urlencode('openid profile offline_access User.Read Mail.Read Calendars.Read Contacts.Read');
$request_url = $baseUrl.'state='.$state.'&scope='.$scope.'&response_type=code&approval_prompt=auto&redirect_uri='.$redirect_uri.'&client_id='.OUTLOOK_CLIENT_ID;

?>

<a href="<?php echo $request_url; ?>"> Click to Authorize </a>
?>
