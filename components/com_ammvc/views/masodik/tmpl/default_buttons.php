<?php
$option = JRequest::getVar('option');
$user = JFactory::getUser();
// use $this->helper->accessRight for prepare ! 
$adminBtns  = ' 
<button type="button" onclick="pressbutton('."'add'".')" class="btnAdd">'.JText::_('ADD').'</button>
<button type="button" onclick="pressbutton('."'show'".')" class="btnShow">'.JText::_('SHOW').'</button>
<button type="button" onclick="pressbutton('."'edit'".')" class="btnEdit">'.JText::_('EDIT').'</button>
<button type="button" onclick="pressbutton('."'delete'".')" class="btnDelete">'.JText::_('DELETE').'</button>
';

echo '
<div class="componentheading">
  <table border=0" width="100%">
    <tr><td align="left" valign="center">
         <h2 class="gridTitle">'.$this->Title.'</h2>
        </td>
        <td align="right" valign="center">
         '.$adminBtns.'
        </td>
    </tr>
  </table>      
</div>
';
?>
