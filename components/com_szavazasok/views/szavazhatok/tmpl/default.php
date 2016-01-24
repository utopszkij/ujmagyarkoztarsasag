<?php
/**
 * szavazhatok böngésző képernyő
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
';
// filterStr = keresendő_str|activeFlag szétbontása
$w = explode('|',urldecode(JRequest::getVar('filterStr','')));
if ($w[1]==1) $filterAktiv = 'checked="checked"';
echo '
<center>
  <a href="index.php?option=com_szavazasok&view=vita&task=vita">'.JText::_('VITA').'</a>&nbsp;
  <a href="index.php?option=com_szavazasok&view=szavaztam&task=szavaztam">'.JText::_('SZAVAZTAM').'</a>&nbsp;
</center>
<h2>'.$this->Title.'</h2>
<div class="szuroKepernyo">
  <form action="'.$this->doFilterLink.'&task=dofilter" method="post">
    <div class="szurourlap">
      '.JText::_('SZURES').'
      <input type="text" name="filterKeresendo" size="40" value="'.$w[0].'" />
      <input type="hidden" name="filterAktiv" value="" '.$filterAktiv.'" />
      <input type="hidden" name="filterStr" value="'.JRequest::getVar('filterStr','').'" />
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
  		'.JText::_('SZAVAZASMEGNEVEZES').'
      </a>  
    </th>
    <th>'.JText::_('SZAVAZASALLAPOT').'</th>
    <th class="'.thClass(6).'">
      <a href="'.$this->reorderLink.'&order=6">
  		'.JText::_('SZAVAZAS_VEGE').' 
      </a>  
    </th>
    <th class="'.thClass(7).'">
      <a href="'.$this->reorderLink.'&order=7">
  		'.JText::_('TITKOSSAG').' 
      </a>  
    </th>
    <th class="'.thClass(8).'">
      <a href="'.$this->reorderLink.'&order=8">
  		'.JText::_('SZAVAZTAL').' 
      </a>  
    </th>
  </tr>
  </thead>
  <tbody>
  ';
  $rowClass = 'row0';
  foreach ($this->Items as $item) { 
      if (($item->user_id  == '') | ($item->kepviselo_id > 0))
        $szavaztal = '';
      else
        $szavaztal = '<img src="images/stories/ok.gif" />';
      if ($item->vita1 == 1) $item->vita1 = 'X'; else $item->vita1 = '';    
      if ($item->vita2 == 1) $item->vita2 = 'X'; else $item->vita2 = '';    
      if ($item->szavazas == 1) $item->szavazas = 'X'; else $item->szavazas = '';    
      if ($item->lezart == 1) $item->lezart = 'X'; else $item->lezart = '';    
     	echo '<tr class="'.$rowClass.'">';
		  //+ 2015.12.09 FB nem brtja a hosszú linkeket, kép kezelés 
		  //$link = $this->itemLink.'&temakor='.$item->temakor_id.'&szavazas='. $item->id;
		  $link = str_replace('szavazas',$item->id,$this->itemLink);
		  $kep = '';
		  $allapot = $item->vita1.'/'.$item->vita1.'/'.$item->szavazas.'/'.$item->lezart;
		  if ($item->vita1 == 'X') $allapot = JText::_('SZAVAZASVITA1'); 
		  if ($item->vita2 == 'X') $allapot = JText::_('SZAVAZASVITA2'); 
		  if ($item->szavazas == 'X')	$allapot = JText::_('SZAVAZAS'); 
		  if ($item->lezart == 'X') $allapot = JText::_('LEZART'); 
		  // img tag kiemelése
		  $matches = Array();
		  preg_match('/<img[^>]+>/i', $item->leiras, $matches);
		  if (count($matches) > 0) {
			  $img = $matches[0];
			  // src attributum kiemelése
			  preg_match('/src="[^"]+"/i', $img, $matches);
			  if (count($matches) > 0) {
				$src = $matches[0];
			  } else {
				$src = '';  
			  }	
		  } else {
			  $src = '';	
		  }
		  if ($src != '') {
			  $kep = '<img '.$src.' style="width:80px; float:left; margin:2px;" />';
		  }
		  //- 2015.12.09
	  
	  
	  
      if ($item->titkos==0) $item->titkos = JText::_('NYILT');
      if ($item->titkos==1) $item->titkos = JText::_('TITKOS');
      if ($item->titkos==2) $item->titkos = JText::_('SZIGORUANTITKOS');
     	echo '<td><a href="'.$link.'">'.$kep.$item->megnevezes.'</a></td>
        <td align="center">'.$allapot.'</td>
        <td align="center">'.$item->szavazas_vege.'</td>
        <td align="center">'.$item->titkos.'</td>
        <td align="center">'.$szavaztal.'</td>
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