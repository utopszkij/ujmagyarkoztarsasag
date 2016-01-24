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
 * @version 	3.5.12 2015-10-05
 * @since       3.2.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');

// JFactory
$app		= JFactory::getApplication();
$document	= JFactory::getDocument();
$lang		= JFactory::getLanguage();
$user		= JFactory::getUser();

// Global Options
//$iCparams = JComponentHelper::getParams('com_icagenda');
$iCparams = $app->getParams();

// Get User Info (Access Levels, id, email)
$userLevels	= $user->getAuthorisedViewLevels();
$u_id		= $user->get('id');
$u_mail		= $user->get('email');

// Get Access Levels to the form
$accessDefault = array('2');
$submitAccess = $iCparams->get('submitAccess', $accessDefault);

// Get Content of the page for not logged-in users
$NotLoginDefault = JText::_( 'COM_ICAGENDA_EVENT_SUBMISSION_ACCESS' ).'<br />';
$submitNotLogin = $iCparams->get('submitNotLogin', '');

if ($submitNotLogin == 2)
{
	$submitNotLogin_Content = $iCparams->get('submitNotLogin_Content', $NotLoginDefault);
}
else
{
	$submitNotLogin_Content = $NotLoginDefault;
}

// Get Content of the page for not authorised logged-in users
$NoRightsDefault = JText::_( 'COM_ICAGENDA_EVENT_SUBMISSION_NO_RIGHTS' ).'<br />';
$submitNoRights = $iCparams->get('submitNoRights', '');
if ($submitNoRights == 2)
{
	$submitNoRights_Content = $iCparams->get('submitNoRights_Content', $NoRightsDefault);
}
else
{
	$submitNoRights_Content = $NoRightsDefault;
}

// Control: if access level, set true to display form
$AccessForm = false;

foreach ($submitAccess AS $ac)
{
	if ( in_array($ac, $userLevels ))
	{
		$AccessForm = true;
	}
}

// Set Return Page
$uri		= JFactory::getURI();
$return		= base64_encode($uri);
$rlink		= JRoute::_("index.php?option=com_users&view=login&return=$return", false);

// Loading Submission Page
if ( !$u_id && !in_array('1', $submitAccess ))
{
	// if not login, and submission form not "public"
	$app->enqueueMessage($submitNotLogin_Content, 'info');
	$app->redirect($rlink);

}
elseif (!$AccessForm)
{
	// if No Access Permissions
	$app->enqueueMessage($submitNoRights_Content, 'info');
	$app->redirect($rlink);

}
else
{
	// Display Form

	// Set name or username for logged-in user
	$nameJoomlaUser = $iCparams->get('nameJoomlaUser', 1);
	if ($nameJoomlaUser == 1)
	{
		$u_name=$user->get('name');
	}
	else
	{
		$u_name=$user->get('username');
	}

	// Autofill name and email if registered user log in
	$autofilluser = $iCparams->get('autofilluser', 1);
	if ($autofilluser != 1)
	{
		$u_name='';
		$u_mail='';
	}

	$theme = $this->template;
//	$infoimg = JURI::root().'components/com_icagenda/themes/packs/default/images/info.png';

	JText::script('COM_ICAGENDA_TERMS_OF_SERVICE_NOT_CHECKED_SUBMIT_EVENT');
	JText::script('COM_ICAGENDA_FORM_NO_DATES_ALERT');

	$period_display			= $this->submit_periodDisplay;
	$weekdays_display		= $this->submit_weekdaysDisplay;
	$dates_display			= $this->submit_datesDisplay;
	$displaytime_display	= $this->submit_displaytimeDisplay;
	$displaytime_default	= $iCparams->get('displaytime', '1');

	$tos = $iCparams->get('tos', 1);

	// Set Tooltips
	$icTip_name			= htmlspecialchars('<strong>' . JText::_( 'COM_ICAGENDA_SUBMIT_FORM_USER_NAME' ) . '</strong><br />' . JText::_( 'COM_ICAGENDA_SUBMIT_FORM_USER_NAME_DESC' ) . '');
	$icTip_Uemail		= htmlspecialchars('<strong>' . JText::_( 'COM_ICAGENDA_SUBMIT_FORM_USER_EMAIL' ) . '</strong><br />' . JText::_( 'COM_ICAGENDA_SUBMIT_FORM_USER_EMAIL_DESC' ) . '');
	$icTip_title		= htmlspecialchars('<strong>' . JText::_( 'COM_ICAGENDA_FORM_LBL_EVENT_TITLE' ) . '</strong><br />' . JText::_( 'COM_ICAGENDA_FORM_DESC_EVENT_TITLE' ) . '');
	$icTip_category		= htmlspecialchars('<strong>' . JText::_( 'COM_ICAGENDA_FORM_LBL_EVENT_CATID' ) . '</strong><br />' . JText::_( 'COM_ICAGENDA_FORM_DESC_EVENT_CATID' ) . '');
	$icTip_image		= htmlspecialchars('<strong>' . JText::_( 'COM_ICAGENDA_FORM_LBL_EVENT_IMAGE' ) . '</strong><br />' . JText::_( 'COM_ICAGENDA_FORM_DESC_EVENT_IMAGE' ) . '');
	$icTip_startD		= htmlspecialchars('<strong>' . JText::_( 'COM_ICAGENDA_FORM_LBL_EVENTPERIOD_START' ) . '</strong><br />' . JText::_( 'COM_ICAGENDA_FORM_DESC_EVENTPERIOD_START' ) . '');
	$icTip_endD			= htmlspecialchars('<strong>' . JText::_( 'COM_ICAGENDA_FORM_LBL_EVENTPERIOD_END' ) . '</strong><br />' . JText::_( 'COM_ICAGENDA_FORM_DESC_EVENTPERIOD_END' ) . '');
	$icTip_weekDays		= htmlspecialchars('<strong>' . JText::_( 'COM_ICAGENDA_FORM_WEEK_DAYS_INFO_TITLE' ) . '</strong><br />' . JText::_( 'COM_ICAGENDA_FORM_WEEK_DAYS_INFO_DESC' ) . '');
	$icTip_displayTime	= htmlspecialchars('<strong>' . JText::_( 'COM_ICAGENDA_DISPLAY_TIME_LABEL' ) . '</strong><br />' . JText::_( 'COM_ICAGENDA_DISPLAY_TIME_DESC' ) . '');
	$icTip_venue		= htmlspecialchars('<strong>' . JText::_( 'COM_ICAGENDA_FORM_LBL_EVENT_VENUE' ) . '</strong><br />' . JText::_( 'COM_ICAGENDA_FORM_DESC_EVENT_VENUE' ) . '');
	$icTip_email		= htmlspecialchars('<strong>' . JText::_( 'COM_ICAGENDA_FORM_LBL_EVENT_EMAIL' ) . '</strong><br />' . JText::_( 'COM_ICAGENDA_FORM_DESC_EVENT_EMAIL' ) . '');
	$icTip_phone		= htmlspecialchars('<strong>' . JText::_( 'COM_ICAGENDA_FORM_LBL_EVENT_PHONE' ) . '</strong><br />' . JText::_( 'COM_ICAGENDA_FORM_DESC_EVENT_PHONE' ) . '');
	$icTip_website		= htmlspecialchars('<strong>' . JText::_( 'COM_ICAGENDA_FORM_LBL_EVENT_WEBSITE' ) . '</strong><br />' . JText::_( 'COM_ICAGENDA_FORM_DESC_EVENT_WEBSITE' ) . '');
	$icTip_file			= htmlspecialchars('<strong>' . JText::_( 'COM_ICAGENDA_FORM_LBL_EVENT_FILE' ) . '</strong><br />' . JText::_( 'COM_ICAGENDA_FORM_DESC_EVENT_FILE' ) . '');
	$icTip_reg			= htmlspecialchars('<strong>' . JText::_( 'COM_ICAGENDA_REGISTRATION_LABEL' ) . '</strong><br />' . JText::_( 'COM_ICAGENDA_REGISTRATION_DESC' ) . '');
	$icTip_tickets		= htmlspecialchars('<strong>' . JText::_( 'COM_ICAGENDA_MAX_REGISTRATIONS_LABEL' ) . '</strong><br />' . JText::_( 'COM_ICAGENDA_MAX_REGISTRATIONS_DESC' ) . '');

	$session			= JFactory::getSession();
	$address_session	= $session->get('ic_submit_address', '');
	$ic_submit_tos		= $session->get('ic_submit_tos', '');
	$post				= $session->get('ic_submit', '');

	$post_username			= $post ? $post->username : '';
	$post_created_by_email	= $post ? $post->created_by_email : '';
	$post_title				= $post ? $post->title : '';
	$post_image				= $post ? $post->image : '';
	$post_startdate			= $post ? $post->startdate : '0000-00-00 00:00:00';
	$post_enddate			= $post ? $post->enddate : '0000-00-00 00:00:00';
	$post_weekdays			= $post ? explode(',', $post->weekdays) : array();
	$post_displaytime		= $post ? $post->displaytime : '1';
	$post_desc				= $post ? $post->desc : '';
	$post_venue				= $post ? $post->place : '';
	$post_email				= $post ? $post->email : '';
	$post_phone				= $post ? $post->phone : '';
	$post_website			= $post ? $post->website : '';
	$post_file				= $post ? $post->file : '';
	$post_address			= $post ? $post->address : '';
	$post_lat				= $post ? $post->lat : '0';
	$post_lng				= $post ? $post->lng : '0';
	$post_params			= $post ? $post->params : '';

	if ($post_params)
	{
//		foreach ($post_image as $key => $value)
//		{
//			$post_img[$key] = $value;
//		}

		$post_params = json_decode( $post_params, true );

		foreach ($post_params as $key => $value)
		{
			$post_param[$key] = $value;
		}
	}

	$params = $this->form->getFieldsets('params');


	// Set default values for Google Maps
	// ZOOM
	$zoom = '16';
	// HYBRID, ROADMAP, SATELLITE, TERRAIN
	$mapTypeId = 'ROADMAP';

	$coords = $post_lat . ', ' . $post_lng;
	$lat = '0';
	$lng = '0';
	$zoom = $post ? '16' : '1';

	// Form Validation
	$novalidate			= ($this->submit_form_validation == 1) ? ' novalidate' : '';
	$form_validate		= ($this->submit_form_validation == 1) ? '' : ' form-validate';
	$iCheckForm			= ($this->submit_form_validation == 1) ? '' : ' onsubmit="return iCheckForm();"';
	?>

	<?php // ERROR ALERT ?>
	<div id="form_errors" class="alert alert-danger" style="display:none">
		<strong><?php echo JText::_('JGLOBAL_VALIDATION_FORM_FAILED'); ?></strong>
		<div id="message_error">
		</div>
	</div>

	<div id="icagenda" class="ic-submit-view<?php echo $this->pageclass_sfx; ?>">
		<?php if ($this->params->get('show_page_heading', 1)) : ?>
		<h1 class="componentheading">
			<?php echo $this->escape($this->params->get('page_heading')); ?>
		</h1>
		<?php endif; ?>

		<form id="submitevent" action="<?php echo JRoute::_('index.php?option=com_icagenda&view=submit'); ?>" method="post" class="icagenda_form<?php echo $form_validate; ?>" enctype="multipart/form-data"<?php echo $iCheckForm . $novalidate; ?>>
			<div>
			<legend><?php echo JText::_('COM_ICAGENDA_LEGEND_USERINFOS'); ?></legend>
			<div class="fieldset">
				<div class="ic-control-group ic-clearfix">
					<div class="ic-control-label">
						<label id="submit_username-lbl" for="submit_username"><?php echo JText::_( 'COM_ICAGENDA_SUBMIT_FORM_USER_NAME' ); ?> *</label>
					</div>
					<div class="ic-controls">
						<?php
						if ($u_name)
						{
							echo '<input type="text" id="submit_username" name="username" value="'.$this->escape($u_name).'" size="40" class="input-large required" aria-required="true" readonly="true" />';
						}
						else
						{
							echo '<input type="text" id="submit_username" name="username" value="' . $post_username . '" size="40" class="input-large required" aria-required="true" required="true" />';
						}
						?>
						<?php echo '<span class="iCFormTip iCicon iCicon-info-circle" title="' . $icTip_name . '"></span>'; ?>
					</div>
				</div>
				<div class="ic-control-group ic-clearfix">
					<div class="ic-control-label">
						<label id="submit_created_by_email-lbl" for="submit_created_by_email"><?php echo JText::_( 'COM_ICAGENDA_SUBMIT_FORM_USER_EMAIL' ); ?> *</label>
					</div>
					<div class="ic-controls">
						<?php
						if ($u_mail)
						{
							echo '<input type="text" id="submit_created_by_email" name="created_by_email" value="' . $this->escape($u_mail) . '" size="40" class="input-large required" aria-required="true" readonly="true" />';
						}
						else
						{
							echo '<input type="text" id="submit_created_by_email" name="created_by_email" value="' . $post_created_by_email . '" size="40" class="input-large required" aria-required="true" required="true" />';
						}
						?>
						<?php echo '<span class="iCFormTip iCicon iCicon-info-circle" title="' . $icTip_Uemail . '"></span>'; ?>
					</div>
				</div>
			</div>
			<div>&nbsp;</div>

			<legend id="ic-event-fieldset"><?php echo JText::_('COM_ICAGENDA_LEGEND_NEW_EVENT'); ?></legend>

			<div class="fieldset">
				<div class="ic-control-group ic-clearfix">
					<div class="ic-control-label">
						<label id="title-lbl" for="title"><?php echo JText::_( 'COM_ICAGENDA_FORM_LBL_EVENT_TITLE' ); ?> *</label>
					</div>
					<div class="ic-controls">
						<input id="title" type="text" name="title" size="60" value="<?php echo $post_title; ?>" class="input-xlarge required" aria-required="true" required="true"/>
						<?php echo '<span class="iCFormTip iCicon iCicon-info-circle" title="' . $icTip_title . '"></span>'; ?>
					</div>
				</div>
				<div class="ic-control-group ic-clearfix">
					<div class="ic-control-label">
						<label id="catid-lbl" for="catid"><?php echo JText::_( 'COM_ICAGENDA_FORM_LBL_EVENT_CATID' ); ?> *</label>
					</div>
					<div class="ic-controls ic-select">
						<?php echo $this->form->getInput('catid'); ?>
						<?php echo '<span class="iCFormTip iCicon iCicon-info-circle" title="' . $icTip_category . '"></span>'; ?>
					</div>
				</div>
				<?php if ($this->submit_imageDisplay) : ?>
				<div class="ic-control-group ic-clearfix">
					<div class="ic-control-label">
						<label><?php echo JText::_( 'COM_ICAGENDA_FORM_LBL_EVENT_IMAGE' ); ?></label>
					</div>
					<div class="ic-controls ic-select">
						<?php if (!$post_image) : ?>
							<?php echo $this->form->getInput('image'); ?>
							<?php echo '<span class="iCFormTip iCicon iCicon-info-circle" title="' . $icTip_image . '"></span>'; ?>
						<?php else : ?>
							<?php echo '<input type="hidden" name="image_session" value="' . $post_image . '" />'; ?>
							<?php echo '<img src="' . $post_image .'" alt="" />'; ?>
						<?php endif; ?>
					</div>
				</div>
				<div id="ic-upload-preview"></div>
				<?php endif; ?>
			</div>
			<div>&nbsp;</div>

			<legend id="ic-dates-fieldset"><?php echo JText::_('COM_ICAGENDA_LEGEND_DATES'); ?></legend>

			<div class="fieldset">
				<?php if ($period_display == '1') : ?>
				<h3><?php echo JText::_('COM_ICAGENDA_LEGEND_PERIOD_DATES'); ?></h3>
				<div class="ic-control-group ic-clearfix">
					<div class="ic-control-label">
						<label><?php echo JText::_( 'COM_ICAGENDA_FORM_LBL_EVENTPERIOD_START' ); ?></label>
					</div>
					<div class="ic-controls">
						<?php if ($lang->getTag() == 'fa-IR') : ?>
							<?php echo JHtml::_('calendar', $post_startdate, 'startdate', 'startdate_jalali', '%Y-%m-%d %H:%M:%S', ''); ?>
						<?php else : ?>
							<input type="text" name="startdate" id="startdate" class="ic-date-input" value="<?php echo $post_startdate; ?>">
						<?php endif; ?>
						<?php echo '<span class="iCFormTip iCicon iCicon-info-circle" title="' . $icTip_startD . '"></span>'; ?>
					</div>
				</div>
				<div class="ic-control-group ic-clearfix">
					<div class="ic-control-label">
						<label><?php echo JText::_( 'COM_ICAGENDA_FORM_LBL_EVENTPERIOD_END' ); ?></label>
					</div>
					<div class="ic-controls">
						<?php if ($lang->getTag() == 'fa-IR') : ?>
							<?php echo JHtml::_('calendar', $post_enddate, 'enddate', 'enddate_jalali', '%Y-%m-%d %H:%M:%S', ''); ?>
						<?php else : ?>
							<input type="text" name="enddate" id="enddate" class="ic-date-input" value="<?php echo $post_enddate; ?>">
						<?php endif; ?>
						<?php echo '<span class="iCFormTip iCicon iCicon-info-circle" title="' . $icTip_endD . '"></span>'; ?>
					</div>
				</div>
				<?php if ($weekdays_display == '1') : ?>
				<div class="ic-control-group ic-clearfix">
					<div class="ic-control-label">
						<?php echo $this->form->getLabel('weekdays'); ?>
					</div>
					<div class="ic-controls ic-select">
						<?php if (!$post_weekdays) : ?>
							<?php echo $this->form->getInput('weekdays'); ?>
						<?php else : ?>
							<select
								name="weekdays"
								type="list"
								label="COM_ICAGENDA_FORM_LBL_WEEK_DAYS"
								description="COM_ICAGENDA_FORM_DESC_WEEK_DAYS"
								multiple="true"
								labelclass="control-label"
								>
								<option value="0" <?php if (in_array('0', $post_weekdays)) { echo "selected"; } ?>>
									<?php echo JText::_('SUNDAY') ?></option>
								<option value="1" <?php if (in_array('1', $post_weekdays)) { echo "selected"; } ?>>
									<?php echo JText::_('MONDAY') ?></option>
								<option value="2" <?php if (in_array('2', $post_weekdays)) { echo "selected"; } ?>>
									<?php echo JText::_('TUESDAY') ?></option>
								<option value="3" <?php if (in_array('3', $post_weekdays)) { echo "selected"; } ?>>
									<?php echo JText::_('WEDNESDAY') ?></option>
								<option value="4" <?php if (in_array('4', $post_weekdays)) { echo "selected"; } ?>>
									<?php echo JText::_('THURSDAY') ?></option>
								<option value="5" <?php if (in_array('5', $post_weekdays)) { echo "selected"; } ?>>
									<?php echo JText::_('FRIDAY') ?></option>
								<option value="6" <?php if (in_array('6', $post_weekdays)) { echo "selected"; } ?>>
									<?php echo JText::_('SATURDAY') ?></option>
							</select>
						<?php endif; ?>
						<?php echo '<span class="iCFormTip iCicon iCicon-info-circle" title="' . $icTip_weekDays . '"></span>'; ?>
					</div>
				</div>
				<?php endif; ?>
				<?php endif; ?>

				<?php if ($dates_display == '1') : ?>
				<h3><?php echo JText::_('COM_ICAGENDA_LEGEND_SINGLE_DATES'); ?></h3>
				<div class="ic-control-group ic-clearfix">
					<?php echo $this->form->getInput('dates'); ?>
				</div>
				<?php endif; ?>

				<?php if ($displaytime_display == '1' && ($period_display == '1' || $dates_display == '1')) : ?>
				<h3><?php echo JText::_('COM_ICAGENDA_DISPLAY_TIME_LABEL'); ?></h3>
				<?php
				if ($post)
				{
					$time_checked_0			= empty($post_displaytime) ? ' checked="checked"' : '';
					$time_checked_1			= ! empty($post_displaytime) ? ' checked="checked"' : '';
				}
				else
				{
					$time_checked_0			= ($displaytime_default == '0') ? ' checked="checked"' : '';
					$time_checked_1			= ($displaytime_default == '1') ? ' checked="checked"' : '';;
				}
				?>
				<div class="ic-control-group ic-clearfix">
					<fieldset id="displaytime" class="ic-radio ic-btn-group">
						<?php echo '<input id="displaytime0" class="ic-btn" type="radio" value="0"' . $time_checked_0 . ' name="displaytime"></input>'; ?>
						<?php echo '<label class="ic-btn" for="displaytime0">' . JText::_('JHIDE') . '</label>'; ?>
						<?php echo '<input id="displaytime1" class="ic-btn" type="radio" value="1"' . $time_checked_1 . ' name="displaytime"></input>'; ?>
						<?php echo '<label class="ic-btn" for="displaytime1">' . JText::_('JSHOW') . '</label>'; ?>
					</fieldset>
					<?php echo '<span class="iCFormTip iCicon iCicon-info-circle" title="' . $icTip_displayTime . '"></span>'; ?>
				</div>
				<?php else : ?>
				<?php echo '<input type="hidden" value="' . $displaytime_default . '" name="displaytime" />'; ?>
				<?php endif; ?>

				<?php echo $this->form->getInput('next'); ?>
			</div>
			<div>&nbsp;</div>

			<?php // Description Field Set ?>
			<?php if ($this->submit_descDisplay
				|| $this->submit_shortdescDisplay
				|| $this->submit_metadescDisplay) : ?>
				<legend><?php echo JText::_('COM_ICAGENDA_LEGEND_DESC'); ?></legend>
				<div class="fieldset">

					<?php // Short Description ?>
					<?php if ($this->submit_shortdescDisplay) : ?>
					<div class="ic-control-group ic-clearfix">
						<h3><?php echo JText::_('COM_ICAGENDA_SUBMIT_AN_EVENT_SHORT_DESCRIPTION_LBL') . ' <small class="iCFormTip iCicon iCicon-info-circle" title="' . JText::_('COM_ICAGENDA_SUBMIT_AN_EVENT_SHORT_DESCRIPTION_DESC') . '"></small>'; ?></h3>
						<?php echo $this->form->getInput('shortdesc'); ?>
					</div>
					<?php endif; ?>

					<?php // Description ?>
					<?php if ($this->submit_descDisplay) : ?>
					<div class="ic-control-group ic-clearfix">
						<h3><?php echo JText::_('COM_ICAGENDA_FORM_LBL_EVENT_DESC') . ' <small class="iCFormTip iCicon iCicon-info-circle" title="' . JText::_('COM_ICAGENDA_SUBMIT_AN_EVENT_DESCRIPTION_DESC') . '"></small>'; ?></h3>
						<div>
							<?php
							if ($post_desc)
							{
								$editor = JFactory::getEditor();
								echo '<div id="tos_custom">';
								echo $editor->display("desc", $post_desc, "100%", "300", "300", "20", 1, null, null, null, array('mode' => 'advanced'));
								echo '</div>';
							}
							else
							{
								echo $this->form->getInput('desc');
							}
							?>
						</div>
						<div>&nbsp;</div>
					</div>
					<?php endif; ?>

					<?php // Meta-description ?>
					<?php if ($this->submit_metadescDisplay) : ?>
					<div class="ic-control-group ic-clearfix">
						<h3><?php echo JText::_('COM_ICAGENDA_FORM_EVENT_METADESC_LBL') . ' <small class="iCFormTip iCicon iCicon-info-circle" title="' . JText::_('COM_ICAGENDA_SUBMIT_AN_EVENT_METADESC_DESC') . '"></small>'; ?></h3>
						<?php echo $this->form->getInput('metadesc'); ?>
					</div>
					<?php endif; ?>
      <!--textarea name="taMessage2" cols="50" rows="3" class="textarea" id="taMessage2" onMouseOut="CheckFieldLength(taMessage2, 'charcount2', 'remaining2', 140);" onKeyDown="CheckFieldLength(taMessage2, 'charcount2', 'remaining2', 140);" window.onmousemove="CheckFieldLength(taMessage2, 'charcount2', 'remaining2', 140);"></textarea-->
      <!--h2><span id="charcount2">0</span> characters entered | <span id="remaining2">140</span> characters remaining</h2>
		<script type="text/javascript">
		window.onmousemove = iCuseractions;
		window.onscroll = iCuseractions;
		function iCuseractions()
		{
			CheckFieldLength(taMessage2, 'charcount2', 'remaining2', 140);
		}
		</script-->
				</div>
				<div>&nbsp;</div>
			<?php endif; ?>

			<?php // Information Field Set ?>
			<?php if ($this->submit_venueDisplay
				OR $this->submit_emailDisplay
				OR $this->submit_phoneDisplay
				OR $this->submit_websiteDisplay
				OR $this->submit_fileDisplay
				OR $this->submit_customfieldsDisplay) : ?>
				<legend><?php echo JText::_('COM_ICAGENDA_LEGEND_INFORMATION'); ?></legend>
				<div class="fieldset">

					<?php // Venue ?>
					<?php if ($this->submit_venueDisplay) : ?>
						<h3><?php echo JText::_('COM_ICAGENDA_LEGEND_VENUE'); ?></h3>
						<div class="ic-control-group ic-clearfix">
							<div class="ic-control-label">
								<label><?php echo JText::_( 'COM_ICAGENDA_FORM_LBL_EVENT_VENUE' ); ?></label>
							</div>
							<div class="ic-controls">
								<?php
								if ($post_venue)
								{
									echo '<input type="text" name="place" value="' . $post_venue . '" size="40" class="input-large" />';
								}
								else
								{
									echo $this->form->getInput('place');
								}
								?>
								<?php echo '<span class="iCFormTip iCicon iCicon-info-circle" title="' . $icTip_venue . '"></span>'; ?>
							</div>
						</div>
					<?php endif; ?>

					<?php // Contact ?>
					<?php if ($this->submit_emailDisplay
						OR $this->submit_phoneDisplay
						OR $this->submit_websiteDisplay) : ?>
						<h3><?php echo JText::_('COM_ICAGENDA_LEGEND_CONTACT'); ?></h3>

						<?php // Email ?>
						<?php if ($this->submit_emailDisplay) : ?>
						<div class="ic-control-group ic-clearfix">
							<div class="ic-control-label">
								<label><?php echo JText::_( 'COM_ICAGENDA_FORM_LBL_EVENT_EMAIL' ); ?></label>
							</div>
							<div class="ic-controls">
								<?php
								if ($post_email)
								{
									echo '<input type="text" name="email" value="' . $post_email . '" size="40" class="input-xlarge" />';
								}
								else
								{
									echo $this->form->getInput('email');
								}
								?>
								<?php echo '<span class="iCFormTip iCicon iCicon-info-circle" title="' . $icTip_email . '"></span>'; ?>
							</div>
						</div>
						<?php endif; ?>

						<?php // Phone ?>
						<?php if ($this->submit_phoneDisplay) : ?>
						<div class="ic-control-group ic-clearfix">
							<div class="ic-control-label">
								<label><?php echo JText::_( 'COM_ICAGENDA_FORM_LBL_EVENT_PHONE' ); ?></label>
							</div>
							<div class="ic-controls">
								<?php
								if ($post_phone)
								{
									echo '<input type="text" name="phone" value="' . $post_phone . '" size="40" class="input-large" />';
								}
								else
								{
									echo $this->form->getInput('phone');
								}
								?>
								<?php echo '<span class="iCFormTip iCicon iCicon-info-circle" title="' . $icTip_phone . '"></span>'; ?>
							</div>
						</div>
						<?php endif; ?>

						<?php // Website ?>
						<?php if ($this->submit_websiteDisplay) : ?>
						<div class="ic-control-group ic-clearfix">
							<div class="ic-control-label">
								<label><?php echo JText::_( 'COM_ICAGENDA_FORM_LBL_EVENT_WEBSITE' ); ?></label>
							</div>
							<div class="ic-controls">
								<?php
								if ($post_website)
								{
									echo '<input type="text" name="website" value="' . $post_website . '" size="40" class="input-large" />';
								}
								else
								{
									echo $this->form->getInput('website');
								}
								?>
								<?php echo '<span class="iCFormTip iCicon iCicon-info-circle" title="' . $icTip_website . '"></span>'; ?>
							</div>
						</div>
						<?php endif; ?>

					<?php endif; ?>

					<?php // Load Custom fields - Event form (2) ?>
					<?php if ($this->submit_customfieldsDisplay) : ?>
						<?php if (icagendaCustomfields::loader(2)) : ?>
							<h3><?php echo JText::_('COM_ICAGENDA_LEGEND_OTHER_INFORMATION'); ?></h3>
							<?php echo icagendaCustomfields::loader(2); ?>
							<br />
						<?php endif; ?>
					<?php endif; ?>

					<?php // Attachment ?>
					<?php if ($this->submit_fileDisplay) : ?>
						<h3><?php echo JText::_('COM_ICAGENDA_LEGEND_ALLEG'); ?></h3>
						<div class="ic-control-group ic-clearfix">
							<div class="ic-control-label">
								<label><?php echo JText::_( 'COM_ICAGENDA_FORM_LBL_EVENT_FILE' ); ?></label>
							</div>
							<div class="ic-controls">
								<?php if ($post_file) : ?>
									<?php echo '<input type="hidden" name="file_session" value="' . $post_file . '" />'; ?>
									<?php
									$path_parts = pathinfo($post_file);
									echo $path_parts['basename'];
									?>
								<?php else : ?>
									<?php echo $this->form->getInput('file'); ?>
									<?php echo '<span class="iCFormTip iCicon iCicon-info-circle" title="' . $icTip_file . '"></span>'; ?>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
				<div>&nbsp;</div>
			<?php endif; ?>

			<?php // Google Maps Field Set ?>
			<?php if ($this->submit_gmapDisplay) : ?>
				<legend><?php echo JText::_('COM_ICAGENDA_LEGEND_GOOGLE_MAPS'); ?></legend>
				<div class="fieldset">
					<div id="googlemap">
						<div class="row-fluid">
							<div class="span6 ic-align-left">
								<h3><?php echo JText::_('COM_ICAGENDA_GOOGLE_MAPS_SUBTITLE_LBL'); ?></h3>
								<div>
									<?php echo JText::_('COM_ICAGENDA_GOOGLE_MAPS_NOTE1'); ?>
									<br/>
									<?php echo JText::_('COM_ICAGENDA_GOOGLE_MAPS_NOTE2'); ?>
									<br/>
								</div>
								<div style="clear:both"></div>
								<div>
									<div class="icmap-address">
										<?php
										if ($address_session)
										{
											echo '<input type="hidden" name="address_session" value="' . $address_session . '" size="40" class="input-xlarge" readonly="true" />';
//											echo '<div><strong>' . $address_session . '</strong></div>';
										}
										?>
										<div class="icmap-label">
											<?php echo $this->form->getLabel('address'); ?>
										</div>
										<?php echo $this->form->getInput('address'); ?>
									</div>
									<div class="icmap-field">
										<?php echo $this->form->getInput('city'); ?>
									</div>
									<div class="icmap-field">
										<?php echo $this->form->getInput('country'); ?>
									</div>
									<div class="icmap-field">
										<?php echo $this->form->getInput('lat'); ?>
									</div>
									<div class="icmap-field">
										<?php echo $this->form->getInput('lng'); ?>
									</div>
								</div>
							</div>
							<div class="span6 ic-align-left">
								<div class='map-wrapper'>
									<h3>Map</h3>
									<label id="geo_label" for="reverseGeocode"><?php echo JText::_('COM_ICAGENDA_GOOGLE_MAPS_REVERSE'); ?></label>
									<select id="reverseGeocode">
										<option value="false" selected><?php echo JText::_('JNO'); ?></option>
										<option value="true"><?php echo JText::_('JYES'); ?></option>
									</select><br/>
									<div id="map"></div>
									<div id="legend"><?php echo JText::_('COM_ICAGENDA_GOOGLE_MAPS_LEGEND'); ?></div>
								</div>
							</div>
						</div>
					</div>
					<div style="clear:both"></div>
				</div>
				<div>&nbsp;</div>
			<?php endif; ?>

			<?php // Registration Field Set ?>
			<?php if ($this->submit_regoptionsDisplay && $this->statutReg == 1) : ?>
				<legend><?php echo JText::_('COM_ICAGENDA_REGISTRATION_OPTIONS'); ?></legend>
				<div class="fieldset">

					<?php
					if ($post && $post_param)
					{
						$statutReg	= $post_param['statutReg'];
						$checked_0	= empty($statutReg) ? ' checked="checked"' : '';
						$checked_1	= !empty($statutReg) ? ' checked="checked"' : '';
						$maxReg		= $post_param['maxReg'];
					}
					else
					{
						$statutReg	= $iCparams->get('statutReg', '0');
						$checked_0	= ($statutReg == '0') ? ' checked="checked"' : '';
						$checked_1	= ($statutReg == '1') ? ' checked="checked"' : '';;
						$maxReg		= '';
					}
					?>

					<?php // Registration Activation ?>
					<div class="ic-control-group ic-clearfix">
						<div class="ic-control-label">
							<label><?php echo JText::_( 'COM_ICAGENDA_REGISTRATION_LABEL' ); ?></label>
						</div>
						<div class="ic-controls">
							<fieldset id="params_statutReg" class="ic-radio ic-btn-group">
								<?php echo '<input id="params_statutReg0" class="ic-btn" type="radio"' . $checked_0 . ' value="0" name="params[statutReg]"></input>'; ?>
								<?php echo '<label class="ic-btn" for="params_statutReg0">' . JText::_('JOFF') . '</label>'; ?>
								<?php echo '<input id="params_statutReg1" class="ic-btn" type="radio"' . $checked_1 . ' value="1" name="params[statutReg]"></input>'; ?>
								<?php echo '<label class="ic-btn" for="params_statutReg1">' . JText::_('JON') . '</label>'; ?>
							</fieldset>
							<?php echo '<span class="iCFormTip iCicon iCicon-info-circle" title="' . $icTip_reg . '"></span>'; ?>
						</div>
					</div>

					<?php // Nb of Tickets ?>
					<div class="ic-control-group ic-clearfix">
						<div class="ic-control-label">
							<label><?php echo JText::_( 'COM_ICAGENDA_MAX_REGISTRATIONS_LABEL' ); ?></label>
						</div>
						<div class="ic-controls">
							<?php echo '<input type="text" class="input-small" name="params[maxReg]" value="' . $maxReg . '" />'; ?>
							<?php echo '<span class="iCFormTip iCicon iCicon-info-circle" title="' . $icTip_tickets . '"></span>'; ?>
						</div>
					</div>

					<?php foreach ($params as $name => $fieldSet) : ?>
						<?php if ($fieldSet->name != 'captcha') : ?>
							<?php if (isset($fieldSet->description) && trim($fieldSet->description)) : ?>
								<p class="tip"><?php echo $this->escape(JText::_($fieldSet->description));?></p>
							<?php endif; ?>
							<!--h3><?php echo $this->escape(JText::_($fieldSet->label)); ?></h3-->
							<?php foreach ($this->form->getFieldset($name) as $field) : ?>
								<div class="ic-control-group ic-clearfix">
									<div class="ic-control-label">
										<?php echo $field->label; ?>
									</div>
									<div class="ic-controls">
										<?php
										if ($post_params)
										{
											foreach ($post_params as $key => $value)
											{
												$post_param[$key] = $value;
											}
											echo $field->input;
										}
										else
										{
											echo $field->input;
										}
										?>
									</div>
								</div>
							<?php endforeach; ?>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
				<div>&nbsp;</div>
			<?php endif; ?>

			<?php // Hidden Fields ?>
			<div style="display:none">
				<?php echo $this->form->getInput('alias'); ?>
				<?php echo $this->form->getInput('id'); ?>
				<?php echo $this->form->getInput('created_by'); ?>
				<?php echo $this->form->getInput('created_by_alias'); ?>
				<?php echo $this->form->getInput('created'); ?>
				<?php echo $this->form->getInput('checked_out'); ?>
				<?php echo $this->form->getInput('checked_out_time'); ?>
				<?php
				$current_url	= JURI::getInstance()->toString();
				$menu			= JFactory::getApplication()->getMenu();
				$current_menu	= $menu->getActive();
				?>
				<!--input type="hidden" name="menuID" value="<?php echo $menuID; ?>" /-->
				<input type="hidden" name="current_url" value="<?php echo $current_url; ?>" />
				<input type="hidden" name="site_itemid" value="<?php echo $current_menu->id; ?>" />
				<input type="hidden" name="site_menu_title" value="<?php echo $current_menu->title; ?>" />
				<input type="hidden" id="tos" name="submit_tos" value="<?php echo $ic_submit_tos; ?>" />
			</div>

				<?php
				/**
				 * Terms of Service Display
				 */
				if ($tos == 0) // No Terms of Service
				{
					// Terms of Service not displayed
					$tokenHTML = str_replace('type="hidden"','id="formAgree" name="tos" value="checked" class="required" required="true" type="checkbox" checked style="display:none"',JHTML::_( 'form.token' ));
					echo $tokenHTML;
					?>
					<div class="bgButton">

						<?php // RECAPTCHA ?>
						<?php if ($this->submit_captcha != '0') : ?>
						<div class="ic-control-group ic-clearfix">
							<div class="ic-control-label">
								<label> </label>
							</div>
							<div class="ic-controls">
								<?php echo $this->form->getInput('captcha'); ?>
							</div>
						</div>
						<br />
						<?php endif; ?>

						<span>
							<!--input type="submit" value="<?php echo JText::_( 'COM_ICAGENDA_EVENT_FORM_SUBMIT' ); ?>" class="button" name="submit"/-->
							<button type="submit" class="button validate"><?php echo JText::_('COM_ICAGENDA_EVENT_FORM_SUBMIT');?></button>
							<input type="hidden" name="task" value="" />
							<input type="hidden" name="return" value="index.php" />
							<?php if (false) echo JHtml::_( 'form.token' ); ?>
						</span>
						<!--span class="buttonx">
							<a href="javascript:history.go(-1)" title="<?php echo JTEXT::_('COM_ICAGENDA_CANCEL'); ?>">
								<?php echo JTEXT::_('COM_ICAGENDA_CANCEL'); ?>
							</a>
						</span-->
					</div><?php // End Div bgButton ?>
					<?php
				}
				elseif ($tos == 1) // Terms of Service Required
				{
					// Terms of Service
					$checked = ($ic_submit_tos == 'checked') ? ' checked' : '';

					$tokenHTML = str_replace('type="hidden"', 'id="formAgree" name="tos" value="checked" class="required" required="true" type="checkbox"' . $checked, JHtml::_( 'form.token' ));

					// Get the site name
					$config = JFactory::getConfig();
					if (version_compare(JVERSION, '3.0', 'ge')) {
						$sitename = $config->get('sitename');
					} else {
						$sitename = $config->getValue('config.sitename');
					}

					// Tos Type
					$iCparams	= JComponentHelper::getParams('com_icagenda');
					$tos_Type	= $iCparams->get('tos_Type', '');
					$tosArticle	= $iCparams->get('tosArticle', '');
					$tosContent	= $iCparams->get('tosContent', '');

					$tosDEFAULT	= JText::sprintf( 'COM_ICAGENDA_TOS', $sitename, $sitename);
					$tosARTICLE	= 'index.php?option=com_content&view=article&id=' . $tosArticle . '&tmpl=component';
					$tosCUSTOM	= $tosContent;

					?>
					<div class="ic-tos-content bgButton">
						<div>
							<b><big><?php echo JText::_( 'COM_ICAGENDA_TERMS_OF_SERVICE'); ?></big></b>
						</div>
						<?php
						if ($tos_Type == 1)
						{
							echo '<iframe src="'.htmlentities($tosARTICLE).'" width="98%" height="150"></iframe>';
						}
						elseif ($tos_Type == 2)
						{
							echo '<div class="ic-tos-text">';
							echo $tosCUSTOM;
							echo '</div>';
						}
						else
						{
							echo '<div class="ic-tos-text">';
							echo $tosDEFAULT;
							echo '</div>';
						}
						?>
						<!--iframe src="<?php echo htmlentities($tosURL); ?>" width="98%" height="150"></iframe-->
						<div class="ic-tos-agree agreeToS">
							<p>
							<span><?php echo $tokenHTML; ?></span>
							<span id="formAgree-lbl" for="formAgree"><?php echo JText::_( 'COM_ICAGENDA_TERMS_OF_SERVICE_AGREE'); ?> *<label style="display:none" id="formAgree-lbl" for="formAgree"><?php echo JText::_( 'COM_ICAGENDA_TERMS_AND_CONDITIONS'); ?></label></span>
							</p>
						</div>

						<?php // RECAPTCHA ?>
						<?php if ($this->submit_captcha != '0') : ?>
						<div class="ic-control-group ic-clearfix">
							<div class="ic-control-label ic-captcha-label">
								<label> </label>
							</div>
							<div class="ic-controls">
								<?php echo $this->form->getInput('captcha'); ?>
							</div>
						</div>
						<br />
						<?php endif; ?>

						<div id="submit">
							<!--input id="submit" type="submit" value="<?php echo JText::_( 'COM_ICAGENDA_EVENT_FORM_SUBMIT' ); ?>" class="button" name="Submit" /--><!--  onclick="javascript:Recaptcha.reload()" -->
							<button type="submit" class="button validate">
								<?php echo JText::_('COM_ICAGENDA_EVENT_FORM_SUBMIT');?>
							</button>
							<input type="hidden" name="task" value="" />
							<input type="hidden" name="return" value="index.php" />
							<?php if (false) echo JHtml::_( 'form.token' ); ?>
						</div>
						<!--span class="buttonx">
							<a href="javascript:history.go(-1)" title="<?php echo JTEXT::_('COM_ICAGENDA_CANCEL'); ?>">
								<?php echo JTEXT::_('COM_ICAGENDA_CANCEL'); ?>
							</a>
						</span-->
					</div><?php // End Div bgButton ?>
					<?php
				}
				?>
			</div><?php // End Form Fields ?>
			<div style="clear:both"></div>
		</form>
	</div>

	<?php
	$limitSize = $this->submit_imageMaxSize;

	// Script to test Text Counter limit on mouse move and on scroll
	$ic_max_com_shortdesc	= JComponentHelper::getParams('com_icagenda')->get('char_limit_short_description', '100');
	$ic_max_shortdesc		= $this->params->get('char_limit_short_description', '100');
	$ic_max_shortdesc		= ($ic_max_com_shortdesc >= $ic_max_shortdesc) ? $ic_max_shortdesc : $ic_max_com_shortdesc;

	$ic_max_com_metadesc	= JComponentHelper::getParams('com_icagenda')->get('char_limit_meta_description', '160');
	$ic_max_metadesc		= $this->params->get('char_limit_meta_description', '160');
	$ic_max_metadesc		= ($ic_max_com_metadesc >= $ic_max_metadesc) ? $ic_max_metadesc : $ic_max_com_metadesc;

	$script = '<script type="text/javascript">';
	$script.= 'window.onmousemove = useractions;';
	$script.= 'window.onscroll = useractions;';
	$script.= 'function useractions()';
	$script.= '{';

	if ($this->submit_shortdescDisplay)
	{
		$script.= '	var shortdesc_control = document.getElementById("shortdesc");';
		$script.= '	var counter_shortdesc = document.getElementById("shortdesc-counter");';
		$script.= '	if (shortdesc_control.value.length > ' . $ic_max_shortdesc . ')';
		$script.= '	{';
		$script.= '		shortdesc_control.value = shortdesc_control.value.substring(0,' . $ic_max_shortdesc . ');';
		$script.= '		counter_shortdesc.value = 0;';
		$script.= '		shortdesc_control.addClass("ic-counter-limit");';
		$script.= '		counter_shortdesc.addClass("ic-counter-limit");';
		$script.= '		alert(Joomla.JText._("COM_ICAGENDA_ALERT_TEXT_EXCEEDS_CHARACTER_LIMIT"));';
		$script.= '		shortdesc_control.scrollIntoView();';
		$script.= '	}';
	}

	if ($this->submit_metadescDisplay)
	{
		$script.= '	var metadesc_control = document.getElementById("metadesc");';
		$script.= '	var counter_metadesc = document.getElementById("metadesc-counter");';
		$script.= '	if (metadesc_control.value.length > ' . $ic_max_metadesc . ')';
		$script.= '	{';
		$script.= '		metadesc_control.value = metadesc_control.value.substring(0,' . $ic_max_metadesc . ');';
		$script.= '		counter_metadesc.value = 0;';
		$script.= '		metadesc_control.addClass("ic-counter-limit");';
		$script.= '		counter_metadesc.addClass("ic-counter-limit");';
		$script.= '		alert(Joomla.JText._("COM_ICAGENDA_ALERT_TEXT_EXCEEDS_CHARACTER_LIMIT"));';
		$script.= '		metadesc_control.scrollIntoView();';
		$script.= '	}';
	}

	$script.= '}';
	$script.= '</script>';

	echo $script;

	// Disable submit button after first click
	JFactory::getDocument()->addScriptDeclaration('
		jQuery(function($) {
			$("#submitevent").one("submit", function() {
				$(this).find(\'button[type="submit"]\')
					.attr("disabled","disabled")
					.css({
						"background-color": "transparent",
						"color": "grey"
					});
				$("#submit").addClass("ic-loader");
			});
		});
	');
	?>

	<script type="text/javascript">
	jQuery(function($) {

		// var url = window.URL || window.webkitURL; // alternate use

		function readImage(file, accept, mimetype, limitSize) {

			var reader = new FileReader();
			var image  = new Image();

			reader.readAsDataURL(file);
			reader.onload = function(_file) {
				image.src    = _file.target.result;              // url.createObjectURL(file);
				image.onload = function() {
					var w = file.width,
						h = file.height,
						t = file.type,                           // ext only: // file.type.split('/')[1],
						n = file.name,
						size = ~~(file.size/1024),
						s = ~~(file.size/1024) +' <?php echo JText::_("IC_LIBRARY_KILO_BYTES"); ?>';

					if ( inArray(t, mimetype) )
					{
						if (size < limitSize)
						{
							$('#ic-upload-preview').empty();
							$('#ic-upload-preview').append('<center><img src="'+ image.src +'"><br />'+w+'x'+h+' - '+s+' - '+t+' - '+n+'</center><br />');
						}
						else
						{
							var uploadInvalidSize_string = "<?php echo JText::sprintf('IC_LIBRARY_UPLOAD_INVALID_SIZE', '<strong>"+ n +"</strong>', '"+ size +"', '"+ limitSize +"'); ?>";
							$('#ic-upload-preview').empty();
							$('#ic-upload-preview').append('<div class="alert alert-error">'+uploadInvalidSize_string+'</div>');
							$('input[name=image]').val('');
						}
					}
					else
					{
						$('#ic-upload-preview').empty();
						$('#ic-upload-preview').append('<div class="alert alert-error"><?php echo JText::sprintf("IC_LIBRARY_UPLOAD_INVALID_FILE_TYPE", "<strong>'+ n +'</strong>", "'+accept+'"); ?></div>');
						$('input[name=image]').val('');
					}
				};
				image.onerror= function() {
					alert('<?php echo JText::_("IC_LIBRARY_UPLOAD_INVALID_FILE_TYPE_ALERT"); ?> '+ file.type);
				};
			};

		}

		$("#image").change(function (e){
			if(this.disabled) return alert('<?php echo JText::_("IC_LIBRARY_UPLOAD_NOT_SUPPORTED"); ?>');
			var F = this.files;
			if(F && F[0]) for(var i=0; i<F.length; i++) readImage( F[i], "jpg, jpeg, png, gif", ['image/jpg','image/jpeg','image/png','image/gif'], "<?php echo $limitSize; ?>" );
		});
	});

	</script>

	<?php if ($this->submit_gmapDisplay) : ?>
	<script type="text/javascript">
		//<![CDATA[
		jQuery(function($) {
			var address_session = '<?php echo $address_session; ?>';

			if (address_session)
			{
				$('#address').val(address_session);
			}

			var addresspicker = $( "#addresspicker" ).addresspicker();
			var addresspickerMap = $( '#address' ).addresspicker({
				regionBias: "fr",
				updateCallback: showCallback,
				mapOptions: {
					zoom: <?php echo $zoom; ?>,
					center: new google.maps.LatLng(<?php echo $coords; ?>),
					scrollwheel: false,
					mapTypeId: google.maps.MapTypeId.<?php echo $mapTypeId; ?>,
					streetViewControl: false
				},
				elements: {
					map:      "#map",
					lat:      "#lat",
					lng:      "#lng",
					street_number: '#street_number',
					route: '#route',
					locality: '#locality',
					administrative_area_level_2: '#administrative_area_level_2',
					administrative_area_level_1: '#administrative_area_level_1',
					country:  '#country',
					postal_code: '#postal_code',
					type:    '#type',
				}
			});

			var gmarker = addresspickerMap.addresspicker( "marker");
			gmarker.setVisible(true);
			addresspickerMap.addresspicker( "updatePosition");

			$('#reverseGeocode').change(function(){
				$("#address").addresspicker("option", "reverseGeocode", ($(this).val() === 'true'));
			});

			function showCallback(geocodeResult, parsedGeocodeResult){
				$('#callback_result').text(JSON.stringify(parsedGeocodeResult, null, 4));
			}
  		});
		//]]>
	</script>
	<?php endif; ?>

	<?php
	// clear the data so we don't process it again
	$session->clear('ic_submit');
	$session->clear('custom_fields');
	$session->clear('ic_submit_dates');
	$session->clear('ic_submit_catid');
	$session->clear('ic_submit_shortdesc');
	$session->clear('ic_submit_metadesc');
	$session->clear('ic_submit_city');
	$session->clear('ic_submit_country');
	$session->clear('ic_submit_lat');
	$session->clear('ic_submit_lat');
	$session->clear('ic_submit_address');
	$session->clear('ic_submit_tos');
	$session->clear('email2');

	// Script validation for Submit Event form (2)
	if (!$this->submit_form_validation)
	{
		$iCheckForm = icagendaForm::submit(2);
		JFactory::getDocument()->addScriptDeclaration($iCheckForm);
	}

	if (file_exists("components/com_icagenda/themes/packs/".$this->template."/css/".$this->template."_component.css"))
	{
		$css_component	= '/components/com_icagenda/themes/packs/'.$this->template.'/css/'.$this->template.'_component.css';
		$css_com_rtl	= '/components/com_icagenda/themes/packs/'.$this->template.'/css/'.$this->template.'_component-rtl.css';
	}
	else
	{
		$css_component	= '/components/com_icagenda/themes/packs/default/css/default_component.css';
		$css_com_rtl	= '/components/com_icagenda/themes/packs/default/css/default_component-rtl.css';
	}
	// Add the media specific CSS to the document
	JLoader::register('iCagendaMediaCss', JPATH_ROOT . '/components/com_icagenda/helpers/media_css.class.php');
	iCagendaMediaCss::addMediaCss($this->template, 'component');

	// Theme pack component css
	$document->addStyleSheet( JURI::base( true ) . $css_component );

	// RTL css if site language is RTL
	$lang = JFactory::getLanguage();

	if ( $lang->isRTL()
		&& file_exists( JPATH_SITE . $css_com_rtl) )
	{
		$document->addStyleSheet( JURI::base( true ) . $css_com_rtl );
	}

	// Joomla 2.5
	if (version_compare(JVERSION, '3.0', 'lt'))
	{
		JHtml::stylesheet( 'com_icagenda/icagenda-front.j25.css', false, true );

		JHtml::_('behavior.framework');

		// load jQuery, if not loaded before (NEW VERSION IN 1.2.6)
		$scripts = array_keys($document->_scripts);
		$scriptFound = false;
		$scriptuiFound = false;
		$mapsgooglescriptFound = false;

		for ($i = 0; $i < count($scripts); $i++)
		{
			if (stripos($scripts[$i], 'jquery.min.js') !== false)
			{
					$scriptFound = true;
			}
			// load jQuery, if not loaded before as jquery - added in 1.2.7
			if (stripos($scripts[$i], 'jquery.js') !== false)
			{
				$scriptFound = true;
			}
			if (stripos($scripts[$i], 'jquery-ui.min.js') !== false)
			{
				$scriptuiFound = true;
			}
			if (stripos($scripts[$i], 'maps.google') !== false)
			{
				$mapsgooglescriptFound = true;
			}
		}

		// jQuery Library Loader
		if (!$scriptFound)
		{
			// load jQuery, if not loaded before
			if (!JFactory::getApplication()->get('jquery'))
			{
				JFactory::getApplication()->set('jquery', true);
				// add jQuery
				$document->addScript('https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js');
				JHtml::script('com_icagenda/jquery.noconflict.js', false, true);
			}
		}

		if (!$scriptuiFound)
		{
			$document->addScript('https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js');
		}
	}
	// Joomla 3
	else
	{
		JHtml::_('bootstrap.framework');
		JHtml::_('jquery.framework');

		/**
		 * Change jQuery UI version from 1.9.2 to 1.8.23 (joomla version, but not complete)
		 * to prevent a conflict in tooltip that appeared since Joomla 3.1.4
		 */
//		$document->addScript('https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js');
		$document->addScript( 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js' );
	}

	/**
	 * Google Maps api V3
	 */
	if ($this->submit_gmapDisplay)
	{
		$curlang	= $document->language;
		$lang		= substr($curlang, 0, 2);
		$document->addScript('https://maps.googleapis.com/maps/api/js?sensor=false&language=' . $lang);
		JHtml::script( 'com_icagenda/icmap.js', false, true );
	}

	/**
	 * Script files which could be overridden into your site template.
	 * (eg. /templates/my_template/js/com_icagenda/FILE_NAME.js)
	 */
	JHtml::script( 'com_icagenda/timepicker.js', false, true );
	JHtml::script( 'com_icagenda/icdates.js', false, true );
	JHtml::script( 'com_icagenda/jquery.tipTip.js', false, true );
	JHtml::script( 'com_icagenda/icagenda.js', false, true );
	JHtml::script( 'com_icagenda/icform.js', false, true );

	$iCtip	 = array();
	$iCtip[] = '	jQuery(document).ready(function(){';
	$iCtip[] = '		jQuery(".iCFormTip").tipTip({maxWidth: "280px", defaultPosition: "right", edgeOffset: 5});';
	$iCtip[] = '	});';

	// Add the script to the document head.
	JFactory::getDocument()->addScriptDeclaration(implode("\n", $iCtip));
}
