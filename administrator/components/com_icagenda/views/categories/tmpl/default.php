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
 * @version     3.3.3 2014-04-12
 * @since       1.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

$app = JFactory::getApplication();

// Access Administration Categories check.
if (JFactory::getUser()->authorise('icagenda.access.categories', 'com_icagenda'))
{
	$user		= JFactory::getUser();
	$userId		= $user->get('id');
	$listOrder	= $this->escape($this->state->get('list.ordering'));
	$listDirn	= $this->escape($this->state->get('list.direction'));
	$canOrder	= $user->authorise('core.edit.state', 'com_icagenda');

	$saveOrder	= $listOrder == 'a.ordering';

	if (version_compare(JVERSION, '3.0', 'lt'))
	{
		JHtml::_('behavior.tooltip');
		JHtml::_('script','system/multiselect.js',false,true);
	}
	else
	{
		// Include the component HTML helpers.
		JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
		JHtml::_('bootstrap.tooltip');
		JHtml::_('behavior.multiselect');
		JHtml::_('formbehavior.chosen', 'select');
		JHtml::_('dropdown.init');

		$extension	= $this->escape($this->state->get('filter.extension'));

		$archived	= $this->state->get('filter.published') == 2 ? true : false;
		$trashed	= $this->state->get('filter.published') == -2 ? true : false;

		if ($saveOrder)
		{
			$saveOrderingUrl = 'index.php?option=com_icagenda&task=categories.saveOrderAjax&tmpl=component';
			JHtml::_('sortablelist.sortable', 'categoriesList', 'adminForm', strtolower($listDirn), $saveOrderingUrl, false, true);
		}
		//$sortFields = $this->getSortFields();
		$sortFields = array(); // Alchemy - tmp bug fix
		?>
		<script type="text/javascript">
			Joomla.orderTable = function()
			{
				table = document.getElementById("sortTable");
				direction = document.getElementById("directionTable");
				order = table.options[table.selectedIndex].value;
				if (order != '<?php echo $listOrder; ?>')
				{
					dirn = 'asc';
				}
				else
				{
					dirn = direction.options[direction.selectedIndex].value;
				}
				Joomla.tableOrdering(order, dirn, '');
			}
		</script>
		<?php
	}
	?>

	<form action="<?php echo JRoute::_('index.php?option=com_icagenda&view=categories'); ?>" method="post" name="adminForm" id="adminForm">
	<?php if (!empty( $this->sidebar)) : ?>
		<div id="j-sidebar-container" class="span2">
			<?php echo $this->sidebar; ?>
		</div>
		<div id="j-main-container" class="span10">
	<?php else : ?>
		<div id="j-main-container">
	<?php endif;?>

		<?php if(version_compare(JVERSION, '3.0', 'lt')) : ?>
			<fieldset id="filter-bar">
				<div class="filter-search fltlft">
					<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
					<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('Search'); ?>" />
					<button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
					<button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
				</div>
				<div class="filter-select fltrt">
					<select name="filter_published" class="inputbox" onchange="this.form.submit()">
						<option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
						<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), "value", "text", $this->state->get('filter.state'), true);?>
					</select>
				</div>
			</fieldset>
			<div class="clr"> </div>

		<?php else : ?>

			<div id="filter-bar" class="btn-toolbar">
				<div class="filter-search btn-group pull-left">
					<label for="filter_search" class="element-invisible"><?php echo JText::_('COM_ICAGENDA_FILTER_SEARCH_CATEGORIES_DESC'); ?></label>
					<input type="text" name="filter_search" placeholder="<?php echo JText::_('COM_ICAGENDA_FILTER_SEARCH_CATEGORIES_DESC'); ?>" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_ICAGENDA_FILTER_SEARCH_CATEGORIES_DESC'); ?>" />
				</div>
				<div class="btn-group pull-left">
					<button class="btn tip hasTooltip" type="submit" title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i></button>
					<button class="btn tip hasTooltip" type="button" onclick="document.id('filter_search').value='';this.form.submit();" title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>"><i class="icon-remove"></i></button>
				</div>
				<div class="btn-group pull-right hidden-phone">
					<label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC'); ?></label>
					<?php echo $this->pagination->getLimitBox(); ?>
				</div>
				<!--div class="btn-group pull-right hidden-phone">
					<label for="directionTable" class="element-invisible"><?php echo JText::_('JFIELD_ORDERING_DESC'); ?></label>
					<select name="directionTable" id="directionTable" class="input-medium" onchange="Joomla.orderTable()">
						<option value=""><?php echo JText::_('JFIELD_ORDERING_DESC'); ?></option>
						<option value="asc" <?php if ($listDirn == 'asc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_ASCENDING'); ?></option>
						<option value="desc" <?php if ($listDirn == 'desc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_DESCENDING');  ?></option>
					</select>
				</div-->
				<!--div class="btn-group pull-right">
					<label for="sortTable" class="element-invisible"><?php echo JText::_('JGLOBAL_SORT_BY'); ?></label>
					<select name="sortTable" id="sortTable" class="input-medium" onchange="Joomla.orderTable()">
						<option value=""><?php echo JText::_('JGLOBAL_SORT_BY');?></option>
						<?php echo JHtml::_('select.options', $sortFields, 'value', 'text', $listOrder); ?>
					</select>
				</div-->
			</div>
			<div class="clearfix"> </div>

		<?php endif;?>


		<?php if(version_compare(JVERSION, '3.0', 'lt')) : ?>
			<table class="adminlist">
		<?php else : ?>
			<table class="table table-striped" id="categoriesList">
		<?php endif; ?>

				<thead>
					<tr>
	<!-- Ordering HEADER Joomla 3.x (Test) -->
						<?php if(version_compare(JVERSION, '3.0', 'ge')) : ?>
 						<th width="1%" class="nowrap center hidden-phone">
							<?php echo JHtml::_('grid.sort', '<i class="icon-menu-2"></i>', 'a.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING'); ?>
						</th>
						<?php endif; ?>

	<!-- CheckBox HEADER -->
						<th width="1%" class="hidden-phone">
							<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
						</th>

	<!-- Status HEADER -->
						<th width="1%" style="min-width:55px" class="nowrap center">
							<?php echo JHtml::_('grid.sort', 'JSTATUS', 'a.state', $listDirn, $listOrder); ?>
						</th>

	<!-- Color HEADER -->
						<th width="5%" class="nowrap hidden-phone">
							<?php echo JHtml::_('grid.sort',  'COM_ICAGENDA_CATEGORIES_COLOR', 'a.color', $listDirn, $listOrder); ?>
						</th>

	<!-- Title HEADER -->
						<th>
							<?php echo JHtml::_('grid.sort',  'COM_ICAGENDA_CATEGORIES_TITLE', 'a.title', $listDirn, $listOrder); ?>
						</th>


	<!-- Ordering HEADER Joomla 2.5 -->
					<?php if(version_compare(JVERSION, '3.0', 'lt')) : ?>
						<?php if (isset($this->items[0]->ordering)) { ?>
						<th width="10%">
							<?php echo JHtml::_('grid.sort',  'JGRID_HEADING_ORDERING', 'a.ordering', $listDirn, $listOrder); ?>
							<?php if ($canOrder && $saveOrder) :?>
								<?php echo JHtml::_('grid.order',  $this->items, 'filesave.png', 'categories.saveorder'); ?>
							<?php endif; ?>
						</th>
	                	<?php } ?>
					<?php endif; ?>

	<!-- ID HEADER -->
						<th width="1%" class="nowrap hidden-phone">
							<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
						</th>


				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="10">
						<?php echo $this->pagination->getListFooter(); ?>
					</td>
				</tr>
			</tfoot>
			<tbody>
			<?php foreach ($this->items as $i => $item) :
				$ordering	= ($listOrder == 'a.ordering');
				$canCreate	= $user->authorise('core.create',		'com_icagenda');
				$canEdit	= $user->authorise('core.edit',			'com_icagenda');
				$canCheckin	= $user->authorise('core.manage',		'com_icagenda');
				$canChange	= $user->authorise('core.edit.state',	'com_icagenda');
//				$canEditOwn	= $user->authorise('core.edit.own',		'com_icagenda') && $item->created_by == $userId;
				$canEditOwn	= $user->authorise('core.edit.own',		'com_icagenda');
				?>
				<?php
	/* (Not in used currently)
				$originalOrders = array();
				foreach ($this->items as $i => $item) :
					$orderkey   = array_search($item->id, $this->ordering[$item->parent_id]);
					$canEdit    = $user->authorise('core.edit',       $extension . '.category.' . $item->id);
					$canCheckin = $user->authorise('core.admin',      'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
					$canEditOwn = $user->authorise('core.edit.own',   $extension . '.category.' . $item->id) && $item->created_user_id == $userId;
					$canChange  = $user->authorise('core.edit.state', $extension . '.category.' . $item->id) && $canCheckin;

					// Get the parents of item for sorting
					if ($item->level > 1)
					{
						$parentsStr = "";
						$_currentParentId = $item->parent_id;
						$parentsStr = " " . $_currentParentId;
						for ($i2 = 0; $i2 < $item->level; $i2++)
						{
							foreach ($this->ordering as $k => $v)
							{
								$v = implode("-", $v);
								$v = "-".$v."-";
								if (strpos($v, "-" . $_currentParentId . "-") !== false)
								{
									$parentsStr .= " " . $k;
									$_currentParentId = $k;
									break;
								}
							}
						}
					}
					else
					{
						$parentsStr = "";
					}
*/
					?>

			<!--tr class="row<?php echo $i % 2; ?>" sortable-group-id="<?php //echo $item->parent_id // invalid ?>" item-id="<?php echo $item->id ?>" parents="<?php //echo $parentsStr // invalid ?>" level="<?php //echo $item->level // invalid ?>"-->
				<tr class="row<?php echo $i % 2; ?>">

	<!-- Ordering Joomla 3.x (Test 3.3.3) -->
	<?php if(version_compare(JVERSION, '3.0', 'ge')) : ?>
					<td class="order nowrap center hidden-phone">
					<?php if ($canChange) :
						$disableClassName = '';
						$disabledLabel	  = '';

						if (!$saveOrder) :
							$disabledLabel    = JText::_('JORDERINGDISABLED');
							$disableClassName = 'inactive tip-top';
						endif; ?>
						<span class="sortable-handler hasTooltip <?php echo $disableClassName; ?>" title="<?php echo $disabledLabel; ?>">
							<i class="icon-menu"></i>
						</span>
						<input type="text" style="display:none" name="order[]" size="5" value="<?php echo $item->ordering; ?>" class="width-20 text-area-order " />
					<?php else : ?>
						<span class="sortable-handler inactive" >
							<i class="icon-menu"></i>
						</span>
					<?php endif; ?>
					</td>
	<?php endif; ?>


	<!-- CheckBox -->
						<td class="center hidden-phone">
							<?php echo JHtml::_('grid.id', $i, $item->id); ?>
						</td>

	<!-- Status -->
 	              <?php if (isset($this->items[0]->state)) { ?>
					    <td class="center">
						    <?php echo JHtml::_('jgrid.published', $item->state, $i, 'categories.', $canChange, 'cb'); ?>
					    </td>
  	              <?php } ?>

	<!-- Color -->
						<td class="small hidden-phone">
							<div style="display:block; width:50px; height:40px; border-radius:5px; background:<?php echo $item->color; ?>;"></div>
						</td>

	<!-- Title -->
						<td class="nowrap has-context">
							<div class="pull-left">
								<?php if ($item->checked_out) : ?>
									<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'categories.', $canCheckin); ?>
								<?php endif; ?>
								<?php //if ($item->language == '*'):?>
									<?php //$language = JText::alt('JALL', 'language'); ?>
								<?php //else:?>
									<?php //$language = $item->language ? $this->escape($item->language) : JText::_('JUNDEFINED'); ?>
								<?php //endif;?>
								<?php if ($canEdit) : ?>
									<a href="<?php echo JRoute::_('index.php?option=com_icagenda&task=category.edit&id=' . $item->id); ?>" title="<?php echo JText::_('JACTION_EDIT'); ?>">
										<?php echo $this->escape($item->title); ?></a>
								<?php else : ?>
									<span title="<?php echo JText::sprintf('JFIELD_ALIAS_LABEL', $this->escape($item->alias)); ?>"><?php echo $this->escape($item->title); ?></span>
								<?php endif; ?>
							</div>

	<!-- DropDown Edit Joomla 3 -->
	<?php if(version_compare(JVERSION, '3.0', 'ge')) : ?>
							<div class="pull-left">
								<?php
									// Create dropdown items
									JHtml::_('dropdown.edit', $item->id, 'category.');
									JHtml::_('dropdown.divider');
									if ($item->state) :
										JHtml::_('dropdown.unpublish', 'cb' . $i, 'categories.');
									else :
										JHtml::_('dropdown.publish', 'cb' . $i, 'categories.');
									endif;

//									if ($item->featured) :
//										JHtml::_('dropdown.unfeatured', 'cb' . $i, 'categories.');
//									else :
//										JHtml::_('dropdown.featured', 'cb' . $i, 'categories.');
//									endif;

									JHtml::_('dropdown.divider');

									if ($archived) :
										JHtml::_('dropdown.unarchive', 'cb' . $i, 'categories.');
									else :
										JHtml::_('dropdown.archive', 'cb' . $i, 'categories.');
									endif;

									if ($item->checked_out) :
										JHtml::_('dropdown.checkin', 'cb' . $i, 'categories.');
									endif;

									if ($trashed) :
										JHtml::_('dropdown.untrash', 'cb' . $i, 'categories.');
									else :
										JHtml::_('dropdown.trash', 'cb' . $i, 'categories.');
									endif;

									// Render dropdown list
									echo JHtml::_('dropdown.render');
									?>
							</div>
		<?php endif; ?>


						</td>

	<!-- Ordering Joomla 2.5 -->
	<?php if(version_compare(JVERSION, '3.0', 'lt')) : ?>
             	   <?php if (isset($this->items[0]->ordering)) { ?>
					    <td class="order">
						    <?php if ($canChange) : ?>
							    <?php if ($saveOrder) :?>
								    <?php if ($listDirn == 'asc') : ?>
									    <span><?php echo $this->pagination->orderUpIcon($i, true, 'categories.orderup', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
									    <span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, true, 'categories.orderdown', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
								    <?php elseif ($listDirn == 'desc') : ?>
									    <span><?php echo $this->pagination->orderUpIcon($i, true, 'categories.orderdown', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
									    <span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, true, 'categories.orderup', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
								    <?php endif; ?>
							    <?php endif; ?>
							    <?php $disabled = $saveOrder ?  '' : 'disabled="disabled"'; ?>
							    <input type="text" name="order[]" size="5" value="<?php echo $item->ordering;?>" <?php echo $disabled ?> class="text-area-order" />
						    <?php else : ?>
							    <?php echo $item->ordering; ?>
						    <?php endif; ?>
					    </td>
             	   <?php } ?>
		<?php endif; ?>


	<!-- ID -->
						<?php if (isset($this->items[0]->id)) { ?>
						<td class="center hidden-phone">
							<?php echo (int) $item->id; ?>
						</td>
        	        	<?php } ?>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

			<div>
				<input type="hidden" name="task" value="" />
				<input type="hidden" name="boxchecked" value="0" />
				<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
				<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
				<?php echo JHtml::_('form.token'); ?>
			</div>
		</div>
	</form>
	<?php
}
else
{
	$app->enqueueMessage(JText::_('JERROR_ALERTNOAUTHOR'), 'warning');
	$app->redirect(htmlspecialchars_decode('index.php?option=com_icagenda&view=icagenda'));
}
