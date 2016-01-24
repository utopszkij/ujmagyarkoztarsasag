<?php
/**
 *------------------------------------------------------------------------------
 *  iCagenda v3 by Jooml!C - Events Management Extension for Joomla! 2.5 / 3.x
 *------------------------------------------------------------------------------
 *
 * @package LiveUpdate 2.1.5
 * @copyright Copyright ©2011-2013 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU LGPLv3 or later <http://www.gnu.org/copyleft/lesser.html>
 *
 * @version     3.1.7 2013-08-28
 * @since       1.2.6
 */

defined('_JEXEC') or die();

/**
 * Configuration class for your extension's updates.
 */
class LiveUpdateConfig extends LiveUpdateAbstractConfig
{
	var $_extensionName			= 'com_icagenda';
	var $_extensionTitle		= 'iCagenda Release System';
	var $_updateURL				= 'http://www.joomlic.com/index.php?option=com_ars&view=update&format=ini&id=2';
	var $_requiresAuthorization	= false;
	var $_versionStrategy		= 'newest';
	var $_storageAdapter		= 'file';
	var $_storageConfig = array('path' => JPATH_CACHE);

	public function __construct() {
		JLoader::import('joomla.filesystem.file');

		// Should I use our private CA store?
		if(@file_exists(dirname(__FILE__).'/../assets/cacert.pem')) {
			$this->_cacerts = dirname(__FILE__).'/../assets/cacert.pem';
		}

		parent::__construct();
	}
}
