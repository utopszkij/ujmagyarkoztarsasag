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

defined('_JEXEC') or die('Restricted Access');

?>

<div>

	<?php if (!empty($this->items)): ?>
		<h1><?php echo $this->sitemap->title; ?></h1>
			<?php foreach ($this->items as $sitemaps): ?>
				<ul>
					<?php foreach ($sitemaps as $item): ?>
						<li>
							<a href="<?php echo $item->link ?>"><?php echo $this->escape(ucwords($item->alias)); ?></a>
						</li>
					<?php endforeach; ?>
				</ul>
				<br />
			<?php endforeach; ?>

	<?php endif; ?>

</div>