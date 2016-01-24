<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
$option = JRequest::getVar('option');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

$this->form = &JForm::getInstance($this->viewName,
           JPATH_COMPONENT.DS.'models'.DS.'forms'.DS.$this->viewName.'.xml');
$this->form->bind($this->Item);
$url = JURI::base().'/index.php?option='.$option;
$fieldName = '';
$fieldValue = '';
echo '
<link type="text/css" href="components/'.$option.'/assets/'.$this->viewName.'.css" rel="stylesheet" />
<div class="alaps">
<form name="adminForm" id="adminForm" method="post" action="'.$url.'">
<input type="hidden" name="view" value="'.JRequest::getVar('view').'" />
<input type="hidden" name="Itemid" value="'.JRequest::getVar('Itemid').'" />
<input type="hidden" name="task" value="'.$this->viewName.'.cancel" />
<p class="formButtons">
     <button type="button" class="btnBack" onclick="submitbutton('."'".$this->viewName.".cancel'".')">'.JText::_(strtoupper($this->viewName).'_BACK_TO_LIST').'</button>
</p>
';
foreach ($this->Item as $fieldName => $fieldValue) {
  echo '<p><label>'.$this->form->getLabel($fieldName).'</label> : '.$this->form->getValue($fieldName).'</p>
  <div style="clear:both"></div>
  ';
}
echo JHtml::_( 'form.token' );
echo '</form>
</div>
<script type="text/javascript">
  submitbutton = function(task)  {
      document.getElementById("adminForm").task.value = task;
  		document.getElementById("adminForm").submit();
  }
</script>
';
?>