<?php
/**
 * Kunena Component
 * @package Kunena.Administrator.Template
 * @subpackage Attachments
 *
 * @copyright (C) 2008 - 2014 Kunena Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.org
 **/
defined ( '_JEXEC' ) or die ();

/** @var KunenaAdminViewAttachments $this */
?>

<script type="text/javascript">
	Joomla.orderTable = function() {
		var dirn = '';
		var table = document.getElementById("sortTable");
		var direction = document.getElementById("directionTable");
		var order = table.options[table.selectedIndex].value;
		if (order != '<?php echo $this->listOrdering; ?>') {
			dirn = 'asc';
		} else {
			dirn = direction.options[direction.selectedIndex].value;
		}
		Joomla.tableOrdering(order, dirn, '');
	}
</script>

<div id="kunena" class="admin override">
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12">
				<div id="j-sidebar-container" class="span2">
					<div id="sidebar">
						<div class="sidebar-nav"><?php include KPATH_ADMIN.'/template/joomla25/common/menu.php'; ?></div>
					</div>
				</div>
				<div id="j-main-container" class="span10">
					<form action="<?php echo KunenaRoute::_('administrator/index.php?option=com_kunena&view=attachments') ?>" method="post" id="adminForm" name="adminForm">
						<input type="hidden" name="task" value="" />
						<input type="hidden" name="filter_order" value="<?php echo $this->listOrdering ?>" />
						<input type="hidden" name="filter_order_Dir" value="<?php echo $this->listDirection ?>" />
						<input type="hidden" name="boxchecked" value="0" />
						<?php echo JHtml::_( 'form.token' ); ?>

						<div id="filter-bar" class="btn-toolbar">
							<div class="filter-search btn-group pull-left">
								<label for="filter_search" class="element-invisible"><?php echo JText::_('COM_KUNENA_FIELD_LABEL_SEARCHIN');?></label>
								<input type="text" name="filter_search" id="filter_search" class="filter" placeholder="<?php echo JText::_('COM_KUNENA_FIELD_INPUT_SEARCH'); ?>" value="<?php echo $this->escape($this->state->get('list.search')); ?>" title="<?php echo JText::_('COM_KUNENA_FIELD_INPUT_SEARCH'); ?>" />
							</div>
							<div class="btn-group pull-left">
								<button class="btn tip" type="submit" ><?php echo JText::_('COM_KUNENA_SYS_BUTTON_FILTERSUBMIT'); ?></button>
								<button class="btn tip" type="button"  onclick="document.getElements('.filter').set('value', '');this.form.submit();"><?php echo JText::_('COM_KUNENA_SYS_BUTTON_FILTERRESET'); ?></button>
							</div>
							<div class="btn-group pull-right hidden-phone">
								<label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?></label>
								<?php echo KunenaLayout::factory('pagination/limitbox')->set('pagination', $this->pagination); ?>
							</div>
							<div class="btn-group pull-right hidden-phone">
								<label for="directionTable" class="element-invisible"><?php echo JText::_('JFIELD_ORDERING_DESC');?></label>
								<select name="directionTable" id="directionTable" class="input-medium" onchange="Joomla.orderTable()">
									<option value=""><?php echo JText::_('JFIELD_ORDERING_DESC');?></option>
									<?php echo JHtml::_('select.options', $this->sortDirectionFields, 'value', 'text', $this->escape($this->listDirection));?>
								</select>
							</div>
							<div class="btn-group pull-right">
								<label for="sortTable" class="element-invisible"><?php echo JText::_('COM_KUNENA_SORT_TABLE_BY');?></label>
								<select name="sortTable" id="sortTable" class="input-medium" onchange="Joomla.orderTable()">
									<option value=""><?php echo JText::_('COM_KUNENA_SORT_TABLE_BY');?></option>
									<?php echo JHtml::_('select.options', $this->sortFields, 'value', 'text', $this->listOrdering);?>
								</select>
							</div>
							<div class="clearfix"></div>
						</div>

						<table class="table table-striped">
							<thead>
								<tr>
									<th width="1%"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count ( $this->items ); ?>);" /></th>
									<th><?php echo JHtml::_('grid.sort', 'COM_KUNENA_ATTACHMENTS_FIELD_LABEL_TITLE', 'filename', $this->listDirection, $this->listOrdering ); ?></th>
									<th><?php echo JHtml::_('grid.sort', 'COM_KUNENA_ATTACHMENTS_FIELD_LABEL_TYPE', 'filetype', $this->listDirection, $this->listOrdering ); ?></th>
									<th><?php echo JHtml::_('grid.sort', 'COM_KUNENA_ATTACHMENTS_FIELD_LABEL_SIZE', 'size', $this->listDirection, $this->listOrdering ); ?>
									<th><?php echo JText::_('COM_KUNENA_ATTACHMENTS_FIELD_LABEL_IMAGEDIMENSIONS'); ?>	</th>
									<th><?php echo JHtml::_('grid.sort', 'COM_KUNENA_ATTACHMENTS_USERNAME', 'username', $this->listDirection, $this->listOrdering); ?></th>
									<th><?php echo JHtml::_('grid.sort', 'COM_KUNENA_ATTACHMENTS_FIELD_LABEL_MESSAGE', 'post', $this->listDirection, $this->listOrdering ); ?></th>
									<th class="center"><?php echo JHtml::_('grid.sort', 'COM_KUNENA_ATTACHMENTS_ID', 'id', $this->listDirection, $this->listOrdering ); ?></th>
								</tr>
								<tr>
									<td class="center">
									</td>
									<td class="nowrap">
										<label for="filter_title" class="element-invisible"><?php echo JText::_('COM_KUNENA_FIELD_LABEL_SEARCH_IN');?>:</label>
										<input class="input-block-level input-filter filter" type="text" name="filter_title" id="filter_title" placeholder="<?php echo JText::_('COM_KUNENA_SYS_BUTTON_FILTERSUBMIT') ?>" value="<?php echo $this->filterTitle; ?>" title="<?php echo JText::_('COM_KUNENA_SYS_BUTTON_FILTERSUBMIT') ?>" />
									</td>
									<td class="nowrap">
										<label for="filter_type" class="element-invisible"><?php echo JText::_('COM_KUNENA_FIELD_LABEL_SEARCH_IN');?>:</label>
										<input class="input-block-level input-filter filter" type="text" name="filter_type" id="filter_type" placeholder="<?php echo JText::_('COM_KUNENA_SYS_BUTTON_FILTERSUBMIT') ?>" value="<?php echo $this->filterType; ?>" title="<?php echo JText::_('COM_KUNENA_SYS_BUTTON_FILTERSUBMIT') ?>" />
									</td>
									<td class="nowrap">
										<label for="filter_size" class="element-invisible"><?php echo JText::_('COM_KUNENA_FIELD_LABEL_SEARCH_IN');?>:</label>
										<input class="input-block-level input-filter filter" type="text" name="filter_size" id="filter_size" placeholder="<?php echo JText::_('COM_KUNENA_SYS_BUTTON_FILTERSUBMIT') ?>" value="<?php echo $this->filterSize; ?>" title="<?php echo JText::_('COM_KUNENA_SYS_BUTTON_FILTERSUBMIT') ?>" />
									</td>
									<td class="nowrap">
									<?php /*
										<label for="filter_dims" class="element-invisible"><?php echo JText::_('COM_KUNENA_FIELD_LABEL_SEARCH_IN');?>:</label>
										<input class="input-block-level input-filter filter" type="text" name="filter_dims" id="filter_dims" placeholder="<?php echo JText::_('COM_KUNENA_SYS_BUTTON_FILTERSUBMIT') ?>" value="<?php echo $this->filterDimensions; ?>" title="<?php echo JText::_('COM_KUNENA_SYS_BUTTON_FILTERSUBMIT') ?>" />
									*/ ?>
									</td>
									<td class="nowrap">
										<label for="filter_username" class="element-invisible"><?php echo JText::_('COM_KUNENA_FIELD_LABEL_SEARCH_IN');?>:</label>
										<input class="input-block-level input-filter filter" type="text" name="filter_username" id="filter_username" placeholder="<?php echo JText::_('COM_KUNENA_SYS_BUTTON_FILTERSUBMIT') ?>" value="<?php echo $this->filterUsername; ?>" title="<?php echo JText::_('COM_KUNENA_SYS_BUTTON_FILTERSUBMIT') ?>" />
									</td>
									<td class="nowrap">
										<label for="filter_post" class="element-invisible"><?php echo JText::_('COM_KUNENA_FIELD_LABEL_SEARCH_IN');?>:</label>
										<input class="input-block-level input-filter filter" type="text" name="filter_post" id="filter_post" placeholder="<?php echo JText::_('COM_KUNENA_SYS_BUTTON_FILTERSUBMIT') ?>" value="<?php echo $this->filterPost; ?>" title="<?php echo JText::_('COM_KUNENA_SYS_BUTTON_FILTERSUBMIT') ?>" />
									</td>
									<td class="nowrap center hidden-phone">
									</td>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<td colspan="8">
										<?php echo KunenaLayout::factory('pagination/footer')->set('pagination', $this->pagination); ?>
									</td>
								</tr>
							</tfoot>
							<tbody>
							<?php
							$k = $i = 0;
							$n = count($this->items);
							if($this->pagination->total > 0) :
							foreach ($this->attachments_instance as $attachment)
							{
							?>
								<tr <?php echo 'class = "row' . $k . '"';?>>
									<td><?php echo JHtml::_('grid.id', $i, intval($attachment->attachment->id)) ?></td>
									<td><?php echo $attachment->attachment->getThumbnailLink() . ' ' . KunenaForumMessageAttachmentHelper::shortenFileName($attachment->attachment->filename, 10, 15) ?></td>
									<td><?php echo $this->escape($attachment->attachment->filetype); ?></td>
									<td><?php echo number_format ( intval ( $attachment->attachment->size ) / 1024, 0, '', ',' ) . ' KB'; ?></td>
									<td><?php echo isset($attachment->width) && isset($attachment->height) ? $attachment->width . ' x ' . $attachment->height  : '' ?></td>
									<td><?php echo $this->escape($attachment->message->name); ?></td>
									<td><?php echo $this->escape($attachment->message->subject); ?></td>
									<td><?php echo intval($attachment->attachment->id); ?></td>
								</tr>
							<?php
							$i++;
							$k = 1 - $k;
							}
							else : ?>
								<tr>
									<td colspan="10">
										<div class="well center filter-state">
										<span><?php echo JText::_('COM_KUNENA_FILTERACTIVE'); ?>
											<?php /*<a href="#" onclick="document.getElements('.filter').set('value', '');this.form.submit();return false;"><?php echo JText::_('COM_KUNENA_FIELD_LABEL_FILTERCLEAR'); ?></a> */?>
											<?php if($this->filterActive || $this->pagination->total > 0) : ?>
												<button class="btn" type="button"  onclick="document.getElements('.filter').set('value', '');this.form.submit();"><?php echo JText::_('COM_KUNENA_FIELD_LABEL_FILTERCLEAR'); ?></button>
											<?php else : ?>
												<?php //Currently no default state, might change later. ?>
											<?php endif; ?>
										</span>
										</div>
									</td>
								</tr>
							<?php endif; ?>
							</tbody>
						</table>
					</form>
				</div>
				<div class="pull-right small">
					<?php echo KunenaVersion::getLongVersionHTML (); ?>
				</div>
			</div>
		</div>
	</div>
</div>
