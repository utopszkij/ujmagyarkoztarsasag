<?php
/**
 * szavazoknak küldendő körlevél form
 * bemenet:
 * $this->Szavazas
 *      .>Temakor 
 *      ->Akciok      [cancel,send]
 */ 
// no direct access
defined('_JEXEC') or die('Restricted access');
$editor =& JFactory::getEditor();
$user = JFactory::getUser();
$s = '<p><a href="'.JURI::base().'index.php'.
'?option=com_alternativak&task=browse'.
'&szavazas='.$this->Szavazas->id.
'&temakor='.$this->Szavazas->temakor_id.'">'.$this->Szavazas->megnevezes.'</a></p>
<div>'.$this->Szavazas->leiras.'</div>
<br /><br />
<p><a href="'.JURI::base().'index.php?option=com_alternativak&task=browse'.
'&szavazas='.$this->Szavazas->id.
'&temakor='.$this->Szavazas->temakor_id.'">Látogass el a szavazás oldalára!</a></p>
<br /><br />
<p>Ha nem akarsz több ilyen hírlevelet kapni, akkor 
  <a href="'.JURI::base().'index.php?option=com_szavazasok&view=szavazasok&task=unsub&id={naplo_id}">Kattints ide!</a> 
  &nbsp;(Ez a letíltás nem vonatkozik a hozzászólásokról, fórum bejegyzésekről küldött értesitő levelekre, amennyiben ilyeneket kértél a hozzászólásnál, fórum bejegyzésnél)</p>
';

//DBG echo '<pre><code>'.$s.'</code></pre>';

echo '
<div class="emailform">
<form action="'.$this->Akciok['send'].'" method="post">
<h2>'.$this->Temakor->megnevezes.'</h2>
<h3>'.$this->Szavazas->megnevezes.'</h3>
<h4>'.JText::_('EMAILFORM').'</h4>
<p>'.JText::_('SUBJECT').':<br /><input type="text" name="subject" size="60" value="Új szavazás a li-de rendszerben" /></p>
<p>'.JText::_('MAILBODY').':<br />
  '.$editor->display('mailbody', $s, '550', '400', '60', '20', false).'
</p>
<center>
   <button type="submit" class="btnOK">'.JText::_('SEND').'</button>&nbsp;
   <button type="button" class="btnCancel" onclick="location='."'".$this->Akciok['cancel']."'".';">'.JText::_('CANCEL').'</button>
</center>
</form>
</div>
';
?>