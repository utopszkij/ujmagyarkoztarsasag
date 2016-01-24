<?php

// No direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

class plg##Plugtype####Plugin## extends JPlugin
{
	
	/**
	 * Constructor
	 *
	 * @access      protected
	 * @param       object  $subject The object to observe
	 * @param       array   $config  An array that holds the plugin configuration
	 * @since       1.5
	 */
	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}

	/**
	 * readmore button
	 * @return array A two element array of (imageName, textToInsert)
	 */
	public function onDisplay($name)
	{
		$app = JFactory::getApplication();

		$doc		= JFactory::getDocument();

		$js = "
			function insert##Plugin##(editor) {
				jInsertEditorText('<div>example</div>', editor);
			}
			";

		$doc->addScriptDeclaration($js);

		$button = new JObject;
		$button->set('modal', false);
		$button->set('onclick', 'insert##Plugin##(\''.$name.'\');return false;');
		$button->set('text', JText::_('PLG_##Plugin##_BUTTON_##Plugin##'));
		$button->set('name', '##plugin##');
		$button->set('link', '#');

		return $button;
	}
    
}