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

namespace Phool\Options;

//=============================================================================
/**
* This class manages command line options. It is a wrapper above Getopt
*/

abstract class Base
{
// These properties must be declared in the child class (see 'Dummy' class)

// protected $opt_modifiers; /* Modifier args */
// protected $options;	/* Option values */

abstract protected function processOption($opt,$arg);

//-----------------------

public function options()
{
return $this->options;
}

//-----------------------

public function option($opt)
{
if (!array_key_exists($opt,$this->options))
	throw new \Exception("$opt: Unknown option");
return $this->options[$opt];
}

//-----------------------

public function set($opt,$value)
{
if (!array_key_exists($opt,$this->options))
	throw new \Exception("$opt: Unknown option");
$this->options=$value;
}

//-----------------------

public function parse(&$args)
{
$short_opts='';
$long_opts=array();
foreach($this->opt_modifiers as $mod)
	{
	$short_opts .= $mod['short'];
	$long=$mod['long'];
	if ($mod['value'])
		{
		$short_opts .= ':';
		$long .= '=';
		}
	$long_opts[]=$long;
	}

list($opts,$args2)=Getopt::getopt2($args,$short_opts,$long_opts);
foreach($opts as $opt_val)
	{
	list($opt,$arg)=$opt_val;
	if (strlen($opt)>1) // Convert long option to short
		{
		$opt=substr($opt,2);
		foreach($this->opt_modifiers as $mod)
			{
			if ($mod['long']==$opt)
				{
				$opt=$mod['short'];
				break;
				}
			}
		}
	if (strlen($opt)>1) throw new \Exception("--$opt: Unrecognized option");
	$this->processOption($opt,$arg);
	}

$args=$args2;
}

//-----------------------

public function parseAll(&$args)
{
$res=array();

while(true)
	{
	$this->parse($args);
	if (!count($args)) break;
	$res[]=array_shift($args);
	}
$args=$res;
}

//---------

//============================================================================
} // End of class
?>
