<?php
/**
 *------------------------------------------------------------------------------
 *  iCagenda v3 by Jooml!C - Events Management Extension for Joomla! 2.5 / 3.x
 *------------------------------------------------------------------------------
 * @package     com_icagenda
 * @copyright   Copyright (c)2012-2015 Cyril Rezé, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      doorknob & Cyril Rezé
 * @link        http://www.joomlic.com
 *
 * @version     3.5.6 2015-05-06
 * @since       3.4.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

$app = JFactory::getApplication();
$document = JFactory::getDocument();

// Access Administration Features check.
if (JFactory::getUser()->authorise('icagenda.access.features', 'com_icagenda'))
{
	$bootstrapType		= '1';
	$PanelOne_Tag		= 'feature';
	$PanelOne_Title		= JText::_('COM_ICAGENDA_TITLE_FEATURE', true);
	$PanelTwo_Tag		= 'desc';
	$PanelTwo_Title		= JText::_('COM_ICAGENDA_LEGEND_DESC', true);
	$PublishingTag		= 'publishing';
	$PublishingTitle	= JText::_('JGLOBAL_FIELDSET_PUBLISHING', true);

	// Joomla 2.5
	if (version_compare(JVERSION, '3.0', 'lt'))
	{
		jimport( 'joomla.html.html.tabs' );

		$iCmapDisplay		= '3';

		$icPanOne			= JText::_('COM_ICAGENDA_TITLE_EVENT');
		$icPanTwo			= JText::_('COM_ICAGENDA_LEGEND_DESC');
		$icPanPublishing	= JText::_('JGLOBAL_FIELDSET_PUBLISHING');
		$startPane			= 'tabs.start';
		$addPanel			= 'tabs.panel';
		$endPanel			= 'tabs.end';
		$endPane			= 'tabs.end';
		$PanelOne_Tag1		= $PanelOne_Tag;
		$PanelOne_Tag2		= $PanelOne_Title;
		$PanelTwo_Tag1		= $PanelTwo_Tag;
		$PanelTwo_Tag2		= $PanelTwo_Title;
		$PublishingTag1		= $PublishingTag;
		$PublishingTag2		= $PublishingTitle;
	}

	// Joomla 3
	else
	{
		JHtml::_('formbehavior.chosen', 'select');
		jimport('joomla.html.html.bootstrap');

		$icPanOne			= 'icTab';
		$icPanTwo			= 'icTab';
		$icPanPublishing	= 'icTab';

		if ($bootstrapType == '1')
		{
			$iCmapDisplay	= '1';
			$startPane		= 'bootstrap.startTabSet';
			$addPanel		= 'bootstrap.addTab';
			$endPanel		= 'bootstrap.endTab';
			$endPane		= 'bootstrap.endTabSet';
			$PanelOne_Tag1	= $PanelOne_Tag;
			$PanelOne_Tag2	= $PanelOne_Title;
			$PanelTwo_Tag1	= $PanelTwo_Tag;
			$PanelTwo_Tag2	= $PanelTwo_Title;
			$PublishingTag1	= $PublishingTag;
			$PublishingTag2	= $PublishingTitle;
		}
		if ($bootstrapType == '2')
		{
			$iCmapDisplay	= '2';
			$startPane		= 'bootstrap.startAccordion';
			$addPanel		= 'bootstrap.addSlide';
			$endPanel		= 'bootstrap.endSlide';
			$endPane		= 'bootstrap.endAccordion';
			$PanelOne_Tag1	= $PanelOne_Title;
			$PanelOne_Tag2	= $PanelOne_Tag;
			$PanelTwo_Tag1	= $PanelTwo_Title;
			$PanelTwo_Tag2	= $PanelTwo_Tag;
			$PublishingTag1	= $PublishingTitle;
			$PublishingTag2	= $PublishingTag;
		}
	}
	?>

	<script type="text/javascript">
		Joomla.submitbutton = function(task)
		{
			if (task == 'feature.cancel' || document.formvalidator.isValid(document.id('feature-form'))) {
				Joomla.submitform(task, document.getElementById('feature-form'));
			}
			else {
				alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
			}
		}
	</script>

	<form action="<?php echo JRoute::_('index.php?option=com_icagenda&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="feature-form" class="form-validate">
		<div class="container">
			<?php // iCagenda Header ?>
			<header>
				<h1>
					<?php echo empty($this->item->id) ? JText::_('COM_ICAGENDA_LEGEND_NEW_FEATURE') : JText::sprintf('COM_ICAGENDA_LEGEND_EDIT_FEATURE', $this->item->id); ?>&nbsp;<span>iCagenda</span>
				</h1>
				<h2>
					<?php echo JText::_('COM_ICAGENDA_COMPONENT_DESC'); ?>
				</h2>
			</header>
			<div>&nbsp;</div>

			<?php // Begin Content ?>
			<div class="row-fluid">
				<div class="span10 form-horizontal">

					<?php // Open Panel Set ?>
					<?php echo JHtml::_($startPane, 'icTab', array('active' => 'feature')); ?>

						<?php // Panel Feature ?>
						<?php echo JHtml::_($addPanel, $icPanOne, $PanelOne_Tag1, $PanelOne_Tag2); ?>

							<div class="icpanel iCleft">
								<h1>
									<?php echo empty($this->item->id) ? JText::_('COM_ICAGENDA_LEGEND_NEW_FEATURE') : JText::sprintf('COM_ICAGENDA_LEGEND_EDIT_FEATURE', $this->item->id); ?>
								</h1>
								<hr>
								<div class="row-fluid">
									<div class="span12 iCleft">
										<div class="control-group">
											<div class="control-label">
												<?php echo $this->form->getLabel('title'); ?>
											</div>
											<div class="controls">
												<?php echo $this->form->getInput('title'); ?>
											</div>
										</div>
									</div>
								</div>
								<div class="row-fluid">
									<div class="span12 iCleft">
										<div class="control-group">
											<div class="control-label">
												<?php echo $this->form->getLabel('icon'); ?>
											</div>
											<div class="controls">
												<?php echo $this->form->getInput('icon'); ?>
											</div>
										</div>
									</div>
								</div>
								<div class="row-fluid">
									<div class="span12 iCleft">
										<div class="control-group">
											<div class="control-label">
												<?php echo $this->form->getLabel('new_icon'); ?>
											</div>
											<div class="controls">
												<?php echo $this->form->getInput('new_icon'); ?>
											</div>
										</div>
									</div>
								</div>
								<div class="row-fluid">
									<div class="span12 iCleft">
										<div class="control-group">
											<div class="control-label">
												<?php echo $this->form->getLabel('icon_alt'); ?>
											</div>
											<div class="controls">
												<?php echo $this->form->getInput('icon_alt'); ?>
											</div>
										</div>
									</div>
								</div>
								<div class="row-fluid">
									<div class="span12 iCleft">
										<div class="control-group">
											<div class="control-label">
												<?php echo $this->form->getLabel('show_filter'); ?>
											</div>
											<div class="controls">
												<?php echo $this->form->getInput('show_filter'); ?>
											</div>
										</div>
									</div>
								</div>
							</div>

							<?php // End Panel Feature ?>
							<?php if(version_compare(JVERSION, '3.0', 'ge')) echo JHtml::_($endPanel); ?>


							<?php // Panel Description ?>
							<?php //echo JHtml::_($addPanel, $icPanTwo, $PanelTwo_Tag1, $PanelTwo_Tag2); ?>

								<!--div class="icpanel iCleft">
								<h1>
								<?php //echo JText::_('COM_ICAGENDA_FORM_FEATURE_DESCRIPTION_LABEL'); ?>
								</h1>
								<hr>
								<div class="row-fluid">
									<div class="span12 iCleft">
										<h3>
											<?php //echo JText::_('COM_ICAGENDA_FORM_FEATURE_DESCRIPTION_DESC'); ?>
										</h3>
										<?php //echo $this->form->getInput('desc'); ?>
									</div>
								</div>
							</div-->

						<?php // End Panel Description ?>
						<?php //if(version_compare(JVERSION, '3.0', 'ge')) echo JHtml::_($endPanel); ?>


						<?php // Panel Publishing ?>
						<?php echo JHtml::_($addPanel, $icPanPublishing, $PublishingTag1, $PublishingTag2); ?>

							<div class="icpanel iCleft">
								<h1>
									<?php echo JText::_('JGLOBAL_FIELDSET_PUBLISHING'); ?>
								</h1>
								<hr>
								<div class="row-fluid">
									<div class="span6 iCleft">
										<div class="control-group">
											<div class="control-label">
												<?php echo $this->form->getLabel('alias'); ?>
											</div>
											<div class="controls">
												<?php echo $this->form->getInput('alias'); ?>
											</div>
										</div>
										<div class="control-group">
											<div class="control-label">
												<?php echo $this->form->getLabel('id'); ?>
											</div>
											<div class="controls">
												<?php echo $this->form->getInput('id'); ?>
											</div>
										</div>
										<div class="control-group">
											<div class="control-label">
												<?php echo $this->form->getLabel('checked_out'); ?>
											</div>
											<div class="controls">
												<?php echo $this->form->getInput('checked_out'); ?>
											</div>
										</div>
										<div class="control-group">
											<div class="control-label">
												<?php echo $this->form->getLabel('checked_out_time'); ?>
											</div>
											<div class="controls">
												<?php echo $this->form->getInput('checked_out_time'); ?>
											</div>
										</div>
									</div>
								</div>
							</div>

						<?php // End Panel Publishing ?>
						<?php echo JHtml::_($endPanel); ?>

					<?php // End Panel Set ?>
					<?php echo JHtml::_($endPane, 'icTab'); ?>

				</div>


				<?php // Begin Sidebar ?>
				<div class="span2 iCleft">

					<h4>
						<?php echo JText::_('COM_ICAGENDA_TITLE_SIDEBAR_DETAILS'); ?>
					</h4>
					<hr>
					<div class="control-group">
						<div class="control-label">
							<?php echo $this->form->getLabel('state'); ?>
						</div>
						<div class="controls">
							<?php echo $this->form->getInput('state'); ?>
						</div>
					</div>

				<?php // End Sidebar ?>
				</div>

				<div class="clr"></div>
			</div>
		</div>
		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
		<div class="clr"></div>
	</form>

	<?php
	// Joomla 2.5
	if (version_compare(JVERSION, '3.0', 'lt'))
	{
		JHtml::stylesheet('com_icagenda/template.j25.css', false, true);
		JHtml::stylesheet('com_icagenda/icagenda-back.j25.css', false, true);

		JHtml::_('behavior.framework');

		// load jQuery, if not loaded before
		$scripts = array_keys($document->_scripts);
		$scriptFound = false;
		$scriptuiFound = false;

		for ($i = 0; $i < count($scripts); $i++)
		{
			if (stripos($scripts[$i], 'jquery.min.js') !== false)
			{
				$scriptFound = true;
			}
			if (stripos($scripts[$i], 'jquery.js') !== false)
			{
				$scriptFound = true;
			}
			if (stripos($scripts[$i], 'jquery-ui.min.js') !== false)
			{
				$scriptuiFound = true;
			}
		}

		// jQuery Library Loader
		if (!$scriptFound)
		{
			// load jQuery, if not loaded before
			if (!$app->get('jquery'))
			{
				$app->set('jquery', true);
				// add jQuery
				$document->addScript('https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js');
				$document->addScript( JURI::root( true ) . '/media/com_icagenda/js/jquery.noconflict.js' );
			}
		}

		if (!$scriptuiFound)
		{
			$document->addScript('https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js');
		}

		$document->addScript( JURI::root( true ) . '/media/com_icagenda/js/template.js' );
	}
	else
	{
		JHtml::_('bootstrap.framework');
		JHtml::_('jquery.framework');
	}

	}
else
{
	$app->enqueueMessage(JText::_('JERROR_ALERTNOAUTHOR'), 'warning');
	$app->redirect(htmlspecialchars_decode('index.php?option=com_icagenda&view=icagenda'));
}
