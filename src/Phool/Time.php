<?php
//=============================================================================
/**
* @copyright Francois Laupretre <phool@tekwire.net>
* @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, V 2.0
* @category phool
* @package phool
*/
//============================================================================
//----------------------------------------------------------------------------

namespace Phool;

class Time
{

//---------
// Converts a timestamp to a string
// @ to suppress warnings about system timezone

public static function timestring($time=null)
{
if ($time=='unlimited') return $time;
if (is_null($time)) $time=time();
return @strftime('%d-%b-%Y %H:%M %z',$time);
}

//---------

public function compoundString($t='now',$tz)
{
$d=new \DateTime($t,new DateTimeZone($tz));
return $d->format('d-M-Y H:i:s (U)');
}

//---------
// $start=microtime() float

public static function deltaMS($start)
{
$delta=microtime(true)-$start;

return round($delta*1000,2).' ms';
}

//----------
} // End of class
//=============================================================================
?>
