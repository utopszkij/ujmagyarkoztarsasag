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
$session = JFactory::getSession();

echo '<div class="temakorokList">
<div class="componentheading'.$this->escape($this->params->get('pageclass_sfx')).'">
<h2>'.Jtext::_('TEMAKOROK').'</h2>
';
// kezdőlapon nem jelenitem meg a képviselő dobozt és az akció gombokat
$session->set('kepviselo','');
if ((strpos($_SERVER['QUERY_STRING'],'temakorok') > 0) & 
    (strpos($_SERVER['QUERY_STRING'],'886') == 0)) {
	$session->set('akciok',$this->Akciok);
	$session->set('altkepviselo',$this->AltKepviselo);
} else {
	$session->set('akciok','');
	$session->set('altkepviselo','');
}
echo '</div><!-- componentheading -->
<div class="clr"></div>
<center>
<div class="tableTemakorok'.$this->escape($this->params->get('pageclass_sfx')).'">
';
  foreach ($this->Items as $i => $item) { 
		$link = str_replace('szavazasoklist','vita_alt',$this->itemLink.'&task=vita_alt&limit=5&temakor='. $item->id);
        if ($item->szavazas == '') $item->szavazas = '0';				
        if ($item->lezart == '') $item->lezart = '0';
        if ($item->allapot == 1) $item->megnevezes .= '('.JText::_('CLOSED').')';				
     	  echo '<div class="temakorItem temakorItem'.$item->id.'">
          <a href="'.$link.'" class="temakor_'.$item->id.'">
		    <p><img src="'.kepLeirasbol($item->leiras).'" /></p>
		    <p>'.$item->megnevezes.'</p>
		  </a>
		  </div>
       '; 
  } 
echo '
</div><!-- tabkleTemakorok -->
</center>
</div><!-- temakorokList -->
';
?>