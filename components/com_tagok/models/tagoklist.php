<?php


jimport('joomla.application.component.modellist');
jimport('joomla.application.component.helper');

JTable::addIncludePath(JPATH_ROOT.'/administrator/components/com_tagok/tables');

class TagokModelTagoklist extends JModelList
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
			$this->setState('tagoklist.id', $id);			
	}

	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id	.= ':'.$this->getState('tagoklist.id');

		return parent::getStoreId($id);
	}	
	
	/**
	 * Method to get a JDatabaseQuery object for retrieving the data set from a database.
	 *
	 * @return	object	A JDatabaseQuery object to retrieve the data set.
	 */
	protected function getListQuery()
	{
    // valamiért a lapozás nem akar jó lenni, áthidaló megoldás
    //JRequest::setVar('limit','200');
    		
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);			
		$catid = (int) $this->getState('authorlist.id', 1);
    $limitStart = JRequest::getVar('limitstart',0);
    if (JRequest::getVar('filterStr')!='')
      $filter = ' and (u.name like "%'.JRequest::getVar('filterStr').'%" or u.username like "%'.JRequest::getVar('filterStr').'%")';
    else
      $filter = '';
    $order = JRequest::getVar('order',1);
    if ($order == 5) {
      $order = '5 DESC';
    }
    if (JRequest::getVar('task') == 'ujTag') {
      /*
      $query = 'select u.*
      from #__users u
      left outer join #__tagok t on t.user_id = u.id and t.temakor_id="'.JRequest::getVar('temakor').'" 
      where t.id is null '.$filter.'
      order by '.JRequest::getVar('order');
      */
		  $query->select('u.*');
		  $query->from('#__users u left outer join #__tagok t on t.user_id = u.id and t.temakor_id="'.JRequest::getVar('temakor',0).'"');
		  $query->where('t.id is null and u.block = 0 '.$filter);
      $query->order($order);
    } else if (JRequest::getVar('temakor',0) > 0) {		
		  $query->select('u.id, u.name, u.username, if(a.admin=1,"ADMIN","") admin, count(distinct k.user_id) kepviselt');
		  $query->from('#__tagok as a
                    inner join #__users u on a.user_id = u.id
                    left outer join #__kepviselok k on k.kepviselo_id = a.user_id and 
                       (k.temakor_id = '.JRequest::getVar('temakor',0).' or k.temakor_id = 0)');
		  $query->where('a.temakor_id="'.JRequest::getvar('temakor',0).'" and u.block = 0 '.$filter);
      $query->group('u.id, u.name, u.username');
      $query->order($order);
		}	else {
		  $query->select('u.id, u.name, u.username, if(max(m.group_id)>=6,"ADMIN","") admin, count(distinct k.user_id) kepviselt');
		  $query->from('#__users u
                   inner join #__user_usergroup_map m on u.id = m.user_id
                   left outer join #__kepviselok k on k.kepviselo_id = u.id');
      $query->where('u.id = m.user_id  and u.block = 0 '.$filter);
      $query->group('u.id,u.name,u.username');
      $query->order($order);
    }	
    return $query;
	}	
}