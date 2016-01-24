<?php
/**
 * alternativak böngésző képernyő = szavazazás adatlap
 * bemenet:
 * $this->Items
 *      ->temakor
 *      ->Szavazas   
 *      ->Akciok      [name=>link,...]
 *      ->Kepviselo   [kepviselojeLink=>link, kepviselojeloltLink=>link,.....]
 *      ->altKepviselo
 *      ->reorderLink
 *      ->itemLink
 *      ->Lapozosor
 *      ->CommentId  comments megjelenitéshez cikk ID 
 *  Jrequest:  filterStr             
 */ 
//+ 2014.09.10 Az alternativa név csak akkor link ha jogosult módosítani
// no direct access
defined('_JEXEC') or die('Restricted access');
$db = JFactory::getDBO();
$session = JFactory::getSession();
$db->setQuery('select * from #__temakorok where id='.$db->quote($this->Szavazas->temakor_id));
$temakorRec = $db->loadObject();

//UMK specialitás:  rész eredmény nem kérdezhető le
if ($this->Szavazas->lezart != 1) $this->Akciok['eredmeny'] = '';

?>
<div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
	<div class="temakorDoboz">
		<div class="dobozFejlec">
			<a href="<?php echo $this->backLink; ?>">
				<img class="temakorKep" src="<?php echo kepLeirasbol($temakorRec->leiras); ?>" />
				Témakör: <h2><?php echo $temakorRec->megnevezes; ?></h2>
			</a>	
		</div>
		<div class="temakorLeiras"><?php echo utf8Substr($temakorRec->leiras,0,10000); ?></div>
	</div>
</div><!-- componetheading -->
<div class="clr"></div>

<?php
// Szavazaás létrehozó elérésea
//$szuser = JFactory::getUser($this->Szavazas->letrehozo);
// $szuser->load($this->Szavazas->letrehozo);
$db = JFactory::getDBO();
$user = JFactory::getUser();
$db->setQuery('SELECT email,name from #__users WHERE id="'.$this->Szavazas->letrehozo.'"');
$szuser = $db->loadObject();
if ($szuser) 
   $grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $szuser->email )));
else
   $grav_url = '';    
?>
<div class="szavazasfej">
<h3>
  <?php echo $this->Szavazas->megnevezes; ?>
  <?php
	  if ($this->Akciok['szavazasedit'] != '') {  
		  echo '<a href="'.$this->Akciok['szavazasedit'].'" class="editIcon" title="Módosítás">
		    <span>Edit</span>&nbsp;</a>';
	  }
	  //if ($this->Akciok['copy'] != '') {  
	  //	  echo '<a href="'.$this->Akciok['copy'].'" class="copyIcon" title="Másolás">
	  //	    <span>Másolás</span>&nbsp;</a>';
	  //}
  ?>
</h3>  
<?php
  if ($this->Szavazas->vita1 == 1) echo JText::_('ALLAPOT_VITA1');
  if ($this->Szavazas->vita2 == 1) echo JText::_('ALLAPOT_VITA2');
  if ($this->Szavazas->szavazas == 1) echo JText::_('ALLAPOT_SZAVAZAS');
  if ($this->Szavazas->lezart == 1) echo JText::_('ALLAPOT_LEZART');
  if ($this->Szavazo) {
    if (($this->Szavazo->user_id > 0) & ($this->Szavazo->kepviselo_id == 0))
      echo '&nbsp;<var class="szavaztal"><span>Szavaztal</span></var>
      ';
  }
  if ($this->szavaztak > 0) {
    echo '<var class="szavaztak">'.JText::_('EDDIG_SZAVAZTAK').':'.$this->szavaztak.'</var>';
  }
?>
</div><!-- szavazasfej -->

<div id="szavazasInfo" style="display:block;">
	<img src="<?php echo $grav_url; ?>" float:"left" />
	<br /><?php echo $szuser->name; ?>
    <?php echo $this->Szavazas->leiras; ?>
	<p><br /><b>Létrehozva: </var><?php echo str_replace('-','.',$this->Szavazas->letrehozva);?></var>
    <br /><b>Vita vége:</b><var><?php echo str_replace('-','.',$this->Szavazas->vita1_vege); ?></var>
	<?php if ($this->Szavazas->vita2 == 1) : ?>
	<br /><b>Második vita szakasz vége: </b><?php echo str_replace('-','.',$this->Szavazas->vita2_vege); ?></var> 
	<?php endif; ?>
	<?php if ($this->Szavazas->stavazas == 1) : ?>
	<br /><b>Szavazás vége: </b><?php echo str_replace('-','.',$this->Szavazas->szavazas_vege); ?></var>
	<?php endif; ?>
	</p>
</div><!-- szavazasinfo -->

<?php
/*  szavazásra javaslom/nem javaslom
if (($this->Szavazas->vita1==1) & ($user->id > 0)) {
	if ($this->igen == '') $this->igen = 0;
	if ($this->nem == '') $this->nem = 0;
	echo '<div class="szavazas_in">
	   Szavazásra javaslom 
	   &nbsp;&nbsp;<button type="button" onclick="igenClick()" title="Igen">
	   <div class="iconIgen" style="display:inline-block">&nbsp;</div>
	   </button>Igen
	   '.$this->igen.'
	   &nbsp;&nbsp;<button type="button" onclick="nemClick()" title="Nem">
	   <div class="iconNem" style="display:inline-block">&nbsp;</div>
	   </button>Nem
	   '.$this->nem.'
	</div>
	';
} else if (($this->igen > 0) | ($this->nem > 0)) {
	echo '<div class="szavazas_in">
	   Szavazásra javasolták 
	   &nbsp;&nbsp;<div class="iconIgen" style="display:inline-block">&nbsp;</div>Igen
	   '.$this->igen.'
	   &nbsp;&nbsp;<div class="iconNem" style="display:inline-block">&nbsp;</div>Nem
	   '.$this->nem.'
	</div>
	';
}
*/

/*
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
echo '</div>
';	  
*/

?>
  

<div class="clr"></div>
<div class="tableAlternativak">
	<table border="0" width="100%">
  <thead>
    <tr><th>Választható alternatívák</th></tr>
  </thead>
  <tbody>
  <?php $rowClass = 'row0'; ?>
  <?php 
    foreach ($this->Items as $item) { 
	  // publikálandó alternativák csak adminoknak
	  if (($item->elbiralasra_var == 0) | ($this->Akciok['alternativaedit'] != '')) {
		  if ($item->elbiralasra_var == 1)
			  $rowClass = 'publikalandoAlternativa';
		  else
			  $rowClass = 'alternativa';
		  if ($this->itemLink != '') {  
			$link = $this->itemLink.'&alternativa='. $item->id;
			//+ 2014.09.10 Az alternativa név csak akkor link ha jogosult módosítani
			/*
			if ($this->isAdmin | 
				$this->temakor_admin |
				($item->letrehozo == $this->user->id)
			   ) {
			*/       
			echo '<tr class="'.$rowClass.'">
			<td> * '.$item->megnevezes;
			if ($this->Akciok['alternativaedit'] != '')
				echo '<a class="editIcon" href="'.$this->Akciok['alternativaedit'].'&alternativa='.$item->id.'"><span>Edit</span></a>';
			if ($this->Akciok['alternativatorles'] != '')
				echo '<a class="deleteIcon" href="'.$this->Akciok['alternativatorles'].'&alternativa='.$item->id.'"><span>Delete</span></a>';
			echo '<br /><blockquote class="alternativaInfo">'.$item->leiras.'</blockquote>
			</td>
			</tr>
			';
			
		   
		   //- 2014.09.10 Az alternativa név csak akkor link ha jogosult módosítani
		 } else {
			  echo '<tr class="'.$rowClass.'">
			<td> * '.$item->megnevezes;
			if ($this->Akciok['alternativaedit'] != '')
				echo '<a class="editIcon" href="'.$this->Akciok['alternativaedit'].'&alternativa='.$item->id.'"><span>Edit</span></a>';
			if ($this->Akciok['alternativatorles'] != '')
				echo '<a class="deleteIcon" href="'.$this->Akciok['alternativatorles'].'&alternativa='.$item->id.'"><span>Delete</span></a>';
			echo '<blockquote class="alternativaInfo">'.$item->leiras.'</blockquote>
			</td>
			</tr>
		   '; 
		 }
	  } // láthatja
	} // foreach 
  ?> 	
  <?php if ($this->Akciok['ujAlternativa'] != '') : ?>
		<tr class="ujAlternativa">
		  <td><a href="<?php echo $this->Akciok['ujAlternativa']; ?>" class="akcioGomb ujGomb">
		        Új alternatívát javaslok
			  </a>
		  </td>
		</tr>
  <?php endif; ?> 
</tbody>
</table>		
<div class="lapozosor">
  <?php echo $this->LapozoSor; ?>
</div>
<div class="akciogombok">

<?php
//echo '<a href="'.$this->Akciok['deleteSzavazas'].'" class="akcioGomb btnAltDelete" styla="height:30px; margin-top:-4px">'.JText::_('SZAVAZASTORLES').'</a>
//';
if ($this->Akciok['szavazok'] != '') {
      echo '<a href="'.$this->Akciok['szavazok'].'" class="akcioGomb btnSzavazok" >'.JText::_('SZAVAZOK').'</a>
      ';
} 
/*
if ($this->Akciok['szavaztal'] != '') {
      echo '<span class="szavaztal">'.JText::_('SZAVAZTAL').'</span>';
}
if ($this->Akciok['szavazatTorles'] != '') {
      echo '<a href="'.$this->Akciok['szavazatTorles'].'" class="akcioGomb btnSzavazatDelete" >'.JText::_('SZAVAZATOMTORLESE').'</a>
      ';
}
*/
if ($this->Akciok['eredmeny'] != '') {
      //echo '<a href="'.$this->Akciok['eredmeny'].'" class="akcioGomb btnEredmeny" onMouseDown="alter(123456);">'.JText::_('EREDMENY').'</a>
      echo '<a class="akcioGomb btnEredmeny" onClick="eredmenyClick();" style="cursor:pointer">'.JText::_('EREDMENY').'</a>
      ';
} 
/* 
if ($this->Akciok['emailszavazas'] != '') {
      echo '<a class="akcioGomb btnEmailSzavazas" style="cursor:pointer" href="'.$this->Akciok['emailszavazas'].'">'.JText::_('EMAILMEGHIVO').'</a>
      ';
} 
 
echo '<a href="'.$this->backLink.' "class="akcioGomb btnBack">A témakör szavazásai</a>
      <a href="'.$this->homeLink.'" class="akcioGomb btnBack">'.JText::_('TEMAKOROK').'</a>
	 ';
*/
echo '	 
      <a href="'.$this->Akciok['sugo'].'" class="akcioGomb btnHelp modal" 
          rel="{handler: '."'iframe'".', size: {x: 800, y: 600}}">'.JText::_('SUGO').'</a>
';   
?>   
</div><!-- akciogombok -->

<div id="divTurelem" style="display:none;">
<h1>Türelmet kérek...</h1>
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
    document.getElementById("btnszinfo").style.display="none";
  }
  function szinfoClose() {
    document.getElementById("szavazasInfo").style.display="none";
    document.getElementById("btnszinfo").style.display="inline-block";
  }
  function eredmenyClick() {
    document.getElementById("divTurelem").style.display="block";
    setInterval("turelemAnimacio()",100);
    location = "'.$this->Akciok['eredmeny'].'";
  }
  function turelemAnimacio() {
    // esetleg itt lehet valami animáció
    d = document.getElementById("divTurelem");
  }
  
  function igenClick() {
	 location = "index.php?option=com_alternativak&view=alternativaklist&task=igenclick"+
	   "&szavazas='.$this->Szavazas->id.'&temakor='.$this->Szavazas->temakor.'"; 
  }
  function nemClick() {
	 location = "index.php?option=com_alternativak&view=alternativaklist&task=nemclick"+
	   "&szavazas='.$this->Szavazas->id.'&temakor='.$this->Szavazas->temakor.'"; 
  }
  function ertClick(i) {
	  document.forms.ertekeloForm.user_rating.value = i;
	  document.forms.ertekeloForm.submit();
  }

</script>

<?php
  /*
  // értékelés beolvasása az adatbázisból és megjelenitése
  $db->setQuery('select * from #__content_rating where content_id = '.$db->quote($this->CommentId));
  $res = $db->loadObject();
  //DBG echo $db->getQuery();
  if (!$res) {
	 $res = new stdClass();
	 $res->rating_sum = 0;
	 $res->rating_count = 0;	
  }	  
  if ($res->rating_count > 0)
    $ertekeles = round($res->rating_sum / $res->rating_count);
  else
	$ertekeles = 0;  
  echo '<div class="ertekeles">
  <label>Értékelés:</label>
  ';
  for ($i=1; $i <= 5; $i++) {
	if ($i <= $ertekeles) $ertClass = 'csillagSzines'; else $ertClass = 'csillag';
	echo '<var class="'.$ertClass.'" onclick="ertClick('.$i.')"><span>*</span></var>
	';
  }
  echo ' <i>('.$res->rating_count.'.db értékelés)</i> Értékelj a csillagokra kattintva!
  </div>
  ';
  */
?>

<form id="ertekeloForm" name="ertekeloForm" method="post" style="display:none"
      action="<?php echo JURI::base(); ?>index.php?option=com_content&view=article&id=<?php echo $this->CommentId; ?>&Itemid=888&hitcount=0" class="form-inline">
	<input type="hidden" id="content_vote_<?php echo $this->CommentId; ?>" name="user_rating" value="" />
	<input type="hidden" name="submit_vote" value="Értékelés" />
	<input type="hidden" name="task" value="article.vote" />
	<input type="hidden" name="hitcount" value="0" />
	<input type="hidden" name="url" value="<?php echo JURI::base(); ?>SU/alternativak/alternativaklist/browse/<?php echo JRequest::getVar('temakor'); ?>/<?php echo JRequest::getVar('szavazas'); ?>/5/0/1/" />
	<?php echo JHtml::_( 'form.token' ); ?>
</form>
			
<?php 
if ($this->CommentId > 0) {
  // adt átadás az almenü, kepviselodoboz moduloknak
  $session = JFactory::getSession();
  $session->set('kepviselo',$this->Kepviselo);
  $session->set('akciok',$this->Akciok);

  echo JComments::show($this->CommentId, 'com_content', $this->Szavazas->megnevezes);
}
?>