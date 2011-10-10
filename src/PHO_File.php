<?php
//----------------------------------------------------------------------------
/**
* @package Phool
*/
//----------------------------------------------------------------------------
/**
* @package Phool
*/

class PHO_File
{

//----

public static function file_suffix($filename)
{
$dotpos=strrpos($filename,'.');
if ($dotpos===false) return '';

return strtolower(substr($filename,$dotpos+1));
}

//---------
// Combines a base directory and a relative path. If the base directory is
// '.', returns the relative part without modification
// Use '/' separator on stream-wrapper URIs

public static function combine_path($dir,$rpath)
{
if ($dir=='.' || $dir=='') return $rpath;
if ($rpath==='' || $rpath==='.') return $dir;
$rpath=trim($rpath,'/');
$rpath=trim($rpath,'\\');

$separ=(strpos($dir,':')!==false) ? '/' : DIRECTORY_SEPARATOR;
if (($dir==='/') || ($dir==='\\')) $separ='';
else
	{
	$c=substr($dir,-1,1);
	if (($c==='/') || ($c=='\\')) $dir=rtrim($dir,$c);
	}

return $dir.$separ.$rpath;
}

//---------

public static function readfile($path)
{
if (($data=@file_get_contents($path))===false)
	throw new Exception($path.': Cannot get file content');
return $data;
}

//---------
// Throws exceptions and removes '.' and '..'

public static function scandir($path)
{
if (($subnames=scandir($path))===false)
	throw new Exception($path.': Cannot read directory');

$a=array();
foreach($subnames as $f)
	if (($f!='.') && ($f!='..')) $a[]=$f;

return $a;
}

//---------------------------------

public static function atomic_write($path,$data)
{
$tmpf=tempnam(dirname($path),'tmp_');

if (file_put_contents($tmpf,$data)!=strlen($data))
	throw new Exception($tmpf.": Cannot write");

// Windows does not support renaming to an existing file (looses atomicity)

if (PHK_Util::is_windows()) @unlink($path);

if (!rename($tmpf,$path))
	{
	unlink($tmpf);
	throw new Exception($path,'Cannot replace file');
	}
}

//---------------------------------
/**
* Computes a string uniquely identifying a given path on this host.
*
* Mount point unicity is based on a combination of device+inode+mtime.
*
* On systems which don't supply a valid inode number (eg Windows), we
* maintain a fake inode table, whose unicity is based on the path filtered
* through realpath(). It is not perfect because I am not sure that realpath
* really returns a unique 'canonical' path, but this is best solution I
* have found so far.
*
* @param string $path The path to be mounted
* @return string the computed mount point
* @throws Exception
*/

private static $simul_inode_array=array();
private static $simul_inode_index=1;

public static function path_unique_id($prefix,$path,&$mtime)
{
if (($s=stat($path))===false) throw new Exception("$path: File not found");

$dev=$s[0];
$inode=$s[1];
$mtime=$s[9];

if ($inode==0) // This system does not support inodes
	{
	$rpath=realpath($path);
	if ($rpath === false) throw new Exception("$path: Cannot compute realpath");

	if (isset(self::$simul_inode_array[$rpath]))
		$inode=self::$simul_inode_array[$rpath];
	else
		{ // Create a new slot
		$inode=self::$simul_inode_index++;	
		self::$simul_inode_array[$rpath]=$inode;
		}
	}

return sprintf('%s_%X_%X_%X',$prefix,$dev,$inode,$mtime);
}

//----------
} // End of class
//=============================================================================
?>
