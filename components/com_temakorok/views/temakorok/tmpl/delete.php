<?php
JHTML::_('behavior.modal'); 
$form = JForm::getInstance('beallitasok',JPATH_ADMINISTRATOR.DS.'components'.DS.'com_temakorok'.DS.'models'.DS.'forms'.DS.'temakorok.xml');
$form->bind($this->Item);
$this->form = $form;

if ($this->Masg != '') {
  echo '<div class="errorMsg">'.$this->Msg.'</div>
  ';
}
echo $this->Szulok;
echo '<h2>'.$this->Title.'</h2>
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
  <input type="hidden" name="itemId" value="'.JRequest::getVar('itemId').'" />
 '; 
?>
      <p>&nbsp;</p>
      <p><strong><?php echo $this->Item->megnevezes; ?></strong></p>
      <div><?php echo $this->Item->leiras; ?></div>
      <p>&nbsp;</p>
      <p><h2><?php echo JText::_('SURE_TEMAKOR_DELETE'); ?></h2></p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
			<div class="clr"></div>
      <div class="col <?php if(version_compare(JVERSION,'3.0','lt')):  ?>width-30  <?php endif; ?>span2 fltrgt">
      </div>                   
		  <?php echo JHTML::_( 'form.token' ); ?>

<?php
echo '        
<center>
  <button type="submit" class="btnDelete">'.JText::_('DELETE').'</button>&nbsp;
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