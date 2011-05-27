<?php
//----------------------------------------------------------------------------
/**
* @package Phool
*/
//----------------------------------------------------------------------------
/**
* @package Phool
*/

class PHO_Time
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
// $start=microtime() float

public static function delta_ms($start)
{
$delta=microtime(true)-$start;

return round($delta*1000,2).' ms';
}

//----------
} // End of class
//=============================================================================
?>
