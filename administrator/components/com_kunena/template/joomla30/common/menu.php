<?php
/**
 * Kunena Component
 * @package Kunena.Administrator.Template.Joomla30
 * @subpackage Common
 *
 * @copyright (C) 2008 - 2014 Kunena Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.org
 **/
defined ( '_JEXEC' ) or die ();
$view = JRequest::getCmd('view', 'cpanel');
?>
<!-- Main navigation -->
<ul class="nav nav-list">
	<li<?php if ($view == 'cpanel') echo ' class="active"';?>><a href="<?php echo JRoute::_('index.php?option=com_kunena'); ?>"><i class="icon-dashboard"></i> <?php echo JText::_('COM_KUNENA_MENU_DESC_DASHBOARD'); ?></a></li>
	<li<?php if ($view == 'categories' || $view == 'category') echo ' class="active"';?>><a href="<?php echo JRoute::_('index.php?option=com_kunena&view=categories'); ?>"><i class="icon-list-view"></i> <?php echo JText::_('COM_KUNENA_C_FORUM'); ?></a></li>
	<li<?php if ($view == 'users' || $view == 'user') echo ' class="active"';?>><a href="<?php echo JRoute::_('index.php?option=com_kunena&view=users'); ?>"><i class="icon-user"></i> <?php echo JText::_('COM_KUNENA_C_USER'); ?></a></li>
	<li<?php if ($view == 'attachments' || $view == 'attachment') echo ' class="active"';?>><a href="<?php echo JRoute::_('index.php?option=com_kunena&view=attachments'); ?>"><i class="icon-folder-open"></i> <?php echo JText::_('COM_KUNENA_MENU_DESC_FILEMANAGER'); ?></a></li>
	<li<?php if ($view == 'smilies' || $view == 'smiley') echo ' class="active"';?>><a href="<?php echo JRoute::_('index.php?option=com_kunena&view=smilies'); ?>"><i class="icon-thumbs-up"></i> <?php echo JText::_('COM_KUNENA_EMOTICONS_EMOTICON_MANAGER'); ?></a></li>
	<li<?php if ($view == 'ranks' || $view == 'rank') echo ' class="active"';?>><a href="<?php echo JRoute::_('index.php?option=com_kunena&view=ranks'); ?>"><i class="icon-star-2"></i> <?php echo JText::_('COM_KUNENA_A_RANK_MANAGER'); ?></a></li>
	<li<?php if ($view == 'templates' || $view == 'template') echo ' class="active"';?>><a href="<?php echo JRoute::_('index.php?option=com_kunena&view=templates'); ?>"><i class="icon-color-palette"></i> <?php echo JText::_('COM_KUNENA_A_TEMPLATE_MANAGER'); ?></a></li>
	<li<?php if ($view == 'config') echo ' class="active"';?>><a href="<?php echo JRoute::_('index.php?option=com_kunena&view=config'); ?>"><i class="icon-wrench"></i> <?php echo JText::_('COM_KUNENA_MENU_DESC_CONFIGURATION'); ?></a></li>
	<li<?php if ($view == 'plugins') echo ' class="active"';?>><a href="<?php echo JRoute::_('index.php?option=com_kunena&view=plugins'); ?>"><i class="icon-cube"></i> <?php echo JText::_('COM_KUNENA_PLUGIN_MANAGER'); ?></a></li>
	<li<?php if ($view == 'tools') echo ' class="active"';?>><a href="<?php echo JRoute::_('index.php?option=com_kunena&view=tools'); ?>"><i class="icon-tools"></i> <?php echo JText::_('COM_KUNENA_A_VIEW_TOOLS'); ?></a></li>
	<li<?php if ($view == 'trash') echo ' class="active"';?>><a href="<?php echo JRoute::_('index.php?option=com_kunena&view=trash'); ?>"><i class="icon-trash"></i> <?php echo JText::_('COM_KUNENA_TRASH_VIEW'); ?></a></li>
</ul>
<!-- /Main navigation -->
