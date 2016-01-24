##codestart##


jimport('joomla.application.component.modellist');
jimport('joomla.application.component.helper');

JTable::addIncludePath(JPATH_ROOT.'/administrator/components/com_##component##/tables');

class ##Component##Model##Name##list extends JModelList
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
			$this->setState('##name##list.id', $id);			
	}

	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id	.= ':'.$this->getState('##name##list.id');

		return parent::getStoreId($id);
	}	
	
	/**
	 * Method to get a JDatabaseQuery object for retrieving the data set from a database.
	 *
	 * @return	object	A JDatabaseQuery object to retrieve the data set.
	 */
	protected function getListQuery()
	{
		
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);			
		
		$catid = (int) $this->getState('authorlist.id', 1);	
##ifdefFieldaliasStart##
		$query->select('a.*, '
		. ' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(\':\', a.id, a.alias) ELSE a.id END as slug');
##ifdefFieldaliasEnd##
##ifnotdefFieldaliasStart##		
		$query->select('a.*');
##ifnotdefFieldaliasEnd##
		$query->from('##table## as a');
##ifdefFieldpublishedStart##	
		$query->where('a.published>0');
##ifdefFieldpublishedEnd##					
		return $query;
	}	
}