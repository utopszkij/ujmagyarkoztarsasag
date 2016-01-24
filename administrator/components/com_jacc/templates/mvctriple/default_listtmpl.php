##codestart##
// no direct access
defined('_JEXEC') or die('Restricted access');
##codeend##
<div class="componentheading##codestart## echo $this->escape($this->params->get('pageclass_sfx')); ##codeend##"><h2>##codestart## echo $this->params->get('page_title');  ##codeend##</h2></div>

<div class="contentpane">
	<h3>Some Items, if present</h3>
	<ul>
##codestart## foreach ($this->items as $i => $item) : 
				//you may want to do this anywhere else
##ifdefFieldaliasStart##				
				$item->slug	= $item->alias ? ($item->##primary##.':'.$item->alias) : $item->##primary##;				
				$link = JRoute::_('index.php?view=##name##&id='. $item->slug);							
##ifdefFieldaliasEnd##
##ifnotdefFieldaliasStart##					
				$link = JRoute::_('index.php?view=##name##&id='. $item->##primary##);
##ifnotdefFieldaliasEnd##				
	##codeend##
	<li><a href="##codestart## echo $link ##codeend##">##codestart##  echo $item-><?php echo $this->hident ?> ##codeend##</a></li>
##codestart## endforeach; ##codeend##
</ul>		
</div>