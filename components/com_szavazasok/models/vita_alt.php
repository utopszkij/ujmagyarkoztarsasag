<?php
/**
  * azon szavazaspok amik vita1 statuszban vannak 
  */

jimport('joomla.application.component.modellist');
jimport('joomla.application.component.helper');

JTable::addIncludePath(JPATH_ROOT.'/administrator/components/com_szavazasok/tables');

class SzavazasokModelVita_alt extends JModelList {
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
		$db		= $this->getDbo();
		$w = explode('|',urldecode(JRequest::getVar('filterStr','')));
		$user = JFactory::getUser();
		$filterStr = $w[0];
		$filterAktiv = $w[1];
		if ($filterAktiv==1)
		  $lezartLimit = 1;
		else
		  $lezartLimit = 99;
		if ($filterStr != '') {
		  $filterStr = ' and sz.megnevezes like "%'.$db->quote($filterStr).'%"';
		} else {
		  $filterStr = '';	
		}
		if ((JRequest::getVar('temakor') != '') & (JRequest::getVar('temakor') != 0))
		  $filterStr .= ' and sz.temakor_id='.$db->quote(JRequest::getVar('temakor')); 	
		$query	= $db->getQuery(true);			
		$catid = (int) $this->getState('authorlist.id', 1);		
		$query = '/* szavazások amik jelenleg vita1 állapotban vannak */
		/* ================================================ */
		SELECT sz.megnevezes, sz.leiras, sz.vita1, sz.vita2, sz.szavazas, sz.lezart, sz.szavazas_vege, sz.titkos, sz.vita1_vege,
		  sz.id, sz.temakor_id, sz.letrehozo, u.username, datediff(sz.vita1_vege, curdate()) hatravan,
		  r.rating_sum, r.rating_count
		FROM #__szavazasok sz
		LEFT OUTER JOIN #__users u on u.id = sz.letrehozo
		LEFT OUTER JOIN #__content c on c.alias = concat("sz",sz.id)
		LEFT OUTER JOIN #__content_rating r on r.content_id = c.id
		WHERE (sz.vita1=1) and sz.elbiralas_alatt=0 and sz.elutasitva = "" '.$filterStr;
		$query .= ' order by '.JRequest::getVar('order','9');
		//DBG echo $query.'<br>';
		return $query;  
	}
	
  /**
   * get total record count
   * @return integer   
   */      
  public function getTotal($filterStr='') {
    $db = JFactory::getDBO();
    if ($filterStr != '') {
      $filterStr = ' and sz.megnevezes like "%'.$filterStr.'%"';
    }  
	if ((JRequest::getVar('temakor') != '') & (JRequest::getVar('temakor') != 0))
      $filterStr .= ' and sz.temakor_id='.$db->quote(JRequest::getVar('temakor')); 	
    $result = 0;
    $db->setQuery('
/* szavazások amik vita1 statuszban vannak */
SELECT sz.id
FROM #__szavazasok sz
WHERE (sz.vita1=1) and sz.elbiralas_alatt=0 and sz.elutasitva = "" '.$filterStr);
     $res = $db->loadObjectList();
     $result = count($res);
     return $result;
  }
  /**
   * get altémák
   * @return mysql recordset
   * @Jrequest integer $temakor
   */            
  public function getAltemak() {
  	$sql1 = 'select t.id, t.megnevezes
		         FROM #__temakorok as t
             WHERE t.szulo = "'.JRequest::getVar('temakor',0).'"';
    $db = JFactory::getDBO();
    $db->setQuery($sql1);
	
	//DBG echo $db->getQuery();
	
    return $db->loadObjectList();
  }  
}