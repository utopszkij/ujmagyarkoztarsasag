<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>"><h2><?php echo $this->params->get('page_title');  ?></h2></div>

<div class="contentpane">
	<h3>Some Items, if present</h3>
	<ul>
<?php foreach ($this->items as $i => $item) : 
    $link = (isset($item->slug)) ? $item->link.$item->slug : $item->link;
    ?>
	<li><a href="<?php echo JRoute::_($link) ?>"><?php  echo $item->title ?></a></li>
<?php endforeach; ?>
   </ul>		
</div>
