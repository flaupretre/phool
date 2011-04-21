<?
//----------------------------------------------------------------------------
/**
* Traitement XML d'un document HTML
*
* @package XPage
*/
//----------------------------------------------------------------------------

//error_reporting(E_ERROR | E_CORE_ERROR | E_USER_ERROR);

//----------------------------------------------------------------------------
/**
* Cette classe permet d'analyser une page HTML comme un document XML
*
* @package XPage
*/

class XPage
{

/** @var string Buffer contenant le document XML

public $page;

/** @var DOMDocument La page sous forme d'objet DOMDocument */

private $xdoc=null;

#--------
/** Cree l'objet DOMDocument et importe les donnees HTML
*
* @param string $data Le contenu de la page HTML
*
* @returns void
* @throws DOMException
*/

public function __construct($data)
{
$this->page=$data;
$this->xdoc=new DOMDocument;
if (!@$this->xdoc->loadHTML($data))
	throw new DOMException('Cannot XML-load HTML data');
}

#--------
/**
* Renvoie la liste des noeuds correspondant a un XPath
*
* @param string $xpath La chaine XPath a resoudre
* @param DOMElement|null L'element de depart de la recherche (si null, part du
* noeud root du document).
*
* @returns DOMNodeList (peut etre vide)
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
* Renvoie le premier noeud correspondant a un XPath
*
* @param string $xpath La chaine XPath a resoudre
* @param DOMElement|null L'element de depart de la recherche (si null, part du
* noeud root du document).
*
* @returns DOMNode|null null si aucun noeud ne correspond
*/

public function node($xpath,$base=null)
{
$node_list=$this->nodes($xpath,$base);
return ($node_list->length ? $node_list->item(0) : null);
}

#--------
/**
* Renvoie les valeurs des noeuds correspondant a un XPath (nodeValue)
*
* @param string $xpath La chaine XPath a resoudre
* @param DOMElement|null L'element de depart de la recherche (si null, part du
* noeud root du document).
*
* @returns array Si pas de match, renvoie tableau vide
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
* Renvoie la valeur du premier noeud correspondant a un XPath (nodeValue)
*
* @param string $xpath La chaine XPath a resoudre
* @param DOMElement|null L'element de depart de la recherche (si null, part du
* noeud root du document).
*
* @returns string|false Si pas de match, renvoie false
*/

public function value($xpath,$base=null)
{
$node=$this->node($xpath,$base);

return (($node===null) ? null : $node->nodeValue);
}

#--------
/**
* Renvoie le nombre de noeuds correspondant a un XPath (nodeValue)
*
* @param string $xpath La chaine XPath a resoudre
* @param DOMElement|null L'element de depart de la recherche (si null, part du
* noeud root du document).
*
* @returns int
*/

public function nb($xpath,$base=null)
{
return $this->nodes($xpath,$base)->length;
}

#--------
/**
* Renvoie le texte et la cible d'un lien sous forme
* array('text' => <texte>, 'url' => <cible>)
*
* @param DOMNode $node Noeud de type 'a'
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

//----------
} // End of class XPage
//=============================================================================
?>
