<?php
/**
 * @version		$Id: categoryparent.php 125 2012-10-09 11:09:48Z michel $
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

jimport('joomla.html.html');

JFormHelper::loadFieldClass('list');


/**
 * Form Field class for the Joomla Framework.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_categories
 * @since		1.6
 */
class JFormFieldCategoryParent extends JFormFieldList
{
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	public $type = 'CategoryParent';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array		An array of JHtml options.
	 */
	protected function getOptions()
	{
		$app = JFactory::getApplication();
		
		$db		= &JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select('a.id AS value, a.title AS text, a.level');
		$query->from('#__##component##_categories AS a');
		$query->join('LEFT', '`#__##component##_categories` AS b ON a.lft > b.lft AND a.rgt < b.rgt');

		// Filter by the type
		if ($extension = $app->getUserState('com_##component##_categories.filter.extension')) {
			$query->where('(a.extension = '.$db->quote($extension).' OR a.parent_id = 0)');
		}

		// Prevent parenting to children of this item.
		if ($id = $this->element['id']) {
			$query->join('LEFT', '`#__##component##_categories` AS p ON p.id = '.(int) $id);
			$query->where('NOT(a.lft >= p.lft AND a.rgt <= p.rgt)');
		}

		$query->group('a.id');
		$query->order('a.lft ASC');

		// Get the options.
		$db->setQuery($query);

		$options = $db->loadObjectList();

		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}

		// Pad the option text with spaces using depth level as a multiplier.
		for ($i = 0, $n = count($options); $i < $n; $i++) {
			$options[$i]->text = str_repeat('- ', $options[$i]->level).$options[$i]->text;
		}

		$options	= array_merge(
			parent::getOptions(),
			$options
		);

		return $options;
	}
}