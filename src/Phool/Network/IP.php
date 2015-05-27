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

namespace Phool\Network;

class IP
{

public function network($ip,$mask)
{
self::validate($ip);
self::validate($mask);

$a_ip=self::stringToArray($ip);
$a_mask=self::stringToArray($mask);

$a_res=array();
for ($i=0;$i<4;$i++) $a_res[]=intval($a_ip[$i]) & intval($a_mask[$i]);

return self::arrayToString($a_res);
}

//-----------

public function validate($string)
{
$a=self::stringToArray($string);
for ($i=0;$i<4;$i++)
	{
	$val=$a[$i];
	if ((!is_numeric($val))||($val < 0) || ($val > 255))
		throw new \Exception("$val/$string: Invalid IP address");
	}
return $string;
}

//-----------

public function stringToArray($string)
{
$res=explode('.',$string);
if (count($res)!==4) throw new \Exception("$string: Invalid IP address");
return $res;
}

//-----------

public function arrayToString($a)
{
return implode('.',$a);
}

//-----------
}
?>