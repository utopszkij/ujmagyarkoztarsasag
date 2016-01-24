<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Templates.Base Template Joomla 3
 */

defined('_JEXEC') or die;

function modChrome_well($module, &$params, &$attribs)
{
	if ($module->content)
	{
		echo "<div class=\"well " . htmlspecialchars($params->get('moduleclass_sfx')) . "\">";
		if ($module->showtitle)
		{
			echo "<h3 class=\"page-header\">" . $module->title . "</h3>";
		}
		echo $module->content;
		echo "</div>";
	}
}

function modChrome_specialgrey($module, &$params, &$attribs)
{
	if ($module->content)
	{
		echo "<div class=\"specialgrey " . htmlspecialchars($params->get('moduleclass_sfx')) . "\">";
		if ($module->showtitle)
		{
			echo "<h3 class=\"page-header\">" . $module->title . "</h3>";
		}
		echo "<div class=\"module-content\">" . $module->content . "</div>";
		echo "</div>";
	}
}

function modChrome_specialblue($module, &$params, &$attribs)
{
	if ($module->content)
	{
		echo "<div class=\"specialblue " . htmlspecialchars($params->get('moduleclass_sfx')) . "\">";
		if ($module->showtitle)
		{
			echo "<h3 class=\"page-header\">" . $module->title . "</h3>";
		}
		echo "<div class=\"module-content\">" . $module->content . "</div>";
		echo "</div>";
	}
}

function modChrome_specialred($module, &$params, &$attribs)
{
	if ($module->content)
	{
		echo "<div class=\"specialred " . htmlspecialchars($params->get('moduleclass_sfx')) . "\">";
		if ($module->showtitle)
		{
			echo "<h3 class=\"page-header\">" . $module->title . "</h3>";
		}
		echo "<div class=\"module-content\">" . $module->content . "</div>";
		echo "</div>";
	}
}

function modChrome_specialgold($module, &$params, &$attribs)
{
	if ($module->content)
	{
		echo "<div class=\"specialgold " . htmlspecialchars($params->get('moduleclass_sfx')) . "\">";
		if ($module->showtitle)
		{
			echo "<h3 class=\"page-header\">" . $module->title . "</h3>";
		}
		echo "<div class=\"module-content\">" . $module->content . "</div>";
		echo "</div>";
	}
}

?>