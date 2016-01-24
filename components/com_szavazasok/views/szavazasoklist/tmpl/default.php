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


echo '<div class="szavazasokList">
<div class="componentheading'.$this->escape($this->params->get('pageclass_sfx')).'">
<h3>'.$this->Temakor->megnevezes.'
  <a href="javascript:infoClick()" class="akcioIkon btnInfo" title="Infó" id="iconInfo" style="display:none">&nbsp;</a>';
  if ($this->Akciok['temakoredit'] != '') {  
      echo '<a href="'.$this->Akciok['temakoredit'].'" class="akcioIkon beallitasokGomb" title="'.JText::_('TEMAKORBEALLITASOK').'">&nbsp;</a>
      ';
  }
  if (($this->Akciok['tagJelentkezes'] != '') & ($this->Temakor->id > 0)) {
      echo '<a href="'.$this->Akciok['tagJelentkezes'].'" class="akcioIkon tagJelentkezoGomb" title="'.JText::_('TAGJELENTKEZES').'">&nbsp;</a>
      ';
  }
  if ($this->Temakor->allapot == 1) echo '('.JText::_('CLOSED').')';
  if ($this->Temakor->leiras != '')
		echo '  
		</h3>
		<div id="temakorInfo" style="display:block;">
		  <p style="text-align:right">
			<button type="button" onclick="infoClose()"><b>X</b></button>
		  </p>
		  '.$this->Temakor->leiras.'
		</div>
		</div>
		<div class="kepviselok">
		';
	   if ($this->AltKepviselo['kepviselojeLink'] != '') {
        echo '<div class="altKepviselo">
			 <a class="btnKepviselo" href="'.$this->AltKepviselo['kepviselojeLink'].'">
             <div class="avatar">'.$this->AltKepviselo['image'].'</div>
             <br />'.$this->AltKepviselo['nev'].'
             <br />'.JText::_('GLOBALISKEPVISELO').'
             </a>
			 </div>
             ';
      }       
      if ($this->Kepviselo['kepviselojeLink'] != '') {
        echo '<div class="temaKepviselo">
			 <a class="btnKepviselo" href="'.$this->Kepviselo['kepviselojeLink'].'">
             <div class="avatar">'.$this->Kepviselo['image'].'</div>
             <br />'.$this->Kepviselo['nev'].'
             <br />'.JText::_('TEMAKORKEPVISELO').'
             </a>
			 </div>
             ';
      }
	  if ($this->Kepviselo['kepviseloJeloltLink'] != '') {
        echo '<div class="temaKepviseloJelolt">
			  <a class="akcioGomb btnJelolt" href="'.$this->Kepviselo['kepviseloJeloltLink'].'">
              '.JText::_('TEMAKORKEPVISELOJELOLT').'
              </a>
			 </div>
             ';
      } 
	  if ($this->Kepviselo['kepviselotValasztLink'] != '') {
        echo '<div class="temaKepviselotValaszt">
			  <a class="akcioGomb btnKepviselotValaszt" href="'.$this->Kepviselo['kepviselotValasztLink'].'">
             '.JText::_('TEMAKORKEPVISELOTVALASZT').'
              </a>
			  </div>
			  <div class="temaKepviseloJelolt">
              <a class="akcioGomb btnUjJelolt" href="'.$this->Kepviselo['ujJeloltLink'].'">
             '.JText::_('UJTEMAKORKEPVISELOJELOLT').'
             </a>
			 </div>
             ';
      };
echo '
</div>
<div class="clr"></div>
';

echo '<div class="akciogombok">
';
    
    if ($this->Akciok['ujAltema'] != '') {
      echo '<a href="'.$this->Akciok['ujAltema'].'" class="akcioGomb ujAlTemaGomb">'.JText::_('UJALTEMA').'</a>
      ';
    }  
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
<h2>'.$this->Title.'</h2>
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
    <th class="'.thClass(1).'">
      <a href="'.$this->reorderLink.'&order=1">
  		'.JText::_('ID').'
      </a>  
    </th>
    <th class="'.thClass(2).'">
      <a href="'.$this->reorderLink.'&order=2">
  		'.JText::_('SZAVAZASMEGNEVEZES').'
      </a>  
    </th>
    <th class="thClass(4)">'.JText::_('SZAVAZASALLAPOT').'</th>
    <th class="'.thClass(7).'">
      <a href="'.$this->reorderLink.'&order=7">
  		'.JText::_('SZAVAZAS_VEGE').' 
      </a>  
    </th>
    <th class="'.thClass(8).'">
      <a href="'.$this->reorderLink.'&order=8">
  		'.JText::_('TITKOSSAG').' 
      </a>  
    </th>
    <th>
  		'.JText::_('SZAVAZTAL').' 
    </th>
  </tr>
  </thead>
  <tbody>
  ';

	if (count($this->AlTemak) > 0) {
	  echo '<tr><td colspan="9"><div class="altemak">
	  <ul>
	  ';
	  foreach ($this->AlTemak as $alTema) {
		$alTemaLink = JURI::base().'/index.php?option=com_szavazasok&view=szavazasoklist&temakor='.$alTema->id;
		echo '<li><a href="'.$alTemaLink.'">'.$alTema->megnevezes.' </a></li>
		';
	  }
	  echo '</ul>
	  </div></td></tr>
	  ';
	}
	
  $rowClass = 'row0';
  foreach ($this->Items as $item) { 
      if (($item->user_id  == '') | ($item->kepviselo_id > 0))
        $szavaztal = '';
      else
        $szavaztal = '<img src="images/stories/ok.gif" />';  
     	echo '<tr class="'.$rowClass.'">';
		
      // 2015.12.06 FB nem bitja a hosszú linkeket    $link = $this->itemLink.'&szavazas='. $item->id;
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
	  
      if ($item->vita == '') $item->vita = '0';				
      if ($item->szavazas == '') $item->szavazas = '0';				
      if ($item->lezart == '') $item->lezart = '0';
      if ($item->titkos==0) $item->titkos = JText::_('NYILT');
      if ($item->titkos==1) $item->titkos = JText::_('TITKOS');
      if ($item->titkos==2) $item->titkos = JText::_('SZIGORUANTITKOS');
     	echo '
        <td align="right">'.$item->id.'</td>
        <td><a href="'.$link.'">'.$kep.$item->megnevezes.'</a></td>
        <td align="left">'.$allapot.'</td>
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
</div>
<script type="text/javascript">
  function infoClick() {
    document.getElementById("temakorInfo").style.display="block";
    document.getElementById("iconInfo").style.display="none";
  }
  function infoClose() {
    document.getElementById("temakorInfo").style.display="none";
    document.getElementById("iconInfo").style.display="inline-block";
  }
</script>
';

// kommentek megjelenitése
if ($this->CommentId > 0) {
  echo JComments::show($this->CommentId, 'com_content', $this->Szavazas->megnevezes);
}

include 'components/com_jumi/files/forum.php'; 


?>