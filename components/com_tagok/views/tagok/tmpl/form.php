<?php
JHTML::_('behavior.modal');

//DBG foreach ($this->Item as $fn => $fv) echo '<p>form->Item '.$fn.'='.$fv.'</p>';
 
$form = JForm::getInstance('tagok',JPATH_ADMINISTRATOR.DS.'components'.DS.'com_tagok'.DS.'models'.DS.'forms'.DS.'tagok.xml');
$form->bind($this->Item);
$this->form = $form;

if ($this->Msg != '') {
  echo '<div class="errorMsg">'.$this->Msg.'</div>
  ';
}
echo '
<script type="text/javascript">
  function cancelClick() {
    location="'.$this->Akciok['cancel'].'";
  }
</script>
<h3>'.$this->Temakor->megnevezes.'</h3>
<h2>'.$this->Title.'</h2>
<p>'.$this->Item->name.' ('.$this->Item->username.')
   &nbsp;<a class="akcioGomb btnEmail" href="'.$this->Akciok['sendmail'].'">'.JText::_('EMAILTKULD').'</a>
</p>
<p style="text-align:right">
';
if ($this->Akciok['delete'] != '') {
  echo '
   <a class="akcioGomb btnDelete" href="'.$this->Akciok['delete'].'">
   '.JText::_('TAGTORLES').'
   </a>
  ';
}
echo '   
   <a class="akcioGomb btnHelp modal" rel="{handler: '."'iframe'".', size: {x: 800, y: 600}}" href="'.$this->Akciok['sugo'].'">
   '.JText::_('SUGO').'
   </a>
</p>
';
echo '
<form action="'.$this->Akciok['ok'].'" method="post">
  <input type="hidden" name="limit" value="'.JRequest::getVar('limit').'" />
  <input type="hidden" name="limitstart" value="'.JRequest::getVar('limitstart').'" />
  <input type="hidden" name="order" value="'.JRequest::getVar('order').'" />
  <input type="hidden" name="filterStr" value="'.JRequest::getVar('filterStr').'" />
  <input type="hidden" name="temakor" value="'.JRequest::getVar('temakor','0').'" />
  <input type="hidden" name="temakor_id" value="'.JRequest::getVar('temakor','0').'" />
  <input type="hidden" name="itemId" value="'.JRequest::getVar('itemId').'" />
  <input type="hidden" name="tag" value="'.JRequest::getVar('tag').'" />
  <input type="hidden" name="id" value="'.JRequest::getVar('tag').'" />
  ';
  if ($this->Mode=='edit') {
?>  
 	<div class="col <?php if(version_compare(JVERSION,'3.0','lt')):  ?>width-60  <?php endif; ?>span8 form-horizontal fltlft">
		  <fieldset class="adminform">
			  <legend><?php echo JText::_( 'ADATOK' ); ?></legend>
				<?php echo JText::_('ADMIN'); ?>
				<?php echo $this->form->getInput('admin');  ?>
				<div class="clr"></div>
      </fieldset>                      
      </div>
      <div class="col <?php if(version_compare(JVERSION,'3.0','lt')):  ?>width-30  <?php endif; ?>span2 fltrgt">
      </div>                   
		<?php echo JHTML::_( 'form.token' ); ?>
		<div class="clr"></div>
<?php
    echo '
    <p>&nbsp;</p>        
    <center>
      <button type="submit" class="btnOK">'.JText::_('RENDBEN').'</button>&nbsp;
      <button type="button" class="btnCancel" onclick="cancelClick()">'.JText::_('MEGSEM').'</a>
    </center>
    ';
  } else {
    if ($this->Item->admin == 1)
      echo '
      <p>Admin</p>
      ';
    echo '
    <p>&nbsp;</p>        
    <center>
      <button type="button" class="akcioGomb btnBack" onclick="cancelClick()">'.JText::_('VISSZA').'</a>
    </center>
    ';
  }
  echo '</form>
  ';
?>