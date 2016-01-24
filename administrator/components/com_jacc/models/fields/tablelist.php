<?php

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');


/**
 * Form Field class for the Joomla Framework.
 *
 * @package		Jacc
 * @subpackage	fields
 */
class JFormFieldTableList extends JFormFieldList
{
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	public $type = 'TableList';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array		An array of JHtml options.
	 */
	protected function getOptions()
	{
	
		$db =& JFactory::getDBO();
		$tables= $db->getTableList();
		$config =& JFactory::getConfig();
		$options = array();
		$db = JFactory::getDBO();		
		for ($i=0;$i<count($tables);$i++) {
			//only tables with primary key
			$db->setQuery("SHOW FIELDS FROM `".$tables[$i]."` WHERE LOWER( `Key` ) = 'pri'");
			if ($db->loadResult()) {
				$dbprefix = version_compare(JVERSION,'3.0','lt') ? $config->getValue('config.dbprefix') : $config->get('dbprefix');
				$options[$i] = new stdClass;
				$options[$i]->value = str_replace($dbprefix, '#__', $tables[$i]);
				$options[$i]->text = $tables[$i];
			}
		}

		return $options;
	}
}
