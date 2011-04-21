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
* @copyright Francois Laupretre <francois@tekwire.net>
* @license http://www.gnu.org/licenses GNU Lesser General Public License, V 3.0
*/
//============================================================================

//============================================================================
/**
* Static functions used to display messages (normal, trace, debug...)
*/

class CDisplay
{

/** @var integer Verbose level, default=0 */

private static $verbose_level=0;

//----------------------------------------------------------------------------
/**
* Increment verbose level
*
* @return void
*/

public static function inc_verbose()
{
self::$verbose_level++;
}

//----------------------------------------------------------------------------
/**
* Set verbose level
*
* @param integer $level Positive integer
* @return void
*/

public static function set_verbose($level)
{
self::$verbose_level=$level;
}

//----------------------------------------------------------------------------
/**
* Conditionnally display a string to stderr
*
* Display the string if the message level is less or equal to the verbose level
*
* The string is prefixed with '>' characters (count equal to the level)
*
* @param string $msg The message
* @param integer $level The message level
* @return void
*/

private static function _display($msg,$level)
{
if ($level <= self::$verbose_level)
	{
	fprintf(STDERR,str_repeat('>',$level).($level ? ' ' : '')."$msg\n");
	}
}

//----------------------------------------------------------------------------
/**
* Display an error message
*
* @param string $msg The message
* @return void
*/

public static function error($msg)
{
self::msg("\n***ERROR*** $msg\n");
}

//----------------------------------------------------------------------------
/**
* Display a level 0 message
*
* @param string $msg The message
* @return void
*/

public static function msg($msg)
{
self::_display($msg,0);
}

//----------------------------------------------------------------------------
/**
* Display a level 1 message
*
* @param string $msg The message
* @return void
*/

public static function trace($msg)
{
self::_display($msg,1);
}

//----------------------------------------------------------------------------
/**
* Display a level 2 message
*
* @param string $msg The message
* @return void
*/

public static function debug($msg)
{
self::_display($msg,2);
}

//----------------------------------------------------------------------------
/**
* Convert a boolean to a displayable string
*
* @param bool $val The boolean value to convert
* @return string The string to display
*/

public static function bool_str($val)
{
return ($val ? 'yes' : 'no');
}

//----------------------------------------------------------------------------
/**
* Converts a variable through var_dump()
*
* @param any $var The value to convert
* @return string The dumped value
*/

public static function vdump($var)
{
ob_start();
var_dump($var);
return ob_get_clean();
}

//----------------------------------------------------------------------------
/**
* Display current stack trace
*/

public static function show_trace()
{
$e=new Exception();
print_r($e->getTrace());
}

} // End of class CDisplay
