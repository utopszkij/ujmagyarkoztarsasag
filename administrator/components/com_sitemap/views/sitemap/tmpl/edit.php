<?php

/**
* Qlue Sitemap
*
* @author Jon Boutell
* @package QMap
* @license GNU/GPL
* @version 1.0
*
* This component gathers information from various Joomla Components and 
* compiles them into a sitemap, supporting both an HTML view and an XML 
* format for search engines.
*
*/

defined('_JEXEC') or die('Restricted Access');

require_once JPATH_ROOT . DS . 'components' . DS . 'com_content' . DS . 'helpers' . DS . 'route.php';

JHtml::_('behavior.tooltip');

?>

<div>
	<form action="<?php echo JRoute::_('index.php'); ?>" method="post" name="adminForm">
		<div class="width-60 fltlft">
			<fieldset class="adminform">
				<legend><?php echo JText::_(COM_SITEMAP_TITLE_EDIT); ?></legend>

				<ul class="adminformlist">
					<li>
						<?php echo $this->form->getLabel('id'); ?>
						<?php echo $this->form->getInput('id'); ?>
					</li>
					<li>
						<?php echo $this->form->getLabel('title'); ?>
						<?php echo $this->form->getInput('title'); ?>
					</li>
					<li>
						<?php echo $this->form->getLabel('alias'); ?>
						<?php echo $this->form->getInput('alias'); ?>
					</li>
					<li>
						<?php echo $this->form->getLabel('published'); ?>
						<?php echo $this->form->getInput('published'); ?>
					</li>
				</ul>
			</fieldset>
		</div>
		
		<div class="width-40 fltrt">
			<fieldset class="adminform">
				<legend><?php echo JText::_(COM_SITEMAP_TITLE_LINKS); ?></legend>
					<?php if (!empty($this->item->event->onNewSitemap)): ?>

						<?php foreach ($this->item->event->onNewSitemap as $item): ?>

							<?php foreach ($item as $key => $value): ?>

								<?php echo $value->link; ?>
								<br />

							<?php endforeach; ?>

							<br />

						<?php endforeach; ?>

					<?php else: ?>

						<p><?php echo JText::_(COM_SITEMAP_DESC_LINKS); ?></p>

					<?php endif; ?>
					
			</fieldset>
		</div>

		<input type="hidden" name="option" value="com_sitemap" />
		<input type="hidden" name="view" value="sitemap" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="id" value="<?php echo (int)$this->item->id; ?>" />
		<?php echo JHtml::_('form.token'); ?>

	</form>
</div>