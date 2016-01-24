<?php


jimport('joomla.application.component.modellist');
jimport('joomla.application.component.helper');

JTable::addIncludePath(JPATH_ROOT.'/administrator/components/com_temakorok/tables');

class KepviselokModelJelolteklist extends JModelList
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
    $whereStr = 'a.temakor_id="'.JRequest::getVar('temakor').'" and a.user_id <> "'.$user->id.'" and u.block=0';
    if (JRequest::getVar('filterStr') != '') {
      $whereStr .= ' and (a.name like "%'.JRequest::getVar('filterStr').'%" or a.username like "%'.JRequest::getVar('filterStr').'%")';
    }
    $order = JRequest::getVar('order','1'); 
    
    $query = 'select u.name, u.username, u.email, u.id
    from #__kepviselojeloltek a
    left outer join #__users u on u.id = a.user_id
    where '.$whereStr.'
    order by '.$order.',1';
		return $query;
	}	
}