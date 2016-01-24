<?php
// *******************************************************************
// Title          udde Instant Messages (uddeIM)
// Description    Instant Messages System for Mambo 4.5 / Joomla 1.0 / Joomla 1.5
// Author         � 2007-2010 Stephan Slabihoud, � 2006 Benjamin Zweifel
// License        This is free software and you may redistribute it under the GPL.
//                uddeIM comes with absolutely no warranty.
//                Use at your own risk. For details, see the license at
//                http://www.gnu.org/licenses/gpl.txt
//                Other licenses can be found in LICENSES folder.
// *******************************************************************
// Language file: Norwegian (source file is Latin-1)
// Translator v.1.1:	Karl-Gustav Freding - E-mail gusse500@gmail.com
// Translator v1.2 - v1.5:	Christian Segura - E-mail christian@propius.no
// Translator v1.6 - v2.1:	http://villtur.org
// *******************************************************************
DEFINE ('_UDDEADM_TRANSLATORS_CREDITS', 'Karl-Gustav Freding, Christian Segura and <a href="http://villtur.org" target="_new">villtur.org</a>');	// Enter your credits line here, e.g. 'Translation by <a href="http://domain.com" target="_new">John Doe</a>'

// New: 3.8
DEFINE ('_UDDEADM_CAPTCHA_RECAPTCHA2', 'reCaptcha 2.0');
DEFINE ('_UDDEADM_CB2', 'Community Builder 2.0+');

// New: 3.7
DEFINE ('_UDDEADM_SHOWMENULINK_HEAD', 'Show menu entry');
DEFINE ('_UDDEADM_SHOWMENULINK_EXP', 'Show additional menu entry.');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_16', '...set default for additonal menu link');

// New: 3.6
DEFINE ('_UDDEIM_KUNENA_LINK', 'Forum');
DEFINE ('_UDDEIM_PM_USER', 'Send private message');
DEFINE ('_UDDEIM_PM_USER_DESC', 'Send a private message to this user');
DEFINE ('_UDDEIM_PM_INBOX', 'Show private Inbox');
DEFINE ('_UDDEIM_PM_INBOX_DESC', 'Show received private messages');
DEFINE ('_UDDEIM_PM_OUTBOX', 'Show private Outbox');
DEFINE ('_UDDEIM_PM_OUTBOX_DESC', 'Show sent private messages');
DEFINE ('_UDDEIM_PM_TRASHBOX', 'Show trash');
DEFINE ('_UDDEIM_PM_TRASHBOX_DESC', 'Show trashed private messages');
DEFINE ('_UDDEIM_PM_OPTIONS', 'Show PMS options');
DEFINE ('_UDDEIM_PM_OPTIONS_DESC', 'Show PMS options');
DEFINE ('_UDDEIM_PM_ARCHIVE', 'Show private Archive');
DEFINE ('_UDDEIM_PM_ARCHIVE_DESC', 'Show archived private messages');
DEFINE ('_UDDEIM_PM_SENDMESSAGE', 'Message sent');
DEFINE ('_UDDEIM_PM_PMSTAB', 'Send message');
DEFINE ('_UDDEIM_PM_PROFILEMSG', 'Quick message');
DEFINE ('_UDDEIM_PM_SENTSUCCESS', 'Successfully sent.');
DEFINE ('_UDDEIM_PM_SESSIONTIMEOUT', 'Session timeout.');
DEFINE ('_UDDEIM_PM_NOTSENT', 'Message not sent.');
DEFINE ('_UDDEIM_PM_TRYAGAIN', 'Try again.');
DEFINE ('_UDDEIM_PM_EMPTYMESSAGE', 'Empty message.');
DEFINE ('_UDDEIM_PM_EMAILFORMSUBJECT', 'Subject');
DEFINE ('_UDDEIM_PM_EMAILFORMMESSAGE', 'Message');
DEFINE ('_UDDEIM_PM_TABINBOX', 'Inbox');
DEFINE ('_UDDEIM_PM_PMSLINK', 'Private Messaging');

// New: 3.5
DEFINE ('_UDDEADM_GROUPSADMIN_HEAD', 'Additional Admin groups');
DEFINE ('_UDDEADM_GROUPSADMIN_EXP', 'Enter group IDs which should be treated as admin groups (e.g. 10, 11, 17). IDs 7, 8 (Joomla >=1.6) and IDs 24, 25 (Joomla <=1.5) are always admins.');
DEFINE ('_UDDEADM_GROUPSSPECIAL_HEAD', 'Additional Special groups');
DEFINE ('_UDDEADM_GROUPSSPECIAL_EXP', 'Enter group IDs which should be treated as special groups (e.g. 10, 11, 17). IDs 3-8 (Joomla >=1.6) and IDs 19-25 (Joomla <=1.5) are always special users.');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_15', '...set default for additonal groups');

// New: 3.3
DEFINE ('_UDDEADM_KUNENA30', 'Kunena 3.0+');

// New: 3.1
DEFINE ('_UDDEIM_BADWORD', 'Bad word detected');
DEFINE ('_UDDEADM_BADWORDS_HEAD', 'Badwords filter');
DEFINE ('_UDDEADM_BADWORDS_EXP', 'New messages will be filtered for badwords. All badwords have to be seperated by a semicolon (;).');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_14', '...set default for badwords filter');
DEFINE ('_UDDEADM_OOD_PB', 'Postbox Plugin out of date!');

// New: 3.0
DEFINE ('_UDDEADM_UDDEIM', 'uddeIM');
DEFINE ('_UDDEADM_REPLYTEXT_HEAD', 'Auto reply');
DEFINE ('_UDDEADM_REPLYTEXT_EXP', 'The original message will be included automatically when you reply to a message.');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_13', '...set default for replys (options)');

// New: 2.9
DEFINE ('_UDDEADM_KUNENA20', 'Kunena 2.0+');
DEFINE ('_UDDEADM_POSTBOXFULL_HEAD', 'Full message text');
DEFINE ('_UDDEADM_POSTBOXFULL_EXP', 'Show full message text of none, first or all messages.');
DEFINE ('_UDDEADM_POSTBOXFULL_0', 'None');
DEFINE ('_UDDEADM_POSTBOXFULL_1', 'First');
DEFINE ('_UDDEADM_POSTBOXFULL_2', 'All');
DEFINE ('_UDDEADM_POSTBOXAVATARS_HEAD', 'Display Avatars');
DEFINE ('_UDDEADM_POSTBOXAVATARS_EXP', 'Display Avatars in message view.');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_12', '...set default for postbox (options)');

// New: 2.8
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_11', '...set default for postbox');
DEFINE ('_UDDEADM_POSTBOX_HEAD', 'Enable Postbox');
DEFINE ('_UDDEADM_POSTBOX_EXP', 'Enables the Postbox.');
DEFINE ('_UDDEIM_FILTER_TITLE_POSTBOX', 'Show from/to this user only');
DEFINE ('_UDDEIM_MESSAGES', 'Messages');
DEFINE ('_UDDEIM_POSTBOX', 'Postbox');
DEFINE ('_UDDEIM_FILTEREDUSER', 'user filtered');
DEFINE ('_UDDEIM_FILTEREDUSERS', 'users filtered');
DEFINE ('_UDDEIM_NOMESSAGES_FILTERED_POSTBOX', ' postbox');
DEFINE ('_UDDEIM_NOMESSAGES_POSTBOX', 'You have no messages in your postbox.');
DEFINE ('_UDDEIM_DISPLAY', 'Display');
DEFINE ('_UDDEIM_HELP_POSTBOX', 'The <b>Postbox</b> holds all your incoming and outgoing messages.');
DEFINE ('_UDDEIM_HELP_PREAD', 'The message has been read (inbox=you can toggle the status).');
DEFINE ('_UDDEIM_HELP_PUNREAD', 'The message is still unread (inbox=you can toggle the status).');

// New: 2.7
DEFINE ('_UDDEADM_MOOTOOLS_NONEMEIO', 'do not load MooTools (use MEIO)');
DEFINE ('_UDDEADM_MOOTOOLS_13MEIO', 'force loading MooTools 1.3 (use MEIO)');

// New: 2.6
DEFINE ('_UDDEADM_DONTSEFMSGLINK_HEAD', 'No SEF for %msglink%');
DEFINE ('_UDDEADM_DONTSEFMSGLINK_EXP', 'Do not use SEF for %msglink% placeholder in email notifications.');
DEFINE ('_UDDEADM_STIME_HEAD', 'Use special calendars');
DEFINE ('_UDDEADM_STIME_EXP', 'When enabled on sites using the farsi language file the persian calendar is used.');
DEFINE ('_UDDEADM_RESTRICTREM_HEAD', 'Remove orphaned connections');
DEFINE ('_UDDEADM_RESTRICTREM_EXP', 'Automatically remove orphaned connections when saving an existing contact list.');
DEFINE ('_UDDEADM_RESTRICTCON_HEAD', 'Show connections only');
DEFINE ('_UDDEADM_RESTRICTCON_EXP', 'The users shown in the list can be restricted to CB/CBE/JS connections (hide users from userlist has no effect here when enabled).');
DEFINE ('_UDDEADM_RESTRICTCON0', 'disabled');
DEFINE ('_UDDEADM_RESTRICTCON1', 'registered users');
DEFINE ('_UDDEADM_RESTRICTCON2', 'registered, special users');
DEFINE ('_UDDEADM_RESTRICTCON3', 'all users (incl. admins)');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_10', '...set default for show connections');

// New: 2.4
DEFINE ('_UDDEIM_SECURITYCODE', 'Security Code:');

// New: 2.3
DEFINE ('_UDDEADM_CC_HEAD', 'Button "Show CC: line"');
DEFINE ('_UDDEADM_CC_EXP', 'When enabled a user can choose if uddeIM shall add a CC: line containing all recipients to a message or not.');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_9', '...set default for CC: line, and moderation');
DEFINE ('_UDDEIM_TOOLBAR_MCP', 'Message Center');
DEFINE ('_UDDEIM_TOOLBAR_REMOVEMESSAGE', 'Delete message');
DEFINE ('_UDDEIM_TOOLBAR_DELIVERMESSAGE', 'Deliver message');
DEFINE ('_UDDEADM_OOD_MCP', 'Message Center Plugin out of date!');
DEFINE ('_UDDEADM_MCP_STAT', 'Messages to moderate:');
DEFINE ('_UDDEADM_MCP_TRASHED', 'Trashed');
DEFINE ('_UDDEADM_MCP_NOTEDEL', 'Delete this message from database?');
DEFINE ('_UDDEADM_MCP_NOTEDELIVER', 'Deliver this message to recipient?');
DEFINE ('_UDDEADM_MCP_SHOWHIDE', 'Show/Hide');
DEFINE ('_UDDEADM_MCP_EDIT', 'Message Control Center');
DEFINE ('_UDDEADM_MCP_FROM', 'From');
DEFINE ('_UDDEADM_MCP_TO', 'To');
DEFINE ('_UDDEADM_MCP_TEXT', 'Message');
DEFINE ('_UDDEADM_MCP_DELETE', 'Delete');
DEFINE ('_UDDEADM_MCP_DATE', 'Date');
DEFINE ('_UDDEADM_MCP_DELIVER', 'Deliver');
DEFINE ('_UDDEADM_USERSET_MODERATE', 'Mod');
DEFINE ('_UDDEADM_USERSET_SELMODERATE', '- Mod -');
DEFINE ('_UDDEIM_MCP_MODERATED', 'Your messages will be moderated. A moderator will check them before they are delivered to the recipients.');
DEFINE ('_UDDEIM_STATUS_DELAYED', 'Waiting for moderator');
DEFINE ('_UDDEADM_MODNEWUSERS_HEAD', 'Moderate new users');
DEFINE ('_UDDEADM_MODNEWUSERS_EXP', 'When enabled messages from new registered users are moderated by default.');
DEFINE ('_UDDEADM_MODPUBUSERS_HEAD', 'Moderate public users');
DEFINE ('_UDDEADM_MODPUBUSERS_EXP', 'When enabled messages from public users users are moderated.');
DEFINE ('_UDDEIM_MENUICONS_P3', 'No menu');

// New: 2.2
DEFINE ('_UDDEADM_OOD_PF', 'Public Frontend Plugin out of date!');
DEFINE ('_UDDEADM_OOD_A', 'File Attachment Plugin out of date!');
DEFINE ('_UDDEADM_OOD_RSS', 'RSS Plugin out of date!');
DEFINE ('_UDDEADM_OOD_ASC', 'Message Report Center Plugin out of date!');
DEFINE ('_UDDEIM_NOMESSAGES3_FILTERED', '<b>You have no filtered messages in your%s.</b>');
DEFINE ('_UDDEIM_FILTER_UNREAD', 'unread');
DEFINE ('_UDDEIM_FILTER_FLAGGED', 'flagged');
DEFINE ('_UDDEADM_GRAVATAR_HEAD', 'gravatar enabled');
DEFINE ('_UDDEADM_GRAVATAR_EXP', 'Enables gravatar support.');
DEFINE ('_UDDEADM_GRAVATARD_HEAD', 'gravatar imageset');
DEFINE ('_UDDEADM_GRAVATARD_EXP', 'Select the imageset for default images.');
DEFINE ('_UDDEADM_GRAVATARR_HEAD', 'gravatar rating');
DEFINE ('_UDDEADM_GRAVATARR_EXP', 'By default, only "G" rated images are displayed unless you indicate higher ratings. "X" displays all gravatar images.');
DEFINE ('_UDDEADM_GR404', '404');
DEFINE ('_UDDEADM_GRMM', 'mm');
DEFINE ('_UDDEADM_GRIDENTICON', 'identicon');
DEFINE ('_UDDEADM_GRMONSTERID', 'monsterid');
DEFINE ('_UDDEADM_GRWAVATAR', 'wavatar');
DEFINE ('_UDDEADM_GRRETRO', 'retro');
DEFINE ('_UDDEADM_GRDEFAULT', 'default');
DEFINE ('_UDDEADM_GRG', 'G = General');
DEFINE ('_UDDEADM_GRPG', 'PG = Parental Guidance');
DEFINE ('_UDDEADM_GRR', 'R = Restricted');
DEFINE ('_UDDEADM_GRX', 'X = Adult only');
DEFINE ('_UDDEADM_NINJABOARD', 'Ninjaboard');
DEFINE ('_UDDEADM_KUNENA16', 'Kunena 1.6+');
DEFINE ('_UDDEIM_PROCESSING', 'Processing...');
DEFINE ('_UDDEIM_SEND_NONOTIFY', 'Do not send notification emails');
DEFINE ('_UDDEIM_SYSGM_NONOTIFY', 'Email notifications will not be sent');
DEFINE ('_UDDEIM_SYSGM_FORCEEMBEDDED', 'Text will be embedded in notification email');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_8', '...set default for thumbnails');
DEFINE ('_UDDEADM_AVATARWH_HEAD', 'Display size of thumbnails');
DEFINE ('_UDDEADM_AVATARWH_EXP', 'Width and height (in pixels) of thumbnails (0 = size will not be changed).');
DEFINE ('_UDDEIM_SAVE', 'Save');

// New: 2.1
DEFINE ('_UDDEIM_BODY_SPAMREPORT',
"Hei %you%,\n\n%touser% har rapportert en suspekt melding fra %fromuser%. Vennligst logg p� og sjekk den!\n\n%livesite%");
DEFINE ('_UDDEIM_SUBJECT_SPAMREPORT', 'En melding har blitt rapportert p� %site%');
DEFINE ('_UDDEADM_KBYTES', 'KByte');
DEFINE ('_UDDEADM_MBYTES', 'MByte');
DEFINE ('_UDDEIM_ATT_FILEDELETED', 'Filen har blitt slettet');
DEFINE ('_UDDEIM_ATT_FILENOTEXISTS', 'Feil: Filen eksisterer ikke');
DEFINE ('_UDDEIM_ATTACHMENTS2', 'Vedlegg (maks. %s pr fil):');
DEFINE ('_UDDEADM_JOOCM', 'Joo!CM');
DEFINE ('_UDDEADM_UNPROTECTATTACHMENT_HEAD', 'Ubeskyttet filnedlasting');
DEFINE ('_UDDEADM_UNPROTECTATTACHMENT_EXP', 'Vanligvis viser ikke uddeIM filvedleggets lokasjon p� serveren, s� ingen, selv n�r filnavnet er kjent, kan laste ned filen. Ved � aktivere dette valget vil uddeIM returnere eksakt lokasjon til filen. Av sikkerhetsmessige �rsaker legger uddeIM til en MD5 sjekksum til det originale filnavnet. Brukere kan laste ned filer direkte n�r eksakt lokasjon er kjent. V�r sv�rt forsiktig med � sl� p� dette! LES FAQ HVIS DU AKTIVERER VALGET!');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_7', '...sett standard for filvedlegg i offendlig del av nettstedet');
DEFINE ('_UDDEIM_FILETYPE_NOTALLOWED', 'Ikke tillatte filtyper');
DEFINE ('_UDDEADM_ALLOWEDEXTENSIONS_HEAD', 'Tillatte filtyper');
DEFINE ('_UDDEADM_ALLOWEDEXTENSIONS_EXP', 'Oppgi alle tillate filtype-endelser (adskilt med ";"). Oppgi blank for � tillate alle filtyper.');
DEFINE ('_UDDEADM_PUBEMAIL_HEAD', 'Epost p�krevd');
DEFINE ('_UDDEADM_PUBEMAIL_EXP', 'Hvis aktivert m� uregistrerte brukere oppgi epost-adresse.');
DEFINE ('_UDDEADM_WAITDAYS_HEAD', 'Dager � vente');
DEFINE ('_UDDEADM_WAITDAYS_EXP', 'Oppgi hvor mange dager en bruker m� vente f�r han f�r lov til � sende meldinger (for 3 timer, oppgi 0.125).');
DEFINE ('_UDDEIM_WAITDAYS1', 'Du m� vente ');
DEFINE ('_UDDEIM_WAITDAYS2', ' dager til du kan sende meldinger.');
DEFINE ('_UDDEIM_WAITDAYS2H', ' timer til du kan sende meldinger.');

// New: 2.0
DEFINE ('_UDDEADM_RECAPTCHAPRV_HEAD', 'reCaptcha privat n�kkel');
DEFINE ('_UDDEADM_RECAPTCHAPRV_EXP', 'Hvis du vil bruke reCaptcha, oppgi din private n�kkel her.');
DEFINE ('_UDDEADM_RECAPTCHAPUB_HEAD', 'reCaptcha offentlig n�kkel');
DEFINE ('_UDDEADM_RECAPTCHAPUB_EXP', 'Hvis du vil bruke reCaptcha, oppgi din offentlige n�kkel her.');
DEFINE ('_UDDEADM_CAPTCHA_INTERNAL', 'Innebygd');
DEFINE ('_UDDEADM_CAPTCHA_RECAPTCHA', 'reCaptcha');
DEFINE ('_UDDEADM_CAPTCHATYPE_HEAD', 'Captcha-tjeneste');
DEFINE ('_UDDEADM_CAPTCHATYPE_EXP', 'Hvilken captcha-tjeneste �nsker du � bruke: Den innebygde tjenesten eller reCaptcha (se <a href="http://recaptcha.net" target="_new">reCaptcha</a> for mere informasjon)?');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_6', '...sett standard for captcha-tjenesten');
DEFINE ('_UDDEADM_AUP', 'AlphaUserPoints');
DEFINE ('_UDDEADM_CHECKFILESFOLDER', 'Vennligst flytt <i>\uddeimfiles</i> til <i>\images\uddeimfiles</i>. Sjekk dokumentasjonen!');
DEFINE ('_UDDEADM_CRYPT4', 'Kraftig kryptering');
DEFINE ('_UDDEADM_ALLOWTOALL2_HEAD', 'Tillat sending av systemmeldinger');
DEFINE ('_UDDEADM_ALLOWTOALL2_EXP', 'uddeIM st�tter systemmeldinger. Disse sendes til alle brukerene i systemet ditt. Benytt dem med m�te.');
DEFINE ('_UDDEADM_ALLOWTOALL2_0', 'Deaktivert');
DEFINE ('_UDDEADM_ALLOWTOALL2_1', 'kun administratorer');
DEFINE ('_UDDEADM_ALLOWTOALL2_2', 'administratorer og innholdsadministratorer');

// New: 1.9
DEFINE ('_UDDEIM_FILEUPLOAD_FAILED', 'Filopplasting feilet');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_5', '...sett standard for vedlegg');
DEFINE ('_UDDEADM_ENABLEATTACHMENT_HEAD', 'Tillat vedlegg');
DEFINE ('_UDDEADM_ENABLEATTACHMENT_EXP', 'Dette tillater sending av vedlegg for registrerte brukere eller kun administratorer.');
DEFINE ('_UDDEADM_MAXSIZEATTACHMENT_HEAD', 'Maks. filst�rrelse');
DEFINE ('_UDDEADM_MAXSIZEATTACHMENT_EXP', 'Maksimal tillat filst�rrelse for vedlegg.');
DEFINE ('_UDDEIM_FILESIZE_EXCEEDED', 'Maksimal filst�rrelse overskredet');
DEFINE ('_UDDEADM_BYTES', 'Bytes');
DEFINE ('_UDDEADM_MAXATTACHMENTS_HEAD', 'Maks. vedlegg');
DEFINE ('_UDDEADM_MAXATTACHMENTS_EXP', 'Maksimalt antall vedlegg pr melding.');
DEFINE ('_UDDEIM_DOWNLOAD', 'Last ned');
DEFINE ('_UDDEADM_FILEADMINIGNITIONONLY_HEAD', 'Automatisk filsletting');
DEFINE ('_UDDEADM_FILEADMINIGNITIONONLY_YES', 'bare av administratorer');
DEFINE ('_UDDEADM_FILEADMINIGNITIONONLY_NO', 'av hvilken som helst bruker');
DEFINE ('_UDDEADM_FILEADMINIGNITIONONLY_MANUALLY', 'manuelt');
DEFINE ('_UDDEADM_FILEADMINIGNITIONONLY_EXP', 'Automatisk sletting gir stor belasting p� tjeneren. Hvis du velger <b>bare av administratorer</b> vil automatisk sletting starte n�r en administrator sjekker innboksen sin. Velg denne muligheten hvis en administrator sjekker innboksen regelmessig. Sm� nettsteder, eller som administreres sjeldent, kan velge <b>av hvilken som helst bruker</b>.');
DEFINE ('_UDDEADM_FILEMAINTENANCE_PRUNE', 'Rydd i lagrede filer n�');
DEFINE ('_UDDEADM_FILEMAINTENANCEDEL_HEAD', 'Kj�r filsletting');
DEFINE ('_UDDEADM_FILEMAINTENANCEDEL_EXP', 'Fjerner slettede filer fra databasen. Dette er det samme som \'Rydd i lagrede filer n�\' p� systemfliken.');
DEFINE ('_UDDEADM_FILEMAINTENANCEDEL_ERASE', 'SLETT');
DEFINE ('_UDDEIM_ATTACHMENTS', 'Vedlegg (maks. %u bytes pr fil):');
DEFINE ('_UDDEADM_MAINTENANCE_F1', 'Eierl�se vedlegg lagret i filsystemet: ');
DEFINE ('_UDDEADM_MAINTENANCE_F2', 'Sletter eierl�se filer');
DEFINE ('_UDDEADM_BACKUP_DONE', 'Sikkerhetskopiering av konfigurasjon utf�rt.');
DEFINE ('_UDDEADM_RESTORE_DONE', 'Gjenoppretting av konfigurasjon utf�rt.');
DEFINE ('_UDDEADM_PRUNE_DONE', 'Opprydding av meldinger utf�rt.');
DEFINE ('_UDDEADM_FILEPRUNE_DONE', 'Opprydding av vedlegg utf�rt.');
DEFINE ('_UDDEADM_FOLDERCREATE_ERROR', 'Feil ved opprettelse av katalog: ');
DEFINE ('_UDDEADM_ATTINSTALL_WRITEFAILED', 'Feil ved opprettelse av fil: ');
DEFINE ('_UDDEADM_ATTINSTALL_IGNORE', 'Du kan ignorere denne feilen hvis du ikke har kj�pt "File attachments premium plugin" (se FAQ).');
DEFINE ('_UDDEADM_ATTACHMENTGROUPS_HEAD', 'Tillatte grupper');
DEFINE ('_UDDEADM_ATTACHMENTGROUPS_EXP', 'Grupper som har tillatelse til � sende vedlegg.');
DEFINE ('_UDDEIM_SELECT', 'Velg');
DEFINE ('_UDDEIM_ATTACHMENT', 'Vedlegg');
DEFINE ('_UDDEADM_SHOWLISTATTACHMENT_HEAD', 'Vis vedleggikoner');
DEFINE ('_UDDEADM_SHOWLISTATTACHMENT_EXP', 'Vis vedleggikoner i meldingslister (innboks, utboks, arkiv).');
DEFINE ('_UDDEIM_HELP_ATTACHMENT', 'Meldingen inneholder et vedlegg.');
DEFINE ('_UDDEADM_MAINTENANCE_COUNTFILES', 'Filreferanser i databasen:');
DEFINE ('_UDDEADM_MAINTENANCE_COUNTFILESDISTINCT', 'Vedlegg lagret:');
DEFINE ('_UDDEADM_SHOWMENUCOUNT_HEAD', 'Vis tellere');
DEFINE ('_UDDEADM_SHOWMENUCOUNT_EXP', 'N�r det st�r <b>ja</b>, inneholder menylinjen meldingstellere. Merk: Dette vil kreve flere databases�k i tillegg, s� ikke bruk det p� svake systemer.');
DEFINE ('_UDDEADM_CONFIG_FTPLAYER', 'Konfigurasjon (tilgang via FTP-laget):');
DEFINE ('_UDDEADM_ENCODEHEADER_HEAD', 'MIME-kode epost-titler');
DEFINE ('_UDDEADM_ENCODEHEADER_EXP', 'Satt til <b>ja</b>, n�r epost-titler (som emne) skal v�re RFC2047-kodet. Nyttig n�r du har problemer med s�r-norske tegn.');
DEFINE ('_UDDEIM_UP', 'sorter stigende');
DEFINE ('_UDDEIM_DOWN', 'sorter synkende');
DEFINE ('_UDDEIM_UPDOWN', 'sorter');
DEFINE ('_UDDEADM_ENABLESORT_HEAD', 'Aktiver sortering');
DEFINE ('_UDDEADM_ENABLESORT_EXP', 'Satt til <b>ja</b>, n�r brukeren skal kunne sortere innboksen, utboksen og arkiv (skaper ekstra belastning p� databaseserveren).');

// New: 1.8
// %s will be replaced by _UDDEIM_NOMESSAGES_FILTERED_INBOX, _UDDEIM_NOMESSAGES_FILTERED_OUTBOX, _UDDEIM_NOMESSAGES_FILTERED_ARCHIVE
// Translators help: When having problems with the grammar, you can also move some text (e.g. "in your") to _UDDEIM_NOMESSAGES_FILTERED_* variables, e.g.
// instead of "_UDDEIM_NOMESSAGES_FILTERED_INBOX=inbox" you can also use "_UDDEIM_NOMESSAGES_FILTERED_INBOX=in your inbox"
DEFINE ('_UDDEIM_NOMESSAGES2_FR_FILTERED', '<b>Du har ingen meldinger fra denne brukeren i din %s.</b>');
DEFINE ('_UDDEIM_NOMESSAGES2_TO_FILTERED', '<b>Du har ingen meldinger til denne brukeren i din %s.</b>');
DEFINE ('_UDDEIM_NOMESSAGES2_UNFR_FILTERED', '<b>Du har ingen uleste meldinger fra denne brukeren i din %s.</b>');
DEFINE ('_UDDEIM_NOMESSAGES2_UNTO_FILTERED', '<b>Du har ingen uleste meldinger til denne brukeren i din %s.</b>');

// New: 1.7
DEFINE ('_UDDEADM_EMAILSTOPPED', '\'Ikke send e-post\' aktivert.');
DEFINE ('_UDDEIM_ACCOUNTLOCKED', 'Tilgang til din innboks er sperret. Vennligst kontakt side-administrator.');
DEFINE ('_UDDEADM_USERSET_LOCKED', 'Sperret');
DEFINE ('_UDDEADM_USERSET_SELLOCKED', '- Sperret -');
DEFINE ('_UDDEADM_CBBANNED_HEAD', 'Kontroller for brukere utestengt fra CB');
DEFINE ('_UDDEADM_CBBANNED_EXP', 'N�r aktivert sjekker uddeIM om brukeren er blitt utestengt i CB, og tillater da ikke tilgang til uddeIM. I tillegg kan ikke andre brukere sende meldinger til utestengt bruker.');
DEFINE ('_UDDEIM_YOUAREBANNED', 'Du er blitt utestengt. Vennligst kontakt administrator eller moderator.');
DEFINE ('_UDDEIM_USERBANNED', 'Brukeren er blitt utestengt');
DEFINE ('_UDDEADM_JOOBB', 'Joo!BB');
DEFINE ('_UDDEPLUGIN_SEARCHSECTION', 'Privat sending av meldinger');
DEFINE ('_UDDEPLUGIN_MESSAGES', 'Private meldinger');
DEFINE ('_UDDEADM_MAINTENANCEDEL_HEAD', 'Iverksett rydding av meldinger');
// note "This  is the same as _UDDEADM_MAINTENANCE_PRUNE on the system tab."
DEFINE ('_UDDEADM_MAINTENANCEDEL_EXP', 'Fjerner slettede meldinger fra databasen. Dette er det samme som \'T�m meldinger n�\' p� system-fanen.');
DEFINE ('_UDDEADM_MAINTENANCEDEL_ERASE', 'RYDD');
DEFINE ('_UDDEADM_REPORTSPAM_HEAD', 'Link til Rapporter melding');
DEFINE ('_UDDEADM_REPORTSPAM_EXP', 'N�r aktivert viser dette en \'Rapporter Melding\'-lenke som lar brukere rapportere s�ppelpost til admin.');
DEFINE ('_UDDEIM_TOOLBAR_REMOVESPAM', 'Slett melding');
DEFINE ('_UDDEIM_TOOLBAR_REMOVEREPORT', 'Fjern rapport');
DEFINE ('_UDDEIM_TOOLBAR_SPAMCONTROL', 'Rapportkontroll');
DEFINE ('_UDDEADM_INFORMATION', 'Informasjon');
DEFINE ('_UDDEADM_SPAMCONTROL_STAT', 'Rapporterte meldinger:');
DEFINE ('_UDDEADM_SPAMCONTROL_TRASHED', 'Slettet');
DEFINE ('_UDDEADM_SPAMCONTROL_NOTEDEL', 'Slette denne meldingen fra database?');
DEFINE ('_UDDEADM_SPAMCONTROL_NOTEREMOVE', 'Fjern denne rapporten?');
DEFINE ('_UDDEADM_SPAMCONTROL_SHOWHIDE', 'Vis/skjul');
DEFINE ('_UDDEADM_SPAMCONTROL_EDIT', 'RapporteringsKontrollSenter');
DEFINE ('_UDDEADM_SPAMCONTROL_FROM', 'Fra');
DEFINE ('_UDDEADM_SPAMCONTROL_TO', 'Til');
DEFINE ('_UDDEADM_SPAMCONTROL_TEXT', 'Melding');
DEFINE ('_UDDEADM_SPAMCONTROL_DELETE', 'Slett');
DEFINE ('_UDDEADM_SPAMCONTROL_REMOVE', 'Fjern');
DEFINE ('_UDDEADM_SPAMCONTROL_DATE', 'Dato');
DEFINE ('_UDDEADM_SPAMCONTROL_REPORTED', 'Rapportert');
DEFINE ('_UDDEIM_SPAMCONTROL_REPORT', 'Rapporter melding');
DEFINE ('_UDDEIM_SPAMCONTROL_MARKED', 'Meldingen har blitt rapportert');
DEFINE ('_UDDEIM_SPAMCONTROL_UNREPORT', 'Angre rapporteringen');
DEFINE ('_UDDEADM_JOMSOCIAL', 'JomSocial');
DEFINE ('_UDDEADM_KUNENA', 'Kunena');
DEFINE ('_UDDEADM_ADMIN_FILTER', 'Filter');
DEFINE ('_UDDEADM_ADMIN_DISPLAY', 'Vis #');
DEFINE ('_UDDEADM_TRASHORIGINALSENT_HEAD', 'Slett sendt melding');
DEFINE ('_UDDEADM_TRASHORIGINALSENT_EXP', 'N�r aktivert vil dette plassere en avkryssingsboks ved siden av \'Send\' svarknappen kalt \'slett melding\', som ikke er avkrysset som standard. Brukerene kan krysse av hvis de vil slette meldingen umiddelbart etter � ha sendt den.');
DEFINE ('_UDDEIM_TRASHORIGINALSENT', 'slett melding');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_4', '...sett standard for slett sendt melding, rapporter s�ppelpost, blokkerte CB-brukere');
DEFINE ('_UDDEADM_VERSIONCHECK_IMPORTANT', 'Viktige linker:');
DEFINE ('_UDDEADM_VERSIONCHECK_HOTFIX', 'Hotfix');
DEFINE ('_UDDEADM_VERSIONCHECK_NONE', 'Ingen');
DEFINE ('_UDDEADM_MAINTENANCEFIX_HEAD', "Kompatibilitetsopprydding");
DEFINE ('_UDDEADM_MAINTENANCEFIX_EXP', "uddeIM bruker to XML-filer for � sikre seg at pakkene kan installeres p� b�de Joomla 1.0 og 1.5. P� Joomla 1.5 vil den ene XML-filen ikke v�re n�dvendig, og f�r utvidelsesh�ndtereren til � vise en inkompabilitetsadvarsel (som er feil). Dette fjerner un�dvendige filer, slik at advarselen ikke lenger vises.");
DEFINE ('_UDDEADM_MAINTENANCE_FIX', "FIKS");
DEFINE ('_UDDEADM_MAINTENANCE_XML1', "Joomla 1.0 og Joomla 1.5 XML installasjonspakker for uddeIM finnes.<br />");
DEFINE ('_UDDEADM_MAINTENANCE_XML2', "Dette er n�dvendig p� grunn av installasjonspakker for Joomla 1.0 og Joomla 1.5.<br />");
DEFINE ('_UDDEADM_MAINTENANCE_XML3', "Siden den ikke er n�dvendig etter at installasjonen er ferdig, kan Joomla 1.0-installasjonsfilen fjernes p� Joomla 1.5-systemer.<br />");
DEFINE ('_UDDEADM_MAINTENANCE_XML4', "Dette vil bli gjort for f�lgende pakker:<br />");
DEFINE ('_UDDEADM_MAINTENANCE_FXML1', "Un�dvendige XML installasjonsfiler for f�lgende uddeIM-pakker vil bli fjernet:<br />");
DEFINE ('_UDDEADM_MAINTENANCE_FXML2', "Ingen un�dvendige XML installasjonsfiler for uddeIM-pakker funnet!<br />");
DEFINE ('_UDDEADM_SHOWMENUICONS1_HEAD', 'Utseende p� menyfeltet');
DEFINE ('_UDDEADM_SHOWMENUICONS1_EXP', 'Her kan du velge om menyfeltet skal vises med ikoner og/eller tekst.');
DEFINE ('_UDDEIM_MENUICONS_P1', 'Ikoner og tekst');
DEFINE ('_UDDEIM_MENUICONS_P2', 'Kun ikoner');
DEFINE ('_UDDEIM_MENUICONS_P0', 'Kun tekst');
DEFINE ('_UDDEIM_LISTSLIMIT_2', 'Maksimalt antall mottakere p� listen:');
DEFINE ('_UDDEADM_ADDEMAIL_ADMIN', 'Administratorer kan velge');
DEFINE ('_UDDEAIM_ADDEMAIL_SELECT', 'Gi beskjed via melding');
DEFINE ('_UDDEAIM_ADDEMAIL_TITLE', 'Inkludere hele beskjeden i e-postmelding.');

// New: 1.6
DEFINE ('_UDDEIM_NOLISTSELECTED', 'Ingen brukerliste valgt!');
DEFINE ('_UDDEADM_NOPREMIUM', 'Premium plugin ikke installert');
DEFINE ('_UDDEIM_LISTGLOBAL_CREATOR', 'Skaper:');
DEFINE ('_UDDEIM_LISTGLOBAL_ENTRIES', 'Oppf�ringer');
DEFINE ('_UDDEIM_LISTGLOBAL_TYPE', 'Type');
DEFINE ('_UDDEIM_LISTGLOBAL_NORMAL', 'Normal');
DEFINE ('_UDDEIM_LISTGLOBAL_GLOBAL', 'Global');
DEFINE ('_UDDEIM_LISTGLOBAL_RESTRICTED', 'Begrenset');
DEFINE ('_UDDEIM_LISTGLOBAL_P0', 'Normal kontaktliste');
DEFINE ('_UDDEIM_LISTGLOBAL_P1', 'Global kontaktliste');
DEFINE ('_UDDEIM_LISTGLOBAL_P2', 'Begrenset kontaktliste (Kun medlemmer av listen har tilgang)');
DEFINE ('_UDDEIM_TOOLBAR_USERSETTINGS', 'Brukerinnstillinger');
DEFINE ('_UDDEIM_TOOLBAR_REMOVESETTINGS', 'Fjern innstillinger');
DEFINE ('_UDDEIM_TOOLBAR_CREATESETTINGS', 'Opprett innstillinger');
DEFINE ('_UDDEIM_TOOLBAR_SAVE', 'Lagre');
DEFINE ('_UDDEIM_TOOLBAR_BACK', 'Tilbake');
DEFINE ('_UDDEIM_TOOLBAR_TRASHMSGS', 'S�ppelmeldinger');
DEFINE ('_UDDEIM_CBPLUG_CONT', '[fortsett]');
DEFINE ('_UDDEIM_CBPLUG_UNBLOCKNOW', '[ikke blokker]');
DEFINE ('_UDDEIM_CBPLUG_DOBLOCK', 'Blokker bruker');
DEFINE ('_UDDEIM_CBPLUG_DOUNBLOCK', 'Ikke blokker bruker');
DEFINE ('_UDDEIM_CBPLUG_BLOCKINGCFG', 'Blokkering');
DEFINE ('_UDDEIM_CBPLUG_BLOCKED', 'Du har blokkert denne brukeren.');
DEFINE ('_UDDEIM_CBPLUG_UNBLOCKED', 'Denne brukeren kan kontakte deg.');
DEFINE ('_UDDEIM_CBPLUG_NOWBLOCKED', 'Brukeren er n� blokkert.');
DEFINE ('_UDDEIM_CBPLUG_NOWUNBLOCKED', 'Brukeren er ikke lenger blokkert.');
DEFINE ('_UDDEADM_PARTIALIMPORTDONE', 'Delimport av meldinger fra gammel PMS gjennomf�rt. Ikke gjennomf�r denne importen en gang til, ellers blir meldingene importert p� nytt og vist dobbelt.');
DEFINE ('_UDDEADM_IMPORT_HELP', 'Merk: Meldinger kan importeres alle med en gang eller delvis. Delimport kan bli n�dvendig hvis importen ikke fungerte pga. at det var for mange meldinger som skulle importeres.');
DEFINE ('_UDDEADM_IMPORT_PARTIAL', 'Delimport:');
DEFINE ('_UDDEADM_UPDATEYOURDB', 'Viktig: Du har ikke oppdatert din database! V�r s� snill og se p� filen README hvordan du oppdaterer uddeIM riktig!');
DEFINE ('_UDDEADM_RESTRALLUSERS_HEAD', 'Begrens tilgang for "Alle brukere"');
DEFINE ('_UDDEADM_RESTRALLUSERS_EXP', 'Du kan begrense tilgangen til "Alle brukere"-listen. Vanligvis er "Alle brukere"-listen tilgjenglig for alle (<i>ingen begrensning</i>).');
DEFINE ('_UDDEADM_RESTRALLUSERS_0', 'ingen begrensning');
DEFINE ('_UDDEADM_RESTRALLUSERS_1', 'spesialbrukere');
DEFINE ('_UDDEADM_RESTRALLUSERS_2', 'kun administratorer');
DEFINE ('_UDDEIM_MESSAGE_UNARCHIVED', 'Melding fjernet fra arkiv.');
DEFINE ('_UDDEADM_AUTOFORWARD_SPECIAL', 'Spesialbrukere');
DEFINE ('_UDDEIM_HELP', 'Hjelp');
DEFINE ('_UDDEIM_HELP_HEADLINE1', 'uddeIM Hjelp');
DEFINE ('_UDDEIM_HELP_HEADLINE2', 'Kort oversikt over alle funksjoner');
DEFINE ('_UDDEIM_HELP_INBOX', '<b>Innboks</b> inneholder alle innkomne meldinger. Alle mottatte e-post finnes her.');
DEFINE ('_UDDEIM_HELP_OUTBOX', '<b>Utboks</b> lagrer en kopi av alle meldinger du sender. Du kan n�r som helst g� tilbake til utboksen og se hva du har sendt.');
DEFINE ('_UDDEIM_HELP_TRASHCAN', '<b>S�ppelb�tte</b> inneholder alle slettede meldinger. Meldinger slettes ikke umiddelbart men blir oppbevart en viss tid. S� lenge meldingen befinner seg i s�ppelb�tten kan den hentes frem igjen.');
DEFINE ('_UDDEIM_HELP_ARCHIVE', '<b>Arkiv</b> inneholder alle arkiverte meldinger fra innboksen. Kun meldinger fra innboksen kan arkiveres. N�r du �nsker � arkivere en melding du selv har skrevet m� du huske � velge <i>kopi til meg</i> ved sending.');
DEFINE ('_UDDEIM_HELP_USERLISTS', '<b>Kontakter</b> tillater vedlikehold av kontaktlister (ogs� kalt distribusjonslister). Listene tillater sending av PM til flere mottakere. I stedet for � legge til flere mottakere kan listenavn benyttes <i>#listenavn</i>.');
DEFINE ('_UDDEIM_HELP_SETTINGS', '<b>Innstillinger</b> omfatter alle konfigurerbare bruker-valg..');
DEFINE ('_UDDEIM_HELP_COMPOSE', '<b>Skriv ny</b> tillater opprettelse av ny privat melding.');
DEFINE ('_UDDEIM_HELP_IREAD', 'Meldingen har blitt lest (du kan endre status).');
DEFINE ('_UDDEIM_HELP_IUNREAD', 'Meldingen har ikke blitt lest (du kan endre status).');
DEFINE ('_UDDEIM_HELP_OREAD', 'Meldingen har blitt lest.');
DEFINE ('_UDDEIM_HELP_OUNREAD', 'Meldingen har ikke blitt lest. Uleste meldinger kan tilbakekalles.');
DEFINE ('_UDDEIM_HELP_TREAD', 'Meldingen har blitt lest.');
DEFINE ('_UDDEIM_HELP_TUNREAD', 'Meldingen har ikke blitt lest.');
DEFINE ('_UDDEIM_HELP_FLAGGED', 'Melding markert som viktig, f.eks. n�r det er en viktig melding (du kan endre status).');
DEFINE ('_UDDEIM_HELP_UNFLAGGED', '<i>Normal</i> melding (du kan endre status).');
DEFINE ('_UDDEIM_HELP_ONLINE', 'Brukeren er p�logget.');
DEFINE ('_UDDEIM_HELP_OFFLINE', 'Brukeren er ikke p�logget.');
DEFINE ('_UDDEIM_HELP_DELETE', 'Slett en melding (flytt meldingen til s�ppelb�tten).');
DEFINE ('_UDDEIM_HELP_FORWARD', 'Videresend melding til annen mottaker.');
DEFINE ('_UDDEIM_HELP_ARCHIVEMSG', 'Arkiver melding. Arkiverte meldinger vil ikke bli slettet automatisk n�r administrator har satt opp en tidsfrist for lagring av meldinger i innboksen.');
DEFINE ('_UDDEIM_HELP_UNARCHIVEMSG', 'Hent melding fra arkivet. Meldingen vil bli flyttet tilbake til innboksen.');
DEFINE ('_UDDEIM_HELP_RECALL', 'Tilbakekall en melding. Kun sendte meldinger som ikke har blitt lest av mottaker kan tilbakekalles.');
DEFINE ('_UDDEIM_HELP_RECYCLE', 'Resirkuler en melding (flytt melding fra s�ppelb�tte til innboks eller utboks).');
DEFINE ('_UDDEIM_HELP_NOTIFY', 'Konfigurering av e-postvarsling for mottak av ny melding.');
DEFINE ('_UDDEIM_HELP_AUTORESPONDER', 'N�r automatisk svar er aktivert vil hver enkelt mottatt melding bli besvart umiddelbart.');
DEFINE ('_UDDEIM_HELP_AUTOFORWARD', 'Nye meldinger kan sendes videre til annen bruker automatisk.');
DEFINE ('_UDDEIM_HELP_BLOCKING', 'Du kan blokkere brukere. Disse brukerne kan ikke sende deg private meldinger.');
DEFINE ('_UDDEIM_HELP_MISC', 'Her finner du flere konfigurasjonsalternativer');
DEFINE ('_UDDEIM_HELP_FEED', 'Du kan f� tilgang til din innboks ved bruk av RSS feed.');
DEFINE ('_UDDEADM_SEPARATOR_HEAD', 'Separator');
DEFINE ('_UDDEADM_SEPARATOR_EXP', 'Velg separator til mottakere (standard er ",").');
DEFINE ('_UDDEADM_SEPARATOR_P0', 'komma (standard)');
DEFINE ('_UDDEADM_SEPARATOR_P1', 'semikolon');
DEFINE ('_UDDEADM_RSSLIMIT_HEAD', 'RSS meldinger');
DEFINE ('_UDDEADM_RSSLIMIT_EXP', 'Begrens antall returnerte RSS meldinger (0 for ingen grense).');
DEFINE ('_UDDEADM_SHOWHELP_HEAD', 'Vis knapp for hjelp');
DEFINE ('_UDDEADM_SHOWHELP_EXP', 'Hvis aktivert vises en knapp for hjelp.');
DEFINE ('_UDDEADM_SHOWIGOOGLE_HEAD', 'Vis knapp for iGoogle gadget');
DEFINE ('_UDDEADM_SHOWIGOOGLE_EXP', 'N�r aktivert vil en <i>Legg til i iGoogle</i>-knapp for uddeIM iGoogle gadget vises i brukerinnstillingene.');
DEFINE ('_UDDEADM_MOOTOOLS_NONE11', 'ikke last MooTools (1.1 blir brukt)');
DEFINE ('_UDDEADM_MOOTOOLS_NONE12', 'ikke last MooTools (1.2 blir brukt)');
DEFINE ('_UDDEIM_RSS_INTRO1', 'Du kan aksessere innboksen din via RSS (0.91).');
DEFINE ('_UDDEIM_RSS_INTRO1B', 'Tilgangslinken er:');
DEFINE ('_UDDEIM_RSS_INTRO2', 'Ikke gi denne linken til andre brukere, siden den gir tilgang til din innboks.');
DEFINE ('_UDDEIM_RSS_FEED', 'RSS Meldingsstr�m');
DEFINE ('_UDDEIM_RSS_NOOBJECT', 'Feil, ingen objekter...');
DEFINE ('_UDDEIM_RSS_USERBLOCKED', 'Bruker er blokkert...');
DEFINE ('_UDDEIM_RSS_NOTALLOWED', 'Ingen tilgang...');
DEFINE ('_UDDEIM_RSS_WRONGPASSWORD', 'Feil brukernavn eller passord...');
DEFINE ('_UDDEIM_RSS_NOMESSAGES', 'Ingen meldinger');
DEFINE ('_UDDEIM_RSS_NONEWMESSAGES', 'Ingen nye meldinger');
DEFINE ('_UDDEADM_ENABLERSS_HEAD', 'Aktiver RSS');
DEFINE ('_UDDEADM_ENABLERSS_EXP', 'Hvis aktivert, vil meldinger kunne lastes ned ved hjelp av RSS. Brukerene vil finne den n�dvendige linken i profilen sin.');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_3', '...sett som standard for RSS, iGoogle, hjelp, separator');
DEFINE ('_UDDEADM_DELETEM_DELETING', 'Sletter meldinger:');
DEFINE ('_UDDEADM_DELETEM_FROMUSER', 'Sletter meldinger fra bruker ');
DEFINE ('_UDDEADM_DELETEM_MSGSSENT', '- meldinger sendt: ');
DEFINE ('_UDDEADM_DELETEM_MSGSRECV', '- meldinger mottatt: ');
DEFINE ('_UDDEIM_PMNAV_THISISARESPONSE', 'Dette er et svar til:');
DEFINE ('_UDDEIM_PMNAV_THEREARERESPONSES', 'Svar til dette:');
DEFINE ('_UDDEIM_PMNAV_DELETED', 'Melding er ikke tilgjengelig');
DEFINE ('_UDDEIM_PMNAV_EXISTS', 'hopp til melding');
DEFINE ('_UDDEIM_PMNAV_COPY2ME', '(Kopi)');
DEFINE ('_UDDEADM_PMNAV_HEAD', 'Tillat navigering');
DEFINE ('_UDDEADM_PMNAV_EXP', 'Viser et navigeringsfelt som tillater navigering gjennom en meldingstr�d.');
DEFINE ('_UDDEADM_MAINTENANCE_ALLDAYS', 'Meldinger:');
DEFINE ('_UDDEADM_MAINTENANCE_7DAYS', 'Meldinger siste 7 dager:');
DEFINE ('_UDDEADM_MAINTENANCE_30DAYS', 'Meldinger siste 30 dager:');
DEFINE ('_UDDEADM_MAINTENANCE_365DAYS', 'Meldinger siste 365 dager:');
DEFINE ('_UDDEADM_MAINTENANCE_HEAD1', 'Sender p�minnelse til (Glem meg ikke: %s dager):');
DEFINE ('_UDDEADM_MAINTENANCE_HEAD2', 'In %s days sending reminders to:');
DEFINE ('_UDDEADM_MAINTENANCE_NO', 'Nei:');
DEFINE ('_UDDEADM_MAINTENANCE_USERID', 'BrukerID:');
DEFINE ('_UDDEADM_MAINTENANCE_TONAME', 'Navn:');
DEFINE ('_UDDEADM_MAINTENANCE_MID', 'MeldingsID:');
DEFINE ('_UDDEADM_MAINTENANCE_WRITTEN', 'Skrevet:');
DEFINE ('_UDDEADM_MAINTENANCE_TIMER', 'Tid:');

// New: 1.5
DEFINE ('_UDDEMODULE_ALLDAYS', ' meldinger');
DEFINE ('_UDDEMODULE_7DAYS', ' meldinger siste 7 dager');
DEFINE ('_UDDEMODULE_30DAYS', ' meldinger siste 30 dager');
DEFINE ('_UDDEMODULE_365DAYS', ' meldinger siste 365 dager');
DEFINE ('_UDDEADM_EMN_SENDERMAIL_WARNING', '<br /><b>Merk:<br />N�r du bruker mosmail, m� du konfigurere en gyldig e-post adresse!</b>');
DEFINE ('_UDDEIM_FILTEREDMESSAGE', 'melding filtrert');
DEFINE ('_UDDEIM_FILTEREDMESSAGES', 'meldinger filtrert');
DEFINE ('_UDDEIM_FILTER', 'Filter:');
DEFINE ('_UDDEIM_FILTER_TITLE_INBOX', 'Vise fra bare denne bruker');
DEFINE ('_UDDEIM_FILTER_TITLE_OUTBOX', 'Vise til bare denne bruker');
DEFINE ('_UDDEIM_FILTER_UNREAD_ONLY', 'bare uleste');
DEFINE ('_UDDEIM_FILTER_SUBMIT', 'Filter');
DEFINE ('_UDDEIM_FILTER_ALL', '- alle -');
DEFINE ('_UDDEIM_FILTER_PUBLIC', '- vis bare brukere -');
DEFINE ('_UDDEADM_FILTER_HEAD', 'Sl� p� filter');
DEFINE ('_UDDEADM_FILTER_EXP', 'Brukere kan velge � filtrere frem meldinger fra bestemte brukere.');
DEFINE ('_UDDEADM_FILTER_P0', 'sl�tt av');
DEFINE ('_UDDEADM_FILTER_P1', 'over meldingsliste');
DEFINE ('_UDDEADM_FILTER_P2', 'under meldingsliste');
DEFINE ('_UDDEADM_FILTER_P3', 'over og under listen');
DEFINE ('_UDDEIM_NOMESSAGES_FILTERED', '<b>Du har ingen %s meldinger %s i din %s.</b>');	// see next also six lines
DEFINE ('_UDDEIM_NOMESSAGES_FILTERED_UNREAD', ' ulest');
DEFINE ('_UDDEIM_NOMESSAGES_FILTERED_FROM', ' fra denne brukeren');
DEFINE ('_UDDEIM_NOMESSAGES_FILTERED_TO', ' til denne brukeren');
DEFINE ('_UDDEIM_NOMESSAGES_FILTERED_INBOX', ' innboks');
DEFINE ('_UDDEIM_NOMESSAGES_FILTERED_OUTBOX', ' utboks');
DEFINE ('_UDDEIM_NOMESSAGES_FILTERED_ARCHIVE', ' arkiv');
DEFINE ('_UDDEIM_TODP_TITLE', 'Mottaker');
DEFINE ('_UDDEIM_TODP_TITLE_CC', 'En eller flere mottakere (del med komma)');
DEFINE ('_UDDEIM_ADDCCINFO_TITLE', 'N�r huket vil en linje med alle mottakere legges til meldingen.');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_2', '...sette standard for autosvar, autovideresending, inputbox, filter');
DEFINE ('_UDDEADM_AUTORESPONDER_HEAD', 'Sl� p� autosvar');
DEFINE ('_UDDEADM_AUTORESPONDER_EXP', 'N�r autosvar er sl�tt p� kan brukeren sette en forvalgt svarmelding i personlige brukerinnstillinger.');
DEFINE ('_UDDEIM_EMN_AUTORESPONDER', 'Sl� p� autosvar');
DEFINE ('_UDDEIM_AUTORESPONDER', 'Autosvar');
DEFINE ('_UDDEIM_AUTORESPONDER_EXP', 'N�r autosvar er sl�tt p� blir mottatte meldinger besvart umiddelbart.');
DEFINE ('_UDDEIM_AUTORESPONDER_DEFAULT', "Beklager, jeg er for �yeblikket ikke tilgjengelig.\nJeg g�r gjennom min innboks s� snart som mulig.");
DEFINE ('_UDDEADM_USERSET_AUTOR', 'AutoSvar');
DEFINE ('_UDDEADM_USERSET_SELAUTOR', '- AutoSvar -');
DEFINE ('_UDDEIM_USERBLOCKED', 'Bruker er blokkert.');
DEFINE ('_UDDEADM_AUTOFORWARD_HEAD', 'Sl� p� autovideresending');
DEFINE ('_UDDEADM_AUTOFORWARD_EXP', 'N�r autovideresending er p� kan brukeren videresende meldinger til en annen bruker automagisk.');
DEFINE ('_UDDEIM_EMN_AUTOFORWARD', 'Sl� p� autovideresending');
DEFINE ('_UDDEADM_USERSET_AUTOF', 'AutoVideresend');
DEFINE ('_UDDEADM_USERSET_SELAUTOF', '- AutoVideresend -');
DEFINE ('_UDDEIM_AUTOFORWARD', 'Autovideresending');
DEFINE ('_UDDEIM_AUTOFORWARD_EXP', 'Nye meldinger kan videresendes til en annen bruker umiddelbart.');
DEFINE ('_UDDEIM_THISISAFORWARD', 'Autovidesendt melding opprinnelig sendt til ');
DEFINE ('_UDDEADM_COLSROWS_HEAD', 'Meldingsboks (kol/rad)');
DEFINE ('_UDDEADM_COLSROWS_EXP', 'Denne spesifiserer kolonner og rader for meldingsboksen (standard verdier er 60/10).');
DEFINE ('_UDDEADM_WIDTH_HEAD', 'Meldingsboks (bredde)');
DEFINE ('_UDDEADM_WIDTH_EXP', 'Spesifiserer bredden p� meldingsboksen i piksler (standard er 0). Er verdien 0, bli bredden i CSS stilen brukt.');
DEFINE ('_UDDEADM_CBE', 'CB Utvidet');

// New: 1.4
DEFINE ('_UDDEADM_IMPORT_CAPS', 'IMPORTER');

// New: 1.3
DEFINE ('_UDDEADM_MOOTOOLS_HEAD', 'Laste MooTools');
DEFINE ('_UDDEADM_MOOTOOLS_EXP', 'Denne sier hvordan uddeIM laster MooTools (MooTools er p�krevd for autofullf�r): <i>Ingen</i> kan brukes om malen laster det, <i>Auto</i> er anbefalt standard (samme som i uddeIM 1.2), n�r man bruker J1.0 kan du ogs� tvinge lasting av MooTools 1.1 eller 1.2.');
DEFINE ('_UDDEADM_MOOTOOLS_NONE', 'ikke last MooTools');
DEFINE ('_UDDEADM_MOOTOOLS_AUTO', 'auto');
DEFINE ('_UDDEADM_MOOTOOLS_1', 'tving lasting av MooTools 1.1');
DEFINE ('_UDDEADM_MOOTOOLS_2', 'tving lasting av MooTools 1.2');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_1', '...standard innstilling for MooTools');
DEFINE ('_UDDEADM_AGORA', 'Agora');

// New: 1.2
DEFINE ('_UDDEADM_CRYPT3', 'Base64 encoded');
DEFINE ('_UDDEADM_TIMEZONE_HEAD', 'Endre tidssone');
DEFINE ('_UDDEADM_TIMEZONE_EXP', 'Hvis uddeIM viser feil tid kan du justere tidssone her. Er alt satt opp riktig skal dette kunne v�re 0. Det kan likevel v�re �rsaker til � justere.');
DEFINE ('_UDDEADM_HOURS', 'timer');
DEFINE ('_UDDEADM_VERSIONCHECK', 'Versjon informasjon:');
DEFINE ('_UDDEADM_STATISTICS', 'Statistikk:');
DEFINE ('_UDDEADM_STATISTICS_HEAD', 'Vis statistikk');
DEFINE ('_UDDEADM_STATISTICS_EXP', 'Dette viser noe statistikk (som antall lagrede meldinger, etc.)');
DEFINE ('_UDDEADM_STATISTICS_CHECK', 'VIS STATISTIKK');
DEFINE ('_UDDEADM_MAINTENANCE_COUNT', 'Meldinger lagret i databasen: ');
DEFINE ('_UDDEADM_MAINTENANCE_COUNT_RECIPIENT', 'Meldinger slettet pr mottaker: ');
DEFINE ('_UDDEADM_MAINTENANCE_COUNT_SENDER', 'Meldinger slettet pr sender: ');
DEFINE ('_UDDEADM_MAINTENANCE_COUNT_TRASH', 'Meldinger i s�ppelet: ');
DEFINE ('_UDDEADM_OVERWRITEITEMID_HEAD', 'Overskrive ID');
DEFINE ('_UDDEADM_OVERWRITEITEMID_EXP', 'Vanligvis pr�ver uddeIM � finne riktig ID n�r den ikke er satt. I noen tilfeller kan det v�re behov for � overskrive denne verdien, f.eks. n�r du bruker flere meny-linker til uddeIM.');
DEFINE ('_UDDEADM_OVERWRITEITEMID_CURRENT', 'Oppdaget ID er: ');
DEFINE ('_UDDEADM_USEITEMID_HEAD', 'Bruk ID');
DEFINE ('_UDDEADM_USEITEMID_EXP', 'Bruk denne ID istedet for den som ble oppdaget.');
DEFINE ('_UDDEADM_SHOWLINK_HEAD', 'Bruke profil linker');
DEFINE ('_UDDEADM_SHOWLINK_EXP', 'N�r satt til <i>ja</i>, vil alle brukernavn i uddeIM bli vist som linker til brukerprofiler.');
DEFINE ('_UDDEADM_SHOWPIC_HEAD', 'Vis miniatyrbilder');
DEFINE ('_UDDEADM_SHOWPIC_EXP', 'N�r satt til <i>ja</i>, vil miniatyrbilde til avsender vises n�r man leser en melding.');
DEFINE ('_UDDEADM_THUMBLISTS_HEAD', 'Vise miniatyrbilder i lister');
DEFINE ('_UDDEADM_THUMBLISTS_EXP', 'Sett til <i>ja</i> hvis du vil vise brukeres minatyrbilder i meldingslisteoversikt (innboks, utboks, etc.)');
DEFINE ('_UDDEADM_FIREBOARD', 'Fireboard');
DEFINE ('_UDDEADM_CB', 'Community Builder');
DEFINE ('_UDDEADM_DISABLED', 'Sl�tt av');
DEFINE ('_UDDEADM_ENABLED', 'Sl�tt p�');
DEFINE ('_UDDEIM_STATUS_FLAGGED', 'Viktig');
DEFINE ('_UDDEIM_STATUS_UNFLAGGED', '');
DEFINE ('_UDDEADM_ALLOWFLAGGED_HEAD', 'Tillat meldingstagging');
DEFINE ('_UDDEADM_ALLOWFLAGGED_EXP', 'Tillater meldingstagging (uddeIM viser en stjene i lister, som kan brukes til � skille ut viktige meldinger).');
DEFINE ('_UDDEADM_REVIEWUPDATE', 'Viktig: n�r du har oppdatert uddeIM fra en tidligere versjon, les README. Noen ganger m� du legge til eller endre databasetabeller og -felt!');
DEFINE ('_UDDEIM_ADDCCINFO', 'Legg til CC: linje');
DEFINE ('_UDDEIM_CC', 'CC:');
DEFINE ('_UDDEADM_TRUNCATE_HEAD', 'Korte ned sitattekst');
DEFINE ('_UDDEADM_TRUNCATE_EXP', 'Korte ned sitattekst til 2/3 av maksimum tekst lengde, hvis den er st�rre en grensen.');
DEFINE ('_UDDEIM_PLUG_INBOXENTRIES', 'Innboksmeldinger ');
DEFINE ('_UDDEIM_PLUG_LAST', 'Siste ');
DEFINE ('_UDDEIM_PLUG_ENTRIES', ' meldinger');
DEFINE ('_UDDEIM_PLUG_STATUS', 'Status');
DEFINE ('_UDDEIM_PLUG_SENDER', 'Avsender');
DEFINE ('_UDDEIM_PLUG_MESSAGE', 'Melding');
DEFINE ('_UDDEIM_PLUG_EMPTYINBOX', 'Tom innboks');

// New: 1.1
DEFINE ('_UDDEADM_NOTRASHACCESS_NOT', 'Tilgang til papirkurven er ikke tillatt.');
DEFINE ('_UDDEADM_NOTRASHACCESS_HEAD', 'Begrens tilgangen til papirkurven');
DEFINE ('_UDDEADM_NOTRASHACCESS_EXP', 'Du kan begrense tilgangen til papirkurven. Vanligvis er papirkurven tilgjengelig for alle (<i>ingen begrensing</i>). Du kan begrense tilgangen til spesielle brukere eller bare til administratorer, grupper med lavere tilgangsrettigheter kan ikke flytte en melding til papirkurven.');
DEFINE ('_UDDEADM_NOTRASHACCESS_0', 'ingen begrensinger');
DEFINE ('_UDDEADM_NOTRASHACCESS_1', 'spesielle brukere');
DEFINE ('_UDDEADM_NOTRASHACCESS_2', 'bare administratorer');
DEFINE ('_UDDEADM_PUBHIDEUSERS_HEAD', 'Skjul brukere i brukerliste');
DEFINE ('_UDDEADM_PUBHIDEUSERS_EXP', 'Skriv id til bruker som skal skjules i offentlig brukerliste (f.eks. 65,66,67).');
DEFINE ('_UDDEADM_HIDEUSERS_HEAD', 'Skjul brukere i brukerliste');
DEFINE ('_UDDEADM_HIDEUSERS_EXP', 'Skriv id til bruker som skal skjules i brukerlisten (f.eks. 65,66,67).');
DEFINE ('_UDDEIM_ERRORCSRF', 'CSRF (Cross-Site Request Forgery) angrep er gjenkjent');
DEFINE ('_UDDEADM_CSRFPROTECTION_HEAD', 'CSRF (Cross-Site Request Forgery) beskyttelse');
DEFINE ('_UDDEADM_CSRFPROTECTION_EXP', 'Dette beskytter alle former for Cross-Site Request Forgery angrep. Dette b�r v�re sl�tt p�. Hvis du opplever rare problemer, sl� den av.');
DEFINE ('_UDDEIM_CANTREPLYARCHIVE', 'Du kan ikke svare p� arkiverte meldinger.');
DEFINE ('_UDDEIM_COULDNOTRECALLPUBLIC', 'Svar til uregistrerte brukere kan ikke tilbakekalles.');
DEFINE ('_UDDEADM_PUBREPLYS_HEAD', 'Tillat svar');
DEFINE ('_UDDEADM_PUBREPLYS_EXP', 'Tillat direkte svar p� meldinger fra uregistrerte brukere.');
DEFINE ('_UDDEADM_PUBNAMESTEXT', 'Vis virkelig navn');
DEFINE ('_UDDEADM_PUBNAMESDESC', 'Vis virkelig navn eller brukernavn p� offentlig del av nettsted?');
DEFINE ('_UDDEIM_USERLIST', 'Brukerliste');
DEFINE ('_UDDEIM_YOUHAVETOWAIT', 'Beklager, du m� vente f�r du kan sende en ny melding');
DEFINE ('_UDDEADM_USERSET_LASTSENT', 'Sist sendt');
DEFINE ('_UDDEADM_TIMEDELAY_HEAD', 'Tidsforsinkelse');
DEFINE ('_UDDEADM_TIMEDELAY_EXP', 'Tid i sekunder en bruker m� vente f�r brukeren kan sende neste melding (0 for ingen tidsforsinkelse).');
DEFINE ('_UDDEADM_SECONDS', 'sekunder');
DEFINE ('_UDDEIM_PUBLICSENT', 'Melding sendt.');
DEFINE ('_UDDEIM_ERRORINFROMNAME', 'Feil i senders navn');
DEFINE ('_UDDEIM_ERRORINEMAIL', 'Feil i E-postadresse');
DEFINE ('_UDDEIM_YOURNAME', 'Ditt navn:');
DEFINE ('_UDDEIM_YOUREMAIL', 'Din E-postadresse:');
DEFINE ('_UDDEADM_VERSIONCHECK_USING', 'Du bruker uddeIM ');
DEFINE ('_UDDEADM_VERSIONCHECK_LATEST', 'Du bruker allerede siste versjon av uddeIM.');
DEFINE ('_UDDEADM_VERSIONCHECK_CURRENT', 'Den gjeldende versjon er ');
DEFINE ('_UDDEADM_VERSIONCHECK_INFO', 'Oppdater informasjonen:');
DEFINE ('_UDDEADM_VERSIONCHECK_HEAD', 'Sjekk om det finnes oppdateringer');
DEFINE ('_UDDEADM_VERSIONCHECK_EXP', 'Dette kontakter uddeIMs utviklernettsted for � motta informasjon om siste uddeIM-versjon.');
DEFINE ('_UDDEADM_VERSIONCHECK_CHECK', 'SJEKK N�');
DEFINE ('_UDDEADM_VERSIONCHECK_ERROR', 'Kan ikke motta versjonsinformasjon.');
DEFINE ('_UDDEIM_NOSUCHLIST', 'Kontaktliste ble ikke funnet!');
DEFINE ('_UDDEIM_LISTSLIMIT_1', 'Du har overskredet maks. antall mottagere (maks. ');
DEFINE ('_UDDEADM_MAXONLISTS_HEAD', 'Maks. antall oppf�ringer');
DEFINE ('_UDDEADM_MAXONLISTS_EXP', 'Maks. antall oppf�ringer pr. kontaktliste.');
DEFINE ('_UDDEIM_LISTSNOTENABLED', 'Kontaktliste er ikke aktivert');
DEFINE ('_UDDEADM_ENABLELISTS_HEAD', 'Aktiver kontaktlister');
DEFINE ('_UDDEADM_ENABLELISTS_EXP', 'uddeIM gir brukere mulighet til � lage kontaktlister. Disse listene kan brukes til � sende beskjeder til flere brukere. Ikke glem � aktivere flere mottakere n�r du vil bruke kontaktlister.');
DEFINE ('_UDDEADM_ENABLELISTS_0', 'ikke aktivert');
DEFINE ('_UDDEADM_ENABLELISTS_1', 'registrerte brukere');
DEFINE ('_UDDEADM_ENABLELISTS_2', 'spesialbrukere');
DEFINE ('_UDDEADM_ENABLELISTS_3', 'bare administratorer');
DEFINE ('_UDDEIM_LISTSNEW', 'Lag en ny kontaktliste');
DEFINE ('_UDDEIM_LISTSSAVED', 'Kontaktliste er lagret');
DEFINE ('_UDDEIM_LISTSUPDATED', 'Kontaktliste oppdatert');
DEFINE ('_UDDEIM_LISTSDESC', 'Beskrivelse');
DEFINE ('_UDDEIM_LISTSNAME', 'Navn');
DEFINE ('_UDDEIM_LISTSNAMEWO', 'Navn (uten mellomrom)');
DEFINE ('_UDDEIM_EDITLINK', 'rediger');
DEFINE ('_UDDEIM_LISTS', 'Kontakter');
DEFINE ('_UDDEIM_STATUS_READ', 'lest');
DEFINE ('_UDDEIM_STATUS_UNREAD', 'ikke lest');
DEFINE ('_UDDEIM_STATUS_ONLINE', 'tilkoblet');
DEFINE ('_UDDEIM_STATUS_OFFLINE', 'frakoblet');
DEFINE ('_UDDEADM_CBGALLERY_HEAD', 'Vis CB galleribilder');
DEFINE ('_UDDEADM_CBGALLERY_EXP', 'UddeIM er forh�ndsinnstilt til � bare vise profilbilder som brukere har lastet opp. N�r du aktiverer denne innstillingen vil uddeIM vise bilder fra CB profilbildegalleriet.');
DEFINE ('_UDDEADM_UNBLOCKCB_HEAD', 'Sl� av CB forbindelse');
DEFINE ('_UDDEADM_UNBLOCKCB_EXP', 'Du kan tillate beskjeder til mottakere n�r den registrerte brukeren er p� mottakerlisten i CB (selv n�r mottakeren er i en gruppe som er blokkert). Denne innstillingen er uavhengig av den personlige sperringen hver bruker kan konfigurere n�r dette er sl�tt p� (se innstillinger ovenfor).');
DEFINE ('_UDDEIM_GROUPBLOCKED', 'Du har ikke tillatelse til � sende til denne gruppen.');
DEFINE ('_UDDEIM_ONEUSERBLOCKS', 'Mottakeren har blokkert deg.');
DEFINE ('_UDDEADM_BLOCKGROUPS_HEAD', 'Blokkerte grupper (registrerte brukere)');
DEFINE ('_UDDEADM_BLOCKGROUPS_EXP', 'Grupper som registrerte brukere ikke har tillatelse � sende beskjeder til. Dette gjelder bare registrerte brukere. Denne innstillingen gjelder ikke spesialbrukere og adminstratorer. Denne innstillingen er uavhengig av den personlige sperringen hver bruker kan konfigurere n�r dette er sl�tt p� (se innstillinger ovenfor).');
DEFINE ('_UDDEADM_PUBBLOCKGROUPS_HEAD', 'Blokkerte grupper (offentlige brukere)');
DEFINE ('_UDDEADM_PUBBLOCKGROUPS_EXP', 'Grupper som offentlige brukere ikke har tillatelse � sende beskjeder til. Denne innstillingen er uavhengig av den personlige sperringen hver bruker kan konfigurere n�r dette er sl�tt p� (se innstillinger ovenfor). N�r du blokkerer en gruppe, kan ikke brukere i denne gruppen se valget "sl� p�" offentlig i profilen deres.');
DEFINE ('_UDDEADM_BLOCKGROUPS_1', 'Offentlig bruker');
DEFINE ('_UDDEADM_BLOCKGROUPS_2', 'CB forbindelse');
DEFINE ('_UDDEADM_BLOCKGROUPS_18', 'Registrert bruker');
DEFINE ('_UDDEADM_BLOCKGROUPS_19', 'Skribent');
DEFINE ('_UDDEADM_BLOCKGROUPS_20', 'Skribent (kan redigere)');
DEFINE ('_UDDEADM_BLOCKGROUPS_21', 'Skribent (kan publisere)');
DEFINE ('_UDDEADM_BLOCKGROUPS_23', 'Innholdsadministrator');
DEFINE ('_UDDEADM_BLOCKGROUPS_24', 'Systemadministrator');
DEFINE ('_UDDEADM_BLOCKGROUPS_25', 'Superadministrator');
DEFINE ('_UDDEIM_NOPUBLICMSG', 'Brukere mottar bare beskjeder fra registrerte brukere.');
DEFINE ('_UDDEADM_PUBHIDEALLUSERS_HEAD', 'Skjul offentlig "Alle brukere" listen');
DEFINE ('_UDDEADM_PUBHIDEALLUSERS_EXP', 'Du kan skjule grupper fra � bli listet i den offentlige "Alle brukere" liste. Merk: dette skjuler bare navnene, brukere kan fortsatt motta beskjeder. Brukere som ikke har sl�tt p� offentlig visning vil ikke bli listet i denne listen.');
DEFINE ('_UDDEADM_HIDEALLUSERS_HEAD', 'Skjul fra "Alle brukere" liste');
DEFINE ('_UDDEADM_HIDEALLUSERS_EXP', 'Du kan skjule enkelte grupper fra � bli listet i "Alle brukere" liste. Merk: dette skjuler bare navnene, brukere kan fortsatt motta beskjeder.');
DEFINE ('_UDDEADM_HIDEALLUSERS_0', 'ingen');
DEFINE ('_UDDEADM_HIDEALLUSERS_1', 'bare superadministratorer');
DEFINE ('_UDDEADM_HIDEALLUSERS_2', 'bare systemadministrator');
DEFINE ('_UDDEADM_HIDEALLUSERS_3', 'spesialbrukere');
DEFINE ('_UDDEADM_PUBLIC', 'Offentlig');
DEFINE ('_UDDEADM_PUBMODESHOWALLUSERS_HEAD', 'Oppf�rsel til "Alle brukere" linken');
DEFINE ('_UDDEADM_PUBMODESHOWALLUSERS_EXP', 'Velg om "Alle brukere" linken skal skjules offentlig, skal alle brukere skjules eller vises offentlig.');
DEFINE ('_UDDEADM_USERSET_PUBLIC', 'Offentlig');
DEFINE ('_UDDEADM_USERSET_SELPUBLIC', '- velg offentlig -');
DEFINE ('_UDDEIM_OPTIONS_F', 'Gir offentlige brukere tilgang til � sende beskjeder');
DEFINE ('_UDDEIM_MSGLIMITREACHED', 'Meldingsgrense n�dd!');
DEFINE ('_UDDEIM_PUBLICUSER', 'Offentlig bruker');
DEFINE ('_UDDEIM_DELETEDUSER', 'Bruker slettet');
DEFINE ('_UDDEADM_CAPTCHALEN_HEAD', 'Captcha lengde');
DEFINE ('_UDDEADM_CAPTCHALEN_EXP', 'Spesifiserer hvor mange karakterer en bruker m� skrive.');
DEFINE ('_UDDEADM_USECAPTCHA_HEAD', 'Captcha s�ppelpost-beskyttelse');
DEFINE ('_UDDEADM_USECAPTCHA_EXP', 'Spesifiser hvem som m� bruke captcha n�r de sender en beskjed');
DEFINE ('_UDDEADM_CAPTCHAF0', 'Deaktivert');
DEFINE ('_UDDEADM_CAPTCHAF1', 'bare offentlige brukere');
DEFINE ('_UDDEADM_CAPTCHAF2', 'offentlige og registrerte brukere');
DEFINE ('_UDDEADM_CAPTCHAF3', 'offentlige, registrerte, spesialbrukere');
DEFINE ('_UDDEADM_CAPTCHAF4', 'alle brukere (inkludert administratorer)');
DEFINE ('_UDDEADM_PUBFRONTEND_HEAD', 'Aktiver offentlig');
DEFINE ('_UDDEADM_PUBFRONTEND_EXP', 'N�r aktivert kan uregistrerte brukere sende beskjeder til registrerte brukere (kan spesifiseres i personlige innstillinger om de vil bruke denne funksjonen).');
DEFINE ('_UDDEADM_PUBFRONTENDDEF_HEAD', 'Forh�ndsvelg offentlig');
DEFINE ('_UDDEADM_PUBFRONTENDDEF_EXP', 'Dette er den forh�ndsvalgte verdien for om en uregistrert bruker har tilgang til � sende en beskjed til en registrert bruker.');
DEFINE ('_UDDEADM_PUBDEF0', 'deaktivert');
DEFINE ('_UDDEADM_PUBDEF1', 'aktivert');
DEFINE ('_UDDEIM_WRONGCAPTCHA', 'Feil sikkerhetskode');

// New: 1.0
DEFINE ('_UDDEADM_NONEORUNKNOWN', 'ingen eller ukjent');
DEFINE ('_UDDEADM_DONATE', 'Hvis du liker uddeIM, og vil hjelpe utviklingen, gi en liten donasjon.');
// New: 1.0rc2
DEFINE ('_UDDEADM_BACKUPRESTORE_DATE', 'Konfigurasjon funnet i databasen: ');
DEFINE ('_UDDEADM_BACKUPRESTORE_HEAD', 'Sikkerhetskopiere og gjenopprette konfigurasjon');
DEFINE ('_UDDEADM_BACKUPRESTORE_EXP', 'Du kan sikkerhetskopiere konfigurasjonen til databasen, og gjenopprette den n�r det er n�dvendig. Dette er nyttig n�r du oppdaterer uddeIM eller n�r du vil lagre en bestemt konfigurasjon fordi du skal teste.');
DEFINE ('_UDDEADM_BACKUPRESTORE_BACKUP', 'SIKKERHETSKOPIER');
DEFINE ('_UDDEADM_BACKUPRESTORE_RESTORE', 'GJENOPPRETT');
DEFINE ('_UDDEADM_CANCEL', 'Avbryt');
// New: 1.0rc1
DEFINE ('_UDDEADM_LANGUAGECHARSET_HEAD', 'Tegnsett til spr�kfil');
DEFINE ('_UDDEADM_LANGUAGECHARSET_EXP', 'Som oftest er den <b>forh�ndsvalgte</b> (ISO-8859-1) korrekt innstilling for Joomla 1.0 og <b>UTF-8</b> for Joomla 1.5.');
DEFINE ('_UDDEADM_LANGUAGECHARSET_UTF8', 'UTF-8');
DEFINE ('_UDDEADM_LANGUAGECHARSET_DEFAULT', 'forh�ndsvalgt');
DEFINE ('_UDDEIM_READ_INFO_1', 'Leste meldinger vil v�re i innboksen i ');
DEFINE ('_UDDEIM_READ_INFO_2', ' dager f�r de slettes automatisk.');
DEFINE ('_UDDEIM_UNREAD_INFO_1', 'Uleste meldinger vil v�re i innboksen i ');
DEFINE ('_UDDEIM_UNREAD_INFO_2', ' dager f�r de slettes automatisk.');
DEFINE ('_UDDEIM_SENT_INFO_1', 'Sendte meldinger vil v�re i utboksen i ');
DEFINE ('_UDDEIM_SENT_INFO_2', ' dager f�r de slettes automatisk.');
DEFINE ('_UDDEADM_DELETEREADAFTERNOTE_HEAD', 'Vis innboksmerknad for leste meldinger');
DEFINE ('_UDDEADM_DELETEREADAFTERNOTE_EXP', 'Vis innboksmerknad <i>"Leste meldinger vil bli slettet etter n dager"</i>');
DEFINE ('_UDDEADM_DELETEUNREADAFTERNOTE_HEAD', 'Vis innboksmerknad for uleste meldinger');
DEFINE ('_UDDEADM_DELETEUNREADAFTERNOTE_EXP', 'Vis innboksmerknad <i>"Uleste meldinger vil bli slettet etter n dager"</i>');
DEFINE ('_UDDEADM_DELETESENTAFTERNOTE_HEAD', 'Vis utboksmerknad for sendte meldinger');
DEFINE ('_UDDEADM_DELETESENTAFTERNOTE_EXP', 'Vis utboksbeskjed <i>"Sendte meldinger vil bli slettet etter n dager"</i>');
DEFINE ('_UDDEADM_DELETETRASHAFTERNOTE_HEAD', 'Vis papirkurvmerknader for meldinger i papirkurven');
DEFINE ('_UDDEADM_DELETETRASHAFTERNOTE_EXP', 'Vis papirkurvmerknad <i>"Papirkurven vil bli rensket for meldinger etter n dager"</i>');
DEFINE ('_UDDEADM_DELETESENTAFTER_HEAD', 'Sendte meldinger beholdes i (dager)');
DEFINE ('_UDDEADM_DELETESENTAFTER_EXP', 'Skriv antall dager f�r <b>sendte</b> meldinger vil bli slettet automatisk fra utboksen.');
DEFINE ('_UDDEIM_SEND_TOALLSPECIAL', 'send til alle spesialbrukere');
DEFINE ('_UDDEIM_SYSGM_WILLSENDTOALLSPECIAL', 'Melding til <b>alle spesialbrukere</b>');
DEFINE ('_UDDEADM_USERSET_SELUSERNAME', '- velg brukernavn -');
DEFINE ('_UDDEADM_USERSET_SELNAME', '- velg navn -');
DEFINE ('_UDDEADM_USERSET_EDITSETTINGS', 'Rediger brukerinnstillinger');
DEFINE ('_UDDEADM_USERSET_EXISTING', 'eksisterende');
DEFINE ('_UDDEADM_USERSET_NONEXISTING', 'ikke-eksisterende');
DEFINE ('_UDDEADM_USERSET_SELENTRY', '- velg adgang -');
DEFINE ('_UDDEADM_USERSET_SELNOTIFICATION', '- velg p�minnelse -');
DEFINE ('_UDDEADM_USERSET_SELPOPUP', '- velg sprettopp -');
DEFINE ('_UDDEADM_USERSET_USERNAME', 'Brukernavn');
DEFINE ('_UDDEADM_USERSET_NAME', 'Navn');
DEFINE ('_UDDEADM_USERSET_NOTIFICATION', 'P�minnelse');
DEFINE ('_UDDEADM_USERSET_POPUP', 'Popup');
DEFINE ('_UDDEADM_USERSET_LASTACCESS', 'Siste innlogging');
DEFINE ('_UDDEADM_USERSET_NO', 'Nei');
DEFINE ('_UDDEADM_USERSET_YES', 'Ja');
DEFINE ('_UDDEADM_USERSET_UNKNOWN', 'ukjent');
DEFINE ('_UDDEADM_USERSET_WHENOFFLINEEXCEPT', 'N�r frakoblet (bortsett fra svar)');
DEFINE ('_UDDEADM_USERSET_ALWAYSEXCEPT', 'Alltid (bortsett fra svar)');
DEFINE ('_UDDEADM_USERSET_WHENOFFLINE', 'N�r frakoblet');
DEFINE ('_UDDEADM_USERSET_ALWAYS', 'Alltid');
DEFINE ('_UDDEADM_USERSET_NONOTIFICATION', 'Ingen p�minnelse');
DEFINE ('_UDDEADM_WELCOMEMSG', "Velkommen til uddeIM!\n\nInstallasjonen av uddeIM var vellykket.\n\nPr�v � se denne beskjeden med forskjellige maler. Du kan velge mal i administrasjonen for uddeIM.\n\nuddeIM er et prosjekt i stadig utvikling. Hvis du finner feil eller svakheter, skriv til meg s� vi kan gj�re uddeIM bedre sammen.\n\nLykke til og ha det moro!");
DEFINE ('_UDDEADM_UDDEINSTCOMPLETE', 'uddeIM installasjon ferdig.');
DEFINE ('_UDDEADM_REVIEWSETTINGS', 'Fortsett til administrasjonen og g� gjennom innstillingene.');
DEFINE ('_UDDEADM_REVIEWLANG', 'Hvis du bruker et annet tegnsett enn ISO 8859-1, juster tegnsettingen.');
DEFINE ('_UDDEADM_REVIEWEMAILSTOP', 'Etter installasjonen er all uddeIM e-posttrafikk (e-postp�minnelse, Glem meg ikke e-poster) deaktivert s� ingen e-post blir sendt s� lenge du tester. Glem ikke � deaktiver "stopp e-post" n�r du er ferdig.');
DEFINE ('_UDDEADM_MAXRECIPIENTS_HEAD', 'Maks. antall mottakere');
DEFINE ('_UDDEADM_MAXRECIPIENTS_EXP', 'Maks. antall mottakere pr. melding (0=ingen begrensing)');
DEFINE ('_UDDEIM_TOOMANYRECIPIENTS', 'for mange mottakere');
DEFINE ('_UDDEIM_STOPPEDEMAIL', 'Sending av E-post er deaktivert.');
DEFINE ('_UDDEADM_SEARCHINSTRING_HEAD', 'S�king inne i teksten');
DEFINE ('_UDDEADM_SEARCHINSTRING_EXP', 'Automatisk ferdigstillelse s�ker inne i teksten (ellers s�kes det bare fra begynnelsen)');
DEFINE ('_UDDEADM_MODESHOWALLUSERS_HEAD', 'Oppf�rsel til "Alle brukere" lenken');
DEFINE ('_UDDEADM_MODESHOWALLUSERS_EXP', 'Velg om "Alle brukere" lenken skal skjules, vises eller alle brukere skal vises bestandig.');
DEFINE ('_UDDEADM_MODESHOWALLUSERS_0', 'Skjul "Alle brukere" lenke');
DEFINE ('_UDDEADM_MODESHOWALLUSERS_1', 'Vis "Alle brukere" lenke');
DEFINE ('_UDDEADM_MODESHOWALLUSERS_2', 'Alltid vis alle brukere');
DEFINE ('_UDDEADM_CONFIGNOTWRITEABLE', 'Konfigurasjonsfilen er ikke overskrivbar:');
DEFINE ('_UDDEADM_CONFIGWRITEABLE', 'Konfigurasjonsfilen er overskrivbar:');
DEFINE ('_UDDEIM_FORWARDLINK', 'videresend');
DEFINE ('_UDDEIM_RECIPIENTFOUND', 'mottaker funnet');
DEFINE ('_UDDEIM_RECIPIENTSFOUND', 'mottakere funnet');
DEFINE ('_UDDEADM_MAILSYSTEM_MOSMAIL', 'mosMail');
DEFINE ('_UDDEADM_MAILSYSTEM_PHPMAIL', 'php mail (forh�ndsvalgt)');
DEFINE ('_UDDEADM_MAILSYSTEM_HEAD', 'Mailsystem');
DEFINE ('_UDDEADM_MAILSYSTEM_EXP', 'Velg mailsystem uddeIM skal bruke for � sende p�minnelser.');
DEFINE ('_UDDEADM_SHOWGROUPS_HEAD', 'Vis Joomla grupper');
DEFINE ('_UDDEADM_SHOWGROUPS_EXP', 'Vis Joomla grupper i den generelle meldingslisten.');
DEFINE ('_UDDEADM_ALLOWFORWARDS_HEAD', 'Videresending av meldinger');
DEFINE ('_UDDEADM_ALLOWFORWARDS_EXP', 'Tillat videresending av meldinger.');
DEFINE ('_UDDEIM_FWDFROM', 'Original melding fra');
DEFINE ('_UDDEIM_FWDTO', 'til');

// New: 0.9+
DEFINE ('_UDDEIM_UNARCHIVE', 'Avarkivere melding');
DEFINE ('_UDDEIM_CANTUNARCHIVE', 'Kan ikke av-arkivere melding');
DEFINE ('_UDDEADM_ALLOWMULTIPLERECIPIENTS_HEAD', 'Tillat flere mottakere');
DEFINE ('_UDDEADM_ALLOWMULTIPLERECIPIENTS_EXP', 'Tillat flere mottakere (skilles med komma).');
DEFINE ('_UDDEIM_CHARSLEFT', 'tegn igjen');
DEFINE ('_UDDEADM_SHOWTEXTCOUNTER_HEAD', 'Vis tegnteller');
DEFINE ('_UDDEADM_SHOWTEXTCOUNTER_EXP', 'Vis en tegnteller som viser antall tegn igjen.');
DEFINE ('_UDDEIM_CLEAR', 'T�m');
DEFINE ('_UDDEADM_ALLOWMULTIPLEUSER_HEAD', 'Legg til brukere som mottakere');
DEFINE ('_UDDEADM_ALLOWMULTIPLEUSER_EXP', 'Dette tillater utvelgelse av flere mottakere fra "Alle brukere" listen.');
DEFINE ('_UDDEADM_CBALLOWMULTIPLEUSER_HEAD', 'Legg til forbindelse til mottakere');
DEFINE ('_UDDEADM_CBALLOWMULTIPLEUSER_EXP', 'Dette tillater utvelgelse av flere mottakere fra "CB forbindelser" listen.');
DEFINE ('_UDDEADM_PMSFOUND', 'PMS funnet: ');
DEFINE ('_UDDEIM_ENTERNAME', 'skriv et navn');
DEFINE ('_UDDEADM_USEAUTOCOMPLETE_HEAD', 'Bruk automatisk ferdigstillelse');
DEFINE ('_UDDEADM_USEAUTOCOMPLETE_EXP', 'Bruk automatisk ferdigstillelse for mottakernavn.');
DEFINE ('_UDDEADM_OBFUSCATING_HEAD', 'N�kkel for kryptering');
DEFINE ('_UDDEADM_OBFUSCATING_EXP', 'Skriv n�kkel som brukes til � kryptere meldinger. Ikke forandre denne n�kkelen etter at kryptering av meldinger er aktivert.');
DEFINE ('_UDDEADM_CFGFILE_NOTFOUND', 'Feil konfigurasjonsfil funnet!');
DEFINE ('_UDDEADM_CFGFILE_FOUND', 'Versjon funnet:');
DEFINE ('_UDDEADM_CFGFILE_EXPECTED', 'Versjon forventet:');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING', 'Gj�r om konfigurasjonen...');
DEFINE ('_UDDEADM_CFGFILE_DONE', 'Ferdig!');
DEFINE ('_UDDEADM_CFGFILE_WRITEFAILED', 'Kritisk feil: Kunne ikke skrive til konfigurasonsfilen:');

// New: 0.8+
DEFINE ('_UDDEIM_ENCRYPTDOWN', 'Kryptert melding! - Nedlasting ikke mulig!');
DEFINE ('_UDDEIM_WRONGPASSDOWN', 'Feil passord! - Nedlasting ikke mulig!');
DEFINE ('_UDDEIM_WRONGPW', 'Feil passord! - Kontakt databaseadministrator!');
DEFINE ('_UDDEIM_WRONGPASS', 'Feil passord!');
DEFINE ('_UDDEADM_MAINTENANCE_D1', 'Feil papirkurvdatoer (innboks/utboks): ');
DEFINE ('_UDDEADM_MAINTENANCE_D2', 'Retter feil papirkurvdatoer');
DEFINE ('_UDDEIM_TODP', 'Til: ');
DEFINE ('_UDDEADM_MAINTENANCE_PRUNE', 'Slett meldinger n�');
DEFINE ('_UDDEADM_SHOWACTIONICONS_HEAD', 'Vis handlingsbilder');
DEFINE ('_UDDEADM_SHOWACTIONICONS_EXP', 'N�r satt til <b>ja</b>, vil handlingslenker bli vist som bilde.');
DEFINE ('_UDDEIM_UNCHECKALL', 'ta bort alle markeringer');
DEFINE ('_UDDEIM_CHECKALL', 'marker alle');
DEFINE ('_UDDEADM_SHOWBOTTOMICONS_HEAD', 'Vis bunnbilder');
DEFINE ('_UDDEADM_SHOWBOTTOMICONS_EXP', 'N�r satt til <b>ja</b>, vil alle lenkene p� bunnen bli vist som bilder.');
DEFINE ('_UDDEADM_ANIMATED_HEAD', 'Bruk animerte smileys');
DEFINE ('_UDDEADM_ANIMATED_EXP', 'Bruk animerte smileys i stedet for de statiske.');
DEFINE ('_UDDEADM_ANIMATEDEX_HEAD', 'Flere animerte smileys');
DEFINE ('_UDDEADM_ANIMATEDEX_EXP', 'Vis flere animerte smileys.');
DEFINE ('_UDDEIM_PASSWORDREQ', 'Kryptert melding - Passord beh�ves');
DEFINE ('_UDDEIM_PASSWORD', '<b>Passord beh�ves</b>');
DEFINE ('_UDDEIM_PASSWORDBOX', 'Passord');
DEFINE ('_UDDEIM_ENCRYPTIONTEXT', ' (krypteringstekst)');
DEFINE ('_UDDEIM_DECRYPTIONTEXT', ' (avkrypteringstekst)');
DEFINE ('_UDDEIM_MORE', 'FLERE');
// uddeIM Module
DEFINE ('_UDDEMODULE_PRIVATEMESSAGES', 'Private Meldinger');
DEFINE ('_UDDEMODULE_NONEW', 'ingen nye');
DEFINE ('_UDDEMODULE_NEWMESSAGES', 'Nye meldinger: ');
DEFINE ('_UDDEMODULE_MESSAGE', 'melding');
DEFINE ('_UDDEMODULE_MESSAGES', 'meldinger');
DEFINE ('_UDDEMODULE_YOUHAVE', 'Du har');
DEFINE ('_UDDEMODULE_HELLO', 'Hei');
DEFINE ('_UDDEMODULE_EXPRESSMESSAGE', 'Ekspressmelding');

// New: 0.7+
DEFINE ('_UDDEADM_USEENCRYPTION', 'Bruk kryptering');
DEFINE ('_UDDEADM_USEENCRYPTIONDESC', 'Krypter lagrede meldinger');
DEFINE ('_UDDEADM_CRYPT0', 'Ingen');
DEFINE ('_UDDEADM_CRYPT1', 'Gj�r meldinger vanskelige � lese for andre enn sender og mottaker');
DEFINE ('_UDDEADM_CRYPT2', 'Krypter meldinger');
DEFINE ('_UDDEADM_NOTIFYDEFAULT_HEAD', 'Forh�ndsvalgt for E-post p�minnelse');
DEFINE ('_UDDEADM_NOTIFYDEFAULT_EXP', 'Forh�ndsvalgt verdi for E-post p�minnelse (for brukere som ikke har forandret deres referanser enn�).');
DEFINE ('_UDDEADM_NOTIFYDEF_0', 'Ingen p�minnelse');
DEFINE ('_UDDEADM_NOTIFYDEF_1', 'Alltid');
DEFINE ('_UDDEADM_NOTIFYDEF_2', 'P�minnelse n�r frakoblet');
DEFINE ('_UDDEADM_SUPPRESSALLUSERS_HEAD', 'Skjul "Alle brukere" lenken');
DEFINE ('_UDDEADM_SUPPRESSALLUSERS_EXP', 'Skjul "Alle brukere" lenken i boksen "skriv ny melding" (nyttig n� det er mange registerte brukere).');
DEFINE ('_UDDEADM_POPUP_HEAD','Sprettoppvarsling');
DEFINE ('_UDDEADM_POPUP_EXP','Vis sprettoppvindu n�r en ny melding mottas (mod_uddeim eller oppdatert mod_cblogin beh�ves)');
DEFINE ('_UDDEIM_OPTIONS', 'Flere innstillinger');
DEFINE ('_UDDEIM_OPTIONS_EXP', 'Her kan du konfigurere flere innstillinger.');
DEFINE ('_UDDEIM_OPTIONS_P', 'Vis sprettoppvindu n�r en melding mottas');
DEFINE ('_UDDEADM_POPUPDEFAULT_HEAD', 'Sprettoppvarsling er forh�ndsvalgt');
DEFINE ('_UDDEADM_POPUPDEFAULT_EXP', 'Sl� p� sprettoppvarsling som forh�ndsvalgt (for brukere som ikke har forandret deres innstillinger enn�).');
DEFINE ('_UDDEADM_MAINTENANCE', 'Vedlikehold');
DEFINE ('_UDDEADM_MAINTENANCE_HEAD', 'Database vedlikehold');
DEFINE ('_UDDEADM_MAINTENANCE_CHECK', 'KONTROLLER');
DEFINE ('_UDDEADM_MAINTENANCE_TRASH', 'REPARER');
DEFINE ('_UDDEADM_MAINTENANCE_EXP', "N�r en bruker slettes fra databasen blir vanligvis meldingene til brukeren beholdt i databasen. Denne funksjonen kontrollerer om det er n�dvendig � slette l�se meldinger, og du kan slette dem hvis det beh�ves.<br />Dette kontrollerer databasen for noen f� feil som vil bli rettet.");
DEFINE ('_UDDEADM_MAINTENANCE_MC1', "Kontrollerer...<br />");
DEFINE ('_UDDEADM_MAINTENANCE_MC2', "<i>#nnn (Brukernavn): [innboks|innbokspapirkurv|utboks|utbokspapirkurv]</i><br />");
DEFINE ('_UDDEADM_MAINTENANCE_MC3', "<i>innboks: meldinger lagret i brukers innboks</i><br />");
DEFINE ('_UDDEADM_MAINTENANCE_MC4', "<i>innboks slettet: meldinger slettet fra brukers innboks, men ligger enn� i en eller annens utboks</i><br />");
DEFINE ('_UDDEADM_MAINTENANCE_MC5', "<i>utboks: meldinger lagret i brukers utboks</i><br />");
DEFINE ('_UDDEADM_MAINTENANCE_MC6', "<i>utboks slettet: meldinger slettet fra brukers utboks, men ligger enn� i en eller annens innboks</i><br />");
DEFINE ('_UDDEADM_MAINTENANCE_MT1', "Sletting p�g�r...<br />");
DEFINE ('_UDDEADM_MAINTENANCE_NOTFOUND', "ikke funnet (fra/til/innstillinger/sperrer/blokkert):");
DEFINE ('_UDDEADM_MAINTENANCE_MT2', "fjern alle referanser fra bruker");
DEFINE ('_UDDEADM_MAINTENANCE_MT3', "fjern blokkering av bruker");
DEFINE ('_UDDEADM_MAINTENANCE_MT4', "slett alle meldinger sendt til slettet bruker i avsenderens utboks, og fjern brukerens innboks");
DEFINE ('_UDDEADM_MAINTENANCE_MT5', "slett alle meldinger sendt fra slettet bruker i brukerens utboks og mottakerens innboks");
DEFINE ('_UDDEADM_MAINTENANCE_NOTHINGTODO', '<b>Ingenting � gj�re</b><br />');
DEFINE ('_UDDEADM_MAINTENANCE_JOBTODO', '<b>Vedlikehold beh�ves</b><br />');

// New: 0.6+
DEFINE ('_UDDEADM_NAMESTEXT', 'Vis navn');
DEFINE ('_UDDEADM_NAMESDESC', 'Vis navn eller brukernavn?');
DEFINE ('_UDDEADM_REALNAMES', 'Navn');
DEFINE ('_UDDEADM_USERNAMES', 'Brukernavn');
DEFINE ('_UDDEADM_CONLISTBOX', 'CB forbindelse listeboks');
DEFINE ('_UDDEADM_CONLISTBOXDESC', 'Vis mine forbindelser i en listeboks eller i en tabell?');
DEFINE ('_UDDEADM_LISTBOX', 'Listeboks');
DEFINE ('_UDDEADM_TABLE', 'Tabell');

DEFINE ('_UDDEIM_TRASHCAN_INFO_1', 'Meldinger vil v�re i papirkurven i ');
DEFINE ('_UDDEIM_TRASHCAN_INFO_2', ' timer f�r de blir slettet for godt. Du kan bare se de f�rste ordene i meldingen. For � lese meldingen m� du gjennopprette den f�rst.');
DEFINE ('_UDDEIM_RECALLEDMESSAGE_INFO', 'Denne meldingen er gjenopprettet. Du kan n� redigere og sende den p� nytt.');
DEFINE ('_UDDEIM_COULDNOTRECALL', 'Meldingen kunne ikke bli hentet tilbake (sannsynligvis fordi den er lest eller slettet for godt.)');
DEFINE ('_UDDEIM_CANTRESTORE', 'Gjenoppretting av meldingen feilet. (Den kan ha v�rt for lenge i papirkurven og blitt slettet for godt.)');
DEFINE ('_UDDEIM_DONTSEND', 'Ikke send');
DEFINE ('_UDDEIM_NOTLOGGEDIN', 'Du er ikke innlogget.');
DEFINE ('_UDDEIM_NOMESSAGES_INBOX', '<b>Du har ingen meldinger i innboksen din.</b>');

DEFINE ('_UDDEIM_NOMESSAGES_OUTBOX', '<b>Du har ingen meldinger i utboksen din.</b>');
DEFINE ('_UDDEIM_NOMESSAGES_TRASHCAN', '<b>Du har ingen meldinger i papirkurven din.</b>');
DEFINE ('_UDDEIM_INBOX', 'Innboks');
DEFINE ('_UDDEIM_OUTBOX', 'Utboks');
DEFINE ('_UDDEIM_TRASHCAN', 'Papirkurv');
DEFINE ('_UDDEIM_FROM', 'Fra');
DEFINE ('_UDDEIM_FROM_SMALL', 'fra');
DEFINE ('_UDDEIM_TO', 'Til');
DEFINE ('_UDDEIM_TO_SMALL', 'til');
DEFINE ('_UDDEIM_OUTBOX_WARNING', 'Utboksen inneholder alle meldinger du har sendt. Du kan hente meldingen tilbake n�r den ikke er lest enn�. Hvis du henter den tilbake kan ikke mottakeren lenger lese meldingen. ');

DEFINE ('_UDDEIM_RECALL', 'hent tilbake');
DEFINE ('_UDDEIM_RECALLTHISMESSAGE', 'Hent tilbake meldingen');
DEFINE ('_UDDEIM_RESTORE', 'gjenopprett');
DEFINE ('_UDDEIM_MESSAGE', 'Melding');
DEFINE ('_UDDEIM_DATE', 'Dato');
DEFINE ('_UDDEIM_DELETED', 'Slettet');
DEFINE ('_UDDEIM_DELETE', 'slett');
DEFINE ('_UDDEIM_DELETELINK', 'slett');
DEFINE ('_UDDEIM_MESSAGENOACCESS', 'Denne meldingen kan ikke vises. <br />Mulig grunn:<ul><li>Du har ikke rettigheter til � lese denne meldingen.<li><li>Meldingen er slettet.</li></ul>');
DEFINE ('_UDDEIM_YOUMOVEDTOTRASH', '<b>Du har flyttet denne meldingen til papirkurven.</b>');
DEFINE ('_UDDEIM_MESSAGEFROM', 'Melding fra ');
DEFINE ('_UDDEIM_MESSAGETO', 'Melding fra deg til ');
DEFINE ('_UDDEIM_REPLY', 'Svar');
DEFINE ('_UDDEIM_SUBMIT', 'Send');
DEFINE ('_UDDEIM_DELETEREPLIED', 'Flytt den originale meldingen til papirkurven etter at du har svart');
DEFINE ('_UDDEIM_NOID', 'Feil: Mottaker er ikke funnet. Ingen melding er sendt.');
DEFINE ('_UDDEIM_MESSAGE_REPLIEDTO', 'Svar sendt');
DEFINE ('_UDDEIM_MESSAGE_SENT', 'Melding sendt');
DEFINE ('_UDDEIM_MOVEDTOTRASH', ' og den originale meldingen er flyttet til papirkurven');
DEFINE ('_UDDEIM_NOSUCHUSER', 'Det er ingen bruker med dette brukernavnet!');
DEFINE ('_UDDEIM_NOTTOYOURSELF', 'Det er ikke mulig � sende meldinger til deg selv!');
DEFINE ('_UDDEIM_VIOLATION', '<b>Rettighetsbrudd!</b> Du har ikke rettighet til � utf�re denne handlingen!');
DEFINE ('_UDDEIM_PRUNELINK', 'Bare administratorer: Slett');

// Admin
DEFINE ('_UDDEADM_SETTINGS', 'uddeIM Administrasjon');
DEFINE ('_UDDEADM_ABOUT', 'Om');
DEFINE ('_UDDEADM_DATESETTINGS', 'Dato/klokkeslett');
DEFINE ('_UDDEADM_DELETEREADAFTER_HEAD', 'Leste meldinger beholdes i (dager)');
DEFINE ('_UDDEADM_DELETEUNREADAFTER_HEAD', 'Uleste meldinger beholdes i (dager)');
DEFINE ('_UDDEADM_DELETETRASHAFTER_HEAD', 'Meldinger beholdes i papirkurven i (dager)');
DEFINE ('_UDDEADM_DAYS', 'dag(er)');
DEFINE ('_UDDEADM_DELETEREADAFTER_EXP', 'Skriv antall dager f�r <b>leste</b> meldinger blir slettet automatisk fra innboksen. Vis du ikke vil slette meldinger automatisk, skriv et veldig stort tall (f.eks. 36524 dager som er det samme som hundre �r). Husk p� at databasen kan fylles fort, hvis du beholder alle meldinger.');
DEFINE ('_UDDEADM_DELETEUNREADAFTER_EXP', 'Skriv antall dager f�r meldinger <b>som ikke er lest</b> av mottakeren blir slettet.');
DEFINE ('_UDDEADM_DELETETRASHAFTER_EXP', 'Skriv antall dager f�r meldinger blir slettet fra papirkurven. Desimaltall er mulig, f.eks. for � slette meldinger fra papirkurven etter 3 timer skriv 0.125 som verdi.');
DEFINE ('_UDDEADM_DATEFORMAT_HEAD', 'Datoformat');
DEFINE ('_UDDEADM_DATEFORMAT_EXP', 'Velg formatet som skal brukes n�r dato/klokkeslett vises. M�neder vil forkortes etter lokale spr�kinnstillinger i Joomla (hvis en passende uddeIM spr�kfil finnes).');
DEFINE ('_UDDEADM_LDATEFORMAT_HEAD', 'Langt datoformat');
DEFINE ('_UDDEADM_LDATEFORMAT_EXP', 'N�r meldinger vises er det mer plass til dato/klokkeslettstreng. Velg datoformatet som vises n�r en melding �pnes. For ukedager og m�neder vil lokale spr�kinnstillinger i Joomla brukes (hvis en passende uddeIM spr�kfil finnes).');
DEFINE ('_UDDEADM_ADMINIGNITIONONLY_HEAD', 'Sletting startet');
DEFINE ('_UDDEADM_ADMINIGNITIONONLY_YES', 'bare av administratorer');
DEFINE ('_UDDEADM_ADMINIGNITIONONLY_NO', 'av hvilken som helst bruker');
DEFINE ('_UDDEADM_ADMINIGNITIONONLY_MANUALLY', 'manuelt');
DEFINE ('_UDDEADM_ADMINIGNITIONONLY_EXP', 'Automatisk sletting gir stor belasting p� tjeneren. Hvis du velger <b>bare av administratorer</b> vil automatisk sletting starte n�r en administrator sjekker innboksen sin. Velg denne muligheten hvis en administrator sjekker innboksen regelmessig. Sm� nettsteder, eller som administreres sjeldent, kan velge <b>av hvilken som helst bruker</b>.');
DEFINE ('_UDDEADM_SETTINGSSAVED', 'Innstillinger er lagret.');

// admin import tab
DEFINE ('_UDDEADM_CONTINUE', 'fortsett');
DEFINE ('_UDDEADM_IMPORT_EXP', 'Dette vil ikke endre de gamle PMS meldingene eller installasjonen. De vil forbli intakte og du kan trygt importere de til uddeIM, ogs� hvis du bestemmer deg for � fortsette � bruke den gamle PMS. Du b�r lagre alle forandringer du har gjort i innstillingene f�r du kj�rer importfunksjonen! Alle meldinger som allerede er i uddeIM-databasen vil forbli intakt.');
	
DEFINE ('_UDDEADM_IMPORT_YES', 'Importer gamle PMS meldinger til uddeIM n�');
DEFINE ('_UDDEADM_IMPORT_NO', 'Nei, ikke importer meldinger');  
DEFINE ('_UDDEADM_IMPORTING', 'Vent mens meldingene blir importert.');
DEFINE ('_UDDEADM_IMPORTDONE', 'Ferdig med � importere meldingene fra gammel PMS. Ikke kj�r dette installasjonsskriptet en gang til (Da vil meldingene importeres en gang til og vil vises dobbelt)'); 
DEFINE ('_UDDEADM_IMPORT', 'Importer');
DEFINE ('_UDDEADM_IMPORT_HEADER', 'Importer meldinger fra gammel PMS');
DEFINE ('_UDDEADM_PMSNOTFOUND', 'Ingen annen PMS installasjon funnet. Import er ikke mulig.');
DEFINE ('_UDDEADM_ALREADYIMPORTED', '<span style="color: red;">Du har allerede importert disse meldingene fra den gamle PMS til uddeIM.</span>');

// new in 0.3 Frontend
DEFINE ('_UDDEIM_YOUAREBLOCKED', 'Ikke sendt (bruker har blokkert deg)');
DEFINE ('_UDDEIM_BLOCKNOW', 'blokkert&nbsp;bruker');
DEFINE ('_UDDEIM_BLOCKS_EXP', 'Dette er en liste over brukere du har blokkert. Disse brukerene kan ikke sende deg private meldinger.');
DEFINE ('_UDDEIM_NOBODYBLOCKED', 'For tiden har du ikke blokkert noen brukere.');
DEFINE ('_UDDEIM_YOUBLOCKED_PRE', 'For tiden har du blokkert ');
DEFINE ('_UDDEIM_YOUBLOCKED_POST', ' bruker(e).');
DEFINE ('_UDDEIM_UNBLOCKNOW', '[ikke blokker]');
DEFINE ('_UDDEIM_BLOCKALERT_EXP_ON', 'N�r en bruker du har blokkert pr�ver � sende deg en melding. Vil han f� beskjed om at han er blokkert og at meldingen ikke vil sendes.');
DEFINE ('_UDDEIM_BLOCKALERT_EXP_OFF', 'En blokkert bruker kan ikke se at du har blokkert han.');
DEFINE ('_UDDEIM_CANTBLOCKADMINS', 'Du kan ikke blokkere administratorer.');

// new in 0.3 Admin
DEFINE ('_UDDEADM_BLOCKSYSTEM_HEAD', 'Sl� p� blokkeringssystemet');
DEFINE ('_UDDEADM_BLOCKSYSTEM_EXP', 'N�r sl�tt p�, kan brukere blokkere andre brukere. En blokkert bruker kan ikke sende meldinger til brukeren som har blokkert han/henne. Administratorer kan ikke bli blokkert.');
DEFINE ('_UDDEADM_BLOCKSYSTEM_YES', 'Ja');
DEFINE ('_UDDEADM_BLOCKSYSTEM_NO', 'nei');
DEFINE ('_UDDEADM_BLOCKALERT_HEAD', 'Informasjon til blokkert bruker');
DEFINE ('_UDDEADM_BLOCKALERT_EXP', 'Hvis satt til <b>ja</b>, vil en blokkert bruker bli informert at meldingen ikke er sendt fordi mottakeren har blokkert han/henne. Hvis satt til <b>nei</b>, vil den blokkerte brukeren ikke f� noen beskjed om at meldingen ikke er sendt.');
DEFINE ('_UDDEADM_BLOCKALERT_YES', 'ja');
DEFINE ('_UDDEADM_BLOCKALERT_NO', 'nei');
DEFINE ('_UDDEIM_BLOCKSDISABLED', 'Blokkeringssystemet er ikke sl�tt p�');
DEFINE ('_UDDEADM_DELETIONS', 'Sletting'); // changed in 0.4
DEFINE ('_UDDEADM_BLOCK', 'Blokkering');

// new in 0.4, admin
DEFINE ('_UDDEADM_INTEGRATION', 'Integrering');
DEFINE ('_UDDEADM_EMAIL', 'E-post');
DEFINE ('_UDDEADM_SHOWCBLINK_HEAD', 'Vis CB linker');
DEFINE ('_UDDEADM_SHOWCBLINK_EXP', 'N�r satt til <b>ja</b>, vil alle brukernavnene i uddeIM vises som lenker til deres Community Builder profil.');
DEFINE ('_UDDEADM_SHOWCBPIC_HEAD', 'Vis CB miniatyrbilder');
DEFINE ('_UDDEADM_SHOWCBPIC_EXP', 'N�r satt til <b>ja</b>, vil miniatyrbildene til brukeren som er lagret i Community Builder vises n�r en melding leses.');
DEFINE ('_UDDEADM_SHOWONLINE_HEAD', 'Vis status for tilkoblet');
DEFINE ('_UDDEADM_SHOWONLINE_EXP', 'N�r satt til <b>ja</b>, vil uddeIM vise brukernavnet med et lite ikon som informerer om brukeren er tilkoblet eller frakoblet.');
DEFINE ('_UDDEADM_ALLOWEMAILNOTIFY_HEAD', 'Tillat E-post p�minnelse');
DEFINE ('_UDDEADM_ALLOWEMAILNOTIFY_EXP', 'N�r satt til <b>ja</b>, kan brukerene velge om de vil motta en E-post hver gang en melding mottas i innboksen.');
DEFINE ('_UDDEADM_EMAILWITHMESSAGE_HEAD', 'E-post inneholder melding');
DEFINE ('_UDDEADM_EMAILWITHMESSAGE_EXP', 'N�r satt til <b>nei</b>, vil E-posten bare inneholde informasjon om n�r og hvem fra meldingen var sendt, men ikke selve meldingen.');
DEFINE ('_UDDEADM_LONGWAITINGEMAIL_HEAD', 'Glem meg ikke E-post');
DEFINE ('_UDDEADM_LONGWAITINGEMAIL_EXP', 'Denne funksjonen sender en E-post til brukere som har uleste meldinger i innboksen (sett tiden under). Denne innstillingen er uavhengig fra \'tillat E-post p�minnelse\'. Hvis du ikke vil sende noen E-poste, m� du sl� av begge.');
DEFINE ('_UDDEADM_LONGWAITINGDAYS_HEAD', 'Glem meg ikke sendes etter dag(er)');
DEFINE ('_UDDEADM_LONGWAITINGDAYS_EXP', 'Hvis glem meg ikke-funksjonen (ovenfor) er satt til  <b>ja</b>, sett her antall dager f�r E-post p�minnelsen om uleste meldinger skal sendes.');
DEFINE ('_UDDEADM_FIRSTWORDSINBOX_HEAD', 'F�rste tegnliste');
DEFINE ('_UDDEADM_FIRSTWORDSINBOX_EXP', 'Du kan angi her hvor mange tegn i meldingen som skal vises i innboksen, utboksen og papirkurven.');
DEFINE ('_UDDEADM_MAXLENGTH_HEAD', 'Maks. meldingslengde');
DEFINE ('_UDDEADM_MAXLENGTH_EXP', 'Sett maks. meldingslengde (meldingen vil bli besk�ret automatisk n�r lengden overskrider denne verdien). Sett til \'0\' for � tillate meldinger av hvilken som helst lengde (ikke anbefalt).');
DEFINE ('_UDDEADM_YES', 'ja');
DEFINE ('_UDDEADM_NO', 'nei');
DEFINE ('_UDDEADM_ADMINSONLY', 'bare administratorer');
DEFINE ('_UDDEADM_SYSTEM', 'System');
DEFINE ('_UDDEADM_SYSM_USERNAME_HEAD', 'Brukernavn for systemmeldinger');
DEFINE ('_UDDEADM_SYSM_USERNAME_EXP', 'uddeIM st�tter systemmeldinger. De har ikke noen avsender og brukere kan ikke svare meldingen. Skriv det standard brukernavnalias for systemmeldinger (for eksempel <b>Brukerst�tte</b>, <b>Hjelpeskranke</b> eller <b>Community Master</b>).');
DEFINE ('_UDDEADM_ALLOWTOALL_HEAD', 'Tillat administratorer � sende generelle meldinger');
DEFINE ('_UDDEADM_ALLOWTOALL_EXP', 'uddeIM st�tter generelle meldinger. De blir sendt til alle brukere i systemet. Bruk funksjonen med forsiktighet.');
DEFINE ('_UDDEADM_EMN_SENDERNAME_HEAD', 'E-post avsendernavn');
DEFINE ('_UDDEADM_EMN_SENDERNAME_EXP', 'Skriv navnet som E-post p�minnelsen skal komme fra (for eksempel <b>Din side</b> eller <b>Meldingsservice</b>)');
DEFINE ('_UDDEADM_EMN_SENDERMAIL_HEAD', 'E-post avsenderadresse');
DEFINE ('_UDDEADM_EMN_SENDERMAIL_EXP', 'Skriv E-postadressen som E-post p�minnelse blir sendt fra (dette b�r v�re E-postadressen til hovedkontakten for nettstedet.');
DEFINE ('_UDDEADM_VERSION', 'uddeIM versjon');
DEFINE ('_UDDEADM_ARCHIVE', 'Arkivsystem'); // translators info: headline for Archive system
DEFINE ('_UDDEADM_ALLOWARCHIVE_HEAD', 'Sl� p� arkivfunksjonen');
DEFINE ('_UDDEADM_ALLOWARCHIVE_EXP', 'Velg om en bruker skal ha tillatelse til � lagre meldingene i et arkiv. Meldingene i arkivet vil ikke bli slettet automatisk.');
DEFINE ('_UDDEADM_MAXARCHIVE_HEAD', 'Maks. antall meldinger i arkivet');
DEFINE ('_UDDEADM_MAXARCHIVE_EXP', 'Sett hvor mange meldinger hver bruker kan lagre i arkivet (ingen begrensing for administratorer).');
DEFINE ('_UDDEADM_COPYTOME_HEAD', 'Tillat kopier');
DEFINE ('_UDDEADM_COPYTOME_EXP', 'Tillat brukere � motta kopier av meldinger de sender. Disse kopiene vil vises i innboksen.');
DEFINE ('_UDDEADM_MESSAGES', 'Meldinger');
DEFINE ('_UDDEADM_TRASHORIGINAL_HEAD', 'Foresl� � sende originalmeldingen til papirkurven');
DEFINE ('_UDDEADM_TRASHORIGINAL_EXP', 'N�r aktivert vil dette plassere en avkryssingsboks ved siden av \'Send\' svarknappen kalt \'originalmelding til papirkurv\', som er avkrysset som standard. I dette tilfellet vil en melding bli flyttet fra innboksen til papirkurven n�r et svar blir sendt. Denne funksjonen reduserer antallet meldinger som beholdes i databasen. Brukere kan fjerne avkryssingen hvis de vil beholde meldingen i innboksen.');

DEFINE ('_UDDEADM_PERPAGE_HEAD', 'Meldinger pr. side');	
DEFINE ('_UDDEADM_PERPAGE_EXP', 'Sett antall meldinger som skal vises pr. side i innboksen, utboksen, papirkurven og arkivet.');
DEFINE ('_UDDEADM_CHARSET_HEAD', 'Tegnkoding som brukes');
DEFINE ('_UDDEADM_CHARSET_EXP', 'Hvis det oppleves problemer med ikke-latinske tegn som vises, kan du sette hvilken tegnkoding som uddeIM skal bruke for � omdanne databasens utdata til HTML kode. Standardverdien er korrekt for de fleste europeiske spr�k, og er korrekt for Norsk.');
DEFINE ('_UDDEADM_MAILCHARSET_HEAD', 'Tegnkoding brukt til E-post');
DEFINE ('_UDDEADM_MAILCHARSET_EXP', 'Hvis det oppleves problemer med ikke-latinske tegn som vises, kan du sette hvilken tegnkoding som uddeIM skal bruke vedd utg�ende E-post. Standardverdien er korrekt for de fleste europeiske spr�k, og er korrekt for Norsk.');

DEFINE ('_UDDEADM_EMN_BODY_NOMESSAGE_EXP', 'Dette er innholdet i E-posten brukere vil motta n�r det er valgt ovenfor. Innholdet i meldingen vil ikke inkluderes i E-posten. Behold variablene %you%, %user% and %site% inntakt. ');		
DEFINE ('_UDDEADM_EMN_BODY_WITHMESSAGE_EXP', 'Dette er innholdet i E-posten brukere vil motta n�r det er valgt ovenfor. Innholdet i meldingen vil bli inkludert i E-posten. Behold variablene %you%, %user%, %pmessage% og %site% inntakt. ');		
DEFINE ('_UDDEADM_EMN_FORGETMENOT_EXP', 'Dette er innholdet i Glem meg ikke E-posten brukere vil motta n�r det er valgt ovenfor. Behold variablene %you% og %site% inntakt. ');
DEFINE ('_UDDEADM_ENABLEDOWNLOAD_EXP', 'Tillat brukere � laste ned meldinger fra arkivet deres ved � sende en E-post til seg selv.');
DEFINE ('_UDDEADM_ENABLEDOWNLOAD_HEAD', 'Tillat nedlasting');	
DEFINE ('_UDDEADM_EXPORT_FORMAT_EXP', 'Dette er E-postformatet som brukere vil motta n�r de laster ned deres egne meldinger fra arkivet. Behold variablene %user%, %msgdate% og %msgbody% inntakt. ');	

DEFINE ('_UDDEADM_INBOXLIMIT_HEAD', 'Sett grense for innboksen');		
DEFINE ('_UDDEADM_INBOXLIMIT_EXP', 'Du kan inkludere antall meldinger i innboksen i maks. antall arkiverte meldinger. I dette tilfellet m� antall meldinger i innboksen og arkivet ikke overskride totalen satt ovenfor. Alternativt kan du sette totalen bare for innboksen uten arkivet. Da kan brukerene ikke ha flere meldinger i innboksen enn antallet meldinger satt ovenfor. Hvis antallet n�s, vil brukeren ikke kunne svare meldinger eller skrive nye f�r de sletter noen gamle meldinger henholdsvis fra innboksen eller arkivet (brukere vil likevel kunne motta og lese meldinger).');
DEFINE ('_UDDEADM_SHOWINBOXLIMIT_HEAD', 'Vis grense og bruk av innboksen');		
DEFINE ('_UDDEADM_SHOWINBOXLIMIT_EXP', 'Viser hvor mange meldinger en bruker har lagret (og hvor mange de har lov til � lagre) p� en linje under innboksen.');
		
DEFINE ('_UDDEADM_ARCHIVETOTRASH_INTRO', 'Du har sl�tt av arkivet. Hvordan vil du behandle meldinger som er lagret i arkivet?');		
DEFINE ('_UDDEADM_ARCHIVETOTRASH_LEAVE_LINK', 'Behold dem');		
DEFINE ('_UDDEADM_ARCHIVETOTRASH_LEAVE_EXP', 'Behold dem i arkivet (brukere vil ikke kunne f� tilgang til meldingene og meldingene vil telles i meldingsgrensen).');		
DEFINE ('_UDDEADM_ARCHIVETOTRASH_INBOX_LINK', 'Flytt til innboksen');		
DEFINE ('_UDDEADM_ARCHIVETOTRASH_INBOX_DONE', 'Arkiverte meldinger flyttet til innboksene');
DEFINE ('_UDDEADM_ARCHIVETOTRASH_INBOX_EXP', 'Meldinger vil flyttes til brukerens innboks (eller til papirkurven hvis de er eldre enn tillatt alder i innboksen).');		

// 0.4 frontend, admins only (no translation necessary)		
DEFINE ('_UDDEIM_VALIDFOR_1', 'gyldig i ');
DEFINE ('_UDDEIM_VALIDFOR_2', ' timer. 0=alltid (gjelder automatisk sletting)');
DEFINE ('_UDDEIM_WRITE_SYSM_GM', '[Lag systemmelding eller generell melding]');
DEFINE ('_UDDEIM_NOTALLOWED_SYSM_GM', 'Systemmeldinger og generelle meldinger er ikke tillatt.');

DEFINE ('_UDDEIM_SYSGM_PLEASECONFIRM', 'Du er i ferd med � sende meldingen som vises under. Les gjennom meldingen og bekreft eller avbryt!');
DEFINE ('_UDDEIM_SYSGM_WILLSENDTOALL', 'Melding til <b>alle brukere</b>');
DEFINE ('_UDDEIM_SYSGM_WILLSENDTOALLADMINS', 'Melding til <b>alle administratorer</b>');
DEFINE ('_UDDEIM_SYSGM_WILLSENDTOALLLOGGED', 'Melding til <b>alle brukere som er logget inn n�</b>');
DEFINE ('_UDDEIM_SYSGM_WILLDISABLEREPLY', 'Mottakere vil ikke kunne svare p� denne meldingen.');
DEFINE ('_UDDEIM_SYSGM_WILLSENDAS_1', 'Meldingen vil bli sendt med <b>');
DEFINE ('_UDDEIM_SYSGM_WILLSENDAS_2', '</b> som brukernavn');
DEFINE ('_UDDEIM_SYSGM_WILLEXPIRE', 'Melding vil utl�pe ');
DEFINE ('_UDDEIM_SYSGM_WILLNOTEXPIRE', 'Melding vil ikke utl�pe');
DEFINE ('_UDDEIM_SYSGM_CHECKLINK', '<b>Sjekk linken (ved � klikke p� den) f�r du fortsetter!</b>');
DEFINE ('_UDDEIM_SYSGM_SHORTHELP', 'Brukes <b>bare i systemmeldinger</b>:<br /> [b]<b>fet</b>[/b] [i]<em>skr�stilt</em>[/i]<br />[url=http://www.someurl.com]some url[/url] eller [url]http://www.someurl.com[/url] er linker');
DEFINE ('_UDDEIM_SYSGM_ERRORNORECIPS', 'Feil: Ingen mottaker funnet. Meldingen er ikke sendt.');		

DEFINE ('_UDDEIM_EMN_SUBJECT', 'Du har meldinger p� %site%');
DEFINE ('_UDDEIM_SEND_ASSYSM', 'send som systemmelding (dvs., mottakere kan ikke svare meldingen)');
DEFINE ('_UDDEIM_SEND_TOALL', 'send til alle brukere');
DEFINE ('_UDDEIM_SEND_TOALLADMINS', 'send til alle administratorer');
DEFINE ('_UDDEIM_SEND_TOALLLOGGED', 'send til alle p�loggede brukere');
DEFINE ('_UDDEIM_CANTREPLY', 'Du kan ikke svare p� denne meldingen.');

DEFINE ('_UDDEIM_UNEXPECTEDERROR_QUIT', 'Uventet feil: ');
DEFINE ('_UDDEIM_ARCHIVENOTENABLED', 'Arkivsystemet er ikke sl�tt p�.');
DEFINE ('_UDDEIM_ARCHIVE_ERROR', 'Lagring av melding i arkivet feilet.');
DEFINE ('_UDDEIM_ARC_SAVED_1', 'Du har lagret ');
DEFINE ('_UDDEIM_ARC_SAVED_NONE', '<b>Du har enn� ikke lagret noen melding i arkivet.</b>'); 
DEFINE ('_UDDEIM_ARC_SAVED_NONE_2', '<b>Du har ingen melding i arkivet ditt.</b>'); 
DEFINE ('_UDDEIM_ARC_SAVED_2', ' meldinger');
DEFINE ('_UDDEIM_ARC_SAVED_3', 'For � lagre nye meldinger m� du f�rst slette noen meldinger.');
DEFINE ('_UDDEIM_INBOX_LIMIT_1', 'Du har ');
DEFINE ('_UDDEIM_INBOX_LIMIT_2', ' meldinger i din');
DEFINE ('_UDDEIM_INBOX_LIMIT_2_SINGULAR', ' melding i din'); // same as _UDDEIM_INBOX_LIMIT_2, but singular (as in one "message in your")
DEFINE ('_UDDEIM_ARC_UNIVERSE_ARC', 'arkiv');
DEFINE ('_UDDEIM_ARC_UNIVERSE_INBOX', 'innboks');
DEFINE ('_UDDEIM_ARC_UNIVERSE_BOTH', 'innboks og arkiv');
DEFINE ('_UDDEIM_INBOX_LIMIT_3', 'Maksimum tillatt er ');
DEFINE ('_UDDEIM_INBOX_LIMIT_4', 'Du kan fortsatt motta og lese meldinger, men vil ikke kunne svare eller lage nye f�r du sletter noen meldinger.');
DEFINE ('_UDDEIM_SHOWINBOXLIMIT_1', 'Melding lagret: ');
DEFINE ('_UDDEIM_SHOWINBOXLIMIT_2', '(av maks. ');

DEFINE ('_UDDEIM_MESSAGE_ARCHIVED', 'Melding lagret i arkivet.');
DEFINE ('_UDDEIM_STORE', 'arkiver');				// translators info: as in: 'store this message in archive now'
DEFINE ('_UDDEIM_BACK', 'tilbake');
DEFINE ('_UDDEIM_TRASHCHECKED', 'slett merkede');	// translators info: plural!
DEFINE ('_UDDEIM_SHOWALL', 'vis alle');				// translators example "SHOW ALL messages"
DEFINE ('_UDDEIM_ARCHIVE', 'Arkivsystem');				// should be same as _UDDEADM_ARCHIVE
	
DEFINE ('_UDDEIM_ARCHIVEFULL', 'Arkivet fullt. Ikke lagret.');	
	
DEFINE ('_UDDEIM_NOMSGSELECTED', 'Ingen melding valgt.');
DEFINE ('_UDDEIM_THISISACOPY', 'Kopi av melding du sendte til ');
DEFINE ('_UDDEIM_SENDCOPYTOME', 'behold kopi');
DEFINE ('_UDDEIM_SENDCOPYTOARCHIVE', 'kopi til arkivet');
DEFINE ('_UDDEIM_TRASHORIGINAL', 'slett original');

DEFINE ('_UDDEIM_MESSAGEDOWNLOAD', 'Meldingsnedlasting');
DEFINE ('_UDDEIM_EXPORT_MAILED', 'E-post med eksportert melding er sendt');
DEFINE ('_UDDEIM_EXPORT_NOW', 'e-post sendt til meg');
DEFINE ('_UDDEIM_EXPORT_COULDNOTSEND', 'Kunne ikke sende E-posten som inneholder meldingen.');
DEFINE ('_UDDEIM_LIMITREACHED', 'Meldingsgrense er n�dd! Ikke gjenopprettet.');

// new in 0.5 ADMIN

DEFINE ('_UDDEADM_TEMPLATEDIR_HEAD', 'uddeIM Mal');
DEFINE ('_UDDEADM_TEMPLATEDIR_EXP', 'Velg malen du vil at uddeIM skal bruke');
DEFINE ('_UDDEADM_SHOWCONNEX_HEAD', 'Vis CB forbindelser');
DEFINE ('_UDDEADM_SHOWCONNEX_EXP', 'Bruk <b>ja</b> hvis du har Community Builder installert og vil vise brukerens forbindelse p� Skriv ny melding-siden .');
DEFINE ('_UDDEADM_SHOWSETTINGSLINK_HEAD', 'Vis innstillinger');
DEFINE ('_UDDEADM_SHOWSETTINGSLINK_EXP', 'Linken til innstillingene vises automatisk i uddeIM hvis du har E-post p�minnelse eller blokkeringssystemet aktivert. Du kan spesifisere posisjonen og du kan sl� det av helt.');
DEFINE ('_UDDEADM_SHOWSETTINGS_ATBOTTOM', 'ja, p� bunnen');
DEFINE ('_UDDEADM_ALLOWBB_HEAD', 'Tillat BB kodetagger');
DEFINE ('_UDDEADM_FONTFORMATONLY', 'bare skriftformatering');
DEFINE ('_UDDEADM_ALLOWBB_EXP', 'Bruk <b>bare skriftformatering</b> for � gi brukere lov til � bruke BB kodetagger for fet, skr�stilt, understrek, skriftfarge og skriftst�rrelse. N�r du setter dette valget til <b>ja</b>, kan brukere bruke <b>alle</b> st�ttede BB kodetagger (f.eks. linker og bilder).');
DEFINE ('_UDDEADM_ALLOWSMILE_HEAD', 'Tillat Emoticons');
DEFINE ('_UDDEADM_ALLOWSMILE_EXP', 'n�r satt til <b>ja</b>, vil emoticonkoder som :-) erstattes med emoticongrafikk i meldingene som vises.');
DEFINE ('_UDDEADM_DISPLAY', 'Vis');
DEFINE ('_UDDEADM_SHOWMENUICONS_HEAD', 'Vis Menyikoner');
DEFINE ('_UDDEADM_SHOWMENUICONS_EXP', 'N�r satt til <b>ja</b>, vil menylinker bli vist som ikoner.');
DEFINE ('_UDDEADM_SHOWTITLE_HEAD', 'Komponenttittel');
DEFINE ('_UDDEADM_SHOWTITLE_EXP', 'Skriv overskriften for private meldinger, for eksempel \'Privat Melding\'. La den v�re tom hvis du ikke vil ha noen overskrift.');
DEFINE ('_UDDEADM_SHOWABOUT_HEAD', 'Vis Om lenke');
DEFINE ('_UDDEADM_SHOWABOUT_EXP', 'Sett til <b>ja</b> for � vise en lenke til uddeIM programvaremedvirkende og lisens. Denne lenken vil plasseres i bunnen av uddeIM utdata.');
DEFINE ('_UDDEADM_STOPALLEMAIL_HEAD', 'Stopp E-post');
DEFINE ('_UDDEADM_STOPALLEMAIL_EXP', 'Kryss av denne boksen for � forhindre uddeIM � sende E-poster (e-post p�minnelse og glem meg ikke E-poster) uavhengig av brukerenes innstillinger, for eksempel n�r du tester nettstedet.');
DEFINE ('_UDDEADM_GETPICLINK_HEAD', 'CB miniatyrbilder i listene');
DEFINE ('_UDDEADM_GETPICLINK_EXP', 'Sett til <b>ja</b> hvis du vil vise Community Builder miniatyrbilder i oversikten til meldingslistene (innboks, utboks, osv.)');

// new in 0.5 FRONTEND

DEFINE ('_UDDEIM_SHOWUSERS', 'Vis brukere');
DEFINE ('_UDDEIM_CONNECTIONS', 'Forbindelser');
DEFINE ('_UDDEIM_SETTINGS', 'Innstillinger');
DEFINE ('_UDDEIM_NOSETTINGS', 'Det er ingen innstillinger � justere.');
DEFINE ('_UDDEIM_ABOUT', 'Om'); // as in "About uddeIM"
DEFINE ('_UDDEIM_COMPOSE', 'Skriv'); // as in "write new message", but only one word
DEFINE ('_UDDEIM_EMN', 'E-postp�minnelse');
DEFINE ('_UDDEIM_EMN_EXP', 'Motta en E-post p�minnelse for nye private meldinger.');
DEFINE ('_UDDEIM_EMN_ALWAYS', 'E-post p�minnelse for nye meldinger');
DEFINE ('_UDDEIM_EMN_NONE', 'Ingen E-post p�minnelse');
DEFINE ('_UDDEIM_EMN_WHENOFFLINE', 'E-post p�minnelse n�r frakoblet');
DEFINE ('_UDDEIM_EMN_NOTONREPLY', 'Ikke send p�minnelse av svar');
DEFINE ('_UDDEIM_BLOCKSYSTEM', 'Brukerblokkering'); // Headline for blocking system in settings
DEFINE ('_UDDEIM_BLOCKSYSTEM_EXP', 'Du kan forhindre brukere fra � sende deg meldinger med � blokkere de. Velg <b>blokker bruker</b> n�r du leser en melding fra brukeren.'); // block user is the same as _UDDEIM_BLOCKNOW
DEFINE ('_UDDEIM_SAVECHANGE', 'Lagre forandringer');
DEFINE ('_UDDEIM_TOOLTIP_BOLD', 'BB kodetagger for � lage fet tekst. Bruk: [b]fet[/b]');
DEFINE ('_UDDEIM_TOOLTIP_ITALIC', 'BB kodetagger for � lage skr�stilt tekst. Bruk: [i]italic[/i]');
DEFINE ('_UDDEIM_TOOLTIP_UNDERLINE', 'BB kodetagger for � lage understreking. Bruk: [u]understrek[/u]');
DEFINE ('_UDDEIM_TOOLTIP_COLORRED', 'BB kodetagger for � lage fargede bokstaver. Bruk: [color=#XXXXXX]farge[/color] hvor XXXXXX er hexkoden til fargen du vil bruke, for eksempel FF0000 for r�d farge.');
DEFINE ('_UDDEIM_TOOLTIP_COLORGREEN', 'BB kodetagger for � lage fargede bokstaver. Bruk: [color=#XXXXXX]farge[/color] hvor XXXXXX er hexkoden til fargen du vil bruke, for eksempel 00FF00 for gr�nn farge.');
DEFINE ('_UDDEIM_TOOLTIP_COLORBLUE', 'BB kodetagger for � lage fargede bokstaver. Bruk: [color=#XXXXXX]farge[/color] hvor XXXXXX er hexkoden til fargen du vil bruke, for eksempel 0000FF for bl� farge.');
DEFINE ('_UDDEIM_TOOLTIP_FONTSIZE1', 'BB kodetagger for � lage veldig sm� bokstaver. Bruk: [size=1]veldig liten tekst.[/size]');
DEFINE ('_UDDEIM_TOOLTIP_FONTSIZE2', 'BB kodetagger for � lage sm� bokstaver. Bruk: [size=2] liten tekst.[/size]');
DEFINE ('_UDDEIM_TOOLTIP_FONTSIZE4', 'BB kodetagger for � lage store bokstaver. Bruk: [size=4]stor tekst.[/size]');
DEFINE ('_UDDEIM_TOOLTIP_FONTSIZE5', 'BB kodetagger for � lage veldig store bokstaver. Bruk: [size=5]veldig stor tekst.[/size]');
DEFINE ('_UDDEIM_TOOLTIP_IMAGE', 'BB kodetagger for sette inn en lenke til et bilde. Bruk: [img]Sti (URL) til bildet[/img]');
DEFINE ('_UDDEIM_TOOLTIP_URL', 'BB kodetagger for � sette inn en lenke. Bruk: [url]nettadresse[/url]. Ikke glem http:// i starten p� nettadressen.');
DEFINE ('_UDDEIM_TOOLTIP_CLOSEALLTAGS', 'Steng alle �pne BB kodetagger.');

// *******************************************************************

$udde_smon[1]="Jan";
$udde_smon[2]="Feb";
$udde_smon[3]="Mar";
$udde_smon[4]="Apr";
$udde_smon[5]="Mai";
$udde_smon[6]="Jun";
$udde_smon[7]="Jul";
$udde_smon[8]="Aug";
$udde_smon[9]="Sep";
$udde_smon[10]="Okt";
$udde_smon[11]="Nov";
$udde_smon[12]="Des";

$udde_lmon[1]="Januar";
$udde_lmon[2]="Februar";
$udde_lmon[3]="Mars";
$udde_lmon[4]="April";
$udde_lmon[5]="Mai";
$udde_lmon[6]="Juni";
$udde_lmon[7]="Juli";
$udde_lmon[8]="August";
$udde_lmon[9]="September";
$udde_lmon[10]="Oktober";
$udde_lmon[11]="November";
$udde_lmon[12]="Desember";

$udde_lweekday[0]="S�ndag";
$udde_lweekday[1]="Mandag";
$udde_lweekday[2]="Tirsdag";
$udde_lweekday[3]="Onsdag";
$udde_lweekday[4]="Torsdag";
$udde_lweekday[5]="Fredag";
$udde_lweekday[6]="L�rdag";

$udde_sweekday[0]="S�n";
$udde_sweekday[1]="Man";
$udde_sweekday[2]="Tir";
$udde_sweekday[3]="Ons";
$udde_sweekday[4]="Tor";
$udde_sweekday[5]="Fre";
$udde_sweekday[6]="L�r";

DEFINE ('_UDDEIM_EMN_BODY_PUBLICWITHMESSAGE',
"Hei %user%,\n\n%you% har sendt deg f�lgende private melding fra %site%.\n__________________\n%pmessage%");
DEFINE ('_UDDEIM_EMN_BODY_NOMESSAGE',
"Hei %you%,\n\n%user% har sendt deg en privat melding p� %site%. Logg inn for � lese meldingen!");
DEFINE ('_UDDEIM_EMN_BODY_WITHMESSAGE',
"Hei %you%,\n\n%user% har sendt deg f�lgende private melding p� %site%. Logg inn for � svare!\n__________________\n%pmessage%");
DEFINE ('_UDDEIM_EMN_FORGETMENOT',
"Hei %you%,\n\ndu har uleste meldinger p� %site%. Logg inn for � lese meldingen(e)!");
DEFINE ('_UDDEIM_EXPORT_FORMAT', '
================================================================================
%user% (%msgdate%)
----------------------------------------
%msgbody%
================================================================================');
