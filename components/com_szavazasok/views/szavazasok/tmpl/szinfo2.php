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
echo '<h2>'.$szavazas->megnevezes.'<br /> Leadott szavazatok</h2>
<table border="0">
<tbody>
';
$elozoSzavazo = -1;
foreach ($this->Szavazatok as $szavazat) {
  if ($szavazat->kepviselo_id != $elozoSzavazo) {
    if ($szavazat->darab > 1)
      echo '<tr><td><br/>'.$szavazat->name.'(x'.$szavazat->darab.')</td><td><br />'.$szavazat->pozicio.'</td><td><br />'.$szavazat->alternativa.'</td></tr>
      ';
    else
      echo '<tr><td><br/>'.$szavazat->name.'</td><td><br />'.$szavazat->pozicio.'</td><td><br />'.$szavazat->alternativa.'</td></tr>
      ';
    $elozoSzavazo = $szavazat->kepviselo_id;
  } else {
    echo '<tr><td>&nbsp;</td><td>'.$szavazat->pozicio.'</td><td>'.$szavazat->alternativa.'</td></tr>
    ';
  }
}
echo '</tbody>
</table>
<center>
<button type="button" onclick="location='."'$url'".'" class="akcioGomb btnBack" style="height:34px">Vissza a szavazas adatlaphoz</button>
</center>
';
?>
