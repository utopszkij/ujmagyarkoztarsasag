<?php
$url = JURI::base().'index.php?option=com_alternativak&vies=alternativaklist&task=browse'.
       '&temakor='.$this->Temakor_id.
       '&szavazas='.$this->Szavazas_id;
$db = JFactory::getDBO();
$db->setQuery('select * from #__temakorok where id="'.$this->Temakor_id.'"');
$temakor = $db->loadObject();
$db->setQuery('select * from #__szavazasok where id="'.$this->Szavazas_id.'"');
$szavazas = $db->loadObject();
if (JRequest::getVar('msg') != '') {
  echo '<div class="msg">'.JRequest::getVar('msg').'</div>';
}
echo '
<div class="organiztaionPath">
    '.$this->temakor->megnevezes.'
</div>
';
echo '<h2>'.$szavazas->megnevezes.'<br /> saját leadott szavazatom</h2>
<p class="szavazasModja">'.$this->SzavazasModja.'</p>
';
if ($this->Kepviselok != '') {
  echo '<p class="kepviselok">'.$this->Kepviselok.'</p>
  ';
}
if ($this->LeadottSzavazat) {
  echo '<div class="leadottSzavazat">
  '.$this->LeadottSzavazat.'
  </div>
  ';
}

echo '<center>
<button type="button" onclick="location='."'$url'".'" class="akcioGomb btnBack" style="height:34px">Vissza a szavazas adatlaphoz</button>
</center>
';
?>
