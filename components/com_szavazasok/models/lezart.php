<?php
/**
  * azon szavazaspok amiknél a szavazás folyik 
  */

jimport('joomla.application.component.modellist');
jimport('joomla.application.component.helper');

JTable::addIncludePath(JPATH_ROOT.'/administrator/components/com_szavazasok/tables');

class SzavazasokModelLezart extends JModelList {
	public function __construct($config = array())
	{		
	
		parent::__construct($config);		
	}
	
	protected function populateState($ordering = null, $direction = null)
	{
			parent::populateState();
			$app = JFactory::getApplication();
			$id = JRequest::getVar('id', 0, '', 'int');
			$this->setState('szavazasoklist.id', $id);			
	}

	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id	.= ':'.$this->getState('szavazasoklist.id');
		return parent::getStoreId($id);
	}	
	
	/**
	 * Method to get a JDatabaseQuery object for retrieving the data set from a database.
	 *
	 * @return	object	A JDatabaseQuery object to retrieve the data set.
	 */
	protected function getListQuery()	{
		$w = explode('|',urldecode(JRequest::getVar('filterStr','')));
		$user = JFactory::getUser();
		$filterStr = $w[0];
		$filterAktiv = $w[1];
		if ($filterAktiv==1)
		  $lezartLimit = 1;
		else
		  $lezartLimit = 99;
		if ($filterStr != '') {
		  $filterStr = ' and sz.megnevezes like "%'.$filterStr.'%"';
		}  
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);			
		$catid = (int) $this->getState('authorlist.id', 1);		
		$query = '
		/* szavazások amik jelenleg vita1 állapotban vannak */
		/* ================================================ */
		SELECT sz.megnevezes, sz.leiras, sz.vita1, sz.vita2, sz.szavazas, sz.lezart, sz.szavazas_vege, sz.titkos, sz.vita2_vege,
		  sz.id, sz.temakor_id, sz2.id sz2id
		FROM #__szavazasok sz
		LEFT OUTER JOIN #__szavazok sz2 on sz2.user_id = "'.$user->id.'" and sz2.szavazas_id = sz.id
		';
		if (JRequest::getVar('temakor') > 0)
		   $query .= 'WHERE (sz.lezart=1 and sz.temakor_id="'.JRequest::getVar('temakor').'") '.$filterStr;
		else
		   $query .= 'WHERE (sz.lezart=1 '.$filterStr;
		$query .= ' order by '.JRequest::getVar('order','6').' DESC';
		return $query;  
	}
	
  /**
   * get total record count
   * @return integer   
   */      
  public function getTotal($filterStr='') {
     $result = 0;
     $db = JFactory::getDBO();
     $query = '/* szavazások amik lezártak */
		SELECT sz.id
		FROM #__szavazasok sz ';
	 if (JRequest::getVar('temakor') > 0)
		$query .= ' WHERE (sz.lezart=1 and sz.temakor_id="'.JRequest::getVar('temakor').'") '.$filterStr;
	 else 
		$query .= ' WHERE sz.lezart=1 '.$filterStr;
	 $db->setQuery($query);
     $res = $db->loadObjectList();
     $result = count($res);
     return $result;
  }
}