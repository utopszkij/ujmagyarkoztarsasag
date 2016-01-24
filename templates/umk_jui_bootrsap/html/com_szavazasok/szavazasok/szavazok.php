<?php
// szavazás leadása
// be: $this->Item,  $this->Item->alternativak 
function options($count) {
  $result = '';
  for ($i=1; $i <= ($count - 1); $i++) {
      $result .= '<option value="'.$i.'">'.$i.'</option>';
  }
  $result .= '<option value="'.$count.'" selected="selected">'.$count.'</option>';
  // $result .= '<option selected="selected" value="'.(1 + $count).'">&nbsp;?&nbsp;</option>';
  return $result;
}

$cancelUrl = $this->Akciok['cancel'];
$user = JFactory::getUser();
$session = JFactory::getSession();
if ($user->id == 0) {
   echo '<div class="errorMsg">'.JText::_('NINCSBEJELENZKEZVE').'</div>
   ';
   echo '<center><button type="button" onclick="location='."'$cancelUrl'".'" class="btnCancel">'.JText::_('BACK').'</button></center>';
   return;
}
if ($this->Item->titkos == 0)
  $nyilt = 'nyilt';
else if ($this->Item->titkos == 1)
  $nyilt = 'titkos';
else if ($this->Item->titkos == 2)
  $nyilt = 'szigoruan titkos';

$db = JFactory::getDBO();
$db->setQuery('select id from #__szavazatok
where szavazas_id="'.$this->szavazas_id.'" and
      user_id="'.$user->id.'"');
$res = $db->loadObjectList();

if (count($res) > 0) {
   echo '<div class="errorMsg">'.JText::_('MARSZAVAZTAL').'</div>
   ';
   echo '<center><button type="button" onclick="location='."'$cancelUrl'".'" class="btnCancel">'.JText::_('BACK').'</button></center>';
   return;
}       

//+ 2015.03.31 Az Igen/nem szavazások másmilyen formon....
if (count($this->Item->alternativak)==2) {
  if ((strtoupper($this->Item->alternativak[0]->megnevezes)=='IGEN') &
      (strtoupper($this->Item->alternativak[1]->megnevezes)=='NEM')) {
        echo '<h2>'.$this->Szervezet->title.'</h2>
              <h3>'.$this->Item->megnevezes.'</h3>
        <div id="divTurelem" style="display:none; background-color:transparent; cursor:default;"></div>
        <p style="text-align:right">
           <a class="akcioGomb btnHelp modal" rel="{handler: '."'iframe'".', size: {x: 800, y: 600}}" href="'.$this->Akciok['sugo'].'">
           '.JText::_('SUGO').'
           </a>
        </p>
        <form method="post" action="'.$this->Akciok['ok'].'" name="CastVote" id="CastVote">
        <input type="hidden" name="task" value="szavazassave" />
        <input type="hidden" name="nick" value="'.$user->username.'" />
        <input type="hidden" name="temakor" value="'.$this->Temakor->id.'" />
        <input type="hidden" name="szavazas" value="'.$this->Item->id.'" />
        ';
        $secret = md5(date('Hsi'.$user->id));
        $session = JFactory::getSession();
        $session->set('szavazas_secret',$secret);
        $cancelUrl = $this->Akciok['cancel'];
        echo '<input type="hidden" name="'.$secret.'" value="1" />
        ';
        echo '<h2>'.$nyilt.' '.JText::_('SZAVAZAS').'</h2>
        <input id="selIgen" name="pos'.$this->Item->alternativak[0]->id.'" type="hidden" value="2" />
        <input id="selNem" name="pos'.$this->Item->alternativak[1]->id.'" type="hidden" value="2" />
        <div style="margin:5px 5px 5px 40px">
        <input type="radio" name="IgenNem" onclick="igenClick()" />Igen<br /><br />
        <input type="radio" name="IgenNem" onclick="nemClick()" />Nem<br /><br />
        <input type="radio" name="IgenNem" onclick="tartClick()" />Tartozkodok a szavazástól<br /><br />
        </div>
        <center>
          <button type="button" onclick="okClick();" class="btnOK">'.JText::_('SZAVAZAT_BEKULDESE').'</button>
          <button type="button" onclick="location='."'$cancelUrl'".'" class="btnCancel">'.JText::_('MEGSEM').'</button>
        </center>
        </form>
        <script type="text/javascript">
          function okClick() {
             document.forms.CastVote.submit();
          }
          function igenClick() {
             document.getElementById("selIgen").value = "1"; 
             document.getElementById("selNem").value = "2"; 
          }
          function nemClick() {
             document.getElementById("selIgen").value = "2"; 
             document.getElementById("selNem").value = "1"; 
          }
          function tartClick() {
             document.getElementById("selIgen").value = "2"; 
             document.getElementById("selNem").value = "2"; 
          }
        </script>
        ';
        return;
      }
}
//- 2015.03.31

if (JRequest::getVar('msg') != '') {
  echo '<div class="msg">'.JRequest::getVar('msg').'</div>';
}

echo '<h2>'.$this->Szervezet->title.'</h2>
      <h3>'.$this->Item->megnevezes.'</h3>
<div id="divTurelem" style="display:none; background-color:transparent; cursor:default;"></div>
<form method="post" action="'.$this->Akciok['ok'].'" name="CastVote" id="CastVote">
<input type="hidden" name="task" value="szavazassave" />
<input type="hidden" name="nick" value="'.$user->username.'" />
<input type="hidden" name="temakor" value="'.$this->Temakor->id.'" />
<input type="hidden" name="szavazas" value="'.$this->Item->id.'" />
';
$secret = md5(date('Hsi'.$user->id));
$session = JFactory::getSession();
$session->set('szavazas_secret',$secret);
$cancelUrl = $this->Akciok['cancel'];
echo '<input type="hidden" name="'.$secret.'" value="1" />
';
echo '<h2>'.$nyilt.' '.JText::_('SZAVAZAS').'</h2>';
echo '<p>Értékelt az alternatívákat! A neked legjobban tetsző lehetőségnél kattints a jobb szélső csillagra,
a legkevésbé tetszőnél (leginkább elutasítottnál) a bal szélső csillagra, kattints a közbenső csillagokra ha
 a megoldást többé-kevésbé elfogadhatónak tartod! Több alternatívának is adhatod ugyanazt az értékelést,
 de ha minden alternatívát egyformán értékelsz akkor szavazatod nem befolyásolja a végeredményt.</p>';
echo '<p><a class="modal" rel="{handler: '."'iframe'".', size: {x: 800, y: 600}}" href="index.php?option=com_content&view=article&id=18:preferencialis-borda-rendszeru-szavazas&catid=8&Itemid=435&template=system">A preferenciális szavazás leírását lásd itt.</a></p>';
echo '
<div id="szavaz-left" style="float:left;">
<table cellpadding="5px" cellspacing="0" border="1" id="preftable" width="100%">
<tr class="heading"><th>'.JText::_('ALTERNATIVA').'</th><th>Értékelés</th></tr>
';
if (count($this->Item->alternativak)==0) {
  echo '</table>
  <div class="msg">'.JText::_('NINCSALTERNATIVA').'</div>';
  echo '<center><button type="button" onclick="location='."'$cancelUrl'".'" class="btnCancel">'.JText::_('BACK').'</button></center>';
  return;
}
$tr_i = 0;
foreach ($this->Item->alternativak as $res1) {
  if ($res1->elbiralasra_var == 0) {	
  echo '<tr id="tr_'.$tr_i.'" ertek="0">
           <td class="choice">'.$res1->megnevezes.'</td>
		   <td>';
			for ($i=0; $i < count($this->Item->alternativak); $i++) {
					echo '<span id="csillag_'.$res1->id.'_'.$i.'" onclick="csillagClick('.$res1->id.','.$i.')" 
					         class="csillag" style="cursor:pointer">*</span>';
			}
			echo ' <input type="hidden" id="pos'.$res1->id.'" name="pos'.$res1->id.'" onchange="sort_rows()" class="pos"  value="0" />
		   </td>
        </tr>
        ';
  $tr_i++;		
  }
}
?>
</table>
</div>
 <div style="clear:both"></div>   

<?php

echo '<center><button type="button" onclick="okClick();" class="btnOK">Szavazat beküldése</button>';
echo '  <button type="button" onclick="location='."'$cancelUrl'".'" class="btnCancel">Mégsem</button></center>';
echo '</form>
';
?>
<script type="text/javascript">
  function csillagClick(alt_id, ertekeles) {
	var imax = <?php echo count($this->Item->alternativak); ?> - 1;
	var i = 0;  
	var j = 0;
	var ertek_1 = 0;
	var ertek_2 = 0;
	var s = "";
	var w = 0;
	// tárolás a hiden meezőbe
    document.getElementById("pos"+alt_id).value = ertekeles + 1;
	// tárolás a atr ertek elmbe
    document.getElementById("pos"+alt_id).parentNode.parentNode.ertek = ertekeles + 1;
	
	// csillag szinezés
	for (i=0; i <= imax; i++) {
		document.getElementById("csillag_"+alt_id+"_"+i).className = "csillag";
	}	
	for (i = 0; i <= ertekeles; i++) {
		document.getElementById("csillag_"+alt_id+"_"+i).className = "csillagSzines";
	}
	// tr sorok rendezése ertek szerint
	for (i = imax; i>=1; i-- ) {
		for (j=0; j<i; j++) {
			ertek_1 = document.getElementById("tr_"+j).ertek;
			ertek_2 = document.getElementById("tr_"+(j+1)).ertek;
			if (ertek_1 == undefined) ertek_1 = 0;
			if (ertek_2 == undefined) ertek_2 = 0;
			if (ertek_2 > ertek_1) {
				s = "";
				s = document.getElementById("tr_"+j).innerHTML;
				w = ertek_1;
				document.getElementById("tr_"+j).innerHTML = 
				  document.getElementById("tr_"+(j+1)).innerHTML;
				document.getElementById("tr_"+j).ertek = ertek_2;
				document.getElementById("tr_"+(j+1)).innerHTML = s;
				document.getElementById("tr_"+(j+1)).ertek = w;
			}
		}
	}
	
  }
  
  function okClick() {
    var jo = true;
    var f = document.forms.CastVote;
    var ctrls = f.elements;
    var i = 0;
    for (i=0; i < ctrls.length; i++) {
      if (ctrls[i].name.substring(0,3)=='pos') {
        if (ctrls[i].selectedIndex == ctrls[i].options.length - 1) jo = false;
      }
    }
    /*
    if (jo) {
       document.getElementById("divTurelem").style.display="block";
       document.forms.CastVote.submit();
    } else {
       alert('Nem választott minden jelölthöz poziciót');
    } 
    */     
    document.getElementById("divTurelem").style.display="block";
    document.forms.CastVote.submit();
  }
  function infoClick() {
    var url = "<?php echo JURI::base(); ?>index.php?option=com_candidates&view=candidates&task=aspirants&organization=<?php echo JRequest::getVar('organization'); ?>&template=system";
    window.open(url,'','left=100,top=100,width=600,height=600,scrollbars=yes');
  }
<?php
echo '  
</script>
';
$akciok = array();
$akciok['sugo'] = $this->Akciok['sugo'];
$session->set('akciok',$akciok);

?>