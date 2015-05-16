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

//============================================================================
/**
* This abstract class allows to know whether an object has been modified or not
* since it was created or read from persistent storage
*
* Each time a property is modified, the descendant class must call the
* {@link set_modified()} method.
*
* When it is saved, {@link clear_modified()} must be called
* 
* The current state can be retrieved via the {@link modified()} method.
*
* When the instance is created, the state is set to 'not-modified'
*/

abstract class Modifiable
{
/** @var boolean True if the object was modified since creation/load/save */

private $modified_flag=false;

//----------------------------------------------------------------------------
/**
* Class constructor
*
* Ensures that the instance is in 'non-modified' state at creation time
*
* @return void
*/

protected function __construct()
{
$this->clear_modified();
}

//----------------------------------------------------------------------------
/**
* Set the 'modified' state depending on an input toggle
*
* The input toggle allows to pass a boolean return code as argument
*
* @param boolean $toggle If true, set the state, if false, do nothing
* @return void
*/

protected function set_modified($toggle=true)
{
if ($toggle) $this->modified_flag=true;
}

//----------------------------------------------------------------------------
/**
* Set the 'not-modified' state
* Should be called only when the instance is transferred to persistent storage
* @return void
*/

protected function clear_modified()
{
$this->modified_flag=false;
}

//----------------------------------------------------------------------------
/**
* Returns the modified state
*
* @return boolean the current state
*/

public function modified()
{
return $this->modified_flag;
}

//----------------------------------------------------------------------------
} // End of class
?>