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
 * @version     3.5.6 2015-05-06
 * @since		3.4.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

$app = JFactory::getApplication();
$document = JFactory::getDocument();

// Access Administration Categories check.
if (JFactory::getUser()->authorise('icagenda.access.customfields', 'com_icagenda'))
{
	$bootstrapType		= '1';
	$PanelOne_Tag		= 'customfield';
	$PanelOne_Title		= JText::_('COM_ICAGENDA_CUSTOMFIELD_PANEL_TITLE', true);
	$PanelTwo_Tag		= 'desc';
	$PanelTwo_Title		= JText::_('COM_ICAGENDA_LEGEND_DESC', true);
	$PublishingTag		= 'publishing';
	$PublishingTitle	= JText::_('JGLOBAL_FIELDSET_PUBLISHING', true);

	// Joomla 2.5
	if (version_compare(JVERSION, '3.0', 'lt'))
	{
		jimport( 'joomla.html.html.tabs' );

		$iCmapDisplay		= '3';

		$icPanFirst			= JText::_('COM_ICAGENDA_CUSTOMFIELD_PANEL_TITLE');
		$icPanDesc			= JText::_('COM_ICAGENDA_LEGEND_DESC');
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

		$icPanFirst			= 'icTab';
		$icPanDesc			= 'icTab';
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
		elseif ($bootstrapType == '2')
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
		if (task == 'customfield.cancel' || document.formvalidator.isValid(document.id('customfield-form'))) {
			Joomla.submitform(task, document.getElementById('customfield-form'));
		}
		else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_icagenda&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="customfield-form" class="form-validate">

	<div class="container">

		<!-- iCheader top bar -->
		<!--div class="iCheader-top">
			<a href="#">
				<strong>&laquo; Previous </strong>event
			</a>
			<span class="right">
				<a href="#">
					<strong>Next</strong> event <strong>&raquo;</strong>
				</a>
			</span>
			<div class="clr"></div>
		</div-->
		<!--/ iCheader top bar -->


		<!-- iCagenda Header -->
		<header>
			<h1>
				<?php echo empty($this->item->id) ? JText::_('COM_ICAGENDA_CUSTOMFIELD_LEGEND_NEW') : JText::sprintf('COM_ICAGENDA_CUSTOMFIELD_LEGEND_EDIT', $this->item->id); ?>&nbsp;<span>iCagenda</span>
			</h1>
			<h2>
				<?php echo JText::_('COM_ICAGENDA_COMPONENT_DESC'); ?>
				<!--nav class="iCheader-videos">
					<span style="font-variant:small-caps">Tutorial Videos</span>
					<a href="#">Add a event</a>
					<a href="#">Video 2</a>
					<a href="#">Video 3</a>
				</nav-->
			</h2>
		</header>

		<div>&nbsp;</div>



		<!-- Begin Content -->
		<div class="row-fluid">
			<div class="span10 form-horizontal">

				<!-- Open Panel Set -->
				<?php echo JHtml::_($startPane, 'icTab', array('active' => 'customfield')); ?>

					<!-- Panel Event -->
					<?php echo JHtml::_($addPanel, $icPanFirst, $PanelOne_Tag1, $PanelOne_Tag2); ?>

						<div class="icpanel iCleft">
							<h1><?php echo empty($this->item->id) ? JText::_('COM_ICAGENDA_CUSTOMFIELD_LEGEND_NEW') : JText::sprintf('COM_ICAGENDA_CUSTOMFIELD_LEGEND_EDIT', $this->item->id); ?></h1>
							<hr>
							<div class="row-fluid">
								<div class="span6 iCleft">
									<div class="control-group">
										<div class="control-label">
											<?php echo $this->form->getLabel('title'); ?>
										</div>
										<div class="controls">
											<?php echo $this->form->getInput('title'); ?>
										</div>
									</div>
									<div class="control-group">
										<div class="control-label">
											<?php echo $this->form->getLabel('slug'); ?>
										</div>
										<div class="controls">
											<?php echo $this->form->getInput('slug'); ?>
										</div>
									</div>
									<div class="control-group">
										<div class="control-label">
											<?php echo $this->form->getLabel('parent_form'); ?>
										</div>
										<div class="controls">
											<?php echo $this->form->getInput('parent_form'); ?>
										</div>
									</div>
								</div>
								<div class="span6 iCleft">
									<div class="control-group">
										<div class="control-label">
											<?php echo $this->form->getLabel('type'); ?>
										</div>
										<div class="controls">
											<?php echo $this->form->getInput('type'); ?>
										</div>
									</div>
									<div class="control-group">
										<div class="control-label">
											<?php echo $this->form->getLabel('options'); ?>
										</div>
										<div class="controls">
											<?php echo $this->form->getInput('options'); ?>
										</div>
									</div>
									<div class="control-group">
										<div class="control-label">
											<?php echo $this->form->getLabel('required'); ?>
										</div>
										<div class="controls">
											<?php echo $this->form->getInput('required'); ?>
										</div>
									</div>
								</div>
							</div>
							<hr>
						</div>


					<?php
					if(version_compare(JVERSION, '3.0', 'ge')) {
						echo JHtml::_($endPanel);
					}
					?>


					<!-- Panel Description -->
					<?php echo JHtml::_($addPanel, $icPanDesc, $PanelTwo_Tag1, $PanelTwo_Tag2); ?>

						<div class="icpanel iCleft">
							<h1><?php echo JText::_('COM_ICAGENDA_LEGEND_DESC'); ?></h1>
							<hr>
							<div class="row-fluid">
								<div class="span12 iCleft">
									<h3><?php echo JText::_('COM_ICAGENDA_CUSTOMFIELD_DESCRIPTION_DESC'); ?></h3>
									<?php echo $this->form->getInput('description'); ?>
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
									<?php echo $this->form->getLabel('alias'); ?>
								</div>
								<div class="controls">
									<?php echo $this->form->getInput('alias'); ?>
								</div>
							</div>
							<div class="control-group">
								<?php echo $this->form->getLabel('created'); ?>
								<div class="controls">
									<?php echo $this->form->getInput('created'); ?>
								</div>
							</div>
							<div class="control-group">
								<?php echo $this->form->getLabel('created_by'); ?>
								<div class="controls">
									<?php echo $this->form->getInput('created_by'); ?>
								</div>
							</div>
							<div class="control-group">
								<?php echo $this->form->getLabel('created_by_alias'); ?>
								<div class="controls">
									<?php echo $this->form->getInput('created_by_alias'); ?>
								</div>
							</div>
							<div class="control-group">
								<?php echo $this->form->getLabel('modified'); ?>
								<div class="controls">
									<?php echo $this->form->getInput('modified'); ?>
								</div>
							</div>
							<div class="control-group">
								<?php echo $this->form->getLabel('modified_by'); ?>
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
							<!--div class="control-group">
								<?php echo $this->form->getLabel('access'); ?>
								<div class="controls">
									<?php echo $this->form->getInput('access'); ?>
								</div>
							</div-->
							<!--div class="control-group">
								<?php echo $this->form->getLabel('language'); ?>
								<div class="controls">
									<?php echo $this->form->getInput('language'); ?>
								</div>
							</div-->
							<input type="hidden" name="language" value="*" />
			</div>
		<!-- End Sidebar -->
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
