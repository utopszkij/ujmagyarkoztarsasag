<?php
/**
* @version		$Id: plugins.php 125 2012-10-09 11:09:48Z michel $
* @package		Jacc
* @subpackage 	Controllers
* @copyright	Copyright (C) 2011, Michael Liebler. All rights reserved.
* @license #http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

/**
 * JaccPlugins Controller
 *
 * @package    Jacc
 * @subpackage Controllers
 */
class JaccControllerPlugins extends JaccController
{
	/**
	 * Constructor
	 */
	protected $_viewname = 'plugins'; 
	protected $_mainmodel = 'plugins';
	protected $_itemname = 'Plugins';
	 
	public function __construct($config = array ()) 
	{
		parent :: __construct($config);
		JRequest :: setVar('view', $this->_viewname);

	}		
	
	/*
	 * Creates the archive from live module
	 */
	public function zipLivePlugin(& $model)
	{
		
	    jimport('joomla.filesystem.archive');
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');
		
		$item = & $model->getItem();

		
		//Create TempFolders
		if (JFolder::exists($model->getTempPath(true))) {
			JFolder::delete($model->getTempPath(true));
		}
		
		//There is no such folder
		if (!JFolder::exists(JPATH_SITE.DS.'plugins'.DS.$item->folder)) {
			return -2;
		}
		
		JFolder::create($model->getTempPath());
  
		//Copy the plugin
		
		if (JFolder::exists(JPATH_SITE.DS.'plugins'.DS.$item->folder.DS.$item->name)) {
			JFolder::copy(JPATH_SITE.DS.'plugins'.DS.$item->folder.DS.$item->name, $model->getTempPath(),'',true);
		}  else {
			JFolder::delete($model->getTempPath());
			return -2;
		}
		
		//Create Language Folders
		if (!JFolder::exists($model->getTempPath().DS.'language')) {
			JFolder::create($model->getTempPath().DS.'language');
		}
		//Find Language Files
		$langs_site = JLanguage::getKnownLanguages(JPATH_SITE);
		$langs_admin = JLanguage::getKnownLanguages(JPATH_ADMINISTRATOR);
		$langfiles_site = array();
		$langfiles_admin = array();
		foreach ($langs_site as $lang) {
			$langfiles_site  = array_merge(JFolder::files(JPATH_SITE.DS.'language'.DS.$lang['tag'], $item->name, true, true), $langfiles_site);
		}
		

		//Copy Language Files
		if (count($langfiles_site))
		foreach ($langfiles_site as $file) {
			JFile::copy($file, $model->getTempPath().DS.'language'.DS.JFile::getName($file));
		}
		
		$model->readinFiles();
		
		$model->buildArchiveContent(); 

		//create archive
		$model->createArchive();
	
		//delete tmp folder
		if (JFolder::exists(JPATH_SITE.DS.'tmp'.DS.'jctmp')) {
			JFolder::delete(JPATH_SITE.DS.'tmp'.DS.'jctmp');
		}	 

	}
	
	
	
	public function zip () {
	    require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'jacc.php';
		jimport('joomla.filesystem.archive');
		jimport('joomla.filesystem.file');
		jimport('joomla.filtere.filteroutput');
		jimport('joomla.filesystem.folder');
		$zipdir = JPATH_COMPONENT.DS.'archives';
		//Get Model and Item
		
	
		$model = $this->getModel('plugins');		
		
		$item = $model->getItem();
				
		//archive name
		$archive = 'plg_'.JFilterOutput::stringURLSafe($item->name).'-'.$item->version.'.zip';
		
		$model->addPath('archive',$zipdir.DS.$archive);
		//some basic variables to replace the template patterns
		//now
		$date = &JFactory::getDate();		
		
		$plugin = $item->name;

		JRequest::setVar('plugin', $plugin);
		
		//Component name for camel case functions
		$plugin = ucfirst(strtolower($plugin));

		//lower Component name
		$lplugin = strtolower($plugin);				
		
		$model->addRenaming($lplugin,'#plugin#');
		
		
		//User wants to create archive from installed component
		if ($item->use >1 ) {
			return $this->zipLivePlugin($model) ;
		}
		
		//Create temp folder
		if (JFolder::exists($model->getTempPath())) {

			JFolder::delete($model->getTempPath());
		}

		// copy Basic Plugin tmp/jctmp
		JFolder::copy(JPATH_COMPONENT.DS.'templates'.DS.'plugins'.DS.$item->folder, $model->getTempPath());
		
        $plugtype = ($item->folder == 'editors-xtd') ? 'button' : $item->folder; 
		
		
		$options = array('plugin' => $lplugin, 'folder' => $item->folder, 'plugtype' => $plugtype);		
		
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
		if (JFolder::exists(JPATH_SITE.DS.'tmp'.DS.'jctmp')) {
			JFolder::delete(JPATH_SITE.DS.'tmp'.DS.'jctmp');
		}		
		
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

		$model = $this->getModel('plugins');
		if (!$model->publish($cid, 1)) {
			echo "<script> alert('" . $model->getError(true) . "'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect('index.php?option=com_jacc&view=plugins');
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

		$model = $this->getModel('plugins');
		if (!$model->publish($cid, 0)) {
			echo "<script> alert('" . $model->getError(true) . "'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect('index.php?option=com_jacc&view='.$this->_viewname);
	}
	public function orderup() 
	{
		// Check for request forgeries
		JRequest :: checkToken() or jexit('Invalid Token');

		$model = $this->getModel('plugins');
		$model->move(-1);

		$this->setRedirect('index.php?option=com_jacc&view='.$this->_viewname);
	}

	public function orderdown() 
	{
		// Check for request forgeries
		JRequest :: checkToken() or jexit('Invalid Token');

		$model = $this->getModel('plugins');
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

		$model = $this->getModel('plugins');
		$model->saveorder($cid, $order);

		$msg = JText :: _('New ordering saved');
		$this->setRedirect('index.php?option=com_jacc&view='.$this->_viewname, $msg);
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
        
		$model = $this->getModel('plugins');
		
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
        
		if ($this->zip() == -2) {
			$msg = JText::_('Could not save. Component backend not present');
			$this->setRedirect($link, $msg);
		} else {
			$this->setRedirect($link, $msg);
		}
	}	
}// class
?>