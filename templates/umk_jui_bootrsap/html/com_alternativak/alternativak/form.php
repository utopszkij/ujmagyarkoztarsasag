<?php
JHTML::_('behavior.modal'); 
$form = JForm::getInstance('szavazasok',JPATH_ADMINISTRATOR.DS.'components'.DS.'com_alternativak'.DS.'models'.DS.'forms'.DS.'alternativak.xml');
$form->bind($this->Item);
$this->form = $form;

if ($this->Msg != '') {
  echo '<div class="errorMsg">'.$this->Msg.'</div>
  ';
}

?>
<div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
	<div class="temakorDoboz">
		<div class="dobozFejlec">
			<a href="<?php echo JURI::base(); ?>index.php?option=com_szavazasok&view=vita_alt&task=vita_alt&temakor=<?php echo $this->Temakor->id; ?>">
				<img class="temakorKep" src="<?php echo kepLeirasbol($this->Temakor->leiras); ?>" />
				Témakör: <h2><?php echo $this->Temakor->megnevezes; ?></h2>
			</a>	
		</div>
		<div class="temakorLeiras"><?php echo utf8Substr($this->Temakor->leiras,0,10000); ?></div>
	</div>
	<div class="szavazasDoboz">
		<div class="dobozFejlec">
			<a href="<?php echo JURI::base(); ?>index.php?option=com_alternativak&view=alternativaklist&task=browse&temakor=<?php echo $this->Temakor->id; ?>&szavazas=<?php echo $this->Szavazas->id; ?>">
				<img class="szavazasKep" src="<?php echo kepLeirasbol($this->Szavazas->leiras); ?>" />
				Szavazás: <h2><?php echo $this->Szavazas->megnevezes; ?></h2>
			</a>	
		</div>
		<div class="szavazasLeiras"><?php echo utf8Substr($this->Szavazas->leiras,0,10000); ?></div>
	</div>
	
</div><!-- componetheading -->
<div class="clr"></div>
<?php
echo '<h2>'.$this->Title.'</h2>
<p style="text-align:right;">
';
if ($this->Akciok['delete'] != '') {
  echo '
   <a class="akcioGomb btnAltDelete"  href="'.$this->Akciok['delete'].'">
   '.JText::_('DELETE').'
   </a>
  '; 
}

echo '
   <a class="akcioGomb btnHelp modal" rel="{handler: '."'iframe'".', size: {x: 800, y: 600}}" href="'.$this->Akciok['sugo'].'">
   '.JText::_('SUGO').'
   </a>
</p>
<form action="'.$this->Akciok['ok'].'" method="post" name="alternativakForm" id="alternativakForm"
  <input type="hidden" name="limit" value="'.JRequest::getVar('limit').'" />
  <input type="hidden" name="limitstart" value="'.JRequest::getVar('limitstart').'" />
  <input type="hidden" name="order" value="'.JRequest::getVar('order').'" />
  <input type="hidden" name="filterStr" value="'.JRequest::getVar('filterStr').'" />
  <input type="hidden" name="temakor" value="'.JRequest::getVar('temakor','0').'" />
  <input type="hidden" name="szavazas" value="'.JRequest::getVar('szavazas','0').'" />
  <input type="hidden" name="temakor_id" value="'.JRequest::getVar('temakor','0').'" />
  <input type="hidden" name="szavazas_id" value="'.JRequest::getVar('szavazas','0').'" />
  <input type="hidden" name="itemId" value="'.JRequest::getVar('itemId').'" />
  <input type="hidden" name="id" value="'.$this->Item->id.'" />
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
				<?php echo $this->form->getLabel('letrehozo'); ?>
        <?php $user = JFactory::getUser($this->Item->letrehozo); 
             echo $user->username; ?>
				<div class="clr"></div>
				<?php echo $this->form->getLabel('letrehozva'); ?>
				<?php echo $this->Item->letrehozva;  ?>
				<?php if($this->item->id > 0) : ?>
				  <?php echo $this->form->getLabel('elbiralasra_var'); ?>
				  <?php echo $this->form->getInput('elbiralasra_var');  ?>
				<?php else :  ?>
				  <input type="hidden" name="elbiralasra_var" value="1" />
				<?php endif; ?>
				<div class="clr"></div>
      </fieldset>                      
      <div class="col <?php if(version_compare(JVERSION,'3.0','lt')):  ?>width-30  <?php endif; ?>span2 fltrgt">
      </div>                   
		<?php echo JHTML::_( 'form.token' ); ?>
		<div class="clr"></div>
    <p><?php echo JText::_('ALTERNATIVAHELP'); ?></p>
<?php
echo '        
<center>
  <button type="button" onclick="okClick()" class="btnOK">'.JText::_('RENDBEN').'</button>&nbsp;
  <button type="button" class="btnCancel" onclick="cancelClick()">'.JText::_('MEGSEM').'</a>
</center>
</form>
<script type="text/javascript">
  function cancelClick() {
    location="'.$this->Akciok['cancel'].'";
  }
  function okClick() {
    document.forms.alternativakForm.submit();
  }
</script>
';
?>