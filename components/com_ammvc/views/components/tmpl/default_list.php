<?php
// $this->Items list
// $this->Title
defined('_JEXEC') or die('Restricted access');
$this->Pagination	= new JPagination($this->Total, 
                                    JRequest::getVar('limitstart',0), 
                                    JRequest::getVar('limit'));
$option = JRequest::getVar('option');
echo '
<script type="text/javascript">
var selectedRow = null;
var id = 0;
function tdClick(event) {
    var tr = false;
    var td = false;
    if (event == -1) {
      event = {target:null};
      var w = document.getElementsByTagName("TD");
      event.target = w[0];
    }
    if (!event) {
      event = window.event;
    }
    var tr = null;
    var td = null;
    if (selectedRow != null) {
        tr = selectedRow;
        if (tr) {
          td = tr.firstChild;
          while (td) {
            td.className = td.className.replace(" selected","");
            td = td.nextSibling;
          }  
        }
    }
    selectedRow = event.target.parentNode;
    tr = selectedRow;
    if (tr) {
          td = tr.firstChild;
          while (td) {
            if (td.className == "col_id") {
              id = td.innerHTML;                              
            }
            td.className = td.className + " selected";
            td = td.nextSibling;
          }
    }
} 
function formActivate() {
  // find first tr
  var firstTr = document.getElementById("tr_0");
  var tr = false;
  var td = false;
  // select first tr
  if (firstTr) {
    selectedRow = firstTr;
    tr = firstTr;
    if (tr) {
          td = tr.firstChild;
          while (td) {
            if (td.className == "col_id") {
              id = td.innerHTML;                              
            }
            td.className = td.className + " selected";
            td = td.nextSibling;
          }
    }
  }
}
function pressbutton(task) {
  link = "'.JURI::base().'index.php"+
    "?option='.$option.'"+
    "&filterStr='.JRequest::getVar('filterStr').'"+
    "&limitstart='.JRequest::getVar('limitstart','0').'"+
    "&limit='.JRequest::getVar('limit','20').'"+
    "&parent='.JRequest::getVar('parent','').'"+
    "&ordering='.JRequest::getVar('ordering','id').'"+
    "&task="+task+
    "&id="+id+
    "&Itemid='.JRequest::getVar('Itemid').'";
  if (task == "delete") {
    if (confirm("'.JText::_(strtoupper($this->viewName).'_SURE_DELETE?').'")) {
      location = link;
    }
  } else {  
    location = link;
  }  
}
function thClick(fieldName) {
  var actOrdering = "'.JRequest::getVar('ordering').'";
  var newOrdering = fieldName;
  if (actOrdering == fieldName) {
     newOrdering = fieldName + " desc";    
  }
  if (actOrdering == fieldName + " desc") {
     newOrdering = fieldName;    
  }
  var link = "'.JURI::base().'index.php"+
    "?option='.$option.'"+
    "&filterStr='.JRequest::getVar('filterStr').'"+
    "&limitstart='.JRequest::getVar('limitstart','0').'"+
    "&limit='.JRequest::getVar('limit','20').'"+
    "&parent='.JRequest::getVar('parent','').'"+
    "&ordering="+newOrdering+
    "&task='.$this->viewName.'.list"+
    "&id="+id+
    "&Itemid='.JRequest::getVar('Itemid').'";
  location = link;
}
setTimeout("formActivate()",1000);
</script>
';

$this->form = &JForm::getInstance($this->viewName,
              JPATH_COMPONENT.DS.'models'.DS.'forms'.DS.$this->viewName.'.xml');
//include_once (JPATH_COMPONENT.'/assets/browser_inc.php');
$class = 'row0';
echo '<link type="text/css" href="components/'.$option.'/assets/'.$this->viewName.'.css" rel="stylesheet" />
';
echo '<h2>'.$this->Title.'</h2>';
echo '<table id="grid" border="1" cellspacing="0" width="100%" class="grid">
<tr class="gridHead">
';
if (count($this->Items)>0) {
  foreach ($this->Items[0] as $fieldName => $fieldValue) {
    $field = $this->form->getField($fieldName);
    if ($fieldName == JRequest::getVar('ordering','id')) {
      $class = ' class="ordering"';
    } else if ($fieldName.' desc' == JRequest::getVar('ordering')) {
      $class = ' class="orderingdesc"';
    } else {
      $class = '';
    }
    echo '<th onclick="parent.thClick('."'".$fieldName."'".')"><label '.$class.'>'.$field->title.'&nbsp;</th>';
  }
} else {
  echo '<th>'.JText::_('ROWS_NOT_FOUND').'</th>';
}
echo '</tr>
';
$i=0;
foreach ($this->Items as $item) {
  echo '<tr class="'.$class.'" id="tr_'.$i.'">
  ';
  foreach ($item as $fieldName => $fieldValue) {
     echo '<td class="col_'.$fieldName.'" onclick="tdClick(event)">'.$fieldValue.'</td>';
  }   
  echo '</tr>
  ';
  if ($class=='row0')
    $class='row1';
  else
    $class='row0';  
  $i++;  
}
echo '</table>
<center>'.$this->Pagination->getListFooter().'</center>
';
?>