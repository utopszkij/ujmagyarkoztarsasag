<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
$option = JRequest::getVar('option');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
$url = JURI::base().'/index.php?option='.$option;
$url2 = JURI::base().'/index.php?option='.$option.'&id='.$this->Item->id;
echo '
<link type="text/css" href="components/'.$option.'/assets/components.css" rel="stylesheet" />
<script language="Javascript" type="text/javascript" src="'.JURI::base().'/components/com_ammvc/assets/edit_area/edit_area_full.js"></script>
<div class="components" style="position:absolute; z-index:99; left:20px; top:20px; width:900px;  background-color:#D0D0F0; padding:5px;">
<h2>'.$this->Title.'</h2>
';
$this->showTabs('controller',0);
echo '
<div class="tabs_body"> 
<form name="adminForm" id="adminForm" method="post" action="'.$url.'">
<input type="hidden" name="view" value="'.JRequest::getVar('view').'" />
<input type="hidden" name="Itemid" value="'.JRequest::getVar('Itemid').'" />
<input type="hidden" name="id" value="'.JRequest::getVar('id').'" />
<input type="hidden" name="task" value="'.$this->viewName.'.save" />
<input type="hidden" name="fileName" value="'.$this->Item->fileName.'" />
<p class="formButtons">
     <button type="button" class="btnCheck" onclick="checkClick()">'.JText::_('CHECK').'</button>
     <button type="button" class="btnOK" onclick="submitbutton('."'components.save'".')">'.JText::_('OK').'</button>
     <button type="button" class="btnCancel" onclick="submitbutton('."'".$this->viewName.".cancel'".')">'.JText::_('CANCEL').'</button>
</p>
<p>
  <textarea name="lines" id="lines" cols="100" rows="20" style="width:100%">'.implode('',$this->Item->lines).'</textarea>
  <iframe name="ifrmCheck" height="150" width="100%"></iframe>
</p>
';
echo JHtml::_( 'form.token' );
$this->showFooter();
echo '</form>
</div>
</div>
<script type="text/javascript">
  submitbutton = function(task)  {
    var s = editAreaLoader.getValue("lines");
    s = s.replace("\<textarea\>","{textarea}");
    s = s.replace("\<\/textarea\>","{/textarea}");
    document.getElementById("adminForm").target = "";
    document.getElementById("adminForm").lines.value = s;
    document.getElementById("adminForm").task.value = task;
 		document.getElementById("adminForm").submit();
  }
  tabClick = function(name) {
  	if (document.formvalidator.isValid(document.id("adminForm"))) {
      var s = editAreaLoader.getValue("lines");
      s = s.replace("\<textarea\>","{textarea}");
      s = s.replace("\<\/textarea\>","{/textarea}");
      document.getElementById("adminForm").target = "";
      document.getElementById("adminForm").lines.value = s;
      document.getElementById("adminForm").task.value = "components.edit"+name;
  		document.getElementById("adminForm").submit();
  	}
  }
  checkClick = function() {
  	if (document.formvalidator.isValid(document.id("adminForm"))) {
      var s = editAreaLoader.getValue("lines");
      s = s.replace("\<textarea\>","{textarea}");
      s = s.replace("\<\/textarea\>","{/textarea}");
      document.getElementById("adminForm").action += "&caller='.JRequest::getVar('task').'&template=system";
      document.getElementById("adminForm").target = "ifrmCheck";
      document.getElementById("adminForm").lines.value = s;
      document.getElementById("adminForm").task.value = "components.phpcheck";
  		document.getElementById("adminForm").submit();
  	}
  }
  formActivate = function() {
		editAreaLoader.init({
			id: "lines"	// id of the textarea to transform		
			,start_highlight: true	// if start with highlight
			,allow_resize: "both"
			,allow_toggle: true
			,word_wrap: true
			,language: "en"
			,syntax: "php"	
		});
  }
  gotoLine = function(line) {
    var s = editAreaLoader.getValue("lines");
    var a = s.split("\n");
    var w = 0;
    var i = 0;
    while ((i < (line - 1)) & (i < a.length)) {
      w = w + a[i].length + 1;
      i++;
    }
    editAreaLoader.setSelectionRange("lines",w,w);
  }
  setTimeout("formActivate()",1000);
</script>
';
?>