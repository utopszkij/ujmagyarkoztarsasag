<?php
/**
 *------------------------------------------------------------------------------
 *  iCagenda v3 by Jooml!C - Events Management Extension for Joomla! 2.5 / 3.x
 *------------------------------------------------------------------------------
 * @package     com_icagenda
 * @copyright   Copyright (c)2012-2015 Cyril Rezé, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Cyril Rezé (Lyr!C)
 * @link        http://www.joomlic.com
 *
 * @version     3.5.13 2015-11-05
 * @since       2.0.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

jimport('joomla.application.component.modellist');
jimport( 'joomla.html.parameter' );

if(version_compare(JVERSION, '3.0', 'ge')) {
	jimport( 'joomla.installer.installer' );
	jimport( 'joomla.installer.helper' );
	jimport( 'joomla.filesystem.folder' );
}

/**
 * Model Admin - Theme Manager - iCagenda
 */
class iCagendaModelthemes extends JModelList
{

	protected 	$_paths 	= array();
	protected 	$_manifest 	= null;
	protected	$option 		= 'com_icagenda';
	protected 	$text_prefix	= 'com_icagenda';

	function __construct(){
		parent::__construct();
	}

	public function getForm($data = array(), $loadData = true)
	{

		$app	= JFactory::getApplication();
		$form 	= $this->loadForm('com_icagenda.template', 'themes', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}
		return $form;
	}

	function install($theme)
	{
		$app		= JFactory::getApplication();
		$db 		= JFactory::getDbo();
		$package 	= $this->_getPackageFromUpload();

		if (!$package) {
			JError::raiseWarning(1, JText::_('COM_ICAGENDA_ERROR_FIND_INSTALL_PACKAGE'));
			$this->deleteTempFiles();
			return false;
		}

		if ($package['dir'] && JFolder::exists($package['dir'])) {
			$this->setPath('source', $package['dir']);
		} else {
			JError::raiseWarning(1, JText::_('COM_ICAGENDA_ERROR_INSTALL_PATH_NOT_EXISTS'));
			$this->deleteTempFiles();
			return false;
		}

		// We need to find the installation manifest file
		if (!$this->_findManifest()) {
			JError::raiseWarning(1, JText::_('COM_ICAGENDA_ERROR_FIND_INFO_INSTALL_PACKAGE'));
			$this->deleteTempFiles();
			return false;
		}

		// Files - copy files in manifest
		foreach ($this->_manifest->children() as $child)
		{
			if (is_a($child, 'JXMLElement') && $child->name() == 'files') {
				if ($this->parseFiles($child) === false) {
					JError::raiseWarning(1, JText::_('COM_ICAGENDA_ERROR_FIND_INFO_INSTALL_PACKAGE'));
					$this->deleteTempFiles();
					return false;
				}
			}
		}

		// File - copy the xml file
		$copyFile 		= array();
		$path['src']	= $this->getPath( 'manifest' ); // XML file will be copied too
		$path['dest']	= JPATH_SITE.DS.'components'.DS.'com_icagenda'.DS.'themes'.DS. basename($this->getPath('manifest'));
		$copyFile[] 	= $path;
		$this->copyFiles($copyFile, array());
		$this->deleteTempFiles();

		// -------------------
		// Themes
		// -------------------
		// Params -  Get new themes params
		$paramsThemes = $this->getParamsThemes();


		// -------------------
		// Component
		// -------------------
		if (isset($theme['component']) && $theme['component'] == 1 ) {

			$component			= 'com_icagenda';
			$paramsC			= JComponentHelper::getParams($component) ;

			foreach($paramsThemes as $keyT => $valueT) {
if(version_compare(JVERSION, '3.0', 'lt')) {
				$paramsC->setValue($valueT['name'], $valueT['value']);
} else {
				$paramsC->set($valueT['name'], $valueT['value']);
}
			}

			$data['params'] 	= $paramsC->toArray();
			$table 				= JTable::getInstance('extension');

			$idCom				= $table->find( array('element' => $component ));
			$table->load($idCom);

			if (!$table->bind($data)) {
				JError::raiseWarning( 500, 'Not a valid component' );
				return false;
			}

			// pre-save checks
			if (!$table->check()) {
				JError::raiseWarning( 500, $table->getError('Check Problem') );
				return false;
			}

			// save the changes
			if (!$table->store()) {
				JError::raiseWarning( 500, $table->getError('Store Problem') );
				return false;
			}
		}

		return true;
	}

	function _getPackageFromUpload()
	{
		// Get the uploaded file information
		$userfile = JRequest::getVar('Filedata', null, 'files', 'array' );
// 2.5		$userfile = JRequest::getVar('install_package', null, 'files', 'array' );

		// Make sure that file uploads are enabled in php
		if (!(bool) ini_get('file_uploads')) {
			JError::raiseWarning('SOME_ERROR_CODE', JText::_('COM_ICAGENDA_ERROR_INSTALL_FILE_UPLOAD'));
			return false;
		}

		// Make sure that zlib is loaded so that the package can be unpacked
		if (!extension_loaded('zlib')) {
			JError::raiseWarning('SOME_ERROR_CODE', JText::_('COM_ICAGENDA_ERROR_INSTALL_ZLIB'));
			return false;
		}

		// If there is no uploaded file, we have a problem...
		if (!is_array($userfile) ) {
			JError::raiseWarning('SOME_ERROR_CODE', JText::_('COM_ICAGENDA_ERROR_NO_FILE_SELECTED'));
			return false;
		}

		// Check if there was a problem uploading the file.
		if ( $userfile['error'] || $userfile['size'] < 1 ) {
			JError::raiseWarning('SOME_ERROR_CODE', JText::_('COM_ICAGENDA_ERROR_UPLOAD_FILE'));
			return false;
		}

		// Build the appropriate paths
if(version_compare(JVERSION, '3.0', 'lt')) {
		$config 	=& JFactory::getConfig();
		$tmp_dest 	= $config->getValue('config.tmp_path').DS.$userfile['name'];
} else {
		$config 	=& JFactory::getConfig();
		$tmp_dest 	= $config->get('tmp_path') . '/' . $userfile['name'];
}

		$tmp_src	= $userfile['tmp_name'];

		// Move uploaded file
		jimport('joomla.filesystem.file');
		$uploaded = JFile::upload($tmp_src, $tmp_dest, false, true);

		// Unpack the downloaded package file
if(version_compare(JVERSION, '3.0', 'lt')) {
		$package = JInstallerHelper::unpack($tmp_dest);
} else {
		$package = self::unpack($tmp_dest);
}

		$this->_manifest =& $manifest;

		$this->setPath('packagefile', $package['packagefile']);
		$this->setPath('extractdir', $package['extractdir']);

		return $package;
	}

	function getPath($name, $Default=null) {
		return (!empty($this->_paths[$name])) ? $this->_paths[$name] : $Default;
	}

	function setPath($name, $value) {
		$this->_paths[$name] = $value;
	}

	function _findManifest() {
		// Get an array of all the xml files from teh installation directory
		$xmlfiles = JFolder::files($this->getPath('source'), '.xml$', 1, true);

		// If at least one xml file exists
		if (count($xmlfiles) > 0) {
			foreach ($xmlfiles as $file)
			{
				// Is it a valid joomla installation manifest file?
				$manifest = $this->_isManifest($file);
				if (!is_null($manifest)) {

					$attr = $manifest->attributes();
					if ((string)$attr['method'] != 'icthemes') {
						JError::raiseWarning(1, JText::_('COM_ICAGENDA_ERROR_NO_THEME_FILE'));
						return false;
					}

					// Set the manifest object and path
					$this->_manifest =& $manifest;
					$this->setPath('manifest', $file);

					// Set the installation source path to that of the manifest file
					$this->setPath('source', dirname($file));

					return true;
				}
			}

			// None of the xml files found were valid install files
			JError::raiseWarning(1, JText::_('COM_ICAGENDA_ERROR_XML_INSTALL_ICAGENDA'));
			return false;
		} else {
			// No xml files were found in the install folder
			JError::raiseWarning(1, JText::_('COM_ICAGENDA_ERROR_XML_INSTALL'));
			return false;
		}
	}

	function _isManifest($file) {
		$xml	= JFactory::getXML($file, true);
		if (!$xml) {
			unset ($xml);
			return null;
		}
		if (!is_object($xml) || ($xml->name() != 'install' )) {
			unset ($xml);
			return null;
		}
		return $xml;
	}


	function parseFiles($element, $cid=0) {
		$copyfiles 		= array();
		$copyfolders 	= array();

		if (!is_a($element, 'JXMLElement') || !count($element->children())) {
			return 0;// Either the tag does not exist or has no children therefore we return zero files processed.
		}

		$files = $element->children();// Get the array of file nodes to process

		if (count($files) == 0) {
			return 0;// No files to process
		}

		$source 	 	= $this->getPath('source');
		$destination 	= JPATH_SITE.DS.'components'.DS.'com_icagenda'.DS.'themes';
		$destination2 	= JPATH_SITE.DS.'components'.DS.'com_icagenda'.DS.'themes'.DS.'packs';

if(version_compare(JVERSION, '3.0', 'lt')) {
		foreach ($files as $file) {
			if ($file->name() == 'folder') {
				$path['src']	= $source.DS.$file->data();
				$path['dest']	= $destination2.DS.$file->data();
				$copyfolders[] = $path;
			} else {
				$path['src']	= $source.DS.$file->data();
				$path['dest']	= $destination.DS.$file->data();
				$copyfiles[] = $path;
			}
		}
} else {
		if(!empty($files->folder)){
			foreach ($files->folder as $fk => $fv) {
				$path['src']	= $source . '/' . $fv;
				$path['dest']	= $destination2 . '/' . $fv;
				$copyfolders[] = $path;
			}
		}
		if (!empty($files->filename)) {
			foreach($files->filename as $fik => $fiv) {
				$path['src']	= $source . '/' . $fiv;
				$path['dest']	= $destination . '/' . $fiv;
				$copyfiles[] = $path;
			}
		}
}

		return $this->copyFiles($copyfiles, $copyfolders);
	}

	function copyFiles($files, $folders) {

		$i = 0;
		$fileIncluded = $folderIncluded = 0;
		if (is_array($folders) && count($folders) > 0)
		{
			foreach ($folders as $folder)
			{
				// Get the source and destination paths
				$foldersource	= JPath::clean($folder['src']);
				$folderdest		= JPath::clean($folder['dest']);

				if (!JFolder::exists($foldersource)) {
					JError::raiseWarning(1, JText::sprintf('COM_ICAGENDA_FOLDER_NOT_EXISTS', $foldersource));
					return false;
				} else {
					if (!(JFolder::copy($foldersource, $folderdest, '', true))) {
						JError::raiseWarning(1, JText::sprintf('COM_ICAGENDA_ERROR_COPY_FOLDER_TO', $foldersource, $folderdest));
						return false;
					} else {
						$i++;
					}
				}
			}
			$folderIncluded = 1;
		}

		if (is_array($files) && count($files) > 0)
		{
			foreach ($files as $file)
			{
				// Get the source and destination paths
				$filesource	= JPath::clean($file['src']);
				$filedest	= JPath::clean($file['dest']);

				if (!file_exists($filesource)) {
					JError::raiseWarning(1, JText::sprintf('COM_ICAGENDA_FILE_NOT_EXISTS', $filesource));
					return false;
				} else {
					if (!(JFile::copy($filesource, $filedest))) {
						JError::raiseWarning(1, JText::sprintf('COM_ICAGENDA_ERROR_COPY_FILE_TO', $filesource, $filedest));
						return false;
					} else {
						$i++;
					}
				}
			}
			$fileIncluded = 1;
		}

		if ($fileIncluded == 0 && $folderIncluded ==0) {
			JError::raiseWarning(1, JText::sprintf('COM_ICAGENDA_ERROR_INSTALL_FILE'));
			return false;
		}

		return $i;// Possible TO DO, now it returns count folders and files togeter, //return count($files);
	}

	protected function getParamsThemes() {

		$element = $this->_manifest->children()->params;

		if (!is_a($element, 'JXMLElement') || !count($element->children())) {
			return null;// Either the tag does not exist or has no children therefore we return zero files processed.
		}

		$params = $element->children();
		if (count($params) == 0) {
			return null;// No params to process
		}

		// Process each parameter in the $params array.
		$paramsArray = array();
		$i=0;
		foreach ($params as $param) {
			if (!$name = $param['name']) {
				continue;
			}
			if (!$value = $param['default']) {
				continue;
			}

			$paramsArray[$i]['name'] = (string)$name;
			$paramsArray[$i]['value'] = (string)$value;
			$i++;
		}
		return $paramsArray;
	}

	function deleteTempFiles() {
		$path = $this->getPath('source');
		if (is_dir($path)) {
			$val = JFolder::delete($path);
		} else if (is_file($path)) {
			$val = JFile::delete($path);
		}
		$packageFile = $this->getPath('packagefile');
		if (is_file($packageFile)) {
			$val = JFile::delete($packageFile);
		}
		$extractDir = $this->getPath('extractdir');
		if (is_dir($extractDir)) {
			$val = JFolder::delete($extractDir);
		}
	}


	/*
	 * Added @since 3.0.
	 */
	public static function unpack($p_filename)
	{
		// Path to the archive
		$archivename = $p_filename;

		// Temporary folder to extract the archive into
		$tmpdir = uniqid('install_');

		// Clean the paths to use for archive extraction
		$extractdir = JPath::clean(dirname($p_filename) . '/' . $tmpdir);
		$archivename = JPath::clean($archivename);

		// Do the unpacking of the archive
		try
		{
			JArchive::extract($archivename, $extractdir);
		}
		catch (Exception $e)
		{
			return false;
		}

		/*
		 * Let's set the extraction directory and package file in the result array so we can
		 * cleanup everything properly later on.
		 */
		$retval['extractdir'] = $extractdir;
		$retval['packagefile'] = $archivename;

		/*
		 * Try to find the correct install directory.  In case the package is inside a
		 * subdirectory detect this and set the install directory to the correct path.
		 *
		 * List all the items in the installation directory.  If there is only one, and
		 * it is a folder, then we will set that folder to be the installation folder.
		 */
		$dirList = array_merge(JFolder::files($extractdir, ''), JFolder::folders($extractdir, ''));

		if (count($dirList) == 1)
		{
			if (JFolder::exists($extractdir . '/' . $dirList[0]))
			{
				$extractdir = JPath::clean($extractdir . '/' . $dirList[0]);
			}
		}

		/*
		 * We have found the install directory so lets set it and then move on
		 * to detecting the extension type.
		 */
		$retval['dir'] = $extractdir;

		/*
		 * Get the extension type and return the directory/type array on success or
		 * false on fail.
		 */
		$retval['type'] = self::detectType($extractdir);
		if ($retval['type'])
		{
			return $retval;
		}
		else
		{
			return false;
		}
	}

	/*
	 * Added @since 3.0.
	 */
	public static function detectType($p_dir)
	{
		// Search the install dir for an XML file
		$files = JFolder::files($p_dir, '\.xml$', 1, true);

		if (!count($files))
		{
			JLog::add(JText::_('JLIB_INSTALLER_ERROR_NOTFINDXMLSETUPFILE'), JLog::WARNING, 'jerror');
			return false;
		}

		foreach ($files as $file)
		{
			$xml = simplexml_load_file($file);

			if (!$xml)
			{
				continue;
			}

			if ($xml->getName() != 'install')
			{
				unset($xml);
				continue;
			}

			$type = (string) $xml->attributes()->type;

			// Free up memory
			unset($xml);
			return $type;
		}

		JLog::add(JText::_('JLIB_INSTALLER_ERROR_NOTFINDJOOMLAXMLSETUPFILE'), JLog::WARNING, 'jerror');

		// Free up memory.
		unset($xml);
		return false;
	}

}
?>
