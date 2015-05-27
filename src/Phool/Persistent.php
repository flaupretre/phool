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
//=============================================================================
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
* This abstract class implements an object which can be saved and retrieved
* to/from a file on  disk.
*
* It exposes the {@link load()} and {@link save()} methods.
*
* It also provides a checksum mechanism transparent to the descendant
* class. Everytime an object is read from storage, its checksum is computed
*  and compared to the value that was stored at save() time.
*
* The descendant class must define two methods named serialize and
* unserialize to transmit/retrieve the data to save.
*
* Note: Late static binding would allow to access the descendant class
* properties and get the magic string from the toplevel class at runtime.
* Unfortunately, it is implemented in versions of PHP >= 5.3, which is too
* restrictive. So, we use another way.
*/

//----------------------------------------------------------------------------

abstract class Persistent extends Modifiable
{
// @var string The magic string to write and check

private $magic;

// @var string The last loaded path. Allows to call save() without argument.

private $path=null;

//----------------------------------------------------------------------------
/**
* Return the properties to save as a string
*
* @return string
*/

abstract protected function serialize();

//----------------------------------------------------------------------------
/**
* Restore data from the result of a previous {@link __serialize()} execution
*
* @param mixed $data The data returned by a previous {@link __serialize()}
* execution
*
* @return void
*/

abstract protected function unserialize($data);

//----------------------------------------------------------------------------
/**
* Class constructor
*
* @param string $magic The magic string to use when writing/reading a file
* @param string|null $path A file to load if not null
* @return void
*/

protected function __construct($magic,$path=null)
{
$this->magic=$magic;
parent::__construct();
if (!is_null($path)) $this->load($path);
}

//----------------------------------------------------------------------------
/**
* Records a path
*
* @param string $path
* @return void
*/

public function setPath($path)
{
$this->path=$path;
}

//----------------------------------------------------------------------------
/**
* Restore data from a save()d file
*
* @param string $path Path of the file to load
* @return void
* @throws Exception if file cannot be loaded
*/

public function load($path)
{
if (!file_exists($path)) throw new \Exception("$path: File does not exist");

try
	{
	$buf=file_get_contents($path);
	if ($buf===false) throw new \Exception("$path: Cannot get file contents");
	//-- Check magic
	if (substr($buf,0,strlen($this->magic))!==$this->magic)
		throw new \Exception("Bad magic string");
	//-- Skip magic string
	$buf=substr($buf,strlen($this->magic));
	//-- Unserialize toplevel array
	$a=unserialize($buf);
	if ((!is_array($a))
		||(!array_key_exists('crc',$a))
		||(!array_key_exists('data',$a)))
		throw new \Exception('Invalid format');

	$data=$a['data'];
	if (crc32($data) !== $a['crc'])
		throw new \Exception('Wrong checksum');

	$this->unserialize($data);
	}
catch (\Exception $e)
	{
	throw new \Exception("$path: Cannot load file: ".$e->getMessage());
	}

$this->setPath($path);
}

//----------------------------------------------------------------------------
/**
* Save data to a file on disk
*
* @param string|null $path Path to save or null if same as load()
* @return void
* @throws Exception if write failed or path cannot be determined
*/

public function save($path=null)
{
if (is_null($path))
	{
	if (is_null($this->path))
		throw new \Exception('Save path cannot be determined');
	$path=$this->path;
	}

$value=$this->serialize(); // Call toplevel method
$data=serialize(array(
	'crc' => crc32($value),
	'data' => $value
	));

if (file_put_contents($path,$this->magic.$data)===false)
	throw new \Exception("$path: Cannot write file");

//-- Write is OK. Now we can clear the 'modified' flag

parent::clearModified();
}

//----------------------------------------------------------------------------
/**
* Save object to a file if it was modified since last load() or save()
*
* @param string|null $path Path to save or null if same as load()
* @return void
* @throws Exception if write failed
*/

public function saveIfModified($path=null)
{
if ($this->modified()) $this->save($path);
}

} // End of class
?>