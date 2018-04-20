<?php
require(__DIR__."/vendor/autoload.php");

use Abraham\TwitterOAuth\TwitterOAuth;

$config = json_decode(file_get_contents(__DIR__."/config.json"), true);

$connection = new TwitterOAuth(
	$config["CONSUMER_KEY"],
	$config["CONSUMER_SECRET"],
	$config["ACCESS_TOKEN"],
	$config["ACCESS_TOKEN_SECRET"]
);
$account = $connection->get("account/verify_credentials");

$tweets = $connection->get("statuses/user_timeline", [
	"user_id" => $account->id,
	"max_id" => $config["TRIM_BEFORE_ID"],
	"count" => 100,
	"exclude_replies" => false,
	"include_rts" => false
]);
if( empty($tweets) ){
	echo "No tweets.\n";
	exit;
}

$dryRun = ( isset($argv[1]) && $argv[1] === "n" ) ? true : false;
foreach($tweets as $i){
	deleteTweet($connection, $i, $dryRun);
}

/**
 * @param object $connection
 * @param object $tweet
 * @param boolean $dryRun
 */
function deleteTweet($connection, $tweet, $dryRun){
	if( $dryRun ){
		echo "Will be deleted:\n";
		var_dump([
			"id" => $tweet->id,
			"created_at" => $tweet->created_at,
			"text" => $tweet->text
		]);
		return;
	}
	$result = $connection->post("statuses/destroy", [
		"id" => $tweet->id
	]);
	if( property_exists($result, "id") && $result->id === $tweet->id ){
		echo "[Done] ID: {$tweet->id}\n";
	}else{
		echo "[Failed] The response:\n";
		var_dump($result);
	}
}
