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

require_once JPATH_ROOT.'/components/com_temakorok/models/temakorok.php';
require_once JPATH_ADMINISTRATOR.'/components/com_content/models/article.php';
require_once JPATH_ADMINISTRATOR.'/components/com_jdownloads/tables/category.php';
require_once JPATH_ADMINISTRATOR.'/components/com_jdownloads/models/category.php';

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
	  * értesitő email új szavazásról
	  * @param string cimzett email
	  * @param JTable az új szavazás rekordot tartalmazó JTable
	  * @return void
	  */
	protected function ujSzavazasEmail($email, $table) {
		$mailbody = '<h2>Új szavazás indult a li-de rendszerben<h2>
		<h3>Adminoknak szoló értesités</h3>
		<p><a href="'.JURI::base().'index.php'.
		'?option=com_alternativak&task=browse'.
		'&szavazas='.$table->id.
		'&temakor='.$table->temakor_id.'">'.$table->megnevezes.'</a></p>
		<div>'.$table->leiras.'</div>
		<br /><br />
		<p><a href="'.JURI::base().'index.php?option=com_alternativak&task=browse'.
		'&szavazas='.$table->id.
		'&temakor='.$table->temakor_id.'">Látogass el a szavazás oldalára!</a></p>
		<br /><br />
		';
		$subject = 'Uj szavazas a li-de rendszerben';
		$mail = JFactory::getmailer();
 	    $mail->clearAllRecipients();
	    $mail->addRecipient($email);
	    $mail->isHTML(true);
	    $mail->setBody($mailbody);
	    $mail->setSubject($subject);
	    $mail->setSender('li-de@adatmagus.hu');
	    $mail->send();
		return true;
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
		 $this->_item->elbiralas_alatt = 0;
		 $this->_item->elutasitva = '';
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
   * szavazas beolvasása a cliboardon lévő 
   * clipboard_szavazas_id alapján
   */
  public function getFromClipboard() {
    $session = JFactory::getSession();
    $db = JFactory::getDBO();
    $clId = $session->get('clipboard_szavazas_id');
    if ($clId != '') {
      $result = $this->getItem($clId);
      $result->id = 0;
      $result->letrehozo = $user->id;
      $result->letrehozva = date('Y-m-d H:i:s');
      $result->vita1_vege = date('Y-m-d 23:59:59',time()+(5*24*60*60));
      $result->vita2_vege = date('Y-m-d 23:59:59',time()+(10*24*60*60));
      $result->szavazas_vege = date('Y-m-d 23:59:59',time()+(15*24*60*60));
      $result->vita1 = 1;
      $result->vita2 = 0;
      $result->szavazas = 0;
      $result->lezart = 0;
	  $result->elbiralas_alatt = 0;
	  $result->elutasitva = '';
      for ($i=0; $i<count($result->alternativak); $i++)
        $result->alternativak[$i]->szavazas_id = 0;
    } else {
      $result = $this->getItem(0);
    }
    return $result;  
  }       

/**
   * adat olvasás a $source assotiativ tömbből
   * @param array   
   * @return mysql record object
   * ha vita2_vege nem érkezik akkkor legyen a vita1_vege -vel azonos (UMK projek)
   */         
  public function bind($source) {
	if (!isset($source['vita2_vege'])) {
		$source['vita2_vege'] = $source['vita1_vege'];
	}
    $i = 0;
		$table = JTable::getInstance('Szavazasok', 'Table');
    $table->bind($source);
    $result = new stdclass();
    foreach( $table as $fn => $fv) 
      $result->$fn = $fv;
    $result->temakor_id = JRequest::getVar('temakor_id',0);
    $result->id = JRequest::getVar('id',0);
    // allapot radiobutton kezelése
    $result->elbiralas_alatt=0;
    $result->vita1=0;
    $result->vita2=0;
    $result->szavazas=0;
    $result->lezart=0;
    if (JRequest::getVar('allapot') == 'elbiralas_alatt') $result->elbiralas_alatt = 1;  
    if (JRequest::getVar('allapot') == 'vita1') $result->vita1 = 1;  
    if (JRequest::getVar('allapot') == 'vita2') $result->vita2 = 1;  
    if (JRequest::getVar('allapot') == 'szavazas') $result->szavazas = 1;  
    if (JRequest::getVar('allapot') == 'lezart') $result->lezart = 1;
    if (JRequest::getVar('elvetve') == 'elvetve') {
		$result->velbiralas_alatt = 0;
		$result->vita1 = 0;
		$result->vita2 = 0;
		$result->szavazas = 0;
		$result->lezart = 0;
	} else {
		$result->elutasitva = '';
	}	
   
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
	
	$result->cimkek = '';
	for ($i=0; $i < 50; $i++) {
		if (JRequest::getVar('cimke_'.$i) != '') {
			$result->cimkek .= JRequest::getVar('cimke_'.$i).',';
		}
	}
	//DBG echo JSON_encode($result); exit();
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
     if ((($item->vita1 + $item->vita2 + $item->szavazas + $item->lezart + $item->elbiralas_alatt) != 1) & ($item->elutasitva == '')) {
         $result = false;
         $msg .= JText::_('ROSSZSZAVAZASALLAPOT').' '.JSON_encode($item).'<br />';
     }
     if ((($item->vita1 + $item->vita2 + $item->szavazas + $item->lezart + $item->elbiralas_alatt) == 0) & ($item->elutasitva == '')) {
         $result = false;
         $msg .= JText::_('ELUTASITAST_INDOKOLNI_KELL').' '.JSON_encode($item).'<br />';
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

       /*
       echo '<p>$table létrehozva</p>';
       foreach ($table as $fn => $fv) {
         echo $fn.'='.$fv.'<br />';
       }


       echo '<p>$this->check jon   $item</p>';
       foreach ($item as $fn => $fv) {
         echo $fn.'='.$fv.'<br />';
       }
       */
       
     if ($this->check($item)) {
       $table->bind($item);
       
       /*
       echo '<p>$table bind után</p>';
       foreach ($table as $fn => $fv) {
         echo $fn.'='.$fv.'<br />';
       }
       */
       
       $table->temakor_id = JRequest::getVar('temakor_id','20');
	   if ($table->temakor_id == '') $table->temakor_id = 20;
       $table->id = JRequest::getVar('id','0');
       if ($table->id == 0) {
         $table->letrehozo = $user->id;
         $table->letrehozva = date('Y-m-d H:i:s');
       }
       
       /*
       echo '<p>$table->store jon</p>';
       foreach ($table as $fn => $fv) {
         echo $fn.'='.$fv.'<br />';
       }
       */
	   
	   // allapot fixálás
	   if ($table->elutasitva != '') {
		   $table->vita1 = 0;
		   $table->vita2 = 0;
		   $table->szavazas = 0;
		   $table->lezart = 0;
		   $table->elbiralas_alatt = 0;
	   }
	   if ($table->elbiralas_alatt) {
		   $table->vita1 = 0;
		   $table->vita2 = 0;
		   $table->szavazas = 0;
		   $table->lezart = 0;
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
	   
	   // PMS a joomla adminoknak ($table->id és a további mezők használhatóak)
	   $db->setQuery('select * from #__temakorok where id='.$table->temakor_id);
	   $temakor = $db->loadObject();
	   if ($ujfelvitel) {
		   $db->setQuery('select distinct u.email, u.id 
		   from #__users u
		   inner join #__user_usergroup_map m on m.user_id = u.id
		   left outer join #__tagok t on t.user_id = u.id and t.temakor_id='.$table->temakor_id. '
		   where m.group_id = 8 or m.group_id = 7 or t.admin = 1');
		   $adminok = $db->loadObjectList();
		   foreach ($adminok as $admin) {
			  //$this->ujSzavazasEmail($admin->email,$table);
			  // PMS a rendszer és témakör adminoknak
			  $db->setQuery('INSERT INTO #__uddeim 
				(`id`, 
				`replyid`, 
				`fromid`, 
				`toid`, 
				`message`, 
				`datum`, 
				`toread`, 
				`totrash`, 
				`totrashdate`, 
				`totrashoutbox`, 
				`totrashdateoutbox`, 
				`expires`, 
				`disablereply`, 
				`systemflag`, 
				`delayed`, 
				`systemmessage`, 
				`archived`, 
				`cryptmode`, 
				`flagged`, 
				`crypthash`, 
				`publicname`, 
				`publicemail`
				)
				VALUES
				(0, 
				0, 
				'.$db->quote($user->id).', 
				'.$db->quote($admin->id).', 
				"Új ötlet javaslat lett a web oldalra feltöltve'.
				   '\nTémakör:'.$temakor->megnevezes.
				   '\nÖtlet megnevezése:'.$table->megnevezes.
				   '\nFeltöltő:'.$user->username.
				   '\n[url]'.JURI::base().'SU/alternativak/alternativaklist/browse/'.$table->temakor_id.'/'.$table->id.'/20/0/1/[/url]", 
				"'.time().'", 
				0, 
				0, 
				0, 
				0, 
				0, 
				0, 
				0, 
				1, 
				0, 
				"Új ötlet (javaslat)", 
				0, 
				0, 
				0, 
				"", 
				"", 
				""
				);
			  ');
			  $db->query();
		   } // foreach
	   } // új felvitel

         // cikk kategoria létrehozása vagy módosítása
         $this->storeContentCategory($table->id, $item);

         // jdownloader kategoria létrehozása vagy módosítása
         $this->storeJdownloadsCategory($table->id, $item);

         // kapcsolodó cikk létrehozása vagy módosítása
         $this->storeArtycle($table->id, $item);

         // kunena fórum kategória létrehozása vagy módosítása
         // 2015.05.17 nem generálunk kunena kategoriákat $this->storeKunenaCategory($table->id, $item);
       
	
       if ($table->elbiralas_alatt == 0) {		
		// icAgenda események létrehozása, karbantartása
	     $this->storeEvent($table->id, $item);
	   }
     } else {
       $result = false;
     }
	 
	 if ($result) {
		 $db->setQuery('DELETE FROM #__cimke_szavazasok where szavazas_id="'.$table->id.'"');
		 $db->query();
		 $w = explode(',',$item->cimkek);
		 foreach ($w as $cimke) {
			 if ($cimke != '') {
				 $db->setQuery('INSERT INTO #__cimke_szavazasok
				 value ("'.$cimke.'","'.$table->id.'")');
				 $db->query();
			 }
		 }
		 
	 }
     return $result;
   } 
   /**
    * delete a item
    * @param mysql_record $item
    * @result boolean
    */
    public function delete($item) {
      $db = JFactory::getDBO();
      $result = true;
      $db->setQuery('start transaction');
      $db->query();
      $db->setQuery('delete from #__szavazasok where id="'.$item->id.'"');
      $result = $db->query();
      if ($result) {
        $db->setQuery('delete from #__alternativak where szavazas_id="'.$item->id.'"');
        $result = $db->query();
      }  
      if ($result) {
        $db->setQuery('delete from #__szavazatok where szavazas_id="'.$item->id.'"');
        $result = $db->query();
      }
      if ($result) {
        $db->setQuery('delete from #__szavazok where szavazas_id="'.$item->id.'"');
        $result = $db->query();
      }
      if ($result)
        $db->setQuery('commit');
      else
        $db->setQuery('rollback');  
      $db->query();
      return $result;
    }
    /**
     * a szavazásnál érvényesült szavazat átruházási lánc elérése
     * @param integer $szavazas_id
     * @param integer $kepviselo_id
     * @return string képviselő nevek listája     
     */                    
    public function getKepviselok($szavazas_id, $kepviselo_id) {
      $s = '';
      $db = JFactory::getDBO();
      while ($kepviselo_id != 0) {
        $db->setQuery('select u.name, sz.kepviselo_id
        from #__users u
        inner join #__szavazok sz on sz.user_id = u.id
        where u.id = "'.$kepviselo_id.'" and szavazas_id="'.$szavazas_id.'"');
        $res = $db->loadObject();
        if ($res) {
          $s .= '&gt;&nbsp;'.$res->name;
          $kepviselo_id = $res->kepviselo_id;
        } else {
          $kepviselo_id = 0;
        }
      }
      return $s;
    }                 
   /**
    * a $item -ben adott szavazas rekordhoz Jdownloads kategoria
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
     // témakör rekord elérése
     $temakorModel = new TemakorokModelTemakorok();
     $temakor = $temakorModel->getItem($item->temakor_id);
     
     // parent Jdownloads category elérése
     $db->setQuery('SELECT * FROM #__jdownloads_categories WHERE alias="t'.$item->temakor_id.'"');
     $szulo = $db->loadObject();
     if ($szulo == false) {
       $szulo = new stdClass();
       $szulo->id = 1;
	   $szulo->level = 1;
       $szulo->cat_dir_parent = '';
       $szulo->cat_dir = '';
     }
     
     // old record load from database
     $db->setQuery('SELECT * FROM #__jdownloads_categories WHERE alias="sz'.$newId.'"');
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
     $data['alias'] = 'sz'.$newId;
     $data['cat_dir'] = $item->megnevezes;
     $data['access'] = 1;
     $data['cat_dir_parent'] = '';
     $data['language'] = '*';
     $data['pic'] = 'folder.png';
	 $data['level'] = $szulo->level + 1;
     
     // rekord store
     $result = $model->save($data, true); // false paraméternél hibát jelez
     
     
     // Jdownloads category jogosultságok beállítása
     // $item->lathatosag: 0-mindenki, 1-regisztraltak, 2-téma tagok
     // usergoups 1:public, 2:Registered, 3:Author, 4:Editor, 6:Manager, 8:superuser, más: usergroup_id 
     if ($temakor->lathatosag == 0) {
        // mindenki
        $rules = '';
      }  
     if ($temakor->lathatosag == 1) {
        // regisztráltak
        $rules = '{"core.create":{"1":0,"2":1},
"core.delete":{"1":0,"2":1},
"core.edit":{"1":0,"2":1},
"core.edit.state":{"1":0,"2":1},
"core.edit.own":{"1":0,"2":1},
"download":{"1":0,"2":1}
}';
     }   
     if ($temakor->lathatosag == 2) {
        // téma tagok
        $db->setQuery('SELECT id FROM #__usergroups WHERE title like "['.$newId.']%"');
        $res = $db->loadObject();
        if ($db->getErrorNum() > 0) $db->stderr();
        if ($res)
          $gr = $res->id;
        else
          $gr = 0;
        if ($gr > 0) {    
          $rules = '{"core.create":{"1":0,"2":0,"'.$gr.'":1},
"core.delete":{"1":0,"2":0,"'.$gr.'":1},
"core.edit":{"1":0,"2":0,"'.$gr.'":1},
"core.edit.state":{"1":0,"2":0,"'.$gr.'":1},
"core.edit.own":{"1":0,"2":0,"'.$gr.'":1},
"download":{"1":0,"2":0,"'.$gr.'":1}
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
     $link = '<p><a href="'.JURI::base().'index.php?option=com_szavazasok&view=szavazasoklist&temakor='.$item->temakor_id.'">Ugrás a témakör oldalára</a>&nbsp;&nbsp;'.
             '<a href="'.JURI::base().'index.php?option=com_alternativak&view=alternativaklist&temakor='.$item->temakor_id.'&szavazas='.$newId.'">Ugrás a szavazás oldalára</a></p>';
     $db = JFactory::getDBO();
     $db->setQuery('SELECT id FROM #__content WHERE alias="sz'.$item->id.'"');
     $res = $db->loadObject();
     if ($res) {
           // kapcsolodó cikk rekord update
           $db->setQuery('update #__content
           set title='.$db->quote($item->megnevezes.' (kommentek)').',
               introtext = '.$db->quote($item->leiras.$link).'
           where alias="sz'.$item->id.'"    
           ');
           $result = $db->query();
           
           
           
           if ($db->getErrorNum() > 0) $db->stderr();
     } else {
           $artycleData = array(
            'catid' => 10, 
            'title' => $item->megnevezes.' (kommentek)',
            'introtext' => $item->leiras.$link,
            'fulltext' => '',
            'alias' => 'sz'.$newId,
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
     $db->setQuery('SELECT id FROM #__usergroups WHERE title like "['.$item->temakor_id.']%"');
     $res = $db->loadObject();
     if ($db->getErrorNum() > 0) $db->stderr();
     if ($res)
        $gr = $res->id;
     else
       $gr = 1;
     
     // témakör elérése
     $temakorModel = new TemakorokModelTemakorok();
     $temakor = $temakorModel->getItem($item->temakor_id);
     if ($temakor->lathatosag == 0) {
       $gr = 1;
       $params = '{"access_post":["6","2","8"],"access_reply":["6","2","8"]}';
     }
     if ($temakor->lathatosag == 1) {
       $gr = 2;
       $params = '{"access_post":["6","2","8"],"access_reply":["6","2","8"]}';
     }
     if ($temakor->lathatosag == 2) {
       $params = '{"access_post":["6","'.$gr.'",8"],"access_reply":["6","'.$gr.'",8"]}';
     }

     // szülő elérése
     $db->setQuery('SELECT id FROM #__kunena_categories WHERE alias="T'.$item->temakor_id.'"');
     $res = $db->loadObject();
     if ($res) 
        $parentId = $res->id;
     else
        $parentId = 85; //li-de témakörök  
        
     // meglévő rekord elérése
     $db->setQuery('SELECT id FROM #__kunena_categories WHERE alias="SZ'.$item->id.'"');
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
     $data['alias'] = 'SZ'.$newId;    
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
     } else {
        $category->save();
     }    
     
     return $result;
   }
   /**
     * Új icagenda esemény létrehozása a szavazásokhoz
   */
   protected function createEvent($db, $user, $id, $datum, $szoveg, $temakor_id) {
	   $param = '{"statutReg":"1","accessReg":"","typeReg":"1","maxReg":"","maxRlistGlobal":"","maxRlist":"","RegButtonText":"","RegButtonLink":"","RegButtonLink_Article":"","RegButtonLink_Url":"","RegButtonTarget":"0","atevent":""}';
	   $db->setQuery('INSERT INTO #__icagenda_events 
		VALUES
		(0, 
		0, 
		0, 
		1, 
		0, 
		0, 
		0, 
		"0000-00-00", 
		"'.$szoveg.
		'<br /><br /><a href=\"SU/alternativak/alternativaklist/browse/'.$temakor_id.'/'.$id.'/20/0/6/%7C1\">Ugrás a szavazás oldalára</a>", 
		"sz-'.$id.'-'.$szoveg.'", 
		1, 
		"*", 
		"'.date('Y-m-d H:i:s').'", 
		'.$user->id.', 
		"'.$user->username.'", 
		"'.$user->email.'", 
		0, 
		"", 
		"'.$user->username.'", 
		1, 
		"", 
		"", 
		1, 
		"", 
		"", 
		"'.$datum.' 08:00:00", 
		"'.$datum.' 09:00:00", 
		"a:1:{i:0;s:16:\"'.$datum.' 08:00\"}", 
		"a:1:{i:0;s:16:\"0000-00-00 00:00\"}", 
		"'.$datum.' 08:00:00", 
		"", 
		"", 
		"", 
		"", 
		"", 
		"", 
		"", 
		"", 
		"", 
		"", 
		"0.0000000000000000", 
		"0.0000000000000000", 
		"", 
		"", 
		"", 
		'.$db->quote($param).'
		);
	   ');
	   if ($db->query() == false) {
		   $db->sderr();
		   return;
	   }
   } 
  
   /**
     * icAgenda eseményeklétrehozása, karbantartása
	 * alias = sz-id-szavazás megnevezése
   */
   protected function storeEvent($newId, $item) {
	   $db = JFactory::getDBO();
	   $user = JFactory::getUser();
	   $db->setQuery('delete from #__icagenda_events where alias like "sz-'.$newId.'-%"');
	   if ($db->query() == false) {
		   $db->sderr();
		   return;
	   }
	   $this->createEvent($db,$user,$newId,$item->vita1_vege,$item->megnevezes.' vita1 vége',$item->temakor_id);
	   if ($item->vita2_vege != $item->vita1_vege)
	     $this->createEvent($db,$user,$newId,$item->vita2_vege,$item->megnevezes.' vita2 vége',$item->temakor_id);
	   $this->createEvent($db,$user,$newId,$item->szavazas_vege,$item->megnevezes.' szavazás vége',$item->temakor_id);
   }
  
   /**
    * Content kategória létrehozása az $item -ben lévő szavazáshoz
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
      $db->setQuery('SELECT * FROM #__categories WHERE alias="t'.$item->temakor_id.'"');
      $szulo = $db->loadObject();
      if (!$szulo) {
        $szulo = new stdClass();
        $szulo->id = 0;
      }
      // megvan már a rekord?
      $db->setQuery('SELECT * FROM #__categories WHERE alias="sz'.$newId.'"');
      $old = $db->loadObject();
      
	  
      if ($old == false) {
        $category_data = array();
        $category_data['id'] = 0;
        $category_data['parent_id'] = $szulo->id;
        $category_data['title'] = $item->megnevezes;
        $category_data['description'] = $item->leiras;
        $category_data['alias'] = 'sz'.$newId;
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
        WHERE alias="sz'.$newId.'"');
        $db->query();
        if ($db->getErrorNum() > 0) $db->stderr();
      }
	}
} // class
?>