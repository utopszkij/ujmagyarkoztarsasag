<?php

// Ha Jrequest temakor adott akkor ennek a témakörne a szavazásait listázza,
// ha nem adott akkor az összes "aktiv" (nem lezárt) szavazást

jimport('joomla.application.component.modellist');
jimport('joomla.application.component.helper');

JTable::addIncludePath(JPATH_ROOT.'/administrator/components/com_szavazasok/tables');

class SzavazasokModelElutasitottak extends JModelList
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
		$lezartLimit = 99;
		if (JRequest::getVar('order') > 4) JRequest::setvar('order',1);
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);			
		$catid = (int) $this->getState('authorlist.id', 1);		
		$query = 'select sz.id, sz.megnevezes,
					   sz.letrehozva,
					   u.username,
					   sz.elutasitva
					 from #__szavazasok as sz 
				 left outer join #__users as u on u.id = sz.letrehozo 
				 left outer join #__cimke_szavazasok c on c.cimke="'.$filterStr.'" and c.szavazas_id = sz.id
		';
		if (Jrequest::getVar('temakor') > 0)
		    $query .= ' where sz.temakor_id="'.JRequest::getVar('temakor',0).'" and  sz.elutasitva <> "" ';
		else
			$query .= ' where sz.temakor_id > 0 and sz.elutasitva <> "" ';
		if ($filterStr=='')
			$query .= ' and sz.lezart < '.$lezartLimit;
		else
			$query .= ' and  (sz.megnevezes like "%'.$filterStr.'%" or c.cimke = "'.$filterStr.'") and sz.lezart < '.$lezartLimit;
		if ((JRequest::getVar('order')=='') | (JRequest::getVar('order') < 2))	JRequest::setVar('order',2);
		$query .= ' order by '.JRequest::getVar('order');
	  
	    //DBG echo $query;
		
		return $query;  
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