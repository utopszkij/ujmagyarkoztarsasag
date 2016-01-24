<?php
$option = JRequest::getVar('option');
echo '
<div class="filterForm">
  <form method="get" action="'.JURI::base().'/index.php">
    <input type="hidden" name="option" value="'.$option.'" />
    <input type="hidden" name="ordering" value="'.JRequest::getVar('ordering').'" />
    <input type="hidden" name="view" value="'.JRequest::getVar('view').'" />
    <input type="hidden" name="limitstart" value="0" />
    <input type="hidden" name="limit" value="'.JRequest::getVar('limit').'" />
    <input type="hidden" name="parent" value="'.JRequest::getVar('parent').'" />
    <input type="hidden" name="task" value="'.$this->viewName.'.list" />
    <input type="hidden" name="Itemid" value="'.JRequest::getVar('Itemid','0').'" />
    <p>'.JText::_('FILTER').' <input type="text" name="filterStr" value="'.JRequest::getVar('filterStr').'" />
       <button type="submit">'.JText::_('DO_FILTER').'</button>
  </form>
</div>
';
?>
