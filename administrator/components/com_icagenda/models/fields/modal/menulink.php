<?php
/**
 *------------------------------------------------------------------------------
 *  iCagenda v3 by Jooml!C - Events Management Extension for Joomla! 2.5 / 3.x
 *------------------------------------------------------------------------------
 * @package     com_icagenda
 * @copyright   Copyright (c)2012-2015 Cyril RezŽ, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Cyril RezŽ (Lyr!C)
 * @link        http://www.joomlic.com
 *
 * @version     3.3.6 2014-04-29
 * @since       2.1.4
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

jimport( 'joomla.filesystem.path' );
jimport('joomla.form.formfield');

class JFormFieldModal_Menulink extends JFormField
{
	protected $type='modal_menulink';

	protected function getInput()
	{

		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select('a.title, a.published, a.id, a.path')
			->from('`#__menu` AS a')
			->where( "(link = 'index.php?option=com_icagenda&view=list') AND (published > 0)" );
		$db->setQuery($query);
		$link = $db->loadObjectList();
		$class = JRequest::getVar('class');

		$html= '
			<select id="'.$this->id.'_id"'.$class.' name="'.$this->name.'">';
		if ($this->name!='jform[catid]' && $this->name!='catid') $html.='<option value="">- '.JTEXT::_('JGLOBAL_AUTO').' -</option>';
		foreach ($link as $l){
		if ($l->published == '1') {
			$html.='<option value="'.$l->id.'"';
			if ($this->value == $l->id){
				$html.='selected="selected"';
			}
			$html.='>['.$l->id.'] '.$l->title.'</option>';
		}
		}
		$html.='</select>';
		return $html;

	}
}
