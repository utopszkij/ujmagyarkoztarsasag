<?php
JHTML::_('behavior.modal'); 
if ($this->Masg != '') {
  echo '<div class="errorMsg">'.$this->Msg.'</div>
  ';
}
echo '<h2>'.JText::_('BEALLITASOKURLAP').'</h2>
<p style="text-align:right">
   <a class="akcioGomb btnHelp modal" rel="{handler: '."'iframe'".', size: {x: 800, y: 600}}" href="'.$this->helpLink.'">
   '.JText::_('SUGO').'
   </a>
</p>
<form action="'.$this->okLink.'" method="post">
				'.$this->form->getLabel('id').'
				'.$this->form->getInput('id').'
				'.$this->form->getLabel('temakor_felvivo').'
				'.$this->form->getInput('temakor_felvivo').'
<center>
  <button type="submit" class="btnOK">'.JText::_('RENDBEN').'</button>&nbsp;
  <button type="button" class="btnCancel" onclick="cancelClick()">'.JText::_('MEGSEM').'</a>
</center>
</form>
<script type="text/javascript">
  function cancelClick() {
    location="'.$this->cancelLink.'";
  }
</script>
';
?>