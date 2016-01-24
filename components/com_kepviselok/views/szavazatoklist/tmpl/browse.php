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
<h2>'.$this->Kuser->name.' ('.$this->Kuser->username.')</h2>
<h3>'.Jtext::_('SZAVAZATOK').'</h3></div>
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
<div class="tableKepviselok'.$this->escape($this->params->get('pageclass_sfx')).'">
	<table border="0" width="100%">
  <thead>
  <tr>
    <th class="'.thClass(1).'">
      <a href="'.$this->reorderLink.'&order=1">
  		'.JText::_('TEMAKOR').'
      </a>  
    </th>
    <th class="'.thClass(2).'">
      <a href="'.$this->reorderLink.'&order=2">
  		'.JText::_('SZAVAZAS').'
      </a>  
    </th>
    <th class="'.thClass(3).'">
      <a href="'.$this->reorderLink.'&order=3">
  		'.JText::_('IDOPONT').'
      </a>  
    </th>
    <th colspan="2">'.JText::_('SORREND').'</th>

  </tr>
  </thead>
  <tbody>
  ';
  $rowClass = 'row0';
  $wtemakor = '';
  $wszavazas = '';
  $widopont = '';
  foreach ($this->Items as $i => $item) { 
     	  echo '<tr class="'.$rowClass.'">';
        if ($wtemakor != $item->tmegnevezes)
           echo '<td>'.$item->tmegnevezes.'</td>';
        else
           echo '<td>&nbsp;</td>';
        if ($wszavazas != $item->szmegnevezes)      
          echo '<td>'.$item->szmegnevezes.'</td>';
        else
           echo '<td>&nbsp;</td>';
        if ($widopont != $item->idopont)
          echo '<td>'.$item->idopont.'</td>';
        else
           echo '<td>&nbsp;</td>';
        echo '<td>'.$item->pozicio.'</td>';
        echo '<td>'.$item->amegnevezes.'</td>';
        echo '</tr>
        ';
       if ($rowClass == 'row0') $rowClass='row1'; else $rowClass='row0';
       $wtemakor = $item->tmegnevezes;
       $wszavazas = $item->szmegnevezes;
       $widopont = $item->idopont;
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