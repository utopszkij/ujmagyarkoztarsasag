<?php 
/**
* @version		$Id:Model.php  1 2014-04-24Z FT $
* @package		Alternativak
* @subpackage 	Models
* @copyright	Copyright (C) 2014, Fogler Tibor. All rights reserved.
* @license #GNU/GPL
*/
// no direct access
defined('_JEXEC') or die('Restricted access');
/**
 * Model
 * @author Michael Liebler
 */
 
jimport( 'joomla.application.component.model' ); 

class AlternativakModel  extends JModelLegacy { 

  
	/**
	 * Items data array
	 *
	 * @var array
	 */
	protected $_data = null;

	/**
	 * Items total
	 *
	 * @var integer
	 */
	protected $_total = null;

	/**
	 * ID
	 *
	 * @var integer
	 */
	
	protected $_id = null;

	/**
	 * Default Filter
	 *
	 * @var mixed
	 */
	
	protected $_default_filter = null;

	/**
	 * Default Filter
	 *
	 * @var mixed
	 */
	
	protected $_default_table = null;

		
	/**
	 * @var		string	The URL option for the component.	
	 */
	protected $option = null;
		
	/**
	 * @var		string	context	the context to find session data.	
	 */		
	protected $_context = null;		
	
	/**
 	* Constructor
 	*/
	
	public function __construct()
	{
		parent::__construct();
			$app = &JFactory::getApplication('site');
			// Guess the option from the class name (Option)Model(View).
		if (empty($this->option)) {
			$r = null;
			if (!preg_match('/(.*)Model/i', get_class($this), $r)) {
				JError::raiseError(500, JText::_('No Model Name'));
			}
			$this->option = 'com_'.strtolower($r[1]);
		}		
		
		$db = $this->getDbo();
		$this->_query = $db->getQuery(true);  
		
		$table = $this->getTable();
		if($table) {
			$this->_default_table = $table->getTableName(); 
			if(isset($table->published))  $this->_state_field = 'published';
		}
		
		if (empty($this->_context)) {
			$this->_context = $this->option.'.'.$this->getName();
		}
		
		$array = JRequest :: getVar('cid', array (
			0
		), '', 'array');
		$edit = JRequest :: getVar('edit', true);
		if ($edit) {
			$this->setId((int) $array[0]);
		}
		// Get the pagination request variables
	
		$limit		= $app ->getUserStateFromRequest( $this->_context .'.limit', 'limit', $app->getCfg('list_limit',0), 'int' );
		$limitstart	= $app ->getUserStateFromRequest( $this->_context .'.limitstart', 'limitstart', 0, 'int' );
	
		// In case limit has been changed, adjust limitstart accordingly
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);

	}

	/**
	* Method to get the item identifier
	*
	* @access public
	* @return $_id int Item Identifier
	*/
	public function getId() {		
		return $this->_id;
	}

	/**
	* Method to set the item identifier
	*
	* @access public
	* @param int Item identifier
	*/
	public function setId($id) {
		// Set item id and wipe data
		$this->_id = $id;
		$this->_data = null;
	}

	/**
	   * Return a  List of vendor-Items 
	   * @access	public 
	   * @return $_data array
	   */

	public function getData()
	{
		// Lets load the content if it doesn't already exist
	   
		if (empty($this->_data))
		{
			$query = $this->_buildQuery();
			$this->_data = $this->_getList($query,$this->getState('limitstart'), $this->getState('limit'));
		}
		
		return $this->_data;
		
	}

	/**
	 * Method to get an Item
	 *
	 * @access	public 
	 * @return $item array
	 */
	
	public function getItem() {			
		$item = & $this->getTable();				
		$item->load($this->_id);
		if(isset($item->params)) {					
			$params = json_decode($item->params);					
			$item->params = new JObject();
			$item->params ->setProperties(JArrayHelper::fromObject($params));
		}
		return $item;
	}

   /**
    * Method to delete an Item
 	*
	* @access	public
    * @param  $cid int
    * @return $affected int
    */
     public function  delete($cid) {
        $db = & JFactory::getDBO();     
	    $query = 'DELETE FROM '.$this->_default_table.' WHERE id '.$this->_multiDbCondIfArray($cid);
        $db->setQuery( $query);

        $db->query();
	    $affected = $db->getAffectedRows();	    
        return $affected ;
     }



	/**
	 * Method to store the vendor
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	public function store($data)
	{
		// Implemented in child classes	
	}

 
	/**
	 * Method to get a pagination object 
	 *
	 * @access public
	 * @return integer
	 */
	public function getPagination()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_pagination))
		{
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination( $this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
		}

		return $this->_pagination;
	}
	

	/**
	 * Method to get the total number of  items
	 *
	 * @access public
	 * @return integer
	 */
	public function getTotal()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_total))
		{
			$query = $this->_buildQuery();
			$this->_total = $this->_getListCount($query);
		}

		return $this->_total;
	}	
	
		/**
	* Method to (un)publish an item
	*
	* @access public
	* @return boolean True on success
	
	*/
	public function publish($cid = array (), $publish = 1) {
		$user = & JFactory :: getUser();
		if (count($cid)) {
			JArrayHelper :: toInteger($cid);
			$cids = implode(',', $cid);
			$query = 'UPDATE '.$this->_default_table.' SET published = ' . (int) $publish . ' WHERE id IN ( ' . $cids . ' )';
			$this->_db->setQuery($query);
	
			if (!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}
		return true;
	}

	/**
	* Method to move a item
	*
	* @access public
	* @return boolean True on success
	
	*/
	public function saveorder($cid = array (), $order) {
		$row = & $this->getTable();
		$groupings = array ();
		// update ordering values
		for ($i = 0; $i < count($cid); $i++) {
			$row->load((int) $cid[$i]);

			if ($row->ordering != $order[$i]) {
				$row->ordering = $order[$i];
				if (!$row->store()) {
					$this->setError($this->_db->getErrorMsg());
					return false;
				}
			}
		}

		return true;
	}
	
	/**
	 * Method to move an item
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	public function move($direction)
	{
		$row =& $this->getTable();
		if (!$row->load($this->_id)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		$table = $this->getTable();
		$where = "";
		
		if($row->catid) {
			$where = ' catid = '.(int) $row->catid.' AND published >= 0 ';
		} 
		if (!$row->move( $direction, $where )) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		return true;
	}
	
	/**
	* Method to checkin/unlock the item
	*
	* @access public
	* @return boolean True on success
	
	*/
	public function checkin() {
		if ($this->_id) {
			$item = & $this->getTable();
			if (!$item->checkin($this->_id)) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}
		return false;
	}
	/**
	* Method to checkout/lock the item
	*
	* @access public
	* @param int $uid User ID of the user checking the article out
	* @return boolean True on success
	
	*/
	public function checkout($uid = null) {
		if ($this->_id) {
			// Make sure we have a user id to checkout the vendor with
			if (is_null($uid)) {
				$user = & JFactory :: getUser();
				$uid = $user->get('id');
			}
			// Lets get to it and checkout the thing...
			$item = & $this->getTable();
			if (!$item->checkout($uid, $this->_id)) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
			return true;
		}
		return false;
	}	
	
	/**
	 * Method to set the Default Filter Column
	 * 
	 * @access public
	 * @param mixed Default Filter
	 */
	
	public function setDefaultFilter($filter) {
		$this->_default_filter = $filter;
	}
	
	/**
	* Method to build the query
	*
	* @access private
	* @return string query	
	*/

	protected function _buildQuery()
	{
		$where = $this->_buildContentWhere();
		$orderby = $this->_buildContentOrderBy();
		
		$query = 'SELECT * FROM '.$this->_default_table.' '. $where . $orderby;

		return $query;
	}

	/**
	* Method to build the Order Clause
	*
	* @access private
	* @return string orderby	
	*/
	
	protected function _buildContentOrderBy() {
		$app = &JFactory::getApplication('site');
		$context			= $this->option.'.'.strtolower($this->getName()).'.list.';
		$filter_order = $app->getUserStateFromRequest($context . 'filter_order', 'filter_order', $this->_default_filter, 'cmd');
		$filter_order_Dir = $app->getUserStateFromRequest($context . 'filter_order_Dir', 'filter_order_Dir', '', 'word');

		$orderby = ' ORDER BY ' . $filter_order . ' ' . $filter_order_Dir ;

		return $orderby;
	}
	
	/**
	* Method to build the Where Clause 
	*
	* @access private
	* @return string orderby	
	*/
	
	protected function _buildContentWhere() {
		// Implemented in child classes	
	}		
	
	protected function _multiDbCondIfArray($search) {
		$ret = (is_array($search)) ? " IN ('" . implode("','", $search) . "') " : " = '" . $search . "' ";
		return $ret;
	}

}  