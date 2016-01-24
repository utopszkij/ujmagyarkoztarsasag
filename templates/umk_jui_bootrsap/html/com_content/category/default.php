<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

JHtml::_('behavior.caption');
?>
<div class="kapcsolodoCikkek">
<?php
// li-de témakör/szavazás elérése, megjelenitése
$temakor_id = '';
$szavazas_id = '';
$db = JFactory::getDBO();
$session = JFactory::getSession();
$db->setQuery('select * from #__categories where id='.$db->quote(JRequest::getVar('id')));
$res = $db->loadObject();
if ($res) {
	if (substr($res->alias,0,2)=='sz') {
	   // lehet hogy szavazáshoz rendelt kategoria
	   $szavazas_id = substr($res->alias,2,10);
	   $db->setQuery('select * from #__categories where id = '.$res->parent_id);
	   $res = $db->loadObject();
	   if ($res) {
		   if ($res->parent_id == 82) {
			   $temakor_id = substr($res->alias,1,10);
		   } else {
			   $szavazas_id = '';
		   }
	   } else {
		   $szavazas_id = '';
	   }
	}
	if ((substr($res->alias,0,1)=='t') and ($res->parent_id == 82)) {
	   $temakor_id = substr($res->alias,1,10);
    }
}
if ($temakor_id != '')	{
	JRequest::setVar('temakor',$temakor_id);
	$akciok = array();
	$akciok['ujSzavazas'] = JURI::base().'index.php?option=com_szavazasok&view=szavazasok&task=add&temakor='.$temakor_id.'&limit=20&limitstart=0&order=6';
	$session->set('akciok', $akciok);
	$db->setQuery('select * from #__temakorok where id='.$temakor_id);
	$temakor = $db->loadObject();
	if ($szavazas_id != '') {
	  $db->setQuery('select * from #__szavazasok where id='.$szavazas_id);
	  $szavazas = $db->loadObject();
	}
	?>
	<div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
		<div class="temakorDoboz">
			<div class="dobozFejlec">
			    <a href="<?php echo JURI::base(); ?>index.php?option=com_szavazasok&view=vita_alt&task=vita_alt&temakor=<?php echo $temakor_id; ?>">
				  <img class="temakorKep" src="<?php echo kepLeirasbol($temakor->leiras); ?>" />
				  Témakör: <h2><?php echo $temakor->megnevezes; ?></h2>
				</a>
			</div>
			<div class="temakorLeiras"><?php echo utf8Substr($temakor->leiras,0,10000); ?></div>
		</div>
		<?php if ($szavazas_id != '') : ?>
		<div class="szavazasDoboz">
			<div class="dobozFejlec">
				<a href="<?php echo JURI::base(); ?>index.php?option=com_alternativak&view=alternativaklist&task=browse&temakor=<?php echo $temakor_id; ?>&szavazas=<?php echo $szavazas_id; ?>">
				  <img class="szavazasKep" src="<?php echo kepLeirasbol($szavazas->leiras); ?>" />
			      <h3><?php echo $szavazas->megnevezes; ?></h3>
				</a>
			</div>
			<div class="szavazasLeiras"><?php echo utf8Substr($szavazas->leiras,0,10000); ?></div>
		</div>
		<?php endif; ?>
	</div><!-- componetheading -->
	<div class="clr"></div>	
	<?php
}

?>


<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

// Create some shortcuts.
$params    = &$this->item->params;
$n         = count($this->items);
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));

// Check for at least one editable article
$isEditable = false;

if (!empty($this->items))
{
	foreach ($this->items as $article)
	{
		if ($article->params->get('access-edit'))
		{
			$isEditable = true;
			break;
		}
	}
}
?>
<?php if (empty($this->items)) : ?>

	<?php if ($this->params->get('show_no_articles', 1)) : ?>
	<p><?php echo JText::_('COM_CONTENT_NO_ARTICLES'); ?></p>
	<?php endif; ?>

<?php else : ?>

<form action="<?php echo htmlspecialchars(JUri::getInstance()->toString()); ?>" method="post" name="adminForm" id="adminForm" class="form-inline">
	<?php if ($this->params->get('show_headings') || $this->params->get('filter_field') != 'hide' || $this->params->get('show_pagination_limit')) :?>
	<fieldset class="filters btn-toolbar clearfix">
		<?php if ($this->params->get('filter_field') != 'hide') :?>
			<div class="btn-group">
				<label class="filter-search-lbl element-invisible" for="filter-search">
					<?php echo JText::_('COM_CONTENT_' . $this->params->get('filter_field') . '_FILTER_LABEL') . '&#160;'; ?>
				</label>
				<input type="text" name="filter-search" id="filter-search" value="<?php echo $this->escape($this->state->get('list.filter')); ?>" class="inputbox" onchange="document.adminForm.submit();" title="<?php echo JText::_('COM_CONTENT_FILTER_SEARCH_DESC'); ?>" placeholder="<?php echo JText::_('COM_CONTENT_' . $this->params->get('filter_field') . '_FILTER_LABEL'); ?>" />
			</div>
		<?php endif; ?>
		<?php if ($this->params->get('show_pagination_limit')) : ?>
			<div class="btn-group pull-right">
				<label for="limit" class="element-invisible">
					<?php echo JText::_('JGLOBAL_DISPLAY_NUM'); ?>
				</label>
				<?php echo $this->pagination->getLimitBox(); ?>
			</div>
		<?php endif; ?>

		<input type="hidden" name="filter_order" value="" />
		<input type="hidden" name="filter_order_Dir" value="" />
		<input type="hidden" name="limitstart" value="" />
		<input type="hidden" name="task" value="" />
	</fieldset>
	<?php endif; ?>

	<table class="category table table-striped table-bordered table-hover">
		<?php
		$headerTitle    = '';
		$headerDate     = '';
		$headerAuthor   = '';
		$headerHits     = '';
		$headerEdit     = '';
		?>
		<?php if ($this->params->get('show_headings')) : ?>
			<?php
			$headerTitle    = 'headers="categorylist_header_title"';
			$headerDate     = 'headers="categorylist_header_date"';
			$headerAuthor   = 'headers="categorylist_header_author"';
			$headerHits     = 'headers="categorylist_header_hits"';
			$headerEdit     = 'headers="categorylist_header_edit"';
			?>
		<thead>
			<tr>
				<th id="categorylist_header_title">
					<?php echo JHtml::_('grid.sort', 'JGLOBAL_TITLE', 'a.title', $listDirn, $listOrder); ?>
				</th>
				<?php if ($date = $this->params->get('list_show_date')) : ?>
					<th id="categorylist_header_date">
						<?php if ($date == "created") : ?>
							<?php echo JHtml::_('grid.sort', 'COM_CONTENT_' . $date . '_DATE', 'a.created', $listDirn, $listOrder); ?>
						<?php elseif ($date == "modified") : ?>
							<?php echo JHtml::_('grid.sort', 'COM_CONTENT_' . $date . '_DATE', 'a.modified', $listDirn, $listOrder); ?>
						<?php elseif ($date == "published") : ?>
							<?php echo JHtml::_('grid.sort', 'COM_CONTENT_' . $date . '_DATE', 'a.publish_up', $listDirn, $listOrder); ?>
						<?php endif; ?>
					</th>
				<?php endif; ?>
				<?php if ($this->params->get('list_show_author')) : ?>
					<th id="categorylist_header_author">
						<?php echo JHtml::_('grid.sort', 'JAUTHOR', 'author', $listDirn, $listOrder); ?>
					</th>
				<?php endif; ?>
				<?php if ($this->params->get('list_show_hits')) : ?>
					<th id="categorylist_header_hits">
						<?php echo JHtml::_('grid.sort', 'JGLOBAL_HITS', 'a.hits', $listDirn, $listOrder); ?>
					</th>
				<?php endif; ?>
				<?php if ($isEditable) : ?>
					<th id="categorylist_header_edit"><?php echo JText::_('COM_CONTENT_EDIT_ITEM'); ?></th>
				<?php endif; ?>
			</tr>
		</thead>
		<?php endif; ?>
		<tbody>
			<?php foreach ($this->items as $i => $article) : ?>
				<?php if ($this->items[$i]->state == 0) : ?>
				 <tr class="system-unpublished cat-list-row<?php echo $i % 2; ?>">
				<?php else: ?>
				<tr class="cat-list-row<?php echo $i % 2; ?>" >
				<?php endif; ?>
					<td <?php echo $headerTitle; ?> class="list-title">
						<?php if (in_array($article->access, $this->user->getAuthorisedViewLevels())) : ?>
							<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catid, $article->language)); ?>">
								<?php echo $this->escape($article->title); ?>
							</a>
						<?php else: ?>
							<?php
							echo $this->escape($article->title) . ' : ';
							$menu   = JFactory::getApplication()->getMenu();
							$active = $menu->getActive();
							$itemId = $active->id;
							$link   = new JUri(JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId, false));
							$link->setVar('return', base64_encode(JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catid, $article->language), false)));
							?>
							<a href="<?php echo $link; ?>" class="register">
								<?php echo JText::_('COM_CONTENT_REGISTER_TO_READ_MORE'); ?>
							</a>
						<?php endif; ?>
						<?php if ($article->state == 0) : ?>
							<span class="list-published label label-warning">
								<?php echo JText::_('JUNPUBLISHED'); ?>
							</span>
						<?php endif; ?>
						<?php if (strtotime($article->publish_up) > strtotime(JFactory::getDate())) : ?>
							<span class="list-published label label-warning">
								<?php echo JText::_('JNOTPUBLISHEDYET'); ?>
							</span>
						<?php endif; ?>
						<?php if ((strtotime($article->publish_down) < strtotime(JFactory::getDate())) && $article->publish_down != JFactory::getDbo()->getNullDate()) : ?>
							<span class="list-published label label-warning">
								<?php echo JText::_('JEXPIRED'); ?>
							</span>
						<?php endif; ?>
						<div class="intro">
						<?php echo $article->introtext; ?>
						</div>
					</td>
					<?php if ($this->params->get('list_show_date')) : ?>
						<td <?php echo $headerDate; ?> class="list-date small">
							<?php
							echo JHtml::_(
								'date', $article->displayDate,
								$this->escape($this->params->get('date_format', JText::_('DATE_FORMAT_LC3')))
							); ?>
						</td>
					<?php endif; ?>
					<?php if ($this->params->get('list_show_author', 1)) : ?>
						<td <?php echo $headerAuthor; ?> class="list-author">
							<?php if (!empty($article->author) || !empty($article->created_by_alias)) : ?>
								<?php $author = $article->author ?>
								<?php $author = ($article->created_by_alias ? $article->created_by_alias : $author);?>
								<?php if (!empty($article->contact_link) && $this->params->get('link_author') == true) : ?>
									<?php echo JText::sprintf('COM_CONTENT_WRITTEN_BY', JHtml::_('link', $article->contact_link, $author)); ?>
								<?php else: ?>
									<?php echo JText::sprintf('COM_CONTENT_WRITTEN_BY', $author); ?>
								<?php endif; ?>
							<?php endif; ?>
						</td>
					<?php endif; ?>
					<?php if ($this->params->get('list_show_hits', 1)) : ?>
						<td <?php echo $headerHits; ?> class="list-hits">
							<span class="badge badge-info">
								<?php echo JText::sprintf('JGLOBAL_HITS_COUNT', $article->hits); ?>
							</span>
						</td>
					<?php endif; ?>
					<?php if ($isEditable) : ?>
						<td <?php echo $headerEdit; ?> class="list-edit">
							<?php if ($article->params->get('access-edit')) : ?>
								<?php echo JHtml::_('icon.edit', $article, $params); ?>
							<?php endif; ?>
						</td>
					<?php endif; ?>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>

<?php // Code to add a link to submit an article. ?>
<?php if ($this->category->getParams()->get('access-create')) : ?>
	<?php echo JHtml::_('icon.create', $this->category, $this->category->params); ?>
<?php  endif; ?>

<?php // Add pagination links ?>
<?php if (!empty($this->items)) : ?>
	<?php if (($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2)) && ($this->pagination->pagesTotal > 1)) : ?>
	<div class="pagination">

		<?php if ($this->params->def('show_pagination_results', 1)) : ?>
			<p class="counter pull-right">
				<?php echo $this->pagination->getPagesCounter(); ?>
			</p>
		<?php endif; ?>

		<?php echo $this->pagination->getPagesLinks(); ?>
	</div>
	<?php endif; ?>
</form>
<?php  endif; ?>

<?php
/* orig változat
<b>Kapcsolódó cikkek</b>
<div class="category-list< ?php echo $this->pageclass_sfx;? >">
< ?php
$this->subtemplatename = 'articles';
echo JLayoutHelper::render('joomla.content.category_default', $this);
? >
</div>
*/
?>

</div>