<?php
//----------------------------------------------------------------------------
/**
* This class allows to browse an XML or XHTML document
*
* @package XPage
*/
//----------------------------------------------------------------------------

//error_reporting(E_ERROR | E_CORE_ERROR | E_USER_ERROR);

//----------------------------------------------------------------------------
/**
* @package XPage
*/

class PHO_XPage
{

/** @var string Buffer containing the document

public $page;

/** @var DOMDocument The document as a DOMDocument instance */

public $xdoc=null;

#--------
/** Creates the DOM instance and imports the data
*
* @param string $data The content of the page/document
* @param boolean $html Is the format html (or xml) ?
* @returns void
* @throws DOMException
*/

public function __construct($data,$html=true)
{
$this->page=$data;
$this->xdoc=new DOMDocument;

$method=($html ? 'loadHTML' : 'loadXML');
if (!@$this->xdoc->$method($data))
	throw new DOMException('Cannot load data');
}

#--------
/**
* Returns a list of nodes corresponding to an XPath
*
* @param string $xpath The xpath string
* @param DOMElement|null The search base(if null, starts from the root node)
*
* @returns DOMNodeList (can be empty)
*/

public function nodes($xpath,$base=null)
{
$xp=new DOMXPath($this->xdoc);
if (is_null($base)) $base=$this->xdoc->documentElement;
$n=$xp->query($xpath,$base);
unset($xp);
return $n;
}

//------------
/**
* Returns the first node corresponding to an XPath
*
* @param string $xpath The xpath string
* @param DOMElement|null The search base(if null, starts from the root node)
*
* @returns DOMNode|null null if no match
*/

public function node($xpath,$base=null)
{
$node_list=$this->nodes($xpath,$base);
return ($node_list->length ? $node_list->item(0) : null);
}

//------------
/**
* Returns the last node corresponding to an XPath
*
* @param string $xpath The xpath string
* @param DOMElement|null The search base(if null, starts from the root node)
*
* @returns DOMNode|null null if no match
*/

public function last_node($xpath,$base=null)
{
$node_list=$this->nodes($xpath,$base);
return ($node_list->length ? $node_list->item($node_list->length-1) : null);
}

#--------
/**
* Returns the values of the nodes corresponding to an XPath (nodeValue)
*
* @param string $xpath The xpath string
* @param DOMElement|null The search base(if null, starts from the root node)
*
* @returns array empty if no match
*/

public function values($xpath,$base=null)
{
$a=array();
$res=$this->nodes($xpath,$base);
if (!$res->length) return $a;
foreach($res as $node) $a[]=$node->nodeValue;
return $a;
}

#--------
/**
* Returns the value of the first node corresponding to an XPath (nodeValue)
*
* @param string $xpath The xpath string
* @param DOMElement|null The search base(if null, starts from the root node)
*
* @returns string|null null if no match
*/

public function value($xpath,$base=null)
{
$node=$this->node($xpath,$base);

return (($node===null) ? null : $node->nodeValue);
}

#--------
/**
* Returns the number of nodes corresponding to an XPath (nodeValue)
*
* @param string $xpath The xpath string
* @param DOMElement|null The search base(if null, starts from the root node)
*
* @returns int
*/

public function nb($xpath,$base=null)
{
return $this->nodes($xpath,$base)->length;
}

#--------
/**
* Returns the text and target of an hyperlink node as an
* array('text' => <text>, 'url' => <target>)
*
* @param DOMNode $node Node of type 'a'
*
* @returns array(text,url)
*
* @throws Exception
*/

public static function a_info($node)
{
if ((! $node instanceof DOMElement))
	throw new Exception('Arg should be a DOMElement');

if ($node->tagName != 'a')
	throw new Exception('Node should be an anchor ('.$node->tagName.')');

return array('text' => $node->textContent
	,'url' => $node->attributes->getNamedItem('href')->nodeValue);
}

#--------

public function recursive_back_nodes($start_node,$item)
{
$a=array();
$node=$start_node;

while (true)
	{
	$nodes=$this->nodes($item,$node);
	if ($nodes->length)
		{
		for ($i=0;$i<$nodes->length;$i++) $a[]=$nodes->item($i);
		}
	if ($node->isSameNode($this->xdoc)) break; // if root node
	$node=$node->parentNode;
	}
return $a;
}

#--------

public function recursive_back_node($start_node,$item)
{
$nodes=$this->recursive_back_nodes($start_node,$item);
return ((count($nodes)==0) ? null : $nodes[0]);
}

#--------

public function recursive_back_values($start_node,$item)
{
$a=array();
foreach ($this->recursive_back_nodes($start_node,$item) as $node)
	$a[]=$node->nodeValue;
return $a;
}

#--------

public function recursive_back_value($start_node,$item)
{
$node=$this->recursive_back_node($start_node,$item);
return (is_null($node) ? null : $node->nodeValue);
}

//----------
} // End of class XPage
//=============================================================================
?>
