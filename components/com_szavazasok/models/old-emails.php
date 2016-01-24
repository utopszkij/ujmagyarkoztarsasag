<?php
/**
* @version		$Id: default_modelfrontend.php 125 2012-10-09 11:09:48Z michel $
* @package		Szavazasok
* @subpackage 	Models
* @copyright	Copyright (C) 2014, . All rights reserved.
* @license #
*/
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modelitem');
jimport('joomla.application.component.helper');
request_once (JPATH_ROOT.'/components/com_temakorok/models/temakorok.php');

/**
 * SzavazasokModelSzavazasok
 * @author $Author$
 */
 
 
class SzavazasokModelEmails  extends JModelItem {
  function __construct() {
    parent::__construct();
    $q = JFactory::getDBO();
    $q->setQuery('
    CREATE TABLE IF NOT EXISTS #__levelek (
     `id` INT(11) NOT NULL AUTO_INCREMENT, 
     `targy` VARCHAR(120), 
     `szoveg` TEXT, 
     `szavazas_id` INT(11), 
     `temakor_id` INT(11), 
     `letrehozo` INT(11), 
     `letrehozva` DATETIME, 
     PRIMARY KEY (`id`)
     ); 
  ');
    if (!$q->query()) {
        echo '<p class="errorMsg">'.$q->getErrorMsg().'</p>';
        exit();
    }
    $q->setQuery('
    CREATE TABLE IF NOT EXISTS #__levelkuldesek (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `level_id` int(11),
    `cimzett_email` varchar(80),
    `cimzett_nev` varchar(80),
    `status` varchar(6),
    `hibauzenet` varchar(120),
    `idopont` datetime,
    `probalkozas` int(11),
    PRIMARY KEY (`id`),
    UNIQUE KEY `index1` (`level_id`,`cimzett_email`)
    )  
    ');
    if (!$q->query()) {
        echo '<p class="errorMsg">'.$db->getErrorMsg().'</p>';
        exit();
    }
  }
  /**
   * Törli az elavult log bejegyzéseket
   */       
  public function deleteOldEmailLog() {
    $q = JFactory::getDBO();
    $q->setQuery('delete 
    from #__levelkuldesek 
    where idopont < "'.date('Y-m-d',time() - 500*24*60*60).'" and idopont > 0');
    if (!$q->query()) {
        echo '<p class="errorMsg">'.$q->getErrorMsg().'</p>';
        exit();
    }
  }  
  /**
   * a paraméterben lévő szavazason szavazas jogosultak cimeire szoló
   * levél küldési feladatokat belökdősi az email que-ba
   * @return void
   * @param szavazas_record $szavazas 
   * @param string $subject
   * @param text $szoveg           
   */      
  public function sendSzavazasToEmailQue($szavazas, $subject, $mailbody) {
    $q = JFactory::getDBO();
    $user = JFactory::getUser();
    // irás a levelek táblába, levelek_id lekérése
    $q->setQuery('insert into #__levelek
    (`targy`,`szoveg`,`szavazas_id`,`temakor_id`,`letrehozo`,`letrehozva`)
    values 
    ("'.$q->escape($subject).'",
     "'.$q->escape($mailbody).'",
     "'.$szavazas->id.'",
     "'.$szavazas->temakor_id.'",
     "'.$user->id.'","'.date('Y-m-d H:i:s').'")
    ');
    if (!$q->query()) {
        echo '<p class="errorMsg">'.$q->getErrorMsg().'</p>';
        exit();
    }
    $level_id = $q->insertid();
    // irás a #__levelkuldesek táblába
    //   regisztrált tagok
    if ($szavazas->szavazok == 1) {
      $q->setQuery('insert ignore into #__levelkuldesek
      select 0 id,
             "'.$level_id.'",
             email,
             name,
             "" status,
             "" hibauzenet,
             0 idopont,
             0 probalkozas
      from #__users
      where block=0
      ');
      if (!$q->query()) {
          echo '<p class="errorMsg">'.$q->getErrorMsg().'</p>';
          exit();
      }
    }
    //   témakör tagok
    if ($szavazas->szavazok == 2) {
      $db->setQuery('insert ignore into #__levelkuldesek
      select 0 id,
             "'.$level_id.'",
             u.email,
             u.name,
             "" status,
             "" hibauzenet,
             0 idopont,
             0 probalkozas
      from #__tagok t
      inner join #__users u on u.id = t.user_id
      where t.id = "'.$szavazas->temakor_id.'" and u.block=0
      ');
      if (!$q->query()) {
          echo '<p class="errorMsg">'.$q->getErrorMsg().'</p>';
          exit();
      }
    }
    //   témakör tulajdonosának tagjai
    // FIGYELEM!!  egy email többször is bekerülhet a táblába ha egy temakor szülöjénél is
    // tag ugyanaz a user!
    if ($szavazas->szavazok == 3) {
      $temakorModel = new TemakorokModelTemakorok();  
      $temakor = $temakorModel->getItem($szavazas->temakor_id)  
      while ($temakor) {
        $db->setQuery('insert ignore into #__levelkuldesek
        select 0 id,
               "'.$level_id.'",
               u.email,
               u.name,
               "" status,
               "" hibauzenet,
               0 idopont,
               0 probalkozas
        from #__tagok t
        inner join #__users u on u.id = t.user_id
        where t.id = "'.$temakor->id.'" and u.block=0
        ');
        if (!$q->query()) {
            echo '<p class="errorMsg">'.$q->getErrorMsg().'</p>';
            exit();
        }
        $temakor = $temakorModel->getItem($temakor->szulo);
      }
    }  
  }
                 
} // class
?>