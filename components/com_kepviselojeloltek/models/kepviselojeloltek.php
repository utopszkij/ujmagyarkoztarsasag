<?php
/**
* @version		$Id: default_modelfrontend.php 125 2012-10-09 11:09:48Z michel $
* @package		Kepviselojeloltek
* @subpackage 	Models
* @copyright	Copyright (C) 2014, . All rights reserved.
* @license #
*/
 defined('_JEXEC') or die('Restricted access');


jimport('joomla.application.component.modelitem');
jimport('joomla.application.component.helper');
require_once JPATH_ADMINISTRATOR.'/components/com_content/models/article.php';
require_once JPATH_ADMINISTRATOR.'/components/com_jdownloads/tables/category.php';
require_once JPATH_ADMINISTRATOR.'/components/com_jdownloads/models/category.php';

require_once JPATH_BASE.'/libraries/kunena/database/object.php';
require_once JPATH_BASE.'/libraries/kunena/forum/category/category.php';

JTable::addIncludePath(JPATH_ROOT.'/administrator/components/com_kepviselojeloltek/tables');
/**
 * KepviselojeloltekModelKepviselojeloltek
 * @author $Author$
 */
 
 
class KepviselojeloltekModelKepviselojeloltek  extends JModelItem { 

	
	
	protected $context = 'com_kepviselojeloltek.kepviselojeloltek';   
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
		$this->setState('kepviselojeloltek.id', $id);

		// Load the parameters.
		//TODO: componenthelper
		//$this->setState('params', $params);
	}

	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id	.= ':'.$this->getState('kepviselojeloltek.id');

		return parent::getStoreId($id);
	}
	
	/**
	 * Method to get an ojbect.
	 *
	 * @param	integer	The id of the object to get.
	 *
	 * @return	mixed	Object on success, false on failure.
	 */
	public function &getItem($id = null)
	{
		if ($this->_item === null) {
			
			$this->_item = false;

			if (empty($id)) {
				$id = $this->getState('kepviselojeloltek.id');
			}

			// Get a level row instance.
			$table = JTable::getInstance('Kepviselojeloltek', 'Table');


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
   * store $item into database
   * @param mysql record $item
   * @return boolean      
   */     
  public function store($item) {
    $db = JFactory::getDBO();
    if ($item->id <= 0) {  
      // felvitel
      $db->setQuery('insert into #__kepviselojeloltek (user_id, temakor_id, leiras)
      values ("'.$item->user_id.'","'.$item->temakor_id.'","'.mysql_escape_string($item->leiras).'")
      ');
    } else {
      // módosítás
      $db->setQuery('update #__kepviselojeloltek
      set leiras="'.mysql_escape_string($item->leiras).'"
      where user_id="'.$item->user_id.'" and temakor_id="'.$item->temakor_id.'"
      ');
    }  
    $result = $db->query();
    if ($result == false) $this->setError($db->getErrorMsg());
    // jdownloader kategoria létrehozása vagy módosítása
    $this->storeJdownloadsCategory($item->user_id, $item);
    // kapcsolodó cikk létrehozása vagy módosítása
    $this->storeArtycle($item->user_id, $item);
    // kunena fórum kategória létrehozása vagy módosítása
    // nem generálunk kunen afórum kategoriákat $this->storeKunenaCategory($item->user_id, $item);
    return $result;
  }
   /**
    * a $item -ben adott temakor rekordhoz Jdownloads kategoria
    * létrehozása vagy modositása
    * FIGYELEM a tulajdonos témakörhöz meg kell, hogy legyen már a JDowloads kategoria!    
    * @param mysql record object  $item 
    * @return boolean     
  */            
   protected function storeJdownloadsCategory($newId, $item) {
     $result = true;
     $db = JFactory::getDBO();
     $model = new jdownloadsModelcategory();
     $user = JFactory::getUser($item->user_id);
     
     // parent Jdownloads category elérése
     $szulo = new stdClass();
     $szulo->id = 1;
     $szulo->cat_dir_parent = '';
     $szulo->cat_dir = '';
     
     // old record load from database
     $db->setQuery('SELECT * FROM #__jdownloads_categories WHERE alias="k'.$newId.'"');
     $old = $db->loadObject();
     if ($db->getErrorNum() > 0) $db->stderr();
     if ($old == false) {
       $old = new stdClass();       
       $old->cat_dir_parent = 'li-de temakoeroek es szavazasok';
     }
     $data = array();
     
     // data fields update
     foreach ($old as $fn => $fv) {
       if (!isset($item->$fn)) 
          $data[$fn] = $fv;
     }   
     if ($old->id > 0) 
        $data['id'] = $old->id;
     $data['parent_id'] = $szulo->id;
     $data['published'] = 1;
     $data['title'] = $user->name;
     $data['description'] = '';
     $data['alias'] = 'k'.$newId;
     $data['cat_dir'] = 'K'.$newId;
     $data['access'] = 1;
     if ($szulo->cat_dir_parent == '')
       $data['cat_dir_parent'] = $szulo->cat_dir;
     else
       $data['cat_dir_parent'] = $szulo->cat_dir_parent.'/'.$szulo->cat_dir;
     $data['language'] = '*';
     $data['pic'] = 'folder.png';
     
     // rekord store
     $result = $model->save($data, true); // false paraméternél hibát jelez
     
     // könyvtár ellenörzés ha kell létrehozás
     $path = './jdownloads/'.$data['cat_dir'];
     if (is_dir($path) == false) {
       mkdir($path,0777);
     }
     
     // Jdownloads category jogosultságok beállítása
     // $item->lathatosag: 0-mindenki, 1-regisztraltak, 2-téma tagok
     // usergoups 1:public, 2:Registered, 3:Author, 4:Editor, 6:Manager, 8:superuser, más: usergroup_id 
     // mindenki
        $rules = '';
     $db->setQuery('UPDATE #__assets
     SET rules="'.mysql_escape_string($rules).'"
     WHERE name="com_jdownloads.category.'.$newId.'"');
     $result = $db->query();   
     if ($db->getErrorNum() > 0) $db->stderr();
     return $result;
   }
   /**
    * a $item -ben adott temakor rekordhoz kapcsolodó cikk
    * létrehozása vagy modositása
    * @param mysql record object  $item 
    * @return boolean     
  */            
   protected function storeArtycle($newId, $item) {
     $result = true;
     $db = JFactory::getDBO();
     $user = JFactory::getUser($item->user_id);
     $db->setQuery('SELECT id FROM #__content WHERE alias="k'.$item->id.'"');
     $res = $db->loadObject();
     if ($res) {
           // kapcsolodó cikk rekord update
           $db->setQuery('update #__content
           set title="'.$db->quote($user->name.' (kommentek)').'",
               introtext = ""
           where alias="k'.$item->id.'"    
           ');
           $result = $db->query();
           if ($db->getErrorNum() > 0) $db->stderr();
     } else {
           $artycleData = array(
            'catid' => 10, 
            'title' => $item->name.' (kommentek)',
            'introtext' => '',
            'fulltext' => '',
            'alias' => 'k'.$newId,
            'metadata' => '',
            'state' => 1,
           );
           $new_article = new ContentModelArticle();
           $result = $new_article->save($artycleData);
     }
     return $result;      
   }
   /**
    * a $item -ben adott temakor rekordhoz kapcsolodó kunena fórum kategória
    * létrehozása vagy modositása
    * @param mysql record object  $item 
    * @return boolean     
  */            
   protected function storeKunenaCategory($newId, $item) {
     $result = true;
     $db = JFactory::getDBO();
     $user = JFactory::getUser($item->user_id);
     $gr = 1;
     $params = '{"access_post":["6","2","8"],"access_reply":["6","2","8"]}';
 
     // szülő beállítása
     $parentId = 86; 
      
      // meglévő rekord elérése
     $db->setQuery('SELECT id FROM #__kunena_categories WHERE alias="K'.$newId.'"');
     $res = $db->loadObject();
     if ($db->getErrorNum() > 0) $db->stderr();
     
     // forum kategoria rekord összeállítása
     $data = array();
     if ($res) 
       $data['id'] = $res->id;
     else
       $data['id'] = 0;
     $data['parent_id'] = $parentId;    
     $data['name'] = strip_tags($user->name);    
     $data['description'] = '';    
     $data['pub_acces'] = $gr;    
     $data['access_type'] = 'joomla.group';    
     $data['access'] = 1;    
     $data['alias'] = 'K'.$newId;    
     $data['params'] = $params;    
     $data['admin_access'] = 0; 
     $data['admin_recurse'] = 1;
     $data['pub_recurse'] = 1; 
     $data['published'] = 1; 
 
     // fórum kategoria rekord tárolása
     $category = new KunenaForumCategory($data);
     if ($data['id'] > 0) {
       $db->setQuery('UPDATE #__kunena_categories
       SET name="'.mysql_escape_string($data['name']).'",
       description="'.mysql_escape_string($data['description']).'",
       pub_access="'.$gr.'",
       params = "'.mysql_escape_string($params).'"
       WHERE id="'.$data['id'].'"');
       $db->query();
     } else {
        $category->save();
     }    

     return $result;
   }

}
?>