<?php
/**
  * azon szavazaspok amiknél a szavazás folyik 
  */

jimport('joomla.application.component.modellist');
jimport('joomla.application.component.helper');

JTable::addIncludePath(JPATH_ROOT.'/administrator/components/com_szavazasok/tables');

class SzavazasokModelSzavazas_folyik extends JModelList {
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
	$user = JFactory::getUser();	
    $w = explode('|',urldecode(JRequest::getVar('filterStr','')));
    $user = JFactory::getUser();
	if (JRequest::getVar('order',1) < 7) JRequest::setVar('order',7);
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
	/* szavazások amik jelenleg folyamatban vannak */
	/* ================================================ */
	SELECT sz.megnevezes, sz.leiras, sz.vita1, sz.vita2, sz.szavazas, sz.lezart, sz.szavazas_vege, sz.titkos, sz.vita2_vege,
	  sz.id, sz.temakor_id, u.username, sz2.user_id sz2id, datediff(sz.szavazas_vege, curdate()) hatravan
	FROM #__szavazasok sz
	LEFT OUTER JOIN #__users u on u.id = sz.letrehozo
	LEFT OUTER JOIN #__szavazok sz2 on sz2.szavazas_id = sz.id and sz2.user_id = '.$user->id;
	;
	if (JRequest::getVar('temakor') > 0)
	  $query .= ' WHERE (sz.szavazas=1 and sz.temakor_id="'.JRequest::getVar('temakor').'") '.$filterStr;
	else
	  $query .= ' WHERE sz.szavazas=1 '.$filterStr;
    $query .= ' order by '.JRequest::getVar('order','7');
	//DBG echo $query.'<br>';
    return $query;  
	}
	
  /**
   * get total record count
   * @return integer   
   */      
  public function getTotal($filterStr='') {
     $result = 0;
     $db = JFactory::getDBO();
     $query = '/* szavazások amik vita1 statuszban vannak */
		SELECT sz.id
		FROM #__szavazasok sz ';
		if (JRequest::getVar('temakor') > 0)
		  $query .= ' WHERE (sz.szavazas=1) and sz.temakor_id='.JRequest::getVar('temakor').' '.$filterStr;
		else
		  $query .= ' WHERE sz.szavazas=1 '.$filterStr;
	 $db->setQuery($query); 
     $res = $db->loadObjectList();
     $result = count($res);
     return $result;
  }
}