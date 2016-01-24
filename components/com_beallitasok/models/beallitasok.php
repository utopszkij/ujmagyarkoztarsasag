<?php
/**
* @version		$Id: default_modelfrontend.php 125 2012-10-09 11:09:48Z michel $
* @package		Beallitasok
* @subpackage models
* @copyright	Copyright (C) 2014, . All rights reserved.
* @license #
*/
 defined('_JEXEC') or die('Restricted access');


jimport('joomla.application.component.modelitem');
jimport('joomla.application.component.helper');

/**
 * BeallitasokModelBeallitasok
 * @author $Author$
 */
class BeallitasokModelBeallitasok  extends JModelItem { 
  private $msg = '';
  /**
   * beolvas egy rekordot
   */      
  public function getItem($id) {
    $db = JFactory::getDBO();
    $db->setQuery('select * from #__beallitasok');
    $result = $db->loadObject();
    if (!$result) {
      $result = new stdclass();
      $result->id = 0;
      $result->json = '{}';
    }
    return $result;
  }
  /** 
   * message getter
   * @return string
   */         
  public function getMessage() {
    return $this->msg;
  }
  /**
   * ellenörzés felvitel előtt
   * @return bollen 
   * @param mysql record object $item
   */            
  public function check($item) {
     $this->msg = '';
     return true;
  }
  /** törölhető az adott rekord?
   * @param mysql record object
   * @returnt boolean
   */
  public function delete($item) {
    return;
  }          
  
  /**
   * tárolja a képernyőn beirt adatokat
   */      
  public function save($item) {
    if ($this->check($item)) {
       $db = JFactory::getDBO();
       $db->setQuery('delete from #__beallitasok');
       $db->query();
       $db->setQuery('insert into #__beallitasok (id,json) 
       values 
       (1,'."'".$item->json."'".')
       ');
       $db->query();
       if ($db->getErrorNum() > 0) $db->stderr(); 
       $result = true;
    } else {
       $result = false;
    }
    return $result;
  }	
}
?>