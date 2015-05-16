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

namespace Phool;

abstract class VarContainer
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
if (!$this->val_is_set($vname)) throw new \Exception("$vname: Variable not set");
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