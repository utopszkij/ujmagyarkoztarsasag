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
	 *
	 * @return	object	A JDatabaseQuery object or string to retrieve the data set.
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
                     a.allapot
    from #__temakorok a
    left outer join (
       /* közvetlenül a témakörhöz tartozó szavazások
       SELECT sz2.temakor_id, sz2.vita1, sz2.vita2, sz2.szavazas, sz2.lezart  
       FROM #__temakorok t1 
       LEFT OUTER JOIN #__szavazasok sz2 ON sz2.temakor_id = t1.id
       WHERE t1.szulo=0

       /* első szintű alketegoriákhoz tartozó szavazások */
       UNION ALL
       SELECT t2.id, sz2.vita1, sz2.vita2, sz2.szavazas, sz2.lezart  
       FROM #__temakorok t2
       LEFT OUTER JOIN #__temakorok t1 ON t1.szulo = t2.id 
       LEFT OUTER JOIN #__szavazasok sz2 ON sz2.temakor_id = t1.id
       WHERE t2.szulo=0
       
       /* második szintű alketegoriákhoz tartozó szavazások */
       UNION ALL
       SELECT t3.id, sz2.vita1, sz2.vita2, sz2.szavazas, sz2.lezart  
       FROM #__temakorok t3
       LEFT OUTER JOIN #__temakorok t2 ON t2.szulo = t3.id 
       LEFT OUTER JOIN #__temakorok t1 ON t1.szulo = t2.id 
       LEFT OUTER JOIN #__szavazasok sz2 ON sz2.temakor_id = t1.id
       WHERE t3.szulo=0
       
       /* harmadik szintű alketegoriákhoz tartozó szavazások */
       UNION ALL
       SELECT t4.id, sz2.vita1, sz2.vita2, sz2.szavazas, sz2.lezart  
       FROM #__temakorok t4
       LEFT OUTER JOIN #__temakorok t3 ON t3.szulo = t4.id 
       LEFT OUTER JOIN #__temakorok t2 ON t2.szulo = t3.id 
       LEFT OUTER JOIN #__temakorok t1 ON t1.szulo = t2.id 
       LEFT OUTER JOIN #__szavazasok sz2 ON sz2.temakor_id = t1.id
       WHERE t4.szulo=0
    
    ) sz ON sz.temakor_id = a.id    
    where '.$whereStr.'
    group by a.id, a.megnevezes  
    order by '.$order.',1';
		return $query;
	}	
}