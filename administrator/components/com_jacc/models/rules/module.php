<?php
/**
 * @version		$Id: module.php 125 2012-10-09 11:09:48Z michel $
 * @package		Joomla.Framework
 * @subpackage	Form
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @copyright	Copyright (C) 2008 - 2009 JXtended, LLC. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

jimport('joomla.form.formrule');	

/**
 * Form Rule class for the Joomla Framework.
 *
 * @package		Joomla.Framework
 * @subpackage	Form
 * @since		1.6
 */
class JFormRuleModule extends JFormRule
{
	/**
	 * The regular expression.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $regex = 'mod_.*';

	/**
	 * The regular expression modifiers.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $modifiers = 'i';
}