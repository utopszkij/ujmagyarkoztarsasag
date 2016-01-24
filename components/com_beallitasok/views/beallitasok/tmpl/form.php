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
				'.$this->form->getLabel('json').'
				'.$this->form->getInput('json').'
<center>
  <button type="submit" class="btnOK">'.JText::_('RENDBEN').'</button>&nbsp;
  <button type="button" class="btnCancel" onclick="cancelClick()">'.JText::_('MEGSEM').'</a>
</center>
</form>
<code>
Default:
{
 "temakor_felvivok":1, // 1-regisztráltak, 2- adminok
 "tobbszintu_atruhazas":0,  // 0-nem, 1-igen
 "atruhazas_lefele_titkos":0  // 0-nem,  1-igen
}
</code>
<script type="text/javascript">
  function cancelClick() {
    location="'.$this->cancelLink.'";
  }
</script>
';
?>