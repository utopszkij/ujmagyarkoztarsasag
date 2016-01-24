<?php
$session = JFactory::getSession();
$secret = md5(date('ymdhis'));
$session->set('secret',$secret);
echo '<h2>'.$this->Szavazas->megnevezes.'</h2>'; 
echo '<p>'.$this->Item->megnevezes.'</p>'; 
echo '<p>'.JText::_('ALTERANATIVATORLESBIZTOS').'</p>';
echo '<p>&nbsp;</p>';
echo '<center>
<a href="'.$this->Akciok['ok'].'&'.$secret.'=1" class="akcioGomb btnDelete">'.JText::_('DELETE').'</a>
<a href="'.$this->Akciok['cancel'].'" class="akcioGomb btnCancel">'.JText::_('MEGSEM').'</a>
</center>';
?>