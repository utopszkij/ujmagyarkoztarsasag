<?php
/**
* @version		$Id: modules.php 125 2012-10-09 11:09:48Z michel $
* @package		Jacc
* @subpackage 	Controllers
* @copyright	Copyright (C) 2011, Michael Liebler. All rights reserved.
* @license #http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

/**
 * JaccModules Controller
 *
 * @package    Jacc
 * @subpackage Controllers
 */
class JaccControllerModules extends JaccController
{
	/**
	 * Constructor
	 */
	protected $_viewname = 'modules'; 
	protected $_mainmodel = 'modules';
	protected $_itemname = 'Modules';
		 
	public function __construct($config = array ()) 
	{
		parent :: __construct($config);
		JRequest :: setVar('view', $this->_viewname);

	}

	
	/*
	 * Creates the archive from live module
	 */
	public function zipLiveModule(& $model)
	{
		
	    jimport('joomla.filesystem.archive');
	    jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.file');


		$item = & $model->getItem();

		
		//Create TempFolders
		if (JFolder::exists($model->getTempPath(true))) {
			JFolder::delete($model->getTempPath(true));
		}
		JFolder::create($model->getTempPath());
  
		//Copy the component
		if (JFolder::exists(JPATH_SITE.'/modules/'.$item->name)) {
		    JFolder::copy(JPATH_SITE.'/modules/'.$item->name, $model->getTempPath(),'',true);
		} elseif (JFolder::exists(JPATH_ADMINISTRATOR.'/modules/'.$item->name)) {						      
		    JFolder::copy(JPATH_ADMINISTRATOR.'/modules/'.$item->name, $model->getTempPath(),'',true);
		} else {
			JFolder::delete($model->getTempPath());
			return -2;
		}
		//Create Language Folders
		if (!JFolder::exists($model->getTempPath().'/language')) {
			JFolder::create($model->getTempPath().'/language');
		}
		//Find Language Files
		$langs_site = JLanguage::getKnownLanguages(JPATH_SITE);
		$langs_admin = JLanguage::getKnownLanguages(JPATH_ADMINISTRATOR);
		$langfiles_site = array();
		$langfiles_admin = array();
		foreach ($langs_site as $lang) {
			$langfiles_site  = array_merge(JFolder::files(JPATH_SITE.'/language/'.$lang['tag'], $item->name, true, true), $langfiles_site);
		}
		foreach ($langs_admin as $lang) {
			$langfiles_admin  = array_merge(JFolder::files(JPATH_ADMINISTRATOR.'/language/'.$lang['tag'], $item->name, true, true), $langfiles_admin  );
		}

		//Copy Language Files
		if (count($langfiles_site))
		foreach ($langfiles_site as $file) {
			JFile::copy($file, $model->getTempPath().'/language/'.JFile::getName($file));
		}
		if (count($langfiles_admin))
		foreach ($langfiles_admin as $file) {
			JFile::copy($file, $model->getTempPath().'/language/'.JFile::getName($file));
		}
		
		$model->readinFiles();
		
		$model->buildArchiveContent(); 

		//create archive
		$model->createArchive();		
		//delete tmp folder
		if (JFolder::exists(JPATH_SITE.'/tmp/jctmp')) {
			JFolder::delete(JPATH_SITE.'/tmp/jctmp');
		}	 

	}
	
	
	public function zip () {
	    require_once JPATH_COMPONENT_ADMINISTRATOR.'/helpers/jacc.php';
		jimport('joomla.filesystem.archive');
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');
		jimport('joomla.filter.filteroutput');

		$zipdir = JPATH_COMPONENT.'/archives';
		//Get Model and Item
		
	
		$model = $this->getModel($this->_mainmodel);		
		$item = $model->getItem();
		
		
		$archive = strtolower($item->name).'-'.$item->version.'.zip';
		
		$model->addPath('archive',$zipdir.'/'.$archive);
		
		//some basic variables to replace the template patterns
		//now
		$date = &JFactory::getDate();		
		
		$mod_module = $item->name;

		JRequest::setVar('module', $mod_module);
		
		//Component name for camel case functions
		$module = ucfirst(strtolower(str_replace('mod_', '', $mod_module )));

		//lower Component name
		$lmodule = strtolower(str_replace('mod_', '', $mod_module ));				
		
		$model->addRenaming($lmodule,'#module#');
		
		//archive name
		$archive = 'mod_'.$lmodule.'-'.$item->version.'.zip';
		
		//User wants to create archive from installed component
		if ($item->use >1 ) {
			return $this->zipLiveModule($model) ;
		}
		
				//Create temp folder
		if (JFolder::exists($model->getTempPath())) {

			JFolder::delete($model->getTempPath());
		}

		// copy Basic MVC to tmp/jctmp
		JFolder::copy(JPATH_COMPONENT.'/templates/modules', $model->getTempPath());
		
						
		$options = array('module' => $lmodule);		
	    
		$model->readinFiles();

		$model->customizeFiles($options);
							
		//Delete old archive if exists	
		if (JFile::exists($zipdir.'/'.$archive)) {
			JFile::delete($zipdir.'/'.$archive);
		}
		$model->readinFiles();
		
		$model->buildArchiveContent(); 

		//create archive
		$model->createArchive();		
		
		//delete tmp folder
		if (JFolder::exists(JPATH_SITE.'/tmp/jctmp')) {
			JFolder::delete(JPATH_SITE.'/tmp/jctmp');
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
        
		$model = $this->getModel('modules');
		
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