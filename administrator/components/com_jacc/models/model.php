<?php 
/**
* @version		$Id: model.php 125 2012-10-09 11:09:48Z michel $
* @package		Jacc
* @subpackage 	Models
* @copyright	Copyright (C) 2010, mliebler. All rights reserved.
* @license #http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
*/
// no direct access
defined('_JEXEC') or die('Restricted access');
/**
 * Model
 * @author Michael Liebler
 */
 
jimport('joomla.application.component.model');


 
class JaccModel  extends JModelLegacy { 

  
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
	 * JQuery
	 *
	 * @var object
	 */
	protected $_query;

	/**
	 * JQuery
	 *
	 * @var object
	 */
	protected $_state_field;
		
	/**
	 * @var		string	The URL option for the component.	
	 */
	protected $option = null;
		
	/**
	 * @var		string	context	the context to find session data.	
	 */		
	protected $_context = null;
	
	/**
	 * $var string archive directory
	 */	
	protected $zipdir = null;
	
	/**
	* $var array paths
	*/
	protected $paths = null;
	
	/**
	* $var string temporary path
	*/	
	protected $_temp_path =  null;

	/**
	* $var array exclude patterns
	*/		
	protected $_excludes = array();

	/**
	* $var array renaming patterns
	*/			
	protected $_renameing = array();	

	/**
	* $var array files in archive
	*/	
	protected $_files = array();
	
	/**
	* $var array filenames and data in archive
	*/				
	protected $_archivecontent = array();
	
	/**
 	* Constructor
 	*/
			
	public function __construct()
	{
		parent::__construct();
		
		$app = &JFactory::getApplication('administrator');
			// Guess the option from the class name (Option)Model(View).
		if (empty($this->option)) {
			$r = null;
			if (!preg_match('/(.*)Model/i', get_class($this), $r)) {
				JError::raiseError(500, JText::_('No Model Name'));
			}
			$this->option = 'com_'.strtolower($r[1]);
		}		
		
		$this->_query = $this->_db->getQuery(true); 
		
		$table = $this->getTable();
		if ($table) {
			$this->_default_table = $table->getTableName(); 
			if (isset($table->published))  $this->_state_field = 'published';
		}
		
		if (empty($this->_context)) {
			$this->_context = $this->option.'.'.$this->getName();
		}
		
		$array = JRequest :: getVar('cid', array (
			0
		), '', 'array');
		
		$edit = JRequest :: getVar('edit', true);
		
		if ($edit)
			$this->setId((int) $array[0]);
		// Get the pagination request variables
		
		$limit		= $app ->getUserStateFromRequest( $this->_context .'.limit', 'limit', $app->getCfg('list_limit', 0), 'int' );
		$limitstart	= $app ->getUserStateFromRequest( $this->_context .'.limitstart', 'limitstart', 0, 'int' );
			
		// In case limit has been changed, adjust limitstart accordingly
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
		
		$this->_temp_path =  JPATH_SITE.DS.'tmp'.DS.'jctmp';
        
		$this->_excludes = array('.svn', 'CVS');
	}

	/**
	 * 
	 * Method to add an Exclude pattern
	 * @param mixed exclude pattern
	 */
    public function addExcludes($excludes) {
	    
        $this->_excludes = array_unique(array_merge((array) $excludes,$this->_excludes));
        
	}
	
	/**
	 * 
	 * Method to add a rename pattern
	 * @param string rename pattern
	 */	
    public function addRenaming($replace,$pattern) {
	    
        $this->_renameing[$replace]  = $pattern;
        
	}

	/**
	 * 
	 * Method to get rename patterns
	 * @return array rename patterns
	 */
    public function getRenaming() {
	    
        return $this->_renameing;
        
	}

	/**
	 * 
	 * Method to get exclude patterns
	 * @return array exclude patterns
	 */	
	public function getExcludes() {
        
	    return $this->_excludes;     
	}

	/**
	 * 
	 * Method to get the zip dir
	 * @return string zipdir
	 */		
	public function getZipdir() {
	    return $this->zipdir;
	}
	
	
	/**
	 * 
	 * Method to add a path by key
	 * @param string key
	 * @param string path 
	 */		
	public function addPath($key,$path) {
	    $this->paths[$key] = $path;
	}	
	/**
	 * 
	 * Method to get a path by key
	 * @param string key
	 * @return string path
	 */		
	public function getPath($key) {
	    return $this->paths[$key];
	}
	
	/**
	 * 
	 * Method to get the temporary path
	 * @param boolean trailing - add trailing slash if true
	 * @return string path
	 */		
	public function getTempPath($trailing = false) {
	    
	    $slash = $trailing ? DS : '';
	    return $this->_temp_path.$slash;
	}
	
	/**
	 * 
	 * Method to read all files of a directory recursive 
	 * @param boolean exclude - use excludes 
	 * @return array files
	 */			
	public function readinFiles($exclude = true) {
	    $excludes = $exclude ? $this->getExcludes() : array();
	    $this->_files = JFolder::files($this->getTempPath(), '.', true, true, $excludes);
 	  
	}
	
	/**
	 * 
	 * Method to build an array containing filenames and file data
	 * used for the zip library 
	 */				
	public function buildArchiveContent() {
		//find the files. exclude categories if required
		$files = $this->getTempFiles();
		for ($i=0;$i<count($files);$i++) {
			$found = false;
			$excludes = $this->getExcludes();
			foreach ($excludes  as $exc) {
				if (strpos($files[$i], $exc)) {
					$found = true;
				}
			}
			if (!$found) {
				$data = JFile::read($files[$i]); 
				$file = str_replace($this->getTempPath(true),'',$files[$i]);				
				$this->_archivecontent[$file] = array('name' => $file, 'data' =>$data); 				
			}
		}
	}

	
	public function createArchive () {
	    jimport('joomla.filesystem.archive');
		$zipAdapter =& JArchive::getAdapter('zip'); 		
		$zipAdapter->create($this->getPath('archive'),array_values($this->_archivecontent)); 
	}
	
	/**
	 * get Files form tempdirectory
	 */
	
	public function getTempFiles() {
	    if(!count($this->_files)) {
	        $this->_files = $this->readinFiles();
	    }
	    return $this->_files;
	}
	
	/**
	 * Method to rename placeholders of filenames
	 * @param hash options  
	 */	
	public function customizeFiles ($options) {
      $files = $this->getTempFiles();
      $item = $this->getItem();  
	  for ($i=0;$i<count($files);$i++) {
	      $renamings = $this->getRenaming();	      
	      if(count($renamings))
	          foreach($renamings  as $replace => $pattern) {
	              //rename files
			      if (stripos($files[$i], $pattern)) {
			          $newfile=str_replace($pattern, $replace, $files[$i]);
			          JFile::move($files[$i], $newfile);
			          $files[$i] = $newfile;
			      }              
	          }
	
			//replace the patterns
			$data = file_get_contents($files[$i]);

			
			$data = JaccHelper::_replace($data, $item , $options);
			file_put_contents($files[$i], $data);
		}	    
	    
	}
	
	/**
	* Method to get a Component Versions
	*
	* @access public
	* @return array files
	*/	
	public function getFiles($component) 
	{
		
	    if(!$component) return array();
		$directory =  JPATH_COMPONENT_ADMINISTRATOR.DS.'archives';
		return  JFolder::files($directory, $component.'-*.*', $recurse = true);
	} 	
	
	
/**
	 * Method to auto-populate the model state.
	 *
	 * This method should only be called once per instantiation and is designed
	 * to be called on the first call to the getState() method unless the model
	 * configuration flag to ignore the request is set.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @return	void
	 */
	protected function populateState()
	{
	}

	/**
	* Method to get the item identifier
	*
	* @access public
	* @return $_id int Item Identifier
	*/
	public function getId() 
	{		
		return $this->_id;
	}

	/**
	* Method to set the item identifier
	*
	* @access public
	* @param int Item identifier
	*/
	public function setId($id) 
	{
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
	   
		if (empty($this->_data)) {
			$query = $this->_buildQuery();
			
			$this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
		}

		return $this->_data;
		
	}
	
	public function getDefaultFilter() 
	{
		return $this->_default_filter;
	}
	
	/**
	 * Method to get the row form.
	 *
	 * @return	mixed	JForm object on success, false on failure.
	 * @since	1.6
	 */
	public function getForm($name = null)
	{
		if (!$name) {
			$name = $this->getName();
		}
 
		// Initialize variables.
		$app = &JFactory::getApplication();

		// Get the form.
		
		$form = $this->_getForm($name, 'form', array('control' => 'jform'));
		JFormHelper::addRulePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'rules');
		// Check for an error.
		if (JError::isError($form)) {
			$this->setError($form->getMessage());
			return false;
		}

		// Check the session for previously entered form data.
		$data = $app->getUserState($this->_context.'.edit.'.$name.'.data', array());

		// Bind the form data if present.
		if (!empty($data)) {
			$form->bind($data);
		}
	
		return $form;
	}	

		/**
	 * Method to get a form object.
	 *
	 * @param	string		$xml		The form data. Can be XML string if file flag is set to false.
	 * @param	array		$options	Optional array of parameters.
	 * @param	boolean		$clear		Optional argument to force load a new form.
	 * @return	mixed		JForm object on success, False on error.
	 */
	private function &_getForm($xml, $name = 'form', $options = array(), $clear = false)
	{
	
		// Handle the optional arguments.
		
		$options['control']	= JArrayHelper::getValue($options, 'control', false);
		// Create a signature hash.
		$hash = md5($xml.serialize($options));

		// Check if we can use a previously loaded form.
		if (isset($this->_forms[$hash]) && !$clear) {
			return $this->_forms[$hash];
		}

		// Get the form.

		jimport('joomla.form.form');

		JForm::addFormPath(JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'forms');
		JForm::addFieldPath(JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'fields');

		$form = JForm::getInstance($name, $xml, $options, false);
		
		// Check for an error.
		if (JError::isError($form)) {
			$this->setError($form->getMessage());
			$false = false;
			return $form;
		}


		// Store the form for later.
		$this->_forms[$hash] = $form;

		return $form;
	}
	/**
	 * Method to get an Item
	 *
	 * @access	public 
	 * @return $item array
	 */
	
	public function getItem() 
	{			
		static $instance;
		if($instance) return $instance; 
	   
	    $item = & $this->getTable();				
		$item->load($this->_id);
		if (isset($item->params)) {					
			$params = json_decode($item->params);					
			$item->params = new JObject();
			$item->params ->setProperties(JArrayHelper::fromObject($params));
		}
		$instance = $item;
		return $instance;
	}



   /**
    * Method to delete an Item
 	*
	* @access	public
    * @param  $cid int
    * @return $affected int
    */
     public function  delete($cid) 
     {
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
		if (empty($this->_pagination)) {
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
		if (empty($this->_total)) {
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
	public function publish($cid, $publish = 1) 
	{
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
	public function saveorder($cid, $order) 
	{
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
		
		if ($row->catid) {
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
	public function checkin() 
	{
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
	public function checkout($uid = null) 
	{
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
	
	public function setDefaultFilter($filter) 
	{
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
		static $instance;
		
		if(!empty($instance)) {
			return $instance;
		}
		
		$this->_query->select('a.*');
		$this->_query->from($this->_default_table.' AS a');
		$this->_buildContentWhere();
		$this->_buildContentOrderBy();
		$instance = $this->_query->__toString();
		return $instance;
	}
	
	/**
	* Method to build the Joins
	*
	* @access private	
	*/
	
	protected function _buildJoins() 
	{
		
	}

	/**
	* Method to build the Order Clause
	*
	* @access private
	* @return string orderby	
	*/
	
	protected function _buildContentOrderBy() 
	{
		
		$app = &JFactory::getApplication('administrator');
		$context			= $option.'.'.strtolower($this->getName()).'.list.';
		$filter_order = $app ->getUserStateFromRequest($context . 'filter_order', 'filter_order', $this->_default_filter, 'cmd');
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
		
		$app = &JFactory::getApplication('administrator');
		$context			= $this->option.'.'.strtolower($this->getName()).'.list.';
		$search = $app->getUserStateFromRequest($context . 'search', 'search', '', 'string');
	
		if ($search) {
			$where[] = 'LOWER('.$this->getDefaultFilter().') LIKE ' . $this->_db->Quote('%' . $search . '%');
			$this->_query->where('LOWER('.$this->getDefaultFilter().') LIKE ' . $this->_db->Quote('%' . $search . '%'));
		}
		
		if ($this->_state_field) {
			$filter_state = $app->getUserStateFromRequest($context . 'filter_state', 'filter_state', '', 'word');			
			switch($filter_state) {
				case 'P':
					$this->_query->where('a.published = 1');
					break;
				case 'U':
					$this->_query->where('a.published = 0');
					break;
				case 'T':
					$this->_query->where('a.published = -2');
					break;
			}
		}
	}		
	
	protected function _multiDbCondIfArray($search) 
	{
		$ret = (is_array($search)) ? " IN ('" . implode("','", $search) . "') " : " = '" . $search . "' ";
		return $ret;
	}
	
	/**
	 * Method to validate the form data.
	 *
	 * @param	object		$form		The form to validate against.
	 * @param	array		$data		The data to validate.
	 * @return	mixed		Array of filtered data if valid, false otherwise.
	 * @since	1.1
	 */
	public function validate($form, $data)
	{
		// Filter and validate the form data.
		$data	= $form->filter($data);
		$return	= $form->validate($data);
		
		// Check for an error.
		if (JError::isError($return)) {
			$this->setError($return->getMessage());
			return false;
		}

		// Check the validation results.
		if ($return === false) {
			// Get the validation messages from the form.
			foreach ($form->getErrors() as $message) {
				$this->setError($message);
			}

			return false;
		}

		return $data;
	}	
}    