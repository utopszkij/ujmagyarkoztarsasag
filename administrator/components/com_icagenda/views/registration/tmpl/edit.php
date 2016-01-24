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
 * @version     3.5.9 2015-07-31
 * @since       3.3.3
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

JHtml::_('behavior.tooltip');
JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');

$app = JFactory::getApplication();

// Access Administration Categories check.
if (JFactory::getUser()->authorise('icagenda.access.registrations', 'com_icagenda'))
{
	$document			= JFactory::getDocument();
	$bootstrapType		= '1';
	$RegistrationTag	= 'Registration';
	$RegistrationTitle	= JText::_('COM_ICAGENDA_REGISTRATION_INFORMATION', true);
	$DescTag			= 'desc';
	$DescTitle			= JText::_('COM_ICAGENDA_REGISTRATION_NOTES_DISPLAY_LABEL', true);
	$PublishingTag		= 'publishing';
	$PublishingTitle	= JText::_('JGLOBAL_FIELDSET_PUBLISHING', true);

	// Joomla 2.5
	if (version_compare(JVERSION, '3.0', 'lt'))
	{
		jimport( 'joomla.html.html.tabs' );

		$iCmapDisplay		= '3';

		$icPanRegistration	= JText::_('COM_ICAGENDA_TITLE_REGISTRATION');
		$icPanDesc			= JText::_('COM_ICAGENDA_REGISTRATION_NOTES_DISPLAY_LABEL');
		$icPanPublishing	= JText::_('JGLOBAL_FIELDSET_PUBLISHING');
		$startPane			= 'tabs.start';
		$addPanel			= 'tabs.panel';
		$endPanel			= 'tabs.end';
		$endPane			= 'tabs.end';
		$RegistrationTag1	= $RegistrationTag;
		$RegistrationTag2	= $RegistrationTitle;
		$DescTag1			= $DescTag;
		$DescTag2			= $DescTitle;
		$PublishingTag1		= $PublishingTag;
		$PublishingTag2		= $PublishingTitle;
	}

	// Joomla 3
	else
	{
		JHtml::_('formbehavior.chosen', 'select');
		jimport('joomla.html.html.bootstrap');

		$icPanRegistration	= 'icTab';
		$icPanDesc			= 'icTab';
		$icPanPublishing	= 'icTab';

		if ($bootstrapType == '1')
		{
			$iCmapDisplay		= '1';
			$startPane			= 'bootstrap.startTabSet';
			$addPanel			= 'bootstrap.addTab';
			$endPanel			= 'bootstrap.endTab';
			$endPane			= 'bootstrap.endTabSet';
			$RegistrationTag1	= $RegistrationTag;
			$RegistrationTag2	= $RegistrationTitle;
			$DescTag1			= $DescTag;
			$DescTag2			= $DescTitle;
			$PublishingTag1		= $PublishingTag;
			$PublishingTag2		= $PublishingTitle;
		}
		if ($bootstrapType == '2')
		{
			$iCmapDisplay		= '2';
			$startPane			= 'bootstrap.startAccordion';
			$addPanel			= 'bootstrap.addSlide';
			$endPanel			= 'bootstrap.endSlide';
			$endPane			= 'bootstrap.endAccordion';
			$RegistrationTag1	= $RegistrationTitle;
			$RegistrationTag2	= $RegistrationTag;
			$DescTag1			= $DescTitle;
			$DescTag2			= $DescTag;
			$PublishingTag1		= $PublishingTitle;
			$PublishingTag2		= $PublishingTag;
		}
	}
	?>

	<?php // ERROR ALERT ?>
	<div id="form_errors" class="alert alert-danger" style="display:none">
		<strong><?php echo JText::_('JGLOBAL_VALIDATION_FORM_FAILED'); ?></strong>
		<div id="message_error">
		</div>
	</div>

	<form action="<?php echo JRoute::_('index.php?option=com_icagenda&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="registration-form" class="form-validate" enctype="multipart/form-data">
		<div class="container">

			<!-- iCagenda Header -->
			<header>
				<h1>
					<?php echo empty($this->item->id) ? JText::_('COM_ICAGENDA_LEGEND_NEW_REGISTRATION') : JText::sprintf('COM_ICAGENDA_LEGEND_EDIT_REGISTRATION', $this->item->id); ?>&nbsp;<span>iCagenda</span>
				</h1>
				<h2>
					<?php echo JText::_('COM_ICAGENDA_COMPONENT_DESC'); ?>
				</h2>
			</header>

			<div>&nbsp;</div>

			<!-- Begin Content -->
			<div class="row-fluid">
				<div class="span10 form-horizontal">

					<!-- Open Panel Set -->
					<?php echo JHtml::_($startPane, 'icTab', array('active' => 'Registration')); ?>

						<!-- Panel Event -->
						<?php echo JHtml::_($addPanel, $icPanRegistration, $RegistrationTag1, $RegistrationTag2); ?>

							<div class="icpanel iCleft">
								<h1>
									<?php echo empty($this->item->id) ? JText::_('COM_ICAGENDA_LEGEND_NEW_REGISTRATION') : JText::sprintf('COM_ICAGENDA_LEGEND_EDIT_REGISTRATION', $this->item->id); ?>
								</h1>
								<hr>
								<div class="row-fluid">
									<div class="span6 iCleft">
										<div class="control-group">
											<div class="control-label">
												<?php echo $this->form->getLabel('name'); ?>
											</div>
											<div class="controls">
												<?php echo $this->form->getInput('name'); ?>
											</div>
										</div>
										<div class="control-group">
											<div class="control-label">
												<?php echo $this->form->getLabel('email'); ?>
											</div>
											<div class="controls">
												<?php echo $this->form->getInput('email'); ?>
											</div>
										</div>
										<div class="control-group">
											<div class="control-label">
												<?php echo $this->form->getLabel('phone'); ?>
											</div>
											<div class="controls">
												<?php echo $this->form->getInput('phone'); ?>
											</div>
										</div>
										<h3><?php echo JText::_('COM_ICAGENDA_CUSTOMFIELDS'); ?></h3>
										<?php
										// Load Custom fields - Registration form (1)
										echo icagendaCustomfields::loader(1);
										?>
									</div>
									<div class="span6 iCleft">
										<div class="control-group">
											<div class="control-label">
												<?php echo $this->form->getLabel('eventid'); ?>
											</div>
											<div class="controls">
												<?php echo $this->form->getInput('eventid'); ?>
											</div>
										</div>
										<div class="control-group">
											<div class="control-label">
												<?php echo $this->form->getLabel('date'); ?>
											</div>
											<div class="controls">
												<?php echo $this->form->getInput('date'); ?>
											</div>
										</div>
										<?php //if ($this->item->period) : ?>
										<div class="control-group">
											<div class="control-label">
												<?php echo $this->form->getLabel('period'); ?>
											</div>
											<div class="controls">
												<?php echo $this->form->getInput('period'); ?>
											</div>
										</div>
										<?php //endif; ?>
										<div class="control-group">
											<div class="control-label">
												<?php echo $this->form->getLabel('people'); ?>
											</div>
											<div class="controls">
												<?php echo $this->form->getInput('people'); ?>
											</div>
										</div>
									</div>
								</div>
							</div>


						<?php
						if(version_compare(JVERSION, '3.0', 'ge')) {
							echo JHtml::_($endPanel);
						}
						?>


						<!-- Panel Description -->
						<?php echo JHtml::_($addPanel, $icPanDesc, $DescTag1, $DescTag2); ?>

							<div class="icpanel iCleft">
								<h1><?php echo JText::_('COM_ICAGENDA_REGISTRATION_NOTES_DISPLAY_LABEL'); ?></h1>
								<hr>
								<div class="row-fluid">
									<div class="span12 iCleft">
										<!--h3><?php echo JText::_('COM_ICAGENDA_FORM_DESC_REGISTRATION_DESC'); ?></h3-->
										<?php echo $this->form->getInput('notes'); ?>
									</div>
								</div>
							</div>


						<?php
						if(version_compare(JVERSION, '3.0', 'ge')) {
							echo JHtml::_($endPanel);
						}
						?>

						<?php
						echo JHtml::_($addPanel, $icPanPublishing, $PublishingTag1, $PublishingTag2);
						?>
							<div class="icpanel iCleft">
								<h1><?php echo JText::_('JGLOBAL_FIELDSET_PUBLISHING'); ?></h1>
								<hr>
								<div class="row-fluid">
									<div class="span6 iCleft">
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
												<?php echo $this->form->getLabel('userid'); ?>
											</div>
											<div class="controls">
												<?php echo $this->form->getInput('userid'); ?>
											</div>
										</div>
										<div class="control-group">
											<div class="control-label">
												<?php echo $this->form->getLabel('created'); ?>
											</div>
											<div class="controls">
												<?php echo $this->form->getInput('created'); ?>
											</div>
										</div>
										<div class="control-group">
											<div class="control-label">
												<?php echo $this->form->getLabel('created_by'); ?>
											</div>
											<div class="controls">
												<?php echo $this->form->getInput('created_by'); ?>
											</div>
										</div>
										<div class="control-group">
											<div class="control-label">
												<?php echo $this->form->getLabel('modified'); ?>
											</div>
											<div class="controls">
												<?php echo $this->form->getInput('modified'); ?>
											</div>
										</div>
										<div class="control-group">
											<div class="control-label">
												<?php echo $this->form->getLabel('modified_by'); ?>
											</div>
											<div class="controls">
												<?php echo $this->form->getInput('modified_by'); ?>
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

						<?php echo JHtml::_($endPanel); ?>

					<?php echo JHtml::_($endPane, 'icTab'); ?>
				</div>

				<!-- Begin Sidebar -->
				<div class="span2 iCleft">
					<h4><?php echo JText::_('COM_ICAGENDA_TITLE_SIDEBAR_DETAILS'); ?></h4>
					<hr>
					<div class="control-group">
						<div class="control-label">
							<?php echo $this->form->getLabel('state'); ?>
						</div>
						<div class="controls">
							<?php echo $this->form->getInput('state'); ?>
						</div>
					</div>
				</div>
				<!-- End Sidebar -->

			</div>
			<div class="clr"></div>
		</div>

		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</form>

	<?php
	// Script validation for Registration form (1)
	$iCheckForm = icagendaForm::submit(1);
	$document->addScriptDeclaration($iCheckForm);

	// Joomla 2.5
	if (version_compare(JVERSION, '3.0', 'lt'))
	{
		JHtml::stylesheet('com_icagenda/template.j25.css', false, true);
		JHtml::stylesheet('com_icagenda/icagenda-back.j25.css', false, true);

		// load jQuery, if not loaded before (NEW VERSION IN 1.2.6)
		$scripts = array_keys($document->_scripts);
		$scriptFound = false;
		$scriptuiFound = false;
		$mapsgooglescriptFound = false;
		for ($i = 0; $i < count($scripts); $i++)
		{
			if (stripos($scripts[$i], 'jquery.min.js') !== false)
			{
				$scriptFound = true;
			}
			// load jQuery, if not loaded before as jquery - added in 1.2.7
			if (stripos($scripts[$i], 'jquery.js') !== false)
			{
				$scriptFound = true;
			}
			if (stripos($scripts[$i], 'jquery-ui.min.js') !== false)
			{
				$scriptuiFound = true;
			}
			if (stripos($scripts[$i], 'maps.google') !== false)
			{
				$mapsgooglescriptFound = true;
			}
		}

		// jQuery Library Loader
		if (!$scriptFound)
		{
			// load jQuery, if not loaded before
			if (!JFactory::getApplication()->get('jquery'))
			{
				JFactory::getApplication()->set('jquery', true);
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
}
else
{
	$app->enqueueMessage(JText::_('JERROR_ALERTNOAUTHOR'), 'warning');
	$app->redirect(htmlspecialchars_decode('index.php?option=com_icagenda&view=icagenda'));
}
