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

namespace Phool\Debug;

class Counter
{

//---------

public static $nb=0;
public static $time=0.0;
private static $t;

public static function start()
{
self::$t=microtime(true);
}

public static function end()
{
self::$time+=(microtime(true)-self::$t);
self::$nb++;
}

public static function display()
{
echo '>>> Count: '.self::$nb.' ; Time: '.self::$time."\n";
}

//----------
} // End of class
//=============================================================================
?>
