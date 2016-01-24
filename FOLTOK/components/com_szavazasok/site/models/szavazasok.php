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

JTable::addIncludePath(JPATH_ROOT.'/administrator/components/com_szavazasok/tables');
/**
 * SzavazasokModelSzavazasok
 * @author $Author$
 */
 
 
class SzavazasokModelSzavazasok  extends JModelItem { 
	protected $context = 'com_szavazasok.szavazasok';   
	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	public function populateState()	{
		$app = JFactory::getApplication();
		//$params	= $app->getParams();
		// Load the object state.
		$id	= JRequest::getInt('id');
		$this->setState('szavazasok.id', $id);
		// Load the parameters.
		//TODO: componenthelper
		//$this->setState('params', $params);
	}

	protected function getStoreId($id = '')	{
		// Compile the store id.
		$id	.= ':'.$this->getState('szavazasok.id');
		return parent::getStoreId($id);
	}
	
	/**
	 * Method to get an ojbect.
	 *
	 * @param	integer	The id of the object to get.
	 *
	 * @return	mixed	Object on success, false on failure. FIGYELEM!!! alternativák tömb is!!!!!
	 */
	public function &getItem($id = null){
		$db = JFactory::getDBO();
    if ($this->_item === null) {
			$this->_item = false;
			if (empty($id)) {
				$id = $this->getState('szavazasok.id');
			}
			// Get a level row instance.
			$table = JTable::getInstance('Szavazasok', 'Table');
			// Attempt to load the row.
      if (($id == null) | ($id == 0)) {
         // rekord init felvitelhez
         $user = JFactory::getUser();
         $this->_item = new stdclass();
         $this->_item->id = 0;
         $this->_item->megnevezes = '';
         $this->_item->leiras = '';
         $this->_item->letrehozo = $user->id;
         $this->_item->letrehozva = date('Y-m-d H:i:s');
         $this->_item->vita1_vege = date('Y-m-d 23:59:59',time()+(5*24*60*60));
         $this->_item->vita2_vege = date('Y-m-d 23:59:59',time()+(10*24*60*60));
         $this->_item->szavazas_vege = date('Y-m-d 23:59:59',time()+(15*24*60*60));
         $this->_item->vita1 = 1;
         $this->_item->vita2 = 0;
         $this->_item->szavazas = 0;
         $this->_item->lezart = 0;
         $this->_item->alternativak = array();
      } else if ($table->load($id)) {
				// Check published state.
				if ($published = $this->getState('filter.published')) {
					if ($table->state != $published) {
						return $this->_item;
					}
				}
				// Convert the JTable to a clean JObject.
				$this->_item = JArrayHelper::toObject($table->getProperties(1), 'JObject');
        $db->setQuery('select * from #__alternativak where szavazas_id = "'.$id.'"');
        $this->_item->alternativak = $db->loadObjectList();
			} else if ($error = $table->getError()) {
				$this->setError($error);
			}
		}
		return $this->_item;
	}
/**
   * adat olvasás a $source assotiativ tömbből
   * @param array   
   * @return mysql record object
   */         
  public function bind($source) {
    $i = 0;
		$table = JTable::getInstance('Szavazasok', 'Table');
    $table->bind($source);
    $result = new stdclass();
    foreach( $table as $fn => $fv) 
      $result->$fn = $fv;
      
    // allapot radiobutton kezelése
    $result->vita1=0;
    $result->vita2=0;
    $result->szavazas=0;
    $result->lezart=0;
    if (JRequest::getVar('allapot') == 'vita1') $result->vita1 = 1;  
    if (JRequest::getVar('allapot') == 'vita2') $result->vita2 = 1;  
    if (JRequest::getVar('allapot') == 'szavazas') $result->szavazas = 1;  
    if (JRequest::getVar('allapot') == 'lezart') $result->lezart = 1;
      
    $result->alternativak = array();
    for ($i=0; $i<5; $i++) {
      if (JRequest::getVar('alternativa'.$i)) {
        $result->alternativak[$i] = array();
        $result->alternativak[$i]['nev'] = JRequest::getVar('alternativa'.$i);
        $result->alternativak[$i]['leiras'] = JRequest::getVar('leiras'.$i);
      } else {
        $result->alternativak[$i] = array();
      }
    }  
    return $result;
  }
  /**
   * adat ellenörzés tárolás elött
   * @param mysql record object
   * @return boolena
   */
   public function check($item) {
     $result = true;
     $msg = '';
     if ($item->megnevezes == '') {
       $result = false;
       $msg .= JText::_('SZAVAZASNEVKOTELEZO').'<br />';
     }
     if (($item->vita2_vege < $item->vita1_vege) |
         ($item->szavazas_vege < $item->vita2_vege) |
         ($item->vita1_vege < $item->letrehozva) ) {
         $result = false;
         $msg .= JText::_('ROSSZSZAVAZASDATUMVISZONYOK').'<br />';
     } 
     if (($item->vita1 + $item->vita2 + $item->szavazas + $item->lezart) != 1) {
         $result = false;
         $msg .= JText::_('ROSSZSZAVAZASALLAPOT').'<br />';
     }
     if ($msg != '')
        $this->setError($msg);
     return $result;
   }            
  /**
   * adat tárolás ellenörzéssel
   * @param mysql record object   
   * @return boolean     
   */
   public function store($item) {
     $i = 0;
     $ujfelvitel = ($item->id == 0);
     $user = JFactory::getUser();
     $db = JFactory::getDBO();
     $result = true;
     $table = JTable::getInstance('Szavazasok', 'Table');
     if ($this->check($item)) {
       $table->bind($item);
       $table->temakor_id = JRequest::getVar('temakor','0');
       if ($table->id == 0) {
         $table->letrehozo = $user->id;
         $table->letrehozva = date('Y-m-d H:i:s');
       }
       $result = $table->store();
       if (($ujfelvitel) & (count($item->alternativak) == 5)) {
         for ($i=0; $i<5; $i++) {
           if ($item->alternativak[$i]['nev'] != '') {
              $item->alternativak[$i]['nev'] = str_replace('"','',$item->alternativak[$i]['nev']);
              $item->alternativak[$i]['nev'] = str_replace("\n",'',$item->alternativak[$i]['nev']);
              $item->alternativak[$i]['nev'] = str_replace("\r",'',$item->alternativak[$i]['nev']);
              $item->alternativak[$i]['leiras'] = str_replace('"','',$item->alternativak[$i]['leiras']);
              $item->alternativak[$i]['leiras'] = str_replace("\n",'<br />',$item->alternativak[$i]['leiras']);
              $item->alternativak[$i]['leiras'] = str_replace("\r",'',$item->alternativak[$i]['leiras']);
              $db->setQuery('insert into #__alternativak 
              (temakor_id,szavazas_id,megnevezes,leiras,letrehozo,letrehozva) 
              values 
              ("'.JRequest::getVar('temakor','0').'",
               "'.$table->id.'",
               "'.$item->alternativak[$i]['nev'].'",
               "'.$item->alternativak[$i]['leiras'].'",
               "'.$user->id.'",
               "'.date('Y-m-d').'")
              ');
              $db->query();
           }
         }
       }
     } else {
       $result = false;
     }
     return $result;
   }  
} // class
?>