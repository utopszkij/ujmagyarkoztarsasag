<?php
/**
* @version		$Id: packages.php 121 2012-10-02 14:22:56Z michel $
* @package		Jacc
* @subpackage 	Controllers
* @copyright	Copyright (C) 2011, Michael Liebler. All rights reserved.
* @license #http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

/**
 * JaccPackages Controller
 *
 * @package    Jacc
 * @subpackage Controllers
 */
class JaccControllerPackages extends JaccController
{
	/**
	 * Constructor
	 */
	protected $_viewname = 'packages'; 
	protected $_mainmodel = 'packages';
	protected $_itemname = 'Package';	 
	public function __construct($config = array ()) 
	{
		parent :: __construct($config);
		JRequest :: setVar('view', $this->_viewname);

	}		
	
	
	public function zip() {
	  	require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'jacc.php';
		jimport('joomla.filesystem.archive');
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');
		jimport('joomla.filtere.filteroutput');

		$zipdir = JPATH_COMPONENT.DS.'archives';
		//Get Model and Item
		
	
		$model = $this->getModel('packages');		
		
		$item = $model->getItem();
				
		//archive name
		$archive = 'pkg_'.$item->alias.'-'.$item->version.'.zip';
		
		$model->addPath('archive',$zipdir.DS.$archive);
		//some basic variables to replace the template patterns
		//now
		$date = &JFactory::getDate();		

		$package = $item->name;

		JRequest::setVar('package', $package);
		
		//Component name for camel case functions
		$package  = ucfirst(strtolower($package));

		//lower Component name
		$lpackage = $item->alias;				
		
		$model->addRenaming($lpackage,'#package#');
		
		
		//Create temp folder
		if (JFolder::exists($model->getTempPath())) {

			JFolder::delete($model->getTempPath());
		}

		// copy Basic MVC to tmp/jctmp
		JFolder::copy(JPATH_COMPONENT.DS.'templates'.DS.'packages', $model->getTempPath());
		
		
	    $extensions = $item->params->get('extensions');
	    if (!is_array($extensions) || !count($extensions) )
	        return -2;
	        
	    $filesSection = "";    
	    foreach($extensions as $value ) {	        
	        $extension = json_decode($value);
	        if(JFile::exists(JPATH_COMPONENT_ADMINISTRATOR.DS.'archives'.DS.$extension->file)) {	            
	            JFile::copy(JPATH_COMPONENT_ADMINISTRATOR.DS.'archives'.DS.$extension->file, $model->getTempPath(true).'packages'.DS.$extension->file);
	        } else {
	            return $extension->file;
	        }
	        $filesSection .= '		<file type="'.$extension->type.'" id="'.$extension->id.'"';
	        if(isset($extension->group)) {
	             $filesSection .= ' group="system"';
	        }
	        if($extension->type == 'module') {
	             $filesSection .= ' client="site"';
	        }
	        $filesSection .= '>'.$extension->file.'</file>'."\n";	             
	    }
		
		
		$options = array('name' => $item->name, 'alias' => $item->alias,'packagerurl' => $item->packagerurl, 'updateurl' => $item->updateurl, 'files' => $filesSection);		
		
		$model->readinFiles();

		$model->customizeFiles($options);
							
		//Delete old archive if exists	
		if (JFile::exists($zipdir.DS.$archive)) {
			JFile::delete($zipdir.DS.$archive);
		}
		$model->readinFiles();
		
		$model->buildArchiveContent(); 

		//create archive
		$model->createArchive();		
		
		//delete tmp folder
		if (JFolder::exists($model->getTempPath())) {
			JFolder::delete($model->getTempPath());
		}		
	    
	}
	
	/**
	 * stores the item
	 */
	public function save()
	{
		// Check for request forgeries
		JRequest :: checkToken() or jexit('Invalid Token');
		$app = &JFactory::getApplication('administrator');
		$db = & JFactory::getDBO();

		$post = JRequest :: getVar('jform', array(), 'post', 'array');
		$cid = JRequest :: getVar('cid', array (
		0
		), 'post', 'array');
		$post['id'] = (int) $cid[0];
        
		$model = $this->getModel('packages');
		
		JRequest::setVar('mode', 'return');
		// Validate the posted data.
		$form	= &$model->getForm();

		if (!$form) {
			JError::raiseError(500, $model->getError());
			return false;
		}

		$post	= $model->validate($form, $post);

		// Check for validation errors.
		if ($post === false) {
				
				
			// Get the validation messages.
			$errors	= $model->getErrors();

			// Push up to three validation messages out to the user.
			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++) {
				if (JError::isError($errors[$i])) {
					$app->enqueueMessage($errors[$i]->getMessage(), 'notice');
				} else {
					$app->enqueueMessage($errors[$i], 'notice');
				}
			}
			$link = 'index.php?option=com_jacc&view='.$this->_viewname.'&task=edit&cid[]='.$model->getId() ;
			$this->setRedirect($link, $msg);
			return;
		}

		if ($model->store($post)) {
			$msg = JText :: _($this->_itemname .' Saved');
			JRequest::setVar("cid",array($model->getId()));			
		} else {
			$msg = $model->getError();
		}

		switch ($this->getTask())
		{
			case 'apply':
				$link = 'index.php?option=com_jacc&view='.$this->_viewname.'&task=edit&cid[]='.$model->getId() ;
				break;

			case 'save':
			default:
				$link = 'index.php?option=com_jacc&view='.$this->_viewname;
				break;
		}
        
		$result = $this->zip(); 
		if ($result === -2) {
			$msg = JText::_('Package does not contain Extensions');			
		} elseif (is_string($result)) {
		    $msg = JText::_('Missing '.$result);			
		} 
		$this->setRedirect($link, $msg);		
	}		
	public function publish() 
	{
		// Check for request forgeries
		JRequest :: checkToken() or jexit('Invalid Token');

		$cid = JRequest :: getVar('cid', array (), 'post', 'array');
		JArrayHelper :: toInteger($cid);

		if (count($cid) < 1) {
			JError :: raiseError(500, JText :: _('Select an item to publish'));
		}

		$model = $this->getModel('packages');
		if (!$model->publish($cid, 1)) {
			echo "<script> alert('" . $model->getError(true) . "'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect('index.php?option=com_jacc&view=packages');
	}

	public function unpublish() 
	{
		// Check for request forgeries
		JRequest :: checkToken() or jexit('Invalid Token');

		$cid = JRequest :: getVar('cid', array (), 'post', 'array');
		JArrayHelper :: toInteger($cid);

		if (count($cid) < 1) {
			JError :: raiseError(500, JText :: _('Select an item to unpublish'));
		}

		$model = $this->getModel('packages');
		if (!$model->publish($cid, 0)) {
			echo "<script> alert('" . $model->getError(true) . "'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect('index.php?option=com_jacc&view='.$this->_viewname);
	}
	public function orderup() 
	{
		// Check for request forgeries
		JRequest :: checkToken() or jexit('Invalid Token');

		$model = $this->getModel('packages');
		$model->move(-1);

		$this->setRedirect('index.php?option=com_jacc&view='.$this->_viewname);
	}

	public function orderdown() 
	{
		// Check for request forgeries
		JRequest :: checkToken() or jexit('Invalid Token');

		$model = $this->getModel('packages');
		$model->move(1);

		$this->setRedirect('index.php?option=com_jacc&view='.$this->_viewname);
	}

	public function saveorder() 
	{
		// Check for request forgeries
		JRequest :: checkToken() or jexit('Invalid Token');

		$cid = JRequest :: getVar('cid', array (), 'post', 'array');
		$order = JRequest :: getVar('order', array (), 'post', 'array');
		JArrayHelper :: toInteger($cid);
		JArrayHelper :: toInteger($order);

		$model = $this->getModel('packages');
		$model->saveorder($cid, $order);

		$msg = JText :: _('New ordering saved');
		$this->setRedirect('index.php?option=com_jacc&view='.$this->_viewname, $msg);
	}	
}// class
?>