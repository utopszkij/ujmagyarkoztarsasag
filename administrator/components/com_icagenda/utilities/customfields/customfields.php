<?php
/**
 *------------------------------------------------------------------------------
 *  iCagenda v3 by Jooml!C - Events Management Extension for Joomla! 2.5 / 3.x
 *------------------------------------------------------------------------------
 * @package     iCagenda
 * @subpackage  utilities
 * @copyright   Copyright (c)2012-2015 Cyril Rezé, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Cyril Rezé (Lyr!C)
 * @link        http://www.joomlic.com
 *
 * @version     3.5.10 2015-08-25
 * @since       3.4.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

/**
 * class icagendaCustomfields
 */
class icagendaCustomfields
{
	/**
	 * Function to return list of custom fields depending on the parent form
	 *
	 * @access	public static
	 * @param	$parent_form (1 registration, 2 event edit)
	 * 			$state (if not defined, state is published ('1'))
	 * @return	object list array of custom fields depending on the item ID
	 *
	 * @since   3.4.0
	 */
	static public function getListCustomFields($parent_form, $state = null)
	{
		$filter_state = isset($state) ? $state : 1;

		// Create a new query object.
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select('cf.slug AS cf_slug, cf.type AS cf_type, cf.options AS cf_options,
						cf.title AS cf_title, cf.type AS cf_type, cf.required AS cf_required')
			->from('#__icagenda_customfields AS cf')
			->where($db->qn('cf.state') . ' = ' . $db->q($filter_state))
			->where($db->qn('cf.parent_form') . ' = ' . $db->q($parent_form))
			->order('cf.ordering ASC');
		$db->setQuery($query);
		$list = $db->loadObjectList();

		if ($list) return $list;

		return false;
	}

	/**
	 * Function to return list of custom fields depending on the item ID
	 *
	 * @access	public static
	 * @param	$id item ID
	 * 			$parent_form (1 registration, 2 event edit)
	 * 			$state (if not defined, state is published ('1'))
	 * @return	object list array of custom fields depending on the item ID
	 *
	 * @since   3.4.0
	 */
	static public function getList($id, $parent_form = null, $state = null)
	{
		$filter_state = isset($state) ? $state : 1;

		// Create a new query object.
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select('cf.slug AS cf_slug, cfd.value AS cf_value, cfd.parent_id AS cf_parent_id, cf.title AS cf_title, cf.required AS cf_required')
			->from('#__icagenda_customfields AS cf')
			->leftJoin($db->qn('#__icagenda_customfields_data') . ' AS cfd'
				. ' ON ' . $db->qn('cfd.parent_id') .' = ' . (int)$id
				. ' AND ' . $db->qn('cf.slug') .' = ' . $db->qn('cfd.slug'))
			->where($db->qn('cf.state') . ' = ' . $db->q($filter_state))
			->where($db->qn('cf.parent_form') . ' = ' . $db->q($parent_form))
			->order('cf.ordering ASC');
		$db->setQuery($query);
		$list = $db->loadObjectList();

		if ($list) return $list;

		return false;
	}

	/**
	 * Function to return a list of filled custom fields depending on the item ID
	 *
	 * @access	public static
	 * @param	$id item ID
	 * 			$parent_form (1 registration, 2 event edit)
	 * 			$state (if not defined, state is published ('1'))
	 * @return	object list array of custom fields not empty depending on the item ID
	 *
	 * @since   3.4.0
	 */
	static public function getListNotEmpty($id, $parent_form = null, $state = null)
	{
		$filter_state = isset($state) ? $state : 1;

		// Create a new query object.
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select('cfd.slug AS cf_slug, cfd.value AS cf_value, cfd.parent_id AS cf_parent_id, cf.title AS cf_title')
			->from('#__icagenda_customfields_data AS cfd')
			->leftJoin($db->qn('#__icagenda_customfields') . ' AS cf'
				. ' ON ' . $db->qn('cf.slug') .' = ' . $db->qn('cfd.slug'))
			->where($db->qn('cf.state') . ' = ' . $db->q($filter_state));

		if ($parent_form)
		{
			$query->where($db->qn('cfd.parent_form') . ' = ' . $db->q($parent_form));
		}

		$query->where($db->qn('cfd.parent_id') . ' = ' . (int)$id);
		$query->order('cf.ordering ASC');
		$db->setQuery($query);
		$list = $db->loadObjectList();

		if ($list) return $list;

		return false;
	}

	/**
	 * Return the HTML body of Custom fields for this parent form (parent_id)
	 *
	 * @return HTML fields
	 *
	 * @since	3.4.0
	 */
	static public function loader($parent_form)
	{
		$app = JFactory::getApplication();
		$session = JFactory::getSession();
		$custom_fields = $session->get('custom_fields');

		$customfields = icagendaCustomfields::getCustomfields($parent_form);

		$cf_display = '';

		if ( $customfields )
		{
			foreach ($customfields as $icf)
			{
				if (empty($icf->value)) $icf->value = '';

//				if ($custom_fields) $icf->value = $custom_fields[$icf->slug];
				if ( $app->isSite() )
				{
					$icf->value = isset($custom_fields[$icf->slug]) ? $custom_fields[$icf->slug] : '';
				}

				$options_required = array('list', 'radio');

				// If type is list or radio, should have options
				if ((in_array($icf->type, $options_required) && $icf->options)
					|| ! in_array($icf->type, $options_required))
				{
					$cf_display.= icagendaCustomfields::displayField(
						$icf->type,
						$icf->title,
						$icf->alias,
						$icf->slug,
						$icf->description,
						$icf->value,
						$icf->options,
						$icf->required
					);
				}
			}

			if ($app->isAdmin()) $cf_display.= '<hr>';
		}
		elseif ( $app->isAdmin() )
		{
			$cf_display.= '<div class="alert alert-info">';
			$cf_display.= JText::_('COM_ICAGENDA_CUSTOMFIELDS_NONE');
			$cf_display.= '</div>';
		}
		elseif ( $app->isSite() )
		{
			return false;
		}

		return $cf_display;
	}

	/**
	 * Gets the custom fields for this form
	 *
	 * @return object list
	 *
	 * @since	3.4.0
	 */
	static public function getCustomfields($parent_form)
	{
		$app = JFactory::getApplication();
		$id = $app->input->getInt('id');

		// Get the database connector.
		$db = JFactory::getDbo();

		$list_slugs = array();

		if ($id)
		{
			// Get the query from the database connector.
			$query = $db->getQuery(true);

			// Build the query
			$query->select('id, slug')
				->from($db->qn('#__icagenda_customfields').' AS cf');
			$query->where($db->qn('cf.parent_form').' = ' .$db->q($parent_form));

			// Run Query
			$db->setQuery($query);

			// Invoke the Query
			$all_slugs = $db->loadObjectList();

			// Create array of custom fields slugs for this event
			foreach ($all_slugs as $s)
			{
				$list_slugs[] = '"' . $s->slug . '"';
			}

			$list_slugs = implode(',', $list_slugs);
		}

		// Get the query from the database connector.
		$query = $db->getQuery(true);

		// Build the query
		$query->select('cf.*')
			->from($db->qn('#__icagenda_customfields').' AS cf');

		if ($id && $list_slugs)
		{
			// Build the query
			$query->select('cfd.value AS value')
				->leftJoin($db->qn('#__icagenda_customfields_data') . ' AS cfd'
					. ' ON (' . $db->qn('cfd.parent_id') . ' = ' . (int)$id
					. ' AND ' . $db->qn('cfd.slug') . ' = ' .$db->qn('cf.slug') . ')')
				->where($db->qn('cf.slug').' IN ('.$list_slugs.')');
		}

		$query->where($db->qn('cf.parent_form').' = ' .$db->q($parent_form));
		$query->where($db->qn('cf.state').' = 1');

		$query->order('cf.ordering ASC');

		// Tell the database connector what query to run.
		$db->setQuery($query);

		// Invoke the query.
		if ($db->loadObjectList()) return $db->loadObjectList();

		return false;
	}

	/**
	 * Create the HTML body of the custom fields
	 *
	 * @return object list
	 *
	 * @since	3.4.0
	 */
	static public function displayField($type, $title, $alias, $slug, $description, $value, $options, $required)
	{
		$options_required = array('list', 'radio');

		// If type is list or radio, should have options
		if (in_array($type, $options_required) && ! $options) return false;

		$app = JFactory::getApplication();
		$view = $app->input->get('view');

		$ic_prefix = $app->isSite() ? 'ic-' : '';
		$ic_data = ($app->isSite() && $view != 'registration') ? 'custom_fields' : 'jform[custom_fields]';

		if (empty($value)) $value = '';
// Remove to get session value frontend		$value = $app->isAdmin() ? $value : '';

		$text_required	= $required ? ' required="true"' : '';
		$list_required	= $required ? ' required' : '';
		$radio_required	= $required ? ' required' : '';

		// Required, '*' after label
		$required_icon = $required ? ' *' : '';

		$class_label = ($type == 'radio') ? $ic_prefix . 'control-label' : '';
		$icTip_custom = $description
			? htmlspecialchars('<strong>' . $title . '</strong><br />' . $description . '')
			: '';
		if ($type == 'list' || $type == 'radio') { $is_list = ' ic-select'; } else { $is_list = ''; }

		$cf_fields = '<div class="' . $ic_prefix . 'control-group clearfix" id="' . $alias . '_alias">';
		$cf_fields.= '<div id="' . $alias . '_message"></div>';
		$cf_fields.= '<div class="' . $ic_prefix . 'control-label">';

		// Label
		$label = '<label';

		if ($app->isAdmin())
		{
			if ($class_label || $icTip_custom)
			{
				if ($icTip_custom) $label.= ' title="" data-original-title="'.$icTip_custom.'"';
				$label.= ' class="';
				if ($icTip_custom) $label.= 'hasTooltip';
				if ($icTip_custom && $class_label) $label.= ' ';
				if ($class_label) $label.= $class_label;
				$label.= '"';
			}
		}

		if ($type != 'radio')
		{
			$label.= ' for="' . $slug . '_slug"';
		}

		$label.= '>';
		$label.= $title;

//		if ($type != 'radio')
//		{
			$label.= $required_icon;
//		}

		$label.= '</label>';

		$cf_fields.= $label;
		$cf_fields.= '</div>';

		$cf_fields.= '<div class="' . $ic_prefix . 'controls' . $is_list . '">';

		// Field Type TEXT
		if ($type == 'text')
		{
			$cf_fields.= '<input type="'.$type.'"';
			$cf_fields.= ' class="input-large"';
			$cf_fields.= ' id="' . $slug . '_slug"';
			$cf_fields.= ' name="' . $ic_data . '['.$slug.']"';
			$cf_fields.= ' value="' . $value . '"';
			$cf_fields.= ' placeholder="' . $options . '"';
			$cf_fields.= $text_required;
			$cf_fields.= ' />';
		}

		// Field Type LIST
		elseif ($type == 'list')
		{
//			$cf_fields.= '<select'.$list_required.' id="' . $slug . '" name="' . $ic_data . '['.$slug.']">';
			$cf_fields.= '<select'.$list_required.' type="list" class="select-large" id="' . $slug . '_slug" name="' . $ic_data . '['.$slug.']">';

			$empty_selected = empty($value) ? ' selected="selected"' : '';

//			$cf_fields.= '<option value=""'.$empty_selected.'>- ' . JText::_('IC_SELECT_AN_OPTION') . ' -</option>';
			$cf_fields.= '<option value="">- ' . JText::_('IC_SELECT_AN_OPTION') . ' -</option>';

			$opts_list = str_replace("\n", "##BREAK##", $options);
			$opts_list = explode("##BREAK##", $opts_list);

			foreach ($opts_list as $opts)
			{
				$opt = explode("=", $opts);

				if ($opt[0] && $opt[1])
				{
					if (empty($value))
					{
						$selected = isset($opt[2]) ? ' selected="selected"' : '';
					}
						else
					{
						$selected = '';
					}

					$cf_fields.= '<option value="'.$opt[0].'"';

					if ($value == $opt[0])
					{
						$cf_fields.= ' selected="selected"';
					}

					$cf_fields.= ''.$selected.'>';
					$cf_fields.= $opt[1].'</option>';
				}
			}
			$cf_fields.= '</select>';
		}

		// Field Type RADIO
		elseif ($type == 'radio')
		{
			$cf_fields.= '<fieldset class="' . $ic_prefix . 'radio ' . $ic_prefix . 'btn-group">';

			$opts_list = str_replace("\n", "##BREAK##", $options);
			$opts_list = explode("##BREAK##", $opts_list);

			foreach ($opts_list as $opts)
			{
				$opt = explode("=", $opts);

				if (($opt[0] || $opt[0] == 0) && $opt[1])
				{
					if (empty($value))
					{
						$checked = isset($opt[2]) ? ' checked="checked"' : '';
						$default = $checked ? $ic_prefix . 'btn-success' : '';
					}
					elseif ($value == $opt[0])
					{
						$checked = '';
						$default = $ic_prefix . 'btn-success';
					}
					else
					{
						$checked = '';
						$default = '';
					}

					$class_btn = $app->isSite() ? 'ic-btn ' : '';

					$cf_fields.= '<label class="' . $class_btn . $default . '">';
					$cf_fields.= '<input type="radio"';
					$cf_fields.= ' id="' . $slug . '_slug"';
					$cf_fields.= ' name="' . $ic_data . '[';
					$cf_fields.= $slug;
					$cf_fields.= ']"';
					$cf_fields.= ' value="'.$opt[0].'"';

					if ($value == $opt[0])
					{
						$cf_fields.= ' checked="checked"';
					}

					$cf_fields.= $checked.'/>';
					$cf_fields.= $opt[1].'</label>';
				}
			}

			$cf_fields.= '</fieldset>';
		}

		if ($icTip_custom && $app->isSite())
		{
			$cf_fields.= ' <span class="iCFormTip iCicon-info-circle" title="' . $icTip_custom . '"></span>';
		}

		$cf_fields.= '</div>';
		$cf_fields.= '</div>';

		return $cf_fields;
	}


	/**
	 * Save Custom Fields to the database if at least one is filled
	 * or update existing data from custom fields.
	 *
	 * @since	3.4.0
	 */
	static public function saveToData($custom_fields, $parent_id, $parent_form, $state = 1, $language = '*')
	{
		// Get the database connector.
		$db = JFactory::getDBO();

		if (isset($custom_fields) && is_array($custom_fields))
		{
			foreach ( $custom_fields as $name => $value )
			{
				$customfields_data = new stdClass();
				$customfields_data->slug = $name;
				$customfields_data->value = $value;
				$customfields_data->state = $state;
				$customfields_data->parent_form = $parent_form;
				$customfields_data->parent_id = $parent_id;
				$customfields_data->language = $language;

				$query = $db->getQuery(true)
					->select('id')
					->from($db->qn('#__icagenda_customfields_data'))
					->where($db->qn('slug') . ' = ' . $db->q($customfields_data->slug))
					->where($db->qn('parent_form') . ' = ' . $db->q($customfields_data->parent_form))
					->where($db->qn('parent_id') . ' = ' . $db->q($customfields_data->parent_id));
				$db->setQuery($query);
				$id_exists = $db->loadResult();

				if ( ! $id_exists && $customfields_data->value)
				{
					$db->insertObject( '#__icagenda_customfields_data', $customfields_data, 'id' );
				}
				elseif (empty($customfields_data->value))
				{
					$query = $db->getQuery(true);

					// Delete any empty slug records from the __icagenda_customfields_data table if exists
					$conditions = array(
    					$db->quoteName('parent_id') . ' = ' . $db->quote($customfields_data->parent_id),
    					$db->quoteName('slug') . ' = ' . $db->quote($customfields_data->slug)
					);

					$query->delete($db->quoteName('#__icagenda_customfields_data'));
					$query->where($conditions);

					$db->setQuery($query);
					$db->execute($query);

					if ( ! $db->execute())
					{
						return false;
					}
				}
				else
				{
					$customfields_data->id = $id_exists;
					$db->updateObject('#__icagenda_customfields_data', $customfields_data, 'id');
				}
			}
		}
	}

	/**
	 * Delete Custom Fields from the database
	 * or update existing data from custom fields.
	 *
	 * @since	3.5.6
	 */
	static public function deleteData($parent_id, $parent_form)
	{
		// Get the database connector.
		$db = JFactory::getDbo();

		// Delete any unwanted customfields records from the __icagenda_customfields_data table
		$query = $db->getQuery(true);
		$query->delete($db->qn('#__icagenda_customfields_data'));
		$query->where('parent_id = ' . (int) $parent_id);
		$query->where('parent_form = ' . (int) $parent_form);

		$db->setQuery($query);
		$db->execute($query);

		if ( ! $db->execute())
		{
			return false;
		}

		return true;
	}

	/**
	 * Clean Custom Fields from the database (fix for previous versions)
	 *
	 * @since	3.5.6
	 */
	static public function cleanData($parent_form)
	{
		// Get the database connector.
		$db = JFactory::getDbo();

		// Get Registrations ids
		if ($parent_form == 1)
		{
			$query = $db->getQuery(true)
				->select('id')
				->from($db->qn('#__icagenda_registration'));
			$db->setQuery($query);
			$list = $db->loadColumn();
		}

		// Get Events ids
		elseif ($parent_form == 2)
		{
			// Get Registrations ids
			$query = $db->getQuery(true)
				->select('id')
				->from($db->qn('#__icagenda_events'));
			$db->setQuery($query);
			$list = $db->loadColumn();
		}

		$parent_ids = isset($list) && is_array($list) ? implode(',', $list) : '';

		// Delete any unwanted customfields records from the __icagenda_customfields_data table
		$query = $db->getQuery(true);
		$query->delete($db->qn('#__icagenda_customfields_data'));
		$query->where('parent_form = ' . (int) $parent_form);
		$query->where('parent_id NOT IN (' . $parent_ids . ')');

		$db->setQuery($query);
		$db->execute($query);

		if ( ! $db->execute())
		{
			return false;
		}

		return true;
	}
}
