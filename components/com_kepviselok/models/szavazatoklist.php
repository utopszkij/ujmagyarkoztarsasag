<?php


jimport('joomla.application.component.modellist');
jimport('joomla.application.component.helper');

JTable::addIncludePath(JPATH_ROOT.'/administrator/components/com_temakorok/tables');

class KepviselokModelSzavazatoklist extends JModelList
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
    $user = JFactory::getUser();
    $temakor_id = JRequest::getVar('temakor');
    $id = JRequest::getVar('id');
    $order = JRequest::getVar('order','1');
    if ($order == '1')
      $worder = '1,2,3,4';
    else if ($order == '2')
      $worder = '2,1,3,4';
    else 
      $worder = '2,2,1,4';
    $query = 'select t.megnevezes tmegnevezes,
                     sz2.megnevezes szmegnevezes,
                     sz3.idopont,
                     sz1.pozicio,
                     a.megnevezes amegnevezes,
                     t.id, t.lathatosag
    from #__szavazatok sz1
    left outer join #__szavazasok sz2 on sz2.id = sz1.szavazas_id
    left outer join #__szavazok sz3 on sz3.szavazas_id = sz1.szavazas_id and sz3.user_id = "'.$id.'"
    left outer join #__temakorok t on t.id = sz1.temakor_id
    left outer join #__alternativak a on a.id = sz1.alternativa_id
    where sz1.user_id="'.$id.'" and (sz1.temakor_id = "'.$temakor_id.'" or "'.$temakor_id.'"=0)
    order by '.$worder;
		return $query;
	}	
}