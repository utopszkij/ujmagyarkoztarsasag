<?php

jimport('joomla.application.component.modellist');
jimport('joomla.application.component.helper');

JTable::addIncludePath(JPATH_ROOT.'/administrator/components/com_alternativak/tables');

class AlternativakModelAlternativaklist extends JModelList {
	public function __construct($config = array()) {		
		parent::__construct($config);		
	}
	protected function populateState($ordering = null, $direction = null) 	{
			parent::populateState();
			$app = JFactory::getApplication();
			$id = JRequest::getVar('id', 0, '', 'int');
			$this->setState('alternativaklist.id', $id);			
	}

	protected function getStoreId($id = '') {
		// Compile the store id.
		$id	.= ':'.$this->getState('alternativaklist.id');
		return parent::getStoreId($id);
	}	
	
  
	/**
	 * Method to get a JDatabaseQuery object for retrieving the data set from a database.
	 *
	 * @return	object	A JDatabaseQuery object to retrieve the data set.
	 */
	protected function getListQuery()	{
  	$db		= $this->getDBO();
		$query	= $db->getQuery(true);			
		$query->select('a.*');
		$query->from('#__alternativak as a');
    $query->where('a.szavazas_id="'.JRequest::getVar('szavazas',0).'"');
    $query->order(JRequest::getVar('order','1').' ASC');
		return $query;
	}
}
?>
