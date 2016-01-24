<?php
/**
* @version        $Id: default_modelfrontend.php 125 2012-10-09 11:09:48Z michel $
* @package        Joomla site
* @subpackage amcomponent defview Model
* @copyright    Copyright (C) 2013, . All rights reserved.
* @license        GNU/GPL
*/
 defined('_JEXEC') or die('Restricted access');


jimport('joomla.application.component.modelitem');
jimport('joomla.application.component.helper');

JTable::addIncludePath(JPATH_COMPONENT.'/tables');
/**
 * AlapsModelAlaps
 * @author $Author$
 */
 
 
class MasodikModelMasodik  extends JModelItem { 
    protected $viewName = '';
    protected $errorMsg = '';
    protected $context = 'com_defview.defview';   
  // ----------------- config ---------------
  protected $name = 'defview';   // tableName
  // ----------------- config ---------------
  public function setState() {
  }
  public function setViewName($value) {
    $this->viewName = $value;
  }
    /**
     * Method to get an record ojbect.
     * @param    integer    The id of the object to get.
     * @return    mixed    Object on success, false on failure.
     */
    public function getItem($id)    {
    JTable::addIncludePath(JPATH_COMPONENT.DS.'models'.DS.'tables');
    $table = JTable::getInstance(ucfirst($this->name), 'Table');
    if ($id == 0) {
      // init new record for insert
      $this->_item = new stdclass();
      $this->_item->id = 0;
      
    } else {
            $this->_item = false;
            if ($table->load($id)) {
                $this->_item = JArrayHelper::toObject($table->getProperties(1), 'JObject');
            } else if ($error = $table->getError()) {
                $this->setError($error);
            }
        }        
        return $this->_item;
    }
  /**
   * check $data before save it
   * if error then return false and set $this->errorMsg   
   * @return bool   
   * @param array $data index is fieldName   
   */         
  public function check($data) {
    // if hiba van:
    //   $this->errorMsg. = '<br />HIBAÜZENET';
    //   return false
    return true;
  }
  /**
   * check can delete $data
   * return true or false and $this->errormsg
   * @return bool   
   * @param array $data index is fieldName   
   */         
  public function canDelete($id) {
    // if hiba van:
    //   $this->errorMsg. = '<br />HIBAÜZENET';
    //   return false
    return true;
  }
  /**
   * errormsg getter
   * @return string   
   */      
  public function getErrorMsg() {
    return $this->errorMsg;
  }
  /**
   * save $data
   * if error then set $this->errormsg   
   * @return bool   
   * @param array $data index is fieldName   
   */      
  public function save($data) {
    JTable::addIncludePath(JPATH_COMPONENT.DS.'models'.DS.'tables');
    $table = JTable::getInstance(ucfirst($this->name), 'Table');
    if ($table->save($data))
      return true;
    else {
      $this->errorMsg .= '<br>'.JText::_(strtoupper($this->name).'_ERROR_IN_SAVE');
      return false;
    }    
  }
  /**
   * delete record by is
   */      
  public function delete($id) {
    JTable::addIncludePath(JPATH_COMPONENT.DS.'models'.DS.'tables');
    $table = JTable::getInstance(ucfirst($this->name), 'Table');
    if (!$table->delete($id)) {
      $this->errorMsg .= JText::_(strtoupper($this->name).'_ERROR_IN_DELETE');
      return false;
    } else {
      return true;
    }
  }
  /**
   * get items
   */      
  public function getItems($ordering,$limitstart,$limit,$filterStr) {
    if ($ordering=='') $ordering = 'id';
    if ($limitstart=='') $limitstart = 0;
    if ($limit=='') $limit = 20;
    if ($filterStr=='')
      $where = '';
    else
      $where = 'where title like "%'.$filterStr.'%"';  
    $result = array();
    $db = JFactory::getDBO();
    $db->setQuery('select *
    from #__'.$this->name.'
    '.$where.'
    order by '.$ordering.' limit '.$limitstart.','.$limit);
    $result = $db->loadObjectList();
    return $result;
  }
  /**
   * get total record count
   */      
  public function getTotal($filterStr) {
    if ($filterStr=='')
      $where = '';
    else
      $where = 'where title like "%'.$filterStr.'%"';  
    $result = 0;
    $db = JFactory::getDBO();
    $db->setQuery('select count(*) cc
    from #__'.$this->name.'
    '.$where);
    $res = $db->loadObject();
    $result = $res->cc;
    return $result;
  }
}
?>