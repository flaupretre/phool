<?php
//=============================================================================
//
// Copyright Francois Laupretre <automap@tekwire.net>
//
//   Licensed under the Apache License, Version 2.0 (the "License");
//   you may not use this file except in compliance with the License.
//   You may obtain a copy of the License at
//
//       http://www.apache.org/licenses/LICENSE-2.0
//
//   Unless required by applicable law or agreed to in writing, software
//   distributed under the License is distributed on an "AS IS" BASIS,
//   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
//   See the License for the specific language governing permissions and
//   limitations under the License.
//
//=============================================================================
/**
* This class is an example of an options parser
*
* @copyright Francois Laupretre <phool@tekwire.net>
* @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, V 2.0
* @category phool
* @package phool
*/
// <Automap>:ignore-file
//============================================================================

class Dummy_Options extends \Phool\Options\Base
{

// Short/long modifier args

protected $opt_modifiers=array(
	array('short' => 'v', 'long' => 'verbose', 'value' => false),
	array('short' => 'q', 'long' => 'quiet'  , 'value' => false),
	array('short' => 'd', 'long' => 'dummy'  , 'value' => true)
	);

// Option values

protected $options=array(
	'dummy_opt' => 'default_value'
	);

//-----------------------
// Option is always provided in short form

protected function processOption($opt,$arg)
{
switch($opt)
	{
	case 'v':
		\Phool\Display::incVerbose();
		break;

	case 'q':
		\Phool\Display::decVerbose();
		break;

	case 'm':
		$this->$options['dummy_opt']=$arg;
		break;
	}
}

//---------

//============================================================================
} // End of class
?>
