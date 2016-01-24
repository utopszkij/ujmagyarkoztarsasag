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
 * @version     3.5.6 2015-06-23
 * @since       2.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

jimport( 'joomla.filesystem.path' );

JHtml::_('behavior.framework');
JHtml::_('behavior.modal');

$app = JFactory::getApplication();
$document = JFactory::getDocument();

// Access Administration Registrations check.
if (JFactory::getUser()->authorise('icagenda.access.themes', 'com_icagenda'))
{
	// Check Theme Packs Compatibility
	if (class_exists('icagendaTheme')) icagendaTheme::checkThemePacks();

	$user	= JFactory::getUser();
	$userId	= $user->get('id');

	$params = JComponentHelper::getParams( 'com_icagenda' );
	$version = $params->get('version');
	?>

<?php if (!empty( $this->sidebar)) : ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
<?php else : ?>
	<div id="j-main-container">
<?php endif;?>

		<!-- Begin Content -->
		<div class="row-fluid">
			<div class="span12">
				<div class="span6">
					<div style="background-color:#FFFFFF; border: 1px solid #D4D4D4; padding:30px; border-radius: 10px;">
						<form enctype="multipart/form-data" action="index.php" method="post" name="adminForm" id="themes-form" class="form-validate">
							<?php
							if (isset($this->require_ftp)) {
							echo iCagendaFileUpload::renderFTPaccess();
							}
							?>
							<div class="control-group">
								<label for="install_package"><b><?php echo JText::_( 'COM_ICAGENDA_UPLOAD_THEME_PACKAGE_FILE' ); ?></b></label>
								<div class="controls">
									<input type="file" id="sfile-upload" class="input" name="Filedata" />
									<button onclick="submitbutton()" class="btn btn-primary" id="upload-submit">
	<?php if(version_compare(JVERSION, '3.0', 'lt')) : ?>
										<?php echo JText::_( 'COM_ICAGENDA_UPLOAD_AND_INSTALL' ); ?>
	<?php else : ?>
										<i class="icon-upload icon-white"></i> <?php echo JText::_( 'COM_ICAGENDA_UPLOAD_AND_INSTALL' ); ?>
	<?php endif; ?>
									</button>
								</div>
							</div>
							<input type="hidden" name="type" value="" />
							<input type="hidden" name="option" value="com_icagenda" />
							<input type="hidden" name="task" value="themes.themeinstall" />
							<?php echo JHTML::_( 'form.token' ); ?>
						</form>
					</div>
				</div>
				<div class="span1">
				</div>
				<div class="span5">
					<div style="float:right; padding:0px 0px 0px 20px;">
						<img src="../media/com_icagenda/images/logo_icagenda.png" alt="logo_icagenda" />
					</div>
					<div>
						<h2 style="font-size:2em;">
							<b style="color:#cc0000;">iC</b><b style="color: #666666;">agenda<sup style="font-size:0.6em">&trade;</sup></b><?php echo $version ;?>
						</h2>
					</div>
					<div>
						<h4>
							<?php echo JText::_('COM_ICAGENDA_THEME_MANAGER') ?> v1
						</h4>
					</div>
					<br/>
				</div>
			</div>
		</div>
		<div class="clearfix"> </div>

		<div class="row-fluid">
			<h2><?php echo JText::_('COM_ICAGENDA_THEMES_LIST_TITLE'); ?></h2>
			<div class="span12 small" style="margin-left: 0px">
				<?php

				$url=JPATH_SITE.DS.'components'.DS.'com_icagenda'.DS.'themes'.DS.'packs';
				$urlxml=JPATH_SITE.DS.'components'.DS.'com_icagenda'.DS.'themes/';

				$nb_themes = 0;

				function url_exists($url) {
					$a_url = parse_url($url);
					if (!isset($a_url['port'])) $a_url['port'] = 80;
					$errno = 0;
					$errstr = '';
					$timeout = 30;
					if(isset($a_url['host']) && $a_url['host']!=gethostbyname($a_url['host'])){
						$fid = fsockopen($a_url['host'], $a_url['port'], $errno, $errstr, $timeout);
						if (!$fid) return false;
						$page = isset($a_url['path']) ?$a_url['path']:'';
						$page .= isset($a_url['query'])?'?'.$a_url['query']:'';
						fputs($fid, 'HEAD '.$page.' HTTP/1.0'."\r\n".'Host: '.$a_url['host']."\r\n\r\n");
						$head = fread($fid, 4096);
						fclose($fid);
						return preg_match('#^HTTP/.*\s+[200|302]+\s#i', $head);
					} else {
						return false;
					}
				}

				if($dossier = opendir($url)) {
					while(false !== ($pack = readdir($dossier))) {
						if($pack != '.' && $pack != '..' && $pack != 'index.php' && $pack != 'index.html' && $pack != '.DS_Store' && $pack!='.thumbs') {
							$nb_themes++; // On incrémente le compteur de 1
							$xml = '.xml';
							$themeurl = $urlxml.$pack.$xml;

							$dom = new DomDocument;
							$dom->load($themeurl);

							$getthemeUpdate = $dom->getElementsByTagName('themeUpdate');
							foreach ($getthemeUpdate AS $themeUpdate)
							$themeUpdate = $themeUpdate->firstChild->nodeValue;
							$urltheme = $themeUpdate.'/'.$pack.'/update.xml';
							$unknown = JText::_('COM_ICAGENDA_THEME_UNKNOWN');

							// Test si fichier de mise à jour
							$urlex = $urltheme;

							if (url_exists($urlex))
							{
								// Récupération données fichier distant de MàJ
								$update = new DomDocument;
								$update->load($urltheme);

								$getUpdateversion = $update->getElementsByTagName('version');
								$getUpdatedownload = $update->getElementsByTagName('download');
								foreach ($getUpdateversion AS $Updatevers)
								foreach ($getUpdatedownload AS $download)
								$updateVersion = $Updatevers->firstChild->nodeValue;
								$updateDownload = $download->firstChild->nodeValue;
							}
							else
							{
								$updateVersion = $unknown;
								$updateDownload = '#';
							}


//							$getUpdatestatus = $dom->getElementsByTagName('status');

							// Récupération données fichier manifest install
							$getthemename = $dom->getElementsByTagName('name');
							$getversion = $dom->getElementsByTagName('version');
							$getcreationDate = $dom->getElementsByTagName('creationDate');
							$getauthor = $dom->getElementsByTagName('author');
							$getauthorEmail = $dom->getElementsByTagName('authorEmail');
							$getauthorWebsite = $dom->getElementsByTagName('authorWebsite');
							$getauthorUrl = $dom->getElementsByTagName('authorUrl');
							$getdescription = $dom->getElementsByTagName('description');

							// Conversion des données
							foreach ($getthemename AS $name)
//							foreach ($getUpdatestatus AS $status)
							foreach ($getversion AS $version)
							foreach ($getcreationDate AS $creationDate)
							foreach ($getauthor AS $author)
							foreach ($getauthorEmail AS $authorEmail)
							foreach ($getauthorWebsite AS $authorWebsite)
							foreach ($getauthorUrl AS $authorUrl)
							foreach ($getdescription AS $description)

							$authorWebsitetest = $authorWebsite->firstChild->nodeValue;

							// Affichage fiches Themes
							echo '<div class="span3" style="padding: 10px; margin:10px 20px 10px 0px; background: #D9D9D9; border-radius:10px;">';

								// Affichage Titre et Nom
								echo '<div style="text-align:center"><h4>' . $name->firstChild->nodeValue . ' <br><small>[&nbsp;<span style="color:grey">' . $pack . '</span>&nbsp;]</small></h4></div>';

								//Image Theme
								$urlimg		= '../components/com_icagenda/themes/packs';
								$thumb		= $urlimg.'/'.$pack.'/images/'.$pack.'_thumbnail.png';
								$preview	= $urlimg.'/'.$pack.'/images/'.$pack.'_preview.png';
								if (file_exists($thumb))
								{
									$img	= '<img width=280px height=160px src="'.$thumb.'" alt="">';
									if (file_exists($preview))
									{
										$imgtheme	= '<div style="text-align:center; max-width=280px"><a href="'.$preview.'" class="modal" title="'.JText::_('COM_ICAGENDA_CLICK_TO_ENLARGE').'">'.$img.'</a></div>';
									}
								} else {
									$imgtheme ='<div style="text-align:center; max-width=280px">'.JText::_('COM_ICAGENDA_THEME_NO_PREVIEW').'</div>';
								}

								echo $imgtheme;

								// Affichage Description
								echo '<p><div style="text-align:justify;"><i>' . $description->firstChild->nodeValue . '</i></div>';

								// Affichage Auteur
								echo '<div>'.JText::_('COM_ICAGENDA_THEME_AUTHOR').' : <a href="mailto:'.$authorEmail->firstChild->nodeValue.'">' . $author->firstChild->nodeValue . '</a></div>';

								// Affichage Site Auteur
								$authorWebsite = $authorWebsite->firstChild->nodeValue;
								if ($authorWebsite != NULL) {
									echo '<div>'.JText::_('COM_ICAGENDA_THEME_AUTHOR_WEBSITE').' : <a href="'.$authorUrl->firstChild->nodeValue.'" target="_blank">' . $authorWebsite . '</a></div>';
								}

								// Affichage Version installée
								echo '<div>'.JText::_('COM_ICAGENDA_THEME_INSTALLED_VERSION').' : ' . $version->firstChild->nodeValue . '</div>';

								// Affichage Dernière version publiée
								if (($updateVersion > $version->firstChild->nodeValue) && ($updateVersion != $unknown)) {
									echo '<div>'.JText::_('COM_ICAGENDA_THEME_LATEST_VERSION').' : ' . $updateVersion . '</div></p>';
								}

								echo '<p></p><div style="display:block; margin-left:auto; margin-right: auto;">';

									if (($updateVersion > $version->firstChild->nodeValue) && ($updateVersion != $unknown)) {
										echo '<a href="'.$updateDownload.'" target="_blank"><div class="btn_update">'.JText::_('COM_ICAGENDA_THEME_UPDATE').' ' . $updateVersion . ' !</div></a>';
									} elseif ($updateVersion == $unknown) {
										echo '<div style="text-align:center; background:#333333; padding:5px; border-radius:5px; color:#FFFFFF;">'.JText::_('COM_ICAGENDA_THEME_AUTHOR_CONTACT').'</div>';
									} else {
										echo '<div style="text-align:center; background:#FFFFFF; padding:5px; border-radius:5px;">'.JText::_('COM_ICAGENDA_THEME_LATEST').'</div>';
									}

								echo '</div>';
							echo '</div>';
							} // On ferme le if (qui permet de ne pas afficher index.php, etc.)

						} // On termine la boucle

						echo '<div style="clear: both;"></div>';

						echo '<div>&nbsp;</div>';

						echo '<div>' . JText::_('COM_ICAGENDA_THEME_NB_THEMES_1') . '<strong> ' . $nb_themes . ' </strong>' . JText::_('COM_ICAGENDA_THEME_NB_THEMES_2') .'</div>';
						echo '<div>&nbsp;</div>';

						closedir($dossier);

						} else {
							echo 'ERROR: Folder not opened!';
						}
						?>

			</div>

			<div class="span12" style="margin-left: 0px">
				<div class="span6">
					<div>
						<a href="http://icagenda.joomlic.com/resources/translations" target="_blank" class="btn"><?php echo JText::_('COM_ICAGENDA_PANEL_TRANSLATION_PACKS_DONWLOAD');?></a>
						<a href='http://www.joomlic.com/forum/icagenda'  target="_blank" class="btn"><?php echo JText::_('COM_ICAGENDA_PANEL_HELP_FORUM'); ?></a>
					</div>
				</div>
				<div class="span6">
				</div>
			</div>
		</div>
		<div class="clearfix"> </div>
	</div>


	<div class="row-fluid">
		<div class="span12">
		<hr>
			<div class="span9">
				Copyright ©2012-<?php echo date("Y"); ?> joomlic.com -&nbsp;
				<?php echo JText::_('COM_ICAGENDA_PANEL_COPYRIGHT');?>&nbsp;<a href="http://extensions.joomla.org/extensions/calendars-a-events/events/events-management/22013" target="_blank">Joomla! Extensions Directory</a>.
				<br />
				<br />
			</div>
			<div class="span3" style="text-align: right">
				<a href='http://www.joomlic.com' target='_blank'><img src="../media/com_icagenda/images/logo_joomlic.png" alt="JoomliC" border="0"/></a>
				<br />
				<i><b><?php echo JText::_('COM_ICAGENDA_PANEL_SITE_VISIT');?>&nbsp;<a href='http://www.joomlic.com' target='_blank'>www.joomlic.com</a></b></i>
			</div>
		</div>
	</div>

	<div class="clearfix"> </div>

	<?php
	// Joomla 2.5 CSS
	if (version_compare(JVERSION, '3.0', 'lt'))
	{
		JHtml::stylesheet('com_icagenda/template.j25.css', false, true);
		JHtml::stylesheet('com_icagenda/icagenda-back.j25.css', false, true);
	}
}
else
{
	$app->enqueueMessage(JText::_('JERROR_ALERTNOAUTHOR'), 'warning');
	$app->redirect(htmlspecialchars_decode('index.php?option=com_icagenda&view=icagenda'));
}
