<?php
/* ez egy include file amit több képernyő tmpl -is
   behív.  Célja a kunena, jcomment és jdownloader hívó gomb megjelenítése
   a temakor, szavazas, id JRequest paraméterek alapján és
   a $this->temakorGroupId alapján
   szükség esetén kreálja a kategoriákat 
    
*/

require_once JPATH_BASE. "/administrator/components/com_content/models/article.php";
$artycleData = false;
$db = JFactory::getDBO();
$option = JRequest::getVar('option','');
$temakor = JRequest::getVar('temakor','');
$szavazas = JRequest::getVar('szavazas','');
$id = JRequest::getVar('id','');
if ($id == '') $id = JRequest::getVar('user_id');
$forumAlias = 'otletlada';
$articleAlias = '';
$filesAlias = '';
$eventsAlias = 'none';
if (($this->TemakorGroupId == '') | ($this->TemakorGroupId == 0)) {
  $temakorGroupId = 1;
} else {
  $temakorGroupId = $this->TemakorGroupId;
}
if (($option == 'com_kepviselok') | ($option == 'com_kepviselojeloltek')) {
   // képviselő
   $forumAlias = 'K'.$id;
   $filesAlias = 'k'.$id;
   $articleAlias = 'k'.$id;
   $eventsAlias = 'none';
   $kuser = JFactory::getUser($id);
} else if (($option == 'com_temakorok') | 
           ($option == 'com_szavazasok') |
           ($option == 'com_alternativak')) {
  if ($szavazas > 0) {
    $forumAlias = 'SZ'.$szavazas;
    $filesAlias = 'sz'.$szavazas;
    $articleAlias = 'sz'.$szavazas;
    $eventsAlias = 't'.$temakor;
  } else if ($temakor > 0) {
    $forumAlias = 'T'.$temakor;
    $filesAlias = 't'.$temakor;
    $articleAlias = 't'.$temakor;
    $eventsAlias = 't'.$temakor;
  }  
} 
echo '<center>
A demokrácia lényege nem a szavazás, hanem a konszenzusra törekvő eszmecsere!<br />
';

$articleId = 0;
$kunenaCategoryId = 0;
$jdownloadCategoryId = 0;
$db->setQuery('select id from #__content where alias="'.$articleAlias.'"');
$res = $db->loadObject();
if ($res) $articleId = $res->id; 
$db->setQuery('select id from #__kunena_categories where alias="'.$forumAlias.'"');
$res = $db->loadObject();
if ($res) $kunenaCategoryId = $res->id; 
$db->setQuery('select id from #__jdownloads_categories where alias="'.$filesAlias.'"');
$res = $db->loadObject();
if ($res) $jdownloadCategoryId = $res->id; 
$db->setQuery('select id from #__categories where alias="'.$eventsAlias.'"');
$res = $db->loadObject();
if ($res) $jeventsCategoryId = $res->id; 

$artycleUrl = JURI::base().'index.php?option=com_content&view=article&id='.$articleId;
$forumUrl = JURI::base().'index.php?option=com_kunena&view=category&catid='.$kunenaCategoryId;
$filesUrl = JURI::base().'index.php?option=com_jdownloads&view=category&catid='.$jdownloadCategoryId;

//$eventsUrl = //JURI::base().'index.php?option=com_jevents&catids='.$jeventsCategoryId.'&task=month.calendar&Itemid=999';
$eventsUrl = JURI::base().'esemenyek';

if ($articleId != 0)
  echo '<a class="akcioGomb btnForum " href="'.$artycleUrl.'">'.JText::_('COMMENTS').'</a>&nbsp;
  ';

/*
if ($kunenaCategoryId != 0)
  echo  '<a class="akcioGomb btnForum" href="'.$forumUrl.'">'.JText::_('FORUM').'</a>&nbsp;
  ';
*/
  if ($jdownloadCategoryId != 0)
  echo  '<a class="akcioGomb btnFiles" href="'.$filesUrl.'">'.JText::_('FILES').'</a>&nbsp;
  ';
if ($jeventsCategoryId != 0)
  echo  '<a class="akcioGomb btnEvents" href="'.$eventsUrl.'">'.JText::_('EVENTS').'</a>&nbsp;
  ';

echo '</center>
';
   
?>