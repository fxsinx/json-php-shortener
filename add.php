<?php

require_once("./config.php");

$pass = get_magic_quotes_gpc() ? stripslashes(trim($_REQUEST['pass'])) : trim($_REQUEST['pass']);
if ($pass != PASSCODE)
		die(' {"status":0, "msg":"Invalid passcode", "detail": "'.$pass.'"}');


$url = get_magic_quotes_gpc() ? stripslashes(trim($_REQUEST['url'])) : trim($_REQUEST['url']);
if( empty($url) || !preg_match('|^https?://|', $url))
		die(' {"status":0, "msg":"Invalid URL", "detail": "'.$url.'"}');

$short = get_magic_quotes_gpc() ? stripslashes(trim($_REQUEST['short'])) : trim($_REQUEST['short']);
if( empty($short) || !preg_match('|^(\/[0-9a-zA-Z-]{1,}){1,}$|', $short))
		die(' {"status":0, "msg":"Invalid short name", "detail": "'.$short.'"}');

// check if the response is 404.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch,  CURLOPT_RETURNTRANSFER, TRUE);
$res = curl_exec($ch);
$res_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
if($res_status == '404'){
		die(' {"status":0, "msg":"Not found URL"}');
}

$json = file_get_contents(JSON_FILE);
$obj = json_decode($json);

$flag = false;

// already exists
foreach($obj as $key => $value) {
	if ($value == $url) {
		unset($obj->{$key} );
		$obj->{$short} = $url;
		$flag = true;
	}
}

if (!$flag) {
	$obj->{$short} = $url;
}

// You may want to use json_encode($obj, JSON_PRETTY_PRINT) if you want to stylish your json file.

file_put_contents(JSON_FILE, stripslashes(json_encode($obj)));

?>

{
"status":1,
"msg":"<?php echo $flag?'update':'insert'; ?>",
"url_response":"<?php echo $res_status; ?>",
"short":"<?php echo $short; ?>"
}