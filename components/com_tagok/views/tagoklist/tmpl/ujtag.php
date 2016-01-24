<?php
/**
 * ujtag felvitel képernyő böngésző képernyő
 * bemenet:
 * $this->Items
 *      ->Akciok      [name=>link,...]
 *      ->reorderLink
 *      ->dofilterLink
 *      ->itemLink
 *      ->Lapozosor
 *  Jrequest:  filterStr             
 */ 
// no direct access
defined('_JEXEC') or die('Restricted access');

// segéd fubction a th order -függő szinezéséhez
function thClass($col) {
  if (JRequest::getVar('order')==$col)
    $result = 'thOrdering';
  else
    $result = 'th';
  return $result;  
}


echo '
<div class="componentheading'.$this->escape($this->params->get('pageclass_sfx')).'">
<h2>'.$this->Temakor->megnevezes.'</h2>
<h2>'.Jtext::_('UJTAG').'</h2></div>
<div class="akciogombok">
';
    if ($this->Akciok['temakor'] != '')
      echo '<a href="'.$this->Akciok['temakor'].'" class="akcioGomb btnBack">'.JText::_('TEMAKOR').'</a>
      ';
    if ($this->Akciok['temakorok'] != '')
      echo '<a href="'.$this->Akciok['temakorok'].'" class="akcioGomb btnBack">'.JText::_('TEMAKOROK').'</a>
      ';
    echo ' <a href="'.$this->Akciok['sugo'].'" class="akcioGomb btnHelp modal" 
         rel="{handler: '."'iframe'".', size: {x: 800, y: 600}}">'.JText::_('SUGO').'</a>
         '; 
echo '
</div>
<p>'.JText::_('UJTAGHELP1').'</p>
<div class="szuroKepernyo">
  <form action="'.$this->doFilterLink.'&task=browse" method="post">
    <div class="szurourlap">
      '.JText::_('SZURES').'
      <input type="text" name="filterStr" size="40" value="'.JRequest::getVar('filterStr').'" />
      <button type="submit" class="btnFilter">'.JText::_('SZURESSTART').'</button>
      <button type="button" class="btnClrFilter" onclick="location='."'".$this->doFilterLink.'&filterStr='."'".'">
        '.JText::_('SZURESSTOP').'
      </button>
    </div>
  </form>
</div>
<div class="tableKepviselok'.$this->escape($this->params->get('pageclass_sfx')).'">
	<table border="0" width="100%">
  <thead>
  <tr>
    <th class="'.thClass(1).'"><a href="'.$this->reorderLink.'&order=1">'.JText::_('ID').'</a></th>
    <th class="'.thClass(2).'"><a href="'.$this->reorderLink.'&order=2">'.JText::_('NEV').'</a></th>
    <th class="'.thClass(3).'"><a href="'.$this->reorderLink.'&order=3">'.JText::_('USERNEV').'</a></th>
  </tr>
  </thead>
  <tbody>
  ';
  $rowClass = 'row0';
  foreach ($this->Items as $i => $item) { 
				//you may want to do this anywhere else					
				if ($this->itemLink != '') {
          $link = $this->itemLink.'&tag='. $item->id;
     	    echo '<tr class="'.$rowClass.'">
          <td align="right">'.$item->id.'</td>
          <td><a href="'.$link.'">'.$item->name.'</a></td>
          <td align="right">'.$item->username.'</td>
          </tr>
         '; 
       } else {
     	    echo '<tr class="'.$rowClass.'">
          <td align="right">'.$item->id.'</td>
          <td>'.$item->name.'</td>
          <td align="right">'.$item->username.'</td>
          </tr>
         '; 
       }  
       if ($rowClass == 'row0') $rowClass='row1'; else $rowClass='row0';
  } 
echo '
</tbody>
</table>		
<div class="lapozosor">
  '.$this->LapozoSor.'
</div>
</div>
';
?>