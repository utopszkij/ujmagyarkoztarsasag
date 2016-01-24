<?php
/**
 * @version	 $Id: default.php 127 2012-10-16 14:19:02Z michel $
 * @package		Joomla.Administrator
 * @subpackage	com_ammvc
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');

$user	= &JFactory::getUser();
$userId	= $user->get('id');
$extension	= $this->escape($this->state->get('filter.extension'));
?>
<form action="<?php echo JRoute::_('index.php?option=com_ammvc&view=categories&extension='.$extension);?>" method="post" id="adminForm" name="adminForm">

	<div id="filter-bar" class="btn-toolbar">
		<div class="filter-searchh btn-group pull-left fltlft">
			<label class="filter-search-lbl element-invisible" for="filter_search"><?php echo JText::_('JSearch_Filter_Label'); ?></label>
			<input class="inputbox" type="text" name="filter_search" id="filter_search" value="<?php echo $this->state->get('filter.search'); ?>" title="<?php echo JText::_('Search'); ?>" />
		</div>			
		<div class="btn-group fltlft">
				<button type="submit"><?php echo JText::_('Go'); ?></button>
				<button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('Reset'); ?></button>
		</div>
		<div class="filter-select fltrt  pull-right"">
			<select name="extension" class="inputbox" onchange="this.form.submit()">
				<?php echo JHtml::_('ammvc.extensions', $extension);?>
			</select>
			<select name="filter_published" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOption_Select_Published');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.published'), true);?>
			</select>
		</div>
		<div class="clr clearfix"> </div>
	</div>
	<div class="clr clearfix"> </div>
	
	<table class="adminlist table table-striped" id="categoryList">
		<thead>
			<tr>
				<th width="20">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items) ?>)" />
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'Title', 'a.title', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'Published', 'a.published', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
				</th>
				<th width="5%" class="nowrap">
					<?php echo JText::_('Ordering'); ?>
				</th>
				<th width="1%" class="nowrap">
					<?php echo JHtml::_('grid.sort', 'JGrid_Heading_ID', 'a.lft', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="15">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php
			foreach ($this->items as $i => $item) :
				
			    $ordering = ($this->state->get('list.ordering') == 'a.lft');
		
				?>
				<tr class="row<?php echo $i % 2; ?>">
					<td class="center">
						<?php echo JHtml::_('grid.id', $i, $item->id); ?>
					</td>
					<td class="indent-<?php echo intval(($item->level-1)*15)+4; ?>">
						<?php if ($item->checked_out) : ?>
							<?php echo JHtml::_('jgrid.checkedout', $item->editor, $item->checked_out_time); ?>
						<?php endif; ?>
						<?php if($item->level) : echo str_repeat('<span class="gi">&mdash;</span>', $item->level - 1); endif; ?>
						<a href="<?php echo JRoute::_('index.php?option=com_ammvc&task=category.edit&cid[]='.$item->id.'&extension='.$extension);?>">
							<?php echo $this->escape($item->title); ?></a>
						<span class="smallsub" title="<?php echo $this->escape($item->path);?>">
							(<span><?php echo JText::_('JFIELD_ALIAS_LABEL'); ?>:</span> <?php echo $this->escape($item->alias);?>)</span>
					</td>
					<td class="center">
						<?php echo JHtml::_('jgrid.published', $item->published, $i, '');?>
					</td>
					<td class="order">
						<span><?php echo $this->pagination->orderUpIcon($i, $item->order_up, 'orderup', 'JGrid_Move_Up', $ordering); ?></span>
						<span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, $item->order_dn, 'orderdown', 'JGrid_Move_Down', $ordering); ?></span>
					</td>
					<td class="center">
						<span title="<?php echo sprintf('%d-%d', $item->lft, $item->rgt);?>">
							<?php echo (int) $item->id; ?></span>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<input type="hidden" name="option" value="com_ammvc" />
	<input type="hidden" name="view" value="categories" />
	<input type="hidden" name="task" value="category" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->state->get('list.ordering'); ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->state->get('list.direction'); ?>" />
	<?php echo JHtml::_('form.token'); ?>
</form>
