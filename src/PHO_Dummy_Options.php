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
//============================================================================

// <PHK:ignore>
require_once(dirname(__FILE__).'/PHO_Options');
require_once(dirname(__FILE__).'/PHO_Display');
// <PHK:end>

//----------------

class PHO_Dummy_Options extends PHO_Options
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

protected function process_option($opt,$arg)
{
switch($opt)
	{
	case 'v':
		PHO_Display::inc_verbose();
		break;

	case 'q':
		PHO_Display::dec_verbose();
		break;

	case 'm':
		$this->$options['dummy_opt']=$arg;
		break;
}

//---------

//============================================================================
} // End of class
?>
