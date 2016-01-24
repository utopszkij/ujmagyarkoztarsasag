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
 * @version     3.5.12 2015-09-21
 * @since		2.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

JHtml::_('behavior.modal');
JHtml::_('behavior.multiselect');

$app = JFactory::getApplication();

// Access Administration Registrations check.
if (JFactory::getUser()->authorise('icagenda.access.registrations', 'com_icagenda'))
{
	$user			= JFactory::getUser();
	$userId			= $user->get('id');
	$listOrder		= $this->state->get('list.ordering');
	$listDirn		= $this->state->get('list.direction');
	$canOrder		= $user->authorise('core.edit.state', 'com_icagenda');
	$saveOrder		= $listOrder == 'a.ordering';
	$dateFormat		= $this->params->get('date_format_global', 'Y - m - d');
	$dateSeparator	= $this->params->get('date_separator', ' ');
	$timeFormat		= ($this->params->get('timeformat', '1') == 1) ? 'H:i' : 'h:i A';

	if (version_compare(JVERSION, '3.0', 'lt'))
	{
		JHtml::_('behavior.tooltip');
	}
	else
	{
		// Include the component HTML helpers.
		JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
		JHtml::_('bootstrap.tooltip');
		JHtml::_('formbehavior.chosen', 'select');
		JHtml::_('dropdown.init');

//		$archived	= $this->state->get('filter.published') == 2 ? true : false;
//		$trashed	= $this->state->get('filter.published') == -2 ? true : false;

		if ($saveOrder)
		{
	    	$saveOrderingUrl = 'index.php?option=com_icagenda&task=registrations.saveOrderAjax&tmpl=component';
	    	JHtml::_('sortablelist.sortable', 'registrationsList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
		}
	}

	?>

	<form action="<?php echo JRoute::_('index.php?option=com_icagenda&view=registrations'); ?>" method="post" name="adminForm" id="adminForm">
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

					<select name="filter_categories" class="inputbox" onchange="this.form.submit()">
						<option value=""><?php echo JText::_('COM_ICAGENDA_REGISTRATIONS_SELECT_CATEGORY');?></option>
						<?php echo JHtml::_('select.options', $this->categories, 'value', 'text', $this->state->get('filter.categories'));?>
					</select>

					<select name="filter_events" class="inputbox" onchange="this.form.submit()">
						<option value=""><?php echo JText::_('COM_ICAGENDA_REGISTRATIONS_SELECT_EVENT');?></option>
						<?php echo JHtml::_('select.options', $this->events, 'value', 'text', $this->state->get('filter.events'));?>
					</select>

					<select name="filter_dates" class="inputbox" onchange="this.form.submit()">
						<option value=""><?php echo JText::_('COM_ICAGENDA_REGISTRATIONS_SELECT_DATE');?></option>
						<?php echo JHtml::_('select.options', $this->dates, 'value', 'text', $this->state->get('filter.dates'));?>
					</select>

				</div>
			</fieldset>
			<div class="clr"> </div>

		<?php else : ?>

			<div id="filter-bar" class="btn-toolbar">
				<div class="filter-search btn-group pull-left">
					<label for="filter_search" class="element-invisible"><?php echo JText::_('JSEARCH_FILTER'); ?></label>
					<input type="text" name="filter_search" placeholder="<?php echo JText::_('JSEARCH_FILTER'); ?>" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('JSEARCH_FILTER'); ?>" />
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
			<table class="table table-striped" id="registrationsList">
		<?php endif; ?>

				<thead>
					<tr>
						<?php // *** Ordering HEADER (Joomla 3.x) *** ?>
						<?php if(version_compare(JVERSION, '3.0', 'ge')) : ?>
 						<th width="1%" class="nowrap center hidden-phone">
							<?php echo JHtml::_('grid.sort', '<i class="icon-menu-2"></i>', 'a.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING'); ?>
						</th>
						<?php endif; ?>

						<?php // *** CheckBox HEADER *** ?>
						<th width="1%" class="hidden-phone">
							<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
						</th>

						<?php // *** Status HEADER *** ?>
						<th width="1%" style="min-width:55px" class="nowrap center hidden-phone">
							<?php echo JHtml::_('grid.sort', 'JSTATUS', 'a.state', $listDirn, $listOrder); ?>
						</th>

						<?php // *** User HEADER *** ?>
						<th>
							<?php echo JText::_('COM_ICAGENDA_REGISTRATION_INFORMATION'); ?><span class="hidden-phone">:</span><span class="visible-phone"></span>
							<?php echo JHtml::_('grid.sort',  'IC_NAME', 'name', $listDirn, $listOrder); ?>&nbsp;|
							<?php echo JHtml::_('grid.sort',  'COM_ICAGENDA_REGISTRATION_USER_ID', 'userid', $listDirn, $listOrder); ?>&nbsp;|
							<?php echo JHtml::_('grid.sort',  'COM_ICAGENDA_REGISTRATION_EMAIL', 'email', $listDirn, $listOrder); ?>&nbsp;|
							<?php echo JHtml::_('grid.sort',  'COM_ICAGENDA_REGISTRATION_PHONE', 'phone', $listDirn, $listOrder); ?>&nbsp;|
							<?php //echo JText::_('COM_ICAGENDA_REGISTRATION_LABEL'); ?><!--span class="hidden-phone">:</span><span class="visible-phone"></span-->
							<?php echo JHtml::_('grid.sort',  'COM_ICAGENDA_REGISTRATION_NUMBER_PLACES', 'a.people', $listDirn, $listOrder); ?>&nbsp;-
							<?php echo JHtml::_('grid.sort',  'COM_ICAGENDA_REGISTRATION_EVENTID', 'event', $listDirn, $listOrder); ?>&nbsp;|
							<?php echo JHtml::_('grid.sort',  'ICDATE', 'a.date', $listDirn, $listOrder); ?>&nbsp;|
							<?php echo JHtml::_('grid.sort',  'JGLOBAL_FIELD_CREATED_BY_LABEL', 'evt_created_by', $listDirn, $listOrder); ?>
						</th>

						<?php // *** ID HEADER *** ?>
						<th width="1%" class="nowrap hidden-phone">
							<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
						</th>

					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="5">
							<?php echo $this->pagination->getListFooter(); ?>
						</td>
					</tr>
				</tfoot>
				<tbody valign="top">
				<?php foreach ($this->items as $i => $item) :
					$ordering		= ($listOrder == 'a.ordering');
					$canCreate		= $user->authorise('core.create', 'com_icagenda');
					$canEdit		= $user->authorise('core.edit', 'com_icagenda');
					$canCheckin		= $user->authorise('core.manage', 'com_icagenda') || $item->checked_out == $userId || $item->checked_out == 0;
					$canChange		= $user->authorise('core.edit.state', 'com_icagenda') && $canCheckin;
					$canEditOwn		= $user->authorise('core.edit.own', 'com_icagenda') && $item->userid == $userId;

					// Get avatar of the registered user
					$avatar			= md5(strtolower(trim($item->email)));

					// Get Username and name
					$data_name		= ($item->userid) ? $item->fullname : $item->name;
					$data_username	= ($item->userid) ? $item->username : false;

					// Load Custom fields DATA
					$customfields	= icagendaCustomfields::getListNotEmpty($item->id, 1);
					?>
					<tr class="row<?php echo $i % 2; ?>">

						<?php // START J3 CODE ?>
						<?php if(version_compare(JVERSION, '3.0', 'ge')) : ?>

						<?php // *** Ordering (Joomla 3.x) *** ?>
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

						<?php // END J3 CODE ?>
						<?php endif; ?>

						<?php // *** CheckBox *** ?>
						<td class="center hidden-phone">
							<?php //if ( $item->evt_state == 1) : ?>
								<?php echo JHtml::_('grid.id', $i, $item->id); ?>
							<?php //else : ?>
								<?php //echo ''; ?>
							<?php //endif; ?>
						</td>

 						<?php // *** Status *** ?>
				    	<td class="center hidden-phone">
               				<?php if (isset($this->items[0]->state)) : ?>
					    		<?php echo JHtml::_('jgrid.published', $item->state, $i, 'registrations.', $canChange, 'cb'); ?>
                			<?php endif; ?>
				    	</td>

 						<?php // *** User Information *** ?>
						<td class="has-context">
							<div class="pull-left hidden-phone" style="margin-right:10px;">
								<img alt="<?php echo $item->name; ?>" src="http://www.gravatar.com/avatar/<?php echo $avatar; ?>?s=36&d=mm"/>
							</div>
							<div class="pull-left" style="width:45%">
								<?php if ($item->checked_out) : ?>
									<?php echo JHtml::_('jgrid.checkedout', $i, $item->username, $item->checked_out_time, 'registrations.', $canCheckin); ?>
								<?php endif; ?>
								<?php //if ($item->language == '*'):?>
									<?php //$language = JText::alt('JALL', 'language'); ?>
								<?php //else:?>
									<?php //$language = $item->language ? $this->escape($item->language) : JText::_('JUNDEFINED'); ?>
								<?php //endif;?>
								<?php //if ($canEdit || $canEditOwn) : ?>
								<!--a href="<?php //echo JRoute::_('index.php?option=com_icagenda&task=registration.edit&id=' . $item->id); ?>" title="<?php //echo JText::_('JACTION_EDIT'); ?>"-->


								<?php if ($data_name) : ?>
									<p class="smallsub">
										<?php echo JText::_('IC_NAME') . ': '; ?>
										<?php //if ($canEdit && $item->evt_state == 1) : ?>
										<?php if ($canEdit || $canEditOwn) : ?>
											<a href="<?php echo JRoute::_('index.php?option=com_icagenda&task=registration.edit&id=' . $item->id); ?>" title="<?php echo JText::_('JACTION_EDIT'); ?>">
												<?php echo '<strong>' . $this->escape($item->name). '</strong>'; ?>
											</a>
										<?php else : ?>
												<?php echo '<strong>' . $this->escape($item->name). '</strong>'; ?>
										<?php endif; ?>
									</p>
									<?php if ($data_username) : ?>
										<?php echo '<strong>' . $this->escape($data_username) . '</strong>'; ?>
										<?php echo '<small>[' . $this->escape($data_name) . ']</small>'; ?>
									<?php endif; ?>

									<!--/a-->
									<?php //else : ?>
										<!--span title="<?php //echo JText::sprintf('JFIELD_ALIAS_LABEL', $this->escape($item->alias)); ?>"--><?php //echo $this->escape($item->name); ?><!--/span-->
									<?php //endif; ?>
									<?php if ($item->userid != '0') : ?>
										<p class="smallsub">
											<?php echo JText::_('COM_ICAGENDA_REGISTRATION_USER_ID') . ": " . $this->escape($item->userid); ?>
										</p>
									<?php else:?>
										<p class="smallsub">
											<?php echo JText::_('COM_ICAGENDA_REGISTRATION_NO_USER_ID'); ?>
										</p>
									<?php endif; ?>
									<?php if (($item->email) OR ($item->phone)) : ?>
										<!--div class="small" style="height:5px; border-bottom: solid 1px #D4D4D4">
										</div-->
										<p>
										<?php if ($item->email) : ?>
											<div class="small iC-italic-grey">
												<?php echo JText::_('COM_ICAGENDA_REGISTRATION_EMAIL') . ": <b>" . $this->escape($item->email) . "</b>"; ?>
											</div>
										<?php endif; ?>
										<?php if ($item->phone) : ?>
											<div class="small iC-italic-grey">
												<?php echo JText::_('COM_ICAGENDA_REGISTRATION_PHONE') . ": <b>" . $this->escape($item->phone) . "</b>"; ?>
											</div>
										<?php endif; ?>
										</p>
									<?php endif; ?>
								<?php endif; ?>

								<?php if ($item->notes) : ?>
									<br />
									<a href="#loadDiv<?php echo $item->id; ?>" class="modal" rel="{size: {x: 600, y: 350}}">
										<input type="submit" class="btn" value="<?php echo JText::_( 'COM_ICAGENDA_REGISTRATION_NOTES_DISPLAY_LABEL' ); ?>" />
									</a>
									<div style="display:none;">
										<div id="loadDiv<?php echo $item->id; ?>">
											<?php echo "<h3>".JText::_('COM_ICAGENDA_REGISTRATION_NOTES_DISPLAY_LABEL') . ": </h3><hr>" . nl2br(html_entity_decode($item->notes)); ?>
										</div>
									</div>
								<?php endif; ?>

 								<?php // Custom Fields ?>
 								<?php if ($customfields) : ?>
									<?php foreach ($customfields AS $customfield) : ?>
										<?php $cf_value = isset($customfield->cf_value) ? $customfield->cf_value : JText::_('IC_NOT_SPECIFIED'); ?>
										<div class="small iC-italic-grey">
											<?php echo $customfield->cf_title . ': <strong>' . $cf_value . '</strong>'; ?>
										</div>
									<?php endforeach; ?>
								<?php endif; ?>

							</div>
							<div class="pull-right visible-phone" style="margin-right:5%;">
								<img alt="<?php echo $item->name; ?>" src="http://www.gravatar.com/avatar/<?php echo $avatar; ?>?s=36&d=mm"/>
							</div>
							<div class="pull-left" style="width:50%">
								<?php if ( $item->evt_state != 1) : ?>
									<div class="small">
										<div style="font-weight:bold; background:#c30000; color:#FFFFFF; padding: 2px 5px; border-radius: 5px;">
											<?php echo JText::_( 'COM_ICAGENDA_REGISTRATION_EVENT_NOT_PUBLISHED' ); ?>
										</div>
									</div>
								<?php endif; ?>
								<div class="small">
									<?php echo JText::_('ICEVENT'); ?>
								</div>
								<div class="small iC-italic-grey">
									<?php echo JText::_('ICTITLE') . ': <strong>' . $this->escape($item->event) . '</strong>'; ?>
								</div>
								<div class="small iC-italic-grey">
									<?php if (( ! $item->date && $item->period == 0) || ($item->period == 1)) : ?>
										<?php echo JText::_('ICDATES') . ': '; ?>
									<?php else : ?>
										<?php echo JText::_('ICDATE') . ': '; ?>
									<?php endif; ?>
									<strong>
									<?php if ( ! $item->date && $item->period == 0) : ?>
										<?php // echo JText::_( 'COM_ICAGENDA_ADMIN_REGISTRATION_FOR_ALL_PERIOD' ); ?>
										<?php if (iCDate::isDate($item->startdate)) : ?>
											<?php echo iCGlobalize::dateFormat($item->startdate, $dateFormat, $dateSeparator); ?>
											<?php if ($item->displaytime) : ?>
												<?php echo ' - ' . date($timeFormat, strtotime($item->startdate)); ?>
											<?php endif; ?>
										<?php else : ?>
											<?php echo $item->startdate; ?>
										<?php endif; ?>
										<?php if ($item->enddate) echo ' > '; ?>
										<?php if (iCDate::isDate($item->enddate)) : ?>
											<?php echo iCGlobalize::dateFormat($item->enddate, $dateFormat, $dateSeparator); ?>
											<?php if ($item->displaytime) : ?>
												<?php echo ' - ' . date($timeFormat, strtotime($item->enddate)); ?>
											<?php endif; ?>
										<?php else : ?>
											<?php echo $item->enddate; ?>
										<?php endif; ?>
									<?php elseif ( ! $item->date && $item->period == 1) : ?>
										<?php echo JText::_( 'COM_ICAGENDA_ADMIN_REGISTRATION_FOR_ALL_DATES' ); ?>
									<?php else : ?>
										<?php if (iCDate::isDate($item->date)) : ?>
											<?php echo iCGlobalize::dateFormat($item->date, $dateFormat, $dateSeparator); ?>
											<?php if ($item->displaytime) : ?>
												<?php echo ' - ' . date($timeFormat, strtotime($item->date)); ?>
											<?php endif; ?>
										<?php else : ?>
											<?php echo $item->date; ?>
										<?php endif; ?>
									<?php endif; ?>
									</strong>
								</div>
								<?php if ($item->evt_created_by) :
									// Get Author Name
									$db = JFactory::getDBO();
									$db->setQuery(
										'SELECT `name`' .
										' FROM `#__users`' .
										' WHERE `id` = '. (int) $item->evt_created_by
									);
									$authorname = $db->loadObject()->name;
 								?>
								<div class="small iC-italic-grey">
									<?php echo JText::_('JGLOBAL_FIELD_CREATED_BY_LABEL') . ': <strong>' . $this->escape($authorname) . '</strong>'; ?>
								</div>
								<?php endif; ?>
								<p>
								<div class="small">
									<?php echo JText::_('ICINFORMATION'); ?>
								</div>
								<div class="small iC-italic-grey">
									<?php echo JText::_('COM_ICAGENDA_REGISTRATION_NUMBER_PLACES') . ': <strong>' . $item->people . '</strong>'; ?>
								</div>
								</p>
							</div>
						</td>

						<?php // *** ID *** ?>
						<td class="center hidden-phone">
							<?php if (isset($this->items[0]->id)) : ?>
								<?php echo (int) $item->id; ?>
							<?php endif; ?>
						</td>

					</tr>
				<?php endforeach; ?>

			<?php
			// Old Joomla versions asset_id issue. (all Joomla 2.5.x versions, and Joomla 3 NOT updated!)
			$asset_issue = version_compare(JVERSION, '3.0', 'lt') ? true : false;

			if ($asset_issue)
			{
				$ia = '0';
				unset($msg);
				unset($type);
				$msg = $type = $front_submit = '';
				$edittx = '<b>' . JText::_( 'JACTION_EDIT' ) . '</b>';
				$savetx = '<b>' . JText::_( 'JSAVE' ) . '</b>';

				foreach ($this->items as $i => $item)
				{
					if (($item->asset_id == '0') && ($item->state == '-2'))
					{
						$ia = $ia+1;
						$front_submit = '1';
					}
				}

				if ($front_submit == 1 && $ia == 1)
				{
					$app->enqueueMessage(JText::sprintf( 'COM_ICAGENDA_TRASH_FRONTEND_REGISTRATION_1', $edittx, $savetx ), 'notice');
				}
				elseif ($front_submit == 1 && $ia > 1)
				{
					$app->enqueueMessage(JText::sprintf( 'COM_ICAGENDA_TRASH_FRONTEND_REGISTRATION', $edittx, $savetx ), 'notice');
				}

				foreach ($this->items as $i => $item)
				{
					if ($item->asset_id == '0' && $item->state == '-2')
					{
						$editLink = 'index.php?option=com_icagenda&task=registration.edit&id=' . $item->id;
						$msg	= '- ' . $item->name . ' [' . $item->id . '] : <a href="' . $editLink . '"><b>'.JText::_( 'JACTION_EDIT' ).'</b></a>';
						$type	= JText::_( 'JGLOBAL_LIST' ).' :';
					}
					if ( ! empty($msg))
					{
						$app->enqueueMessage($msg, $type);
					}
				}
			}
			?>

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
