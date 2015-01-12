<?php

class PHO_IP
{

public function network($ip,$mask)
{
self::validate($ip);
self::validate($mask);

$a_ip=self::string_to_array($ip);
$a_mask=self::string_to_array($mask);

$a_res=array();
for ($i=0;$i<4;$i++) $a_res[]=intval($a_ip[$i]) & intval($a_mask[$i]);

return self::array_to_string($a_res);
}

//-----------

public function validate($string)
{
$a=self::string_to_array($string);
for ($i=0;$i<4;$i++)
	{
	$val=$a[$i];
	if ((!is_numeric($val))||($val < 0) || ($val > 255))
		throw new Exception("$val/$string: Invalid IP address");
	}
return $string;
}

//-----------

public function string_to_array($string)
{
$res=explode('.',$string);
if (count($res)!==4) throw new Exception("$string: Invalid IP address");
return $res;
}

//-----------

public function array_to_string($a)
{
return implode('.',$a);
}

//-----------
}
?>