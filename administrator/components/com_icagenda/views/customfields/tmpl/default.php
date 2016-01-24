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
 * @version     3.4.0 2014-07-16
 * @since		3.4.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

$app = JFactory::getApplication();

// Access Administration Customfields check.
if (JFactory::getUser()->authorise('icagenda.access.customfields', 'com_icagenda'))
{
	// Check Theme Packs Compatibility
	if (class_exists('icagendaTheme')) icagendaTheme::checkThemePacks();

	$user		= JFactory::getUser();
	$userId		= $user->get('id');
	$listOrder	= $this->escape($this->state->get('list.ordering'));
	$listDirn	= $this->escape($this->state->get('list.direction'));
	$canOrder	= $user->authorise('core.edit.state', 'com_icagenda');

	$saveOrder	= $listOrder == 'cf.ordering';

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
			$saveOrderingUrl = 'index.php?option=com_icagenda&task=customfields.saveOrderAjax&tmpl=component';
			JHtml::_('sortablelist.sortable', 'customfieldsList', 'adminForm', strtolower($listDirn), $saveOrderingUrl, false, true);
		}
		$sortFields = array();
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

	<form action="<?php echo JRoute::_('index.php?option=com_icagenda&view=customfields'); ?>" method="post" name="adminForm" id="adminForm">
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

				<div class="filter-select fltrt">
					<select name="filter_parent_form" class="inputbox" onchange="this.form.submit()">
						<option value=""><?php echo JText::_('COM_ICAGENDA_CUSTOMFIELDS_FILTER_OPTION_SELECT_PARENT_FORM');?></option>
						<?php echo JHtml::_('select.options', $this->get('ParentForm'), "value", "text", $this->state->get('filter.parent_form'), true);?>
					</select>
				</div>

				<div class="filter-select fltrt">
					<select name="filter_type" class="inputbox" onchange="this.form.submit()">
						<option value=""><?php echo JText::_('COM_ICAGENDA_CUSTOMFIELDS_FILTER_OPTION_SELECT_TYPE');?></option>
						<?php echo JHtml::_('select.options', $this->get('FieldTypes'), "value", "text", $this->state->get('filter.type'), true);?>
					</select>
				</div>

			</fieldset>
			<div class="clr"> </div>

		<?php else : ?>

			<div id="filter-bar" class="btn-toolbar">

				<div class="filter-search btn-group pull-left">
					<label for="filter_search" class="element-invisible"><?php echo JText::_('COM_ICAGENDA_CUSTOMFIELDS_FILTER_SEARCH_DESC'); ?></label>
					<input type="text" name="filter_search" placeholder="<?php echo JText::_('COM_ICAGENDA_CUSTOMFIELDS_FILTER_SEARCH_DESC'); ?>" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_ICAGENDA_CUSTOMFIELDS_FILTER_SEARCH_DESC'); ?>" />
				</div>

				<div class="btn-group pull-left">
					<button class="btn tip hasTooltip" type="submit" title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i></button>
					<button class="btn tip hasTooltip" type="button" onclick="document.id('filter_search').value='';this.form.submit();" title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>"><i class="icon-remove"></i></button>
				</div>

				<div class="btn-group pull-right hidden-phone">
					<label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC'); ?></label>
					<?php echo $this->pagination->getLimitBox(); ?>
				</div>

			</div>
			<div class="clearfix"> </div>

		<?php endif;?>

		<?php if(version_compare(JVERSION, '3.0', 'lt')) : ?>
			<table class="adminlist">
		<?php else : ?>
			<table class="table table-striped" id="customfieldsList">
		<?php endif; ?>

				<thead>
					<tr>
					<?php // JOOMLA 3.x ?>
					<?php if(version_compare(JVERSION, '3.0', 'ge')) : ?>

						<?php // Ordering HEADER Joomla 3.x ?>
 						<th width="1%" class="nowrap center hidden-phone">
							<?php echo JHtml::_('grid.sort', '<i class="icon-menu-2"></i>', 'cf.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING'); ?>
						</th>

					<?php endif; ?>
					<?php // END JOOMLA 3.x ?>

						<?php // CheckBox HEADER ?>
						<th width="1%" class="hidden-phone">
							<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
						</th>

						<?php // Status HEADER ?>
						<th width="1%" style="min-width:55px" class="nowrap center">
							<?php echo JHtml::_('grid.sort', 'JSTATUS', 'cf.state', $listDirn, $listOrder); ?>
						</th>

						<?php // Title HEADER ?>
						<th>
							<?php echo JHtml::_('grid.sort',  'COM_ICAGENDA_CUSTOMFIELD_TITLE_LBL', 'cf.title', $listDirn, $listOrder); ?>
						</th>

						<?php // Slug HEADER ?>
						<th>
							<?php echo JHtml::_('grid.sort',  'COM_ICAGENDA_CUSTOMFIELD_SLUG_LBL', 'cf.slug', $listDirn, $listOrder); ?>
						</th>

						<?php // Parent Form HEADER ?>
						<th>
							<?php echo JHtml::_('grid.sort',  'COM_ICAGENDA_CUSTOMFIELD_PARENT_FORM_LBL', 'cf.parent_form', $listDirn, $listOrder); ?>
						</th>

						<?php // Field Type HEADER ?>
						<th>
							<?php echo JHtml::_('grid.sort',  'COM_ICAGENDA_CUSTOMFIELD_TYPE_LBL', 'cf.type', $listDirn, $listOrder); ?>
						</th>

						<?php // Required HEADER ?>
						<th>
							<?php echo JHtml::_('grid.sort',  'COM_ICAGENDA_CUSTOMFIELD_REQUIRED_LBL', 'cf.required', $listDirn, $listOrder); ?>
						</th>

				<?php // JOOMLA 2.5 ?>
				<?php if(version_compare(JVERSION, '3.0', 'lt')) : ?>

						<?php // Ordering HEADER Joomla 2.5 ?>
					<?php if (isset($this->items[0]->ordering)) { ?>
						<th width="10%">
							<?php echo JHtml::_('grid.sort',  'JGRID_HEADING_ORDERING', 'cf.ordering', $listDirn, $listOrder); ?>
							<?php if ($canOrder && $saveOrder) :?>
								<?php echo JHtml::_('grid.order',  $this->items, 'filesave.png', 'customfields.saveorder'); ?>
							<?php endif; ?>
						</th>
					<?php } ?>

				<?php // END JOOMLA 2.5 ?>
				<?php endif; ?>

						<?php // ID HEADER ?>
						<th width="1%" class="nowrap hidden-phone">
							<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'cf.id', $listDirn, $listOrder); ?>
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
				$ordering	= ($listOrder == 'cf.ordering');
				$canCreate	= $user->authorise('core.create',		'com_icagenda');
				$canEdit	= $user->authorise('core.edit',			'com_icagenda');
				$canCheckin	= $user->authorise('core.manage',		'com_icagenda');
				$canChange	= $user->authorise('core.edit.state',	'com_icagenda');
				$canEditOwn	= $user->authorise('core.edit.own',		'com_icagenda');
				?>

					<tr class="row<?php echo $i % 2; ?>">

					<?php // JOOMLA 3.x ?>
					<?php if(version_compare(JVERSION, '3.0', 'ge')) : ?>

						<?php // Ordering Joomla 3.x ?>
						<td class="order nowrap center hidden-phone">
							<?php if ($canChange) :
								$disableClassName = '';
								$disabledLabel	  = '';

								if (!$saveOrder) :
									$disabledLabel    = JText::_('JORDERINGDISABLED');
									$disableClassName = 'inactive tip-top';
								endif;
								?>
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
					<?php // END JOOMLA 3.x ?>

						<?php // Ordering Joomla 3.x ?>
						<td class="center hidden-phone">
							<?php echo JHtml::_('grid.id', $i, $item->id); ?>
						</td>

						<?php // Status ?>
					<?php if (isset($this->items[0]->state)) { ?>
						<td class="center">
							<?php echo JHtml::_('jgrid.published', $item->state, $i, 'customfields.', $canChange, 'cb'); ?>
						</td>
					<?php } ?>

						<?php // Title ?>
						<td class="nowrap has-context">
							<div class="pull-left">
								<?php if ($item->checked_out) : ?>
									<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'customfields.', $canCheckin); ?>
								<?php endif; ?>
								<?php //if ($item->language == '*'):?>
									<?php //$language = JText::alt('JALL', 'language'); ?>
								<?php //else:?>
									<?php //$language = $item->language ? $this->escape($item->language) : JText::_('JUNDEFINED'); ?>
								<?php //endif;?>
								<?php if ($canEdit) : ?>
									<a href="<?php echo JRoute::_('index.php?option=com_icagenda&task=customfield.edit&id=' . $item->id); ?>" title="<?php echo JText::_('JACTION_EDIT'); ?>">
									<?php echo $this->escape($item->title); ?></a>
								<?php else : ?>
									<span title="<?php echo JText::sprintf('JFIELD_ALIAS_LABEL', $this->escape($item->alias)); ?>"><?php echo $this->escape($item->title); ?></span>
								<?php endif; ?>
							</div>

							<?php // DropDown Edit Joomla 3 ?>
						<?php if(version_compare(JVERSION, '3.0', 'ge')) : ?>
							<div class="pull-left">
								<?php
								// Create dropdown items
								JHtml::_('dropdown.edit', $item->id, 'customfield.');
								JHtml::_('dropdown.divider');

								if ($item->state) :
									JHtml::_('dropdown.unpublish', 'cb' . $i, 'customfields.');
								else :
									JHtml::_('dropdown.publish', 'cb' . $i, 'customfields.');
								endif;

								JHtml::_('dropdown.divider');

								if ($archived) :
									JHtml::_('dropdown.unarchive', 'cb' . $i, 'customfields.');
								else :
									JHtml::_('dropdown.archive', 'cb' . $i, 'customfields.');
								endif;

								if ($item->checked_out) :
									JHtml::_('dropdown.checkin', 'cb' . $i, 'customfields.');
								endif;

								if ($trashed) :
									JHtml::_('dropdown.untrash', 'cb' . $i, 'customfields.');
								else :
									JHtml::_('dropdown.trash', 'cb' . $i, 'customfields.');
								endif;

								// Render dropdown list
								echo JHtml::_('dropdown.render');
								?>
							</div>
						<?php endif; ?>
						</td>

						<?php // Slug ?>
						<td class="hidden-phone">
							<?php if ($item->slug) : ?>
								<?php echo $this->escape($item->slug); ?>
							<?php endif; ?>
						</td>

						<?php // Parent Form ?>
						<td class="hidden-phone">
							<?php if ($item->parent_form == 1) : ?>
								<?php echo JText::_('COM_ICAGENDA_CUSTOMFIELD_PARENT_REGISTRATION_FORM'); ?>
							<?php elseif ($item->parent_form == 2) : ?>
								<?php echo JText::_('COM_ICAGENDA_CUSTOMFIELD_PARENT_EVENT_EDIT'); ?>
							<?php endif; ?>
						</td>

						<?php // Field Type ?>
						<td class="hidden-phone">
							<?php if ($item->type) : ?>
								<?php echo $this->escape($item->type); ?>
							<?php endif; ?>
						</td>

						<?php // Required ?>
						<td class="hidden-phone">
							<?php if ($item->required == 1) : ?>
								<?php //echo '<div class="btn btn-mini btn-success">' . JText::_('JYES') . '</div>'; ?>
								<?php echo JText::_('JYES'); ?>
							<?php else : ?>
								<?php //echo '<div class="btn btn-mini">' . JText::_('JNO') . '</div>'; ?>
								<?php echo JText::_('JNO'); ?>
							<?php endif; ?>
						</td>

				<?php // JOOMLA 2.5 ?>
				<?php if(version_compare(JVERSION, '3.0', 'lt')) : ?>

						<?php // Ordering Joomla 2.5 ?>
					<?php if (isset($this->items[0]->ordering)) { ?>
						<td class="order">
							<?php if ($canChange) : ?>
								<?php if ($saveOrder) :?>
									<?php if ($listDirn == 'asc') : ?>
										<span><?php echo $this->pagination->orderUpIcon($i, true, 'customfields.orderup', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
										<span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, true, 'customfields.orderdown', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
									<?php elseif ($listDirn == 'desc') : ?>
										<span><?php echo $this->pagination->orderUpIcon($i, true, 'customfields.orderdown', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
										<span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, true, 'customfields.orderup', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
									<?php endif; ?>
								<?php endif; ?>
								<?php $disabled = $saveOrder ?  '' : 'disabled="disabled"'; ?>
								<?php echo '<input type="text" name="order[]" size="5" value="'
											. $item->ordering . '" ' . $disabled . ' class="text-area-order" />'; ?>
							<?php else : ?>
								<?php echo $item->ordering; ?>
							<?php endif; ?>
						</td>
					<?php } ?>

				<?php endif; ?>
				<?php // END JOOMLA 2.5 ?>

						<?php // ID ?>
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
