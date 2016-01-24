<?php

// Ha Jrequest temakor adott akkor ennek a témakörne a szavazásait listázza,
// ha nem adott akkor az összes "aktiv" (nem lezárt) szavazást

jimport('joomla.application.component.modellist');
jimport('joomla.application.component.helper');

JTable::addIncludePath(JPATH_ROOT.'/administrator/components/com_szavazasok/tables');

class SzavazasokModelSzavazasoklist extends JModelList
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
		if ($filterAktiv==1)
		  $lezartLimit = 1;
		else
		  $lezartLimit = 99;
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);			
		$catid = (int) $this->getState('authorlist.id', 1);		
		$query = 'select sz.id, sz.megnevezes,
					   if(sz.vita1>0,"X"," ") vita1,
					   if(sz.vita2>0,"X"," ") vita2,
					   if(sz.szavazas>0,"X"," ") szavazas,
					   if(sz.lezart>0,"X"," ") lezart,
					   sz.szavazas_vege,
					   sz.titkos,
					   szo.user_id,
					   szo.kepviselo_id,
					   sz.leiras
					 from #__szavazasok as sz 
				 left outer join #__szavazok as szo on szo.user_id = "'.$user->id.'" and szo.szavazas_id = sz.id 
				 left outer join #__cimke_szavazasok c on c.cimke="'.$filterStr.'" and c.szavazas_id = sz.id
		';
		if (Jrequest::getVar('temakor') > 0)
		    $query .= ' where sz.temakor_id="'.JRequest::getVar('temakor',0).'" and elbiralas_alatt=0 and sz.elutasitva = "" ';
		else
			$query .= ' where sz.temakor_id > 0 and sz.lezart=0 and elbiralas_alatt=0 and sz.elutasitva = "" ';
		if ($filterStr=='')
			$query .= ' and sz.lezart < '.$lezartLimit;
		else
			$query .= ' and  (sz.megnevezes like "%'.$filterStr.'%" or c.cimke = "'.$filterStr.'") and sz.lezart < '.$lezartLimit;
		if (JRequest::getVar('order')=='')
		  $query .= ' order by 1 DESC';
		else if (JRequest::getVar('order','1')=='1')
		  $query .= ' order by '.JRequest::getVar('order','1');
		else   
		  $query .= ' order by '.JRequest::getVar('order','1');
	  
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