<?php
//============================================================================
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU Lesser General Public License (LGPL) as
// published by the Free Software Foundation, either version 3 of the License,
// or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU Lesser General Public License for more details.
//
// You should have received a copy of the GNU Lesser General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.
//============================================================================
/**
* @copyright Francois Laupretre <phool@tekwire.net>
* @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, V 2.0
* @category phool
* @package phool
*/
//============================================================================

namespace Phool\Web;

class HTTP
{

//---------

public static function getArg($name)
{
if (!array_key_exists($name,$_GET))
	throw new \Exception("$name: GET argument missing");
return trim($_GET[$name]);
}

//---------
// Compute the base URL we were called with

public static function baseUrl()
{
if (!\Phool\Util::envIsWeb()) return '';

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

public static function http301Redirect($path)
{
header('Location: http://'.$_SERVER['HTTP_HOST'].self::http_baseUrl().$path);
header('HTTP/1.1 301 Moved Permanently');
exit(0);
}

//---------------------------------
// Sends an HTTP 400 failure

public static function http400Fail($msg='')
{
if ($msg!='') $msg=' - '.$msg;
header("HTTP/1.0 400 Bad Request".$msg);
exit(1);
}

//---------------------------------
// Sends an HTTP 403 failure

public static function http403Fail($msg='')
{
if ($msg!='') $msg=' - '.$msg;
header("HTTP/1.0 403 Forbidden".$msg);
exit(1);
}

//---------------------------------
// Sends an HTTP 404 failure

public static function http404Fail($msg='')
{
if ($msg!='') $msg=' - '.$msg;
header("HTTP/1.0 404 Not Found".$msg);
exit(1);
}

//---------------------------------
// Sends a mime header

public static function mimeHeader($type)
{
header("Content-type: $type");
}

//----------
} // End of class
//=============================================================================
?>
