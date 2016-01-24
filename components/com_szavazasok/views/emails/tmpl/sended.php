<?php
/**
 * szavazoknak küldendő körlevél betöltve a que -ba
 * bemenet:
 * $this->Szavazas
 *      .>Temakor 
 *      ->Akciok      [back]
 */ 
// no direct access
defined('_JEXEC') or die('Restricted access');
$editor =& JFactory::getEditor();
echo '
<div class="emailform">
<h2>'.$this->Temakor->megnevezes.'</h2>
<h3>'.$this->Szavazas->megnevezes.'</h3>
<h4>'.JText::_('EMAILSSENDED').'</h4>
<center>
<button type="button" class="btnOK" onclick="location='."'".$this->Akciok['back']."'".';">'.JText::_('RENDBEN').'</button>
</center>
</div>
';
?>