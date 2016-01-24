<?php defined('_JEXEC') or die(); ?>

<div style="text-align:center"><img src='../media/com_icagenda/images/iconicagenda48.png' alt='iCagenda' /><br/><big style="color:#555">ChangeLog</big></div>
================================================================================
? <center><strong><big>Welcome to iCagenda 3.5.13 release!</big></strong></center><br />This is a maintenance release. See the release notes for details.<br />We recommend every user to update, to keep your iCagenda updated.<br />
================================================================================
: <span class="ic-box-important ic-box-12">!</span><span class="ic-important">important</span>&nbsp;<span class="ic-box-added ic-box-12">+</span><span class="ic-added">added</span>&nbsp;<span class="ic-box-removed ic-box-12">-</span><span class="ic-removed">removed</span>&nbsp;<span class="ic-box-changed ic-box-12">~</span><span class="ic-changed">changed</span>&nbsp;<span class="ic-box-fixed ic-box-12">#</span><span class="ic-fixed">fixed</span><br/><i>Info: access to the beta versions and pre-releases are reserved to users with a valid pro subscription.</i><br/>iCagenda™ is distributed under the terms of the GNU General Public License version 3 or later; see LICENSE.txt.
================================================================================


iCagenda 3.5.13 <small style="font-weight:normal;">(2015.12.05)</small>
================================================================================
+ Added : in registrations csv export, new option to display 'created date' (when the user registered).
# [MEDIUM] Fixed : error getimagesize if original image deleted.
# [LOW] Fixed : not able to get user groups after logged-in user changed his password in frontend (return error message in component and modules).
# [LOW] Fixed : issue since Joomla 3.4.5 with upload of custom Theme Packs.
# [LOW] Fixed : issue with date and DST (Day Saving Time) with export to Outlook.
# [LOW] Fixed : private access level for event information was broken if custom fields.
# [LOW] Fixed : admin language ordering in events list.
# [LOW] Fixed : category and search list filters with no effect in registration csv export.
# [MODULE iC calendar][LOW] Fixed : Loading calendar on defined month/year not working in some cases.

* Changed files in 3.5.13
~ admin/controllers/registrations.raw.php
~ admin/models/events.php
~ admin/models/forms/download.xml
~ admin/models/registrations.php
~ admin/models/themes.php
~ admin/utilities/events/data.php
~ admin/utilities/events/events.php
~ admin/utilities/menus/menus.php
~ [LIBRARY] libraries/ic_library/thumb/get.php
~ [MODULE][PRO] modules/mod_ic_event_list/mod_ic_event_list.php
~ [MODULE] modules/mod_iccalendar/helper.php
~ [MODULE] modules/mod_iccalendar/mod_iccalendar.php
~ [PLUGIN] plugins/search/icagenda/icagenda.php
~ site/helpers/icmodel.php
~ site/models/events.php
~ site/models/submit.php
~ site/themes/packs/default/default_day.php
~ site/themes/packs/default/default_event.php
~ site/themes/packs/ic_rounded/ic_rounded_day.php
~ site/themes/packs/ic_rounded/ic_rounded_event.php
~ site/views/list/tmpl/default_vcal.php
~ site/views/list/tmpl/event.php

iCagenda 3.5.12 <small style="font-weight:normal;">(2015.10.12)</small>
================================================================================
+ Added : option field 'Time display' in 'Submit an event' form.
+ Added : global option to Select if 'Time Display' option is set by default on 'Show' or 'hide' when creating a new event ('General Settings' tab of the Global Options of the component).
+ Added : missing separator option in global options for date format.
+ [MODULE iC calendar] Added : option to set custom limit for auto-intro description.
+ [MODULE iC Event List][PRO] Added : option to set HTML filtering for auto-intro description.
~ Changed : use global date format option in registrations list, and display start and end date when registration for a period.
# [MODULE iC calendar][LOW] Fixed : display of "booking closed" when events only singles dates, and all upcoming, but registration type option for this event is set to "for all dates of the event".
# [MODULE iC calendar][LOW] Fixed : in "auto" mode for option "Link to Menu Item", the global option for filter by dates was not defined, if not on a list of events page ("auto" not working properly in this case, in a few cases, depending of your settings, if one at least of the menu item(s) to a list of events was set to use global options for Filter by dates).
# [MODULE iC calendar][LOW] Fixed : option for filtering HTML tags of intro-text not working in tooltip if not on list of events page.
# [LOW] Fixed : not displaying full address if country and/or city included in the place name.
# [LOW] Fixed : display of long content in registrations admin list (overlap in data display).

* Changed files in 3.5.12
~ admin/config.xml
~ admin/models/event.php
~ admin/models/forms/event.xml
~ admin/models/registrations.php
~ admin/utilities/events/events.php
~ admin/utilities/menus/menus.php
~ admin/views/registrations/tmpl/default.php
~ [MODULE][PRO] modules/mod_ic_event_list/helper.php
~ [MODULE][PRO] modules/mod_ic_event_list/mod_ic_event_list.php
~ [MODULE][PRO] modules/mod_ic_event_list/mod_ic_event_list.xml
~ [MODULE][PRO] modules/mod_ic_event_list/tmpl/default.php
~ [MODULE][PRO] modules/mod_ic_event_list/tmpl/icrounded.php
~ [MODULE] modules/mod_iccalendar/helper.php
~ [MODULE] modules/mod_iccalendar/mod_iccalendar.xml
~ script.icagenda.php
~ site/add/elements/icsetvar.php
~ site/helpers/icmodel.php
~ site/models/forms/submit.xml
~ site/views/submit/tmpl/default.php
~ site/views/submit/tmpl/default.xml
~ site/views/submit/view.html.php


iCagenda 3.5.11 <small style="font-weight:normal;">(2015.09.05)</small>
================================================================================
# [LOW] Fixed : date format with short month broken (in 3.5.10).
# [LOW] Fixed : date format with separator broken (since 3.5.6).
# [MODULE iC calendar][LOW] Fixed : display of current month, whereas option 'Loading on Date' is set on a day of the previous month.

* Changed files in 3.5.11
~ [LIBRARY] libraries/ic_library/globalize/culture/en-GB.php
~ [LIBRARY] libraries/ic_library/globalize/culture/en-US.php
~ [LIBRARY] libraries/ic_library/globalize/culture/fa-IR.php
~ [LIBRARY] libraries/ic_library/globalize/globalize.php
~ [MODULE] modules/mod_iccalendar/helper.php
~ [MODULE] modules/mod_iccalendar/mod_iccalendar.php
~ site/helpers/ichelper.php
~ site/helpers/icmodel.php


iCagenda 3.5.10 <small style="font-weight:normal;">(2015.09.01)</small>
================================================================================
+ Added : Compatible with Jalali/Persian calendar in admin (use of Joomla calendar for datetime picker).
+ Added : missing field to select 'Registration type' in the 'Submit an event' form, if registration options displayed.
+ Added : function to disable the submit button in frontend forms, after first click (to prevent multiple clicks during data process).
~ Changed : Asynchronous Loading of the AddThis widget script
~ Changed : auto-detect if https/ssl server for loading the AddThis widget script.
~ [MODULE iC calendar] Changed : you can now select one of the seven days of the week, as the first day of the calendar.
~ [THEME PACK] Changed : registration header is simplified, and use now its own css classes (ic-reg + suffix)
~ [THEME PACK] Changed : new ic-current-period class used to replace inline css when for the overline when period started and current (box date in list of events)
# [LOW] Fixed : a few issues with Jalali calendar in frontend (day 31 of a period not dislayed in calendar, possible datetime contruct error if no single dates in event details view).
# [LOW] Fixed : if only single dates with no period, and registration type option set to "for all dates of event", the date in registration email notifications was wrong.
# [LOW] Fixed : loading of event custom fields in registrations list if same id (missing parent_form control).
# [LOW] Fixed : date could include non-breaking space (&nbsp;) in notification email.
# [MODULE iC Event List][LOW] Fixed : display of month in the date box, on last day of a month (eg. 31 August) was next month, and not current month.

* Changed files in 3.5.10
~ admin/models/fields/modal/date.php
~ admin/models/fields/modal/enddate.php
~ admin/models/fields/modal/startdate.php
~ admin/tables/event.php
~ admin/utilities/customfields/customfields.php
~ admin/utilities/events/events.php
~ admin/utilities/form/form.php
~ admin/views/icagenda/tmpl/default.php
~ admin/views/registrations/tmpl/default.php
+ [LIBRARY] libraries/ic_library/globalize/convert.php
~ [LIBRARY] libraries/ic_library/globalize/globalize.php
+ [MEDIA] media/images/loader.gif
~ [MEDIA] media/js/icdates.js
~ [MODULE][PRO] modules/mod_ic_event_list/mod_ic_event_list.php
~ [MODULE] modules/mod_iccalendar/helper.php
~ [MODULE] modules/mod_iccalendar/mod_iccalendar.php
~ [MODULE] modules/mod_iccalendar/mod_iccalendar.xml
~ site/add/elements/icsetvar.php
~ site/helpers/icmodel.php
~ site/models/forms/submit.xml
~ site/models/submit.php
~ [THEME PACK] site/themes/packs/default/css/default_component.css
~ [THEME PACK] site/themes/packs/default/default_registration.php
~ [THEME PACK] site/themes/packs/ic_rounded/css/ic_rounded_component.css
~ [THEME PACK] site/themes/packs/ic_rounded/ic_rounded_events.php
~ [THEME PACK] site/themes/packs/ic_rounded/ic_rounded_registration.php
~ site/views/list/tmpl/registration.php
~ site/views/submit/tmpl/default.php


iCagenda 3.5.9 <small style="font-weight:normal;">(2015.08.01)</small>
================================================================================
! Added options for export in csv of a list of registrations (select info to be exported, and select between comma or semicolon as separator for values)
! You can now send a newsletter for all users registered for an event (all dates), or only for users registered to only one date (or period) of the event.
~ Changed : dropdowns for event and date in registration form, as well as for newsletter now use ajax for updating the date depending of the selected event, without reloading the page.
~ Changed : set 'All Events' as default value for 'Filter by Dates' global option (on new install).
~ [THEME PACK] Changed : ic_rounded module calendar css for table, by addition of class ic-table (minor change to prevent some possible css conflict with site template).
~ Changed : minimum joomla 3 release is now 3.2.3 (for websites using iCagenda on Joomla 3).
# [MEDIUM] Fixed : when trying to change state of a registration (broken since 3.5.7) the event state was sometimes changed in the same time (but not removed from database). Sorry for any inconvenience.
# [LOW] Fixed : change state not working in admin registrations list (not possible to trash or unpublished a registration entry).
# [LOW] Fixed : lost of changes if changing event in registration admin edition (fixed by using ajax to generate the date list).
# [MODULES][LOW] Fixed : 'Filter by dates' could be broken for modules, if set in all menus to 'Use Global', and set to 'All Events' in global options.
# [MODULE iC Event List][LOW] Fixed : notice error if no events to be displayed (undefined variable).

* Changed files in 3.5.9
~ admin/config.xml
~ admin/controllers/mail.php
~ admin/controllers/registration.php
~ admin/controllers/registrations.php
~ admin/controllers/registrations.raw.php
~ admin/models/fields/modal/evt.php
~ admin/models/fields/modal/evt_date.php
- admin/models/fields/modal/mailinglist.php
~ admin/models/forms/download.xml
~ admin/models/forms/mail.xml
~ admin/models/forms/registration.xml
~ admin/models/mail.php
~ admin/models/registration.php
~ admin/models/registrations.php
- admin/tables/mail.php
~ admin/tables/registration.php
+ admin/utilities/ajax/ajax.php
~ admin/utilities/events/events.php
~ admin/utilities/menus/menus.php
~ admin/views/mail/tmpl/edit.php
~ admin/views/mail/view.html.php
~ admin/views/registration/tmpl/edit.php
~ admin/views/registrations/tmpl/default.php
~ admin/views/registrations/view.html.php
~ [MODULE][PRO] modules/mod_ic_event_list/mod_ic_event_list.php
~ [MODULE] modules/mod_iccalendar/helper.php
~ script.icagenda.php
~ [THEME PACK] site/themes/packs/ic_rounded/css/ic_rounded_module.css


iCagenda 3.5.8 <small style="font-weight:normal;">(2015.07.17)</small>
================================================================================
# [MODULE iC Calendar][LOW] Fixed : no events displayed in the calendar if menus option 'Filter by dates' is set to 'Use Global' (Sorry for any inconvenience).

* Changed files in 3.5.8
~ admin/utilities/menus/menus.php


iCagenda 3.5.7 <small style="font-weight:normal;">(2015.07.16)</small>
================================================================================
+ Added : publishing info for registrations; Created date/by (null if registration processed before update to 3.5.7 or later) and Modified date/by.
+ [MODULES] Added: alert message with number of events not displayed, when a user with admin permissions is logged-in in frontend (see current fix in modules for events with no menu link to allow the display.).
~ Changed : end time for single dates is now assumed to be midnight, when filtering today's events.
~ [THEME PACK] Changed : remove inline css used before to display Terms of Service, and use new names for the css classes.
# [MODULES][LOW] Fixed : no display of events if no menu link allows the display.
# [MODULE iC Calendar][LOW] Fixed : possible script conflict if joomla timezone or server timezone selected (highlightToday issue).
# [MODULE iC Calendar][LOW] Fixed : no display of December events.
# [LOW] Fixed : filtering of space for dates in notification emails if mail received in plain text.
# [LOW] Fixed : possible notice 'Undefined variable: dateglobalize_#' in backend, related to date format option (depends on your admin language).
# [LOW] Fixed : wrong place of a closing div in list of events (3.5.6).
# [LOW] Fixed : edit own access for registrations (user with only edit own access permissions, will see only its own registrations in the list).
# [LOW] Fixed : JS notice empty value if Terms of Services not displayed in registration form.

* Changed files in 3.5.7
~ admin/controllers/registration.php
~ admin/controllers/registrations.php
~ admin/models/fields/iclist/globalization.php
~ admin/models/forms/customfield.xml
~ admin/models/forms/event.xml
~ admin/models/forms/registration.xml
~ admin/models/registration.php
~ admin/models/registrations.php
~ admin/sql/install/mysql/icagenda.install.sql
~ admin/utilities/events/data.php
~ admin/utilities/events/events.php
~ admin/utilities/form/form.php
~ admin/utilities/menus/menus.php
~ admin/views/event/tmpl/edit.php
~ admin/views/registration/tmpl/edit.php
~ admin/views/registrations/tmpl/default.php
~ [LIBRARY] libraries/ic_library/globalize/globalize.php
~ [MODULE][PRO] modules/mod_ic_event_list/css/default_style.css
~ [MODULE][PRO] modules/mod_ic_event_list/css/icrounded_style.css
~ [MODULE][PRO] modules/mod_ic_event_list/helper.php
~ [MODULE][PRO] modules/mod_ic_event_list/mod_ic_event_list.php
~ [MODULE] modules/mod_iccalendar/helper.php
~ [MODULE] modules/mod_iccalendar/mod_iccalendar.php
~ site/helpers/icmodel.php
~ site/models/events.php
~ site/models/submit.php
~ [THEME PACK] site/themes/packs/default/css/default_component.css
~ [THEME PACK] site/themes/packs/default/css/default_module.css
~ [THEME PACK] site/themes/packs/ic_rounded/css/ic_rounded_component.css
~ [THEME PACK] site/themes/packs/ic_rounded/css/ic_rounded_module.css
~ site/views/list/tmpl/default.php
~ site/views/list/tmpl/registration.php
~ site/views/submit/tmpl/default.php


iCagenda 3.5.6 <small style="font-weight:normal;">(2015.06.29)</small>
================================================================================
+ Added : Compatible with Jalali/Persian calendar in frontend.
~ Changed : Update of Info page (addition of credits: languages and external libraries).
~ Changed : Improvement of add to cal function for a better export to external calendars.
~ Changed : Improvement of valid dates control in frontend submit an event form.
~ Changed : migration of globalize date format function to the iC Library, and improvement.
# [MEDIUM] Fixed : delete custom fields data of an event if this one is deleted.
# [LOW] Fixed : add to cal issue when hide time selected.
# [LOW] Fixed : date/dates display in event details depending of number of dates for a period.
# [LOW] Fixed : registration button was not active when event with a past period, but upcoming single dates.
# [LOW] Fixed : line return in Notes field, when exporting list of registrations to csv.
# [LOW] Fixed : confirmed email field (registration form) was not removed from the session.
# [LOW] Fixed : no display of a few dates in today's events filtering (when period with weekdays, and event running).

* Changed files in 3.5.6
~ admin/add/ renamed admin/assets/
+ admin/assets/jcms/info.php
~ admin/config.xml
~ admin/controller.php
- [FOLDER] admin/globalization/
~ admin/icagenda.php
~ admin/models/event.php
~ admin/models/events.php
~ admin/models/fields/iclist/globalization.php
~ admin/models/fields/modal/date.php
~ admin/models/fields/modal/evt_date.php
~ admin/models/forms/event.xml
~ admin/models/registration.php
~ admin/models/registrations.php
~ admin/sql/install/mysql/icagenda.install.sql
~ admin/tables/registration.php
~ admin/utilities/customfields/customfields.php
~ admin/utilities/events/data.php
~ admin/utilities/events/events.php
+ admin/utilities/info/info.php
~ admin/views/category/tmpl/edit.php
~ admin/views/customfield/tmpl/edit.php
~ admin/views/event/tmpl/edit.php
~ admin/views/event/view.html.php
~ admin/views/events/tmpl/default.php
~ admin/views/events/view.html.php
~ admin/views/feature/tmpl/edit.php
~ admin/views/icagenda/tmpl/default.php
~ admin/views/icagenda/view.html.php
~ admin/views/info/tmpl/default.php
~ admin/views/info/view.html.php
~ admin/views/mail/tmpl/edit.php
~ admin/views/registration/tmpl/edit.php
~ admin/views/registration/view.html.php
~ admin/views/registrations/view.html.php
~ admin/views/themes/tmpl/default.php
~ icagenda.xml
~ [LIBRARY] libraries/ic_library/date/date.php
+ [LIBRARY][FOLDER] libraries/ic_library/globalize/
+ [LIBRARY] libraries/ic_library/globalize/culture/fa-IR.php
+ [LIBRARY] libraries/ic_library/globalize/globalize.php
~ [LIBRARY] libraries/ic_library/lib_ic_library.xml
~ [LIBRARY] libraries/ic_library/library/library.php
~ [LIBRARY] libraries/ic_library/string/string.php
~ [MEDIA] media/css/icagenda-back.css
~ [MEDIA] media/css/icagenda-front.css
~ [MEDIA] media/css/icagenda-front.j25.css
~ [MEDIA] media/js/icdates.js
~ [MODULE][PRO] modules/mod_ic_event_list/mod_ic_event_list.php
~ [MODULE][PRO] modules/mod_ic_event_list/mod_ic_event_list.xml
~ [MODULE] modules/mod_iccalendar/helper.php
~ [MODULE] modules/mod_iccalendar/mod_iccalendar.php
~ [MODULE] modules/mod_iccalendar/mod_iccalendar.xml
~ script.icagenda.php
~ site/helpers/ichelper.php
~ site/helpers/icmodel.php
~ site/models/events.php
~ site/models/forms/submit.xml
~ site/models/list.php
~ site/models/submit.php
~ [THEME PACK] site/themes/packs/default/css/default_component.css
~ [THEME PACK] site/themes/packs/default/css/default_module.css
~ [THEME PACK] site/themes/packs/default/default_calendar.php
~ [THEME PACK] site/themes/packs/default/default_day.php
~ [THEME PACK] site/themes/packs/default/default_event.php
~ [THEME PACK] site/themes/packs/default/default_events.php
~ [THEME PACK] site/themes/packs/default/default_registration.php
~ [THEME PACK] site/themes/packs/ic_rounded/css/ic_rounded_component.css
~ [THEME PACK] site/themes/packs/ic_rounded/css/ic_rounded_module.css
~ [THEME PACK] site/themes/packs/ic_rounded/ic_rounded_calendar.php
~ [THEME PACK] site/themes/packs/ic_rounded/ic_rounded_day.php
~ [THEME PACK] site/themes/packs/ic_rounded/ic_rounded_event.php
~ [THEME PACK] site/themes/packs/ic_rounded/ic_rounded_events.php
~ [THEME PACK] site/themes/packs/ic_rounded/ic_rounded_registration.php
~ site/views/list/tmpl/actions.php
~ site/views/list/tmpl/default.php
~ site/views/list/tmpl/default.xml
~ site/views/list/tmpl/default_vcal.php
~ site/views/list/tmpl/event.php
~ site/views/list/tmpl/registration.php
~ site/views/list/view.html.php
~ site/views/submit/tmpl/default.php
~ site/views/submit/tmpl/default.xml
~ site/views/submit/tmpl/send.php
~ site/views/submit/view.html.php


iCagenda 3.5.5 <small style="font-weight:normal;">(2015.04.27)</small>
================================================================================
~ Changed : removal of v1 and v2 release notes (link to online change log for these versions).
# [MEDIUM] Fixed : issue with admin event edition on IE (script error only on Internet Explorer).
# [LOW] Fixed : wrong file jquery.tipTip.js was included in 3.5.4. This version includes the correct new one with tooltip position fix (as announced in previous release).

* Changed files in 3.5.5
~ admin/CHANGELOG.php
~ [MEDIA] media/js/icdates.js
~ [MEDIA] media/js/jquery.tipTip.js


iCagenda 3.5.4 <small style="font-weight:normal;">(2015.04.24)</small>
================================================================================
! JComments ready : You can download the free iC JComments plugin to enable comments on events (http://icagenda.joomlic.com/resources/addons).
+ [GLOBALIZATION] Added : fa-IR Persan (Iran) date formats.
+ Added : global option to set text transformation of the event title (Global Options > General Settings tab).
+ Added : check image name in frontend 'Submit an Event form', and if file extension is missing, add the correct one.
~ Changed : location of css and js core files (removed from admin and site folder, and moved to media).
~ Changed : improve datetime picker validation (no need to click on validate button to be sure date entered is saved).
# [MEDIUM] Fixed : missing 404 error page, when SEF is enabled, and event alias in url doesn't exist (was returning the first event found).
# [MEDIUM] Fixed : Persan language issue, fixed date construct fatal error.
# [LOW] Fixed : possible iCtip position issue (add to cal, print... tooltip) if another script is changing window top offset().
# [LOW] Fixed : broken url to event details view in registration form header.
# [LOW] Fixed : broken approval icon function in admin list of events.
# [LOW] Fixed : special characters in breadcrumbs.
# [LOW] Fixed : Nb of registered user, if only one single date, and registration type is changed after a few registrations occured.

* Changed files in 3.5.4
- [FOLDER] admin/add/css/
~ admin/add/elements/desc.php
~ admin/add/elements/title.php
+ admin/add/elements/titleheader.php
~ admin/add/elements/titleimg.php
- [FOLDER] admin/add/image/
~ admin/config.xml
+ admin/globalization/fa-IR.php
~ admin/models/event.php
~ admin/models/forms/event.xml
~ admin/tables/feature.php
~ admin/utilities/customfields/customfields.php
~ admin/utilities/events/data.php
~ admin/utilities/events/events.php
~ admin/utilities/form/form.php
~ admin/views/categories/view.html.php
~ admin/views/category/tmpl/edit.php
~ admin/views/customfield/tmpl/edit.php
~ admin/views/customfields/view.html.php
~ admin/views/event/tmpl/edit.php
~ admin/views/events/tmpl/default.php
~ admin/views/events/view.html.php
~ admin/views/feature/tmpl/edit.php
~ admin/views/feature/view.html.php
~ admin/views/features/view.html.php
~ admin/views/icagenda/tmpl/default.php
~ admin/views/icagenda/view.html.php
~ admin/views/info/tmpl/default.php
~ admin/views/info/view.html.php
~ admin/views/mail/view.html.php
~ admin/views/registration/tmpl/edit.php
~ admin/views/registrations/view.html.php
~ admin/views/themes/tmpl/default.php
~ icagenda.xml
~ [LIBRARY] libraries/ic_library/date/period.php
~ [LIBRARY] libraries/ic_library/thumb/get.php
~ [MEDIA] media/css/icagenda-back.css
+ [MEDIA] media/css/icagenda-back.j25.css
~ [MEDIA] media/css/icagenda-front.css
+ [MEDIA] media/css/icagenda-front.j25.css
~ [MEDIA] media/css/icagenda.css
+ [MEDIA][FOLDER] media/css/images/
+ [MEDIA] media/css/jquery-ui-1.8.17.custom.css
+ [MEDIA] media/css/template.j25.css
~ [MEDIA][ICICONS][UPDATE] media/icicons/
~ [MEDIA][IMAGES][UPDATE] media/images/
~ [MEDIA] media/js/icdates.js
+ [MEDIA] media/js/icmap-front.js
~ [MEDIA] media/js/jquery.tipTip.js
~ [MODULE][PRO] modules/mod_ic_event_list/mod_ic_event_list.php
~ [MODULE] modules/mod_iccalendar/helper.php
~ [MODULE] modules/mod_iccalendar/mod_iccalendar.php
~ script.icagenda.pro.php
- [FOLDER] site/add/css/
~ site/add/elements/icsetvar.php
- [FOLDER] site/add/image/
~ site/controller.php
~ site/helpers/ichelper.php
~ site/helpers/icmodel.php
- [FOLDER] site/js/
~ site/models/forms/submit.xml
~ site/models/list.php
~ site/models/submit.php
~ site/router.php
~ [THEME PACK] site/themes/packs/default/css/default_component.css
~ [THEME PACK] site/themes/packs/default/default_events.php
~ [THEME PACK] site/themes/packs/default/default_registration.php
~ [THEME PACK] site/themes/packs/ic_rounded/css/ic_rounded_component.css
~ [THEME PACK] site/themes/packs/ic_rounded/ic_rounded_events.php
~ [THEME PACK] site/themes/packs/ic_rounded/ic_rounded_registration.php
+ site/views/list/tmpl/actions.php
~ site/views/list/tmpl/default.php
~ site/views/list/tmpl/default_categories.php
~ site/views/list/tmpl/event.php
~ site/views/list/tmpl/registration.php
~ site/views/list/view.html.php
~ site/views/submit/tmpl/default.php
~ site/views/submit/tmpl/send.php
~ site/views/submit/view.html.php


iCagenda 3.5.3 <small style="font-weight:normal;">(2015.03.25)</small>
================================================================================
+ Added : Confirm Email field in frontend Registration form, for not logged-in user.
+ Added : BOM utf-8 to csv export file (special characters).
~ Changed : improvement of the model for admin event edition.
~ Changed : postal code is now displayed (if available) in frontend address field.
# [MEDIUM] Fixed : saving of custom fields and features when new event (with not yet an ID) was broken (no data saved).
# [THEME PACKS][LOW] Fixed : display of empty participants list when registration not enabled.
# [LOW] Fixed : display of information details in event details view, was not always displayed depending of options and data filled.
# [LOW] Fixed : register button when only a single date, and the list display type is not set to display all dates.
# [LOW] Fixed : added back the alert message on Joomla 2.5 about the impossibility of trashing frontend submitted events if not edited (the issue with trash and empty asset_id is fixed in latest version of Joomla 3).

* Changed files in 3.5.3
~ admin/config.xml
~ admin/models/event.php
~ admin/models/fields/modal/ictext_placeholder.php
~ admin/models/forms/event.xml
~ admin/models/registrations.php
~ admin/tables/event.php
~ admin/utilities/events/data.php
~ admin/views/events/tmpl/default.php
~ admin/views/registrations/view.raw.php
~ [MODULE] modules/mod_iccalendar/helper.php
~ site/add/elements/icsetvar.php
~ site/helpers/ichelper.php
~ site/helpers/icmodel.php
~ site/models/list.php
~ [THEME PACKS] site/themes/packs/default/default_event.php
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_event.php
~ site/views/list/tmpl/event.php
~ site/views/list/tmpl/registration.php
~ site/views/list/view.html.php


iCagenda 3.5.2 <small style="font-weight:normal;">(2015.03.13)</small>
================================================================================
~ Changed : name/username allows now numeric characters (server-side iCagenda validator), and addition of joomla client-side username validation.
~ Changed : minor re-ordering of period options in admin edition of an event, with info text for weekdays.
# [MEDIUM] Fixed : function to generate small icons in Features was broken.
# [LOW] Fixed : Custom fields data broken in csv export of registrations.
# [LOW] Fixed : Number of registered users, for events over a period with no weekdays selected.
# [LOW] Fixed : List of participants was broken if 'Avatar' and/or 'Username' list display option was selected (option 'Full' was working as expected).
# [LOW] Fixed : Url to event details view could return a wrong number of registered user if a period with no weekdays selected (component list of events).
# [LOW] Fixed : notice error when php function dateInterval does not exist on your server.
# [LOW] Fixed : improvement of the function to get the current layout.
# [LOW] Fixed : a few date format buggy depending of your settings, and the current language used.
# [LOW] Fixed : notice error $translator not defined in control panel (language issue) only on free version.
# [LOW] Fixed : filters display issue in registration admin list on Joomla 2.5 when event title length too high.
# [MODULE iC Event List][LOW] Fixed : blur x-small thumbs when created in admin.

* Changed files in 3.5.2
~ admin/add/css/icagenda.j25.css
~ admin/models/fields/modal/thumbs.php
~ admin/models/forms/event.xml
~ admin/models/registrations.php
~ admin/tables/feature.php
~ admin/views/event/tmpl/edit.php
~ admin/views/events/tmpl/default.php
~ admin/views/icagenda/tmpl/default.php
~ admin/views/registrations/tmpl/default.php
~ [LIBRARY] libraries/ic_library/date/period.php
~ [LIBRARY] libraries/ic_library/thumb/get.php
~ [MODULE][PRO] modules/mod_ic_event_list/tmpl/icrounded.php
~ site/add/elements/icsetvar.php
~ site/helpers/ichelper.php
~ site/helpers/icmodel.php
~ site/models/forms/submit.xml
~ site/models/list.php
~ [THEME PACKS] site/themes/packs/default/css/default_component.css
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_component.css
~ site/views/list/tmpl/registration.php
~ site/views/list/view.html.php
~ site/views/submit/tmpl/default.php
~ site/views/submit/view.html.php


iCagenda 3.5.1 <small style="font-weight:normal;">(2015.03.01)</small>
================================================================================
~ [MODULE iC calendar] Cleaned : not needed data attributs in arrows navigation.
# [MEDIUM] Fixed : no display of events if access registered, and user logged-in is not a Super User.
# [LOW] Fixed : possible issue with Joomla 3.4.0 (not saving event due to a script conflict), if admin module 'Multilanguage status' published (change of the modal for this module, using now Bootstrap).
# [LOW] Fixed : minor error issue in script used in edit form (admin) for link option on register button.
# [LOW] Fixed : 'No tickets are available for this date' displayed if no registration done for an event.
# [LOW] Fixed : incorrect count of available and booked tickets when Registration Type is set to 'all dates of the period'.
# [LOW] Fixed : link to view event after registration, not linking to registered date event view.

* Changed files in 3.5.1
~ admin/models/event.php
~ admin/models/fields/modal/iclink_article.php
~ admin/models/fields/modal/iclink_type.php
~ admin/models/fields/modal/iclink_url.php
~ admin/utilities/events/data.php
~ admin/utilities/form/form.php
~ admin/views/event/tmpl/edit.php
~ admin/views/events/view.html.php
~ [MODULE] modules/mod_iccalendar/helper.php
~ site/add/elements/icsetvar.php
~ site/helpers/icmodel.php
~ site/models/events.php
~ site/views/list/tmpl/registration.php


iCagenda 3.5.0 <small style="font-weight:normal;">(2015.02.25)</small>
================================================================================
! [EXPORT CSV][Registrations] : integration of CSV exportation for a list of registrations. Use the filter dropdowns to select state, event and/or date, and export the list of registered users by clicking on the 'Export' button in the toolbar.
! [Registrations] : the max number of tickets is now applied to each individual date of an event, if registration per date is selected.
! [MODULES] Added : event url goes directly to the date selected in the event details view.
! [FORMS] Improvement in Form Validation. By default, the form validation is process first client-side, using now the joomla core form-validate, and in second validation is server-side, processed by iCagenda. You have option both for the 'Registration' and 'Submit an Event' forms, to select default (2 controls) or only server-side form validation (the most advanced and secured one. The client-side validation adds a more user-friendly way which is faster for user (page not reloaded) to know when a field or more are invalid).
+ Added : Admin filter by registered date in registrations list.
+ Added : Admin filter by category in registrations list.
+ [RSS] Added : get current menu options to filter the RSS feeds (Filter by date, ordering...).
+ [MODULE iC calendar] Added : option to close automatically the tooltip on Mouseout.
+ [PLUGIN Search] Added : Search in shortdesc and metadesc text.
~ [MODULE iC calendar] Changed : improvement of the tool tip design, and addition of auto vertical scrolling inside tooltip.
~ [MODULE iC calendar] Changed : All mktime php function changed to be standardized with component refactory.
~ Many code improvements and minor bugs fixed.
# [MEDIUM] Fixed : Possible blank page in frontend, or very slow loading of iCagenda. The issue was not identified (seems to be related to php 5.4.37), but the new release 3.5.0 fixes this problem.
# [MEDIUM] Fixed : Slow loading in frontend, when using distant images, the parent image to generate thumbnails was always controlled, and should not if thumb already existed.
# [LOW] Fixed : W3C validation.
# [LOW] Fixed : issue in checking menu item if published (could return a 404 error page if menu item not published).
# [LOW] Fixed : missing displaytime checking in list of dates rendering (could not display an event over a period, with week days selected, if time not set).
# [LOW] Fixed : when only single dates filled in 'Submit an Event' form, the event was unpublished.
# [LOW] Fixed : "Notice: Undefined index:" if some fields are not filled when captcha solution was incorrect in registration form.
# [LOW] Fixed : issue if captcha plugin option is not set correctly, and set to be shown in form options.
# [LOW] Fixed : do not display event not approved in RSS feeds.
# [LOW] Fixed : no display of toolbar in list of events (admin) if no category created (display issue hiding page header).
# [LOW] Fixed : infotips in registration form not working on Joomla 2.5 (bug introduced in 3.4.1).
# [LOW][PRO MODULE iC Event List] Fixed : wrong date if period has a start date before today, and end date after today (was displaying tomorrow).
# [LOW][PRO MODULE iC Event List] Fixed : missing ic- prefix for columns classes in default layout, and rtl files.
# [SQL] Fixed : possible issue when update from an old version of iCagenda (before 3.2.14 and 3.2.0), with sql updating using the joomla core sql updates system.

* Changed files in 3.5.0
- admin/add/css/icmap.css
~ admin/config.xml
+ admin/controllers/registrations.raw.php
~ admin/globalization/en-GB.php
+ admin/models/download.php
~ admin/models/events.php
~ admin/models/fields/icmap/city.php
~ admin/models/fields/icmap/country.php
~ admin/models/fields/icmap/lat.php
~ admin/models/fields/icmap/lng.php
~ admin/models/fields/modal/date.php
~ admin/models/fields/modal/ictextarea_counter.php
~ admin/models/fields/modal/thumbs.php
+ admin/models/forms/download.xml
~ admin/models/forms/event.xml
~ admin/models/registrations.php
~ admin/sql/updates/3.2.0.sql
~ admin/sql/updates/3.2.14.sql
~ admin/sql/updates/3.2.sql
~ admin/utilities/customfields/customfields.php
+ admin/utilities/events/data.php
~ admin/utilities/events/events.php
~ admin/utilities/form/form.php
~ admin/utilities/menus/menus.php
~ admin/utilities/thumb/thumb.php
~ admin/views/categories/view.html.php
+ admin/views/download/tmpl/default.php
+ admin/views/download/view.html.php
~ admin/views/event/tmpl/edit.php
~ admin/views/event/view.html.php
~ admin/views/events/tmpl/default.php
~ admin/views/events/view.html.php
~ admin/views/registrations/tmpl/default.php
~ admin/views/registrations/view.html.php
+ admin/views/registrations/view.raw.php
~ [LIBRARY] libraries/ic_library/date/date.php
~ [LIBRARY] libraries/ic_library/thumb/create.php
~ [LIBRARY] libraries/ic_library/thumb/get.php
~ [MEDIA] media/css/icagenda-back.css
~ [MEDIA] media/css/icagenda-front.css
+ [MEDIA] media/css/icagenda.css
~ [MEDIA] media/icicons/style.css
~ [MEDIA] media/js/icdates.js
~ [MEDIA] media/js/icform.js
~ [MODULE][PRO] modules/mod_ic_event_list/css/default_style-rtl.css
~ [MODULE][PRO] modules/mod_ic_event_list/css/default_style.css
~ [MODULE][PRO] modules/mod_ic_event_list/css/icrounded_style-rtl.css
~ [MODULE][PRO] modules/mod_ic_event_list/css/icrounded_style.css
~ [MODULE][PRO] modules/mod_ic_event_list/mod_ic_event_list.php
~ [MODULE][PRO] modules/mod_ic_event_list/tmpl/default.php
~ [MODULE] modules/mod_iccalendar/helper.php
~ [MODULE] modules/mod_iccalendar/mod_iccalendar.php
~ [MODULE] modules/mod_iccalendar/mod_iccalendar.xml
~ [MODULE] modules/mod_iccalendar/mod_iccalendar.xml
~ [PLUGIN] plugins/search/icagenda/icagenda.php
~ script.icagenda.php
- site/add/css/icmap.css
~ site/add/elements/icsetvar.php
~ site/helpers/ichelper.php
~ site/helpers/icmodel.php
~ site/models/events.php
~ site/models/forms/submit.xml
~ site/models/list.php
~ site/models/submit.php
~ [THEME PACKS] site/themes/packs/default/css/default_component.css
~ [THEME PACKS] site/themes/packs/default/css/default_component_xsmall.css
~ [THEME PACKS] site/themes/packs/default/css/default_module.css
~ [THEME PACKS] site/themes/packs/default/default_day.php
~ [THEME PACKS] site/themes/packs/default/default_event.php
~ [THEME PACKS] site/themes/packs/default/default_events.php
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_component.css
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_component_xsmall.css
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_module.css
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_day.php
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_event.php
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_events.php
~ site/views/list/tmpl/default.php
~ site/views/list/tmpl/default_categories.php
~ site/views/list/tmpl/event.php
~ site/views/list/tmpl/registration.php
~ site/views/submit/tmpl/default.php
~ site/views/submit/view.html.php

iCagenda 3.4.1 <small style="font-weight:normal;">(2015.01.30)</small>
================================================================================
! Changed : To fix an issue when using a custom captcha plugin (not joomla core reCaptcha plugin), the options has been changed. Now, there's only one place where you can set the captcha plugin used in iCagenda: 'General Settings' tab of the Global Options of the component. And you have individual option to show/hide captcha in 'Registration' and 'Submit an Event' forms. The update script will try to migrate your settings, but it's possible that you will have to set again this option in the menu options of 'Submit en Event' menu item type.
! Fixed : the 404 error page on multi-language site (when clicking on a module link).
+ Added : Get menu id and title of an event submitted in frontend (notification email, and filter in admin list of events).
+ Added : Options to show/hide period, weekdays and single dates in 'Submit an Event' form.
+ Added : Filter RSS feeds by category filter set in the menu options.
+ Added : Tooltip legends to pagination.
+ Added : Option to show/hide time in date box (list of events).
+ Added : Global Option to set access level to registration form.
+ [Plugin Search] Added : Next date added in search result (after title of the event).
~ Changed : You can now enter date before 1970/1/1 and after 2038/1/19 (no more unix limitation due to mktime php function, removed from date functions).
~ Changed : pageclass_sfx moved from id icagenda to a class (ic-list, ic-event, ic-registration, ic-submit, ic-send) to follow joomla standard.
~ Changed : Google Maps script checking (if api not loaded, iCagenda will load it).
~ Changed : Main list of events filter by date is improved (full recoding of the dates filtering functions).
~ Changed : The option 'list of all dates/only next/last date' is changed into 'Display All Dates' yes/no option.
~ [PRO MODULE iC Event List] Changed : ic- prefix added to section, group and col class names (to prevent class names CSS conflict).
~ Changed : Many code improvements.
# [MEDIUM] Fixed : 'auto' mode for menu link in modules was not well filtering language when joomla multi-language enabled. Improvement of the language detection for the menu items to retrieve the correct url.
# [LOW] Fixed : do not send user notification email after an event submission in frontend, if user has permissions to approve an event.
# [LOW] Fixed : no thumbnails were generated when '.' found in the image filename (eg. image.name.jpg).
# [LOW] Fixed : detects if an image file is too large, depending of server memory_limit setting, to prevent a blank page in admin when thumbnails cannot be generated (alert message displayed when a file is too large).
# [LOW] Fixed : filtering by category in events admin list was broken.
# [LOW] Fixed : Minor warning message in admin 'Themes manager' page (don't worry, nothing is broken!), 'Error loading component: COM_ICAGENDA, Component not found'.
# [LOW] Fixed : a few minor issue in admin list of events (date in current language, notice error $list var, ...).
# [LOW] Fixed : no display of events if category is unpublished.
# [LOW] Fixed : Keep in session Terms and Conditions checked, when reCaptcha is not correct.
# [LOW] Fixed : alias not generated when latin and non-latin characters in title (no datetime url safe alias, depending of unicode slug joomla global config setting).
# [LOW] Fixed : wrong display of menu option 'Features' on Joomla 2.5.
# [LOW] Fixed : if click on cancel on registration form, and when back to event details view, the back arrow was returning to registration form (now returns to parent list of events).

* Changed files in 3.4.1
~ admin/add/css/jquery-ui-1.8.17.custom.css
~ admin/config.xml
~ admin/globalization/uk-UA.php
~ admin/models/events.php
~ admin/models/fields/modal/cat.php
~ admin/models/fields/modal/date.php
~ admin/models/fields/modal/enddate.php
~ admin/models/fields/modal/ictextarea_counter.php
~ admin/models/fields/modal/startdate.php
~ admin/models/fields/modal/template.php
~ admin/models/forms/event.xml
~ admin/tables/event.php
~ admin/utilities/events/events.php
~ admin/utilities/form/form.php
~ admin/utilities/menus/menus.php
~ admin/views/event/tmpl/edit.php
~ admin/views/event/view.html.php
~ admin/views/events/tmpl/default.php
~ admin/views/events/view.html.php
~ admin/views/themes/tmpl/default.php
~ admin/views/themes/view.html.php
~ [LIBRARY] libraries/ic_library/date/date.php
~ [LIBRARY] libraries/ic_library/date/period.php
~ [LIBRARY] libraries/ic_library/thumb/create.php
~ [LIBRARY] libraries/ic_library/thumb/get.php
~ [MEDIA] media/css/icagenda-front.css
~ [MEDIA] media/js/icdates.js
~ [MODULE][PRO] modules/mod_ic_event_list/css/default_style.css
~ [MODULE][PRO] modules/mod_ic_event_list/css/icrounded_style.css
~ [MODULE][PRO] modules/mod_ic_event_list/helper.php
~ [MODULE][PRO] modules/mod_ic_event_list/mod_ic_event_list.php
~ [MODULE][PRO] modules/mod_ic_event_list/mod_ic_event_list.xml
~ [MODULE][PRO] modules/mod_ic_event_list/tmpl/default.php
~ [MODULE][PRO] modules/mod_ic_event_list/tmpl/icrounded.php
~ [MODULE] modules/mod_iccalendar/helper.php
~ [PLUGIN] plugins/search/icagenda/icagenda.php
~ script.icagenda.php
~ site/add/css/jquery-ui-1.8.17.custom.css
~ site/helpers/ichelper.php
~ site/helpers/icmodel.php
~ site/models/events.php
+ site/models/forms/registration.xml
~ site/models/forms/submit.xml
~ site/models/list.php
~ site/models/submit.php
~ [THEME PACKS] site/themes/packs/default/css/default_component.css
~ [THEME PACKS] site/themes/packs/default/default_event.php
~ [THEME PACKS] site/themes/packs/default/default_events.php
~ [THEME PACKS] site/themes/packs/default/default_registration.php
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_component.css
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_module.css
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_day.php
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_event.php
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_events.php
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_registration.php
~ site/views/list/tmpl/default.php
~ site/views/list/tmpl/default.xml
+ site/views/list/tmpl/default_categories.php
~ site/views/list/tmpl/default_vcal.php
~ site/views/list/tmpl/event.php
~ site/views/list/tmpl/registration.php
~ site/views/list/view.feed.php
~ site/views/list/view.html.php
~ site/views/submit/tmpl/default.php
~ site/views/submit/tmpl/default.xml
~ site/views/submit/tmpl/send.php
~ site/views/submit/view.html.php


iCagenda 3.4.0 <small style="font-weight:normal;">(2014.12.22)</small>
================================================================================
! New : Custom fields.
1 - Available in registration and event edition forms.
1 - Field types : text, list, radio buttons.
! New : Feature Icons.
1 - Create icons for each feature.
1 - Attribute one or more features individually for each event.
1 - Feature can be for example: Parking, Refreshments, Restaurant, Hotel, Free, TV, Toilets, Swimming, Airport... (no limit of usage!).
! New : Librairies
1 - iC Library : standalone library (loaded by a plugin).
1 - iCagenda Utilities : integrated library of iCagenda.
! New : Full Thumbnails generator
1 - Options for 4 predetermined sizes : large, medium, small, xsmall.
1 - For each thumbnail size, individual options : width, height, quality, crop.
! Improvement and new options:
1 - Captcha option added in 'Registration' and 'Submit an event' forms.
1 - RTL integration (component and modules)
1 - SQL requests improvement (faster process of database queries)
1 - Link to event details from modules and search plugin now detect the category filter setting from each menu items.
1 - Notification email to user who has submitted an event in frontend, with an Event Reference Number.
1 - ...
! Please check all release notes since 3.4.0-alpha1 to review all the changes and new options added since 3.3.8

* Release Notes 3.4.0
~ Changed : 'btn' class renamed in 'ic-btn' for frontend (mainly used for buttons).
~ Changed : a few css improvement (ic_rounded theme, liveupdate design...), and new classes added for a few core functions (date time display...).
# [LOW] Fixed : minor issues with 3.4.0-rc.

* Changed files in 3.4.0
~ admin/config.xml
~ admin/icagenda.php
~ admin/liveupdate/assets/liveupdate.css
~ admin/liveupdate/classes/abstractconfig.php
~ admin/liveupdate/classes/tmpl/nagscreen.php
~ admin/liveupdate/classes/tmpl/overview.php
~ admin/liveupdate/classes/updatefetch.php
~ admin/utilities/customfields/customfields.php
~ admin/utilities/events/events.php
+ admin/utilities/params/params.php
~ admin/views/icagenda/tmpl/default.php
~ admin/views/info/tmpl/default.php
~ [LIBRARY] libraries/ic_library/date/date.php
+ [LIBRARY] libraries/ic_library/date/period.php
~ [MEDIA] media/css/icagenda-front.css
+ [MEDIA] media/js/icagenda.js
~ [MODULE][PRO] modules/mod_ic_event_list/helper.php
~ [MODULE][PRO] modules/mod_ic_event_list/mod_ic_event_list.php
~ [MODULE] modules/mod_iccalendar/helper.php
~ [MODULE] modules/mod_iccalendar/mod_iccalendar.php
~ [PLUGIN] plugins/system/ic_library/ic_library.php
~ script.icagenda.php
~ site/helpers/ichelper.php
~ site/helpers/icmodel.php
~ site/helpers/media_css.class.php
~ site/models/events.php
~ [THEME PACKS] site/themes/packs/default/css/default_component.css
~ [THEME PACKS] site/themes/packs/default/css/default_component_xsmall.css
~ [THEME PACKS] site/themes/packs/default/default_event.php
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_component.css
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_component_medium.css
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_component_small.css
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_component_xsmall.css
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_event.php
~ site/views/list/tmpl/default.php
~ site/views/list/tmpl/event.php
~ site/views/list/tmpl/registration.php
~ site/views/list/view.html.php
~ site/views/submit/tmpl/default.php
~ site/views/submit/tmpl/send.php
~ site/views/submit/view.html.php


$ iCagenda 3.4.0-rc <small style="font-weight:normal;">(2014.12.14)</small>
================================================================================
! RTL integration (component and modules)
! SQL requests improvement (faster process of database queries)
! [MODULES & PLUGIN] Link to event details from modules and search plugin now detect the category filter setting from each menu items.
! Notification email to user who has submitted an event in frontend, with an Event Reference Number (of type YYYYMMDDID where YYYY is year, MM is month, DD is day and ID is event id).
+ Added : form fields saved to session to keep data after submission of the form if a wrong captcha value was entered.
+ Added : nofollow for 'registration' and 'submit an event' form links (to not been read by search engine).
+ Added : option to set ordering of categories in drop-down field.
+ Added : option to set a category as default in drop-down field.
~ Changed : auto-generation of alias improved.
~ Changed : default order of categories in drop-down field by title (previously by id).
# [LOW] Fixed : issue with single date before 1999-11-30.
# [LOW] Fixed : tooltip not working in 'Submit an Event' form on Joomla 3.3.6 (fixed since alpha-1).
# [LOW] Fixed : pixelated event image in details view, if original image is too small.
# [LOW] Fixed : notice error 'DS' in admin and frontend after Joomla upgrade from 2.5 to 3.3.
# [LOW] Fixed : text counter bug in frontend 'Submit an Event' form on IE11.

* Changed files in 3.4.0-rc
~ admin/config.xml
~ admin/icagenda.php
~ admin/models/category.php
~ admin/models/event.php
~ admin/models/events.php
~ admin/models/feature.php
~ admin/models/fields/icmap/city.php
~ admin/models/fields/icmap/country.php
~ admin/models/fields/icmap/lat.php
~ admin/models/fields/icmap/lng.php
~ admin/models/fields/modal/cat.php
~ admin/models/fields/modal/date.php
~ admin/models/fields/modal/iclink_type.php
~ admin/models/fields/modal/ictextarea_counter.php
~ admin/models/fields/modal/multicat.php
~ admin/models/forms/feature.xml
~ admin/tables/category.php
~ admin/tables/customfield.php
~ admin/tables/event.php
~ admin/tables/feature.php
~ admin/tables/registration.php
~ admin/utilities/customfields/customfields.php
~ admin/utilities/events/events.php
~ admin/utilities/form/form.php
+ admin/utilities/menus/menus.php
~ admin/utilities/thumb/thumb.php
~ libraries/ic_library/filter/output.php
~ libraries/ic_library/url/url.php
~ media/css/icagenda-front.css
~ media/js/icform.js
+ [MODULE][PRO] modules/mod_ic_event_list/css/default_style-rtl.css
~ [MODULE][PRO] modules/mod_ic_event_list/css/default_style.css
+ [MODULE][PRO] modules/mod_ic_event_list/css/icrounded_style-rtl.css
~ [MODULE][PRO] modules/mod_ic_event_list/css/icrounded_style.css
~ [MODULE][PRO] modules/mod_ic_event_list/helper.php
~ [MODULE][PRO] modules/mod_ic_event_list/mod_ic_event_list.php
~ [MODULE][PRO] modules/mod_ic_event_list/mod_ic_event_list.xml
~ [MODULE][PRO] modules/mod_ic_event_list/tmpl/default.php
~ [MODULE][PRO] modules/mod_ic_event_list/tmpl/icrounded.php
~ [MODULE] modules/mod_iccalendar/helper.php
~ [MODULE] modules/mod_iccalendar/mod_iccalendar.php
~ site/add/css/style.css
~ site/add/elements/icsetvar.php
~ site/helpers/ichelper.php
~ site/helpers/icmodel.php
~ site/icagenda.php
+ site/models/events.php
~ site/models/forms/submit.xml
~ site/models/list.php
~ site/models/submit.php
+ [THEME PACKS] site/themes/packs/default/css/default_component-rtl.css
~ [THEME PACKS] site/themes/packs/default/css/default_component.css
+ [THEME PACKS] site/themes/packs/default/css/default_module-rtl.css
~ [THEME PACKS] site/themes/packs/default/default_day.php
~ [THEME PACKS] site/themes/packs/default/default_registration.php
+ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_component-rtl.css
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_component.css
+ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_module-rtl.css
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_day.php
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_event.php
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_events.php
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_registration.php
~ site/views/list/tmpl/default.php
~ site/views/list/tmpl/default.xml
~ site/views/list/tmpl/event.php
~ site/views/list/tmpl/registration.php
~ site/views/list/view.html.php
~ site/views/submit/tmpl/default.php
~ site/views/submit/tmpl/default.xml
~ site/views/submit/tmpl/send.php
~ site/views/submit/view.html.php


$ iCagenda 3.4.0-beta2 <small style="font-weight:normal;">(2014.11.09)</small>
================================================================================
+ Captcha option added in 'Registration' and 'Submit an event' forms. You can select the joomla captcha plugin that will be used in the form.
+ Added : Custom fields filled added in the registration notification emails.
+ Added : 3 tags in registration notification emails : [CUSTOMFIELDS] (list of custom fields), [DATE] (only date) and [TIME] (only time).
+ Added : Option to redirect after validation of the frontend 'Submit an Event' form (default, article or url).
+ Added : Option to set a characters limit for Title in List of Events.
+ Added : Option to create custom CSS stylesheets to add to the iCagenda styles or to override existing CSS styles and classes (Global Options).
+ [PRO MODULE iC Event List] Added : Options to set a header and/or footer custom text.
+ [MODULE iC Calendar] Added : Option to select the date on which the calendar will load (month and year).
+ [MODULE iC Calendar] Added : Option to show/hide Month and/or Year navigation.
~ Changed : display of "LiveUpdate" button only to user with component global options permissions.
~ [MODULE iC Calendar] Changed : navigation routing improved in calendar (now compatible with Advanced Module Manager by NoNumber).
~ [Theme Packs] Changed : load animated png is replaced by a animated gif (to prevent not working on not compatible browsers).
# [LOW] Fixed : 'view event' redirect link, after registration submission.
# [LOW] Fixed : nofollow for 'print' and 'add to cal' icons links.
# [LOW] Fixed : issue with custom field type 'list' if set to 'required'. Field was not checked properly if 'alias' and 'slug' identical.
# [LOW] Fixed : Add to iCal if SEF not activated (wrong url).
# [LOW] Fixed : displays users registered depending on the date (when 'All dates of each event' option is selected in menu options).
# [LOW] Fixed : possibility to edit or removed a registered user when the event is not published.
# [LOW] Fixed : changed 'all period' to 'all dates' in registration option, and fix an issue in data saved when no period for an event.
# [LOW] Fixed : possible issues with "edit own" permission for event edition.
# [LOW] Fixed : auto-increment of image name in frontend submit an event form, if image name already exists.
# [LOW] Fixed : error when searching in event with special characters (ą ę ć ś ź ł ż ó ż ń).
# [PRO MODULE iC Event List] [LOW] Fixed : wrong date depending of the time zone (only if datetime or date display is selected).

* Changed files in 3.4.0-beta2
~ admin/config.xml
~ admin/models/events.php
~ admin/models/fields/modal/evt.php
~ admin/models/fields/modal/evt_date.php
~ admin/models/fields/modal/iclink_type.php
~ admin/models/fields/modal/thumbs.php
~ admin/models/forms/event.xml
~ admin/models/forms/registration.xml
~ admin/utilities/customfields/customfields.php
+ admin/utilities/events/events.php
~ admin/utilities/form/form.php
~ admin/views/events/tmpl/default.php
~ admin/views/events/view.html.php
~ admin/views/icagenda/tmpl/default.php
~ admin/views/registrations/tmpl/default.php
+ libraries/ic_library/date/date.php
~ libraries/ic_library/lib_ic_library.xml
~ libraries/ic_library/thumb/create.php
~ libraries/ic_library/url/url.php
~ [MODULE][PRO] modules/mod_ic_event_list/mod_ic_event_list.php
~ [MODULE][PRO] modules/mod_ic_event_list/mod_ic_event_list.xml
~ [MODULE][PRO] modules/mod_ic_event_list/tmpl/default.php
~ [MODULE][PRO] modules/mod_ic_event_list/tmpl/icrounded.php
~ [MODULE] modules/mod_iccalendar/helper.php
~ [MODULE] modules/mod_iccalendar/mod_iccalendar.php
~ [MODULE] modules/mod_iccalendar/mod_iccalendar.xml
~ [PLUGIN] plugins/system/ic_library/ic_library.php
~ site/add/elements/icsetvar.php
~ site/helpers/iCicons.class.php
~ site/helpers/icmodel.php
~ site/helpers/media_css.class.php
~ site/models/list.php
~ site/models/submit.php
~ [THEME PACKS] site/themes/packs/default/css/default_component.css
~ [THEME PACKS] site/themes/packs/default/css/default_module.css
+ [THEME PACKS] site/themes/packs/default/images/ic_load.gif
- [THEME PACKS] site/themes/packs/default/images/ic_load.png
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_component.css
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_module.css
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_event.php
+ [THEME PACKS] site/themes/packs/ic_rounded/images/ic_load.gif
- [THEME PACKS] site/themes/packs/ic_rounded/images/ic_load.png
~ site/views/list/tmpl/default.php
~ site/views/list/tmpl/default_vcal.php
~ site/views/list/tmpl/event.php
~ site/views/list/tmpl/registration.php
~ site/views/list/view.html.php
~ site/views/submit/tmpl/default.php
~ site/views/submit/tmpl/default.xml
~ site/views/submit/view.html.php


$ iCagenda 3.4.0-beta1 <small style="font-weight:normal;">(2014.07.23)</small>
================================================================================
+ Added : Short Description field (you can now enter a special short description, to be used in the list of events as Intro Text).
+ Added : Limit options for Short Description, Auto-Introtext and Meta Description. Addition of a live counter of remaining characters both in admin event edit and submit an event forms.
+ Added : Option for maximum size of the uploaded image in frontend 'submit an event' form. This new function controls the file before upload, check the size and file type, and display a preview if the file is conformed.
+ Added : image added to rss feeds
+ [SQL] Added : 'shortdesc' in '#__icagenda_events' table
~ Changed : 'Meta' is replaced by 'Auto-Introtext' in Intro Text option (global component and modules options).
~ [THEME PACKS] Changed : Begin of renaming of existing CSS classes of ic_rounded theme pack (to use standardized naming, and prevent CSS conflicts with site templates and other third party extensions. Don't forget to update your custom theme pack if needed!)
~ Changed : a few code improvements, and control alert messages added.
# [LOW] Fixed : possible issue on a fresh install, with a wrong installation of the iC Library.
# [LOW] Fixed : wrong display in frontend of radio buttons, when using a Gantry Template.

* Changed files in 3.4.0-beta1
~ admin/add/css/icagenda.j25.css
~ admin/config.xml
+ admin/models/fields/modal/ictextarea_counter.php
~ admin/models/forms/event.xml
~ admin/views/event/tmpl/edit.php
~ admin/views/event/view.html.php
~ admin/views/icagenda/tmpl/color.php
~ icagenda.xml
~ libraries/ic_library/lib_ic_library.xml
~ media/css/icagenda-back.css
~ media/css/icagenda-front.css
+ media/js/icform.js
~ [MODULE][PRO] modules/mod_ic_event_list/css/default_style.css
~ [MODULE][PRO] modules/mod_ic_event_list/mod_ic_event_list.php
~ [MODULE][PRO] modules/mod_ic_event_list/mod_ic_event_list.xml
~ [MODULE] modules/mod_iccalendar/helper.php
~ [MODULE] modules/mod_iccalendar/mod_iccalendar.xml
~ script.icagenda.pro.php
~ site/add/css/icagenda.j25.css
~ site/add/elements/icsetvar.php
~ site/helpers/icmodel.php
~ site/icagenda.php
~ site/models/forms/submit.xml
~ site/models/list.php
~ site/models/submit.php
~ [THEME PACKS] site/themes/packs/default/css/default_component.css
~ [THEME PACKS] site/themes/packs/default/default_event.php
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_component.css
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_event.php
~ site/views/list/tmpl/default.php
~ site/views/list/tmpl/default.xml
~ site/views/list/view.html.php
~ site/views/submit/tmpl/default.php
~ site/views/submit/tmpl/default.xml
~ site/views/submit/view.html.php


$ iCagenda 3.4.0-alpha2 <small style="font-weight:normal;">(2014.07.16)</small>
================================================================================
+ Added : Alert message with list of custom theme packs not updated to be compatible with custom fields and feature icons.
+ Added : Check if at least 1 category is published before adding/editing an event.
+ Added : Option to show/hide custom fields in frontend 'Submit an event' form (Menu Item params and Global Options).
+ Added : Own server for Testing Updates (alpha & beta).
# [MEDIUM] Fixed : SQL error 1064 in event edit if no custom fields exists.
# [LOW] Fixed : bug in checking if a slug already exists (custom fields) (could display multiple times the custom field in event details view).
# [LOW] Fixed : bug in display of information option in Event Details view.
# [LOW] Fixed : bug in fields display options in the form to submit an event in frontend.
# [LOW][PRO][MODULE iC Event List] Fixed : today date was not always properly set depending on your hosting location (now uses Joomla config offset).

* Changed files in 3.4.0-alpha2
~ admin/config.xml
~ admin/liveupdate/classes/abstractconfig.php
~ admin/liveupdate/config.php
~ admin/models/customfields.php
+ admin/sql/install/mysql/icagenda.install.sql
- admin/sql/install.mysql.utf8.sql
+ admin/sql/uninstall/mysql/icagenda.uninstall.sql
- admin/sql/uninstall.mysql.utf8.sql
~ admin/tables/customfield.php
~ admin/utilities/categories/categories.php
~ admin/utilities/customfields/customfields.php
+ admin/utilities/theme/theme.php
~ admin/views/customfields/tmpl/default.php
~ admin/views/event/tmpl/edit.php
~ admin/views/event/view.html.php
~ admin/views/events/view.html.php
~ admin/views/features/tmpl/default.php
~ admin/views/icagenda/tmpl/color.php
~ admin/views/icagenda/tmpl/default.php
~ admin/views/info/tmpl/default.php
~ admin/views/themes/tmpl/default.php
~ icagenda.xml
+ [iC Library] libraries/ic_library/file/file.php
~ [iC Library] libraries/ic_library/lib_ic_library.xml
~ [MODULE][PRO] modules/mod_ic_event_list/css/icrounded_style.css
~ [MODULE][PRO] modules/mod_ic_event_list/mod_ic_event_list.php
~ [PLUGIN][iC Library] plugins/system/ic_library/ic_library.php
~ script.icagenda.pro.php
~ site/add/elements/icsetvar.php
~ site/helpers/icmodel.php
~ [THEME PACKS] site/themes/packs/default/default_event.php
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_event.php
~ site/views/submit/tmpl/default.php
~ site/views/submit/tmpl/default.xml
~ site/views/submit/view.html.php


$ iCagenda 3.4.0-alpha1 <small style="font-weight:normal;">(2014.07.11)</small>
================================================================================
! New : Custom fields.
1 Available in registration and event edition forms.
1 Field types : text, list, radio buttons.
! New : Feature Icons.
1 Create icons for each feature.
1 Attribute one or more features individually for each event.
1 Feature can be for example: Parking, Refreshments, Restaurant, Hotel, Free, TV, Toilets, Swimming, Airport... (no limit of usage!).
! New : Librairies
1 iC Library : standalone library (loaded by a plugin).
1 iCagenda Utilities : integrated library of iCagenda.
! New : Full Thumbnails generator
1 Options for 4 predetermined sizes : large, medium, small, xsmall.
1 For each thumbnail size, individual options : width, height, quality, crop.
! Many code lines cleaned up, and global improvement. (zip is now 0,4 mb lighter!)
+ Added : Modified Date and Modified By fields in admin event edit form.
+ [PRO][MODULE iC Event List] Added : Detection of the categor(y)ies set in the menu items to generate link of an event.
+ [PRO][MODULE iC Event List] Added : Show/Hide venue name
~ [PRO][MODULE iC Event List] Changed : Improved design of icrounded layout.
~ Changed : default ordering of admin list of events is now ID descendant (latest created event in first position).
~ Changed : default ordering of admin list of registered users is now ID descendant (latest registered user in first position).
~ Changed : option to set 'Intro Text'; auto, hide, short desc or meta (global options and modules params).
# [LOW] Fixed : created date was missing in old versions of iCagenda (before 3.1.5). This version update database to set a valid created date for events created with versions of iCagenda < 3.1.5, and set in this order : modified date if valid or next/last date if valid or, at the end, will use current date. (this fix is to prevent wrong 'Created on 30 November -0001' in search results)

* Changed files in 3.4.0-alpha1
~ admin/access.xml
~ admin/add/elements/title.php
~ admin/add/elements/titleimg.php
~ admin/config.xml
+ admin/controllers/customfield.php
+ admin/controllers/customfields.php
~ admin/controllers/event.php
+ admin/controllers/feature.php
+ admin/controllers/features.php
~ admin/helpers/icagenda.php
~ admin/icagenda.php
+ admin/models/customfield.php
+ admin/models/customfields.php
~ admin/models/event.php
~ admin/models/events.php
+ admin/models/feature.php
+ admin/models/features.php
~ admin/models/fields/modal/date.php
+ admin/models/fields/modal/thumbs.php
+ admin/models/forms/customfield.xml
~ admin/models/forms/event.xml
+ admin/models/forms/feature.xml
~ admin/models/forms/registration.xml
~ admin/models/icagenda.php
~ admin/models/registration.php
~ admin/models/registrations.php
+ admin/tables/customfield.php
~ admin/tables/event.php
+ admin/tables/feature.php
~ admin/tables/icagenda.php
~ admin/tables/registration.php
+ admin/utilities/categories/categories.php
+ admin/utilities/class/class.php
+ admin/utilities/customfields/customfields.php
+ admin/utilities/form/form.php
+ admin/utilities/thumb/thumb.php
~ admin/views/category/tmpl/edit.php
+ admin/views/customfield/tmpl/edit.php
+ admin/views/customfield/view.html.php
+ admin/views/customfields/tmpl/default.php
+ admin/views/customfields/view.html.php
~ admin/views/event/tmpl/edit.php
~ admin/views/events/tmpl/default.php
~ admin/views/events/view.html.php
+ admin/views/feature/tmpl/edit.php
+ admin/views/feature/view.html.php
+ admin/views/features/tmpl/default.php
+ admin/views/features/view.html.php
~ admin/views/icagenda/tmpl/default.php
~ admin/views/icagenda/view.html.php
~ admin/views/info/tmpl/default.php
~ admin/views/registration/tmpl/edit.php
~ admin/views/registrations/tmpl/default.php
~ icagenda.xml
+ media/css/icagenda-back.css
+ media/css/icagenda-front.css
~ [iCicons][New icons] media/icicons/
+ media/images/customfields-16.png
+ media/images/customfields-48.png
+ media/images/features-16.png
+ media/images/features-48.png
+ media/images/panel_denied/customfields-48.png
+ media/images/panel_denied/features-48.png
~ [IMAGES][All png optimized] media/images/
~ media/js/icdates.js
- [FOLDER] media/scripts/
~ [MODULE][PRO] modules/mod_ic_event_list/css/default_style.css
~ [MODULE][PRO] modules/mod_ic_event_list/css/icrounded_style.css
~ [MODULE][PRO] modules/mod_ic_event_list/helper.php
~ [MODULE][PRO] modules/mod_ic_event_list/mod_ic_event_list.php
~ [MODULE][PRO] modules/mod_ic_event_list/mod_ic_event_list.xml
~ [MODULE][PRO] modules/mod_ic_event_list/tmpl/default.php
~ [MODULE][PRO] modules/mod_ic_event_list/tmpl/icrounded.php
~ [MODULE] modules/mod_iccalendar/helper.php
~ [MODULE] modules/mod_iccalendar/mod_iccalendar.php
~ [MODULE] modules/mod_iccalendar/mod_iccalendar.xml
- [FOLDER] plugins/search/plg_icagenda/
+ [FOLDER] plugins/search/icagenda/
- [FOLDER] plugins/system/plg_ic_autologin/
+ [FOLDER] plugins/system/ic_autologin/
+ plugins/system/ic_library/ic_library.php
+ plugins/system/ic_library/ic_library.xml
~ script.icagenda.pro.php
~ site/add/elements/icsetvar.php
~ site/helpers/ichelper.php
~ site/helpers/iCicons.class.php
~ site/helpers/icmodel.php
~ site/icagenda.php
~ site/js/icmap.js
~ site/models/forms/submit.xml
~ site/models/list.php
~ site/models/submit.php
~ site/router.php
~ [THEME PACKS] site/themes/packs/default/css/default_component.css
~ [THEME PACKS] site/themes/packs/default/css/default_module.css
~ [THEME PACKS] site/themes/packs/default/default_day.php
~ [THEME PACKS] site/themes/packs/default/default_event.php
~ [THEME PACKS] site/themes/packs/default/default_events.php
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_component.css
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_component_small.css
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_component_xsmall.css
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_module.css
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_day.php
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_event.php
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_events.php
~ site/views/list/tmpl/default.php
~ site/views/list/tmpl/default.xml
~ site/views/list/tmpl/event.php
~ site/views/list/tmpl/registration.php
~ site/views/list/view.feed.php
~ site/views/list/view.html.php
~ site/views/submit/tmpl/default.php
+ [iC Library] libraries/ic_library/color/color.php
+ [iC Library] libraries/ic_library/filter/output.php
+ [iC Library] libraries/ic_library/lib_ic_library.xml
+ [iC Library] libraries/ic_library/library/library.php
+ [iC Library] libraries/ic_library/string/string.php
+ [iC Library] libraries/ic_library/thumb/create.php
+ [iC Library] libraries/ic_library/thumb/get.php
+ [iC Library] libraries/ic_library/thumb/image.php
+ [iC Library] libraries/ic_library/url/url.php
+ [SQL] #__icagenda_customfields_data
+ [SQL] #__icagenda_feature
+ [SQL] #__icagenda_feature_xref


iCagenda 3.3.8 <small style="font-weight:normal;">(2014.07.04)</small>
================================================================================
+ Added : Events RSS feeds integrated to Joomla (This is a partial integration, displaying all events. An advanced integration with options, and events image in the RSS feed, will be added in 3.4.0 version, thanks to the new iC Library not yet implemented).
~ Changed : ChangeLog design
# [HIGH] Fixed : did not save the date selected during registration in datetime database format , depending on date format settings (was not working properly with name of the day of the week display displayed, eg. Saturday, 21 June 2014, or if AM/PM selected).
# [LOW] Fixed : quote issue in short description when sharing on facebook.

* Changed files in 3.3.8
~ admin/add/css/icagenda.css
+ admin/CHANGELOG.php
- admin/UPDATELOGS.php
~ admin/models/fields/modal/evt_date.php
~ admin/views/icagenda/tmpl/color.php
~ admin/views/icagenda/tmpl/default.php
~ admin/views/icagenda/view.html.php
~ icagenda.xml
~ script.icagenda.php
~ site/helpers/icmodel.php
~ site/models/list.php
~ site/views/list/tmpl/default.php
~ site/views/list/tmpl/event.php
~ site/views/list/tmpl/registration.php
+ site/views/list/view.feed.php


iCagenda 3.3.7 <small style="font-weight:normal;">(2014.05.29)</small>
================================================================================
! New : Custom notification emails to a user after registration to an event can be edit in html using your favorite editor.
+ Added : individual options for the display of fields in menu "Submit an event".
~ Changed : New registration button (uses icons, colors, and a redirect to login with return page, if user has no permission).
# [MEDIUM] Fixed : link to past event if "only next/last date" selected in the menu option, returned a view with no data, depending of value set in option 'Selection of events'.
# [LOW] Fixed : bug if 'today' and 'all dates' selected, could display no events (missing offset in date controls).
# [LOW] Fixed : in iCagenda 3.3.6, the notification emails to a user after registration to an event, do not account for newlines.
# [LOW] Fixed : Print popup view, if SEF disabled.

* Changed files in 3.3.7
~ admin/add/css/icagenda.j25.css
~ admin/config.xml
+ admin/models/fields/modal/ic_editor.php
~ [iCicons][Update] media/icicons/
~ site/helpers/icmodel.php
~ site/models/forms/submit.xml
~ site/models/list.php
~ site/models/submit.php
~ [THEME PACKS] site/themes/packs/default/css/default_component.css
~ [THEME PACKS] site/themes/packs/default/css/default_module.css
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_component.css
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_module.css
~ site/views/list/tmpl/event.php
~ site/views/list/tmpl/registration.php
~ site/views/submit/tmpl/default.php
~ site/views/submit/tmpl/default.xml
~ site/views/submit/view.html.php


iCagenda 3.3.6 <small style="font-weight:normal;">(2014.05.16)</small>
================================================================================
+ Added : Option for Intro Text : hide, the short description (generated from full description) or the meta description (Global Options of the component, and options of the modules).
+ [GLOBALIZATION] Added : tr-TR Turkish (Turkey) date formats.
+ [MODULE Calendar] Added : ID is added next to title of the menu, in option to select 'link to menu'.
+ [PRO] Added : Option to set minimum release stability for update notifications. (PRO OPTIONS tab in global options of iCagenda Pro)
~ [Optimization] : SQL request filtering improved in order to fix an issue, and speed up loading (more optimization to come concerning speed of page loading).
~ Changed : Division of the events tab in the global configuration into 2 tabs : Events (list of events options) and Event (details view options).
~ Changed : Updated addthis script (v300).
# [Optimization] Fixed : the list model was running the loading of data twice, and with this issue fixed the execution time for displaying a list is now halved (Thanks doorknob!).
# [HIGH]Fixed : Access to registration form if registration not activated in options.
# [LOW] Fixed : (only on Joomla 2.5) wrong display of print page if 'All Dates for each event' is selected in menu option.
# [LOW][MODULE Calendar][JS] Fixed : It was correctly deleting and adding the class style_Today but not the reverse for style_Day (by doorknob).
# [LOW]Fixed : Issue with Turkish language in admin events list (due to setlocale function, not used anymore).
# [LOW]Fixed : wrong closing select tags in 2 fields of the registration form.
# [LOW]Fixed : missing div tag in registration form.

* Changed files in 3.3.6
~ admin/config.xml
~ admin/globalization/iso.php
+ admin/globalization/tr-TR.php
~ admin/models/fields/modal/menulink.php
~ admin/views/events/tmpl/default.php
~ admin/views/events/view.html.php
~ media/scripts/icthumb.php
~ [MODULE][PRO] modules/mod_ic_event_list/helper.php
~ [MODULE] modules/mod_iccalendar/helper.php
~ [MODULE] modules/mod_iccalendar/js/jQuery.highlightToday.js
~ [MODULE] modules/mod_iccalendar/js/jQuery.highlightToday.min.js
~ site/add/elements/icsetvar.php
~ site/helpers/ichelper.php
~ site/helpers/icmodel.php
~ site/models/list.php
~ site/views/list/tmpl/default.php
~ site/views/list/tmpl/event.php
~ site/views/list/tmpl/registration.php
~ site/views/list/view.html.php


iCagenda 3.3.5-1 (patch) <small style="font-weight:normal;">(2014.04.29)</small>
================================================================================
# Fixed : possible issue with uploaded files (image and/or file) not attached correctly in frontend submission form.

* Changed files in 3.3.5-1
~ site/views/submit/tmpl/default.php


iCagenda 3.3.5 <small style="font-weight:normal;">(2014.04.27)</small>
================================================================================
+ Added : Control if event is published before editing a user registered for an event. (prevent error if user is registered to an unpublished event)
+ Added : Control if registered date still exists when editing a user registered for an event.
~ Changed : can convert date format depending on the option setting for date format (menu or global), when registration saved since version 3.3.3.
# [MEDIUM] Fixed : Date selection in Registration edition.
# [LOW] Fixed : missing loading of template.js on registration edition (Joomla 2.5).
# [LOW] Fixed : wrong css styling of pagination (Joomla 2.5).

* Changed files in 3.3.5
~ admin/add/css/template.css
~ admin/models/fields/modal/evt_date.php
~ admin/models/fields/modal/evt.php
~ admin/models/registrations.php
~ admin/views/registration/tmpl/edit.php
~ admin/views/registrations/tmpl/default.php
~ site/helpers/icmodel.php


iCagenda 3.3.4 <small style="font-weight:normal;">(2014.04.25)</small>
================================================================================
! Joomla 3.3 Ready! This version has been tested on 3.3.0 rc, and a few improvements has been done to run well on the new Joomla 3.3 available soon !
+ Added : Displays 'Home Page' and 'Submit a New Event' buttons, after validation of the event submission form, if user is logged in (was only displayed when user not logged in).
+ Added : Show 'Registration Options' in frontend submission form, only if registration is activated in global options.
~ Changed : Hide User ID when logged-in in registration form (was visible only for registered user).
~ Changed : no more 'onload' to initialize Google Maps (could prevent onload conflict with other extensions).
# [MEDIUM][Joomla 3.2.x & 3.3-beta] Fixed : in the frontend submission form, when user logged-in, 'disabled' changed to 'readonly' for user name and email, as it will not be submitted on a Joomla 3.3 website, and was giving the bug of double-click-needed on the submit button on J3.2.
# [MEDIUM][Joomla 2.5] Fixed : Global Options BUG with options not accessible -> Not correct path for js files in admin (after change of location for the scripts files in 3.3.3), on Joomla 2.5.
# [LOW] Fixed : Possible missing close div in submission form, if registration not displayed.
# [LOW][MODULE Calendar] Fixed : time was displayed even if the option to show time in event edition was disabled. Control missing in default theme pack.

* Changed files in 3.3.4
~ admin/add/elements/desc.php
~ admin/add/elements/title.php
~ admin/icagenda.php
- admin/models/fields/modal/time.php
~ admin/models/forms/event.xml
~ admin/views/event/tmpl/edit.php
~ admin/views/icagenda/tmpl/default.php
~ admin/views/icagenda/view.html.php
~ script.icagenda.php
~ site/helpers/icmodel.php
~ site/models/submit.php
~ [THEME PACKS] site/themes/packs/default/default_day.php
~ site/views/list/tmpl/registration.php
~ site/views/submit/tmpl/default.php
~ site/views/submit/tmpl/send.php
~ site/views/submit/view.html.php
+ media/js/jquery.noconflict.js


iCagenda 3.3.3 <small style="font-weight:normal;">(2014.04.20)</small>
================================================================================
! New : Edition in admin of a user registered for an event, and possibility to create a new registered user.
! New : Advanced options for Registration Button. You can now replace individually for each event, the link on the button by an external url or an article ('Options' tab, in admin event edition). Another option is added for browser target of the registration button.
+ Added : Global option to set a default date format (general settings tab).
+ [MODULE Calendar] Added : Option to display a custom text in header of calendar. (Thanks doorknob)
+ [MODULE Calendar] Added : Option to set a padding for the tooltip, on mobile devices. (Thanks doorknob)
~ Changed : Date selected during a registration will be saved in database without formatting.
~ Changed : IcoMoon replaced by iCicon font (iCagenda vector icons font), for print and calendar icons on Joomla 3.
~ Changed : forms (Submission and Registration): uses iCtip script to generate information tooltips (replaces css3 tooltips, and adds responsive behaviour to detect screen border).
~ Changed : folder 'add/js' moved from admin and site folders to media folder.
~ [THEME PACKS] Changed : in THEME_day.php file, 'cal_date' changed to 'data-cal-date' (to avoid possible future conflicts as html5 is developed).
~ [ROUTER SEF] Changed : "event_registration" to "registration" at the end of url to registration form (when SEF enabled).
~ Code : many code cleaned and/or improved (Thank you Doorknob for your precious contribution!).
- [ROUTER SEF] Removed : "event_details" at the end of url to event details view (when SEF enabled) and provides a better SEO score.
- [MODULE] Removed : br tags after date/close header in calendar tooltip.
# [MEDIUM] Fixed : error in a php function which changes event time (winter/summer time) when event over a period starting before daylight saving, and finishing after daylight saving.
# [MEDIUM] Fixed : displaying of today, and/or upcoming, or past events are now using Joomla config time zone, to prevent issue with server timezone.
# [LOW] Fixed : ordering of categories (admin).
# [LOW] Fixed : possibility of a PHP Warning: Invalid argument supplied for foreach() in /components/com_icagenda/views/list/tmpl/event.php on line 48, in your site error log.
# [LOW] Fixed : Not sending notification to the user who registers for an event, if email is not set as required.
# [LOW] Fixed : Error if no events, with Addthis button.
# [LOW] Fixed : Bug in All Dates, when only sunday for period (wrong display : "Sunday & Sunday").
# [LOW] Fixed : It was not loading Google Maps script if only coordinates were indicated (empty address).
# [LOW][PLUGIN Search] Fixed : Display of events not filtered by current language.
# [LOW][PRO][MODULE iC Event List] Fixed : Possible missing thumbnail, if no leading "/" in image url.

* Changed files in 3.3.3
~ admin/add/css/icagenda.css
~ admin/add/image/joomlic_iCagenda.png
~ admin/add/image/logo_icagenda.png
- [FOLDER] admin/add/js/
~ admin/config.xml
~ admin/controllers/categories.php
~ admin/controllers/event.php
+ admin/controllers/registration.php
~ admin/helpers/icagenda.php
~ admin/liveupdate/liveupdate.php
~ admin/models/event.php
~ admin/models/events.php
~ admin/models/fields/modal/date.php
+ admin/models/fields/modal/evt.php
+ admin/models/fields/modal/evt_date.php
~ admin/models/fields/modal/icalert_msg.php
+ admin/models/fields/modal/iclink_article.php
+ admin/models/fields/modal/iclink_type.php
+ admin/models/fields/modal/iclink_url.php
~ admin/models/forms/event.xml
+ admin/models/forms/registration.xml
+ admin/models/registration.php
~ admin/tables/category.php
~ admin/tables/event.php
+ admin/tables/registration.php
~ admin/views/categories/tmpl/default.php
~ admin/views/event/tmpl/edit.php
~ admin/views/events/tmpl/default.php
~ admin/views/icagenda/tmpl/default.php
~ admin/views/info/tmpl/default.php
+ admin/views/registration/tmpl/edit.php
+ admin/views/registration/tmpl/index.html
+ admin/views/registration/view.html.php
~ admin/views/registrations/tmpl/default.php
~ admin/views/registrations/view.html.php
~ admin/views/themes/tmpl/default.php
~ media/scripts/icthumb.php
~ [MODULE][PRO] modules/mod_ic_event_list/css/default_style.css
~ [MODULE][PRO] modules/mod_ic_event_list/css/icrounded_style.css
~ [MODULE][PRO] modules/mod_ic_event_list/helper.php
~ [MODULE] modules/mod_iccalendar/helper.php
~ [MODULE] modules/mod_iccalendar/js/jQuery.highlightToday.js
~ [MODULE] modules/mod_iccalendar/js/jQuery.highlightToday.min.js
~ [MODULE] modules/mod_iccalendar/mod_iccalendar.php
~ [MODULE] modules/mod_iccalendar/mod_iccalendar.xml
~ [PLUGIN] plugins/search/plg_icagenda/icagenda.php
~ script.icagenda.php
~ site/add/css/icagenda.css
~ site/add/css/style.css
~ site/add/elements/icsetvar.php
- [FOLDER] site/add/js/
~ site/helpers/ichelper.php
~ site/helpers/iCicons.class.php
~ site/helpers/icmodel.php
~ site/router.php
~ [THEME PACKS] site/themes/packs/default/css/default_component.css
~ [THEME PACKS] site/themes/packs/default/css/default_component_xsmall.css
~ [THEME PACKS] site/themes/packs/default/css/default_module.css
~ [THEME PACKS] site/themes/packs/default/default_day.php
~ [THEME PACKS] site/themes/packs/default/default_registration.php
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_component.css
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_component_xsmall.css
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_module.css
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_module_small.css
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_day.php
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_event.php
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_registration.php
~ site/views/list/tmpl/default.php
~ site/views/list/tmpl/event.php
~ site/views/list/tmpl/registration.php
~ site/views/submit/tmpl/default.php


iCagenda 3.3.2 <small style="font-weight:normal;">(2014.03.17)</small>
================================================================================
! [PLUGIN] New plugin iCagenda search, enables searching in events.
- Removed : option 'All options' (by individual date and for all period) in 'Registration type' (not logical).
# [MEDIUM] Fixed : Not displaying singles dates in registration form.
# [LOW] Fixed : Not setting default value correctly for new global options: show/hide venue's name, city, country and short description.
# [LOW][THEME PACKS] Fixed : Missing ic-box-date class in ic_rounded xsmall media css file.
# [LOW][MODULE] Fixed : possibility of a notice message related to the jquery checking.

* Changed files in 3.3.2
~ admin/models/forms/event.xml
~ admin/tables/event.php
~ icagenda.xml
~ [MODULE] modules/mod_iccalendar/mod_iccalendar.php
+ [PLUGIN] plugins/search/plg_icagenda/icagenda.php
+ [PLUGIN] plugins/search/plg_icagenda/icagenda.xml
+ [PLUGIN] plugins/search/plg_icagenda/index.html
+ [PLUGIN][FOLDER] language
~ script.icagenda.php
~ site/add/elements/icsetvar.php
~ site/helpers/icmodel.php
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_component.css
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_component_xsmall.css
~ site/views/list/view.html.php


iCagenda 3.3.1 <small style="font-weight:normal;">(2014.03.14)</small>
================================================================================
+ Added : Global options to show/hide information in list of events (venue's name, city, country, short description).
+ Added : Global options to show/hide day, month and/or year in date box of the list of events.
+ Added : Global option to set HTML filtering in Short Description (All italicized, No HTML or Authorized tags: <br />, <b>, <strong>, <i>, <em>, <u>).
+ Added : Global option to set first day of the week (used when list of weekdays is displayed).
+ [MODULE iC Calendar] Added : Options to select a background color for days with only one event or more than one event.
+ [MODULE iC Calendar] Added : HTML Filtering Option for Short Description in tooltip.
~ Changed : redirect to login page if user has no access to submission form or is not logged-in.
~ [THEME PACKS] Changed : display order of Venue's name, city and country in tooltip of the calendar (now on the same line).
~ [THEME PACKS][ic_rounded] Changed class names for day, month and year in date box.
- [THEME PACKS] Removed, module iC calendar : <i> tags for short description in tooltip.
# [MEDIUM] Fixed : Duplicate display of alert message, and not display of event details, if event not approved, and user logged-in with approval permissions.
# [MODULE iC Calendar][LOW] Fixed : Not displaying events in module calendar on Joomla 2.5, if all categories selected.

* Changed files in 3.3.1
~ admin/config.xml
~ admin/models/registrations.php
~ admin/views/icagenda/tmpl/default.php
~ admin/views/info/tmpl/default.php
~ [MODULE] modules/mod_iccalendar/helper.php
~ [MODULE] modules/mod_iccalendar/mod_iccalendar.php
~ [MODULE] modules/mod_iccalendar/mod_iccalendar.xml
~ site/add/elements/icsetvar.php
~ site/helpers/icmodel.php
~ [THEME PACKS] site/themes/packs/default/css/default_component.css
~ [THEME PACKS] site/themes/packs/default/css/default_module.css
~ [THEME PACKS] site/themes/packs/default/default_day.php
~ [THEME PACKS] site/themes/packs/default/default_events.php
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_component.css
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_module.css
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_day.php
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_events.php
~ site/views/list/tmpl/default.php
~ site/views/list/tmpl/event.php
~ site/views/list/view.html.php
~ site/views/submit/tmpl/default.php


iCagenda 3.3.0 <small style="font-weight:normal;">(2014.03.06)</small>
================================================================================
! [Theme Packs] Added media css files for Responsive Design.
! [SQL] Creates table #__icagenda_customfields database to prepare future Custom Fields System.
+ Added : Options to show/hide the fields in Event Submission Form.
+ Added : Option "Contact's email" in Admin notification mailing list for registrations.
+ Added : Filter by Upcoming/Past/Today events (Admin Events List).
+ Added : Filter by event (Admin Registrations List).
+ [MODULE iC Calendar] Added : Multi-selection of categories.
+ [MODULE iC Calendar] Added : Option to select a default font color for calendar.
+ [SQL] Added : 'metadesc' field to store an event meta-description (if not set, uses the new function to generate a short meta-description based on full description (limited to 160 characters to give the best SEO performance).
+ [SQL] Added : 'custom_fields' field to store data from custom fields (not yet available).
~ [Theme Pack] DEFAULT : major changes in event details view (default_event.php) and list view (default_events.php) by removing table tags, and using div to display content. Many class names changed with a leading prefix 'ic-' added to prevent possible conflict of naming with site templates css files.
~ Updated : iCalcreator updated from v2.16.12 to v2.18 (Add to iCal and Outlook).
~ Changed : limited length for url when adding an event to Yahoo and Google calendar (to prevent errors).
~ Changed : Updating preview of event image in edit admin when mouseover preview link.
~ Changed : Removal of the 404 block in order to prevent double display of an error page (depending of the site template used).
~ [SEO] Changed and enhanced : meta title and description are improved, better filtering, and give the best possible SEO performance.
~ [PRO][MODULE iC Event List] Changed : Using user timezone or if not set, Joomla server time zone, to set today time.
# [HIGH] Security : Fixed access to registration form when an event is unpublished or finished (prevents spamming).
# [MEDIUM] Fixed : conflict with module login, when a user log-in or log-out on the event details view, if 'add to cal' activated (loading iCal/outlook .ics file).
# [MEDIUM] Fixed : redirect to login page if user has no access to registration form and event details page (if direct visit to this page).
# [LOW] Fixed : not sending if missing space after comma, in custom list of emails for notification email.
# [LOW] Fixed : add to outlook calendar if no end date.
# [LOW] Fixed : Error introduced in a previous version with 'add to cal' function, concerning Windows live and yahoo calendars (url broken).
# [LOW] Fixed : Error to get show_page_heading from menu, when not set.
# [LOW] Fixed : conflict of 'date' variable between event details view and calendar (renamed 'iccaldate' in calendar).
# [LOW] Fixed : Error in setting next date if only one date (and/or only sunday) selected as weekday (period events).
#  Many minor bugs fixed, and many code improvement.

* Changed files in 3.3.0
~ admin/config.xml
~ admin/models/category.php
~ admin/models/event.php
~ admin/models/events.php
~ admin/models/forms/event.xml
~ admin/models/mail.php
~ admin/models/registrations.php
~ admin/sql/install.mysql.utf8.sql
~ admin/sql/uninstall.mysql.utf8.sql
~ admin/tables/event.php
~ admin/views/categories/tmpl/default.php
~ admin/views/event/tmpl/edit.php
~ admin/views/events/tmpl/default.php
~ admin/views/events/view.html.php
~ admin/views/icagenda/tmpl/default.php
~ admin/views/info/tmpl/default.php
~ admin/views/registrations/tmpl/default.php
~ admin/views/registrations/view.html.php
~ [MODULE][PRO] modules/mod_ic_event_list/mod_ic_event_list.php
~ [MODULE][PRO] modules/mod_ic_event_list/mod_ic_event_list.xml
~ [MODULE] modules/mod_iccalendar/helper.php
~ [MODULE] modules/mod_iccalendar/mod_iccalendar.php
~ [MODULE] modules/mod_iccalendar/mod_iccalendar.xml
~ script.icagenda.php
~ site/add/css/icagenda.css
~ site/add/css/style.css
~ site/add/elements/icsetvar.php
~ site/helpers/iCalcreator.class.php
~ site/helpers/ichelper.php
~ site/helpers/iCicons.class.php
~ site/helpers/icmodel.php
+ site/helpers/media_css.class.php
~ site/models/list.php
~ site/models/submit.php
~ [THEME PACKS] site/themes/packs/default/css/default_component.css
+ [THEME PACKS] site/themes/packs/default/css/default_component_large.css
+ [THEME PACKS] site/themes/packs/default/css/default_component_medium.css
+ [THEME PACKS] site/themes/packs/default/css/default_component_small.css
+ [THEME PACKS] site/themes/packs/default/css/default_component_xsmall.css
~ [THEME PACKS] site/themes/packs/default/css/default_module.css
+ [THEME PACKS] site/themes/packs/default/css/default_module_large.css
+ [THEME PACKS] site/themes/packs/default/css/default_module_medium.css
+ [THEME PACKS] site/themes/packs/default/css/default_module_small.css
+ [THEME PACKS] site/themes/packs/default/css/default_module_xsmall.css
~ [THEME PACKS] site/themes/packs/default/default_event.php
~ [THEME PACKS] site/themes/packs/default/default_events.php
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_component.css
+ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_component_large.css
+ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_component_medium.css
+ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_component_small.css
+ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_component_xsmall.css
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_module.css
+ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_module_large.css
+ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_module_medium.css
+ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_module_small.css
+ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_module_xsmall.css
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_event.php
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_events.php
~ site/views/list/tmpl/default.php
~ site/views/list/tmpl/default.xml
~ site/views/list/tmpl/default_vcal.php
~ site/views/list/tmpl/event.php
~ site/views/list/tmpl/registration.php
~ site/views/submit/tmpl/default.php
~ site/views/submit/view.html.php
+ SQL : Adding 'metadesc' column to table #__icagenda_events
+ SQL : Adding 'custom_fields' column to table #__icagenda_registration
+ SQL : Create table #__icagenda_customfields



iCagenda 3.2.13 <small style="font-weight:normal;">(2014.02.01)</small>
================================================================================
! [COMPONENT] Advanced Admin ACL (manage access permissions in iCagenda Backend).
! [MODULE iC Calendar] Enhancement of tooltip display on mobile device. Addition of new options in params of the module. (Thanks doorknob!)
! [MODULE iC Calendar] Beta timezone options removed. A new script, developped by doorknob, is now setting "today" highlight according to visitor local time. You keep option to use Joomla Server Time Zone, and you can set highlight on UTC time zone.
! [GNU/GLP License] Update license to version 3 (or later).
+ Added : Category filtering in administration list of events.
+ Added : Category ordering in administration list of events.
~ [Source Language] Fixed of a few errors in english (en-GB British) source translations files (centre, information...). (Thanks Phil Winsor!)
# [LOW] Fixed : limited length to 2068 bytes of the url to add an event to Google Calendar, to prevent 404 error (url length limitation).
# [LOW] Fixed : missing [...] for short description, in default Theme Pack.
# [LOW] Fixed : attachment field in event form (mouseover).
# [LOW] Fixed : Some global styling error in main css files, and some other needed replacements.
# [LOW] Fixed : Conflict Bootstrap/Google Maps, on Zoom Control and street view button (Joomla 3.2).
# [LOW][THEME PACKS] Fixed : Email cloacking click in 'Default' Theme Pack.
# [LOW][MODULE iC Calendar] Fixed : Missing <tr> tags in week days thead.
# [MEDIUM][MODULE iC Calendar] Fixed : Removed limit of sql request.

* Changed files in 3.2.13
! [GNU/GLP License v3] LICENSE.txt
~ admin/access.xml
~ admin/add/css/icagenda.css
~ admin/helpers/icagenda.php
~ admin/icagenda.php
~ admin/liveupdate/classes/tmpl/nagscreen.php
~ admin/models/events.php
~ admin/models/fields/modal/icalert_msg.php
~ admin/models/fields/modal/icfile.php
~ admin/tables/event.php
~ admin/views/categories/tmpl/default.php
~ admin/views/category/tmpl/edit.php
~ admin/views/event/tmpl/edit.php
~ admin/views/events/tmpl/default.php
~ admin/views/events/view.html.php
~ admin/views/icagenda/tmpl/default.php
~ admin/views/info/tmpl/default.php
~ admin/views/mail/tmpl/edit.php
~ admin/views/registrations/tmpl/default.php
~ admin/views/themes/tmpl/default.php
+ media/images/global_options-48.png
+ [Folder] media/images/panel_denied/
+ [MODULE][PRO] modules/mod_ic_event_list/LICENSE.txt
~ [MODULE][PRO] modules/mod_ic_event_list/mod_ic_event_list.php
~ [MODULE][PRO] modules/mod_ic_event_list/mod_ic_event_list.xml
~ [MODULE][PRO] modules/mod_ic_event_list/tmpl/icrounded.php
~ [MODULE] modules/mod_iccalendar/helper.php
- [MODULE] modules/mod_iccalendar/js/function.js
- [MODULE] modules/mod_iccalendar/js/function_312.js
- [MODULE] modules/mod_iccalendar/js/function_316.js
- [MODULE] modules/mod_iccalendar/js/ictip.js
+ [MODULE] modules/mod_iccalendar/js/jQuery.highlightToday.js
+ [MODULE] modules/mod_iccalendar/js/jQuery.highlightToday.min.js
+ [MODULE] modules/mod_iccalendar/LICENSE.txt
~ [MODULE] modules/mod_iccalendar/mod_iccalendar.php
~ [MODULE] modules/mod_iccalendar/mod_iccalendar.xml
~ [PLUGIN] plugins/plg_ic_autologin/ic_autologin.php
+ [PLUGIN] plugins/plg_ic_autologin/LICENSE.txt
~ script.icagenda.php
~ site/add/css/icagenda.css
~ site/add/css/style.css
~ site/helpers/ichelper.php
~ site/helpers/icmodel.php
~ site/icagenda.php
~ site/js/icmap.js
- site/js/map.js
~ [THEME PACKS] site/themes/packs/default/css/default_module.css
~ [THEME PACKS] site/themes/packs/default/default_day.php
~ [THEME PACKS] site/themes/packs/default/default_event.php
~ [THEME PACKS] site/themes/packs/default/default_events.php
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_module.css
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_day.php
~ site/views/list/tmpl/event.php


iCagenda 3.2.12 <small style="font-weight:normal;">(2014.01.08)</small>
================================================================================
! [MODULE iC Calendar] Disabling by default the function detecting the visitor time zone in module calendar, in order to highlight 'today'. This script function was giving some issue depending of your server, settings, and joomla version. You can now find an option in parameters of the module calendar, where you can use the visitor time zone to set 'today' highlight. If option 'Beta 1 - Visitor Time Zone' selected, when a new visitor comes to your website, it sets a variable containing his time zone in session cookies (so could slow a little when first visit of this user, as it reloads the page one time). And it keeps this information in browser cookies. If option 'Beta 2 - Visitor Time Zone' selected, retrieves the time zone of the visitor each time a page with a calendar module is loaded. If you encounter an error or problem during loading of a page where a module calendar is displayed, select 'Joomla - Server Time Zone' to use the global configuration Time Zone set for your website, and clean your cookies. A better and more advanced solution will be developped to set the detection of visitor time zone.
~ Minor enhancements and corrections in code.
~ [iCicons] Update of iCagenda iCicons font.
# [LOW][MODULE iC Event List][PRO] Fixed : Issue on joomla 2.5 with option 'All' in multi-select of categories resulting in an empty list.
# [LOW] Fixed : missing strip_tags in event.php tmpl view file.

* Changed files in 3.2.12
~ [FOLDER][iCicons] media/icicons
+ media/js/detect_timezone.js
+ media/js/jquery.detect_timezone.js
~ [MODULE][PRO] modules/mod_ic_event_list/mod_ic_event_list.php
~ [MODULE] modules/mod_iccalendar/helper.php
~ [MODULE] modules/mod_iccalendar/mod_iccalendar.php
~ [MODULE] modules/mod_iccalendar/mod_iccalendar.xml
~ script.icagenda.php
~ site/helpers/icmodel.php
~ site/models/forms/submit.xml
~ [THEME PACKS] site/themes/packs/default/css/default_component.css
~ [THEME PACKS] site/themes/packs/default/default_registration.php
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_component.css


iCagenda 3.2.11 FIX for 3.2.10 <small style="font-weight:normal;">(2014.01.04)</small>
================================================================================
! The function detecting the visitor time zone, in order to highlight 'today', and introduced in version 3.2.10, is now disabled on Joomla 2.5 website due to a possible alert message (no error on Joomla 3). This feature needs more developpement and testing before being introduced again for Joomla 2.5 sites, because of all possible script conflicts that happen on this platform (Joomla 3.2.1 is much more fluid!).
# [HIGH][MODULE iC Calendar] Fixed : Possible issue with calendar (redirecting to home page if script for setting visitor time zone failed).
# [MEDIUM] Fixed : Issue when 'All Dates' selected, and SEF not activated, in opening event details (error 404).

* Changed files in 3.2.11
~ [MODULE] modules/mod_iccalendar/helper.php
~ site/views/list/tmpl/default.php


iCagenda 3.2.10 <small style="font-weight:normal;">(2014.01.03)</small>
================================================================================
+ Added : Options for emails of notification and confirmation - Registration form.
+ [MODULE iC Event List][PRO] Added : 'Upcoming & Today' and 'Today' filter options.
+ [MODULE iC Event List][PRO] Added : Multi-selection of categories.
+ [MODULE iC Calendar] Added : Option to display 'country'.
~ Updated : Translation Credits and Contributors informations.
~ [MODULE iC Calendar] Enhancement : get visitor timezone and set it to session using javascript (client side) to highlight correctly 'today'.
~ [MODULE iC Calendar] Changed : get option 'display time' and global setting 'time format', in tooltip.
# [LOW] Fixed : Filtering of html content of the tip related to 'Add to Cal' button.
# [LOW][MODULE iC Calendar] Fixed : Error on a php 5.2 server, because of the new function to order events per hour in the tooltip (We really recommend switching to minimum php 5.3).
# [LOW][THEME PACKS] Fixed : Link on title in default theme pack.

* Changed files in 3.2.10
~ admin/config.xml
+ admin/models/fields/modal/ictext_placeholder.php
~ admin/views/icagenda/tmpl/default.php
~ admin/views/info/tmpl/default.php
~ [MODULE][PRO] modules/mod_ic_event_list/helper.php
~ [MODULE][PRO] modules/mod_ic_event_list/mod_ic_event_list.php
~ [MODULE][PRO] modules/mod_ic_event_list/mod_ic_event_list.xml
~ [MODULE] modules/mod_iccalendar/helper.php
~ [MODULE] modules/mod_iccalendar/mod_iccalendar.php
~ [MODULE] modules/mod_iccalendar/mod_iccalendar.xml
~ script.icagenda.php
~ site/helpers/iCicons.class.php
~ site/helpers/icmodel.php
~ [THEME PACKS] site/themes/packs/default/default_day.php
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_day.php


iCagenda 3.2.9 <small style="font-weight:normal;">(2013.12.28)</small>
================================================================================
+ Added : Add to calendar icon (iCal, Google, Yahoo, Windows Live and Outlook calendars) in event details view.
+ Added : Print icon in event details view.
+ [MODULE Calendar] Added : Time for each event, in infotip.
+ [MODULE Calendar] Added : Option to used the text 'Close' in the infotip, translated in your current language, or use of a custom value.
+ [MODULE iC Event List][PRO] Added : Option to display list in columns (1 to 4 columns per row).
~ [THEME PACKS] Changed : style class 'content' renamed in 'ic-content'.
~ [THEME PACKS] Removed : Back button from Theme Packs, and added it in view file (to add future options for this button).
# [LOW] Fixed : Missing date in url, when clicking on [...] in short description, if 'All Dates' option selected for the list of events page view.
# [MEDIUM] Fixed : Change og tag description to full description, for sharing on social networks (remove html tags).
# [MEDIUM][MODULES] Fixed : Date display in Event details view after click on module links, was wrong if 'All Dates' option selected for the list of events page view.
# [MEDIUM][MODULE CALENDAR] Fixed : missing closing div in loading html (may in a rare cases give an error in displaying script code).

* Changed files in 3.2.9
~ admin/config.xml
~ admin/models/fields/modal/ictxt_default.php
~ admin/models/fields/modal/icvalue_opt.php
~ admin/views/info/tmpl/default.php
+ [FOLDER] media/images/cal/
~ [MODULE][PRO] modules/mod_ic_event_list/css/default_style.css
~ [MODULE][PRO] modules/mod_ic_event_list/css/icrounded_style.css
~ [MODULE][PRO] modules/mod_ic_event_list/mod_ic_event_list.php
~ [MODULE][PRO] modules/mod_ic_event_list/mod_ic_event_list.xml
~ [MODULE][PRO] modules/mod_ic_event_list/tmpl/default.php
~ [MODULE][PRO] modules/mod_ic_event_list/tmpl/icrounded.php
~ [MODULE] modules/mod_iccalendar/helper.php
~ [MODULE] modules/mod_iccalendar/mod_iccalendar.php
~ [MODULE] modules/mod_iccalendar/mod_iccalendar.xml
~ site/add/css/style.css
~ site/add/elements/icsetvar.php
~ site/controller.php
+ site/helpers/iCalcreator.class.php
~ site/helpers/ichelper.php
+ site/helpers/iCicons.class.php
~ site/helpers/icmodel.php
~ site/models/list.php
~ [THEME PACKS] site/themes/packs/default/css/default_component.css
~ [THEME PACKS] site/themes/packs/default/css/default_module.css
~ [THEME PACKS] site/themes/packs/default/default_day.php
~ [THEME PACKS] site/themes/packs/default/default_event.php
~ [THEME PACKS] site/themes/packs/default/default_events.php
~ [THEME PACKS] site/themes/packs/default/default_registration.php
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_component.css
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_module.css
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_day.php
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_event.php
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_events.php
~ site/views/list/tmpl/default.php
+ site/views/list/tmpl/default_vcal.php
~ site/views/list/tmpl/event.php
~ site/views/list/view.html.php


iCagenda 3.2.8 <small style="font-weight:normal;">(2013.12.15)</small>
================================================================================
! New : Option to display All Dates for each event (or Next/last date of each event as it was before this release).
! [THEME PACKS] Important : New file THEME_events.php to replace THEME_list.php, and new names of data variables.
+ Added : Globalization Date Format file for Ukrainian uk-UA
+ Added : Localization of Google-maps based on the current language of the site. (Thanks SLV!)
~ [MODULE iC Event List][PRO] Changed : Enhancement of Date and Time option.
~ Changed : Enhancement of css of Submission form on J2.5 websites.
# [LOW] Fixed : alone div tag, which can give problem of display of submission form page.
# [LOW] Fixed : issue in style display of category title.
# [LOW] Fixed : category title and description in header of list of events sometimes in double.
# [THEME PACKS][LOW] Fixed : css missing style for category name in header of the list of events.
# [MODULE iC Event List][PRO][LOW] Fixed : Possible issue with module display.
# [MODULE Calendar][MEDIUM] Fixed : Possible issue with module changing months, due to a bug in text "loading...".

* Changed files in 3.2.8
~ admin/add/css/icagenda.css
~ admin/config.xml
+ admin/globalization/uk-UA.php
+ admin/models/fields/modal/icalert_msg.php
~ admin/views/event/tmpl/edit.php
~ [MODULE][PRO] modules/mod_ic_event_list/css/icrounded_style.css
~ [MODULE][PRO] modules/mod_ic_event_list/mod_ic_event_list.php
~ [MODULE][PRO] modules/mod_ic_event_list/mod_ic_event_list.xml
~ [MODULE][PRO] modules/mod_ic_event_list/tmpl/default.php
~ [MODULE][PRO] modules/mod_ic_event_list/tmpl/icrounded.php
~ [MODULE] modules/mod_iccalendar/helper.php
~ [MODULE] modules/mod_iccalendar/mod_iccalendar.php
~ script.icagenda.php
~ site/add/css/icagenda.j25.css
- site/add/css/template.css
+ site/add/elements/icsetvar.php
~ site/helpers/ichelper.php
~ site/helpers/icmodel.php
~ site/models/list.php
~ [THEME PACKS] site/themes/packs/default/css/default_component.css
~ [THEME PACKS] site/themes/packs/default/css/default_module.css
~ [THEME PACKS] site/themes/packs/default/default_event.php
+ [THEME PACKS] site/themes/packs/default/default_events.php
- [THEME PACKS] site/themes/packs/default/default_list.php
~ [THEME PACKS] site/themes/packs/default/default_registration.php
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_component.css
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_module.css
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_event.php
+ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_events.php
- [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_list.php
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_registration.php
~ site/views/list/tmpl/default.php
~ site/views/list/tmpl/default.xml
~ site/views/list/tmpl/event.php
~ site/views/list/tmpl/registration.php
~ site/views/list/view.html.php
~ site/views/submit/tmpl/default.php
~ site/views/submit/tmpl/send.php


iCagenda 3.2.7 <small style="font-weight:normal;">(2013.11.23)</small>
================================================================================
~ [MODULE iC calendar] Changed : minor edit in sql request of module iC calendar
# [LOW] Fixed : bug in breadcrumbs event details view.
# [THEME PACKS][LOW] Fixed : possible issue of display break when using ic_rounded theme (depending of your site template).

* Changed files in 3.2.7
~ [MODULE] modules/mod_iccalendar/helper.php
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_list.php
~ site/views/list/tmpl/event.php


iCagenda 3.2.6 <small style="font-weight:normal;">(2013.11.21)</small>
================================================================================
! New : Option (menu and global) to display Category informations; title and/or description (in header of list of events).
+ Added : Event Details view added to Breadcrumbs.
+ Added : Option Top & Bottom for navigation arrows (list of events).
# [MODULE iC Event List][PRO] Fixed : time not displayed correctly in module iC Event List.
# [MODULE iC Event List][PRO] Fixed : clic to event details views was not working on IE 9 (and under) with icrounded layout.

* Changed files in 3.2.6
~ admin/config.xml
+ admin/models/fields/modal/icmulti_checkbox.php
+ admin/models/fields/modal/icmulti_opt.php
~ admin/models/forms/category.xml
~ admin/views/icagenda/tmpl/default.php
~ [MODULE][PRO] modules/mod_ic_event_list/mod_ic_event_list.php
~ [MODULE][PRO] modules/mod_ic_event_list/tmpl/default.php
~ [MODULE][PRO] modules/mod_ic_event_list/tmpl/icrounded.php
~ site/helpers/icmodel.php
~ site/models/list.php
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_component.css
~ site/views/list/tmpl/default.php
~ site/views/list/tmpl/default.xml
~ site/views/list/tmpl/event.php
~ site/views/list/view.html.php


iCagenda 3.2.5 <small style="font-weight:normal;">(2013.11.11)</small>
================================================================================
! Terms and Conditions Option added to registration form.
! Design compatibility with Joomla 3.2.0 (admin header html) and enhancements in admin display.
+ [THEME PACKS] Added css and php integration of registration infos in calendar tooltip.
+ [MODULE iC Calendar] Added : Options to display city, name of venue, short description, and registration infos (number of seats, seats available and already registered).
~ [MODULE iC Calendar] Changed : 'today' day is now using joomla timezone (was server timezone before).

* Changed files in 3.2.5
~ admin/add/css/icagenda.css
~ admin/add/css/icagenda.j25.css
~ admin/config.xml
- admin/models/fields/eventtitle.php
+ admin/models/fields/modal/ictxt_article.php
+ admin/models/fields/modal/ictxt_content.php
+ admin/models/fields/modal/ictxt_default.php
+ admin/models/fields/modal/ictxt_type.php
~ admin/models/forms/category.xml
~ admin/models/forms/event.xml
~ admin/views/categories/view.html.php
~ admin/views/category/tmpl/edit.php
~ admin/views/category/view.html.php
~ admin/views/event/tmpl/edit.php
~ admin/views/event/view.html.php
~ admin/views/events/view.html.php
~ admin/views/icagenda/view.html.php
~ admin/views/info/view.html.php
~ admin/views/mail/view.html.php
~ admin/views/registrations/view.html.php
~ admin/views/themes/view.html.php
~ [MODULE][PRO] modules/mod_ic_event_list/mod_ic_event_list.xml
~ [MODULE] modules/mod_iccalendar/helper.php
~ [MODULE] modules/mod_iccalendar/mod_iccalendar.xml
~ script.icagenda.php
- site/add/js/address.js
- site/add/js/dates.js
~ [THEME PACKS] site/themes/packs/default/css/default_module.css
~ [THEME PACKS] site/themes/packs/default/default_day.php
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_module.css
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_day.php
~ site/views/list/tmpl/registration.php


iCagenda 3.2.4 <small style="font-weight:normal;">(2013.10.29)</small>
================================================================================
+ [MODULE iC Event List][PRO] Added : category color as background of the date, in 'default' layout.
~ [MODULE iC Calendar] Changed : authorizes <br /> and <br> html tags in Short Description.
# Fixed : Issue when only sunday selected for period events, all days of the week were displayed.
# Fixed : Not display of Google Maps (blank) after update to last release 3.2.3, when Google Maps Global Options were not set before.
# Fixed : safehtml filter from joomla not working in frontend (skipping html tags, as should not). Filter set now to raw to not skip tags.
# Fixed : issue when access levels to Event Submission Form set to multiple levels (was not filtering access levels as expected).
# [THEME PACKS] Fixed : Issue Alignement of editor buttons in submission form.
# [MODULE iC Event List][PRO] Fixed : wrong display of events in column, due to a conflict in some site templates.

* Changed files in 3.2.4
~ admin/views/event/tmpl/edit.php
~ [MODULE][PRO] modules/mod_ic_event_list/css/default_style.css
~ [MODULE][PRO] modules/mod_ic_event_list/css/icrounded_style.css
~ [MODULE][PRO] modules/mod_ic_event_list/helper.php
~ [MODULE][PRO] modules/mod_ic_event_list/mod_ic_event_list.php
~ [MODULE][PRO] modules/mod_ic_event_list/mod_ic_event_list.xml
~ [MODULE][PRO] modules/mod_ic_event_list/tmpl/default.php
~ [MODULE][PRO] modules/mod_ic_event_list/tmpl/icrounded.php
~ [MODULE] modules/mod_iccalendar/helper.php
~ site/helpers/icmodel.php
~ site/models/forms/submit.xml
~ site/models/submit.php
~ [THEME PACKS] site/themes/packs/default/css/default_component.css
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_component.css
~ site/views/list/tmpl/default.php
~ site/views/list/view.html.php
~ site/views/submit/tmpl/default.php
~ site/views/submit/view.html.php


iCagenda 3.2.3 <small style="font-weight:normal;">(2013.10.20)</small>
================================================================================
! [THEME PACKS] Updated : enhancements of ic_rounded theme pack, to give a better responsive experience. All table tags have been removed, and replace with div tags, and with addition of @media css styling depending of the device (mobile, tablet, desktop). This new version of ic_rounded theme pack will now have version number respectively to the component version. (to improve tracking updates by users creating their own theme. For your information, a website page is in preparation for you to get more information and documentation about creating and updating a personal Theme Pack, and new features for Theme Pack manager are in brainstorming!).
! No loading of Google Maps scripts, if no address is set, or if global option is set on Hide (to speed up loading when this files are not needed).
+ Added : missing Options Week Days in Frontend Submission Form.
+ [MODULE iC Event List][PRO] Added : Options to display date and time, city, short description, and registration infos (number of seats, seats available and already booked).
~ [THEME PACKS] Changed : enhancements of the back arrow to detect if a previous page has been visited. Code in themes php file is now simplified.
~ Changed : enhancements of Open Graph tags (title, type, image, url, description, sitename).
~ Changed : enhancements and changes in <hn> tags used in iCagenda, to able a better structural hierarchy of list of events. (auto-detect if page heading is displayed in content or not, to set properly the Hn tag).
~ Changed : views php files to speed up loading of iCagenda (list of events, event details and event registration).
# Fixed : Calendar Issue; Bug in some countries about the time change. If a date of an event over a period was the day of the time change, it was generated 2 times. The new feature integrates this setting to not double this day.


* Changed files in 3.2.3
+ admin/models/fields/modal/icvalue_field.php
+ admin/models/fields/modal/icvalue_opt.php
~ [MODULE][PRO] modules/mod_ic_event_list/css/default_style.css
~ [MODULE][PRO] modules/mod_ic_event_list/css/icrounded_style.css
~ [MODULE][PRO] modules/mod_ic_event_list/helper.php
~ [MODULE][PRO] modules/mod_ic_event_list/mod_ic_event_list.php
~ [MODULE][PRO] modules/mod_ic_event_list/mod_ic_event_list.xml
~ [MODULE][PRO] modules/mod_ic_event_list/tmpl/default.php
~ [MODULE][PRO] modules/mod_ic_event_list/tmpl/icrounded.php
~ [MODULE] modules/mod_iccalendar/helper.php
+ site/helpers/ichelper.php
~ site/helpers/icmodel.php
~ site/models/forms/submit.xml
~ site/models/list.php
~ site/models/submit.php
~ [THEME PACKS] site/themes/packs/default/css/default_component.css
~ [THEME PACKS] site/themes/packs/default/css/default_module.css
~ [THEME PACKS] site/themes/packs/default/default_calendar.php
~ [THEME PACKS] site/themes/packs/default/default_day.php
~ [THEME PACKS] site/themes/packs/default/default_event.php
~ [THEME PACKS] site/themes/packs/default/default_list.php
~ [THEME PACKS] site/themes/packs/default/default_registration.php
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_component.css
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_module.css
+ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_alldates.php
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_calendar.php
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_day.php
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_event.php
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_list.php
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_registration.php
~ site/views/list/tmpl/default.php
~ site/views/list/tmpl/event.php
~ site/views/list/tmpl/registration.php
~ site/views/list/view.html.php
~ site/views/submit/tmpl/default.php
~ site/views/submit/tmpl/send.php


iCagenda 3.2.2 <small style="font-weight:normal;">(2013.10.10)</small>
================================================================================
! [iCicons] Use of integrated vector icons 'iCicons' designed for iCagenda (will evolve!).
# Fixed : List of dates in registration form (was not filtering by weekdays).
# [iCicons] Fixed : Android not display of arrows in ascii code (calendar, back button, back/next navigation).
# [iCicons] Fixed : Iphone/Ipad, arrows were not clickable (calendar, back button, back/next navigation).
# Fixed : ACL access levels filtering for events in front-end.
# Fixed : Request of Itemid in submit form.
~ Changed : better filtering of Approval access.
~ Changed : clean-up of some php functions, and sql request in frontend.
~ [THEME PACKS] Changed : enhancements of module css, and adding vector icon for back button.

* Changed files in 3.2.2
~ admin/views/events/tmpl/default.php
~ icagenda.xml
~ [MODULE] modules/mod_iccalendar/helper.php
~ [MODULE] modules/mod_iccalendar/mod_iccalendar.php
~ [MODULE] modules/mod_iccalendar/mod_iccalendar.xml
~ site/helpers/icmodel.php
~ site/models/submit.php
~ [THEME PACKS] site/themes/default.xml
~ [THEME PACKS] site/themes/ic_rounded.xml
~ [THEME PACKS] site/themes/packs/default/css/default_module.css
~ [THEME PACKS] site/themes/packs/default/default_event.php
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_module.css
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_event.php
~ site/views/list/view.html.php
~ site/views/submit/tmpl/default.php
+ [FOLDER] media/icicons/
+ [FOLDER] media/icicons/fonts/
+ media/icicons/fonts/iCicons.eot
+ media/icicons/fonts/iCicons.svg
+ media/icicons/fonts/iCicons.ttf
+ media/icicons/fonts/iCicons.woff
+ media/icicons/lte-ie7.js
+ media/icicons/style.css


iCagenda 3.2.1 <small style="font-weight:normal;">(2013.10.07)</small>
================================================================================
! First Stable release with 'Submit an Event' feature. For Users of the free version, see all the Release Notes of previous RC versions (available for Pro).
~ Changed : Use of DATE_FORMAT_LC3 in list of events, admin (to get date in Russian on windows server).
# Fixed : Remove nowrap css class attribute, to prevent not wrapping to the next line for long title (this is solved in iCagenda, but you may have the same problem in Joomla 3 articles. Proposal of modification added on Joomla core Github).
# Fixed : Error message when updating from an older version, if category filter was set to one category (new option multiple-categories filtering).

* Changed files in 3.2.1
~ admin/views/events/tmpl/default.php
~ site/helpers/icmodel.php
~ site/models/list.php


iCagenda 3.2.0 RC4 <small style="font-weight:normal;">(2013.10.04)</small>
================================================================================
! Added : New option, Multi-selection of categories, in parameters of the menu link to list of events.
! Changed : Updated Google Maps API to V3 https
+ Added : Notification email to a user when his event submitted has been approved by a manager.
+ Added : Redirect to login page if Approval Manager is not connected on event details page (replacing 404 page).
+ Added : New icons for 'Approve this event' (J2.5 using icons, and J3 using icomoon).
+ Added : New tooltip script for manager icons.
+ Added : Router SEF for Submit an Event.
# [LOW] Bug : inserting an extra number data at the end of the footer text line, in notification email send to Approval managers.
# [LOW] Bug : Number of events in header was not well set, when an Approval Manager is logged-in.
# [LOW] Display : Display of info tooltip when Phone Field not shown in registration form.
# [MEDIUM] Bug : display of 'sunday', when no days of the week selected for a period event, in event details view.
~ [THEME PACKS] Changed : Manager Icons are removed from theme packs (to prevent not display in personal theme pack) and added in event.php file.
~ Changed : Attachment opens now in a new window (target blank).

* Changed files in 3.2.0 RC4
~ admin/config.xml
~ admin/models/fields/modal/cat.php
+ admin/models/fields/modal/multicat.php
~ admin/models/forms/event.xml
~ admin/views/event/tmpl/edit.php
~ admin/views/events/tmpl/default.php
~ admin/views/icagenda/tmpl/default.php
~ admin/views/info/tmpl/default.php
~ icagenda.xml
~ site/add/css/style.css
~ site/helpers/icmodel.php
~ site/models/forms/submit.xml
~ site/models/list.php
~ site/models/submit.php
~ site/router.php
~ [THEME PACKS] site/themes/default.xml
~ [THEME PACKS] site/themes/ic_rounded.xml
~ [THEME PACKS] site/themes/packs/default/css/default_component.css
~ [THEME PACKS] site/themes/packs/default/default_event.php
~ [THEME PACKS] site/themes/packs/default/default_list.php
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_component.css
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_event.php
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_list.php
~ site/views/list/tmpl/default.xml
~ site/views/list/tmpl/event.php
~ site/views/list/tmpl/registration.php
~ site/views/list/view.html.php
~ site/views/submit/tmpl/default.php
~ site/views/submit/tmpl/send.php
~ site/views/submit/view.html.php
+ [FOLDER] media/css/
+ media/css/tipTip.css
+ [FOLDER] media/css/manager/
+ media/images/manager/approval_16.png
+ [FOLDER] media/js/
+ media/js/jquery.tipTip.js



iCagenda 3.2.0 RC3 <small style="font-weight:normal;">(2013.09.26)</small>
================================================================================
! Changes in the display of Global Options (added General Settings Tab)
! Fixed : important issue in notification emails send to managers authorized to approve events (due to a bug if user is depending of more than one user groups)
! Changed : Approval can be processed directly in Frontend, at event preview page.
+ Added : Check if managers with Approval permissions are Enabled and Activated.
+ Added : Option to select Template in menu-item link 'Submit an Event'.
+ Added : Global option to enable or disable auto login in url links included in notification emails.
+ Added : implemented Page Header and page class suffix in 'Submit an Event' page.
~ Changed : Events submitted in Frontend by a user (manager) belonging to an authorized group will be automatically approved.
~ Changed : Back button in event details view return to list of events ( replace history.go(-1) ).

* Changed files in 3.2.0 RC3
+ admin/add/elements/desc.php
~ admin/config.xml
~ admin/models/forms/event.xml
~ script.icagenda.pro.php
~ site/helpers/icmodel.php
~ site/models/forms/submit.xml
~ site/models/list.php
~ site/models/submit.php
~ [THEME PACKS] site/themes/packs/default/default_event.php
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_event.php
~ site/views/list/tmpl/registration.php
~ site/views/submit/tmpl/default.php
~ site/views/submit/tmpl/default.xml
~ site/views/submit/tmpl/send.php
~ site/views/submit/view.html.php


iCagenda 3.2.0 RC2 <small style="font-weight:normal;">(2013.09.22)</small>
================================================================================
# Fixed : Access Permissions to 'Submit an Event' form (missing global option).
+ Added : Options to customize the content when a user access to the 'Submit an Event' page, and this user is not connected, or connected but does not have sufficient rights.

* Changed files in 3.2.0 RC2
~ admin/config.xml
+ admin/models/fields/modal/ictext_content.php
+ admin/models/fields/modal/ictext_type.php
~ site/helpers/icmodel.php
~ site/models/list.php
~ site/views/submit/tmpl/default.php


iCagenda 3.2.0 RC <small style="font-weight:normal;">(2013.09.20)</small>
================================================================================
! NEW : Menu Type to 'Submit an Event' in frontend.
! NEW : Selection of days of the week for period events (additional options to come for dates settings!).
! NEW : Plugin iCagenda Autologin.

* Changed files in 3.2.0 RC
~ admin/config.xml
~ admin/models/event.php
~ admin/models/events.php
+ admin/models/fields/modal/tos_article.php
~ admin/models/fields/modal/tos_content.php
+ admin/models/fields/modal/tos_default.php
+ admin/models/fields/modal/tos_type.php
~ admin/tables/event.php
~ admin/views/event/tmpl/edit.php
~ [MODULE PRO] modules/mod_ic_event_list/mod_ic_event_list.php
~ [MODULE] modules/mod_iccalendar/helper.php
~ script.icagenda.php
~ site/helpers/icmodel.php
~ site/models/list.php
~ site/models/submit.php
~ [THEME PACKS] site/themes/default.xml
~ [THEME PACKS] site/themes/packs/default/default_event.php
~ [THEME PACKS] site/themes/packs/default/default_list.php
~ [THEME PACKS] site/themes/ic_rounded.xml
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_event.php
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_list.php
+ site/views/submit/tmpl/default.php
+ site/views/submit/tmpl/default.xml
+ site/views/submit/tmpl/send.php
+ site/views/submit/view.html.php
+ [PLUGIN] plugins/plg_ic_autologin/ic_autologin.php
+ [PLUGIN] plugins/plg_ic_autologin/ic_autologin.xml
+ SQL : Adding 'daystime' column to table icagenda_events


iCagenda 3.1.13 <small style="font-weight:normal;">(2013.09.20)</small>
================================================================================
# Fixed : display in frontend of the fake date 30 november 1999, if no single date is set.

* Changed files in 3.1.13
~ site/helpers/icmodel.php


iCagenda 3.1.12 <small style="font-weight:normal;">(2013.09.17)</small>
================================================================================
# Fixed : A problem with the control of the upcoming date for events over a period (unpublished event and message 'no valid date'). This bug is present since version 3.1.5, and rarely appeared.
# Fixed : conflict CSS days font color in calendar module with some Shape5 templates.

* Changed files in 3.1.12
~ site/helpers/icmodel.php
~ [THEME PACKS] site/themes/default.xml
~ [THEME PACKS] site/themes/ic_rounded.xml
~ [THEME PACKS] site/themes/packs/default/css/default_module.css
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_module.css


iCagenda 3.1.11 <small style="font-weight:normal;">(2013.09.13)</small>
================================================================================
# Fixed : Italian bug in translation files, responsible of missing features in event edit (admin).
# Fixed : Error mktime when saving a new event (due to no filling of single dates). A fix should update in the same way events with this issue in the frontend.

* Changed files in 3.1.11
~ admin/models/fields/modal/date.php
~ admin/views/event/tmpl/edit.php
~ site/helpers/icmodel.php


iCagenda 3.1.10 <small style="font-weight:normal;">(2013.09.12)</small>
================================================================================
+ added : control if allow_url_fopen and GD are enabled (thumbnails generator)
+ added : files to prepare the next release with Submit an Event feature!
+ added : Approval option in event edit (will be operating in release 3.2!).
~ Changed : new dates control when saving an event, display now an alert message for new event, and block saving of a new event if no valid date.
~ Changed : enhancement of period datepicker (not possible now to have end date before start date)
# Fixed : not generation of thumbs when extension of a file in caps.
# MODULE iC calendar : Fixed possible conflicts due to div tags enclosed within scripts (rare conflict, manifested by the appearance of a part of the script on the page, and the non-functioning of the calendar).
# THEME IC_ROUNDED : display of next date (Time 2 times), list of events.

* Changed files in 3.1.10
~ admin/add/js/icdates.js
~ admin/config.xml
~ admin/controllers/events.php
+ admin/helpers/html/events.php
~ admin/models/event.php
~ admin/models/fields/modal/date.php
~ admin/models/fields/modal/enddate.php
~ admin/models/fields/modal/startdate.php
+ admin/models/fields/modal/tos_content.php
~ admin/models/forms/event.xml
~ admin/tables/event.php
~ admin/views/event/tmpl/edit.php
~ admin/views/events/tmpl/default.php
~ [PRO] modules/mod_ic_event_list/mod_ic_event_list.php
~ modules/mod_iccalendar/helper.php
~ modules/mod_iccalendar/mod_iccalendar.php
~ site/add/js/icdates.js
~ site/helpers/icmodel.php
+ site/models/forms/submit.xml
~ site/models/list.php
+ site/models/submit.php
~ [THEME PACKS] site/themes/ic_rounded.xml
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_list.php
+ SQL : Adding 'approval' column to table icagenda_events


iCagenda 3.1.9 <small style="font-weight:normal;">(2013.09.06)</small>
================================================================================
! MODULE iC calendar : possibility now to publish many calendars on a single page.
+ Added : Extra-control if mime-type of the event's image is correct (in order to process thumbnails creation).
+ Added : Complete or not form fields 'Name' and 'Email' with the profile information of a Joomla user connected, in registration form.
+ Added : Option to enable or disable the thumbnail generator.
+ Added : 'Notes' field text area in Registration form (set disabled as default).
+ Added : Option Show/Hide 'Notes' in registration form.
+ Added : Option Show/Hide 'Phone' in registration form.
+ Added : Information and control of folder creation used by iCagenda (thumbnails, attachments).
~ THEME PACKS : version 2.0 (default and ic_rounded).
~ Changed : period of dates with start date the same day than end date is now displayed as 'date start time - end time' (eg. 23 April 2013 10:00-19:00)
~ Changed : list of date formats was without <optgroup> infos in Joomla 3
# MODULE iC calendar : Fixed, Tooltip Close X button was not working on Apple mobile devices.
# Fixed : bugs in thumbnails generator if ROOT/images folder doesn't exist. Solve an issue if path to images is not 'images'.

* Changed files in 3.1.9
~ admin/config.xml
~ admin/models/event.php
~ admin/models/fields/iclist/globalization.php
~ admin/models/fields/modal/enddate.php
~ admin/models/fields/modal/startdate.php
~ admin/models/forms/event.xml
~ admin/models/registrations.php
~ admin/tables/event.php
~ admin/views/event/tmpl/edit.php
~ admin/views/events/tmpl/default.php
~ admin/views/registrations/tmpl/default.php
~ media/scripts/icthumb.php
~ [PRO] modules/mod_ic_event_list/mod_ic_event_list.php
~ [PRO] modules/mod_ic_event_list/mod_ic_event_list.xml
+ modules/mod_iccalendar/helper.php
~ modules/mod_iccalendar/mod_iccalendar.php
~ modules/mod_iccalendar/mod_iccalendar.xml
~ script.icagenda.php
- site/helpers/icmodcalendar.php
~ site/helpers/icmodel.php
~ site/models/list.php
~ [THEME PACKS] site/themes/default.xml
~ [THEME PACKS] site/themes/ic_rounded.xml
~ [THEME PACKS] site/themes/packs/default/default_event.php
~ [THEME PACKS] site/themes/packs/ic_rounded/css/ic_rounded_module.css
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_day.php
~ [THEME PACKS] site/themes/packs/ic_rounded/ic_rounded_event.php
~ site/views/list/tmpl/registration.php
~ site/views/list/view.html.php
+ SQL : Adding 'created_by_email' column to table icagenda_events
+ SQL : Adding 'weekdays' column to table icagenda_events
+ SQL : Adding 'notes' column to table icagenda_registration


iCagenda 3.1.8 <small style="font-weight:normal;">(2013.08.30)</small>
================================================================================
# Fixed : Error message in liveupdate (developped by Nicholas from Akeeba) to work under php 5.2. I've added a php control to be able to load storage.php file. But, we truly recommend every user to upgrade their php version to a minimum of 5.3, as recommended by Joomla core, and as minimum to be able to install Joomla 3. In the future, you can encounter other such issue, or error message, if you're still in a PHP version lower than 5.3.
+ Added : Alert Message in control panel of the component, if PHP version is lower than 5.3.

* Changed files in 3.1.8
~ admin/liveupdate/classes/storage/storage.php
~ admin/views/icagenda/tmpl/default.php


iCagenda 3.1.7 <small style="font-weight:normal;">(2013.08.29)</small>
================================================================================
+ Added : Created_by filter in list of registered users (admin).
+ Added : Option to use php function checkdnsrr in registration form, to check if email provider is valid (this option is now disabled by default).
+ Added : Options for event details view: show/hide dates, Google Maps, information... and set access level for some.
+ Added : Options to order by dates list of single dates, and display a vertical or horizontal list.
+ Added : Option for registration form : auto-filled name or username, in name's form field (was only name before).
+ MODULE iC calendar : Option to display only start date in the calendar, in case of an event over a period.
~ MODULE iC calendar : Changes in script code of function.js file to prevent some conflict.
~ Changed : Search in registrations list extended: username, name, email, date, phone, people... (only search in Title before this release)
~ Changed : Default value is now set to "by individual date" in 'Registration Type' field.
~ Changed : Upgraded files of LiveUpdate by Akeeba, updates system integrated in iCagenda.
# Fixed : sending notification email to author of an event, when new registration. Fixed of [AUTHOREMAIL] tag.
# Fixed : Error Debug of Google Maps (icmap.js).

* Changed files in 3.1.7
~ admin/config.xml
~ admin/liveupdate/ (All php files of this folder updated)
+ admin/models/fields/modal/checkdnsrr.php
~ admin/models/forms/event.xml
~ admin/models/registrations.php
~ admin/views/icagenda/tmpl/default.php
~ admin/views/registrations/tmpl/default.php
~ modules/mod_iccalendar/js/function.js
~ modules/mod_iccalendar/mod_iccalendar.xml
~ site/helpers/icmodcalendar.php
~ site/helpers/icmodel.php
~ site/js/icmap.js
~ site/themes/packs/default/default_event.php
~ site/views/list/tmpl/registration.php


iCagenda 3.1.6 <small style="font-weight:normal;">(2013.08.20)</small>
================================================================================
# Fixed : NextDate control when event set on a period in the future.
+ Added : Control of time when event with a date in a period the same as a single date.
+ Added : On windows server and php version < 5.3, disable check function if provider of an email address during registration is valid, as checkdnsrr is implemented on windows server only since php 5.3.0

* Changed files in 3.1.6
~ site/helpers/icmodel.php


iCagenda 3.1.5 Security Release and enhancements! <small style="font-weight:normal;">(2013.08.19)</small>
================================================================================
! Security Release : fixed a XSS vulnerability discovered by Stefan Horlacher from Compass Security AG (www.csnc.ch) (many thanks Stefan to keep the web clean and secured!). Another issue was resolved, discovered by Giusebos, which allowed sending spam to the administrator and the creator of the event, using cookies via registration form. And that's not all! As we always want to add much more security, some filtering enhancements have been added to the registration form (see below).
! Change : Now, when an event over a period with an end date and its time set to 00:00:00, this end date is displayed in frontend (list of events, and modules).
+ Added : New options in filtering events in menuitem. Now you can display all events, upcoming events, past events, events of the day and upcoming, or today's events.
+ Added : Page 404 when event not found.
+ Added : Enhancement of Email control during registration. Test if provider is valid.
+ Added : Test of the Name during registration. Now, a name cannot start with a number and cannot contain any of the following characters: / \ < > "_QQ_" [ ] ( ) " ; = + &.
+ Added : Control in front-end if dates of events are valid (control was before only in admin edit)
# Fixed : was counted archived events in header of list of events, and should not.
# Fixed : if end time is lower or equal to start time of an event over a period, end date is displayed.
# Fixed : Author name and username were not correctly displayed in admin events list, and now display correctly the user selected in 'created by'.

* Changed files in 3.1.5
~ admin/models/events.php
~ admin/tables/event.php
~ admin/views/events/tmpl/default.php
~ site/helpers/icmodcalendar.php
~ site/helpers/icmodel.php
~ site/views/list/tmpl/default.xml
~ site/views/list/tmpl/event.php
~ site/views/list/tmpl/registration.php


iCagenda 3.1.4 <small style="font-weight:normal;">(2013.08.13)</small>
================================================================================
# Fixed : bug in function for detecting wrong dates entered by user, which was not always working as expected, depending of time setting in joomla config
# Fixed : change in function for globalized date format of month and of day, to prevent some errors due to locale (Russian...)
# Fixed : Not sending notification email to the registered user (if his email address is entered and required)
+ Added : Control of event ID to prevent spamming emails to administrator by a robot (notification email admin)
~ Changed : Translation of Date in current language (admin - list of events)

* Changed files in 3.1.4
~ admin/tables/event.php
~ admin/views/events/tmpl/default.php
~ site/helpers/icmodcalendar.php
~ site/helpers/icmodel.php
~ site/themes/packs/default/css/default_module.css
~ site/themes/packs/ic_rounded/css/ic_rounded_module.css


iCagenda 3.1.3 <small style="font-weight:normal;">(2013.08.09)</small>
================================================================================
# Fixed : global option to hide the participants list not working properly
# Fixed : notice message above registration option field, in event edit
~ MODULE iC calendar : changed, access levels control, to speed up loading of pages with calendar
+ MODULE iC calendar : loading picture when charging a new month

* Changed files in 3.1.3
~ admin/models/fields/modal/ph_regbt.php
~ modules/mod_iccalendar/js/function.js
~ modules/mod_iccalendar/mod_iccalendar.php
~ site/helpers/icmodcalendar.php
~ site/helpers/icmodel.php
~ site/themes/packs/default/css/default_module.css
~ site/themes/packs/ic_rounded/css/ic_rounded_module.css
~ (added) site/themes/packs/default/images/ic_load.png
~ (added) site/themes/packs/ic_rounded/images/ic_load.png


iCagenda 3.1.2 <small style="font-weight:normal;">(2013.08.05)</small>
================================================================================
! Important editing of thumbnails generator (List of events in admin, Calendar module, and Event List module). Now, file renaming for thumbnails (remove all special caracters to get a clean url for image), and copy of distant pictures (to prevent broken link). Accepted as image extensions (File Types) for event image : jpg, jpeg, png, gif, bmp
# Fixed : Slow change of month of the calendar (thumbnail generator error function)
# Fixed : Slow display of events in module iC Event List (Pro Version)
~ changed : [J3 issue] jQuery UI version in admin, from 1.9.2 to 1.8.23 to prevent a conflict with description tooltip (appeared since joomla 3.1.4)

* Changed files in 3.1.2
~ admin/views/event/tmpl/edit.php
~ admin/views/events/tmpl/default.php
~ media/scripts/icthumb.php
~ script.icagenda.php
~ site/helpers/icmodcalendar.php


iCagenda 3.1.1 <small style="font-weight:normal;">(2013.07.29)</small>
================================================================================
# Fixed : Wrong filtering of Viewing Access Levels in list of events page
# Fixed : error in modules (front-end), when url to image is broken or invalid
~ changed : url of image when sharing on facebook (other enhancements planned)

* Changed files in 3.1.1
~ admin/views/icagenda/view.html.php
~ script.icagenda.php
~ site/helpers/icmodcalendar.php
~ site/helpers/icmodel.php
~ site/views/list/tmpl/event.php


iCagenda 3.1.0 <small style="font-weight:normal;">(2013.07.26)</small>
================================================================================
! New : Automatic thumbnails generator in modules (some options, and enhancements will be added later in theme packs)
# Fixed : Issues with J3 after upgrade from joomla 3.1.x to 3.1.4 (error 500 default layout missing, and JFile not found)
# Fixed : not sending admin notification email (error in 3.0.1 and 3.0 pre-releases)
# Fixed : No updating of Next Date when menu set to Upcoming Events
# Fixed : participant slide effect and display options not working
+ Added : Global Option for email field in frontend registration (required or not)
~ many code review

* Changed files in 3.1.0
~ admin/config.xml
~ admin/models/categories.php
~ admin/models/fields/modal/ph_regbt.php
~ admin/tables/event.php
~ admin/views/events/tmpl/default.php
~ admin/views/icagenda/view.html.php
~ media/scripts/icthumb.php
~ script.icagenda.php
~ site/helpers/icmodcalendar.php
~ site/helpers/icmodel.php
~ site/models/list.php
~ site/themes/packs/default/default_event.php
~ site/themes/packs/default/css/default_component.css
~ site/themes/packs/ic_rounded/ic_rounded_event.php
~ site/themes/packs/ic_rounded/css/ic_rounded_component.css
~ site/views/list/tmpl/registration.php


iCagenda 3.0.1 <small style="font-weight:normal;">(2013.07.04)</small>
================================================================================
# Fixed : auto-play of the tutorial video on Chrome and Safari (the video should not autoplay)
# Fixed : missing admin pagination in categories list
# Fixed : buttons display over the datepicker (time show/hide button activated)

* Changed files in 3.0.1
~ admin/add/css/jquery-ui-1.8.17.custom.css
~ admin/views/categories/tmpl/default.php
~ admin/views/categories/view.html.php
~ admin/views/event/tmpl/edit.php
~ admin/views/event/view.html.php


iCagenda 3.0 RC <small style="font-weight:normal;">(2013.06.30)</small>
================================================================================
# Fixed : Thumbnail generator in events list admin : error when using a distant url
# Fixed : Position and zooming in admin, in events created before update
# Fixed : Colors of options buttons in event admin edit : not always visible, in events created before update
# Fixed : Theme ic_rounded : problem of display with long title
+ Added : Custom text option for registration button
+ Added : Control if link to event picture is valid, in admin
~ updated : display in Global Options of the component and modules


iCagenda 3.0 beta 1 <small style="font-weight:normal;">(2013.06.09)</small>
================================================================================
! First beta version compatible with Joomla 3 and Joomla 2.5

* Changed files in 3.0
! Given that this new version brings compatibility with Joomla 3, all php files were reviewed to allow dual Joomla 2.5 / 3.x compatibility. Other files were also reviewed, with a major overhaul of logic and graphic structure of iCagenda. The list of modified files is reset with this new version 3.0 of iCagenda and the list of modified files will be detailed again from future release 3.0.1


iCagenda v2 ChangeLog <small style="font-weight:normal;">(2012.12.31 > 2013.05.29)</small>
? <a href="http://icagenda.joomlic.com/docs/changelog/87-v2-changelog" target="_blank" style="color:#fff">http://icagenda.joomlic.com/docs/changelog/87-v2-changelog</a>

iCagenda v1 ChangeLog <small style="font-weight:normal;">(2012.08.07 > 2012.08.29)</small>
? <a href="http://icagenda.joomlic.com/docs/changelog/89-v1-changelog" target="_blank" style="color:#fff">http://icagenda.joomlic.com/docs/changelog/89-v1-changelog</a>

;
