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
echo '
<link type="text/css" href="components/'.$option.'/assets/grid.css" rel="stylesheet" />
<div class="alaps">
<h2>'.$this->Title.'</h2>
<form name="adminForm" id="adminForm" method="post" action="'.$url.'">
+<textarea>+-123456abcd</textarea>
<input type="hidden" name="view" value="'.JRequest::getVar('view').'" />
<input type="hidden" name="Itemid" value="'.JRequest::getVar('Itemid').'" />
<input type="hidden" name="task" value="'.$this->viewName.'.save" />
<p class="formButtons">
     <button type="button" class="btnOK" onclick="submitbutton('."'save'".')">'.JText::_('OK').'</button>
     <button type="button" class="btnCancel" onclick="submitbutton('."'".$this->viewName.".cancel'".')">'.JText::_('CANCEL').'</button>
</p>
';
foreach ($this->Item as $fieldName => $fieldValue) {
  echo '<p><label>'.$this->form->getLabel($fieldName).'</label>'.$this->form->getInput($fieldName).'</p>
  <div style="clear:both"></div>
  ';
}
echo JHTML::_( 'form.token' );
echo '</form>
</div>
<script type="text/javascript">
  submitbutton = function(task)  {
      if (task == "'.$this->viewName.'.cancel" || document.formvalidator.isValid(document.id("adminForm"))) {
      document.getElementById("adminForm").task.value = task;
          document.getElementById("adminForm").submit();
      }
  }
</script>
';
?>