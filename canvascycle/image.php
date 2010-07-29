<?php

$needFlush = false;
if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && preg_match("/gzip/i", $_SERVER['HTTP_ACCEPT_ENCODING'])) {
	$needFlush = true;
	ob_start( "ob_gzhandler" );
}

$file = 'images/'.preg_replace('/\.\./', '', $_GET['file']).'.LBM.json';
if (!file_exists($file)) die("File does not exist: $file\n");

$ttl = 31536000;
header( 'Content-Type: text/javascript' );
header( 'Cache-Control: max-age=$ttl' );
header( 'Last-Modified: ' . gmdate(DATE_RFC822, filemtime($file)) );
header( 'Expires: ' . gmdate(DATE_RFC822, time() + $ttl) );

print $_GET['callback'] . '(' . file_get_contents($file) . ");\n";

if ($needFlush) {
	ob_end_flush();
}

exit();

?>