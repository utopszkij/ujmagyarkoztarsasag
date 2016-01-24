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
      $whereStr = 'a.megnevezes like "%'.JRequest::getVar('filterStr').'%"';
    } else {
      $whereStr = '1';
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
    left outer join #__szavazasok sz on sz.temakor_id = a.id
    where '.$whereStr.'
    group by a.megnevezes  
    order by '.$order.',1';
		return $query;
	}	
}