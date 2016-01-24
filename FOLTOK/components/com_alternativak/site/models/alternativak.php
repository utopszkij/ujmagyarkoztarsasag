<?php
/**
* @version		$Id: default_modelfrontend.php 125 2012-10-09 11:09:48Z michel $
* @package		Alternativak
* @subpackage 	Models
* @copyright	Copyright (C) 2014, . All rights reserved.
* @license #
*/
 defined('_JEXEC') or die('Restricted access');


jimport('joomla.application.component.modelitem');
jimport('joomla.application.component.helper');

JTable::addIncludePath(JPATH_ROOT.'/administrator/components/com_alternativak/tables');
/**
 * SzavazasokModelSzavazasok
 * @author $Author$
 */
 
 
class AlternativakModelAlternativak  extends JModelItem { 
	protected $context = 'com_alternativak.alternativak';   
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
				$id = $this->getState('alternativak.id');
			}
			// Get a level row instance.
			$table = JTable::getInstance('Alternativak', 'Table');
			// Attempt to load the row.
      if (($id == null) | ($id == 0)) {
         // rekord init felvitelhez
         $user = JFactory::getUser();
         $this->_item = new stdclass();
         $this->_item->id = 0;
         $this->_item->megnevezes = '';
         $this->_item->leiras = '';
         $this->_item->temakor_id = JRequest::getVar('temakor',0);
         $this->_item->szavazas_id = JRequest::getVar('szavazas',0);
         $this->_item->letrehozo = $user->id;
         $this->_item->letrehozva = date('Y-m-d H:i:s');
      } else if ($table->load($id)) {
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
		$table = JTable::getInstance('Alternativak', 'Table');
    $table->bind($source);
    $result = new stdclass();
    foreach( $table as $fn => $fv) 
      $result->$fn = $fv;
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
       $msg .= JText::_('ALTERNATIVANEVKOTELEZO').'<br />';
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
     $user = JFactory::getUser();
     $result = true;
     $table = JTable::getInstance('Alternativak', 'Table');
     if ($this->check($item)) {
       $table->bind($item);
       $table->temakor_id = JRequest::getVar('temakor','0');
       $table->szavazas_id = JRequest::getVar('szavazas','0');
       if ($table->id == 0) {
         $table->letrehozo = $user->id;
         $table->letrehozva = date('Y-m-d H:i:s');
       }
       $result = $table->store();
     } else {
       $result = false;
     }
     return $result;
   }  
} // class
?>