<?php
defined('JPATH_BASE') or die;

jimport('joomla.form.fields.list');
require_once(JPATH_ADMINISTRATOR.'/components/com_ammvc/helpers/ammvc.php');

/**
 * Form Field class for the Joomla Framework.
 *
 * @package		Joomla.Framework
 * @subpackage	Form
 * @since		1.6
 */
class JFormFieldAmmvcCategory extends JFormField
{
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	protected $type = 'AmmvcCategory';
	
	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array		An array of JHtml options.
	 */
	protected function getInput()
	{
	
		$size		= ($v = $this->element['size']) ? ' size="'.$v.'"' : '';
		$class		= ($v = $this->element['class']) ? 'class="'.$v.'"' : 'class="inputbox"';
		$extension		= ($v = $this->element['extension']) ? $v : '';
		$readonly	= $this->element['readonly'] == 'true' ? ' readonly="readonly"' : '';
		$onchange	= ($v = $this->element['onchange']) ? ' onchange="'.$v.'"' : '';
		$maxLength	= ($v = $this->element['maxlength']) ? ' maxlength="'.$v.'"' : '';
		$multiple	= ($v = $this->element['multiple']) ? ' multiple="'.$v.'"' : '';
		$input = JHtml::_('ammvc.categories', $extension, $this->value, $this->name, '- Select Category -', array('attributes'=>$class.$size.$readonly.$onchange.$maxLength.$multiple, 'filter.published' => 1)); 
	
		return $input ;
	}
}
?>