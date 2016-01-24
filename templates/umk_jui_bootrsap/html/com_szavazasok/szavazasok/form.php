<?php
JHTML::_('behavior.modal');

//DBG foreach ($this->Item as $fn => $fv) echo '<p>form->Item '.$fn.'='.$fv.'</p>';
 
$form = JForm::getInstance('szavazasok',JPATH_ADMINISTRATOR.DS.'components'.DS.'com_szavazasok'.DS.'models'.DS.'forms'.DS.'szavazasok.xml');

if (JRequest::getVar('szavazas')=='') JRequest::setVar('szavazas',JRequest::getVar('id'));

if ($this->Msg != '') {
  echo '<div class="errorMsg">'.$this->Msg.'</div>
  ';
}
if ($this->Item->id == 0) {
	// Új felvitel alapértékek UMK specialitás
	$this->Item->vita1 = 0;
	$this->Item->vita2 = 0;
	$this->Item->szavazas = 0;
	$this->Item->lezart = 0;
	$this->Item->elbiralas_alatt = 1;
	$this->Item->vita1_vege = date('Y-m-d', time() + (30*24*60*60));
	$this->Item->vita2_vege = date('Y-m-d', time() + (30*24*60*60));
	$this->Item->szavazas_vege = date('Y-m-d', time() + (60*24*60*60));
	$formTitle = 'Új ötlet javaslat beküldése';
} else if ($this->Item->vita_alt == 1) {
	$formTitle = 'Ötlet módosítása';
} else if ($this->Szavazas->szavazas == 1) {
	$formTitle = 'Szavazás módosítása';
} else {
	$formTitle = 'Módosítás';
}
$form->bind($this->Item);
$this->form = $form;
?>

<div class="szavazasForm">
	<div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
		<div class="temakorDoboz">
			<div class="dobozFejlec">
			  <a href="<?php echo JURI::base(); ?>index.php?option=com_szavazasok&view=vita_alt&task=vita_alt&temakor=<?php echo $this->Temakor->id; ?>">
				<img class="temakorKep" src="<?php echo kepLeirasbol($this->Temakor->leiras); ?>" />
				Témakör: <h2><?php echo $this->Temakor->megnevezes; ?></h2>
			  </a>	
			</div>
			<div class="temakorLeiras"><?php echo utf8Substr($this->Temakor_leiras,0,10000); ?></div>
		</div>
		<?php if ($this->Akciok['temakoredit']) :?>
		<a class="editIcon" href="<?php echo $this->Akciok[temakoredit]; ?>" title="Módosít">&nbsp;<span>Edit</span></a>
		<?php endif; ?>
		<?php if ($this->Akciok['temakortorles']) : ?>
		<a class="deleteIcon" href="<?php echo $this->Akciok[temakortorles];?>" title="Töröl">&nbsp;<span>Törlés</span></a>
		<?php endif; ?>
		<div class="clr"></div>
		<h2><?php $formTitle; ?></h2>
		<a class="akcioGomb btnHelp modal" rel="{handler: '."'iframe'".', size: {x: 800, y: 600}}" href="<?php echo $this->Akciok['sugo']; ?>">
			<?php echo JText::_('SUGO'); ?>
		</a>
	</div><!-- componetheading -->
	<div class="clr"></div>
	
<?php
/*
if ($this->Akciok['paste'] != '') {
     echo '
      <a class="akcioGomb btnPaste"  href="'.$this->Akciok['paste'].'">
      '.JText::_('PASTE').'
      </a>
     '; 
}
echo '
   <a class="akcioGomb btnEmails" href="'.$this->Akciok['emails'].'">'.JText::_('SENDEMAILS').'</a>&nbsp;
   <a class="akcioGomb btnHelp modal" rel="{handler: '."'iframe'".', size: {x: 800, y: 600}}" href="'.$this->Akciok['sugo'].'">
   '.JText::_('SUGO').'
   </a>
';
*/
echo '   
</p>
<form action="'.$this->Akciok['ok'].'" method="post" id="szavazasokForm" name="szavazasokForm">
  <input type="hidden" name="limit" value="'.JRequest::getVar('limit').'" />
  <input type="hidden" name="limitstart" value="'.JRequest::getVar('limitstart').'" />
  <input type="hidden" name="order" value="'.JRequest::getVar('order').'" />
  <input type="hidden" name="filterStr" value="'.JRequest::getVar('filterStr').'" />
  <input type="hidden" name="temakor" value="'.JRequest::getVar('temakor','0').'" />
  <!-- input type="hidden" name="temakor_id" value="'.JRequest::getVar('temakor','0').'" / -->
  <input type="hidden" name="itemId" value="'.JRequest::getVar('itemId').'" />
  <input type="hidden" name="id" value="'.JRequest::getVar('szavazas').'" />
 '; 
?>

		<div>
		    <b>Címkék</b><br />
			<?php 
			$db = JFactory::getDBO();
			$db->setQuery('select * from #__cimkek order by cimke');
			$res = $db->loadObjectList();
			$i = 0;
			foreach ($res as $res1) {
				if (strpos($this->Item->cimkek, $res1->cimke) === false) {
					echo '<input type="checkbox" name="cimke_'.$i.'" value="'.$res1->cimke.'" />&nbsp;'.$res1->cimke.' '."\n";
				} else {
					echo '<input type="checkbox" name="cimke_'.$i.'" checked="checked" value="'.$res1->cimke.'" />&nbsp;'.$res1->cimke.' '."\n";
				}
				if (($i >= 5) & ($i % 5 == 0)) echo '<br / >';
				$i++;
			}
			?>
		</div>

	 	<div class="col <?php if(version_compare(JVERSION,'3.0','lt')):  ?>width-60  <?php endif; ?>span8 form-horizontal fltlft">
		  <fieldset class="adminform">
				<?php echo JText::_('MEGNEVEZES'); ?>
				<?php echo $this->form->getInput('megnevezes');  ?>
				<div class="clr"></div>
				<?php echo $this->form->getLabel('leiras'); ?>
				<div class="clr"></div>
				<?php echo $this->form->getInput('leiras');  ?>
				<div class="clr"></div>
				
				<?php if ($this->item->id > 0) {
					echo $this->form->getLabel('temakor_id');
				    echo '<select name="temakor_id">
					'.$this->temakorTree.'
					</select>
					';
				} else {
					echo '<input type="hidden" name="temakor_id" value="'.JRequest::getVar('temakor').'" />
					';
				}
				?>
				<?php if ($this->Item->id == 0) $d="none"; else $d="block"; ?>
				<div id="rejtettFieldset1" style="display:<?php echo $d; ?>">
					<?php echo $this->form->getLabel('titkos'); ?>
					<?php echo $this->form->getInput('titkos');  ?>
					<div class="clr"></div>
					<?php echo $this->form->getLabel('szavazok'); ?>
					<?php echo $this->form->getInput('szavazok');  ?>
					<div class="clr"></div>
					<?php echo $this->form->getLabel('alternativajavaslok'); ?>
					<?php echo $this->form->getInput('alternativajavaslok');  ?>
					<div class="clr"></div>
					<?php echo $this->form->getLabel('vita1_vege'); ?>
					<?php echo $this->form->getInput('vita1_vege');  ?>
					<div class="clr"></div>
					<?php /* echo $this->form->getLabel('vita2_vege');  */ ?>
					<?php /* echo $this->form->getInput('vita2_vege');  */ ?>
					<div class="clr"></div>
					<?php echo $this->form->getLabel('szavazas_vege'); ?>
					<?php echo $this->form->getInput('szavazas_vege');  ?>
				</div>
				<div class="clr"></div>
				<?php echo $this->form->getLabel('letrehozo'); ?>
        <?php $user = JFactory::getUser($this->Item->letrehozo); 
             echo $user->username; ?>
				<div class="clr"></div>
				<?php echo $this->form->getLabel('letrehozva'); ?>
				<?php echo $this->Item->letrehozva;  ?>
				<div class="clr"></div>
      </fieldset>      
		<?php if ($this->Item->id == 0) $d="none"; else $d="block"; ?>
		<div id="rejtettFieldset2" style="display:<?php echo $d; ?>">
			<fieldset class="allapot">
			  <legend><?php echo JText::_( 'ALLAPOT' ); ?></legend>
				<?php echo $this->form->getLabel('elbiralas_alatt'); ?>
			  <input type="radio" onclick="allapotClick()" name="allapot" id="r_elbiralas_alatt" value="elbiralas_alatt"<?php if ($this->Item->elbiralas_alatt==1) echo ' checked="checked"'; ?> />
				<?php echo $this->form->getLabel('vita1'); ?>
			  <input type="radio" onclick="allapotClick()" name="allapot" id="r_vita1" value="vita1"<?php if ($this->Item->vita1==1) echo ' checked="checked"'; ?> />
				<div class="clr"></div>
				<?php /*  echo $this->form->getLabel('vita2');  */ ?>
				<!--
			    <input type="radio" onclick="allapotClick()" name="allapot" id="r_vita2" value="vita2"<?php if ($this->Item->vita2==1) echo ' checked="checked"'; ?> />
				<div class="clr"></div>
				-->
				<?php echo $this->form->getLabel('szavazas'); ?>
			  <input type="radio" onclick="allapotClick()" name="allapot" id="r_szavazas" value="szavazas"<?php if ($this->Item->szavazas==1) echo ' checked="checked"'; ?> />
				<div class="clr"></div>
				<?php echo $this->form->getLabel('lezart'); ?>
			  <input type="radio" onclick="allapotClick()" name="allapot" id="r_lezart" value="lezart"<?php if ($this->Item->lezart==1) echo ' checked="checked"'; ?> />
				<label>Elutasítva</label>
			  <input type="radio" onclick="allapotClick()" name="allapot" id="r_elvetve" value="elvetve"<?php if ($this->Item->elutasitva!='') echo ' checked="checked"'; ?> />
			  <div class="clr"></div>
			</fieldset>
		</div>
	  <fieldset id="fs_elutasitva">
		<label>Elutasítás indoklása</label>
		<?php echo $this->form->getInput('elutasitva');  ?>
	    <div class="clr"></div>
	  </fieldset>
	  
      <?php if ($this->Item->id == 0) { ?>
        <fieldset class="alternativak">
          <h3>Javasolt megoldási alternatívák</h3>
          <?php
            while (count($this->Item->alternativak) < 5) {
              $w = new stdClass();
              $w->megnevezes = '';
              $w->leiras = '';
              $this->Item->alternativak[] = $w;
            }
            for ($i=0; $i<count($this->Item->alternativak); $i++) {
              $alternativa = $this->Item->alternativak[$i];
              echo '
              <p><input type="text" name="alternativa'.$i.'" size="80" class="input400" value="'.$alternativa->megnevezes.'" />
                 <br>&nbsp;&nbsp;&nbsp;
                <textarea name="leiras'.$i.'" rows="4" cols="70" class="input400">'.$alternativa->leiras.'</textarea>
              </p>
              ';
            }
          ?>
        </fieldset>
      <?php } ?>  
      </div>
      <div class="col <?php if(version_compare(JVERSION,'3.0','lt')):  ?>width-30  <?php endif; ?>span2 fltrgt">
      </div>                   
		<?php echo JHTML::_( 'form.token' ); ?>
	  <div class="clr"></div>
<?php
echo '        
<center>
  <button type="button" class="btnOK" onclick="okClick()">'.JText::_('RENDBEN').'</button>&nbsp;
  <button type="button" class="btnCancel" onclick="cancelClick()">'.JText::_('MEGSEM').'</a>
</center>
</form>
</div><!-- szavazasForm -->

<script type="text/javascript">
  function cancelClick() {
    location="'.$this->Akciok['cancel'].'";
  }
  function okClick() {
    szavazokChange();
    document.forms.szavazasokForm.submit();
  }
  function szavazokChange() {
    // az emailses szavazás mindig szigoruan titkos
    var szavazok = document.getElementById("szavazok").selectedIndex;
    if (szavazok == 0) {
      document.getElementById("titkos").selectedIndex = 2;
    }
  }
  function allapotClick() {
	if (document.getElementById("r_elvetve").checked)  {
		document.getElementById("fs_elutasitva").style.display = "block";
	} else {
		document.getElementById("fs_elutasitva").style.display = "none";
	}	
    if ((document.getElementById("r_elbiralas_alatt").checked) | 
        (document.getElementById("r_elvetve").checked))  {
		document.getElementById("vita1_vege").disabled = "disabled";
		document.getElementById("vita1_vege_img").disabled = "disabled";
		document.getElementById("vita2_vege").disabled = "disabled";
		document.getElementById("vita2_vege_img").disabled = "disabled";
		document.getElementById("szavazas_vege").disabled = "disabled";
		document.getElementById("szavazas_vege_img").disabled = "disabled";
	} else {
		document.getElementById("vita1_vege").disabled = "";
		document.getElementById("vita1_vege_img").disabled = "";
		document.getElementById("vita2_vege").disabled = "";
		document.getElementById("vita2_vege_img").disabled = "";
		document.getElementById("szavazas_vege").disabled = "";
		document.getElementById("szavazas_vege_img").disabled = "";
	}
  }
  function formActivate() {
    document.getElementById("szavazok").onchange = szavazokChange;
	allapotClick();
  }
  setTimeout(formActivate,1000);
</script>
';
?>