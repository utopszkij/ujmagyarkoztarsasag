<?php
/**
 * echopath modul
 * feladata témakör utvanl és szavazás kattintható linkes utvonal
 * megjelenítése  illetve sessionban történő tárolása
 */
 $db = JFactory::getDBO();
 $session = JFactory::getSession();
 $utvonal = '';
 $utvonalEnd = '';
 $szavazas = JRequest::getVar('szavazas',0);
 $temakor = JRequest::getVar('temakor',0);
 // ha JRequest 'szavazas' érkezik akkor ebből épiti fel az utvonalat
 $szavazas = JRequest::getVar('szavazas',0);
 if ($szavazas != 0) {
    $db->setQuery('SELECT id,megnevezes,temakor_id from #__szavazasok WHERE id="'.$szavazas.'"');
    $szavazas = $db->loadObject();
    $utvonalEnd = '<a href="'.JURI::base().'index.php?option=com_alternativak&view=alternativaklist'.
       '&szavazas='.$szavazas->id.
       '&temakor='.$szavazas->temakor_id.'">'.$szavazas->megnevezes.'</a>';
    $db->setQuery('SELECT id,megnevezes,szulo FROM #__temakorok WHERE id="'.$szavazas->temakor_id.'"');
    $temakor = $db->loadObject();
    while ($temakor) {
      $utv = '<a href="'.JURI::base().'index.php?option=com_szavazasok&view=szavazasoklist'.
       '&temakor='.$temakor->id.'">'.$temakor->megnevezes.'</a>';
      if ($utvonal == '')
        $utvonal = $utv;
      else
        $utvonal = $utv.'&nbsp;&gt;&nbsp;'.$utvonal;
      $db->setQuery('SELECT id,megnevezes,szulo FROM #__temakorok WHERE id="'.$temakor->szulo.'"');
      $temakor = $db->loadObject();
    }
    $utvonal = '<a href="index.php?option=com_temakorok&view=temakoroklist">'.JText::_('TEMAKOROK').'</a>&nbsp;&gt;&nbsp;'.$utvonal;
} else {
   $temakor = JRequest::getVar('temakor',0);
   if ($temakor != 0) {
      // ha JRequest 'temakor' érkezik akkor ebből épiti fel az utvonalat
      $db->setQuery('SELECT id,megnevezes,szulo FROM #__temakorok WHERE id="'.$temakor.'"');
      $temakor = $db->loadObject();
      $utvonalEnd = '<a href="'.JURI::base().'index.php?option=com_szavazasok&view=szavazasoklist'.
        '&temakor='.$temakor->id.'">'.$temakor->megnevezes.'</a>';
      $db->setQuery('SELECT id,megnevezes,szulo FROM #__temakorok WHERE id="'.$temakor->szulo.'"');
      $temakor = $db->loadObject();
      while ($temakor) {
        $utv = '<a href="'.JURI::base().'index.php?option=com_szavazasok&view=szavazasoklist'.
        '&temakor='.$temakor->id.'">'.$temakor->megnevezes.'</a>';
        if ($utvonal == '')
          $utvonal = $utv;
        else
          $utvonal = $utv.'&nbsp;&gt;&nbsp;'.$utvonal;
        $db->setQuery('SELECT id,megnevezes,szulo FROM #__temakorok WHERE id="'.$temakor->szulo.'"');
        $temakor = $db->loadObject();
      }
      $utvonal = '<a href="index.php?option=com_temakorok&view=temakoroklist">'.JText::_('TEMAKOROK').'</a>&nbsp;&gt;&nbsp;'.$utvonal;
   } else { 
      // ha a fentiek egyike sem érkezik akkor a sessionból hozza fel az ott lévő tárolt utvonalat
      if (JRequest::getVar('option') != 'com_temakorok')
        $utvonal = $session->get('utvonal');
   }
 }
 // tárolja/frissiti a sessionban tárolt utvonal adatot
 if (($utvonal == '') & ($utvonalEnd != ''))
     $session->set('utvonal',$utvonalEnd);
 else if (($utvonal != '') & ($utvonalEnd == ''))
     $session->set('utvonal',$utvonal);
 else if (($utvonal == '') & ($utvonalEnd == ''))
     $session->set('utvonal','');
 else {
     if (substr($utvonal,-10) == '&gt;&nbsp;')
       $session->set('utvonal',$utvonal.$utvonalEnd);
     else    
       $session->set('utvonal',$utvonal.'&nbsp;&gt;&nbsp;'.$utvonalEnd);
 } 
if ($utvonal == '')
      $utvonal = '<a href="index.php?option=com_temakorok&view=temakoroklist">'.JText::_('TEMAKOROK').'</a>';
     
 
 // megjelenít
 //if ($utvonal != '') 
    echo '<div class="utvonal">'.JText::_('Útvonal:').' '.$utvonal.'</div>';
     
?>