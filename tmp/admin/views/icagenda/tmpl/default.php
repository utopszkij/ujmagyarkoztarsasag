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
 * @version     3.5.10 2015-08-15
 * @since       1.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

// Check Theme Packs Compatibility (to be changed to a little note button with modal)
//if (class_exists('icagendaTheme')) icagendaTheme::checkThemePacks();

$user		= JFactory::getUser();
$userId		= $user->get('id');

$params		= JComponentHelper::getParams( 'com_icagenda' );
$version	= $params->get('version');
$icsys		= $params->get('icsys');
$translator	= JText::_('COM_ICAGENDA_TRANSLATOR');

if (version_compare(phpversion(), '5.3.10', '<'))
{
	$JoomlaRecommended = '5.4 +';

	// Get Application
	$app = JFactory::getApplication();

	$icon_warning = (version_compare(JVERSION, '3.0', 'lt')) ? '' : '<span class="icon-warning"></span>';

	$php_warning_msg = '<strong> ' . JText::sprintf('COM_ICAGENDA_YOUR_PHP_VERSION_IS', phpversion()) . '</strong><br />';
	$php_warning_msg.= JText::sprintf('COM_ICAGENDA_PHP_VERSION_JOOMLA_RECOMMENDED', $JoomlaRecommended);
	$php_warning_msg.= ' ( ' . JText::_('IC_READMORE') . ': ';
	$php_warning_msg.= '<a href="http://www.joomla.org/technical-requirements.html"';
	$php_warning_msg.= ' target="_blank">http://www.joomla.org/technical-requirements.html</a> )<br />';
	$php_warning_msg.= JText::_('COM_ICAGENDA_PHP_VERSION_ICAGENDA_RECOMMENDATION');

	$app->enqueueMessage( $icon_warning . $php_warning_msg, 'error' );
}
?>
<div id="j-main-container">
	<?php JHtml::_('behavior.modal'); ?>
	<!-- Start Content -->
	<div class="row-fluid icpanel">
		<div class="span12">
			<div class="row-fluid">
				<div class="span6">
					<div class="row-fluid">
						<?php if ( $user->authorise('icagenda.access.categories', 'com_icagenda') ) : ?>
						<div class="span6" style="text-align: center">
							<table>
								<tbody>
									<tr>
										<td colspan="2">
											<h3><?php echo JText::_('COM_ICAGENDA_TITLE_CATEGORIES'); ?></h3>
										</td>
									</tr>
									<tr>
										<td>
											<div class="icon right">
												<a href="index.php?option=com_icagenda&view=categories">
													<?php if ($user->authorise('icagenda.access.categories', 'com_icagenda')) : ?>
														<img alt=""
															src="../media/com_icagenda/images/all_cats-48.png">
														<span class="iconText">
															<?php echo JText::_( 'COM_ICAGENDA_PANEL_CATEGORY' ); ?>
														</span>
													<?php else : ?>
														<img alt="<?php echo JText::_( 'JERROR_ALERTNOAUTHOR' ); ?>"
															src="../media/com_icagenda/images/panel_denied/all_cats-48.png">
														<span class="iconText denied">
															<?php echo JText::_( 'COM_ICAGENDA_PANEL_CATEGORY' ); ?>
														</span>
													<?php endif; ?>
												</a>
											</div>
										</td>
										<td>
											<div class="icon left">
												<a href="index.php?option=com_icagenda&view=category&layout=edit">
													<?php if ($user->authorise('icagenda.access.categories', 'com_icagenda')) : ?>
														<img alt=""
															src="../media/com_icagenda/images/new_cat-48.png">
														<span class="iconText">
															<?php echo JText::_( 'COM_ICAGENDA_PANEL_NEW_CATEGORY' ); ?>
														</span>
													<?php else : ?>
														<img alt="<?php echo JText::_( 'JERROR_ALERTNOAUTHOR' ); ?>"
															src="../media/com_icagenda/images/panel_denied/new_cat-48.png">
														<span class="iconText denied">
															<?php echo JText::_( 'COM_ICAGENDA_PANEL_NEW_CATEGORY' ); ?>
														</span>
													<?php endif; ?>
												</a>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<?php endif; ?>
						<?php if ( $user->authorise('icagenda.access.events', 'com_icagenda') ) : ?>
						<div class="span6" style="text-align: center">
				    		<table>
				    			<tbody>
				    				<tr>
				    					<td colspan="2">
											<h3><?php echo JText::_('COM_ICAGENDA_TITLE_EVENTS'); ?></h3>
										</td>
									</tr>
				    				<tr>
	 				   					<td>
											<div class="icon right">
												<a href="index.php?option=com_icagenda&view=events">
													<?php if ($user->authorise('icagenda.access.events', 'com_icagenda')) : ?>
														<img alt=""
															src="../media/com_icagenda/images/all_events-48.png">
														<span class="iconText">
															<?php echo JText::_( 'COM_ICAGENDA_PANEL_EVENTS' ); ?>
														</span>
													<?php else : ?>
														<img alt="<?php echo JText::_( 'JERROR_ALERTNOAUTHOR' ); ?>"
															src="../media/com_icagenda/images/panel_denied/all_events-48.png">
														<span class="iconText denied">
															<?php echo JText::_( 'COM_ICAGENDA_PANEL_EVENTS' ); ?>
														</span>
													<?php endif; ?>
												</a>
											</div>
										</td>
	 				   					<td>
											<div class="icon left">
												<a href="index.php?option=com_icagenda&view=event&layout=edit">
													<?php if ($user->authorise('icagenda.access.events', 'com_icagenda')) : ?>
														<img alt=""
															src="../media/com_icagenda/images/new_event-48.png">
														<span class="iconText">
															<?php echo JText::_( 'COM_ICAGENDA_PANEL_NEW_EVENT' ); ?>
														</span>
													<?php else : ?>
														<img alt="<?php echo JText::_( 'JERROR_ALERTNOAUTHOR' ); ?>"
															src="../media/com_icagenda/images/panel_denied/new_event-48.png">
														<span class="iconText denied">
															<?php echo JText::_( 'COM_ICAGENDA_PANEL_NEW_EVENT' ); ?>
														</span>
													<?php endif; ?>
												</a>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<?php endif; ?>
					</div>

					<div class="row-fluid">
						<?php if ( $user->authorise('icagenda.access.registrations', 'com_icagenda')
								|| $user->authorise('icagenda.access.newsletter', 'com_icagenda') ) : ?>
						<div class="span6" style="text-align: center">
			    			<table>
					    		<tbody>
				    				<tr>
				    					<td colspan="2">
											<h3><?php echo JText::_('COM_ICAGENDA_TITLE_REGISTRATION'); ?></h3>
										</td>
									</tr>
				    				<tr>
	 				   					<td>
											<div class="icon right">
												<a href="index.php?option=com_icagenda&view=registrations">
													<?php if ($user->authorise('icagenda.access.registrations', 'com_icagenda')) : ?>
														<img alt=""
															src="../media/com_icagenda/images/registration-48.png">
														<span class="iconText">
															<?php echo JText::_( 'COM_ICAGENDA_PANEL_REGISTRATION' ); ?>
														</span>
													<?php else : ?>
														<img alt="<?php echo JText::_( 'JERROR_ALERTNOAUTHOR' ); ?>"
															src="../media/com_icagenda/images/panel_denied/registration-48.png">
														<span class="iconText denied">
															<?php echo JText::_( 'COM_ICAGENDA_PANEL_REGISTRATION' ); ?>
														</span>
													<?php endif; ?>
												</a>
											</div>
										</td>
	 				   					<td>
											<div class="icon left">
												<a href="index.php?option=com_icagenda&view=mail&layout=edit">
													<?php if ($user->authorise('icagenda.access.newsletter', 'com_icagenda')) : ?>
														<img alt=""
															src="../media/com_icagenda/images/newsletter-48.png">
														<span class="iconText">
															<?php echo JText::_( 'COM_ICAGENDA_PANEL_NEWSLETTER' ); ?>
														</span>
													<?php else : ?>
														<img alt="<?php echo JText::_( 'JERROR_ALERTNOAUTHOR' ); ?>"
															src="../media/com_icagenda/images/panel_denied/newsletter-48.png">
														<span class="iconText denied">
															<?php echo JText::_( 'COM_ICAGENDA_PANEL_NEWSLETTER' ); ?>
														</span>
													<?php endif; ?>
												</a>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<?php endif; ?>
						<?php if ( $user->authorise('icagenda.access.customfields', 'com_icagenda')
								|| $user->authorise('icagenda.access.features', 'com_icagenda') ) : ?>
						<div class="span6" style="text-align: center">
				    		<table>
				    			<tbody>
				    				<tr>
				    					<td colspan="2">
											<h3><?php echo JText::_('COM_ICAGENDA_ADDITIONALS_LABEL'); ?></h3>
										</td>
									</tr>
				    				<tr>
	 				   					<td>
											<div class="icon right">
												<a href="index.php?option=com_icagenda&view=customfields">
													<?php if ($user->authorise('icagenda.access.customfields', 'com_icagenda')) : ?>
														<img alt=""
															src="../media/com_icagenda/images/customfields-48.png" />
														<span class="iconText">
															<?php echo JText::_( 'COM_ICAGENDA_PANEL_CUSTOMFIELDS' ); ?>
														</span>
													<?php else : ?>
														<img alt="<?php echo JText::_( 'JERROR_ALERTNOAUTHOR' ); ?>"
															src="../media/com_icagenda/images/panel_denied/customfields-48.png" />
														<span class="iconText denied">
															<?php echo JText::_( 'COM_ICAGENDA_PANEL_CUSTOMFIELDS' ); ?>
														</span>
													<?php endif; ?>
												</a>
											</div>
										</td>
	 				   					<td>
											<div class="icon left">
												<a href="index.php?option=com_icagenda&view=features">
													<?php if ($user->authorise('icagenda.access.features', 'com_icagenda')) : ?>
														<img alt=""
															src="../media/com_icagenda/images/features-48.png">
														<span class="iconText">
															<?php echo JText::_( 'COM_ICAGENDA_PANEL_FEATURES' ); ?>
														</span>
													<?php else : ?>
														<img alt="<?php echo JText::_( 'JERROR_ALERTNOAUTHOR' ); ?>"
															src="../media/com_icagenda/images/panel_denied/features-48.png">
														<span class="iconText denied">
															<?php echo JText::_( 'COM_ICAGENDA_PANEL_FEATURES' ); ?>
														</span>
													<?php endif; ?>
												</a>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<?php endif; ?>
					</div>

					<div class="row-fluid">
						<?php if ( $user->authorise('core.admin', 'com_icagenda')
								|| $user->authorise('icagenda.access.themes', 'com_icagenda') ) : ?>
						<div class="span6" style="text-align: center">
			    			<table>
					    		<tbody>
				    				<tr>
				    					<td colspan="2">
											<h3><?php echo JText::_('COM_ICAGENDA_GLOBAL_PARAMS_LABEL'); ?></h3>
										</td>
									</tr>
				    				<tr>
	 				   					<td>
											<div class="icon right">
												<?php if(version_compare(JVERSION, '3.0', 'ge')) : ?>
													<a href="index.php?option=com_config&view=component&component=com_icagenda&path=&return=<?php echo base64_encode(JURI::getInstance()->toString()) ?>">
												<?php else : ?>
													<a href="index.php?option=com_config&view=component&component=com_icagenda&path=&tmpl=component"
														class="modal"
														rel="{handler: 'iframe', size: {x: 870, y: 550}}">
												<?php endif; ?>
													<?php if ($user->authorise('core.admin', 'com_icagenda')) : ?>
														<img alt=""
															src="../media/com_icagenda/images/global_options-48.png">
														<span class="iconText">
															<?php echo JText::_( 'JTOOLBAR_OPTIONS' ); ?>
														</span>
													<?php else : ?>
														<img alt="<?php echo JText::_( 'JERROR_ALERTNOAUTHOR' ); ?>"
															src="../media/com_icagenda/images/panel_denied/global_options-48.png">
														<span class="iconText denied">
															<?php echo JText::_( 'JTOOLBAR_OPTIONS' ); ?>
														</span>
													<?php endif; ?>
												</a>
											</div>
										</td>
	 				   					<td>
											<div class="icon left">
												<a href="index.php?option=com_icagenda&view=themes">
													<?php if ($user->authorise('icagenda.access.themes', 'com_icagenda')) : ?>
														<img alt=""
															src="../media/com_icagenda/images/themes-48.png">
														<span class="iconText">
															<?php echo JText::_( 'COM_ICAGENDA_PANEL_THEMES' ); ?>
														</span>
													<?php else : ?>
														<img alt="<?php echo JText::_( 'JERROR_ALERTNOAUTHOR' ); ?>"
															src="../media/com_icagenda/images/panel_denied/themes-48.png">
														<span class="iconText denied">
															<?php echo JText::_( 'COM_ICAGENDA_PANEL_THEMES' ); ?>
														</span>
													<?php endif; ?>
												</a>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<?php endif; ?>
						<?php if ( $user->authorise('core.admin', 'com_icagenda') ) : ?>
						<div class="span6" style="text-align: center">
			    			<table>
					    		<tbody>
				    				<tr>
				    					<td colspan="2">
											<h3><?php echo JText::_('COM_ICAGENDA_PANEL_UPDATE_AND_INFOS'); ?></h3>
										</td>
									</tr>
				    				<tr>
	 				   					<td>
											<div class="icon right">
												<a href="index.php?option=com_icagenda&view=info">
													<img src="../media/com_icagenda/images/info-48.png">
													<span class="iconText"><?php echo JText::_( 'COM_ICAGENDA_INFO' ); ?></span>
												</a>
											</div>
										</td>
	 				   					<td class="left">
											<?php echo LiveUpdate::getIcon(); ?>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<?php endif; ?>
					</div>

					<?php if ($icsys == 'core') : ?>
					<div class="row-fluid">

						<div class="span12">
							<div class="alert alert-block alert-info">
							<?php if(version_compare(JVERSION, '3.0', 'ge')) : ?>
								<button type="button" class="close" data-dismiss="alert">×</button>
							<?php endif; ?>
								<p>&nbsp;</p>
								<div style="font-weight: bold; color: #555555;">
									<p>
										<?php echo JText::_('COM_ICAGENDA_PANEL_FREE_VERSION') ?><br/>
										<?php echo JText::_('COM_ICAGENDA_PANEL_PRO_VERSION') ?>:
										<?php echo JText::_('COM_ICAGENDA_PANEL_PRO_MODULE_IC_EVENT_LIST') ?>
									</p>
								</div>
								<div style="display:none;">
									<div id="loadDiv" style="background-color:#F4F4F4;">
										<table style="width:600px; height:350px;" cellpadding="0" cellspacing="0">
											<tbody>
												<tr>
													<td style="text-align: center; height:140px;" rowspan="1" colspan="3">
														&nbsp;&nbsp;&nbsp;<img src="../media/com_icagenda/images/iconicagenda48.png" alt="" />
													</td>
												</tr>
												<tr>
													<td style="text-align: right; width: 280px; height:60px;">
														<form action="https://secure.shareit.com/shareit/checkout.html?PRODUCT[300582128]=1&stylefrom=300582128" method="post" target="_blank">
															<input type="submit" class="btn" width="120px" value="<?php echo JText::_( 'COM_ICAGENDA_PURCHASE_1_YEAR' ); ?>" />
														</form>
													</td>
													<td style="width: 40px; height:60px;">
													</td>
													<td style="width: 280px; height:60px;">
														<form action="https://secure.shareit.com/shareit/checkout.html?PRODUCT[300579672]=1&stylefrom=300579672" method="post" target="_blank">
															<input type="submit" class="btn" value="<?php echo JText::_( 'COM_ICAGENDA_PURCHASE_UNLIMITED' ); ?>" />
														</form>
													</td>
												</tr>
												<tr>
													<td style="text-align: center; height:50px;" colspan="3">
														<a href="http://www.joomlic.com/extensions/icagenda" alt ="<?php echo JText::_( 'COM_ICAGENDA_INFO' ); ?>" target="_blank"><?php echo JText::_( 'COM_ICAGENDA_VERSIONS_COMPARISON' ); ?></a>
													</td>
												</tr>
												<tr>
													<td style="text-align: center;" rowspan="1" colspan="3">
														<div>
															<p>
																<img src="../media/com_icagenda/images/payment/icon_cca.gif" alt="" border="0"/>
																<img src="../media/com_icagenda/images/payment/icon_pal.gif" alt="" border="0"/>
																<img src="../media/com_icagenda/images/payment/icon_wtr.gif" alt="" border="0"/>
																<img src="../media/com_icagenda/images/payment/icon_chk.gif" alt="" border="0"/>
															</p>
														</div>
														<div>
															<img src="../media/com_icagenda/images/payment/shareit_ani.gif" alt="" border="0"/>
														</div>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>

								<p>
									&nbsp;
								</p>
								<div>
									<p style="text-align: center;">
										<a href="#loadDiv" class="modal" rel="{size: {x: 600, y: 350}}">
											<input type="submit" class="btn" value="<?php echo JText::_( 'COM_ICAGENDA_PURCHASE' ); ?>" />
										</a>
										<!--a href="http://www.joomlic.com/extensions/icagenda" alt ="<?php echo JText::_( 'COM_ICAGENDA_INFO' ); ?>" target="_blank">
											<?php echo JText::_( 'COM_ICAGENDA_INFO' ); ?>
										</a-->
									</p>
									<p style="text-align: center; font-size:11px;">
										<a href="http://www.joomlic.com/extensions/icagenda" alt ="<?php echo JText::_( 'COM_ICAGENDA_INFO' ); ?>" target="_blank"><?php echo JText::_( 'COM_ICAGENDA_VERSIONS_COMPARISON' ); ?></a>
									</p>
								</div>

							</div>

						</div><!--end span12-->

					</div><!--end row-->
					<?php endif; ?>

				</div><!--end span 6-->
				<div class="span1">
				</div><!--end span 1-->
				<div class="span5">
					<div class="span12">

						<?php
						$db = JFactory::getDbo();
						$query	= $db->getQuery(true);
						//$query->select('version AS icv, releasedate AS icd')->from('#__icagenda')->where('id = 1');
						//$query->select('version AS icv, releasedate AS icd')->from('#__icagenda')->where('id = 2');
						$query->select('version AS icv, releasedate AS icd, params AS icp')->from('#__icagenda')->where('id = 3');
						$db->setQuery($query);
						$release	= $db->loadObject()->icv;
						$date		= $db->loadObject()->icd;
						$icp		= json_decode( $db->loadObject()->icp, true );

						if ($icsys == 'pro')
						{
							$app = JFactory::getApplication();
							$welcome_pro =  $app->input->get('welcome', '');

							// Get Current URL
							$thisURL = JURI::getInstance()->toString();

							$return_cp = 'index.php?option=com_icagenda';

							if ($welcome_pro == -1)
							{
								$this->saveDefault($welcome_pro, 'msg_procp', '-1');
								$app->enqueueMessage(JText::_('COM_ICAGENDA_WELCOME_HIDE_SUCCESS'), 'message');
								$app->redirect($return_cp);
							}
							elseif ($welcome_pro == 1)
							{
								$this->saveDefault($welcome_pro, 'msg_procp', '1');
//								$app->enqueueMessage(JText::_('COM_ICAGENDA_WELCOME_SHOW_SUCCESS'), 'message');
								$app->redirect($return_cp);
							}

							$options_link = version_compare(JVERSION, '3.0', 'ge')
											? ' : <a href="index.php?option=com_config&view=component&component=com_icagenda&path=&return='
												.  base64_encode(JURI::getInstance()->toString()) . '#pro">'
												. JText::_('JTOOLBAR_OPTIONS') . '</a>'
											: '.';
							?>
							<?php if ($icp['msg_procp'] == -1) : ?>
								<a class="hasTooltip" href="<?php echo JRoute::_($thisURL.'&welcome=1') ?>" data-original-title="Clear" data-toggle="tooltip" title="<?php echo JText::_('COM_ICAGENDA_WELCOME_RELOAD_DESC') ?>">
									<div class="btn btn-mini"><?php echo JText::_('COM_ICAGENDA_WELCOME_RELOAD'); ?></div>
								</a>
							<?php else : ?>
							<?php
			$app->enqueueMessage('<h2>' . JText::sprintf('COM_ICAGENDA_PRO_WELCOME', 'iCagenda PRO') . '</h2>'
								. '<p>' . JText::sprintf('COM_ICAGENDA_PRO_WELCOME_PRO_ACCOUNT_INFO', 'iCagenda PRO', '<a href="http://pro.joomlic.com" target="_blank">pro.joomlic.com</a>') . '</p>'
								. '<p>' . JText::sprintf('COM_ICAGENDA_PRO_WELCOME_PRO_NOTIFICATION_EMAILS', 'info(at)joomlic.com') . '</p>'
								. '<p>' . JText::sprintf('COM_ICAGENDA_PRO_WELCOME_PRO_NOTIFICATION_EMAILS_FIRST', 'Pro JoomliC') . '<br />'
								. JText::_('COM_ICAGENDA_PRO_WELCOME_PRO_NOTIFICATION_EMAILS_SECOND') . '<br />'
								. JText::_('COM_ICAGENDA_PRO_WELCOME_PRO_CHECK_YOUR_EMAIL') . '</p>'
								. '<p>' . JText::sprintf('COM_ICAGENDA_PRO_WELCOME_PRO_FIRST_LOGIN_1', '<a href="http://pro.joomlic.com" target="_blank">pro.joomlic.com</a>') . '<br />'
								. JText::sprintf('COM_ICAGENDA_PRO_WELCOME_PRO_FIRST_LOGIN_2', '<a href="http://pro.joomlic.com" target="_blank">pro.joomlic.com</a>') . '<br />'
								. JText::sprintf('COM_ICAGENDA_PRO_WELCOME_PRO_OPTIONS', $options_link) . '</p>'
								. '<p>' . JText::sprintf('COM_ICAGENDA_PRO_WELCOME_PRO_ID_1', 'iCagenda PRO') . '</p>'
								. '<p>' . JText::_('COM_ICAGENDA_PRO_WELCOME_CONTACT') . '<br />'
								. JText::sprintf('COM_ICAGENDA_PRO_WELCOME_SUPPORT', '<a href="http://pro.joomlic.com/support" target="_blank">Pro Ticket System</a>') . '</p>'
								. '<p><small><strong>' . JText::_('COM_ICAGENDA_PRO_WELCOME_NOTE') . '</strong></small></p>'
								. '<div style="text-align:center">'
								. '<a class="hasTooltip" href="' . JRoute::_($thisURL.'&welcome=-1') . '" data-original-title="Clear" data-toggle="tooltip" title="' . JText::_('COM_ICAGENDA_WELCOME_SHOW_SUCCESS_DESC') . '">'
								. '<div class="btn btn-inverse btn-small">' . JText::_('IC_HIDE_THIS_MESSAGE') . '</div>'
								. '</a>'
								. '</div>'
								, 'message');
								?>
							<?php endif; ?>
						<?php } ?>

						<div style="float:right; padding:0px 0px 0px 20px;">
							<img src="../media/com_icagenda/images/logo_icagenda.png" alt="logo_icagenda" />
						</div>
						<div>
							<h2 style="font-size:2em;">
								<b style="color:#cc0000;">iC</b><b style="color: #666666;">agenda<sup style="font-size:0.6em">&trade;</sup></b><?php echo $version;?>
							</h2>
						</div>
						<div>
							<h4>
								<?php echo JText::_('COM_ICAGENDA_COMPONENT_DESC') ?>
							</h4>
						</div>

						<div class="small">
							<?php echo JText::_('COM_ICAGENDA_FEATURES_BACKEND') ?><br />
							<?php echo JText::_('COM_ICAGENDA_FEATURES_FRONTEND') ?>
						</div>

						<div>&nbsp;</div>

						<div style="font-size:0.9em" class="blockbtn">
							<?php echo JText::_('COM_ICAGENDA_PANEL_VERSION');?>:&nbsp;<b><?php echo $release ;?></b> | <?php echo JText::_('COM_ICAGENDA_PANEL_DATE');?>:&nbsp;<b><?php echo $date ;?></b>&nbsp;&nbsp;

							<?php JHtml::_('behavior.modal'); ?>
							<div style="display:none;">
								<div id="icagenda-changelog">
									<?php
										require_once dirname(__FILE__).'/color.php';
										echo iCagendaUpdateLogsColoriser::colorise(JPATH_COMPONENT_ADMINISTRATOR.'/CHANGELOG.php');
									?>
								</div>
							</div>
							<a href="#icagenda-changelog" class="btn modal"><?php echo JText::_('COM_ICAGENDA_PANEL_UPDATE_LOGS') ?></a>
							<?php //  rel="{size: {x: 800, y: 350}}" ?>
						</div>

						<br/>
						<?php
							$urlposter = '../media/com_icagenda/images/video_poster_icagenda.jpg';
						?>

						<div>&nbsp;</div>
						<div>&nbsp;</div>

						<div onclick="thevid=document.getElementById('thevideo'); thevid.style.display='block'; this.style.display='none'">
							<img style="cursor: pointer;" src="<?php echo $urlposter; ?>" alt="" width="100%" />
						</div>

						<div id="thevideo" style="display: none;">
							<?php
								jimport('joomla.application.component.helper'); // Import component helper library
								$icagendaParams = JComponentHelper::getParams('com_icagenda');
								$icfolder = $icagendaParams->get('icsys');
							?>
							<iframe src="http://www.joomlic.com/_icagenda/<?php echo $icfolder; ?>/tutorial_video_cp.html" frameborder="0" width="100%" height="340" scrolling="no"></iframe>
						</div>

						<div style="color:#333; margin-top: 5px; font-size: 0.8em;">
							© <?php echo date("Y"); ?> <?php echo JText::_('COM_ICAGENDA_VIDEO_TUTORIALS');?> - Giuseppe Bosco (giusebos) | <a href="http://www.newideasproject.com/" target="_blank">www.newideasproject.com</a>
						</div>

						<div style="color:#333; margin-top: 5px; font-size: 0.8em; line-height:14px; height:30px;">
							<a href="http://www.youtube.com/user/iCagenda" target="_blank"><img src="../media/com_icagenda/images/youtube_iCagenda.png" alt="" style="vertical-align:bottom;" /></a> : <a href="http://www.youtube.com/user/iCagenda" target="_blank"><?php echo JText::_('COM_ICAGENDA_VIDEO_TUTORIALS');?></a>
						</div>

						<div>&nbsp;</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row-fluid">
		<div class="span12">
			<div class="row-fluid">
				<div class="span12">
					<h3>40&nbsp;<?php echo JText::_('COM_ICAGENDA_PANEL_TRANSLATION_PACKS');?></h3>
					<p>
						<?php
							if(version_compare(JVERSION, '3.0', 'lt')) {
								$iCtag = '::';
							} else {
								$iCtag = '<br>';
							}
						?>
						<span rel="tooltip" data-placement="right" class="editlinktip hasTip" title=" Arabic (Unitag)
							<?php echo $iCtag;?><?php echo $translator;?>: haneen2013, fkinanah " >
							<img src="../media/mod_languages/images/ar.gif" border="0" alt="Tooltip"/>
						</span>
						<span rel="tooltip" data-placement="right" class="editlinktip hasTip" title=" Basque (Spain)
							<?php echo $iCtag;?><?php echo $translator;?>: Bizkaitarra " >
							<img src="../media/mod_languages/images/eu_es.gif" border="0" alt="Tooltip"/>
						</span>
						<span rel="tooltip" data-placement="right" class="editlinktip hasTip" title=" Bulgarian (Bulgaria)
							<?php echo $iCtag;?><?php echo $translator;?>: bimbongr " >
							<img src="../media/mod_languages/images/bg.gif" border="0" alt="Tooltip"/>
						</span>
						<span rel="tooltip" data-placement="right" class="editlinktip hasTip" title=" Catalan (Spain)
							<?php echo $iCtag;?><?php echo $translator;?>: Mussool, Figuerolero, riquib " >
							<img src="../media/mod_languages/images/ca.gif" border="0" alt="Tooltip"/>
						</span>
						<span rel="tooltip" data-placement="right" class="editlinktip hasTip" title=" Chinese (China)
							<?php echo $iCtag;?><?php echo $translator;?>: Foxyman " >
							<img src="../media/mod_languages/images/zh.gif" border="0" alt="Tooltip"/>
						</span>
						<span rel="tooltip" data-placement="right" class="editlinktip hasTip" title=" Chinese (Taiwan)
							<?php echo $iCtag;?><?php echo $translator;?>: jedi, hkce, rowdytang " >
							<img src="../media/mod_languages/images/tw.gif" border="0" alt="Tooltip"/>
						</span>
						<span rel="tooltip" data-placement="right" class="editlinktip hasTip" title=" Croatian (Croatia)
							<?php echo $iCtag;?><?php echo $translator;?>: Davor Čolić, komir " >
							<img src="../media/mod_languages/images/hr.gif" border="0" alt="Tooltip"/>
						</span>
						<span rel="tooltip" data-placement="right" class="editlinktip hasTip" title=" Czech (Czech Republic)
							<?php echo $iCtag;?><?php echo $translator;?>: Bong " >
							<img src="../media/mod_languages/images/cz.gif" border="0" alt="Tooltip"/>
						</span>
						<span rel="tooltip" data-placement="right" class="editlinktip hasTip" title=" Danish (Denmark)
							<?php echo $iCtag;?><?php echo $translator;?>: olewolf.dk, hvitnov, torbenspetersen, poulfrom, AhmadHamid " >
							<img src="../media/mod_languages/images/dk.gif" border="0" alt="Tooltip"/>
						</span>
						<span rel="tooltip" data-placement="right" class="editlinktip hasTip" title=" Dutch (Netherlands)
							<?php echo $iCtag;?><?php echo $translator;?>: Molenwal1, AnneM, Mario Guagliardo, wfvdijk, Walldorff " >
							<img src="../media/mod_languages/images/nl.gif" border="0" alt="Tooltip"/>
						</span>
						<span rel="tooltip" data-placement="right" class="editlinktip hasTip" title=" English (United Kingdom)
							<?php echo $iCtag;?><?php echo $translator;?>: Lyr!C " >
							<img src="../media/mod_languages/images/en.gif" border="0" alt="Tooltip"/>
						</span>
						<span rel="tooltip" data-placement="right" class="editlinktip hasTip" title=" English (United States)
							<?php echo $iCtag;?><?php echo $translator;?>: Lyr!C " >
							<img src="../media/mod_languages/images/us.gif" border="0" alt="Tooltip"/>
						</span>
						<span rel="tooltip" data-placement="right" class="editlinktip hasTip" title=" Esperanto
							<?php echo $iCtag;?><?php echo $translator;?>: Anita_Dagmarsdotter, Amema " >
							<img src="../media/mod_languages/images/eo.gif" border="0" alt="Tooltip"/>
						</span>
						<span rel="tooltip" data-placement="right" class="editlinktip hasTip" title=" Estonian (Estonia)
							<?php echo $iCtag;?><?php echo $translator;?>: Eraser, Reijo " >
							<img src="../media/mod_languages/images/et.gif" border="0" alt="Tooltip"/>
						</span>
						<span rel="tooltip" data-placement="right" class="editlinktip hasTip" title=" Finnish (Finland)
							<?php echo $iCtag;?><?php echo $translator;?>: Kai Metsävainio " >
							<img src="../media/mod_languages/images/fi.gif" border="0" alt="Tooltip"/>
						</span>
						<span rel="tooltip" data-placement="right" class="editlinktip hasTip" title=" French (France)
							<?php echo $iCtag;?><?php echo $translator;?>: Lyr!C " >
							<img src="../media/mod_languages/images/fr.gif" border="0" alt="Tooltip"/>
						</span>
						<span rel="tooltip" data-placement="right" class="editlinktip hasTip" title=" German (Germany)
							<?php echo $iCtag;?><?php echo $translator;?>: grisuu, mPino, Wasilis, bmbsbr, chuerner, Proton_11, keraM " >
							<img src="../media/mod_languages/images/de.gif" border="0" alt="Tooltip"/>
						</span>
						<span rel="tooltip" data-placement="right" class="editlinktip hasTip" title=" Greek (Greece)
							<?php echo $iCtag;?><?php echo $translator;?>: E.Gkana-D.Kontogeorgis (elinag), rinenweb, kost36, mbini, Wasilis " >
							<img src="../media/mod_languages/images/el.gif" border="0" alt="Tooltip"/>
						</span>
						<span rel="tooltip" data-placement="right" class="editlinktip hasTip" title=" Hungarian (Hungary)
							<?php echo $iCtag;?><?php echo $translator;?>: Halilaci, magicf, Cerbo, mester93 " >
							<img src="../media/mod_languages/images/it.gif" border="0" alt="Tooltip"/>
						</span>
						<span rel="tooltip" data-placement="right" class="editlinktip hasTip" title=" Italian (Italy)
							<?php echo $iCtag;?><?php echo $translator;?>: Giuseppe Bosco (giusebos) " >
							<img src="../media/mod_languages/images/it.gif" border="0" alt="Tooltip"/>
						</span>
						<span rel="tooltip" data-placement="right" class="editlinktip hasTip" title=" Japanese (Japan)
							<?php echo $iCtag;?><?php echo $translator;?>: nagata, taimai908 " >
							<img src="../media/mod_languages/images/ja.gif" border="0" alt="Tooltip"/>
						</span>
						<span rel="tooltip" data-placement="right" class="editlinktip hasTip" title=" Latvian (Latvia)
							<?php echo $iCtag;?><?php echo $translator;?>: kredo9 " >
							<img src="../media/mod_languages/images/lv.gif" border="0" alt="Tooltip"/>
						</span>
						<span rel="tooltip" data-placement="right" class="editlinktip hasTip" title=" Lithuanian (Lithuania)
							<?php echo $iCtag;?><?php echo $translator;?>: ahxoohx " >
							<img src="../media/mod_languages/images/lt.gif" border="0" alt="Tooltip"/>
						</span>
						<span rel="tooltip" data-placement="right" class="editlinktip hasTip" title=" Luxembourgish (Luxembourg)
							<?php echo $iCtag;?><?php echo $translator;?>: Superjhemp " >
							<img src="../media/mod_languages/images/icon-16-language.png" border="0" alt="Tooltip"/>
						</span>
						<span rel="tooltip" data-placement="right" class="editlinktip hasTip" title=" Macedonian (Macedonia)
							<?php echo $iCtag;?><?php echo $translator;?>: Strumjan (Ilija Iliev) " >
							<img src="../media/mod_languages/images/mk.gif" border="0" alt="Tooltip"/>
						</span>
						<span rel="tooltip" data-placement="right" class="editlinktip hasTip" title=" Norwegian Bokmål (Norway)
							<?php echo $iCtag;?><?php echo $translator;?>: Rikard Tømte Reitan " >
							<img src="../media/mod_languages/images/no.gif" border="0" alt="Tooltip"/>
						</span>
						<span rel="tooltip" data-placement="right" class="editlinktip hasTip" title=" Persian (Iran)
							<?php echo $iCtag;?><?php echo $translator;?>: Arash Rezvani (al3n.nvy) " >
							<img src="../media/mod_languages/images/fa_ir.gif" border="0" alt="Tooltip"/>
						</span>
						<span rel="tooltip" data-placement="right" class="editlinktip hasTip" title=" Polish (Poland)
							<?php echo $iCtag;?><?php echo $translator;?>: mbsrz, KISweb, gienio22, traktor, niewidzialny " >
							<img src="../media/mod_languages/images/pl.gif" border="0" alt="Tooltip"/>
						</span>
						<span rel="tooltip" data-placement="right" class="editlinktip hasTip" title=" Portuguese (Brazil)
							<?php echo $iCtag;?><?php echo $translator;?>: Carosouza, alxaraujo " >
							<img src="../media/mod_languages/images/pt_br.gif" border="0" alt="Tooltip"/>
						</span>
						<span rel="tooltip" data-placement="right" class="editlinktip hasTip" title=" Portuguese (Portugal)
							<?php echo $iCtag;?><?php echo $translator;?>: LFGM, macedorl, horus68, helfer " >
							<img src="../media/mod_languages/images/pt.gif" border="0" alt="Tooltip"/>
						</span>
						<span rel="tooltip" data-placement="right" class="editlinktip hasTip" title=" Romanian (Romania)
							<?php echo $iCtag;?><?php echo $translator;?>: hat, mester93 " >
							<img src="../media/mod_languages/images/ro.gif" border="0" alt="Tooltip"/>
						</span>
						<span rel="tooltip" data-placement="right" class="editlinktip hasTip" title=" Russian (Russia)
							<?php echo $iCtag;?><?php echo $translator;?>: nshash, MSV " >
							<img src="../media/mod_languages/images/ru.gif" border="0" alt="Tooltip"/>
						</span>
						<span rel="tooltip" data-placement="right" class="editlinktip hasTip" title=" Serbian (latin)
							<?php echo $iCtag;?><?php echo $translator;?>: Nenad Mihajlović " >
							<img src="../media/mod_languages/images/sr.gif" border="0" alt="Tooltip"/>
						</span>
						<span rel="tooltip" data-placement="right" class="editlinktip hasTip" title=" Slovak (Slovakia)
							<?php echo $iCtag;?><?php echo $translator;?>: ischindl, J.Ribarszki " >
							<img src="../media/mod_languages/images/sk.gif" border="0" alt="Tooltip"/>
						</span>
						<span rel="tooltip" data-placement="right" class="editlinktip hasTip" title=" Slovenian (Slovenia)
							<?php echo $iCtag;?><?php echo $translator;?>: erbi (Ervin Bizjak) " >
							<img src="../media/mod_languages/images/sl.gif" border="0" alt="Tooltip"/>
						</span>
						<span rel="tooltip" data-placement="right" class="editlinktip hasTip" title=" Spanish (Spain)
							<?php echo $iCtag;?><?php echo $translator;?>: elerizo, mPino, albertodg, adolf64, Goncatín, virem1, leoxordonez, claugardia, sterroso " >
							<img src="../media/mod_languages/images/es.gif" border="0" alt="Tooltip"/>
						</span>
						<span rel="tooltip" data-placement="right" class="editlinktip hasTip" title=" Swedish (Sweden)
							<?php echo $iCtag;?><?php echo $translator;?>: Rickard Norberg (metska), Amema, kricke " >
							<img src="../media/mod_languages/images/sv.gif" border="0" alt="Tooltip"/>
						</span>
						<span rel="tooltip" data-placement="right" class="editlinktip hasTip" title=" Thai (Thailand)
							<?php echo $iCtag;?><?php echo $translator;?>: rattanachai.ha " >
							<img src="../media/mod_languages/images/th.gif" border="0" alt="Tooltip"/>
						</span>
						<span rel="tooltip" data-placement="right" class="editlinktip hasTip" title=" Turkish (Turkey)
							<?php echo $iCtag;?><?php echo $translator;?>: harikalarkutusu, farukzeynep, kemalokmen " >
							<img src="../media/mod_languages/images/tr.gif" border="0" alt="Tooltip"/>
						</span>
						<span rel="tooltip" data-placement="right" class="editlinktip hasTip" title=" Ukrainian (Ukraine)
							<?php echo $iCtag;?><?php echo $translator;?>: Vlad Shuh (slv54) " >
							<img src="../media/mod_languages/images/uk.gif" border="0" alt="Tooltip"/>
						</span>
					</p>
				</div>
			</div>
		</div>
	</div>

	<div class="row-fluid">
		<div class="span12">
			<table style="width: 100%; border: 0px;">
				<tbody>
					<tr>
						<td>
							<a href="http://icagenda.joomlic.com/resources/translations" target="_blank" class="btn">
								<?php echo JText::_('COM_ICAGENDA_PANEL_TRANSLATION_PACKS_DONWLOAD');?>
							</a>
						</td>
						<td style="text-align:right; vertical-align: bottom;">
							<a href='http://www.joomlic.com/forum/icagenda'  target="_blank" class="btn">
								<?php echo JText::_('COM_ICAGENDA_PANEL_HELP_FORUM'); ?>
							</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<hr>

	<div class="row-fluid">
		<div class="span12">
			<div class="row-fluid">
				<div class="span9">
					Copyright ©2012-<?php echo date("Y"); ?> joomlic.com -&nbsp;
					<?php echo JText::_('COM_ICAGENDA_PANEL_COPYRIGHT');?>&nbsp;<a href="http://extensions.joomla.org/extensions/calendars-a-events/events/events-management/22013" target="_blank">Joomla! Extensions Directory</a>.
					<br />
					<br />
				</div>
				<div class="span3" style="text-align: right">
					<a href='http://www.joomlic.com' target='_blank'>
						<img src="../media/com_icagenda/images/logo_joomlic.png" alt="" border="0"/>
					</a>
					<br />
					<i><b><?php echo JText::_('COM_ICAGENDA_PANEL_SITE_VISIT');?>&nbsp;<a href='http://www.joomlic.com' target='_blank'>www.joomlic.com</a></b></i>
				</div>
			</div>
		</div>
	</div>
</div>
