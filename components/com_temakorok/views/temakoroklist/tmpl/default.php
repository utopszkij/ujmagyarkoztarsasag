<?php
/**
 * témakör böngésző képernyő
 * bemenet:
 * $this->Items
 *      ->Akciok      [name=>link,...]
 *      ->Kepviselok  [kepviselojeLink=>link, kepviselojeloltLink=>link,.....]
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


echo '<div class="temakorokList">
<div class="componentheading'.$this->escape($this->params->get('pageclass_sfx')).'">
<h2>'.Jtext::_('TEMAKOROK').'</h2></div>
<div class="kepviselok">
';
      if ($this->Kepviselo['kepviselojeLink'] != '') {
        echo '<div class="altKepviselo">
			 <a class="btnKepviselo" href="'.$this->Kepviselo['kepviselojeLink'].'">
             <div class="avatar">'.$this->Kepviselo['image'].'</div>
             <br />'.$this->Kepviselo['nev'].'
             <br />'.JText::_('GLOBALISKEPVISELO').'
             </a>
			 </div>
             ';
      }
      if ($this->Kepviselo['kepviseloJeloltLink'] != '') {
        echo '<div class="altKepviseloJelolt">
			  <a class="akcioGomb btnJelolt" href="'.$this->Kepviselo['kepviseloJeloltLink'].'">
              '.JText::_('KEPVISELOJELOLT').'
              </a>
			  </div>
             ';
      }
      if ($this->Kepviselo['kepviselotValasztLink'] != '') {
        echo '<div class="altKepviselotValaszt">
			  <a class="akcioGomb btnKepviselotValaszt" href="'.$this->Kepviselo['kepviselotValasztLink'].'">
             '.JText::_('GLOBALISKEPVISELOTVALASZT').'
              </a>
			  </div>
              ';
      }
      if ($this->Kepviselo['ujJeloltLink'] != '') {        
        echo '<div class="altKepviseloJelolt">
              <a class="akcioGomb btnUjJelolt" href="'.$this->Kepviselo['ujJeloltLink'].'">
             '.JText::_('UJGLOBALISKEPVISELOJELOLT').'
             </a>
			 </div>
             ';
      };
echo '
</div>
<div class="akciogombok">
';
    if ($this->Akciok['ujTemakor'] != '') {
      echo '<a href="'.$this->Akciok['ujTemakor'].'" class="akcioGomb ujGomb">'.JText::_('UJTEMAKOR').'</a>
      ';
    }  
    if ($this->Akciok['beallitasok'] != '') {  
      echo '<a href="'.$this->Akciok['beallitasok'].'" class="akcioGomb beallitasokGomb">'.JText::_('BEALLITASOK').'</a>
      ';
    }
    echo '<a href="'.$this->Akciok['tagok'].'" class="akcioGomb tagokGomb">'.JText::_('REGISZTRALTTAGOK').'</a>
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
    <th rowspan="2" class="'.thClass(1).'">
      <a href="'.$this->reorderLink.'&order=1">
  		'.JText::_('TEMAKORMEGNEVEZES').'
      </a>  
    </th>
    <th colspan="3">'.JText::_('TEMAKORSZAVAZASOK').'</th>
  </tr>
  <tr>
    <th class="'.thClass(2).'">
      <a href="'.$this->reorderLink.'&order=2">
  		'.JText::_('TEMAKORVITA').' 
      </a>  
    </th>
    <th class="'.thClass(3).'">
      <a href="'.$this->reorderLink.'&order=3">
  		'.JText::_('TEMAKORSZAVAZAS').' 
    </th>
    <th class="'.thClass(4).'">
      <a href="'.$this->reorderLink.'&order=4">
  		'.JText::_('TEMAKORLEZARTSZAVAZAS').' 
      </a>  
    </th>
  </tr>
  </thead>
  <tbody>
  ';
  $rowClass = 'row0';
  foreach ($this->Items as $i => $item) { 
				//you may want to do this anywhere else					
				$link = $this->itemLink.'&temakor='. $item->id;
        if ($item->vita == '') $item->vita = '0';				
        if ($item->szavazas == '') $item->szavazas = '0';				
        if ($item->lezart == '') $item->lezart = '0';
        if ($item->allapot == 1) $item->megnevezes .= '('.JText::_('CLOSED').')';				
     	  echo '<tr class="'.$rowClass.'">
        <td><a href="'.$link.'">'.$item->megnevezes.'</a></td>
        <td align="right">'.$item->vita.'</td>
        <td align="right">'.$item->szavazas.'</td>
        <td align="right">'.$item->lezart.'</td>
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
</div>
';
include 'components/com_jumi/files/forum.php'; 
?>