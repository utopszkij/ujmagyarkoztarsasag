<?php
/**
* @module		VJ Database Tool
* @copyright	Copyright (C) 2015 vj-tools.com
* @license		GPL
*/
defined('_JEXEC') or die('Direct Access to this location is not allowed.');
error_reporting(E_ERROR);

class HTML_VJDatabaseTool {
	
	function databasetool($option) {
		HTML_VJDatabaseTool::setAdminerToolbar();
		$adminerUrl = JURI::base() . 'components/' . $option . '/adminer.php';
		$cfg = new JConfig();
		$adminerUrl .= '?server=' . $cfg->host . '&username=' . $cfg->user;
		
		?>
		<iframe style="width:100%;height:1000px; border: none;" src="<?php echo $adminerUrl; ?>"></iframe>
		<?php
	}

	function setAdminerToolbar() {
	}	
}

?>