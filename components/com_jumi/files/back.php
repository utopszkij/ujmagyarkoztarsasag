<?php
/**
 * Vissza a felhasználói doku tartalomjegyzékhez link és
 * felhasználói doku tartalomjegyzék megjelenítés
 * A popup ablakban történő tmpl=component -es megjelenítést is támogatja
 * 
 *task=empty  tartalomjegyzékre mutató link megjelenitése
 *task=list   tartalomejygzék megjelenítése     
 */ 
  if (JRequest::getVar('task')=='list') {
    // echo category list
    $db = JFactory::getDBO();
    $db->setQuery('select id,title from #__content where catid=9 order by ordering');
    $res = $db->loadObjectList();
    if ($db->getErrorNum() > 0) $db->stderr();
    echo '<h2>Felhasználói dokumentáció</h2>
    ';
    foreach ($res as $res1) {
      if (JRequest::getVar('tmpl')=='component')
        echo '<p><a href="'.JURI::base().'index.php?optin=com_content&view=article&id='.$res1->id.'&tmpl=component">'.$res1->title.'</a></p>
        ';
      else
        echo '<p><a href="'.JURI::base().'index.php?optin=com_content&view=article&id='.$res1->id.'">'.$res1->title.'</a></p>
        ';
    }
  } else {
    // echi back link 
    $link = JURI::base().'index.php?option=com_jumi&fileid=3&task=list';
    if (JRequest::getVar('tmpl')=='component')
      echo '<center>
      <a href="'.$link.'&tmpl=component">Felhasználói dokumentáció tartalomjegyzék</a>
      </center>
      ';
    else
      echo '<center>
      <a href="'.$link.'">Felhasználói dokumentáció tartalomjegyzék</a>
      </center>
      ';
   }   
?>