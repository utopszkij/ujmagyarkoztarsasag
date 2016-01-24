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
 * @version     3.5.9 2015-07-30
 * @since       1.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

JHtml::_('behavior.tooltip');
JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');

if (version_compare(JVERSION, '3.0', 'ge'))
{
	JHtml::_('formbehavior.chosen', 'select');
}

$app = JFactory::getApplication();

//$session		= JFactory::getSession();
//$ic_newsletter	= $session->get('ic_newsletter', array());

$script = "\t" . 'Joomla.submitbutton = function(pressbutton) {' . "\n";
$script .= "\t\t" . 'var form = document.adminForm;' . "\n";
$script .= "\t\t" . 'if (pressbutton == \'mail.cancel\') {' . "\n";
$script .= "\t\t\t" . 'Joomla.submitform(pressbutton);' . "\n";
$script .= "\t\t\t" . 'return;' . "\n";
$script .= "\t\t" . '}' . "\n";
$script .= "\t\t" . '// do field validation' . "\n";
$script .= "\t\t" . 'if (form.jform_subject.value == ""){' . "\n";
$script .= "\t\t\t" . 'alert("' . JText::_('COM_ICAGENDA_NEWSLETTER_NO_OBJ_ALERT', true) . '");' . "\n";
$script .= "\t\t" . '} else if (getSelectedValue(\'adminForm\',\'jform[eventid]\') == ""){' . "\n";
$script .= "\t\t\t" . 'alert("' . JText::_('COM_ICAGENDA_NEWSLETTER_NO_EVENT_SELECTED', true) . '");' . "\n";
$script .= "\t\t" . '} else if (getSelectedValue(\'adminForm\',\'jform[date]\') == ""){' . "\n";
$script .= "\t\t\t" . 'alert("' . JText::_('COM_ICAGENDA_NEWSLETTER_NO_DATE_SELECTED', true) . '");' . "\n";
//$script .= "\t\t" . '} else if (form.jform_message.value == ""){' . "\n";
//$script .= "\t\t\t" . 'alert("' . JText::_('COM_ICAGENDA_NEWSLETTER_NO_BODY_ALERT', true) . '");' . "\n";
$script .= "\t\t" . '} else {' . "\n";
$script .= "\t\t\t" . 'Joomla.submitform(pressbutton);' . "\n";
$script .= "\t\t" . '}' . "\n";
$script .= "\t\t" . '}' . "\n";

//JFactory::getDocument()->addScriptDeclaration($script);

// Access Administration Newsletter check.
if (JFactory::getUser()->authorise('icagenda.access.newsletter', 'com_icagenda'))
{
	?>
	<!--script type="text/javascript">
		Joomla.submitbutton = function(task)
		{
			if (task == 'event.cancel' || document.formvalidator.isValid(document.id('event-form'))) {
				Joomla.submitform(task, document.getElementById('event-form'));
			}
			else {
				alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
			}
		}
	</script-->

	<form action="<?php echo JRoute::_('index.php?option=com_icagenda&view=mail&layout=edit') ?>" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">
		<div class="container">
			<!-- iCagenda Header -->
			<header>
				<h1>
					<?php echo JText::_('COM_ICAGENDA_TITLE_MAIL'); ?>&nbsp;<span>iCagenda</span>
				</h1>
				<h2>
					<?php echo JText::_('COM_ICAGENDA_COMPONENT_DESC'); ?>
					<!--nav class="iCheader-videos">
						<span style="font-variant:small-caps">Tutorial Videos</span>
						<a href="#">Video</a>
					</nav-->
				</h2>
			</header>

			<div>&nbsp;</div>

			<!-- Begin Content -->
			<h4><?php echo JText::_('COM_ICAGENDA_FORM_LBL_NEWSLETTER_LIST'); ?></h4>
			<div class="row-fluid">
				<div class="span12">
					<div class="span4 iCleft">
						<div class="control-group">
							<?php echo $this->form->getLabel('eventid'); ?>
							<div class="controls">
								<?php echo $this->form->getInput('eventid'); ?>
							</div>
						</div>
					</div>
					<div class="span4 iCleft">
						<div class="control-group">
							<?php echo $this->form->getLabel('date'); ?>
							<div class="controls">
								<?php echo $this->form->getInput('date'); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<hr>
			<h4><?php echo JText::_('COM_ICAGENDA_TITLE_NEWSLETTER'); ?></h4>
			<div class="row-fluid">
				<div class="span12">
					<div class="control-group">
						<?php echo $this->form->getLabel('subject'); ?>
						<div class="controls">
							<?php echo $this->form->getInput('subject'); ?>
						</div>
					</div>
					<div class="control-group">
						<?php echo $this->form->getLabel('message'); ?>
						<div class="controls">
							<?php echo $this->form->getInput('message'); ?>
						</div>
					</div>
				</div>
			</div>
			<input type="hidden" name="option" value="com_icagenda" />
			<input type="hidden" name="task" value="" />
			<?php echo JHtml::_('form.token'); ?>
		</div>
		<div class="clr"></div>
	</form>
	<?php
}
else
{
	$app->enqueueMessage(JText::_('JERROR_ALERTNOAUTHOR'), 'warning');
	$app->redirect(htmlspecialchars_decode('index.php?option=com_icagenda&view=icagenda'));
}
