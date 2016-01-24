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

JHtml::_('behavior.framework');

?>



	<div>
		<form name="adminForm" id="adminForm" method="post" action="<?php echo JRoute::_('index.php?option=com_sitemap'); ?>">
			<table class="adminlist">
				<thead>
					<tr>
						<th width="1%">
							<input type="checkbox" name="checkall-toggle" value="" onclick="Joomla.checkAll(this)" />
						</th>
						<th width="2%">
							<?php echo JHtml::_('grid.sort', JText::_(COM_SITEMAP_LABEL_ID), 'id', $this->sortDirection, $this->sortColumn); ?>
						</th>

						<th class="title" width="30%">
							<?php echo JHtml::_('grid.sort', JText::_(COM_SITEMAP_LABEL_TITLE), 'title', $this->sortDirection, $this->sortColumn); ?>
						</th>

						<th width="30%">
							<?php echo JHtml::_('grid.sort', JText::_(COM_SITEMAP_LABEL_ALIAS), 'alias', $this->sortDirection, $this->sortColumn); ?>
						</th>

						<th width="2%">
							<?php echo JHtml::_('grid.sort', JText::_(COM_SITEMAP_LABEL_STATUS), 'published', $this->sortDirection, $this->sortColumn); ?>
						</th>
					</tr>
				</thead>

				<tbody>
					<?php $actions = SitemapHelper::getActions(); ?>
					<?php foreach ($this->items as $key => $item): ?>
						<tr class="row<?php echo ($key%2); ?>">
							<td>
								<?php echo JHtml::_('grid.checkedOut', $item, $key); ?>
							</td>
							<td>
								<?php echo $this->escape((INT)$item->id); ?>
							</td>

							<td>
								<?php if (!$item->checked_out || $item->checked_out == $item->user->get('id')): ?>
									<a href="<?php echo JRoute::_('index.php?option=com_sitemap&task=sitemap.edit&id=' . (int) $item->id); ?>" >
										<?php echo $this->escape($item->title); ?>
									</a>
								<?php else: ?>
									<?php echo $this->escape($item->title); ?>
								<?php endif; ?>	
							</td>

							<td>
								<?php echo $this->escape($item->alias); ?>
							</td>

							<td>
								<?php echo JHtml::_('jgrid.published', $item->published, $key, 'sitemaps.', $actions->get('core.edit.state')); ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
				<input type="hidden" name="task" value="" />
				<input type="hidden" name="view" value="sitemaps" />
				<input type="hidden" name="boxchecked" value="0" />
				<input type="hidden" name="option" value="com_sitemap" />
				<input type="hidden" name="filter_order" value="<?php echo $this->sortColumn; ?>" />
				<input type="hidden" name="filter_order_Dir" value="<?php echo $this->sortDirection; ?>" />
				<?php echo JHtml::_('form.token'); ?>
		</form>
	</div>

