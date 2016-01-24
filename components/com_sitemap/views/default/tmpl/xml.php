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
	<?php if (!empty($this->items)): ?>
		<?php foreach($this->items as $key => $link): ?>
			<url>

				<loc><?php echo $this->url . $this->escape($link) . "/"; ?></loc>

				<priority><?php echo $this->sitemap->priority; ?></priority>

				<changefreq><?php echo $this->sitemap->update_freq; ?></changefreq>
		
			</url>
		<?php endforeach; ?>
	<?php endif; ?>
</urlset>