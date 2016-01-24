<?php defined('_JEXEC') or die('Restricted access'); ?>
##codestart##
/**
* @version		$Id:##name##.php  1 ##date##Z ##sauthor## $
* @package		##Component##
* @subpackage 	Tables
* @copyright	Copyright (C) ##year##, ##author##. All rights reserved.
* @license ###license##
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
* Jimtawl Table##Name## class
*
* @package		##Component##
* @subpackage	Tables
*/
class Table##Name## extends JTable
{
	##fields##


	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	public function __construct(& $db) 
	{
		parent::__construct('##table##', '##primary##', $db);
	}

	/**
	* Overloaded bind function
	*
	* @acces public
	* @param array $hash named array
	* @return null|string	null is operation was satisfactory, otherwise returns an error
	* @see JTable:bind
	* @since 1.5
	*/
	public function bind($array, $ignore = '')
	{ 
##ifdefFieldparamsStart##
		if ( isset( $array['params'] ) && is_array( $array['params'] ) )
        {
            $array['params'] = json_encode( $array['params'] );

        }
##ifdefFieldparamsEnd##		
		return parent::bind($array, $ignore);		
	}

	/**
	 * Overloaded check method to ensure data integrity
	 *
	 * @access public
	 * @return boolean True on success
	 * @since 1.0
	 */
	public function check()
	{
##ifdefFieldorderingStart##
		if ($this->##primary## === 0) {
			//get next ordering
##ifdefFieldcatidStart##
			$condition = ' catid = '.(int) $this->catid ##ifdefFieldpublishedStart## . ' AND published >= 0 ' ##ifdefFieldpublishedEnd##;
##ifdefFieldcatidEnd##
##ifdefFieldcategory_idStart##
			$condition = ' category_id = '.(int) $this->category_id ##ifdefFieldpublishedStart## . ' AND published >= 0 ' ##ifdefFieldpublishedEnd##;
##ifdefFieldcategory_idEnd##			
			$this->ordering = $this->getNextOrder( ##ifdefFieldcatidStart## $condition ##ifdefFieldcatidEnd##);

		}
##ifdefFieldorderingEnd##
##ifdefFieldcreatedStart##		
		if (!$this->created) {
			$date = JFactory::getDate();
			$this->created = $date->format("Y-m-d H:i:s");
		}				
##ifdefFieldcreatedEnd##
##ifdefFieldcreated_timeStart##		
		if (!$this->created_time) {
			$date = JFactory::getDate();
			$this->created = $date->format("Y-m-d H:i:s");
		}				
##ifdefFieldcreated_timeEnd##
		/** check for valid name */
		/**
		if (trim($this-><?php echo $this->hident ?>) == '') {
			$this->setError(JText::_('Your ##Name## must contain a <?php echo $this->hident ?>.')); 
			return false;
		}
		**/		
##ifdefFieldaliasStart##
		if(empty($this->alias)) {
			$this->alias = $this-><?php echo $this->hident ?>;
		}
		
		$this->alias = JFilterOutput::stringURLSafe($this->alias);
		
		/** check for existing alias */
		$query = 'SELECT '.$this->getKeyName().' FROM '.$this->_tbl.' WHERE alias = '.$this->_db->Quote($this->alias);
		$this->_db->setQuery($query);
		
		$xid = intval($this->_db->loadResult());

		if ($xid && $xid != intval($this->{$this->getKeyName()})) {		
			$this->setError(JText::_('Can\'t save to ##Name##. Name already exists'));
			return false;
		}      	

##ifdefFieldaliasEnd##
		return true;
	}
}
