<?php defined('_JEXEC') or die('Restricted access'); ?>
##codestart##
// no direct access
defined('_JEXEC') or die('Restricted access');
##codeend##
<div class="componentheading##codestart## echo $this->escape($this->params->get('pageclass_sfx')); ##codeend##"><h2>##codestart## echo $this->params->get('page_title');  ##codeend##</h2></div>
<h3>##codestart## echo $this->item->##title##; ##codeend##</h3>
<div class="contentpane">
	<div><h4>Some interesting informations</h4></div>
	##fields##
</div>
