<?php
include_once JPATH_COMPONENT.DS.'condorcet.php';

$url = JURI::base().'index.php?option=com_alternativak&vies=alternativaklist&task=browse'.
       '&temakor='.$this->Temakor_id.
       '&szavazas='.$this->Szavazas_id;
$db = JFactory::getDBO();
$db->setQuery('select * from #__temakorok where id="'.$this->Temakor_id.'"');
$organization = $db->loadObject();
$db->setQuery('select * from #__szavazasok where id="'.$this->Szavazas_id.'"');
$poll = $db->loadObject();
if (JRequest::getVar('msg') != '') {
  echo '<div class="msg">'.JRequest::getVar('msg').'</div>';
}
echo '
<div class="organiztaionPath">
    '.$this->organization->megnevezes.'
</div>
';
//+ 2013.11.04 poll candidates.mező kezelése, olyan jelöltek kihagyása 
//  akikre nincs szavazat
echo '<h2>'.$poll->megnevezes.' szavazás eredménye</h2>
';

/*
echo '
<p>Test szavazat felvitel:  egy sor egy szavazó, a sorban az alternativák javasolt sorrendje</p>
<form method="post" action="'.JURI::base().'index.php?option=com_szavazasok&view=szavazasok&task=eredmeny&temakor='.$this->Temakor_id.'&szavazas='.$this->Szavazas_id.'">
  <textarea name="test" rows="10" cols="15"></textarea>
  <button type="submit">OK</button>
</form>
';
*/

$organization = $this->Temakor_id;
$pollid = $this->Szavazas_id;
// lekérdezzük hány szavazat történt az adott szavazásban
$db->setQuery('select count(id) cc from #__szavazok where szavazas_id="'.$pollid.'"');
$res = $db->loadObject();
$voteCount = $res->cc;
// ha még nincs cache tábla akkor létrehozzuk
$db->setQuery('create table if not exists #__poll_value_cache (
  organization integer,
  pollid integer,
  vote_count integer,
  report text
)');
$db->query();
// nézzük van-e cachelt report?
$db->setQuery('select * from #__poll_value_cache where organization="'.$organization.'" and pollid="'.$pollid.'" and vote_count="'.$voteCount.'"');
$res = $db->loadObjectList();
if (count($res) == 0) {
  // ha nincs; most  kell a lideFeldolgozás  (kivéve a szigoruan titkos szavazásokat)
  if ($poll->titkos < 2) {
    $this->temakorokHelper->lideFeldolgozo($this->Temakor_id, $this->Szavazas_id, $this->Temakor_id);
    $this->temakorokHelper->lideFeldolgozo($this->Temakor_id, $this->Szavazas_id, 0);
  }  
  // majd a condordce feldolgozás és az eredményt tároljuk a cahe -ba
  $schulze = new Condorcet($db,$organization,$pollid);
  $report = $schulze->report();
  $db->setQuery('delete from #__poll_value_cache where pollid="'.$pollid.'"');
  $db->query();
  $db->setQuery('insert into #__poll_value_cache values (
  "'.$organization.'","'.$pollid.'","'.$voteCount.'","'.urlencode($report).'"
  )');
  $db->query();
} else {  
  // ha van akkor a cahcelt reportot jelenitjuük meg
  $report = urldecode($res[0]->report); 
}

// részletező infó kiirása
echo '
<div id="eredmenyInfo0" style="text-align:right">
  <span onclick="reszletekClick()" style="cursor:pointer">[ + ]Részletek</span> 
</div>
<div id="eredmenyInfo1" style="display:none">
<p style="text-align:right">
  <span onclick="reszletekClick()" style="cursor:pointer">[ - ]Részletek</span> 
</p>
<h3>Leadott szavazatok összesítése</h3>';
//+ 2013.11.04 poll candidates.mező kezelése
$db->setQuery('select c.megnevezes, v.pozicio, count(v.id) cc 
from #__alternativak c 
left outer join #__szavazatok v on v.alternativa_id = c.id
where c.temakor_id="'.$this->Temakor_id.'" and 
      c.szavazas_id="'.$this->Szavazas_id.'" and 
      v.id is not null 
group by c.megnevezes, v.pozicio
order by 1,2
');
//- 2013.11.04 poll candidates.mező kezelése
$res = $db->loadObjectList();
echo '<table border="0">
';
$w = '';
foreach  ($res as $res1) {
 if ($w != $res1->megnevezes)
   echo '<tr><td>'.$res1->megnevezes.'</td><td>'.$res1->pozicio.'. pozicióba '.$res1->cc.' szavazó javasolta</td></tr>';
 else
   echo '<tr><td>&nbsp;</td><td>'.$res1->pozicio.'. pozicióba '.$res1->cc.' szavazó javasolta</td></tr>';
 $w = $res1->name;  
}
echo '</table>
</div>';

// condorce eredmény tábla kiirása
echo $report;

echo '<center><br />
<button type="button" onclick="location='."'$url'".'" class="akcioGomb btnBack" style="height:34px">Visszaaz a szavazas adatlaphoz</button>
</center>
<script type="text/javascript">
  function reszletekClick() {
    var d0 = document.getElementById("eredmenyInfo0");
    var d1 = document.getElementById("eredmenyInfo1");
    var d2 = document.getElementById("eredmenyInfo2");
    if (d1.style.display=="none") {
      d0.style.display="none";
      d1.style.display="block";
      d2.style.display="block";
    } else {
      d0.style.display="block";
      d1.style.display="none";
      d2.style.display="none";
    }
  }
</script>
';

?>



