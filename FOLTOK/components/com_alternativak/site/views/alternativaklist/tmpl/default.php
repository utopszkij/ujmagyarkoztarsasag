<?php
/**
 * alternativak böngésző képernyő = szavazazás adatlap
 * bemenet:
 * $this->Items
 *      ->temakor
 *      ->szavazas   
 *      ->Akciok      [name=>link,...]
 *      ->Kepviselo   [kepviselojeLink=>link, kepviselojeloltLink=>link,.....]
 *      ->altKepviselo
 *      ->reorderLink
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

// Témakör kiirása
echo '
<div class="componentheading'.$this->escape($this->params->get('pageclass_sfx')).'">
<h3>'.$this->Temakor->megnevezes.'
  <a href="javascript:infoClick()" title="Info" class="akcioIkon btnInfo">&nbsp;</a>';
  if ($this->Akciok['temakoredit'] != '') {  
      echo '<a title="'.JText::_('TEMAKORBEALLITASOK').'" href="'.$this->Akciok['temakoredit'].'" class="akcioIkon beallitasokGomb">&nbsp;</a>
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
';

// Szavazaás kiirása
echo '
<h3>'.$this->Szavazas->megnevezes.'
  <a href="javascript:szinfoClick()" class="akcioIkon btnInfo" title="Infó">&nbsp;</a>';
  if ($this->Akciok['szavazasedit'] != '') {  
      echo '<a href="'.$this->Akciok['szavazasedit'].'" class="akcioIkon beallitasokGomb" title="'.JText::_('SZAVAZASBEALLITASOK').'">&nbsp;</a>';
  }
  if ($this->Szavazas->vita1 == 1) echo '('.JText::_('ALLAPOT_VITA1').')';
  if ($this->Szavazas->vita2 == 1) echo '('.JText::_('ALLAPOT_VITA2').')';
  if ($this->Szavazas->szavazas == 1) echo '('.JText::_('ALLAPOT_SZAVAZAS').')';
  if ($this->Szavazas->lezart == 1) echo '('.JText::_('ALLAPOT_LEZART').')';
echo '  
</h3>
<div id="szavazasInfo" style="display:none;">
  <p style="text-align:right">
    <button type="button" onclick="szinfoClose()"><b>X</b></button>
  </p>
  '.$this->Szavazas->leiras.'
</div>
';


echo '
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
      };
echo '
</div>
<div class="clr"></div>
<div class="akciogombok">
';
if ($this->Akciok['ujAlternativa'] != '') {
      echo '<a href="'.$this->Akciok['ujAlternativa'].'" class="akcioGomb ujGomb">'.JText::_('UJALTERNATIVA').'</a>
      ';
}  
if ($this->Akciok['szavazok'] != '') {
      echo '<a href="'.$this->Akciok['szavazok'].'" class="akcioGomb btnSzavazok">'.JText::_('SZAVAZOK').'</a>
      ';
}  
if ($this->Akciok['eredmeny'] != '') {
      echo '<a href="'.$this->Akciok['eredmeny'].'" class="akcioGomb btnEredmeny">'.JText::_('EREDMENY').'</a>
      ';
}  

echo '<a href="'.$this->backLink.' "class="akcioGomb btnBack">'.JText::_('SZAVAZASOK').'</a>
      <a href="'.$this->homeLink.'" class="akcioGomb btnBack">'.JText::_('TEMAKOROK').'</a>
      <a href="'.$this->Akciok['sugo'].'" class="akcioGomb btnHelp modal" 
          rel="{handler: '."'iframe'".', size: {x: 800, y: 600}}">'.JText::_('SUGO').'</a>
';      
    
echo '
</div>
<div class="tableKepviselok'.$this->escape($this->params->get('pageclass_sfx')).'">
	<table border="0" width="100%">
  <thead>
  </thead>
  <tbody>
  ';
  $rowClass = 'row0';
  foreach ($this->Items as $item) { 
      if ($this->itemLink != '') {  
        $link = $this->itemLink.'&alternativa='. $item->id;
     	  echo '<tr class="'.$rowClass.'">
        <td> * <a class="alternativaNev" href="'.$link.'">'.$item->megnevezes.'</a>
            <blockquote class="alternativaInfo">'.$item->leiras.'</blockquote>
        </td>
        </tr>
       '; 
     } else {
     	  echo '<tr class="'.$rowClass.'">
        <td> * '.$item->megnevezes.'
            <blockquote class="alternativaInfo">'.$item->leiras.'</blockquote>
        </td>
        </tr>
       '; 
     }  
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
  function szinfoClick() {
    document.getElementById("szavazasInfo").style.display="block";
  }
  function szinfoClose() {
    document.getElementById("szavazasInfo").style.display="none";
  }
</script>
';
?>