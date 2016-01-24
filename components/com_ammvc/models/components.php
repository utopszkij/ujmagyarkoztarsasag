<?php
/**
* @version		$Id: default_modelfrontend.php 125 2012-10-09 11:09:48Z michel $
* @package		Joomla site
* @subpackage amcomponent components Model
* @copyright	Copyright (C) 2013, . All rights reserved.
* @license #
*/
 defined('_JEXEC') or die('Restricted access');


jimport('joomla.application.component.modelitem');
jimport('joomla.application.component.helper');

JTable::addIncludePath(JPATH_COMPONENT.'/tables');
/**
 * AlapsModelAlaps
 * @author $Author$
 */
 
 
class ComponentsModelComponents  extends JModelItem { 
	protected $viewName = '';
  protected $errorMsg = '';
	protected $context = 'com_components.components';   
  // ----------------- config ---------------
  protected $name = 'components';   // tableName
  // ----------------- config ---------------
  
  function __construct() {
    $db = JFactory::getDBO();
    $db->setQuery('create table if not exists #__amcomponents (
       id integer unsigned NOT NULL AUTO_INCREMENT,
       name varchar(32),
       title varchar(80),
       description text,
       author varchar(32),
       authoremail varchar(60),
       licence varchar(60),
       version varchar(32),
       PRIMARY KEY (`id`)
    )
    ');
    if (!$db->query()) {
      echo '<div class="error">'.$db->getErrorMsg().'</div>';
    }
  }
  public function setState() {
  }
  public function setViewName($value) {
    $this->viewName = $value;
  }
  /**
   * file másolása és modosítása
   * @param string $source forrás file név
   * @param string $desr cél file név
   * @param string $viewName
   */               
  protected function masol($source, $dest, $viewName) {
    $lines = file($source);
    for ($i=0; $i<count($lines); $i++) {
      $lines[$i] = str_replace('defview',$viewName,$lines[$i]);
      $lines[$i] = str_replace('Defview',ucfirst($viewName),$lines[$i]);
      $lines[$i] = str_replace('DEFVIEW',strtoupper($viewName),$lines[$i]);
    } 
    $fp = fopen($dest,'w+');
    for ($i=0; $i<count($lines); $i++) {
      fwrite($fp,$lines[$i]);
    }
    fclose($fp);
  }
  /**
   * if $name is a mysql table name then create Jtable and form.xml
   * from mysql table'fields
   * @param string $name
   * @return void      
   */         
  protected function processTable($name) {
    $db = JFactory::getDBO();
    $db->setQuery('show fields from #__'.$name);
    $res = $db->loadObjectList();
    if (count($res) > 1) {
      // create JTable
      $fp = fopen('components/com_ammvc/tables/'.$name.'.php','w+');
      fwrite($fp,'<'.'?php'."\n");
      fwrite($fp,'/**'."\n");
      fwrite($fp,'* @version		1.00 '.date(Y-m-d)."\n");
      fwrite($fp,'* @package		Joomla site'."\n");
      fwrite($fp,'* @subpackage amcomponent '.$name.' table'."\n");
      fwrite($fp,'* @copyright	Copyright (C) 2013, All rights reserved.'."\n");
      fwrite($fp,'* @license GNU/GPL'."\n");
      fwrite($fp,'*/'."\n");
      fwrite($fp,'// no direct access'."\n");
      fwrite($fp,'defined("_JEXEC") or die("Restricted access");'."\n");
      fwrite($fp,'class Table'.ucfirst($name).' extends JTable {'."\n");
      foreach ($res as $res1) {
         fwrite($fp,'  public $'.$res1->Field.' = null;'."\n");
      }
      fwrite($fp,'  public function __construct(& $db){'."\n");
		  fwrite($fp,'    parent::__construct("#__'.$name.'", "id", $db);'."\n");
	    fwrite($fp,'  }'."\n");

      fwrite($fp,'}'."\n");
      fwrite($fp,'?'.'>'."\n");
      fclose($fp);
      // cretae form.xml
      $fp = fopen('components/com_ammvc/models/forms/'.$name.'.xml','w+');
      fwrite($fp,'<?'.'xml version="1.0" encoding="utf-8"?'.'>'."\n");
      fwrite($fp,'<form>'."\n");
	    fwrite($fp,'<'.'fields>'."\n");
      foreach($res as $res1) {
    		fwrite($fp,'  <'.'field'."\n");
			  fwrite($fp,'    name="'.$res1->Field.'"'."\n");
			  fwrite($fp,'    type="text"'."\n");
			  fwrite($fp,'    label="'.strtoupper($name).'_'.strtoupper($res1->Field).'"'."\n");
			  fwrite($fp,'    description="'.strtoupper($name).'_'.strtoupper($res1->Field).'_DESC"'."\n");
			  fwrite($fp,'    required="false"'."\n");
			  fwrite($fp,'    disabled="false"'."\n");
			  fwrite($fp,'    class="inputbox"/>'."\n");
      }     
      fwrite($fp,'<'.'/fields>'."\n");
      fwrite($fp,'</form>'."\n");
      fclose($fp);
    }
  }
	/**
	 * Method to get an record ojbect.
	 * @param	integer	The id of the object to get. or string: title
	 * @return	mixed	Object on success, false on failure.
	 */
	public function getItem($id)	{
    JTable::addIncludePath(JPATH_COMPONENT.DS.'models'.DS.'tables');
    $table = JTable::getInstance(ucfirst($this->name), 'Table');
    if (substr($id,0,1) > '9' ) {
      $db = JFactory::getDBO();
      $db->setQuery('select * from #__amcomponents where title="'.urldecode($id).'"');
      $this->_item = $db->loadObject();
    }
    if ($id == 0) {
      // init new record for insert
      $this->_item = new stdclass();
      $this->_item->id = 0;
      $this->_item->name = '';
      $this->_item->title = '';
      $this->_item->description = '';
      $this->_item->author = '';
      $this->_item->authoremail = '';
      $this->_item->licence = 'GNU/GPL';
      $this->_item->version = '1.00 '.date('Y-m-d');
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
    $result = true;
    if ($data['title'] == '') {
       $this->errorMsg .= '<p>'.JText::_('COMPONENTS_TITLE_REQUED').'</p>';
       $result = false;
    }
    if ($data['name'] == '') {
       $this->errorMsg .= '<p>'.JText::_('COMPONENTS_NAME_REQUED').'</p>';
       $result = false;
    }
    if ($data['author'] == '') {
       $this->errorMsg .= '<p>'.JText::_('COMPONENTS_AUTHOR_REQUED').'</p>';
       $result = false;
    }
    if (($data['id'] == 0) | ($data['id']=='')) {
       $db = JFactory::getDBO();
       $db->setQuery('select id from #__amcomponents where name="'.$data['name'].'"');
       $res = $db->loadObject();
       if ($res) {
         $this->errorMsg .= '<p>'.JText::_('COMPONENTS_NAME_EXIST').'</p>';
         $result = false;
       }
       if(preg_match('/^[a-z0-9-_]+$/',$data['name'])) {
         ;
       } else {
         $this->errorMsg .= '<p>'.JText::_('COMPONENTS_NAME_WRONG').'</p>';
         $result = false;
       }
    }
    return $result;
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
    if ($table->save($data)) {
      if ($data['lines']) {
         // WINDOWS/LINUX 
         $data['lines'] = str_replace("\r\n","\n",$data['lines']);
         $data['lines'] = str_replace("\t","    ",$data['lines']);
         // textarea problem
         $data['lines'] = str_replace("{textarea}","<textarea>",$data['lines']);
         $data['lines'] = str_replace("{/textarea}","</textarea>",$data['lines']);
         
         $fp = fopen($data['fileName'],'w+');
         fwrite($fp,$data['lines']);
         fclose($fp);
      }
      if (($data['id'] == 0) | ($data['id']=='')) {
          $name = $data['name'];
          if (!is_dir('components/com_ammvc/views/'.$name))
            mkdir('components/com_ammvc/views/'.$name,0777);
          if (!is_dir('components/com_ammvc/views/'.$name.'/tmpl'))
            mkdir('components/com_ammvc/views/'.$name.'/tmpl',0777);
          $this->masol('components/com_ammvc/models/defview.php',
                'components/com_ammvc/models/'.$name.'.php',
                $name);
          $this->masol('components/com_ammvc/views/defview/view.html.php',
                'components/com_ammvc/views/'.$name.'/view.html.php',
                $name);
          $this->masol('components/com_ammvc/controllers/defview.php',
                'components/com_ammvc/controllers/'.$name.'.php',
                $name);
          $this->masol('components/com_ammvc/helpers/defview.php',
                'components/com_ammvc/helpers/'.$name.'.php',
                $name);
          $this->masol('components/com_ammvc/tables/defview.php',
                'components/com_ammvc/tables/'.$name.'.php',
                $name);
          $this->masol('components/com_ammvc/models/forms/defview.xml',
                'components/com_ammvc/models/forms/'.$name.'.xml',
                $name);
          $this->masol('components/com_ammvc/views/defview/tmpl/default_list.php',
                'components/com_ammvc/views/'.$name.'/tmpl/default_list.php',
                $name);
          $this->masol('components/com_ammvc/views/defview/tmpl/default_buttons.php',
                'components/com_ammvc/views/'.$name.'/tmpl/default_buttons.php',
                $name);
          $this->masol('components/com_ammvc/views/defview/tmpl/default_filterform.php',
                'components/com_ammvc/views/'.$name.'/tmpl/default_filterform.php',
                $name);
          $this->masol('components/com_ammvc/views/defview/tmpl/form.php',
                'components/com_ammvc/views/'.$name.'/tmpl/form.php',
                $name);
          $this->masol('components/com_ammvc/views/defview/tmpl/show.php',
                'components/com_ammvc/views/'.$name.'/tmpl/show.php',
                $name);
          $this->masol('components/com_ammvc/languages/en-GB.defview.ini',
                'language/en-GB/en-GB.com_ammvc_'.$name.'.ini',
                $name);
          $this->masol('components/com_ammvc/languages/hu-HU.defview.ini',
                'language/hu-HU/hu-HU.com_ammvc_'.$name.'.ini',
                $name);
          $this->masol('components/com_ammvc/assets/grid.css',
                'components/com_ammvc/assets/'.$name.'.css',
                $name);
          $this->processTable($name);      
      }
      return true;
    } else {
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
    $db->setQuery('select id,name,title
    from #__amcomponents
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
    from #__amcomponents
    '.$where);
    $res = $db->loadObject();
    $result = $res->cc;
    return $result;
  }
}
?>