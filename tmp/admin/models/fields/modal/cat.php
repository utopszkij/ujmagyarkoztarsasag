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
 * @version     3.4.1 2015-01-03
 * @since       1.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

jimport( 'joomla.filesystem.path' );
jimport('joomla.form.formfield');

class JFormFieldModal_cat extends JFormField
{
	protected $type='modal_cat';

	protected function getInput()
	{
		$app		= JFactory::getApplication();
		$session	= JFactory::getSession();

		// Initialize some field attributes.
		$class		= !empty($this->class) ? ' class="' . $this->class . '"' : '';

		if ($app->isAdmin())
		{
			$iCparams = JComponentHelper::getParams('com_icagenda');
		}
		else
		{
			$iCparams	= $app->getParams();
		}

		$orderby_catlist		= $iCparams->get('orderby_catlist', 'alpha');
		$default_catlist		= $iCparams->get('default_catlist', '');

		$admin_status_catlist	= $iCparams->get('admin_status_catlist', '1');
		$site_status_catlist	= $iCparams->get('site_status_catlist', '1');

		$admin_status_array		= is_array($admin_status_catlist) ? $admin_status_catlist : array($admin_status_catlist);
		$site_status_array		= is_array($site_status_catlist) ? $site_status_catlist : array($site_status_catlist);

		$admin_status			= implode(',', $admin_status_array);
		$site_status			= implode(',', $site_status_array);

		$catid = $session->get('ic_submit_catid', '');

		// Query List of Categories
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select('c.ordering, c.title, c.state, c.id')
			->from('`#__icagenda_category` AS c');

		// Not display Trashed Categories
		$query->where('c.state <> -2');

		if ($app->isAdmin())
		{
			$query->where($db->qn('c.state') . ' IN (' . $admin_status . ') ');
		}
		else
		{
			$query->where($db->qn('c.state') . ' IN (' . $site_status . ') ');
		}

		if ($orderby_catlist == 'alpha')
		{
			$query->order('c.title ASC');
		}
		elseif ($orderby_catlist == 'ralpha')
		{
			$query->order('c.title DESC');
		}
		elseif ($orderby_catlist == 'order')
		{
			$query->order('c.ordering ASC');
		}

		$db->setQuery($query);
		$categories = $db->loadObjectList();

		$html = '<select id="' . $this->id . '" name="' . $this->name . '"' . $class . '>';

		$html.= ' <option value="">' . JTEXT::_('JOPTION_SELECT_CATEGORY') . '</option>';

		foreach ($categories as $c)
		{
			$html.= '<option value="' . $c->id . '"';

			if ($c->state == '0')
			{
				$html.= ' style="color:red"';
//				$c->title = '[' . $c->title . '] (' . JTEXT::_('JUNPUBLISHED') . ')';
				$c->title = '[' . $c->title . ']';
			}
			elseif ($c->state == '2')
			{
				$html.= ' style="color:orange"';
//				$c->title = $c->title . ' (' . JTEXT::_('JARCHIVED') . ')';
				$c->title = '[' . $c->title . ']';
			}

			if ($this->value == $c->id)
			{
				$html.= ' selected="selected"';
			}

			if ($catid == $c->id)
			{
				$html.= ' selected="selected"';
			}

			if (empty($this->value) && empty($catid)
				&& ($c->id == $default_catlist))
			{
				$html.= ' selected="selected"';
			}

			$html.= '>' . $c->title . '</option>';
		}

		$html.= '</select>';

		// clear the data so we don't process it again
		$session->clear('ic_submit_catid');

		return $html;
	}
}
