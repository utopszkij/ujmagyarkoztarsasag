<?php

// szavazhatok és aktuális szavazások model
// ha JRequest::getVar('aktualis=1') akkor az aktuális szavazásokat kell kigyüjten
// egyébként ahol most szavazhatok

jimport('joomla.application.component.modellist');
jimport('joomla.application.component.helper');

JTable::addIncludePath(JPATH_ROOT.'/administrator/components/com_szavazasok/tables');

class SzavazasokModelSzavazhatok extends JModelList {
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
	// aktuális szavazásokat kell kigyüjteni (0-ás szavazok rekord soha nincsen)
	if (JRequest::getVar('aktualis')==1) $user->id = 0;
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
    /* szavazások ahol jelenleg szavazhatok */
/* ==================================== */
/* ahol minden regisztrált szavazhat */
SELECT sz.megnevezes, sz.leiras, sz.vita1, sz.vita2, sz.szavazas, sz.lezart, sz.szavazas_vege, sz.titkos, szk.user_id,
  sz.id, sz.temakor_id
FROM #__szavazasok sz
INNER join #__temakorok te ON te.id = sz.temakor_id
LEFT OUTER JOIN #__szavazok szk ON szk.szavazas_id = sz.id AND szk.user_id = "'.$user->id.'"
WHERE sz.szavazok<=1 AND sz.szavazas=1 AND szk.user_id IS NULL '.$filterStr.'
/* ahol a tagok szavazhatnak és én tag vagyok */
UNION 
SELECT sz.megnevezes, sz.leiras, sz.vita1, sz.vita2, sz.szavazas, sz.lezart, sz.szavazas_vege, sz.titkos, szk.user_id,
  sz.id, sz.temakor_id
FROM #__szavazasok sz
INNER join #__temakorok te ON te.id = sz.temakor_id
INNER JOIN #__tagok t ON t.temakor_id = sz.temakor_id AND t.user_id='.$user->id.'
LEFT OUTER JOIN #__szavazok szk ON szk.szavazas_id = sz.id AND szk.user_id = '.$user->id.'
WHERE sz.szavazok=2 AND sz.szavazas=1 AND szk.user_id IS NULL '.$filterStr.'
/* ahol a felsöbb szintű témakör tagjai szavazhatnak és én ott tag vagyok   1 */
UNION 
SELECT sz.megnevezes, sz.leiras, sz.vita1, sz.vita2, sz.szavazas, sz.lezart, sz.szavazas_vege, sz.titkos, szk.user_id,
  sz.id, sz.temakor_id
FROM #__szavazasok sz
INNER JOIN #__temakorok tk ON tk.id = sz.temakor_id
INNER JOIN #__tagok t ON t.temakor_id = tk.szulo AND t.user_id='.$user->id.'
LEFT OUTER JOIN #__szavazok szk ON szk.szavazas_id = sz.id AND szk.user_id = '.$user->id.'
WHERE sz.szavazok=3 AND sz.szavazas=1 AND szk.user_id IS NULL '.$filterStr.'
/* ahol a felsöbb szintű témakör tagjai szavazhatnak és én ott tag vagyok   2 */
UNION 
SELECT sz.megnevezes, sz.leiras, sz.vita1, sz.vita2, sz.szavazas, sz.lezart, sz.szavazas_vege, sz.titkos, szk.user_id,
  sz.id, sz.temakor_id
FROM #__szavazasok sz
INNER JOIN #__temakorok tk ON tk.id = sz.temakor_id
INNER JOIN #__temakorok tk1 ON tk1.id = tk.szulo
INNER JOIN #__tagok t ON t.temakor_id = tk1.szulo AND t.user_id='.$user->id.'
LEFT OUTER JOIN #__szavazok szk ON szk.szavazas_id = sz.id AND szk.user_id = '.$user->id.'
WHERE sz.szavazok=3 AND sz.szavazas=1 AND szk.user_id IS NULL '.$filterStr.'
/* ahol a felsöbb szintű témakör tagjai szavazhatnak és én ott tag vagyok   3 */
UNION 
SELECT sz.megnevezes, sz.leiras, sz.vita1, sz.vita2, sz.szavazas, sz.lezart, sz.szavazas_vege, sz.titkos, szk.user_id,
  sz.id, sz.temakor_id
FROM #__szavazasok sz
INNER JOIN #__temakorok tk ON tk.id = sz.temakor_id
INNER JOIN #__temakorok tk1 ON tk1.id = tk.szulo
INNER JOIN #__temakorok tk2 ON tk2.id = tk1.szulo
INNER JOIN #__tagok t ON t.temakor_id = tk2.szulo AND t.user_id='.$user->id.'
LEFT OUTER JOIN #__szavazok szk ON szk.szavazas_id = sz.id AND szk.user_id = '.$user->id.'
WHERE sz.szavazok=3 AND sz.szavazas=1 AND szk.user_id IS NULL '.$filterStr.'
/* ahol a felsöbb szintű témakör tagjai szavazhatnak és én ott tag vagyok   4 */
UNION 
SELECT sz.megnevezes, sz.leiras, sz.vita1, sz.vita2, sz.szavazas, sz.lezart, sz.szavazas_vege, sz.titkos, szk.user_id,
  sz.id, sz.temakor_id
FROM #__szavazasok sz
INNER JOIN #__temakorok tk ON tk.id = sz.temakor_id
INNER JOIN #__temakorok tk1 ON tk1.id = tk.szulo
INNER JOIN #__temakorok tk2 ON tk2.id = tk1.szulo
INNER JOIN #__temakorok tk3 ON tk3.id = tk2.szulo
INNER JOIN #__tagok t ON t.temakor_id = tk3.szulo AND t.user_id='.$user->id.'
LEFT OUTER JOIN #__szavazok szk ON szk.szavazas_id = sz.id AND szk.user_id = '.$user->id.'
WHERE sz.szavazok=3 AND sz.szavazas=1 AND szk.user_id IS NULL '.$filterStr.'
';
    $query .= ' order by '.JRequest::getVar('order','6');
    return $query;  
	}
  /**
   * get total record count
   * @return integer   
   */      
  public function getTotal($filterStr='') {
     $result = 0;
     $db = JFactory::getDBO();
	 $user = JFactory::getUser();
	 // aktuális szavazásokat kell kigyüjteni (0-ás szavazok rekord soha nincsen)
	 if (JRequest::getVar('aktualis')==1) $user->id = 0;
	 
     $db->setQuery('
    /* szavazások ahol jelenleg szavazhatok */
/* ==================================== */
/* ahol minden regisztrált szavazhat */
SELECT sz.id
FROM #__szavazasok sz
INNER join #__temakorok te ON te.id = sz.temakor_id
LEFT OUTER JOIN #__szavazok szk ON szk.szavazas_id = sz.id AND szk.user_id = '.$user->id.'
WHERE sz.szavazok=1 AND sz.szavazas=1 AND szk.user_id IS NULL '.$filterStr.'
/* ahol a tagok szavazhatnak és én tag vagyok */
UNION 
SELECT sz.id
FROM #__szavazasok sz
INNER join #__temakorok te ON te.id = sz.temakor_id
INNER JOIN #__tagok t ON t.temakor_id = sz.temakor_id AND t.user_id='.$user->id.'
LEFT OUTER JOIN #__szavazok szk ON szk.szavazas_id = sz.id AND szk.user_id = '.$user->id.'
WHERE sz.szavazok=2 AND sz.szavazas=1 AND szk.user_id IS NULL '.$filterStr.'
/* ahol a felsöbb szintű témakör tagjai szavazhatnak és én ott tag vagyok   1 */
UNION 
SELECT sz.id
FROM #__szavazasok sz
INNER JOIN #__temakorok tk ON tk.id = sz.temakor_id
INNER JOIN #__tagok t ON t.temakor_id = tk.szulo AND t.user_id='.$user->id.'
LEFT OUTER JOIN #__szavazok szk ON szk.szavazas_id = sz.id AND szk.user_id = '.$user->id.'
WHERE sz.szavazok=3 AND sz.szavazas=1 AND szk.user_id IS NULL '.$filterStr.'
/* ahol a felsöbb szintű témakör tagjai szavazhatnak és én ott tag vagyok   2 */
UNION 
SELECT sz.id
FROM #__szavazasok sz
INNER JOIN #__temakorok tk ON tk.id = sz.temakor_id
INNER JOIN #__temakorok tk1 ON tk1.id = tk.szulo
INNER JOIN #__tagok t ON t.temakor_id = tk1.szulo AND t.user_id='.$user->id.'
LEFT OUTER JOIN #__szavazok szk ON szk.szavazas_id = sz.id AND szk.user_id = '.$user->id.'
WHERE sz.szavazok=3 AND sz.szavazas=1 AND szk.user_id IS NULL '.$filterStr.'
/* ahol a felsöbb szintű témakör tagjai szavazhatnak és én ott tag vagyok   3 */
UNION 
SELECT sz.id
FROM #__szavazasok sz
INNER JOIN #__temakorok tk ON tk.id = sz.temakor_id
INNER JOIN #__temakorok tk1 ON tk1.id = tk.szulo
INNER JOIN #__temakorok tk2 ON tk2.id = tk1.szulo
INNER JOIN #__tagok t ON t.temakor_id = tk2.szulo AND t.user_id='.$user->id.'
LEFT OUTER JOIN #__szavazok szk ON szk.szavazas_id = sz.id AND szk.user_id = '.$user->id.'
WHERE sz.szavazok=3 AND sz.szavazas=1 AND szk.user_id IS NULL '.$filterStr.'
/* ahol a felsöbb szintű témakör tagjai szavazhatnak és én ott tag vagyok   4 */
UNION 
SELECT sz.id
FROM #__szavazasok sz
INNER JOIN #__temakorok tk ON tk.id = sz.temakor_id
INNER JOIN #__temakorok tk1 ON tk1.id = tk.szulo
INNER JOIN #__temakorok tk2 ON tk2.id = tk1.szulo
INNER JOIN #__temakorok tk3 ON tk3.id = tk2.szulo
INNER JOIN #__tagok t ON t.temakor_id = tk3.szulo AND t.user_id='.$user->id.'
LEFT OUTER JOIN #__szavazok szk ON szk.szavazas_id = sz.id AND szk.user_id = '.$user->id.'
WHERE sz.szavazok=3 AND sz.szavazas=1 AND szk.user_id IS NULL '.$filterStr.'
     '
     );
     
     //DBG echo '<hr>'.$db->getQuery().'<hr>';
     
     $res = $db->loadObjectList();
     $result = count($res);
     return $result;
  }
}