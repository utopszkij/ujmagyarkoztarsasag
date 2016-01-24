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

$user		= JFactory::getUser();
$userId		= $user->get('id');

$db			= JFactory::getDbo();
$query		= $db->getQuery(true);
$query->select('version AS icv, releasedate AS icd')->from('#__icagenda')->where('id = 3');
$db->setQuery($query);
$version	= $db->loadObject()->icv;
$date		= $db->loadObject()->icd;
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
				<div class="row-fluid">
					<div class="span6">
						<div class="icpanel" style="background-color:#FFFFFF; border: 1px solid #D4D4D4; padding:10px; border-radius: 10px;">
							<h2 style="font-size:2em; color: Gray; text-align: center">
								<?php echo JText::_('COM_ICAGENDA_PANEL_CONTRIBUTORS');?>
							</h2>
							<div>&nbsp;</div>
							<p style="margin:10px 30px; text-align:center; color: grey;">
								<i>&ldquo; <?php echo JText::_('COM_ICAGENDA_PANEL_THANKS_TEXT'); ?> &rdquo;</i>
							</p>
							<p class="small" style="margin:20px 0px; text-align:justify; color: DimGray;">
								Ervin Bizjak, Bong, Giuseppe Bosco, Carosouza, Davor Čolić, doorknob, Reinhard Ekker, elirezo, jedi, jowe3, JonxDuo, KISweb, kredo9, macedorl, Kai Metsävainio, mussool, NicoDeluxe, Rickard Norberg, Andrzej Opejda, Régis, Tom-Henning, Rikard Tømte Reitan, Vlad Shuh, Leland Vandervort, Wilfred van Dijk, Roland van Wanrooy, David White ...
							</p>
							<h3><?php echo JText::_('COM_ICAGENDA_PANEL_TRANSLATION');?></h3>
							<div style="margin-left: 20px; padding:0px; color: DimGray;">
	<img src='../media/mod_languages/images/ar.gif' alt="ar" class='iCflag' /> &nbsp;<b>Arabic (Unitag) :</b> haneen2013, fkinanah <br />
	<img src='../media/mod_languages/images/eu_es.gif' alt="eu_es" class='iCflag' /> &nbsp;<b>Basque (Spain) :</b> Bizkaitarra <br />
	<img src='../media/mod_languages/images/bg.gif' alt="bg-BG" class='iCflag' /> &nbsp;<b>Bulgarian (Bulgaria) :</b> bimbongr <br />
	<img src='../media/mod_languages/images/ca.gif' alt="ca" class='iCflag' /> &nbsp;<b>Catalan (Spain) :</b> Mussool, Figuerolero, riquib <br />
	<img src='../media/mod_languages/images/zh.gif' alt="zh-CN" class='iCflag' /> &nbsp;<b>Chinese (China) :</b> Foxyman <br />
	<img src='../media/mod_languages/images/tw.gif' alt="zh-TW" class='iCflag' /> &nbsp;<b>Chinese (Taiwan) :</b> jedi, hkce, rowdytang <br />
	<img src='../media/mod_languages/images/hr.gif' alt="hr" class='iCflag' /> &nbsp;<b>Croatian (Croatia) :</b> Davor Čolić, komir <br />
	<img src='../media/mod_languages/images/cz.gif' alt="cz" class='iCflag' /> &nbsp;<b>Czech (Czech Republic) :</b> Bong <br />
	<img src='../media/mod_languages/images/dk.gif' alt="dk" class='iCflag' /> &nbsp;<b>Danish (Denmark) :</b> olewolf.dk, hvitnov, torbenspetersen, poulfrom, AhmadHamid <br />
	<img src='../media/mod_languages/images/nl.gif' alt="nl-NL" class='iCflag' /> &nbsp;<b>Dutch (Netherlands) :</b> Molenwal1, AnneM, Mario Guagliardo, wfvdijk, Walldorff <br />
	<img src='../media/mod_languages/images/en.gif' alt="en-GB" class='iCflag' /> &nbsp;<b>English (United Kingdom) :</b> Lyr!C <br />
	<img src='../media/mod_languages/images/us.gif' alt="en-US" class='iCflag' /> &nbsp;<b>English (United States) :</b> Lyr!C <br />
	<img src='../media/mod_languages/images/eo.gif' alt="eo" class='iCflag' /> &nbsp;<b>Esperanto :</b> Anita_Dagmarsdotter, Amema <br />
	<img src='../media/mod_languages/images/et.gif' alt="et" class='iCflag' /> &nbsp;<b>Estonian (Estonia) :</b> Eraser, Reijo <br />
	<img src='../media/mod_languages/images/fi.gif' alt="fi-FI" class='iCflag' /> &nbsp;<b>Finnish (Finland) :</b> Kai Metsävainio <br />
	<img src='../media/mod_languages/images/fr.gif' alt="fr-FR" class='iCflag' /> &nbsp;<b>French (France) :</b> Lyr!C <br />
	<img src='../media/mod_languages/images/de.gif' alt="de-DE" class='iCflag' /> &nbsp;<b>German (Germany) :</b> grisuu, mPino, Wasilis, bmbsbr, chuerner, Proton_11, keraM <br />
	<img src='../media/mod_languages/images/el.gif' alt="el-GR" class='iCflag' /> &nbsp;<b>Greek (Greece) :</b> E.Gkana-D.Kontogeorgis (elinag), rinenweb, kost36, mbini, Wasilis <br />
	<img src='../media/mod_languages/images/hu.gif' alt="hu-HU" class='iCflag' /> &nbsp;<b>Hungarian (Hungary) :</b> Halilaci, magicf, Cerbo, mester93 <br />
	<img src='../media/mod_languages/images/it.gif' alt="it-IT" class='iCflag' /> &nbsp;<b>Italian (Italy) :</b> Giuseppe Bosco (giusebos) <br />
	<img src='../media/mod_languages/images/ja.gif' alt="ja-JP" class='iCflag' /> &nbsp;<b>Japanese (Japan) :</b> nagata, taimai908 <br />
	<img src='../media/mod_languages/images/lv.gif' alt="lv-LV" class='iCflag' /> &nbsp;<b>Latvian (Latvia) :</b> kredo9 <br />
	<img src='../media/mod_languages/images/lt.gif' alt="lt-LT" class='iCflag' /> &nbsp;<b>Lithuanian (Lithuania) :</b> ahxoohx <br />
	<img src='../media/mod_languages/images/icon-16-language.png' alt="lb-LU" class='iCflag' /> &nbsp;<b>Luxembourgish (Luxembourg) :</b> Superjhemp <br />
	<img src='../media/mod_languages/images/no.gif' alt="nb-NO" class='iCflag' /> &nbsp;<b>Norwegian Bokmål (Norway) :</b> Rikard Tømte Reitan (Rikrei) <br />
	<img src='../media/mod_languages/images/fa_ir.gif' alt="fa-IR" class='iCflag' /> &nbsp;<b>Persian (Iran) :</b> Arash Rezvani (al3n.nvy) <br />
	<img src='../media/mod_languages/images/pl.gif' alt="pl-PL" class='iCflag' /> &nbsp;<b>Polish (Poland) :</b> mbsrz, KISweb, gienio22, traktor, niewidzialny <br />
	<img src='../media/mod_languages/images/pt_br.gif' alt="pt-BR" class='iCflag' /> &nbsp;<b>Portuguese (Brazil) :</b> Carosouza, alxaraujo <br />
	<img src='../media/mod_languages/images/pt.gif' alt="pt-PT" class='iCflag' /> &nbsp;<b>Portuguese (Portugal) :</b> LFGM, macedorl, horus68, helfer <br />
	<img src='../media/mod_languages/images/ro.gif' alt="ro-RO" class='iCflag' /> &nbsp;<b>Romanian (Romania) :</b> hat, mester93 <br />
	<img src='../media/mod_languages/images/ru.gif' alt="ru-RU" class='iCflag' /> &nbsp;<b>Russian (Russia) :</b> nshash, MSV <br />
	<img src='../media/mod_languages/images/sr.gif' alt="sr-YU" class='iCflag' /> &nbsp;<b>Serbian (latin) :</b> Nenad Mihajlović <br />
	<img src='../media/mod_languages/images/sk.gif' alt="sk-SK" class='iCflag' /> &nbsp;<b>Slovak (Slovakia) :</b> ischindl, J.Ribarszki <br />
	<img src='../media/mod_languages/images/sl.gif' alt="sl-SI" class='iCflag' /> &nbsp;<b>Slovenian (Slovenia) :</b> erbi (Ervin Bizjak) <br />
	<img src='../media/mod_languages/images/es.gif' alt="es-ES" class='iCflag' /> &nbsp;<b>Spanish (Spain) :</b> elerizo, mPino, albertodg, adolf64, Goncatín, virem1, leoxordonez, claugardia, sterroso <br />
	<img src='../media/mod_languages/images/sv.gif' alt="sv-SE" class='iCflag' /> &nbsp;<b>Swedish (Sweden) :</b> Rickard Norberg (metska), Amema, kricke <br />
	<img src='../media/mod_languages/images/th.gif' alt="th-TH" class='iCflag' /> &nbsp;<b>Thai (Thailand) :</b> rattanachai.ha <br />
	<img src='../media/mod_languages/images/tr.gif' alt="tr-TR" class='iCflag' /> &nbsp;<b>Turkish (Turkey) :</b> harikalarkutusu, farukzeynep, kemalokmen <br />
	<img src='../media/mod_languages/images/uk.gif' alt="uk" class='iCflag' /> &nbsp;<b>Ukrainian (Ukraine) :</b> Vlad Shuh (slv54) <br />
							</div>
							<br />
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
								<b style="color:#cc0000;">iC</b><b style="color: #666666;">agenda<sup style="font-size:0.6em">&trade;</sup></b>&nbsp;<b style="font-size:0.5em;"></b>
							</h2>
						</div>
						<div>
							<h4>
								<?php echo JText::_('COM_ICAGENDA_INFORMATION') ?>
							</h4>
						</div>
						<div>&nbsp;</div>
						<div>&nbsp;</div>
						<div>&nbsp;</div>
						<div>&nbsp;</div>
						<div>&nbsp;</div>
						<div>&nbsp;</div>

						<h3><?php echo JText::_('iCagenda Team');?></h3>
						<p>
							<strong><?php echo JText::_('COM_ICAGENDA_PANEL_LEAD_DEVELOPER');?></strong><br />
							Cyril Rezé (Lyr!C) | <a href="http://www.joomlic.com" target="_blank">www.joomlic.com</a>
						</p>
						<p>
							<strong><?php echo JText::_('COM_ICAGENDA_PANEL_TEAM_1');?></strong><br>
							Giuseppe Bosco (giusebos) | <a href="http://www.newideasproject.com/" target="_blank">www.newideasproject.com</a>
						</p>
						<p>
							<strong><?php echo JText::_('COM_ICAGENDA_PANEL_TEAM_CODE_CONTRIBUTORS');?></strong>
							<div class="span12">
							Doorknob :
								<ul>
									<small>
									<li>Features</li>
									<li>Responsive Screen Threshold Widths (media css)</li>
									<li>jQuery.highlightToday.js (module calendar)</li>
									</small>
								</ul>
							</div>
							<div class="span12">
							Tom-Henning (MaW) :
								<ul>
									<small>
									<li>iCalcreator integration (Add to iCal/Outlook)</li>
									</small>
								</ul>
							</div>
						</p>
						<h3><?php echo JText::_('COM_ICAGENDA_VERSION');?></h3>
						<p>
							<?php echo $version ;?>
						</p>
						<h3><?php echo JText::_('COM_ICAGENDA_COPYRIGHT');?></h3>
						<p>
							© 2012 - <?php echo date("Y"); ?> Cyril Rezé / Jooml!C<br/>
							<a href="http://www.joomlic.com" target="_blank">www.Jooml!C.com</a>
						</p>
						<h3><?php echo JText::_('COM_ICAGENDA_LICENSE');?></h3>
						<p>
							<a href="http://www.gnu.org/licenses/gpl.html" target="_blank">GPLv3 or later</a>
						</p>
						<hr>
						<h3><?php echo JText::_('COM_ICAGENDA_LIBRARIES');?></h3>
						<p>
							<strong>Akeeba Live Update (ARS)</strong><br/>
							© Nicholas K. Dionysopoulos | <a href="https://www.akeebabackup.com" target="_blank">www.akeebabackup.com</a><br/>
							<small>Licensed under <a href="http://www.gnu.org/copyleft/lesser.html" target="_blank">GNU LGPLv3</a> or later.</small><br/>
						</p>
						<p>
							<strong>Timepicker jQuery addon</strong><br/>
							© Trent Richardson | <a href="http://trentrichardson.com" target="_blank">trentrichardson.com</a><br/>
							<small>Project licensed under the <a href="http://trentrichardson.com/Impromptu/MIT-LICENSE.txt" target="_blank">MIT</a> or <a href="http://trentrichardson.com/Impromptu/GPL-LICENSE.txt" target="_blank">GPL</a> licenses.</small><br/>
						</p>
						<p>
							<strong>TipTip jQuery plugin</strong><br/>
							© Drew Wilson | <a href="http://www.drewwilson.com" target="_blank">www.drewwilson.com</a><br/>
							<small>Dual licensed under the <a href="http://www.opensource.org/licenses/mit-license.php" target="_blank">MIT</a> and <a href="http://www.gnu.org/licenses/gpl.html" target="_blank">GPL</a> licenses.</small><br/>
						</p>
						<p>
							<strong>Google Maps™</strong><br/>
							© Google Inc. | <a href="https://developers.google.com/maps/terms" target="_blank">Google Maps/Google Earth APIs Terms of Service</a><br/>
							<small>Google™ and Google Maps™ are registered trademarks of Google Inc.</small><br/>
						</p>
						<p>
							<strong>and of course... Joomla!</strong><br/>
							<a href="http://www.joomla.org" target="_blank">www.joomla.org</a><br/>
						</p>

					</div>
				</div>
			</div>
		</div>

		<div class="row-fluid">
			<div class="span12">
				<tbody>
					<table style="border: 0px;">
						<tr>
							<td>
								<a href="http://icagenda.joomlic.com/resources/translations" target="_blank" class="btn">
									<?php echo JText::_('COM_ICAGENDA_PANEL_TRANSLATION_PACKS_DONWLOAD');?>
								</a>
							</td>
							<td>
								<a href='http://www.joomlic.com/forum/icagenda'  target="_blank" class="btn">
									<?php echo JText::_('COM_ICAGENDA_PANEL_HELP_FORUM'); ?>
								</a>
							</td>
						</tr>
					</table>
				</tbody>
			</div>
		</div>
	</div>

	<!-- footer -->
	<div>
		<div class="row-fluid">
			<div class="span12">
				<hr>
				<div class="row-fluid">
					<div class="span9">
						Copyright ©2012-<?php echo date("Y"); ?> joomlic.com -&nbsp;
						<?php echo JText::_('COM_ICAGENDA_PANEL_COPYRIGHT');?>&nbsp;<a href="http://extensions.joomla.org/extensions/calendars-a-events/events/events-management/22013" target="_blank">Joomla! Extensions Directory</a>.
						<br />
						<br />
					</div>
					<div class="span3" style="text-align: right">
						<a href='http://www.joomlic.com' target='_blank'>
							<img src="../media/com_icagenda/images/logo_joomlic.png" alt="JoomliC" border="0"/>
						</a>
						<br />
						<i><b><?php echo JText::_('COM_ICAGENDA_PANEL_SITE_VISIT');?>&nbsp;<a href='http://www.joomlic.com' target='_blank'>www.joomlic.com</a></b></i>
					</div>
				</div>
			</div>
		</div>
	</div>
