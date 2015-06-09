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

namespace Phool\Debug;

class Counter
{

//---------

private $nb=0;
private $time=0.0;
private $start_time;

//---------

public function __construct()
{
$this->reset();
}

//---------

public function reset()
{
$this->nb=0;
$this->time=0.0;
}

//---------

public function start()
{
$this->nb++;
$this->start_time=microtime(true);
}

//---------

public function stop()
{
$this->time+=(microtime(true)-$this->start_time);
}

//---------

public function display()
{
echo '>>> Count: '.$this->nb.' ; Time: '.$this->time."\n";
}

//---------

public function stopAndDisplay()
{
$this->stop();
$this->display();
}

//----------
} // End of class
//=============================================================================
?>
