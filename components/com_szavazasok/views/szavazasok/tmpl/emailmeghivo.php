<?php
echo '
<form name="adminform" id="formEmailes" method="post" action="'.JURI::base().'index.php?option=com_szavazasok&view=szavazasok&task=meghivotkuld">
   <h2>'.JText::_('EMAIL_SZAVAZAS_TITLE').'</h2>
   <h3>'.$this->Szavazas->megnevezes.'</h3>
   <input type="hidden" name="temakor" value="'.$this->Temakor.'" />
   <input type="hidden" name="szavazas" value="'.$this->Szavazas->id.'" />
   <input type="hidden" name="felado" value="'.$this->Felado.'" />
   <p>'.JText::_('EMAIL_SZAVAZAS_CIMEK').'</p>
   <p><textarea name="cimek" cols="80" rows="5">'.$this->Cimek.'</textarea></p>
   <p>'.JText::_('EMAIL_SZAVAZAS_SZOVEG').'</p>
   <textarea name="szoveg" cols="80" rows="5">'.$this->Szoveg.'</textarea>
   <p>'.JText::_('EMAIL_SZAVAZAS_LABLEC').'&nbsp;&nbsp;'.$this->Felado.'</p>
   <center>
     <button type="submit" class="btnOK">'.JText::_('SEND').'</button>
     &nbsp;
     <button type="button" class="btnCancel" onclick="location='."'$this->CancelLink'".'">'.JText::_('CANCEL').'</button>
   </center>
</form>
'; 
?>
