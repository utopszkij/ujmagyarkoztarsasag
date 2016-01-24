<?php
// szavazás leadása
// be: $this->Item,  $this->Item->alternativak 
function options($count) {
  $result = '';
  for ($i=1; $i <= $count; $i++) {
      $result .= '<option value="'.$i.'">'.$i.'</option>';
  }
  $result .= '<option selected="selected" value="'.(1 + $count).'">&nbsp;?&nbsp;</option>';
  return $result;
}


$user = JFactory::getUser();
if ($user->id == 0) {
   echo '<div class="errorMsg">'.JText::_('NINCSBEJELENZKEZVE').'</div>
   ';
   echo '<center><button type="button" onclick="location='."'$cancelUrl'".'" class="btnCancel">'.JText::_('BACK').'</button></center>';
   return;
}
echo '
<style type="text/css">
  var {display:inline-block; width:580px;}
  #divsza {margin:5px 0px 5px 0px; padding:3px; background:silver;}
  #divsza label {text-align:right; width:120px; }
  li.row0 {background-color:#D0F0D0;}
  li.row1 {background-color:white; }
  label {display:inline-block; width:300px; text-align:right}
  #preftable select {width:100px;}
  #preftable  tr {cursor:pointer}
  #preftable  tr:hover {cursor:pointer; background-color:#E0F0F0}
  #preftable  tr.selected {background-color:#D0D0D0}
  #preftable tr.heading {background:transparent; cursor:default}
  #preftable tr.heading  {background:transparent; cursor:default}
  #preftable tr.heading:hover {background:transparent; cursor:default}
  #CastVote .btnup {background-image:url(components/com_szavazasok/assets/up.png); background-repeat:no-repeat; 
                    width:140px; height:30px; padding:1px 1px 1px 30px;}
  #CastVote .btndown {background-image:url(components/com_szavazasok/assets/down.png); background-repeat:no-repeat; 
                    width:140px; height:30px; padding:1px 1px 1px 30px;}
  #CastVote .btntop {background-image:url(components/com_szavazasok/assets/top.png); background-repeat:no-repeat; 
                    width:140px; height:30px; padding:1px 1px 1px 30px;}
  #CastVote .btnbottom {background-image:url(components/com_szavazasok/assets/bottom.png); background-repeat:no-repeat; 
                    width:140px; height:30px; padding:1px 1px 1px 30px;}
  #CastVote .btneq {width:140px; height:30px; padding:1px 1px 1px 1px;}
</style>
<script src="components/com_szavazasok/assets/vote.js" type="text/javascript"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js" type="text/javascript"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js" type="text/javascript"></script>
';
if (JRequest::getVar('msg') != '') {
  echo '<div class="msg">'.JRequest::getVar('msg').'</div>';
}
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

echo '<h2>'.$this->Szervezet->title.'</h2>
      <h3>'.$this->Item->megnevezes.'</h3>
<div id="divTurelem"></div>
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
echo '<h2>'.JText::_('SZAVAZAS').'</h2>';
echo '<p>'.JText::_('SZAVAZASHELP1').'</p>';
echo '
<div style="float:left; width:50%">
<table cellpadding="5px" cellspacing="0" border="1" id="preftable" width="100%">
<tr class="heading"><th>'.JText::_('ALTERNATIVA').'</th><th>'.JText::_('POZICIO').'</th></tr>
';
if (count($this->Item->alternativak)==0) {
  echo '</table>
  <div class="msg">'.JText::_('NINCSALTERNATIVA').'</div>';
  echo '<center><button type="button" onclick="location='."'$cancelUrl'".'" class="btnCancel">'.JText::_('BACK').'</button></center>';
  return;
}
foreach ($this->Item->alternativak as $res1) {
  echo '<tr onclick="select_row(this, event.shiftKey||event.ctrlKey);">
           <td class="choice">'.$res1->megnevezes.'</td>
           <td><select id="pos'.$res1->id.'" name="pos'.$res1->id.'" onchange="sort_rows()" class="pos">'.options(count($this->Item->alternativak)).'</select>
           </td>
        </tr>
        ';
}
?>
</table>
</div>
<div style="float:right; width:45%">
	    <input type="button" id="move_top" disabled="disabled" value="<?php echo JText::_('FELSO'); ?>"
	    onclick="do_move_top()" class="btntop" /><br />
	    <input type="button" id="move_up" disabled="disabled" value="<?php echo JText::_('FEL'); ?>"
	    onclick="do_move_up()" class="btnup" /><br />
	    <input type="button" id="make_tie" disabled="disabled" value="<?php echo JText::_('EGYENLO'); ?>"
	    onclick="do_make_tie()" class="btneq" /><br />
	    <input type="button" id="move_down" disabled="disabled" value="<?php echo JText::_('LE'); ?>"
	    onclick="do_move_down()" class="btndown" /><br />
	    <input type="button" id="move_bottom" disabled="disabled" value="<?php echo JText::_('ALSO'); ?>"
	    onclick="do_move_bottom()" class="btnbottom" />
	    
	    <div id="jshelp"><br /><?php echo JText::_('SZAVAZASHELP2'); ?></div>
	    <div id="jsnohelp" clss="display:none"><?php echo JText::_('SZAVAZASNINCSJS'); ?></div>
      
 </div>
 <div style="clear:both"></div>   


<?php

echo '<center><button type="button" onclick="okClick();" class="btnOK">'.JText::_('RENDBEN').'</button>';
echo '  <button type="button" onclick="location='."'$cancelUrl'".'" class="btnCancel">'.JText::_('MEGSEM').'</button></center>';
echo '</form>
<p>'.JText::_('SZAVAZASHELP3').'</p>';
echo '<script type="text/javascript">';
?>
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
    if (jo) {
       document.getElementById("divTurelem").style.display="block";
       document.forms.CastVote.submit();
    } else {
       alert('Nem választott minden jelölthöz poziciót');
    }      
  }
  function infoClick() {
    var url = "<?php echo JURI::base(); ?>index.php?option=com_candidates&view=candidates&task=aspirants&organization=<?php echo JRequest::getVar('organization'); ?>&template=system";
    window.open(url,'','left=100,top=100,width=600,height=600,scrollbars=yes');
  }
  function posChange() {
    var nevek = new Array();
    var idk = new Array();
    var posok = new Array();
    var i = 0;
    var j = 0;
    var k = 0;
    var w = null;
    var w1 = null;
    var w2 = null;
    var liClass = "row0";
    // kigyüjtöm az adatokat a képernyöről
    var w = document.getElementById("ulCandidates");
    if (w) {
      w = w.firstChild;
      while (w) {
        if (w.nodeName=="LI") {
          w1 = w.firstChild;  // var
          nevek.push(w1.firstChild.nodeValue);
          w1 = w1.nextSibling; // select
          idk.push(w1.name)
          posok.push(w1.selectedIndex);
        }
        w = w.nextSibling;
      }
    }
    // rendezem a három tömböt pos szerint
    for (i = nevek.length - 1; i > 0; i--) {
      for (j = 0; j < i; j++) {
        if (posok[j] > posok[j+1]) {
           w = nevek[j];
           w1 = idk[j];
           w2 = posok[j];
           nevek[j] = nevek[j+1];
           idk[j] = idk[j+1];
           posok[j] = posok[j+1];
           nevek[j+1] = w;
           idk[j+1] = w1;
           posok[j+1] = w2; 
        }
      }
    }
    // kialakitom az uj UL bodyt
    w = document.getElementById("ulCandidates");
    i = 0;
    if (w) {
      w = w.firstChild;
      while (w) {
        if (w.nodeName=="LI") {
          w1 = w.firstChild;  // var
          w1.firstChild.nodeValue = nevek[i];
          w1 = w1.nextSibling; // select
          w1.selectedIndex = posok[i];
          w1.name = idk[i];
          w1.id = 'id'+idk[i];
          i++;
        }
        w = w.nextSibling;
      }
   }
  }
  setTimeout('setup();',1000);
<?php
echo '  
</script>
';
?>