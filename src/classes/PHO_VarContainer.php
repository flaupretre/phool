<?php

abstract class PHO_VarContainer
{

protected $vars=array();

//------------------

public static function bool_val($val)
{
return ($val ? 'Y' : '');
}

//------------------

public function val_is_set($vname)
{
return array_key_exists($vname,$this->vars);
}

//------------------

public function val_is_true($vname)
{
return ($this->val_is_set($vname) ? ($this->val($vname) != '') : false);
}

//------------------

public function __get($vname)
{
return $this->val($vname);
}

//------------------
// Difference with __get() method. This one allows to retrieve any variable name, even containing characters forbidden
// in variable names (like '/').

public function val($vname)
{
if (!$this->val_is_set($vname)) throw new Exception("$vname: Variable not set");
return $this->vars[$vname];
}

//------------------

public function val_array()
{
return $this->vars;
}

//------------------

public function setval($name,$value)
{
$this->vars[$name]=trim($value);
}

//------------------
}
?>