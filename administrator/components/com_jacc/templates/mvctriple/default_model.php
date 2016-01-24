 <?php defined('_JEXEC') or die('Restricted access'); ?>
 ##codestart##
 defined('_JEXEC') or die('Restricted access');
/**
* @version		$Id:##name##.php  1 ##date##Z ##sauthor## $
* @package		##Component##
* @subpackage 	Models
* @copyright	Copyright (C) ##year##, ##author##. All rights reserved.
* @license ###license##
*/
 defined('_JEXEC') or die('Restricted access');
/**
 * ##Component##Model##Name## 
 * @author ##author##
 */
 
 
class ##Component##Model##Name##  extends ##Component##Model { 

	
	
	protected $_default_filter = 'a.<?php echo $this->hident ?>';   

/**
 * Constructor
 */
	
	public function __construct()
	{
		parent::__construct();

	}

	/**
	* Method to build the query
	*
	* @access private
	* @return string query	
	*/

	protected function _buildQuery()
	{
		return parent::_buildQuery();
	}
	
	/**
	 * Method to store the Item
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	public function store($data)
	{
		$row =& $this->getTable();
		/**
		 * Example: get text from editor 
		 * $Text  = JRequest::getVar( 'text', '', 'post', 'string', JREQUEST_ALLOWRAW );
		 */
		 
		// Bind the form fields to the table
		if (!$row->bind($data)) {
			$this->setError($row->getError());
			return false;
		}

		// Make sure the table is valid
		if (!$row->check()) {
			$this->setError($row->getError());
			return false;
		}
		
		/**
		 * Clean text for xhtml transitional compliance
		 * $row->text		= str_replace( '<br>', '<br />', $Text );
		 */
	
		// Store the table to the database
		if (!$row->store()) {
			$this->setError($row->getError());
			return false;
		}
		$this->setId($row->{$row->getKeyName()});
		return $row->{$row->getKeyName()};
	}	

	/**
	* Method to build the Order Clause
	*
	* @access private
	* @return string orderby	
	*/
	
	protected function _buildContentOrderBy() 
	{
		$app = &JFactory::getApplication('');
		$context			= $this->option.'.'.strtolower($this->getName()).'.list.';
		$filter_order = $app ->getUserStateFromRequest($context . 'filter_order', 'filter_order', $this->getDefaultFilter(), 'cmd');
		$filter_order_Dir = $app ->getUserStateFromRequest($context . 'filter_order_Dir', 'filter_order_Dir', '', 'word');
		$this->_query->order($filter_order . ' ' . $filter_order_Dir );
	}
	
	/**
	* Method to build the Where Clause 
	*
	* @access private
	* @return string orderby	
	*/
	
	protected function _buildContentWhere() 
	{
		
		$app = &JFactory::getApplication('');
		$context			= $this->option.'.'.strtolower($this->getName()).'.list.';
##ifdefFieldpublishedStart##		
		$filter_state = $app ->getUserStateFromRequest($context . 'filter_state', 'filter_state', '', 'word');
##ifdefFieldpublishedEnd##		
		$filter_order = $app ->getUserStateFromRequest($context . 'filter_order', 'filter_order', $this->getDefaultFilter(), 'cmd');
		$filter_order_Dir = $app ->getUserStateFromRequest($context . 'filter_order_Dir', 'filter_order_Dir', 'desc', 'word');
		$search = $app ->getUserStateFromRequest($context . 'search', 'search', '', 'string');
					
		if ($search) {
			$this->_query->where('LOWER(a.<?php echo $this->hident ?>) LIKE ' . $this->_db->Quote('%' . $search . '%'));			
		}
##ifdefFieldpublishedStart##		
		if ($filter_state) {
			if ($filter_state == 'P') {
				$this->_query->where("a.published = 1");
			} elseif ($filter_state == 'U') {
					$this->_query->where("a.published = 0");
			} else {
				$this->_query->where("a.published > -2");
			}
		} 
##ifdefFieldpublishedEnd##		
	}
	
}
##codeend##