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
 * @version     3.4.0 2014-12-06
 * @since       3.2.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

jimport( 'joomla.filesystem.path' );
jimport('joomla.form.formfield');

class JFormFieldModal_multicat extends JFormField
{
	protected $type='modal_multicat';

	protected function getInput()
	{
		// Initialize some field attributes.
		$class	= !empty($this->class) ? ' class="' . $this->class . '"' : '';

		// Query List of Categories
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select('a.title, a.state, a.id')
			->from('`#__icagenda_category` AS a');
		$db->setQuery($query);
		$cat	= $db->loadObjectList();

		if (!is_array($this->value))
		{
			$this->value = array($this->value);
		}

		$html = ' <select multiple id="' . $this->id . '_id" name="' . $this->name . '"' . $class . '>';

		if (version_compare(JVERSION, '3.0', 'lt'))
		 {
			if ($this->name != 'jform[catid]' && $this->name != 'catid')
			{
				$html.= '<option value="0"';

				if (in_array('0', $this->value))
				{
					$html.= ' selected="selected"';
				}

				$html.= '>-- '.JTEXT::_('COM_ICAGENDA_ALL_CATEGORIES').' --</option>';
			}
		}

		foreach ($cat as $c)
		{
			if ($c->state == '1')
			{
				$html.= '<option value="' . $c->id . '"';

				if ( (in_array($c->id, $this->value)) && (!in_array('0', $this->value)) )
				{
					$html.= ' selected="selected"';
				}

				$html.= '>' . $c->title . '</option>';
			}
		}

		$html.= '</select>';

		return $html;
	}
}
