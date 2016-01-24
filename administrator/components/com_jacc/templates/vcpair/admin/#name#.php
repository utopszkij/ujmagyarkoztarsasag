<?php
/**
* @version		$Id: #name#.php 111 2012-02-24 18:37:06Z michel $
* @package		##Component##
* @subpackage 	Controllers
* @copyright	Copyright (C) ##year##, ##author##. All rights reserved.
* @license ###license##
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

/**
 * ##Component####Name## Controller
 *
 * @package    ##Component##
 * @subpackage Controllers
 */
class ##Component##Controller##Name## extends ##Component##Controller
{
	/**
	 * Constructor
	 */
	protected $_viewname = '##name##'; 
	 
	public function __construct($config = array ()) 
	{
		parent :: __construct($config);
		JRequest :: setVar('view', $this->_viewname);

	}
	
	function cancel()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$this->setRedirect( 'index.php?option=##com_component##&view=##name##' );
		
		$model = $this->getModel('##name##');

		$model ->checkin();
	}	
	
	function edit() 
	{
		$document =& JFactory::getDocument();

		$viewType	= $document->getType();
		$viewType	= $document->getType();
		$viewName	= JRequest::getCmd( 'view', $this->_viewname);
				
		$view = & $this->getView( $viewName, $viewType);
		
		//Some Code here
		
		$view->setLayout('form');
		JRequest::setVar( 'hidemainmenu', 1 );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar( 'view', $this->_viewname);
		JRequest::setVar( 'edit', true );
				
		$view->display();
	}
	

	/**
	 * stores the item
	 */
	function save() 
	{
		// Check for request forgeries
		JRequest :: checkToken() or jexit('Invalid Token');
		
		//Do something
		
		
		switch ($this->getTask())
		{
			case 'apply':
				$link = 'index.php?option=##com_component##&view=##name##.&task=edit&cid[]=1' ;
				break;

			case 'save':
			default:
				$link = 'index.php?option=##com_component##&view=##name##';
				break;
		}
        
		$this->setRedirect($link, $msg);
	}
		
	
}// class
?>