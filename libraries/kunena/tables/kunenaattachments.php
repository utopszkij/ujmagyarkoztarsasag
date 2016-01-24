<?php
/**
 * Kunena Component
 * @package Kunena.Framework
 * @subpackage Tables
 *
 * @copyright (C) 2008 - 2014 Kunena Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.org
 **/
defined ( '_JEXEC' ) or die ();

require_once(__DIR__ . '/kunena.php');

/**
 * Kunena Attachments Table
 * Provides access to the #__kunena_attachments table
 */
class TableKunenaAttachments extends KunenaTable {
	public $id = null;
	public $userid = null;
	public $mesid = null;
	public $hash = null;
	public $size = null;
	public $folder = null;
	public $filetype = null;
	public $filename = null;

	public function __construct($db) {
		parent::__construct ( '#__kunena_attachments', 'id', $db );
	}

	public function check() {
		$user = KunenaUserHelper::get($this->userid);
		$message = KunenaForumMessageHelper::get($this->mesid);
		if ($this->userid != 0 && !$user->exists()) {
			$this->setError(JText::sprintf('COM_KUNENA_LIB_TABLE_ATTACHMENTS_ERROR_USER_INVALID', (int) $user->userid));
		}
		if (!$message->exists()) {
			$this->setError(JText::sprintf('COM_KUNENA_LIB_TABLE_ATTACHMENTS_ERROR_MESSAGE_INVALID', (int) $message->id));
		}
		$this->folder = trim($this->folder, '/');
		if (!$this->folder) {
			$this->setError(JText::_('COM_KUNENA_LIB_TABLE_ATTACHMENTS_ERROR_NO_FOLDER'));
		}
		if (!$this->filename) {
			$this->setError(JText::_('COM_KUNENA_LIB_TABLE_ATTACHMENTS_ERROR_NO_FILENAME'));
		}
		$file = JPATH_ROOT . "/{$this->folder}/{$this->filename}";
		if (!file_exists($file)) {
			$this->setError(JText::sprintf('COM_KUNENA_LIB_TABLE_ATTACHMENTS_ERROR_FILE_MISSING', "{$this->folder}/{$this->filename}"));
		} else {
			if (!$this->hash) $this->hash = md5_file ( $file );
			if (!$this->size) $this->size = filesize ( $file );
		}
		return ($this->getError () == '');
	}
}
