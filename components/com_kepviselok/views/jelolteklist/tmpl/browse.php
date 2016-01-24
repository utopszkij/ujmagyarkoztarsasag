<?php
/**
 * témakör böngésző képernyő
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
<h3>'.Jtext::_('KEPVISELOVALASZTAS').'</h3></div>
<div class="akciogombok">
';
    echo '<a href="'.$this->Akciok['back'].'" class="akcioGomb btnBack">'.JText::_('VISSZA').'</a>
         <a href="'.$this->Akciok['sugo'].'" class="akcioGomb btnHelp modal" 
         rel="{handler: '."'iframe'".', size: {x: 800, y: 600}}">'.JText::_('SUGO').'</a>
         '; 
echo '
</div>
<div class="szuroKepernyo">
  <form action="'.$this->doFilterLink.'&task=dofilter" method="post">
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
<div>'.JText::_('JELOLTEKHELP').'</div>
<div class="tableKepviselok'.$this->escape($this->params->get('pageclass_sfx')).'">
	<table border="0" width="100%">
  <thead>
  <tr>
    <th class="'.thClass(1).'">
      <a href="'.$this->reorderLink.'&order=1">
  		'.JText::_('NAME').'
      </a>  
    </th>
    <th class="'.thClass(2).'">
      <a href="'.$this->reorderLink.'&order=2">
  		'.JText::_('USERNAME').'
      </a>  
    </th>
    <th>&nbsp;</th>

  </tr>
  </thead>
  <tbody>
  ';
  $rowClass = 'row0';
  foreach ($this->Items as $i => $item) { 
				//you may want to do this anywhere else					
				$link = $this->itemLink.'&id='. $item->id;
				$link2 = $this->itemLink2.'&id='. $item->id;
     	  echo '<tr class="'.$rowClass.'">
        <td><a href="'.$link.'">'.$item->name.'</a></td>
        <td>'.$item->username.'</td>
        <td><a href="'.$link2.'" class="akcioIkon btnInfo">&nbsp;</a></td>
        </tr>
       '; 
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