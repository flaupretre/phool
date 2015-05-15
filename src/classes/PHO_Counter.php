<?php
//----------------------------------------------------------------------------
/**
* @package Phool
*/
//----------------------------------------------------------------------------
/**
* @package Phool
*/

class PHO_Counter
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
