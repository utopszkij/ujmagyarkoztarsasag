<?php
JHTML::_('behavior.modal'); 
$form = JForm::getInstance('szavazasok',JPATH_ADMINISTRATOR.DS.'components'.DS.'com_szavazasok'.DS.'models'.DS.'forms'.DS.'szavazasok.xml');
$form->bind($this->Item);
$this->form = $form;

if ($this->Msg != '') {
  echo '<div class="errorMsg">'.$this->Msg.'</div>
  ';
}
if (count($this->Kepviseltek) > 0) {
  $this->Title = JText::_('KEPVISELO');
} else {
  $this->Title = JText::_('KEPVISELOJELOLT');
}
if ($this->Avatar != '') {
  echo '<div style="float:right">'.$this->Avatar.'</div>
  ';
}
echo '<h3>'.$this->Temakor->megnevezes.'</h3>
<h4>'.$this->Item->name.' ('.$this->Item->username.')</h4>
<h2>'.$this->Title.'</h2>
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
<form action="'.$this->Akciok['ok'].'" method="post">
  <input type="hidden" name="limit" value="'.JRequest::getVar('limit').'" />
  <input type="hidden" name="limitstart" value="'.JRequest::getVar('limitstart').'" />
  <input type="hidden" name="order" value="'.JRequest::getVar('order').'" />
  <input type="hidden" name="filterStr" value="'.JRequest::getVar('filterStr').'" />
  <input type="hidden" name="temakor" value="'.JRequest::getVar('temakor','0').'" />
  <input type="hidden" name="temakor_id" value="'.JRequest::getVar('temakor','0').'" />
  <input type="hidden" name="itemId" value="'.JRequest::getVar('itemId').'" />
  <input type="hidden" name="id" value="'.$this->Item->id.'" />
 '; 
?>
	 	<div class="col <?php if(version_compare(JVERSION,'3.0','lt')):  ?>width-60  <?php endif; ?>span8 form-horizontal fltlft">
		  <fieldset class="adminform">
				<?php echo $this->form->getLabel('leiras'); ?>
				<div class="clr"></div>
				<?php echo $this->form->getInput('leiras');  ?>
				<div class="clr"></div>
      </fieldset>                      
      <div class="col <?php if(version_compare(JVERSION,'3.0','lt')):  ?>width-30  <?php endif; ?>span2 fltrgt">
      </div>                   
		<?php echo JHTML::_( 'form.token' ); ?>
		<div class="clr"></div>
    <p><?php echo JText::_('KEPVISELOHELP'); ?></p>
<?php
echo '        
<center>
  <button type="submit" class="btnOK">'.JText::_('RENDBEN').'</button>&nbsp;
  <button type="button" class="btnCancel" onclick="cancelClick()">'.JText::_('MEGSEM').'</a>
</center>
</form>
';
echo '<h3>'.JText::_('KEPVISELTEK').'</h3>
    ';
if ($this->Config->atruhazas_lefele_titkos == 0) {
  if (count($this->Kepviseltek) > 0) {
    foreach ($this->Kepviseltek as $kepviselt) {
      $klink = JURI::base().'index.php?option=com_tagok&view=tagok&task=mailform'.
         '&temakor='.$this->Temakor->id.'&tag='.$kepviselt->id.'&nick='.$kepviselt->username.
         '&return='.urlencode(JURI::base().'index.php?option=com_kepviselojeloltek&view=kepviselojeloltek&task=add&temakor='.$this->Temakor->id);
      echo '<p><a href="'.$klink.'">'.$kepviselt->name.'('.$kepviselt->username.')</a>';
    }
  }
}
echo '<p>'.count($this->Kepviseltek).' '.JText::_('FO').'</p>';
echo '
<script type="text/javascript">
  function cancelClick() {
    location="'.$this->Akciok['cancel'].'";
  }
</script>
';
include 'components/com_jumi/files/forum.php'; 
?>