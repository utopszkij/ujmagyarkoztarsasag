<?php




JHTML::_('behavior.modal'); 
$form = JForm::getInstance('szavazasok',JPATH_ADMINISTRATOR.DS.'components'.DS.'com_szavazasok'.DS.'models'.DS.'forms'.DS.'szavazasok.xml');
$form->bind($this->Item);
$this->form = $form;
$emailLink = JURI::base().'index.php?option=com_tagok&view=tagok&task=mailform'.
'&temakor='.$this->Item->temakor_id.'&tag='.$this->Item->kepviselo_id.
'&nick='.$this->Item->kusername.
'&return='.base64_encode(JURI::base().'index.php?option=com_kepviselok&view=kepviselok&task=show'.
'&temakor='.$this->Item->temakor_id.'&id='.$this->Item->kepviselo_id);
if ($this->Msg != '') {
  echo '<div class="errorMsg">'.$this->Msg.'</div>
  ';
}
if (count($this->Kepviseltek) > 0) {
  $this->Title = JText::_('KEPVISELO');
} else {
  $this->Title = JText::_('KEPVISELOJELOLT');
}
echo '<h3>'.$this->Temakor->megnevezes.'</h3>
<div style="float:left">'.$this->Item->kimage.'</div>
<div style="float:left">
<h2>'.$this->Title.'</h2>
<h4>'.$this->Item->kname.' ('.$this->Item->kusername.')
  <a class="akcioGomb btnEmail" href="'.$emailLink.'">'.JText::_('EMAILKULDES').'</a>
</h4>
</div>
';

if ($this->altKepviseloLink != '') {
  echo '
  <div class="kepviselo" style="float:right;">
    <a class="btnKepviselo" href="'.$this->altKepviseloLink.'">
      '.$this->altKepviseloImg.'<br />'.$this->altKepviseloNev.'
      <br />'.JText::_('ALTKEPVISELOJE').'
    </a>
  </div>
  ';
}
if ($this->temaKepviseloLink != '') {
  echo '
  <div class="kepviselo" style="float:right;">
    <a class="btnKepviselo" href="'.$this->temaKepviseloLink.'">
      '.$this->temaKepviseloImg.'<br />'.$this->temaKepviseloNev.'
       <br />'.JText::_('TEMAKORKEPVISELOJE').'
    </a>
  </div>
  ';
}
echo '
<div style="clear:both"></div>
<p style="text-align:right;">
';
if ($this->Akciok['delete'] <> '')
  echo '<a class="akcioGomb btnDelete" href="'.$this->Akciok['delete'].'">'.JText::_('DELETE').'</a>
  ';
if ($this->Akciok['save'] <> '')
  echo '<a class="akcioGomb btnOK" href="'.$this->Akciok['save'].'">'.JText::_('LEGYENAKEPVISELOM').'</a>
  ';
if ($this->Akciok['temakorok'] <> '')
  echo '<a class="akcioGomb btnBack" href="'.$this->Akciok['temakorok'].'">'.JText::_('TEMAKOROK').'</a>
  ';
if ($this->Akciok['temakor'] <> '')
  echo '<a class="akcioGomb btnBack" href="'.$this->Akciok['temakor'].'">'.JText::_('TEMAKOR').'</a>
  ';
if ($this->Akciok['valaszt'] <> '')
  echo '<a class="akcioGomb btnBack" href="'.$this->Akciok['valaszt'].'">'.JText::_('VALASZT').'</a>
  ';
  
echo '
   <a class="akcioGomb btnSzavazatok" href="'.$this->Akciok['szavazatok'].'">'.JText::_('SZAVAZATOK').'</a>
   <a class="akcioGomb btnHelp modal" rel="{handler: '."'iframe'".', size: {x: 800, y: 600}}" href="'.$this->Akciok['sugo'].'">
   '.JText::_('SUGO').'
   </a>
</p>
<div class="kepviseloleiras">
  '.$item->leiras.'
</div>
';          
echo '<h3>'.JText::_('KEPVISELTEK').'</h3>
';
if ($this->Config->atruhazas_lefele_titos == 0) { 
  foreach ($this->Kepviseltek as $kepviselt) {
    $klink = JURI::base().'index.php?option=com_tagok&view=tagok&task=mailform'.
       '&temakor='.$this->Temakor->id.'&tag='.$kepviselt->id.'&nick='.$kepviselt->username.
       '&return='.urlencode(JURI::base().'index.php?option=com_kepviselok&view=kepviselok'.
       '&task=show&temakor='.$this->Temakor->id.'&id='.$this->Item->kepviselo_id);
    echo '<p><a href="'.$klink.'">'.$kepviselt->name.'('.$kepviselt->username.')</a>';
  }
}
echo '<p>'.$this->KepviseltekDarab.' '.JText::_('FO').'</p>';

// kommentek megjelenitése
if ($this->CommentId > 0) {
  echo JComments::show($this->CommentId, 'com_content', $this->Szavazas->megnevezes);
}

include 'components/com_jumi/files/forum.php'; 
?>