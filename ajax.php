<?php

require_once 'config.php';

if (!isset($_GET['screen_name'])) {
	echo "No user specified.";
	die();
}

$tmhOAuth -> request(
	"GET",
	$tmhOAuth -> url("1/friends/ids"),
	array("screen_name" => $_GET['screen_name'])
);

$results = $tmhOAuth -> response['response'];
$code = $tmhOAuth -> response['code'];

if ($code !== 200) {
	echo "Error: Cannot connect to Twitter API";
	die();
}

$decoded = json_decode($results,true);

$flag = false;

while (!$flag) {
	
	$selecteduserid = array_rand($decoded[ids]);
	
	$friendID =  $decoded[ids][$selecteduserid];
	
	$array['id'] = $friendID;
	
	$tmhOAuth -> request(
	"GET",
	$tmhOAuth -> url("1/users/show"),
	array("user_id" => $friendID)
	);
	
	$result = $tmhOAuth -> response['response'];
	
	$decoded = json_decode($result,true);
	
	if (($decoded["protected"] !== true) and ($decoded[friends_count] > 0) and ($decoded[statuses_count] > 0)) {
		$flag = true;
	}

}

$array['screen_name'] = $decoded[screen_name];

$array['profile_image_url'] = str_replace("_normal","_reasonably_small",$decoded[profile_image_url]);

$array['tweet'] = $decoded[status][text];

print_r(json_encode($array));


?>