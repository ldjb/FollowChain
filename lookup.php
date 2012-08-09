<?php

require_once 'config.php';

if (!isset($_GET['screen_name'])) {
	echo "No user specified.";
	die();
}

$tmhOAuth -> request(
	"GET",
	$tmhOAuth -> url("1/users/show"),
	array("screen_name" => $_GET['screen_name'])
);
	
$result = $tmhOAuth -> response['response'];
	
$decoded = json_decode($result,true);

$results = $tmhOAuth -> response['response'];
$code = $tmhOAuth -> response['code'];

if ($code !== 200) {
	echo "Error: Cannot connect to Twitter API";
	die();
}

$array['screen_name'] = $decoded[screen_name];

$array['profile_image_url'] = str_replace("_normal","_reasonably_small",$decoded[profile_image_url]);

$array['tweet'] = $decoded[status][text];

print_r(json_encode($array));

?>