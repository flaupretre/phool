<?php
//----------------------------------------------------------------------------
/**
* @package Phool
*/
//----------------------------------------------------------------------------
/**
* @package Phool
*/

class PHO_HTTP
{

//---------

public static function get_arg($name)
{
if (!array_key_exists($name,$_GET))
	throw new Exception("$name: GET argument missing");
return trim($_GET[$name]);
}

//---------
// Compute the base URL we were called with

public static function base_url()
{
if (!PHO_Util::env_is_web()) return '';

if (!isset($_SERVER['PATH_INFO'])) return $_SERVER['PHP_SELF'];

$phpself=$_SERVER['PHP_SELF'];
$slen=strlen($phpself);

$pathinfo=$_SERVER['PATH_INFO'];
$ilen=strlen($pathinfo);

// Remove PATH_INFO from PHP_SELF if it is at the end. Don't know
// which config does this, but some servers put it, some don't.

if (($slen > $ilen) && (substr($phpself,$slen-$ilen)==$pathinfo))
	$phpself=substr($phpself,0,$slen-$ilen);

return $phpself;
}

//---------------------------------
// Sends an HTTP 301 redirection

public static function http_301_redirect($path)
{
header('Location: http://'.$_SERVER['HTTP_HOST'].self::http_base_url().$path);
header('HTTP/1.1 301 Moved Permanently');
exit(0);
}

//---------------------------------
// Sends an HTTP 400 failure

public static function http_400_fail($msg='')
{
if ($msg!='') $msg=' - '.$msg;
header("HTTP/1.0 400 Bad Request".$msg);
exit(1);
}

//---------------------------------
// Sends an HTTP 403 failure

public static function http_403_fail($msg='')
{
if ($msg!='') $msg=' - '.$msg;
header("HTTP/1.0 403 Forbidden".$msg);
exit(1);
}

//---------------------------------
// Sends an HTTP 404 failure

public static function http_404_fail($msg='')
{
if ($msg!='') $msg=' - '.$msg;
header("HTTP/1.0 404 Not Found".$msg);
exit(1);
}

//---------------------------------
// Sends a mime header

public static function mime_header($type)
{
header("Content-type: $type");
}

//----------
} // End of class
//=============================================================================
?>
