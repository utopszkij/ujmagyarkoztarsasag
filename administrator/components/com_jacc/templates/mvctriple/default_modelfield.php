##codestart##

defined('JPATH_BASE') or die;

jimport('joomla.html.html');

JFormHelper::loadFieldClass('list');


/**
 * Form Field class.
 */
class JFormField##Component####name## extends JFormFieldList
{
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	public $type = '##Component####name##';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array		An array of JHtml options.
	 */
	protected function getOptions()
	{
		$db		= &JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select('##primary## AS value, ##hident## AS text');
		$query->from('##table##');
		$query->order('##hident## DESC');

		// Get the options.
		$db->setQuery($query->__toString());

		$options = $db->loadObjectList();

		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}


		$options	= array_merge(
			parent::getOptions(),
			$options
		);

		return $options;
	}
}