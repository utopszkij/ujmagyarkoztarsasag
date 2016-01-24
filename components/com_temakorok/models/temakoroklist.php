<?php


jimport('joomla.application.component.modellist');
jimport('joomla.application.component.helper');

JTable::addIncludePath(JPATH_ROOT.'/administrator/components/com_temakorok/tables');

class TemakorokModelTemakoroklist extends JModelList
{
	public function __construct($config = array())
	{		
	
		parent::__construct($config);		
	}
	
	protected function populateState($ordering = null, $direction = null)
	{
			parent::populateState();
			$app = JFactory::getApplication();
			$id = JRequest::getVar('id', 0, '', 'int');
			$this->setState('temakoroklist.id', $id);			
	}

	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id	.= ':'.$this->getState('temakoroklist.id');

		return parent::getStoreId($id);
	}	
	
	/**
	 * Method to get a JDatabaseQuery object for retrieving the data set from a database.
	 * @return	object	A JDatabaseQuery object or string to retrieve the data set.
	 * Ez a rutin agetTotal() -ban vés a getItems van használva, 
	 * a getItems() az ezzel elért darabszámokat azonban egy rekurziv eljárást
	 * használva felül írja (altémákban lévő szavazásokat is figyelmebe veszi). 
	 */
	protected function getListQuery()	{
    if (JRequest::getVar('filterStr') != '') {
      $whereStr = 'a.szulo = 0 and a.megnevezes like "%'.JRequest::getVar('filterStr').'%"';
    } else {
      $whereStr = 'a.szulo = 0';
    }
    if (JRequest::getVar('order') != '') {
      $order = JRequest::getVar('order');
    } else {
      $order = '1';
      JRequest::setVar('order','1');
    }
    
    
    $query = 'select a.id,
                     a.megnevezes, 
                     sum(sz.vita1 + sz.vita2) vita,
                     sum(szavazas) szavazas,
                     sum(lezart) lezart,
                     a.allapot,
					 a.leiras
    from #__temakorok a
    left outer join #__szavazasok sz ON sz.temakor_id = a.id
    WHERE '.$whereStr.'
    group by a.id, a.megnevezes  
    order by '.$order.',1';
		return $query;
	}	
  /**
   * egy adott témakörben lévő szavazások darabszámának kiolvasása
   * beleértve az altémakörökben lévőket is (rekurziv fv) a getItems() használja
   * @param integer temakor_id
   * @return object {id,megnevezes,vita,szavazas,lezart,allapot}
   */
  protected function getItem_r($temakor_id = 0) {
     $db = JFactory::getDBO();
     $db->setQuery('select a.id,
                     a.megnevezes, 
                     sum(sz.vita1 + sz.vita2) vita,
                     sum(szavazas) szavazas,
                     sum(lezart) lezart,
                     a.allapot,
					 a.leiras
     from #__temakorok a
     left outer join #__szavazasok sz ON sz.temakor_id = a.id
     WHERE a.id = "'.$temakor_id.'"
     group by a.id, a.megnevezes');
     $result = $db->loadObject();
     if ($db->getErrorNum() > 0) $db->sdError();
     $db->setQuery('select id from #__temakorok where szulo="'.$temakor_id.'"');
     $altemak = $db->loadObjectList();
     if ($db->getErrorNum() > 0) $db->sdError();
     foreach ($altemak as $altema) {
       $w = $this->getItem_r($altema->id);
       $result->vita = $result->vita + $w->vita;
       $result->szavazas = $result->szavazas + $w->szavazas;
       $result->lezart = $result->lezart + $w->lezart;
     }
     $altemak = 0;
     return $result;
  }                
  
  /**
   * elemek beolvasása 
   * @reguest integer limitstart
   * @reguest integer limit
   * @reguest integer order
   * @reguest string filterStr
   * @return arry of record
   */
   public function getItems() {
     $db = JFactory::getDBO();
     $query = $this->getListQuery();
     $limitstart = JRequest::getVar('limitstart',0);
     $limit = JRequest::getVar('limit',20);
     $query .= ' limit '.$limitstart.','.$limit;
     $db->setQuery($query);
     $res = $db->loadObjectList();
     for ($i=0; $i<count($res); $i++) {
       $res[$i] = $this->getItem_r($res[$i]->id);
     }
     return $res;
   }            

}