<?php
/**
 * szavazasok böngésző képernyő
 * bemenet:
 * $this->Items
 *      ->Akciok      [name=>link,...]
 *      ->Kepviselo   [kepviselojeLink=>link, kepviselojeloltLink=>link,.....]
 *      ->altKepviselo
 *      ->temakor  
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
<h3>'.$this->Temakor->megnevezes.'
  <a href="javascript:infoClick()" class="akcioIkon btnInfo" title="Infó">&nbsp;</a>';
  if ($this->Akciok['temakoredit'] != '') {  
      echo '<a href="'.$this->Akciok['temakoredit'].'" class="akcioIkon beallitasokGomb" title="'.JText::_('TEMAKORBEALLITASOK').'">&nbsp;</a>
      ';
  }
  if ($this->Temakor->allapot == 1) echo '('.JText::_('CLOSED').')';
echo '  
</h3>
<div id="temakorInfo" style="display:none;">
  <p style="text-align:right">
    <button type="button" onclick="infoClose()"><b>X</b></button>
  </p>
  '.$this->Temakor->leiras.'
</div>
<h2>'.$this->Title.'</h2></div>
<div class="kepviselo">
';
      if ($this->AltKepviselo['kepviselojeLink'] != '') {
        echo '<a class="btnKepviselo" href="'.$this->AltKepviselo['kepviselojeLink'].'">
             '.$this->AltKepviselo['image'].'
             <br />'.$this->AltKepviselo['nev'].'
             <br />'.JText::_('GLOBALISKEPVISELO').'
             </a>
             ';
      }       
      if ($this->Kepviselo['kepviselojeLink'] != '') {
        echo '<a class="btnKepviselo" href="'.$this->Kepviselo['kepviselojeLink'].'">
             '.$this->Kepviselo['image'].'
             <br />'.$this->Kepviselo['nev'].'
             <br />'.JText::_('TEMAKORKEPVISELO').'
             </a>
             ';
      } else if ($this->Kepviselo['kepviseloJeloltLink'] != '') {
        echo '<a class="akcioGomb btnJelolt" href="'.$this->Kepviselo['kepviseloJeloltLink'].'">
              '.JText::_('TEMAKORKEPVISELOJELOLT').'
              </a>
             ';
      } else if ($this->Kepviselo['kepviselotValasztLink'] != '') {
        echo '<a class="akcioGomb btnKepviselotValaszt" href="'.$this->Kepviselo['kepviselotValasztLink'].'">
             '.JText::_('TEMAKORKEPVISELOTVALASZT').'
              </a>
              <a class="akcioGomb btnUjJelolt" href="'.$this->Kepviselo['ujJeloltLink'].'">
             '.JText::_('UJTEMAKORKEPVISELOJELOLT').'
             </a>
             ';
      };
echo '
</div>
<div class="clr"></div>
<div class="akciogombok">
';
    if ($this->Akciok['ujSzavazas'] != '') {
      echo '<a href="'.$this->Akciok['ujSzavazas'].'" class="akcioGomb ujGomb">'.JText::_('UJSZAVAZAS').'</a>
      ';
    }  
    echo '<a href="'.$this->Akciok['tagok'].'" class="akcioGomb tagokGomb">'.JText::_('TEMAKORTAGOK').'</a>
          <a href="'.$this->backLink.' "class="akcioGomb btnBack">'.JText::_('TEMAKOROK').'</a>
          <a href="'.$this->Akciok['sugo'].'" class="akcioGomb btnHelp modal" 
          rel="{handler: '."'iframe'".', size: {x: 800, y: 600}}">'.JText::_('SUGO').'</a>
    ';      
    
// filterStr = keresendő_str|activeFlag szétbontása
$w = explode('|',urldecode(JRequest::getVar('filterStr','')));
if ($w[1]==1) $filterAktiv = 'checked="checked"';
echo '
</div>

<div class="szuroKepernyo">
  <form action="'.$this->doFilterLink.'&task=dofilter" method="post">
    <div class="szurourlap">
      '.JText::_('SZURES').'
      <input type="text" name="filterKeresendo" size="40" value="'.$w[0].'" />
      <input type="checkbox" name="filterAktiv" value="1" '.$filterAktiv.'" />
      <input type="hidden" name="filterStr" value="'.JRequest::getVar('filterStr','').'" />
      '.JText::_('CSAKAKTIVAK').'
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
  		'.JText::_('SZAVAZASMEGNEVEZES').'
      </a>  
    </th>
    <th colspan="4">'.JText::_('SZAVAZASALLAPOT').'</th>
    <th rowspan="2" class="'.thClass(6).'">
      <a href="'.$this->reorderLink.'&order=6">
  		'.JText::_('SZAVAZAS_VEGE').' 
      </a>  
    </th>
    <th rowspan="2" class="'.thClass(7).'">
      <a href="'.$this->reorderLink.'&order=7">
  		'.JText::_('TITKOSSAG').' 
      </a>  
    </th>
    
  </tr>
  <tr>
    <th class="'.thClass(2).'">
      <a href="'.$this->reorderLink.'&order=2">
  		'.JText::_('SZAVAZASVITA1').' 
      </a>  
    </th>
    <th class="'.thClass(3).'">
      <a href="'.$this->reorderLink.'&order=3">
  		'.JText::_('SZAVAZASVITA2').' 
    </th>
    <th class="'.thClass(4).'">
      <a href="'.$this->reorderLink.'&order=4">
  		'.JText::_('SZAVAZAS').' 
      </a>  
    </th>
    <th class="'.thClass(5).'">
      <a href="'.$this->reorderLink.'&order=5">
  		'.JText::_('LEZART').' 
      </a>  
    </th>
    
  </tr>
  </thead>
  <tbody>
  ';
  $rowClass = 'row0';
  foreach ($this->Items as $item) { 
        $link = $this->itemLink.'&szavazas='. $item->id;
        if ($item->vita == '') $item->vita = '0';				
        if ($item->szavazas == '') $item->szavazas = '0';				
        if ($item->lezart == '') $item->lezart = '0';
        if ($item->titkos==0) $item->titkos = JText::_('NYILT');
        if ($item->titkos==1) $item->titkos = JText::_('TITKOS');
        if ($item->titkos==2) $item->titkos = JText::_('SZIGORUANTITKOS');
        				
     	  echo '<tr class="'.$rowClass.'">
        <td><a href="'.$link.'">'.$item->megnevezes.'</a></td>
        <td align="center">'.$item->vita1.'</td>
        <td align="center">'.$item->vita2.'</td>
        <td align="center">'.$item->szavazas.'</td>
        <td align="center">'.$item->lezart.'</td>
        <td align="center">'.$item->szavazas_vege.'</td>
        <td align="center">'.$item->titkos.'</td>
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
<script type="text/javascript">
  function infoClick() {
    document.getElementById("temakorInfo").style.display="block";
  }
  function infoClose() {
    document.getElementById("temakorInfo").style.display="none";
  }
</script>
';
?>