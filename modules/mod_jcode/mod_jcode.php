<?php
/*
* @name jcode 1.0
* Created By Guarneri Iacopo
* http://www.the-html-tool.com/
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
error_reporting(E_ALL);
ini_set("display_errors", 1);

//recupero i valori del modulo
$file=$params->get('file_name', '');
if($file!=""){
	$dir=dirname(__FILE__);
	$dir=str_replace("modules","administrator/components",$dir)."/source/".$file;
	$dir=str_replace("mod_jcode","com_jcode",$dir);
	if(file_exists($dir)){
		include($dir);
	}else{
		echo"not found: ".$dir;
	} 
}
echo '<br /><br /><span style="font-size:10px;">Powered by <a href="http://www.the-html-tool.com/" target="_blank">The Html Tool</a></span>';