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

defined('_JEXEC') or die('Restricted Access'); ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

	<?php foreach ($this->items as $key => $item): ?>

	<url>
		<loc><?php echo $this->escape($item->link); ?></loc>

		<priority>0.8</priority>

	</url>

	<?php endforeach; ?>

</urlset>