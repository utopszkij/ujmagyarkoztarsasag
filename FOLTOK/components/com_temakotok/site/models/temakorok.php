<?php
/**
* @version		$Id: default_modelfrontend.php 125 2012-10-09 11:09:48Z michel $
* @package		Temakorok
* @subpackage 	Models
* @copyright	Copyright (C) 2014, . All rights reserved.
* @license #
*/
 defined('_JEXEC') or die('Restricted access');


jimport('joomla.application.component.modelitem');
jimport('joomla.application.component.helper');

JTable::addIncludePath(JPATH_ROOT.'/administrator/components/com_temakorok/tables');
/**
 * TemakorokModelTemakorok
 * @author $Author$
 */
 
 
class TemakorokModelTemakorok  extends JModelItem { 

	
	
	protected $context = 'com_temakorok.temakorok';   
	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	public function populateState()
	{
		$app = JFactory::getApplication();

		//$params	= $app->getParams();

		// Load the object state.
		$id	= JRequest::getInt('id');
		$this->setState('temakorok.id', $id);

		// Load the parameters.
		//TODO: componenthelper
		//$this->setState('params', $params);
	}

	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id	.= ':'.$this->getState('temakorok.id');

		return parent::getStoreId($id);
	}
	
	/**
	 * Method to get an ojbect.
	 *
	 * @param	integer	The id of the object to get.
	 *
	 * @return	mixed	Object on success, false on failure.
	 */
	public function &getItem($id = null)	{
		if ($this->_item === null) {
			$this->_item = false;
			if (empty($id)) {
				$id = $this->getState('temakorok.id');
			}
			// Get a level row instance.
			$table = JTable::getInstance('Temakorok', 'Table');
			// Attempt to load the row.
      if ($table->load($id)) {
				// Check published state.
				if ($published = $this->getState('filter.published')) {
					if ($table->state != $published) {
						return $this->_item;
					}
				}
				// Convert the JTable to a clean JObject.
				$this->_item = JArrayHelper::toObject($table->getProperties(1), 'JObject');
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
		$table = JTable::getInstance('Temakorok', 'Table');
    $table->bind($source);
    $result = new stdclass();
    foreach( $table as $fn => $fv) $result->$fn = $fv;
    return $result;
  }
  /**
   * adat ellenörzés tárolás elött
   * @param mysql record object
   * @return boolena
   */
   public function check($item) {
     $result = true;
     if ($item->megnevezes == '') {
       $result = false;
       $this->setError(JText::_('TEMAKORNEVKOTELEZO'));
     }
     return $result;
   }            
  /**
   * adat tárolás ellenörzéssel
   * @param mysql record object   
   * @return boolean     
   */
   public function store($item) {
     $result = true;
     $table = JTable::getInstance('Temakorok', 'Table');
     if ($this->check($item)) {
       $table->bind($item);
       $result = $table->store();
       if ($result) {
         // alternativák kitárolása
       }
     } else {
       $result = false;
     }
     return $result;
   }    
	 /**
	  * témakör és kapcsolodó rekordok törlése
	  */
   public function delete($item) {
     $db = JFactory::getDBO();
     $errorMsg = '';
     $temakor_id = $item->id;
     // lock tables
     $db->setQuery('lock tables
     #__tagok write,
     #__kepviselok write,
     #__alternativak write,
     #__szavazatok write,
     #__szavazok write,
     #__szavazasok write,
     #__temakorok write');
     if (!$db->query()) {
       $errorMsg .= $db->getErrorMsg().'<br />';
     }
     // begin transaction
     $db->setQuery('start transaction');
     if (!$db->query()) {
       $errorMsg .= $db->getErrorMsg().'<br />';
       $db->setQuery('rollback');
       $db->query();
       return false;
     }
     // tagok törlése
     $db->setQuery('delete from #__tagok
     where temakor_id="'.$temakor_id.'"');
     if (!$db->query()) {
       $errorMsg .= $db->getErrorMsg().'<br />';
       $db->setQuery('rollback');
       $db->query();
       return false;
     }
     // képviselők törlése
     $db->setQuery('delete from #__kepviselok
     where temakor_id="'.$temakor_id.'"');
     if (!$db->query()) {
       $errorMsg .= $db->getErrorMsg().'<br />';
       $db->setQuery('rollback');
       $db->query();
       return false;
     }
     // szavazás alternativák törlése
     $db->setQuery('delete from #__alternativak
     where temakor_id="'.$temakor_id.'"');
     if (!$db->query()) {
       $errorMsg .= $db->getErrorMsg().'<br />';
       $db->setQuery('rollback');
       $db->query();
       return false;
     }
     // szavazatok törlése
     $db->setQuery('delete from #__szavazatok
     where temakor_id="'.$temakor_id.'"');
     if (!$db->query()) {
       $errorMsg .= $db->getErrorMsg().'<br />';
       $db->setQuery('rollback');
       $db->query();
       return false;
     }
     // szavazasjelzok törlése
     $db->setQuery('delete from #__szavazok
     where temakor_id="'.$temakor_id.'"');
     if (!$db->query()) {
       $errorMsg .= $db->getErrorMsg().'<br />';
       $db->setQuery('rollback');
       $db->query();
       return false;
     }
     // szavazások törlése
     $db->setQuery('delete from #__szavazasok
     where temakor_id="'.$temakor_id.'"');
     if (!$db->query()) {
       $errorMsg .= $db->getErrorMsg().'<br />';
       $db->setQuery('rollback');
       $db->query();
       return false;
     }
     // temakor törlése
     $db->setQuery('delete from #__temakorok
     where id="'.$temakor_id.'"');
     if (!$db->query()) {
       $errorMsg .= $db->getErrorMsg().'<br />';
       $db->setQuery('rollback');
       $db->query();
       return false;
     }
     if ($errorMsg != '') $this->setError($errorMsg);
     // end transaction
     $db->setQuery('commit');
     if (!$db->query()) {
       $errorMsg .= $db->getErrorMsg().'<br />';
     }
     //unlock tables
     $db->setQuery('unlock tables');
     if (!$db->query()) {
       $errorMsg .= $db->getErrorMsg().'<br />';
     }
     return ($errorMsg == '');
   }         	
}
?>