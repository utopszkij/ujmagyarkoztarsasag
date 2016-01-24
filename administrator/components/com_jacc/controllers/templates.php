<?php
/**
* @version		$Id: templates.php 121 2012-10-02 14:22:56Z michel $
* @package		Jacc
* @subpackage 	Controllers
* @copyright	Copyright (C) 2011, Michael Liebler. All rights reserved.
* @license #http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

/**
 * JaccTemplates Controller
 *
 * @package    Jacc
 * @subpackage Controllers
 */
class JaccControllerTemplates extends JaccController
{
	/**
	 * Constructor
	 */
	protected $_viewname = 'templates'; 
	protected $_mainmodel = 'templates';
	protected $_itemname = 'Templates';	 
	
	public function __construct($config = array ()) 
	{
		parent :: __construct($config);
		JRequest :: setVar('view', $this->_viewname);

	}		

	/*
	 * Creates the archive from live template
	 */
	public function zipLiveTemplate(& $model)
	{
		
	    jimport('joomla.filesystem.archive');
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');

		$item = & $model->getItem();

		$item->name = strtolower($item->name);
		//Create TempFolders
		if (JFolder::exists($model->getTempPath(true))) {
			JFolder::delete($model->getTempPath(true));
		}
		JFolder::create($model->getTempPath());
         
		//Copy the template
		if (JFolder::exists(JPATH_SITE.DS.'templates'.DS.$item->name)) {
		    JFolder::copy(JPATH_SITE.DS.'templates'.DS.$item->name, $model->getTempPath(),'',true);
		} elseif (JFolder::exists(JPATH_ADMINISTRATOR.DS.'templates'.DS.$item->name)) {						      
		    JFolder::copy(JPATH_ADMINISTRATOR.DS.'templates'.DS.$item->name, $model->getTempPath(),'',true);
		} else {
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
		foreach ($langs_admin as $lang) {
			$langfiles_admin  = array_merge(JFolder::files(JPATH_ADMINISTRATOR.DS.'language'.DS.$lang['tag'], $item->name, true, true), $langfiles_admin  );
		}

		//Copy Language Files
		if (count($langfiles_site))
		foreach ($langfiles_site as $file) {
			JFile::copy($file, $model->getTempPath().DS.'language'.DS.JFile::getName($file));
		}
		if (count($langfiles_admin))
		foreach ($langfiles_admin as $file) {
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
		
	
		$model = $this->getModel($this->_mainmodel);		
		$item = $model->getItem();
		
        //archive name
		$archive = 'tpl_'.JFilterOutput::stringURLSafe($item->name).'-'.$item->version.'.zip';
				
		$model->addPath('archive',$zipdir.DS.$archive);
		
		//some basic variables to replace the template patterns
		//now
		$date = &JFactory::getDate();		
		
		$tmpl_template = $item->name;

		JRequest::setVar('template', $tmpl_template);
		
		//Component name for camel case functions
		$tmpl_template = ucfirst(strtolower($tmpl_template));

		//lower Component name
		$ltemplate = JFilterOutput::stringURLSafe(strtolower($tmpl_template));				
		
		$model->addRenaming($ltemplate,'#template#');

		
		//User wants to create archive from installed component
		if ($item->use >1 ) {
			return $this->zipLiveTemplate($model) ;
		}
		
				//Create temp folder
		if (JFolder::exists($model->getTempPath())) {

			JFolder::delete($model->getTempPath());
		}

		// copy Basic MVC to tmp/jctmp
		JFolder::copy(JPATH_COMPONENT.DS.'templates'.DS.'templates', $model->getTempPath());
		
						
		$options = array('template' => $ltemplate,'TEMPLATE' =>strtoupper($ltemplate));		
	    
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
        
		$model = $this->getModel('templates');
		
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