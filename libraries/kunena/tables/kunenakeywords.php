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
 * Kunena Keywords Table
 * Provides access to the #__kunena_keywords table
 */
class TableKunenaKeywords extends KunenaTable {
	public $id = null;
	public $name = null;
	public $public_count = null;
	public $total_count = null;

	public function __construct($db) {
		parent::__construct ( '#__kunena_keywords', 'id', $db );
	}

	public function check() {
		$this->name = trim($this->name);
		if (!$this->name) {
			$this->setError(JText::_('COM_KUNENA_LIB_TABLE_KEYWORDS_ERROR_EMPTY'));
		}
		return ($this->getError () == '');
	}
}
