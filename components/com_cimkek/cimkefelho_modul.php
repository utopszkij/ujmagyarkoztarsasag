<?php
/**
  * Ez a script JUMI modulként használható fel
  * cimkefelho megjelenitésére
  * position: position-5  css: well page-header
*/
$db = JFactory::getDBO();
$db->setQuery('select cimke, count(szavazas_id) cc
from #__cimke_szavazasok
group by cimke
order by cimke');
$res = $db->loadObjectList();
$maxcc = 0;
foreach ($res as $res1) {
	if ($res1->cc > $maxcc) $maxcc = $res1->cc;
}
$maxcc = $maxcc / 5;
echo '<center>';
foreach ($res as $res1) {
  if ($res1->cc > (4 * $maxcc)) $fs = 20;
  else if ($res1->cc > (3* $maxcc)) $fs = 18;
  else if ($res1->cc > (2 * $maxcc)) $fs = 16;
  else if ($res1->cc > ($maxcc)) $fs = 14;
  else $fs = 12; 
  $link='index.php?option=com_szavazasok&view=szavazasoklist&temakor=-1&filterStr='.urlencode($res1->cimke);
  echo '<a style="font-size:'.$fs.'px" href="'.$link.'">'.$res1->cimke.'</span>&nbsp; ';
}
echo '</center>';
?>