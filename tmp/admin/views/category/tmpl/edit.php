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
 * @since       1.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

$app = JFactory::getApplication();

// Access Administration Categories check.
if (JFactory::getUser()->authorise('icagenda.access.categories', 'com_icagenda'))
{
	$document			= JFactory::getDocument();
	$bootstrapType		= '1';
	$CategoryTag		='category';
	$CategoryTitle		= JText::_('COM_ICAGENDA_TITLE_CATEGORY', true);
	$DescTag			= 'desc';
	$DescTitle			= JText::_('COM_ICAGENDA_LEGEND_DESC', true);
	$PublishingTag		= 'publishing';
	$PublishingTitle	= JText::_('JGLOBAL_FIELDSET_PUBLISHING', true);

	// Joomla 2.5
	if (version_compare(JVERSION, '3.0', 'lt'))
	{
		jimport('joomla.html.html.tabs');

		$iCmapDisplay		= '3';

		$icPanCategory		= JText::_('COM_ICAGENDA_TITLE_CATEGORY');
		$icPanDesc			= JText::_('COM_ICAGENDA_LEGEND_DESC');
		$icPanPublishing	= JText::_('JGLOBAL_FIELDSET_PUBLISHING');
		$startPane			= 'tabs.start';
		$addPanel			= 'tabs.panel';
		$endPanel			= 'tabs.end';
		$endPane			= 'tabs.end';
		$CategoryTag1		= $CategoryTag;
		$CategoryTag2		= $CategoryTitle;
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

		$icPanCategory		= 'icTab';
		$icPanDesc			= 'icTab';
		$icPanPublishing	= 'icTab';

		if ($bootstrapType == '1')
		{
			$iCmapDisplay	= '1';
			$startPane		= 'bootstrap.startTabSet';
			$addPanel		= 'bootstrap.addTab';
			$endPanel		= 'bootstrap.endTab';
			$endPane		= 'bootstrap.endTabSet';
			$CategoryTag1	= $CategoryTag;
			$CategoryTag2	= $CategoryTitle;
			$DescTag1		= $DescTag;
			$DescTag2		= $DescTitle;
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
			$CategoryTag1	= $CategoryTitle;
			$CategoryTag2	= $CategoryTag;
			$DescTag1		= $DescTitle;
			$DescTag2		= $DescTag;
			$PublishingTag1	= $PublishingTitle;
			$PublishingTag2	= $PublishingTag;
		}
	}
	?>

	<script type="text/javascript">
		Joomla.submitbutton = function(task)
		{
			if (task == 'category.cancel' || document.formvalidator.isValid(document.id('category-form'))) {
				Joomla.submitform(task, document.getElementById('category-form'));
			}
			else {
				alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
			}
		}
	</script>

<form action="<?php echo JRoute::_('index.php?option=com_icagenda&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="category-form" class="form-validate">
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
				<?php echo empty($this->item->id) ? JText::_('COM_ICAGENDA_LEGEND_NEW_CATEGORY') : JText::sprintf('COM_ICAGENDA_LEGEND_EDIT_CATEGORY', $this->item->id); ?>&nbsp;<span>iCagenda</span>
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
				<?php echo JHtml::_($startPane, 'icTab', array('active' => 'category')); ?>

					<!-- Panel Event -->
					<?php echo JHtml::_($addPanel, $icPanCategory, $CategoryTag1, $CategoryTag2); ?>

						<div class="icpanel iCleft">
							<h1><?php echo empty($this->item->id) ? JText::_('COM_ICAGENDA_LEGEND_NEW_CATEGORY') : JText::sprintf('COM_ICAGENDA_LEGEND_EDIT_CATEGORY', $this->item->id); ?></h1>
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
								</div>
								<div class="span6 iCleft">
									<div class="control-group">
										<div class="control-label">
											<?php echo $this->form->getLabel('color'); ?>
										</div>
										<div class="controls">
											<?php echo $this->form->getInput('color'); ?>
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
							<h1><?php echo JText::_('COM_ICAGENDA_LEGEND_DESC'); ?></h1>
							<hr>
							<div class="row-fluid">
								<div class="span12 iCleft">
									<h3><?php echo JText::_('COM_ICAGENDA_FORM_DESC_CATEGORY_DESC'); ?></h3>
									<?php echo $this->form->getInput('desc'); ?>
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
							<!--div class="control-group">
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
								<?php echo $this->form->getLabel('created'); ?>
								<div class="controls">
									<?php echo $this->form->getInput('created'); ?>
								</div>
							</div-->
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
							</div>
							<div class="control-group">
								<?php echo $this->form->getLabel('language'); ?>
								<div class="controls">
									<?php echo $this->form->getInput('language'); ?>
								</div>
							</div-->
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
	}
}
else
{
	$app->enqueueMessage(JText::_('JERROR_ALERTNOAUTHOR'), 'warning');
	$app->redirect(htmlspecialchars_decode('index.php?option=com_icagenda&view=icagenda'));
}
