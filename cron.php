<?php
/**
 * cron -ban futtatandó script
 * a com_szavazasok levél küldő rendszerhez tartozik, 
 * ez végzi a levelek fizikai szétküldését
 * egszerre 20 levelet küld el. Küldési hiba esetén ötször próbálkozik
 */     
 define( '_JEXEC', 1 );
 define('JPATH_BASE', dirname(__FILE__) );
 define( 'DS', '/');
 require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
 require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
 JDEBUG ? $_PROFILER->mark( 'afterLoad' ) : null;
 $mainframe =& JFactory::getApplication('site');
 $mainframe->initialise();
 $params = &JComponentHelper::getParams('com_ammvc');
 $mail = JFactory::getmailer();
 $db = JFactory::getDBO();
 $db->setQuery('select l.targy, l.szoveg,k.cimzett_email, k.id
 from #__levelkuldesek k
 inner join #__levelek l on l.id = k.level_id
 where k.status <> "ok" and probalkozas < 5
 order by idopont limit 20');
 $res = $db->loadObjectList();
 foreach ($res as $res1) {
   $email = $res1->cimzett_email;
   $targy = $res1->targy;
   $szoveg = str_replace('{naplo_id}',$res1->id,$res1->szoveg);

   //+ TEST
   //$szoveg = 'TEST li-de.tk hírlevél orig to:'.$email.'<br />'.$szoveg;
   //$email = 'tibor.fogler@gmail.com';
   //- TEST

   $mail->clearAllRecipients();
   $mail->addRecipient($email);
   $mail->isHTML(true);
   $mail->setBody($szoveg);
   $mail->setSubject($targy);
   $mail->setSender('li-de@adatmagus.hu');
   if ($mail->send()===true) {
     $db->setQuery('update #__levelkuldesek
     set status = "ok",idopont="'.date("Y-m-d H:i:s").'"
     where id="'.$res1->id.'"'
     );
     $db->query();
   } else {
     $db->setQuery('update #__levelkuldesek
     set status="error", probalkozas = probalkozas + 1, hibauzenet = "send error"
     where id="'.$res1->id.'"');
     $db->query();
   }  
 }
 echo 'szavazas email küldő futott. Feldolgozott feladat:'.count($res).' '.date('Y-m-d H:i:s');
?>