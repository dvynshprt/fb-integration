<?php
//die("sad");
error_reporting(E_ALL);
ini_set('display_errors',1);
$app_id = '127381704029969';
$app_secret='23bc776401e22083e66a6e5b8ea7fac7';
$my_url= 'http://localhost/fb/index.php';
$code = isset($_REQUEST['code']) ? $_REQUEST['code'] : "";
require './facebook-php-sdk/src/facebook.php';
//die("sad");
$facebook = new Facebook(array(
  'appId'  => '127381704029969',
  'secret' => '23bc776401e22083e66a6e5b8ea7fac7',
  'cookie' => true,
));
$params = array(
  'scope' => 'read_stream, user_likes',
  
);
$user = $facebook->getUser();
//$session = $facebook->getSession();
//var_dump($session);

if ($user) {
  //die($user);
	try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}
// Get User ID

//die("asd");
if(!$user)
{
echo '<a href="'.$facebook->getLoginUrl($params).'">Login</a>';
}
else
{
	echo'you are'.$user;
    	 $token_url = "https://graph.facebook.com/oauth/access_token?"
       . "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url)
       . "&client_secret=" . $app_secret . "&code=" . $code;

     $response = file_get_contents($token_url);
     $params = null;
     parse_str($response, $params);
     $access_token=$params["access_token"];	
	//echo $access_token;
	//finding likes
	$likes = file_get_contents("https://graph.facebook.com/".$user."/?fields=likes&access_token=".$access_token);
        $ar = json_decode($likes,true);
	print_r($ar);	
}
	?>

