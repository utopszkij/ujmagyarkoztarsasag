  <?php
 defined('_JEXEC') or die('Restricted access');
/**
* @version		$Id:kepviselojeloltek.php  1 2014-05-11 07:38:36Z FT $
* @package		Kepviselojeloltek
* @subpackage 	Models
* @copyright	Copyright (C) 2014, Fogler Tibor. All rights reserved.
* @license #GNU/GPL
*/
 defined('_JEXEC') or die('Restricted access');
/**
 * KepviselojeloltekModelKepviselojeloltek 
 * @author Fogler Tibor
 */
 
 
class KepviselojeloltekModelKepviselojeloltek  extends KepviselojeloltekModel { 

	
	
	protected $_default_filter = 'a.id';   

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
    //2014.05.11 nem értem miért nem tárol user_id és temakor_id adatot...

    /* DBG
    foreach ($data as $fn => $fv) echo '<p>data '.$fn.'='.$fv.'</p>'; 
    foreach ($_POST['jform'] as $fn => $fv) echo '<p>POST_jform '.$fn.'='.$fv.'</p>'; 
    foreach ($_POST as $fn => $fv) echo '<p>POST '.$fn.'='.$fv.'</p>'; 
    foreach ($_GET as $fn => $fv) echo '<p>GET '.$fn.'='.$fv.'</p>'; 
    foreach ($row as $fn => $fv) echo '<p>row '.$fn.'='.$fv.'</p>'; 
    exit();

    $db = JFactory::getDBO();
    $db->setQuery('update #__kepviselojeloltek
    set user_id = "'.$row->user_id.'",
    temakor_id = "'.$row->temakor_id.'"
    where id ="'.$row->id.'"');
    $db->query();
    */
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
		
		$filter_order = $app ->getUserStateFromRequest($context . 'filter_order', 'filter_order', $this->getDefaultFilter(), 'cmd');
		$filter_order_Dir = $app ->getUserStateFromRequest($context . 'filter_order_Dir', 'filter_order_Dir', 'desc', 'word');
		$search = $app ->getUserStateFromRequest($context . 'search', 'search', '', 'string');
					
		if ($search) {
			$this->_query->where('LOWER(a.id) LIKE ' . $this->_db->Quote('%' . $search . '%'));			
		}
		
	}
	
}
?>