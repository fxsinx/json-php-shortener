<?php

require_once("./config.php");

$u = strtok($_SERVER["REQUEST_URI"],'?');

$json = file_get_contents(JSON_FILE);

$obj = json_decode($json);
$r = $obj->{$u};
if($r == NULL || $r == "") die('{"status":0, "msg":"No record for this short name", "detail":"'.$u.'"}');

header("HTTP/1.1 301 Moved Permanently");
header("Location: ".$r);


?>

<meta http-equiv="refresh" content="0; url=<?php echo $r; ?>" />

