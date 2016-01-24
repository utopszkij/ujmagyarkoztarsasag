<?php
JHTML::_('behavior.modal'); 
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
    '.$organization->megnevezes.'
</div>
';
//+ 2013.11.04 poll candidates.mező kezelése, olyan jelöltek kihagyása 
//  akikre nincs szavazat
if ($poll->szavazas == 1) {
   echo '<h2>'.$poll->megnevezes.'</h2><br /><h3>'.JText::_('RESZEREDMENY').'</h3>
   <p>'.JText::_('RESZEREDMENY_DESC').'</p>
   ';
} else if ($poll->lezart == 1) {
   echo '<h2>'.$poll->megnevezes.'</h2><br /><h3>'.JText::_('VEGEREDMENY').'</h3>
   ';
} else {
  echo '<h2>'.$poll->megnevezes.'</h2><br /><h3>'.JText::_('RESZEREDMENY').'</h3>
        <br /><p>'.JText::_('NINCSSZAVAZAT').'</p>
  ';
  return;
}  

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
    // a li-de feldolgozás csak lezárt szavazás esetében kell
    if ($poll->lezart == 1) {
      $darab = $this->temakorokHelper->lideFeldolgozo($this->Temakor_id, $this->Szavazas_id, $this->Temakor_id);
      $darab = $darab + $this->temakorokHelper->lideFeldolgozo($this->Temakor_id, $this->Szavazas_id, 0);
    } else {
      $darab = 0;
    }
    // ha történt szavazat generálás akkor a többszintü átruházások kezelése érdekében
    // ismételten tovább kell futatni a feldolgozást
    if ($darab > 0) {
      echo '<div>
        '.JText::_('FELDOLGOZAS_TURELMET_KEREK').'
      </div>
      <script type="text/javascript">
        function feldolgozasRefresh() {
          location="'.JURI::base().'index.php?option=com_szavazasok&view=szavazasok&task=eredmeny&szavazas='.$this->Szavazas_id.'&temakor='.$this->Temakor_id.'";
        }
        setTimeout("feldolgozasRefresh()",5000);
      </script>
      ';
      return;
    }
  }  
  // ha már nem történt szavazat generálás akkor a condordce feldolgozás és az eredményt 
  // tároljuk a cahe -ba
  $schulze = new Condorcet($db,$organization,$pollid);
  $report = $schulze->report();
  $db->setQuery('delete from #__poll_value_cache where pollid="'.$pollid.'"');
  $db->query();
  // a kiértékelés eredményét csak lezárt szavazásnál cacheljük
  if ($poll->lezart == 1) {
    $db->setQuery('insert into #__poll_value_cache values (
    "'.$organization.'","'.$pollid.'","'.$voteCount.'","'.urlencode($report).'"
    )');
    $db->query();
  }
} else {  
  // ha van akkor a cahcelt reportot jelenitjuük meg
  $report = urldecode($res[0]->report); 
}

// részletező infó kiirása
echo '
<div id="eredmenyInfo0" style="text-align:right">
  <span onclick="reszletekClick()" style="cursor:pointer">[ + ]'.JText::_('SZAVAZAS_RESZLETEK').'</span> 
</div>
<div id="eredmenyInfo1" style="display:none">
<p style="text-align:right">
  <span onclick="reszletekClick()" style="cursor:pointer">[ - ]'.JText::_('SZAVAZAS_RESZLETEK').'</span> 
</p>
<h3>'.JText::_('LEADOTTSZAVAZATOK').'</h3>';
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
   echo '<tr><td>'.$res1->megnevezes.'</td><td>'.$res1->pozicio.' '.JText::_('POZICOBA').' '.$res1->cc.' '.JText::_('JAVASOLTA').'</td></tr>';
 else
   echo '<tr><td>&nbsp;</td><td>'.$res1->pozicio.' '.JText::_('POZICOBA').' '.$res1->cc.' '.JText::_('JAVASOLTA').'</td></tr>';
 $w = $res1->megnevezes;  
}
echo '</table>
</div>
';
echo '<p><a class="modal" rel="{handler: '."'iframe'".', size: {x: 800, y: 600}}" href="index.php?option=com_content&view=article&id=18:preferencialis-borda-rendszeru-szavazas&catid=8&Itemid=435&template=system">A preferenciális szavazás leírását lásd itt.</a></p>';
// condorce eredmény tábla kiirása
echo $report;

$szinfourl = JURI::base().'index.php?option=com_szavazasok&view=szavazasok&task=szinfo'.
   '&temakor='.$this->Temakor_id.
   '&szavazas='.$this->Szavazas_id;
$szinfourl2 = JURI::base().'index.php?option=com_szavazasok&view=szavazasok&task=szavazatok'.
   '&temakor='.$this->Temakor_id.
   '&szavazas='.$this->Szavazas_id;
echo '<center><br />
';
if ($poll->titkos < 2) {
   echo '<button type="button" onclick="location='."'$szinfourl2'".'" class="akcioGomb btnInfo" style="height:34px">'.JTEXT::_('NYILTSZAVAZATOK').'</button>';
} else {
   echo JText::_('SZIGORUANTITKOS');
}
echo '
<button type="button" onclick="location='."'$szinfourl'".'" class="akcioGomb btnInfo" style="height:34px">'.JText::_('SAJATSZAVAZATOM').'</button>
<button type="button" onclick="location='."'$url'".'" class="akcioGomb btnBack" style="height:34px">'.JText::_('BACK').'</button>
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



