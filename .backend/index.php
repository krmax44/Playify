<?php

if (!$_GET["q"] || !$_GET["type"]) {
	include("website.html");
}

$token = json_decode(file_get_contents("token.json"), true);
$ftoken = "";

if(time() - $token["date"] > 3599) {
	$url = 'https://accounts.spotify.com/api/token';
	$method = 'POST';

	$credentials = "your:credentials";

	$headers = array(
			"Accept: */*",
			"Content-Type: application/x-www-form-urlencoded",
			"User-Agent: runscope/0.1",
			"Authorization: Basic " . base64_encode($credentials));
	$data = 'grant_type=client_credentials';

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

	$response = curl_exec($ch);
	$res = json_decode($response, true);
	
	$array = array();
	$array["date"] = time();
	$array["token"] = $res["access_token"];
	
	$handle = fopen("token.json", "w");
	fwrite($handle, json_encode($array));
	fclose($handle);
	$ftoken = $res["access_token"];
}
else {
	$ftoken = $token["token"];
}

include "utils.php";

function validateResponse ($response) {
	if ($response == "" || !isset($response)) {
		include("404.html");
		exit;
	}
	else {
		return json_decode($response, true);
	}
}

function answerResponse ($response) {
	$res = validateResponse($response);
	header("Location: ".getLink($res["name"]." - ".$res["artists"][0]["name"]));
}

switch ($_GET["type"]) {
	case "album":
		$response = file_get_contents("https://api.spotify.com/v1/albums/".$_GET["q"]."?access_token=".$ftoken);
		answerResponse($response);
		break;
	case "artist":
		$response = file_get_contents("https://api.spotify.com/v1/artists/".$_GET["q"]."?access_token=".$ftoken);
		$res = validateResponse($response);
		header("Location: ".getLink($res["name"]));
		break;
	case "track":
		$response = file_get_contents("https://api.spotify.com/v1/tracks/".$_GET["q"]."?access_token=".$ftoken);
		answerResponse($response);
		break;
	case "playlist":
		$response = file_get_contents("https://api.spotify.com/v1/users/".urlencode($_GET["q"])."/playlists/".urlencode($_GET["r"])."/tracks?access_token=".$ftoken);		
		$res = validateResponse($response);
		include("playlist.php");
		break;
}
?>