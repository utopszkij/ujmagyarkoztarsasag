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

require_once JPATH_ADMINISTRATOR.'/components/com_content/models/article.php';
require_once JPATH_ADMINISTRATOR.'/components/com_categories/models/category.php';
require_once JPATH_ADMINISTRATOR.'/components/com_jdownloads/tables/category.php';
require_once JPATH_ADMINISTRATOR.'/components/com_jdownloads/models/category.php';
require_once JPATH_ADMINISTRATOR . '/components/com_categories/models/category.php';

require_once JPATH_BASE.'/libraries/kunena/database/object.php';
require_once JPATH_BASE.'/libraries/kunena/forum/category/category.php';

$app = JFactory::getApplication('site');

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
				// Convert the JTable to a clean JObject.
				$this->_item = JArrayHelper::toObject($table->getProperties(1), 'JObject');
              $db = JFactory::getDBO();
              $db->setQuery('select * from #__beallitasok where id = (10+'.$id.')');
              $res = $db->loadObject();
              if ($res) {
                $this->_item->json = $res->json;
              } else {
                $this->_item->json = '{}';
              } 
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
    if (isset($source['json'])) {
       $result->json = $source['json'];
    } else {
       $result->json = '{}';
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
     $user = JFactory::getUser();
     if ($user->id <= 0) {
       echo '<div class="errorMsg">access denied</div>';
       return;
     }
     $db = JFactory::getDBO();
     $felvitel = (($item->id == 0) | ($item->id == ''));
     $table = JTable::getInstance('Temakorok', 'Table');
     if ($this->check($item)) {
       $table->bind($item);
       $result = $table->store();
       if ($result) {
         if ($felvitel) {
           // felvitel
           
           // tárolás a beallitasok táblába
           $db->setQuery('insert into #__beallitasok
           values ((10+'.$table->id.'),"'.$item->json.'")');
           $db->query();
           
           // usergroup létrehozása
           
           $db->setQuery('SELECT * FROM #__usergroups WHERE title like "['.$item->szulo.']%"');
           $szulo = $db->loadObject();
           if ($szulo == false) {
             $szulo = new stdClass();
             $szulo->id = 2;
           }
           $gmodel = new UsersModelGroup();
           $data = array();
           $data['id'] = 0;
           $data['parent_id'] = $szulo->id;
           $data['title'] = '['.$table->id.'] '.$item->megnevezes;
           if ($gmodel->save($data) == false) {
             $this->setError('Error in create userGroup '.$gmodel->gerError());
             return false;
           };
                  
           // temakor admin tag létrehozása
           $db->setQuery('INSERT INTO #__tagok(`temakor_id`,`user_id`,`admin`)
	         VALUES	('.$table->id.','.$user->id.',1);');
           $db->query();
           
           // témakör admin beirása az usergroup alá  
           $db->setQuery('INSERT INTO #__user_usergroup_map
           select '.$user->id.', id
           from #__usergroups
           where title = "['.$table->id.'] '.$item->megnevezes.'"
           limit 1'
           );
           $db->query();
           
           
           // kunena forum csoport létrehozása 
           
  
         } else {
           // módosítás
         
           // tárolás a beallitasok táblába
           $db->setQuery('delete from #__beallitasok where id=(10+'.$table->id.')');
           $db->query();
           $db->setQuery('insert into #__beallitasok
           values ((10+'.$table->id.'),"'.$item->json.'")');
           $db->query();

           // usergroup modositása
           $db->setQuery('UPDATE #__usergroups
           SET title="['.$table->id.'] '.$table->megnevezes.'"
           WHERE title like "['.$table->id.']%"');
           $db->query();

           // kunena kategoria kategoria modositása
           if ($item->lathatosag == 2) {
             // tagok számára látható
             $pub_access = $this->temakorokHelper->getTemakorGroupId($item->id);
             $cat_access = 99;
             $db->setQuery('select id from #__jdownloads_groups where groups_name like "['.$item->id.']%" limit 1');
             // UJ JDONLOADS verzió !!!!   $res = $db->loadObject();
             if ($res) {
               $cat_group_access = $res->id;
             } else {
               $cat_group_access = 0;
             }
           } else if ($item->lathatosag == 1) {
             // regisztráltak számára látható
             $pub_access = 1;
             $cat_access = 11;
             $cat_group_access = 0;
           } else {
             // nyilvános
             $pub_access = 0;
             $cat_access = 11;
             $cat_group_access = 0;
           }

         }
         // jdownloader kategoria létrehozása vagy módosítása
         $this->storeJdownloadsCategory($table->id, $item);

         // kapcsolodó cikk létrehozása vagy módosítása
         $this->storeArtycle($table->id, $item);

         // kunena fórum kategória létrehozása vagy módosítása
         //2015.05.17 nem generálunk kunena kategoriákat $this->storeKunenaCategory($table->id, $item);

         // content kategória létrehozása vagy módosítása
         $this->storeContentCategory($table->id, $item);

         // acymailing kategória létrehozása vagy módosítása
         $this->storeAcymailingCategory($table->id, $item);
         
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
     // biztos ami biztos inkább ne töröljük a Jdownloads kategóriát....
     //    $this->deleteJdownloadsCategory($item); 
     return ($errorMsg == '');
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
     // Jtable objektum elérése
     $db = JFactory::getDBO();
     $model = new jdownloadsModelcategory();
     
     // parent Jdownloads category elérése
     $db->setQuery('SELECT * FROM #__jdownloads_categories WHERE alias="t'.$item->szulo.'"');
     $szulo = $db->loadObject();
     if ($szulo == false) {
       $szulo = new stdClass();
       $szulo->id = 1;
	   $szulo->level = 1;
       $szulo->cat_dir_parent = '';
       $szulo->cat_dir = '';
     }
     
     // old record load from database
     $db->setQuery('SELECT * FROM #__jdownloads_categories WHERE alias="t'.$newId.'"');
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
     if ($old->id > 0) $data['id'] = $old->id;
     $data['parent_id'] = $szulo->id;
     $data['published'] = 1;
     $data['title'] = $item->megnevezes;
     $data['description'] = $item->leiras;
     $data['alias'] = 't'.$newId;
     $data['cat_dir'] = $item->megnevezes;
     $data['access'] = 1;
     $data['cat_dir_parent'] = '';
     $data['language'] = '*';
     $data['pic'] = 'folder.png';
	 $data['level'] = $szulo->level + 1;
     
     // rekord store
     $result = $model->save($data, true); // false paraméternél hibát jelez

     // usergroup el�r�se
     $db->setQuery('SELECT id FROM #__usergroups WHERE title like "['.$newId.']%"');
     $res = $db->loadObject();
     if ($db->getErrorNum() > 0) $db->stderr();
     if ($res)
          $gr = $res->id;
     else
          $gr = 0;

     
     // Jdownloads category jogosultságok beállítása
     // $item->lathatosag: 0-mindenki, 1-regisztraltak, 2-téma tagok
     // usergoups 1:public, 2:Registered, 3:Author, 4:Editor, 6:Manager, 8:superuser, más: usergroup_id 
     if ($item->lathatosag == 0) {
        // mindenki
          $rules = '{"core.create":{"'.$gr.'":1},
"core.delete":{"'.$gr.'":1},
"core.edit":{"'.$gr.'":1},
"core.edit.state":{"'.$gr.'":1},
"core.edit.own":{"'.$gr.'":1},
"download":{"1":1}
}';
      }  
     if ($item->lathatosag == 1) {
        // regisztráltak
          $rules = '{"core.create":{"'.$gr.'":1},
"core.delete":{"'.$gr.'":1},
"core.edit":{"'.$gr.'":1},
"core.edit.state":{"'.$gr.'":1},
"core.edit.own":{"'.$gr.'":1},
"download":{"2":1}
}';
     }   
     if ($item->lathatosag == 2) {
        // téma tagok
        if ($gr > 0) {    
          $rules = '{"core.create":{"'.$gr.'":1},
"core.delete":{"'.$gr.'":1},
"core.edit":{"'.$gr.'":1},
"core.edit.state":{"'.$gr.'":1},
"core.edit.own":{"'.$gr.'":1},
"download":{"'.$gr.'":1}
}';
        } else {
          $rules = '{"core.create":{"1":0,"2":1},
"core.delete":{"1":0,"2":1},
"core.edit":{"1":0,"2":1},
"core.edit.state":{"1":0,"2":1},
"core.edit.own":{"1":0,"2":1},
"download":{"1":0,"2":1}
}';
        }          
     }
     $db->setQuery('UPDATE #__assets
     SET rules="'.mysql_escape_string($rules).'"
     WHERE name="com_jdownloads.category.'.$data['id'].'"');
     $result = $db->query();   
     if ($db->getErrorNum() > 0) $db->stderr();
     //DBG echo $db->getQuery(); exit(); 
   return $result;
   }
   /**
    * a $item -ben adott temakor rekordhoz kapcsolodó cikk
    * létrehozása vagy modositása
    * @param integer az új rekord id -je
    * @param mysql record object  $item 
    * @return boolean     
  */            
   protected function storeArtycle($newId, $item) {
     $result = true;
     $link = '<p><a href="'.JURI::base().'index.php?option=com_szavazasok&view=szavazasoklist&temakor='.$newId.'">Ugrás a témakör oldalára</a></p>';
     $db = JFactory::getDBO();
     $db->setQuery('SELECT id FROM #__content WHERE alias="t'.$item->id.'"');
     $res = $db->loadObject();
     if ($res) {
           // kapcsolodó cikk rekord update
           $db->setQuery('update #__content
           set title='.$db->quote($item->megnevezes.' (kommentek)').',
               introtext = '.$db->quote($item->leiras.$link).'
           where alias="t'.$item->id.'"    
           ');
           $result = $db->query();
           if ($db->getErrorNum() > 0) $db->stderr();
     } else {
           $artycleData = array(
            'catid' => 10, 
            'title' => $item->megnevezes.' (kommentek)',
            'introtext' => $item->leiras.$link,
            'fulltext' => '',
            'alias' => 't'.$newId,
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
     // $temakor GroupId meghatározása láthatóságtól függ lehet nulla is.
     $db->setQuery('SELECT id FROM #__usergroups WHERE title like "['.$newId.']%"');
     $res = $db->loadObject();
     if ($db->getErrorNum() > 0) $db->stderr();
     if ($res)
        $gr = $res->id;
     else
       $gr = 1;
       
     if ($item->lathatosag == 0) {
       $gr = 1;
       $params = '{"access_post":["6","2","8"],"access_reply":["6","2","8"]}';
     }
     if ($item->lathatosag == 1) {
       $gr = 2;
       $params = '{"access_post":["6","2","8"],"access_reply":["6","2","8"]}';
     }
     if ($item->lathatosag == 2) {
       $params = '{"access_post":["6","'.$gr.'",8"],"access_reply":["6","'.$gr.'",8"]}';
     }

     // szülő elérése
     $db->setQuery('SELECT id FROM #__kunena_categories WHERE alias="T'.$item->szulo.'"');
     $res = $db->loadObject();
     if ($res) 
        $parentId = $res->id;
     else
        $parentId = 85; //li-de témakörök  
        
     // meglévő rekord elérése
     $db->setQuery('SELECT id FROM #__kunena_categories WHERE alias="T'.$item->id.'"');
     $res = $db->loadObject();
     if ($db->getErrorNum() > 0) $db->stderr();
     
     // forum kategoria rekord összeállítása
     $data = array();
     if ($res) 
       $data['id'] = $res->id;
     else
       $data['id'] = 0;
     $data['parent_id'] = $parentId;    
     $data['name'] = strip_tags($item->megnevezes);    
     $data['description'] = strip_tags($item->leiras);    
     $data['pub_acces'] = $gr;    
     $data['access_type'] = 'joomla.group';    
     $data['access'] = 1;    
     $data['alias'] = 'T'.$newId;    
     $data['params'] = $params;    
     $data['admin_access'] = 0; 
     $data['admin_recurse'] = 1;
     $data['pub_recurse'] = 1; 
     $data['published'] = 1; 
     // 2015.05.08 tapasztalat: a kunena fórum nem kultiválja ahtml entity-ket 
     $data['description'] = html_entity_decode($data['description'], ENT_COMPAT, 'UTF-8');  
     $data['name'] = html_entity_decode($data['name'], ENT_COMPAT, 'UTF-8');  
 
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
       
       // DEBUG
       // echo $item->leiras.'<hr>'.$db->getQuery(); exit();
       
     } else {
        $category->save();
     }    
     
     return $result;
   }
   /**
    * Content kategória létrehozása az $item -ben lévő témakörhöz
    * @param integer $newId
    * @param mysqlrecord $item
    * @return void
    */
    protected function storeContentCategory($newId, $item) {
      $db = JFactory::getDBO();
      $user = JFactory::getUser();
      $basePath = JPATH_ADMINISTRATOR . '/components/com_categories';
      $config = array( 'table_path' => $basePath . '/tables');
	  
	  // szülő kategoria elérése
      $db->setQuery('SELECT * FROM #__categories WHERE alias="t'.$item->szulo.'"');
      $szulo = $db->loadObject();
      if (!$szulo) {
        $szulo = new stdClass();
        $szulo->id = 82;
      }
      // megvan már a rekord?
      $db->setQuery('SELECT * FROM #__categories WHERE alias="t'.$newId.'"');
      $old = $db->loadObject();
      
	  
      if ($old == false) {
        $category_data = array();
        $category_data['id'] = 0;
        $category_data['parent_id'] = $szulo->id;
        $category_data['title'] = $item->megnevezes;
        $category_data['description'] = $item->leiras;
        $category_data['alias'] = 't'.$newId;
        $category_data['extension'] = 'com_content';
        $category_data['published'] = 1;
        $category_data['language'] = '*';
        $category_data['access'] = 1;
        $category_data['params'] = array();
        $new_category = new CategoriesModelCategory($config);
        $result = $new_category->save($category_data);
      } else {
        $db->setQuery('UPDATE #__categories
        SET title="'.mysql_escape_string($item->megnevezes).'",
            description = "'.mysql_escape_string($item->leiras).'"
        WHERE alias="t'.$newId.'"');
        $db->query();
        if ($db->getErrorNum() > 0) $db->stderr();
      }
     
	}

   /**
    * Acymailing kategória létrehozása az $item -ben lévő témakörhöz
    * @param integer $newId
    * @param mysqlrecord $item
    * @return void
    */
    protected function storeAcymailingCategory($newId, $item) {
      $db = JFactory::getDBO();
      $user = JFactory::getUser();
	  
	  // szülő kategoria elérése
      $db->setQuery('SELECT * FROM #__acymailing_list WHERE alias="t'.$item->szulo.'"');
      $szulo = $db->loadObject();
      if (!$szulo) {
        $szulo = new stdClass();
        $szulo->listid = 0;
      }
      // megvan már a rekord?
      $db->setQuery('SELECT * FROM #__acymailing_list WHERE alias="t'.$newId.'"');
      $old = $db->loadObject();
	  
      if ($old == false) {
		  $db->setQuery('INSERT INTO #__acymailing_list 
			(`name`, 
			`description`, 
			`ordering`, 
			`listid`, 
			`published`, 
			`userid`, 
			`alias`, 
			`color`, 
			`visible`, 
			`welmailid`, 
			`unsubmailid`, 
			`type`, 
			`access_sub`, 
			`access_manage`, 
			`languages`, 
			`startrule`, 
			`category`
			)
			VALUES
			('.$db->quote($item->megnevezes).', 
			'.$db->quote($item->leiras).', 
			0, 
			0, 
			1, 
			"'.$user->id.'", 
			"t'.$newId.'", 
			"#303030", 
			1, 
			0, 
			0, 
			"list", 
			"all", 
			"none", 
			"all", 
			0, 
			"");
		  ');
		  $db->query();
      } else {
        $db->setQuery('UPDATE #__acymailing_list
        SET name="'.mysql_escape_string($item->megnevezes).'",
            description = "'.mysql_escape_string($item->leiras).'"
        WHERE alias="t'.$newId.'"');
        $db->query();
        if ($db->getErrorNum() > 0) $db->stderr();
      }
     
	}
	
         	
}
?>