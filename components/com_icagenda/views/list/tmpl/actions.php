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
 * @version 	3.5.6 2015-05-17
 * @since       3.6.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

// Set Item Object
$this_item	= (array) $this->data->items;
$item		= array_shift($this_item);
?>

<div id="icagenda" class="ic-actions-view<?php echo $this->pageclass_sfx; ?>">
	<?php
	// Set base path
//	JLayoutHelper::$defaultBasePath = JPATH_PLUGINS . '/content/ic_paypal/layouts';

	// Render mylayout.php
//	$renderedLayout = JLayoutHelper::render($item);
//	echo $renderedLayout;

	$app = JFactory::getApplication();
	$status = $app->input->get('status', '');

	if ($status)
	{
		$layout = new JLayoutFile($status, $basePath = JPATH_PLUGINS . '/content/ic_' . $status . '/layouts');
		$displayData = array('item' => $item, 'actions' => $this->actions, 'params' => $this->params);
		$html = $layout->render($displayData);

		echo $html;
	}
	else
	{
		echo 'No Action for this page';
	}

//	$layout = new JLayoutFile('plugins.content.ic_paypal.layouts.payment_test');
//	$renderedLayout = JLayoutHelper::render('payment_test');
//	$data = array();
//	echo $layout->render($item);
//	$this->getLayout('payment_test');

//	echo $this->loadTemplate('test');
	?>
	<div>
		<a href="index.php" class="btn btn-small btn-info button">
		<?php if(version_compare(JVERSION, '3.0', 'ge')) : ?>
			<i class="icon-home icon-white"></i>&nbsp;<?php echo JTEXT::_('JERROR_LAYOUT_HOME_PAGE'); ?>
		<?php else : ?>
			<span style="color:#FFF"><?php echo JTEXT::_('JERROR_LAYOUT_HOME_PAGE'); ?></span>
		<?php endif; ?>
		</a>
	</div>
	<br />
</div>
<?php
if (version_compare(JVERSION, '3.0', 'lt'))
{
	JHtml::_('stylesheet', 'icagenda-front.j25.css', 'components/com_icagenda/add/css/');
}
