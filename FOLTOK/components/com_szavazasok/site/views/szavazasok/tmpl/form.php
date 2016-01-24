<?php
JHTML::_('behavior.modal');

//DBG foreach ($this->Item as $fn => $fv) echo '<p>form->Item '.$fn.'='.$fv.'</p>';
 
$form = JForm::getInstance('szavazasok',JPATH_ADMINISTRATOR.DS.'components'.DS.'com_szavazasok'.DS.'models'.DS.'forms'.DS.'szavazasok.xml');
$form->bind($this->Item);
$this->form = $form;

if ($this->Msg != '') {
  echo '<div class="errorMsg">'.$this->Msg.'</div>
  ';
}
echo '<h3>'.$this->Temakor->megnevezes.'</h3>
<h2>'.$this->Title.'</h2>
<p style="text-align:right">
   <a class="akcioGomb btnHelp modal" rel="{handler: '."'iframe'".', size: {x: 800, y: 600}}" href="'.$this->Akciok['sugo'].'">
   '.JText::_('SUGO').'
   </a>
</p>
<form action="'.$this->Akciok['ok'].'" method="post">
  <input type="hidden" name="limit" value="'.JRequest::getVar('limit').'" />
  <input type="hidden" name="limitstart" value="'.JRequest::getVar('limitstart').'" />
  <input type="hidden" name="order" value="'.JRequest::getVar('order').'" />
  <input type="hidden" name="filterStr" value="'.JRequest::getVar('filterStr').'" />
  <input type="hidden" name="temakor" value="'.JRequest::getVar('temakor','0').'" />
  <input type="hidden" name="temakor_id" value="'.JRequest::getVar('temakor','0').'" />
  <input type="hidden" name="itemId" value="'.JRequest::getVar('itemId').'" />
  <input type="hidden" name="id" value="'.JRequest::getVar('szavazas').'" />
 '; 
?>
	 	<div class="col <?php if(version_compare(JVERSION,'3.0','lt')):  ?>width-60  <?php endif; ?>span8 form-horizontal fltlft">
		  <fieldset class="adminform">
			  <legend><?php echo JText::_( 'ADATOK' ); ?></legend>
				<?php echo JText::_('MEGNEVEZES'); ?>
				<?php echo $this->form->getInput('megnevezes');  ?>
				<div class="clr"></div>
				<?php echo $this->form->getLabel('leiras'); ?>
				<div class="clr"></div>
				<?php echo $this->form->getInput('leiras');  ?>
				<div class="clr"></div>
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
				<?php echo $this->form->getLabel('vita2_vege'); ?>
				<?php echo $this->form->getInput('vita2_vege');  ?>
				<div class="clr"></div>
				<?php echo $this->form->getLabel('szavazas_vege'); ?>
				<?php echo $this->form->getInput('szavazas_vege');  ?>
				<div class="clr"></div>

				<?php echo $this->form->getLabel('letrehozo'); ?>
        <?php $user = JFactory::getUser($this->Item->letrehozo); 
             echo $user->username; ?>
				<div class="clr"></div>
				<?php echo $this->form->getLabel('letrehozva'); ?>
				<?php echo $this->Item->letrehozva;  ?>
				<div class="clr"></div>
      </fieldset>                      
		  <fieldset class="allapot">
			  <legend><?php echo JText::_( 'ALLAPOT' ); ?></legend>
				<?php echo $this->form->getLabel('vita1'); ?>
			  <input type="radio" name="allapot" value="vita1"<?php if ($this->Item->vita1==1) echo ' checked="checked"'; ?> />
				<div class="clr"></div>
				<?php echo $this->form->getLabel('vita2'); ?>
			  <input type="radio" name="allapot" value="vita2"<?php if ($this->Item->vita2==1) echo ' checked="checked"'; ?> />
				<div class="clr"></div>
				<?php echo $this->form->getLabel('szavazas'); ?>
			  <input type="radio" name="allapot" value="szavazas"<?php if ($this->Item->szavazas==1) echo ' checked="checked"'; ?> />
				<div class="clr"></div>
				<?php echo $this->form->getLabel('lezart'); ?>
			  <input type="radio" name="allapot" value="lezart"<?php if ($this->Item->lezart==1) echo ' checked="checked"'; ?> />
				<div class="clr"></div>
      </fieldset>
      <?php if ($this->Item->id == 0) { ?>
        <fieldset class="alternativak">
          <h3><?php echo JText::_(ALTERNATIVAK_LEIRAS); ?></h3>
          <p><input type="text" name="alternativa0" size="80" class="input400" />
             <br>&nbsp;&nbsp;&nbsp;
             <textarea name="leiras0" rows="4" cols="70" class="input400"></textarea>
          </p>
          <p><input type="text" name="alternativa1" size="80" class="input400" />
             <br>&nbsp;&nbsp;&nbsp;
             <textarea name="leiras1" rows="4" cols="70" class="input400"></textarea>
          </p>
          <p><input type="text" name="alternativa2" size="80" class="input400" />
             <br>&nbsp;&nbsp;&nbsp;
             <textarea name="leiras2" rows="4" cols="70" class="input400"></textarea>
          </p>
          <p><input type="text" name="alternativa3" size="80" class="input400" />
             <br>&nbsp;&nbsp;&nbsp;
             <textarea name="leiras3" rows="4" cols="70" class="input400"></textarea>
          </p>
          <p><input type="text" name="alternativa4" size="80" class="input400" />
             <br>&nbsp;&nbsp;&nbsp;
             <textarea name="leiras4" rows="4" cols="70" class="input400"></textarea>
          </p>
        </fieldset>
      <?php } ?>  
      </div>
      <div class="col <?php if(version_compare(JVERSION,'3.0','lt')):  ?>width-30  <?php endif; ?>span2 fltrgt">
      </div>                   
		<?php echo JHTML::_( 'form.token' ); ?>
		<div class="clr"></div>
    <p><?php echo JText::_('SZAVAZASALTERNATIVAHELP'); ?></p>
<?php
echo '        
<center>
  <button type="submit" class="btnOK">'.JText::_('RENDBEN').'</button>&nbsp;
  <button type="button" class="btnCancel" onclick="cancelClick()">'.JText::_('MEGSEM').'</a>
</center>
</form>
<script type="text/javascript">
  function cancelClick() {
    location="'.$this->Akciok['cancel'].'";
  }
</script>
';
?>