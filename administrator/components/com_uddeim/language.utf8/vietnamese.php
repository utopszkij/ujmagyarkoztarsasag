<?php
// *******************************************************************
// Title          udde Instant Messages (uddeIM)
// Description    Instant Messages System for Mambo 4.5 / Joomla 1.0 / Joomla 1.5
// Author         © 2007-2010 Stephan Slabihoud, © 2006 Benjamin Zweifel
// License        This is free software and you may redistribute it under the GPL.
//                uddeIM comes with absolutely no warranty.
//                Use at your own risk. For details, see the license at
//                http://www.gnu.org/licenses/gpl.txt
//                Other licenses can be found in LICENSES folder.
// *******************************************************************
// Tên component: 	udde Instant Messages (uddeIM)
// Tác giả: 		© 2007-2008 Stephan Slabihoud, © 2006 Benjamin Zweifel
// Mô tả: 			Hệ thống nhắn tin nội bộ cho Joomla 1.0, 1.5, Mambo 4.5 tương thích với Community Builder, JomSocial, Kunena
// Bản quyền:		Đây là phần mềm tự do và bạn có thể phân phối lại dưới bản quyền GPL ( http://www.gnu.org/licenses/gpl.txt )
//					Bạn tự chịu trách nhiệm về việc sử dụng phần mềm này và chúng tôi không có bất kì đảm bảo nào đối với việc bạn sử dụng nó.
// Ngôn ngữ(Language): Tiếng Việt(Vietnamese)
// Người dịch(Translator): Bùi Quang Vinh<qvsoft@gmail.com>
// Chú ý(Notice): Bản dịch chỉ gồm các thành phần hiển thị tại FrontEnd(For Frontend Only)
// *******************************************************************
DEFINE ('_UDDEADM_TRANSLATORS_CREDITS', 'Translation by <a href="http://www.J4USolutions.com" target="_new">Bùi Quang Vinh</a>');	// Enter your credits line here, e.g. 'Translation by <a href="http://domain.com" target="_new">John Doe</a>'

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
DEFINE ('_UDDEIM_NOMESSAGES3_FILTERED', '<b>Bạn không có tin nhắn đã được lọc trong %s.</b>');
DEFINE ('_UDDEIM_FILTER_UNREAD', 'chưa đọc');
DEFINE ('_UDDEIM_FILTER_FLAGGED', 'đánh dấu cờ');
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
DEFINE ('_UDDEIM_PROCESSING', 'Đang xử lý...');
DEFINE ('_UDDEIM_SEND_NONOTIFY', 'Không gửi email thông báo');
DEFINE ('_UDDEIM_SYSGM_NONOTIFY', 'Email thông báo sẽ không được gửi');
DEFINE ('_UDDEIM_SYSGM_FORCEEMBEDDED', 'Nội dung sẽ được gửi kèm trong email thông báo');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_8', '...set default for thumbnails');
DEFINE ('_UDDEADM_AVATARWH_HEAD', 'Display size of thumbnails');
DEFINE ('_UDDEADM_AVATARWH_EXP', 'Width and height (in pixels) of thumbnails (0 = size will not be changed).');
DEFINE ('_UDDEIM_SAVE', 'Lưu');

// New: 2.1
DEFINE ('_UDDEIM_BODY_SPAMREPORT',
"Hi %you%,\n\n%touser% đã báo cáo tin nhắn spam từ %fromuser%. Vui lòng đăng nhập để kiểm tra!\n\n%livesite%");
DEFINE ('_UDDEIM_SUBJECT_SPAMREPORT', 'Một tin nhắn đã bị báo cáo tại %site%');
DEFINE ('_UDDEADM_KBYTES', 'KByte');
DEFINE ('_UDDEADM_MBYTES', 'MByte');
DEFINE ('_UDDEIM_ATT_FILEDELETED', 'Đã xóa file');
DEFINE ('_UDDEIM_ATT_FILENOTEXISTS', 'Lỗi: File không tồn tại');
DEFINE ('_UDDEIM_ATTACHMENTS2', 'Đính kèm (Tối đa. %s / file):');
DEFINE ('_UDDEADM_JOOCM', 'Joo!CM');
DEFINE ('_UDDEADM_UNPROTECTATTACHMENT_HEAD', 'Unprotected file downloads');
DEFINE ('_UDDEADM_UNPROTECTATTACHMENT_EXP', 'Usually uddeIM does not disclose the server path of file attachments, so nobody - even when the filename is known - can download the file. Enabling this option forces uddeIM to return the full server path. For security reasons, uddeIM added a MD5 hash to the original file name. Users can download the file directly when the full path is known. Do only use with care! READ THE FAQ WHEN USING THIS OPTION!');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_7', '...set default for file attachments, public frontend');
DEFINE ('_UDDEIM_FILETYPE_NOTALLOWED', 'Định dạng file không được phép');
DEFINE ('_UDDEADM_ALLOWEDEXTENSIONS_HEAD', 'Extensions allowed');
DEFINE ('_UDDEADM_ALLOWEDEXTENSIONS_EXP', 'Enter all extensions allowed (separated by ";"). Leave blank for no restrictions.');
DEFINE ('_UDDEADM_PUBEMAIL_HEAD', 'Email required');
DEFINE ('_UDDEADM_PUBEMAIL_EXP', 'When enabled a public user has to enter an email address.');
DEFINE ('_UDDEADM_WAITDAYS_HEAD', 'Days to wait');
DEFINE ('_UDDEADM_WAITDAYS_EXP', 'Specify how many days a user must wait until he is allowed to send messages (for 3 hours enter 0.125).');
DEFINE ('_UDDEIM_WAITDAYS1', 'Bạn phải đợi ');
DEFINE ('_UDDEIM_WAITDAYS2', ' ngày để có thể gửi tin nhắn.');
DEFINE ('_UDDEIM_WAITDAYS2H', ' giờ để có thể gửi tin nhắn.');

// New: 2.0
DEFINE ('_UDDEADM_RECAPTCHAPRV_HEAD', 'reCaptcha private key');
DEFINE ('_UDDEADM_RECAPTCHAPRV_EXP', 'When you want to use reCaptcha, enter your private key here.');
DEFINE ('_UDDEADM_RECAPTCHAPUB_HEAD', 'reCaptcha public key');
DEFINE ('_UDDEADM_RECAPTCHAPUB_EXP', 'When you want to use reCaptcha, enter your public key here.');
DEFINE ('_UDDEADM_CAPTCHA_INTERNAL', 'Internal');
DEFINE ('_UDDEADM_CAPTCHA_RECAPTCHA', 'reCaptcha');
DEFINE ('_UDDEADM_CAPTCHATYPE_HEAD', 'Captcha service');
DEFINE ('_UDDEADM_CAPTCHATYPE_EXP', 'Which captcha service do you want to use: The build-in service or reCaptcha (see <a href="http://recaptcha.net" target="_new">reCaptcha</a> for more information)?');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_6', '...set default for captcha service');
DEFINE ('_UDDEADM_AUP', 'AlphaUserPoints');
DEFINE ('_UDDEADM_CHECKFILESFOLDER', 'Please move <i>\uddeimfiles</i> to <i>\images\uddeimfiles</i>. Check the documentation!');
DEFINE ('_UDDEADM_CRYPT4', 'Strong encryption');
DEFINE ('_UDDEADM_ALLOWTOALL2_HEAD', 'Allow sending system messages');
DEFINE ('_UDDEADM_ALLOWTOALL2_EXP', 'uddeIM supports system messages. They are sent to all users on your system. Use them sparingly.');
DEFINE ('_UDDEADM_ALLOWTOALL2_0', 'disabled');
DEFINE ('_UDDEADM_ALLOWTOALL2_1', 'admins only');
DEFINE ('_UDDEADM_ALLOWTOALL2_2', 'admins and managers');

// New: 1.9
DEFINE ('_UDDEIM_FILEUPLOAD_FAILED', 'Lỗi upload file');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_5', '...set default for file attachments');
DEFINE ('_UDDEADM_ENABLEATTACHMENT_HEAD', 'Enable file attachments');
DEFINE ('_UDDEADM_ENABLEATTACHMENT_EXP', 'This enables sending file attachments for all registered users or admins only.');
DEFINE ('_UDDEADM_MAXSIZEATTACHMENT_HEAD', 'Max. file size');
DEFINE ('_UDDEADM_MAXSIZEATTACHMENT_EXP', 'Maximum file size allowed for file attachments.');
DEFINE ('_UDDEIM_FILESIZE_EXCEEDED', 'Vượt quá số lượng file tối đa cho phép');
DEFINE ('_UDDEADM_BYTES', 'Bytes');
DEFINE ('_UDDEADM_MAXATTACHMENTS_HEAD', 'Max. attachments');
DEFINE ('_UDDEADM_MAXATTACHMENTS_EXP', 'Maximum number of attachments per message.');
DEFINE ('_UDDEIM_DOWNLOAD', 'Tải xuống');
DEFINE ('_UDDEADM_FILEADMINIGNITIONONLY_HEAD', 'File deletions invoked');
DEFINE ('_UDDEADM_FILEADMINIGNITIONONLY_YES', 'by admins only');
DEFINE ('_UDDEADM_FILEADMINIGNITIONONLY_NO', 'by any user');
DEFINE ('_UDDEADM_FILEADMINIGNITIONONLY_MANUALLY', 'manually');
DEFINE ('_UDDEADM_FILEADMINIGNITIONONLY_EXP', 'Automatic deletions create heavy server load. If you choose <b>by admins only</b> automatic deletions are invoked when an admin checks his inbox. Choose this option if an admin is checking the inbox regulary. Small or rarely administered sites may choose <b>by any user</b>.');
DEFINE ('_UDDEADM_FILEMAINTENANCE_PRUNE', 'Prune files now');
DEFINE ('_UDDEADM_FILEMAINTENANCEDEL_HEAD', 'Invoke file erasing');
DEFINE ('_UDDEADM_FILEMAINTENANCEDEL_EXP', 'Removes deleted files from the database. This is the same as \'Prune files now\' on the system tab.');
DEFINE ('_UDDEADM_FILEMAINTENANCEDEL_ERASE', 'ERASE');
DEFINE ('_UDDEIM_ATTACHMENTS', 'Đính kèm (Tối đa: %u bytes trên một file):');
DEFINE ('_UDDEADM_MAINTENANCE_F1', 'Orphaned attachments stored in filesystem: ');
DEFINE ('_UDDEADM_MAINTENANCE_F2', 'Deleting orphaned files');
DEFINE ('_UDDEADM_BACKUP_DONE', 'Backup configuration done.');
DEFINE ('_UDDEADM_RESTORE_DONE', 'Restore configuration done.');
DEFINE ('_UDDEADM_PRUNE_DONE', 'Message pruning done.');
DEFINE ('_UDDEADM_FILEPRUNE_DONE', 'File attachment pruning done.');
DEFINE ('_UDDEADM_FOLDERCREATE_ERROR', 'Error creating folder: ');
DEFINE ('_UDDEADM_ATTINSTALL_WRITEFAILED', 'Error creating file: ');
DEFINE ('_UDDEADM_ATTINSTALL_IGNORE', 'You can ignore this error when you do not own the File attachments premium plugin (see FAQ).');
DEFINE ('_UDDEADM_ATTACHMENTGROUPS_HEAD', 'Allowed groups');
DEFINE ('_UDDEADM_ATTACHMENTGROUPS_EXP', 'Groups which are allowed to send file attachments.');
DEFINE ('_UDDEIM_SELECT', 'Chọn');
DEFINE ('_UDDEIM_ATTACHMENT', 'Đính kèm');
DEFINE ('_UDDEADM_SHOWLISTATTACHMENT_HEAD', 'Show attachment icons');
DEFINE ('_UDDEADM_SHOWLISTATTACHMENT_EXP', 'Show attachment icons in the message lists (inbox, outbox, archive).');
DEFINE ('_UDDEIM_HELP_ATTACHMENT', 'Tin nhắn bao gồm 1 file đính kèm.');
DEFINE ('_UDDEADM_MAINTENANCE_COUNTFILES', 'File references in database:');
DEFINE ('_UDDEADM_MAINTENANCE_COUNTFILESDISTINCT', 'File attachments stored:');
DEFINE ('_UDDEADM_SHOWMENUCOUNT_HEAD', 'Show counters');
DEFINE ('_UDDEADM_SHOWMENUCOUNT_EXP', 'When set to <b>yes</b>, the menu bar contains message counters. Note: This will require several additional database queries so do not use on weak systems.');
DEFINE ('_UDDEADM_CONFIG_FTPLAYER', 'Configuration (access with FTP layer):');
DEFINE ('_UDDEADM_ENCODEHEADER_HEAD', 'Encode mail headers');
DEFINE ('_UDDEADM_ENCODEHEADER_EXP', 'Set to <b>yes</b>, when mail headers (like the subject) should be rfc 2047 encoded. Useful when you have problems with special characters.');
DEFINE ('_UDDEIM_UP', 'sắp xếp tăng dần');
DEFINE ('_UDDEIM_DOWN', 'sắp xếp giảm dần');
DEFINE ('_UDDEIM_UPDOWN', 'Sắp xếp');
DEFINE ('_UDDEADM_ENABLESORT_HEAD', 'Enable sorting');
DEFINE ('_UDDEADM_ENABLESORT_EXP', 'Set to <b>yes</b>, when the user should be able to sort the inbox, outbox and archive (creates additional load on the database server).');

// New: 1.8
// %s will be replaced by _UDDEIM_NOMESSAGES_FILTERED_INBOX, _UDDEIM_NOMESSAGES_FILTERED_OUTBOX, _UDDEIM_NOMESSAGES_FILTERED_ARCHIVE
// Translators help: When having problems with the grammar, you can also move some text (e.g. "in your") to _UDDEIM_NOMESSAGES_FILTERED_* variables, e.g.
// instead of "_UDDEIM_NOMESSAGES_FILTERED_INBOX=inbox" you can also use "_UDDEIM_NOMESSAGES_FILTERED_INBOX=in your inbox"
DEFINE ('_UDDEIM_NOMESSAGES2_FR_FILTERED', '<b>Bạn không có tin nhắn từ thành viên này trong%s.</b>');
DEFINE ('_UDDEIM_NOMESSAGES2_TO_FILTERED', '<b>Bạn không có tin nhắn tới thành viên này trong%s.</b>');
DEFINE ('_UDDEIM_NOMESSAGES2_UNFR_FILTERED', '<b>Bạn không có tin nhắn chưa đọc từ thành viên này trong%s.</b>');
DEFINE ('_UDDEIM_NOMESSAGES2_UNTO_FILTERED', '<b>Bạn không có tin nhắn chưa đọc tới thành viên này trong%s.</b>');

// New: 1.7
DEFINE ('_UDDEADM_EMAILSTOPPED', '\'Email stop\' enabled.');
DEFINE ('_UDDEIM_ACCOUNTLOCKED', 'Truy cập vào hộp tin nhắn của bạn đã bị khóa. Vui lòng liên hệ admin để biết lí do.');
DEFINE ('_UDDEADM_USERSET_LOCKED', 'Locked');
DEFINE ('_UDDEADM_USERSET_SELLOCKED', '- Locked -');
DEFINE ('_UDDEADM_CBBANNED_HEAD', 'Check for CB banned users');
DEFINE ('_UDDEADM_CBBANNED_EXP', 'When activated uddeIM checks if a user has been banned in CB and does not allow access to uddeIM. Additionally other users are not able to send messages to a banned user.');
DEFINE ('_UDDEIM_YOUAREBANNED', 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ admin để biết lí do.');
DEFINE ('_UDDEIM_USERBANNED', 'Đã khóa tài khoản thành viên.');
DEFINE ('_UDDEADM_JOOBB', 'Joo!BB');
DEFINE ('_UDDEPLUGIN_SEARCHSECTION', 'Tin nhắn riêng');
DEFINE ('_UDDEPLUGIN_MESSAGES', 'Tin nhắn riêng');
DEFINE ('_UDDEADM_MAINTENANCEDEL_HEAD', 'Invoke message erasing');
// note "This  is the same as _UDDEADM_MAINTENANCE_PRUNE on the system tab."
DEFINE ('_UDDEADM_MAINTENANCEDEL_EXP', 'Removes deleted messages from the database. This is the same as \'Prune messages now\' on the system tab.');
DEFINE ('_UDDEADM_MAINTENANCEDEL_ERASE', 'ERASE');
DEFINE ('_UDDEADM_REPORTSPAM_HEAD', 'Report message link');
DEFINE ('_UDDEADM_REPORTSPAM_EXP', 'When activated this show a \'Report message\' link that allows users to report SPAM to the admin.');
DEFINE ('_UDDEIM_TOOLBAR_REMOVESPAM', 'Xóa tin nhắn');
DEFINE ('_UDDEIM_TOOLBAR_REMOVEREPORT', 'Hủy báo cáo');
DEFINE ('_UDDEIM_TOOLBAR_SPAMCONTROL', 'Cấu hình báo cáo');
DEFINE ('_UDDEADM_INFORMATION', 'Information');
DEFINE ('_UDDEADM_SPAMCONTROL_STAT', 'Reported messages:');
DEFINE ('_UDDEADM_SPAMCONTROL_TRASHED', 'Trashed');
DEFINE ('_UDDEADM_SPAMCONTROL_NOTEDEL', 'Delete this message from database?');
DEFINE ('_UDDEADM_SPAMCONTROL_NOTEREMOVE', 'Remove this report?');
DEFINE ('_UDDEADM_SPAMCONTROL_SHOWHIDE', 'Show/Hide');
DEFINE ('_UDDEADM_SPAMCONTROL_EDIT', 'Report Control Center');
DEFINE ('_UDDEADM_SPAMCONTROL_FROM', 'From');
DEFINE ('_UDDEADM_SPAMCONTROL_TO', 'To');
DEFINE ('_UDDEADM_SPAMCONTROL_TEXT', 'Message');
DEFINE ('_UDDEADM_SPAMCONTROL_DELETE', 'Delete');
DEFINE ('_UDDEADM_SPAMCONTROL_REMOVE', 'Remove');
DEFINE ('_UDDEADM_SPAMCONTROL_DATE', 'Date');
DEFINE ('_UDDEADM_SPAMCONTROL_REPORTED', 'Reported');
DEFINE ('_UDDEIM_SPAMCONTROL_REPORT', 'Báo cáo spam');
DEFINE ('_UDDEIM_SPAMCONTROL_MARKED', 'Đã báo cáo');
DEFINE ('_UDDEIM_SPAMCONTROL_UNREPORT', 'Hủy báo cáo');
DEFINE ('_UDDEADM_JOMSOCIAL', 'JomSocial');
DEFINE ('_UDDEADM_KUNENA', 'Kunena');
DEFINE ('_UDDEADM_ADMIN_FILTER', 'Filter');
DEFINE ('_UDDEADM_ADMIN_DISPLAY', 'Display #');
DEFINE ('_UDDEADM_TRASHORIGINALSENT_HEAD', 'Trash sent message');
DEFINE ('_UDDEADM_TRASHORIGINALSENT_EXP', 'When activated this will put a checkbox next to the \'Send\' button called \'trash message\' that is not checked by default. Users can check the box if they want to trash a message immediatly after sending it.');
DEFINE ('_UDDEIM_TRASHORIGINALSENT', 'xóa tin nhắn');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_4', '...set default for delete sent message, report spam, CB banned users');
DEFINE ('_UDDEADM_VERSIONCHECK_IMPORTANT', 'Important links:');
DEFINE ('_UDDEADM_VERSIONCHECK_HOTFIX', 'Hotfix');
DEFINE ('_UDDEADM_VERSIONCHECK_NONE', 'None');
DEFINE ('_UDDEADM_MAINTENANCEFIX_HEAD', "Compatibility maintenance");
DEFINE ('_UDDEADM_MAINTENANCEFIX_EXP', "uddeIM uses two XML files to ensure that packages can be installed on Joomla 1.0 and 1.5. On Joomla 1.5 one XML file is not required and this makes the extension manager to show an incompatibilty warning (which is wrong). This removes the unnecessary files, so the warning is not longer displayed.");
DEFINE ('_UDDEADM_MAINTENANCE_FIX', "FIX");
DEFINE ('_UDDEADM_MAINTENANCE_XML1', "Joomla 1.0 and Joomla 1.5 XML installers for uddeIM packages exists.<br />");
DEFINE ('_UDDEADM_MAINTENANCE_XML2', "This is required due to install packages on Joomla 1.0 and Joomla 1.5.<br />");
DEFINE ('_UDDEADM_MAINTENANCE_XML3', "Since it is not required after the installation has been finished, Joomla 1.0 installer can be removed on Joomla 1.5 systems.<br />");
DEFINE ('_UDDEADM_MAINTENANCE_XML4', "This will be done for following packages:<br />");
DEFINE ('_UDDEADM_MAINTENANCE_FXML1', "Unnecessary XML installers for following uddeIM packages will be removed:<br />");
DEFINE ('_UDDEADM_MAINTENANCE_FXML2', "No unnecessary XML installers for uddeIM packages found!<br />");
DEFINE ('_UDDEADM_SHOWMENUICONS1_HEAD', 'Appearance of menu bar');
DEFINE ('_UDDEADM_SHOWMENUICONS1_EXP', 'Here you can configure if the menu bar should be displayed with icons and/or text.');
DEFINE ('_UDDEIM_MENUICONS_P1', 'Biểu tượng và chữ');
DEFINE ('_UDDEIM_MENUICONS_P2', 'Chỉ có biểu tượng');
DEFINE ('_UDDEIM_MENUICONS_P0', 'Chỉ có chữ');
DEFINE ('_UDDEIM_LISTSLIMIT_2', 'Số người nhận tối đa trong danh sách:');
DEFINE ('_UDDEADM_ADDEMAIL_ADMIN', 'Admins can select');
DEFINE ('_UDDEAIM_ADDEMAIL_SELECT', 'Thông báo kèm tin nhắn');
DEFINE ('_UDDEAIM_ADDEMAIL_TITLE', 'Bao gồm toàn bộ tin nhắn trong email thông báo.');

// New: 1.6
DEFINE ('_UDDEIM_NOLISTSELECTED', 'Chưa chọn danh sách liên lạc nào!');
DEFINE ('_UDDEADM_NOPREMIUM', 'Premium plugin not installed');
DEFINE ('_UDDEIM_LISTGLOBAL_CREATOR', 'Người tạo:');
DEFINE ('_UDDEIM_LISTGLOBAL_ENTRIES', 'Số thành viên');
DEFINE ('_UDDEIM_LISTGLOBAL_TYPE', 'Kiểu');
DEFINE ('_UDDEIM_LISTGLOBAL_NORMAL', 'Thông thường');
DEFINE ('_UDDEIM_LISTGLOBAL_GLOBAL', 'Dùng chung');
DEFINE ('_UDDEIM_LISTGLOBAL_RESTRICTED', 'Riêng biệt');
DEFINE ('_UDDEIM_LISTGLOBAL_P0', 'Nhóm thông thường');
DEFINE ('_UDDEIM_LISTGLOBAL_P1', 'Nhóm dùng chung');
DEFINE ('_UDDEIM_LISTGLOBAL_P2', 'Nhóm riêng biệt (chỉ các thành viên trong nhóm mới có thể truy cập)');
DEFINE ('_UDDEIM_TOOLBAR_USERSETTINGS', 'Thiết lập của thành viên');
DEFINE ('_UDDEIM_TOOLBAR_REMOVESETTINGS', 'Xóa thiết lập');
DEFINE ('_UDDEIM_TOOLBAR_CREATESETTINGS', 'Tạo thiết lập');
DEFINE ('_UDDEIM_TOOLBAR_SAVE', 'Lưu');
DEFINE ('_UDDEIM_TOOLBAR_BACK', 'Quay lại');
DEFINE ('_UDDEIM_TOOLBAR_TRASHMSGS', 'Xóa tin nhắn');
DEFINE ('_UDDEIM_CBPLUG_CONT', '[Tiếp tục]');
DEFINE ('_UDDEIM_CBPLUG_UNBLOCKNOW', '[Mở khóa]');
DEFINE ('_UDDEIM_CBPLUG_DOBLOCK', 'Khóa thành viên');
DEFINE ('_UDDEIM_CBPLUG_DOUNBLOCK', 'Mở khóa thành viên');
DEFINE ('_UDDEIM_CBPLUG_BLOCKINGCFG', 'Khóa thành viên');
DEFINE ('_UDDEIM_CBPLUG_BLOCKED', 'Bạn đã khóa thành viên này.');
DEFINE ('_UDDEIM_CBPLUG_UNBLOCKED', 'Thành viên này có thể liên lạc với bạn.');
DEFINE ('_UDDEIM_CBPLUG_NOWBLOCKED', 'Thành viên đã bị khóa.');
DEFINE ('_UDDEIM_CBPLUG_NOWUNBLOCKED', 'Thành viên đã được mở khóa.');
DEFINE ('_UDDEADM_PARTIALIMPORTDONE', 'Partial import of messages from old PMS done. Do not import this part again because doing so will import the messages again and they will show up twice.');
DEFINE ('_UDDEADM_IMPORT_HELP', 'Note: The messages can be imported all at once or in parts. Importing in parts can be necessary when the import dies because of too many messages to import.');
DEFINE ('_UDDEADM_IMPORT_PARTIAL', 'Partial import:');
DEFINE ('_UDDEADM_UPDATEYOURDB', 'Important: You have not updated your database! Please refer to the README how to update uddeIM correctly!');
DEFINE ('_UDDEADM_RESTRALLUSERS_HEAD', 'Restrict "All users" access');
DEFINE ('_UDDEADM_RESTRALLUSERS_EXP', 'You can restrict the access to the "All users" list. Usually the "All users" list is available for all (<i>no restriction</i>).');
DEFINE ('_UDDEADM_RESTRALLUSERS_0', 'no restriction');
DEFINE ('_UDDEADM_RESTRALLUSERS_1', 'special users');
DEFINE ('_UDDEADM_RESTRALLUSERS_2', 'admins only');
DEFINE ('_UDDEIM_MESSAGE_UNARCHIVED', 'Message unarchived.');
DEFINE ('_UDDEADM_AUTOFORWARD_SPECIAL', 'special users');
DEFINE ('_UDDEIM_HELP', 'Trợ giúp');
DEFINE ('_UDDEIM_HELP_HEADLINE1', 'Trợ giúp tin nhắn');
DEFINE ('_UDDEIM_HELP_HEADLINE2', 'Tổng quan');
DEFINE ('_UDDEIM_HELP_INBOX', '<b>Hộp thư đến</b> Giữ tất cả các tin nhắn gửi đến bạn.');
DEFINE ('_UDDEIM_HELP_OUTBOX', '<b>Hộp thư đi</b> Giữ tất cả các tin nhắn mà bạn đã gửi, nó cho phép bạn xem các tin nhắn mà bạn đã gửi.');
DEFINE ('_UDDEIM_HELP_TRASHCAN', '<b>Thùng rác</b> Giữ các tin nhắn đã bị xóa. Tin nhắn bị xóa sẽ lưu trữ trong thùng rác trong một khoảng thời gian xác định. Nếu tin nhắn chưa bị xóa vĩnh viễn, bạn có thể khôi phục lại nó.');
DEFINE ('_UDDEIM_HELP_ARCHIVE', '<b>Lưu trữ</b> Giữ tất cả các tin nhắn lưu trữ trong hộp thư đến. Bạn chỉ có thể lưu trữ tin nhắn từ hộp thư đến. Nếu bạn muốn lưu trữ tin nhắn của chính mình, hãy chọn <i>Gửi một bản sao cho tôi</i> khi bạn gửi tin nhắn.');
DEFINE ('_UDDEIM_HELP_USERLISTS', '<b>Liên hệ</b> cho phép bạn tào danh sách liên hệ. Với sanh sách liên hệ bạn có thể gửi tin nhắn cho nhiều thành viên. Thay vì việc nhập tên nhiều thành viên, bạn chỉ cần nhập <i>#Tên_danh_sách</i>.');
DEFINE ('_UDDEIM_HELP_SETTINGS', '<b>Thiết lập</b> Bao gồm tất cả các tùy chọn của thành viên.');
DEFINE ('_UDDEIM_HELP_COMPOSE', '<b>Soạn tin</b> cho phép bạn tạo tin nhắn mới.');
DEFINE ('_UDDEIM_HELP_IREAD', 'Tin nhắn đã được đọc (Bạn có thể thêm Trạng thái).');
DEFINE ('_UDDEIM_HELP_IUNREAD', 'Tin nhắn vẫn chưa được đọc (Bạn có thể thêm Trạng thái).');
DEFINE ('_UDDEIM_HELP_OREAD', 'Tin nhắn đã được đọc.');
DEFINE ('_UDDEIM_HELP_OUNREAD', 'Tin nhắn vẫn chưa được đọc. Bạn có thể lấy lại các tin nhắn chưa được đọc.');
DEFINE ('_UDDEIM_HELP_TREAD', 'Tin nhắn đã được đọc.');
DEFINE ('_UDDEIM_HELP_TUNREAD', 'Tin nhắn vẫn chưa được đọc.');
DEFINE ('_UDDEIM_HELP_FLAGGED', 'Tin nhắn đã được gắn cờ, e.g. Khi nó là tin nhắn quan trọng (Bạn có thể thêm Trạng thái).');
DEFINE ('_UDDEIM_HELP_UNFLAGGED', 'Tin nhắn <i>thông thường</i> (Bạn có thể thêm Trạng thái).');
DEFINE ('_UDDEIM_HELP_ONLINE', 'Thành viên này đang Online.');
DEFINE ('_UDDEIM_HELP_OFFLINE', 'Thành viên này đang Offline.');
DEFINE ('_UDDEIM_HELP_DELETE', 'Xóa tin nhắn (Chuyển tin nhắn tới thùng rác).');
DEFINE ('_UDDEIM_HELP_FORWARD', 'Chuyển tiếp tin nhắn tới thành viên khác.');
DEFINE ('_UDDEIM_HELP_ARCHIVEMSG', 'Lưu trữ tin nhắn. Tin nhắn lưu trữ sẽ không bị xóa ngay cả khi người quản trị giới hạn thời gian tồn tại của tin nhắn trong hộp thư đến.');
DEFINE ('_UDDEIM_HELP_UNARCHIVEMSG', 'Không lưu trữ tin nhắn. Tin nhắn sẽ được chuyển trở lại hộp thư đến.');
DEFINE ('_UDDEIM_HELP_RECALL', 'Lấy lại tin nhắn. Bạn có thể lấy lại tin nhắn khi người nhận chưa đọc nó.');
DEFINE ('_UDDEIM_HELP_RECYCLE', 'Khôi phục tin nhắn (Chuyển tin nhắn từ thùng rác vào hộp thư đến hoặc hộp thư đi).');
DEFINE ('_UDDEIM_HELP_NOTIFY', 'Cấu hình thông báo qua email khi có tin nhắn mới.');
DEFINE ('_UDDEIM_HELP_AUTORESPONDER', 'Tự động chuyển tiếp cho phép mỗi người nhận được phép trả lời trực tiếp.');
DEFINE ('_UDDEIM_HELP_AUTOFORWARD', 'Tin nhắn mới có thể tự động chuyển tiếp tới thành viên khác.');
DEFINE ('_UDDEIM_HELP_BLOCKING', 'Bạn có thể khóa thành viên. Những thành viên này sẽ không thể gửi tin nhắn tới bạn.');
DEFINE ('_UDDEIM_HELP_MISC', 'Cấu hình thêm');
DEFINE ('_UDDEIM_HELP_FEED', 'Bạn có thể truy nhập vào hộp thư đến qua RSS.');
DEFINE ('_UDDEADM_SEPARATOR_HEAD', 'Separator');
DEFINE ('_UDDEADM_SEPARATOR_EXP', 'Select the separator used for multiple recipients (default is ",").');
DEFINE ('_UDDEADM_SEPARATOR_P0', 'comma (default)');
DEFINE ('_UDDEADM_SEPARATOR_P1', 'semicolon');
DEFINE ('_UDDEADM_RSSLIMIT_HEAD', 'RSS items');
DEFINE ('_UDDEADM_RSSLIMIT_EXP', 'Limit the number of returned RSS items (0 for no limit).');
DEFINE ('_UDDEADM_SHOWHELP_HEAD', 'Show help button');
DEFINE ('_UDDEADM_SHOWHELP_EXP', 'When enabled a help button is displayed.');
DEFINE ('_UDDEADM_SHOWIGOOGLE_HEAD', 'Show iGoogle gadget button');
DEFINE ('_UDDEADM_SHOWIGOOGLE_EXP', 'When enabled an <i>Add to iGoogle</i> button for the uddeIM iGoogle gadget is displayed in the user preferences.');
DEFINE ('_UDDEADM_MOOTOOLS_NONE11', 'do not load MooTools (1.1 is used)');
DEFINE ('_UDDEADM_MOOTOOLS_NONE12', 'do not load MooTools (1.2 is used)');
DEFINE ('_UDDEIM_RSS_INTRO1', 'Bạn có thể truy nhập vào hộp thư đến qua RSS (0.91).');
DEFINE ('_UDDEIM_RSS_INTRO1B', 'Địa chỉ RSS:');
DEFINE ('_UDDEIM_RSS_INTRO2', 'Đây là địa chỉ RSS riêng hiển thị các tin nhắn chưa đọc trong hộp thư đến của bạn. Chỉ có bạn mới được cung cấp địa chỉ này. Không cung cấp địa chỉ này cho người khác nếu không họ có thể truy cập vào và đọc các tin nhắn của bạn.');
DEFINE ('_UDDEIM_RSS_FEED', 'RSS Tin nhắn');
DEFINE ('_UDDEIM_RSS_NOOBJECT', 'Không có thành phần lỗi...');
DEFINE ('_UDDEIM_RSS_USERBLOCKED', 'Thành viên bị khóa...');
DEFINE ('_UDDEIM_RSS_NOTALLOWED', 'Từ chối truy cập...');
DEFINE ('_UDDEIM_RSS_WRONGPASSWORD', 'Sai tên đăng nhập hoặc mật khẩu...');
DEFINE ('_UDDEIM_RSS_NOMESSAGES', 'Không có tin nhắn');
DEFINE ('_UDDEIM_RSS_NONEWMESSAGES', 'Không có tin nhắn mới');
DEFINE ('_UDDEADM_ENABLERSS_HEAD', 'Enable RSS');
DEFINE ('_UDDEADM_ENABLERSS_EXP', 'When this option is enabled, messages can be received via RSS feed. Users will find the required URL in their profile.');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_3', '...set default for RSS, iGoogle, help, separator');
DEFINE ('_UDDEADM_DELETEM_DELETING', 'Deleting messages:');
DEFINE ('_UDDEADM_DELETEM_FROMUSER', 'Deleting messages from user ');
DEFINE ('_UDDEADM_DELETEM_MSGSSENT', '- messages sent: ');
DEFINE ('_UDDEADM_DELETEM_MSGSRECV', '- messages received: ');
DEFINE ('_UDDEIM_PMNAV_THISISARESPONSE', 'Đây là tin nhắn trả lời cho:');
DEFINE ('_UDDEIM_PMNAV_THEREARERESPONSES', 'Trả lời cho:');
DEFINE ('_UDDEIM_PMNAV_DELETED', 'Tin nhắn không có hiệu lực');
DEFINE ('_UDDEIM_PMNAV_EXISTS', 'Chuyển tới tin nhắn');
DEFINE ('_UDDEIM_PMNAV_COPY2ME', '(Copy)');
DEFINE ('_UDDEADM_PMNAV_HEAD', 'Allow navigation');
DEFINE ('_UDDEADM_PMNAV_EXP', 'Shows a navigation bar which allows navigating through a thread.');
DEFINE ('_UDDEADM_MAINTENANCE_ALLDAYS', 'Messages:');
DEFINE ('_UDDEADM_MAINTENANCE_7DAYS', 'Messages in 7 days:');
DEFINE ('_UDDEADM_MAINTENANCE_30DAYS', 'Messages in 30 days:');
DEFINE ('_UDDEADM_MAINTENANCE_365DAYS', 'Messages in 365 days:');
DEFINE ('_UDDEADM_MAINTENANCE_HEAD1', 'Sending reminders to (Forgetmenot: %s days):');
DEFINE ('_UDDEADM_MAINTENANCE_HEAD2', 'In %s days sending reminders to:');
DEFINE ('_UDDEADM_MAINTENANCE_NO', 'No:');
DEFINE ('_UDDEADM_MAINTENANCE_USERID', 'User ID:');
DEFINE ('_UDDEADM_MAINTENANCE_TONAME', 'Name:');
DEFINE ('_UDDEADM_MAINTENANCE_MID', 'Message ID:');
DEFINE ('_UDDEADM_MAINTENANCE_WRITTEN', 'Written:');
DEFINE ('_UDDEADM_MAINTENANCE_TIMER', 'Timer:');

// New: 1.5
DEFINE ('_UDDEMODULE_ALLDAYS', ' tin nhắn');
DEFINE ('_UDDEMODULE_7DAYS', ' tin nhắn 7 ngày trước đây');
DEFINE ('_UDDEMODULE_30DAYS', ' tin nhắn 30 ngày trước đây');
DEFINE ('_UDDEMODULE_365DAYS', ' tin nhắn 365 ngày trước đây');
DEFINE ('_UDDEADM_EMN_SENDERMAIL_WARNING', '<br /><b>Note:<br />When using mosMail, you have to configure a valid email address!</b>');
DEFINE ('_UDDEIM_FILTEREDMESSAGE', 'tin nhắn đã được lọc');
DEFINE ('_UDDEIM_FILTEREDMESSAGES', 'tin nhắn đã được lọc');
DEFINE ('_UDDEIM_FILTER', 'Bộ lọc:');
DEFINE ('_UDDEIM_FILTER_TITLE_INBOX', 'Chỉ hiển thị từ những thành viên này');
DEFINE ('_UDDEIM_FILTER_TITLE_OUTBOX', 'Chỉ hiển thị tới những thành viên này');
DEFINE ('_UDDEIM_FILTER_UNREAD_ONLY', 'Chỉ các tin chưa đọc');
DEFINE ('_UDDEIM_FILTER_SUBMIT', 'Lọc tin nhắn');
DEFINE ('_UDDEIM_FILTER_ALL', '- Tất cả -');
DEFINE ('_UDDEIM_FILTER_PUBLIC', '- Thành viên khác -');
DEFINE ('_UDDEADM_FILTER_HEAD', 'Enable filtering');
DEFINE ('_UDDEADM_FILTER_EXP', 'If enabled users can filter their in/outbox to show only one recipient or sender.');
DEFINE ('_UDDEADM_FILTER_P0', 'disabled');
DEFINE ('_UDDEADM_FILTER_P1', 'above message list');
DEFINE ('_UDDEADM_FILTER_P2', 'below message list');
DEFINE ('_UDDEADM_FILTER_P3', 'above and below the list');
DEFINE ('_UDDEIM_NOMESSAGES_FILTERED', '<b>Bạn có %s tin nhắn%s trong%s.</b>');	// see next also six lines
DEFINE ('_UDDEIM_NOMESSAGES_FILTERED_UNREAD', ' Chưa đọc');
DEFINE ('_UDDEIM_NOMESSAGES_FILTERED_FROM', ' từ thành viên này');
DEFINE ('_UDDEIM_NOMESSAGES_FILTERED_TO', ' tới thành viên này');
DEFINE ('_UDDEIM_NOMESSAGES_FILTERED_INBOX', ' thư đến');
DEFINE ('_UDDEIM_NOMESSAGES_FILTERED_OUBOX', ' thư đi');
DEFINE ('_UDDEIM_NOMESSAGES_FILTERED_ARCHIVE', ' lưu trữ');
DEFINE ('_UDDEIM_TODP_TITLE', 'Người nhận');
DEFINE ('_UDDEIM_TODP_TITLE_CC', 'Một hoặc nhiều người nhận (Cách nhau bởi dấu phẩy)');
DEFINE ('_UDDEIM_ADDCCINFO_TITLE', 'When checked a line containing all recipients will be added to the message.');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_2', '...set default for autoresponder, autoforwarding, inputbox, filter');
DEFINE ('_UDDEADM_AUTORESPONDER_HEAD', 'Enable Autoresponder');
DEFINE ('_UDDEADM_AUTORESPONDER_EXP', 'When the autoresponder is enabled the user can enable an autoresponder notification in the personal user settings.');
DEFINE ('_UDDEIM_EMN_AUTORESPONDER', 'Bật trả lời tự động');
DEFINE ('_UDDEIM_AUTORESPONDER', 'Tự động trả lời');
DEFINE ('_UDDEIM_AUTORESPONDER_EXP', 'Chế độ tự động trả lời cho phép bạn trả lời các tin nhắn đến với nội dung định trước.');
DEFINE ('_UDDEIM_AUTORESPONDER_DEFAULT', "Xin lỗi, hiện tại mình không online.\nMình sẽ trả lời tin nhắn của bạn ngay khi mình online.");
DEFINE ('_UDDEADM_USERSET_AUTOR', 'AutoR');
DEFINE ('_UDDEADM_USERSET_SELAUTOR', '- AutoR -');
DEFINE ('_UDDEIM_USERBLOCKED', 'Thành viên bị khóa.');
DEFINE ('_UDDEADM_AUTOFORWARD_HEAD', 'Enable Autoforwarding');
DEFINE ('_UDDEADM_AUTOFORWARD_EXP', 'When the autoforwarding is enabled the user can forward new messages to another user automatically.');
DEFINE ('_UDDEIM_EMN_AUTOFORWARD', 'Bật tự động chuyển tiếp');
DEFINE ('_UDDEADM_USERSET_AUTOF', 'AutoF');
DEFINE ('_UDDEADM_USERSET_SELAUTOF', '- AutoF -');
DEFINE ('_UDDEIM_AUTOFORWARD', 'Tự động chuyển tiếp');
DEFINE ('_UDDEIM_AUTOFORWARD_EXP', 'Tin nhắn gửi tới bạn sẽ được tự động chuyển tới thành viên được chọn.');
DEFINE ('_UDDEIM_THISISAFORWARD', 'Tin nhắn tự động chuyển tiếp từ ');
DEFINE ('_UDDEADM_COLSROWS_HEAD', 'Message box (cols/rows)');
DEFINE ('_UDDEADM_COLSROWS_EXP', 'This specifies the columns and rows of the message box (default values are 60/10).');
DEFINE ('_UDDEADM_WIDTH_HEAD', 'Message box (width)');
DEFINE ('_UDDEADM_WIDTH_EXP', 'This specifies the width of the message box in px (default is 0). If this value is 0, the width specified in the CSS style is used.');
DEFINE ('_UDDEADM_CBE', 'CB Enhanced');

// New: 1.4
DEFINE ('_UDDEADM_IMPORT_CAPS', 'IMPORT');

// New: 1.3
DEFINE ('_UDDEADM_MOOTOOLS_HEAD', 'Load MooTools');
DEFINE ('_UDDEADM_MOOTOOLS_EXP', 'This specifies how uddeIM loads MooTools (MooTools is required for Autocompleter): <i>None</i> is useful when your template loads MooTools, <i>Auto</i> is the recommended default (same behavior as in uddeIM 1.2), when using J1.0 you can also force loading MooTools 1.1 or 1.2.');
DEFINE ('_UDDEADM_MOOTOOLS_NONE', 'do not load MooTools');
DEFINE ('_UDDEADM_MOOTOOLS_AUTO', 'auto');
DEFINE ('_UDDEADM_MOOTOOLS_1', 'force loading MooTools 1.1');
DEFINE ('_UDDEADM_MOOTOOLS_2', 'force loading MooTools 1.2');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_1', '...setting default for MooTools');
DEFINE ('_UDDEADM_AGORA', 'Agora');

// New: 1.2
DEFINE ('_UDDEADM_CRYPT3', 'Base64 encoded');
DEFINE ('_UDDEADM_TIMEZONE_HEAD', 'Adjust timezone');
DEFINE ('_UDDEADM_TIMEZONE_EXP', 'When uddeIM shows the wrong time you can adjust the timezone setting here. Usually, when everything is configured correctly, this should be zero. Nevertheless there might be cases you need to change this value.');
DEFINE ('_UDDEADM_HOURS', 'hours');
DEFINE ('_UDDEADM_VERSIONCHECK', 'Version information:');
DEFINE ('_UDDEADM_STATISTICS', 'Statistics:');
DEFINE ('_UDDEADM_STATISTICS_HEAD', 'Show statistics');
DEFINE ('_UDDEADM_STATISTICS_EXP', 'This displays some statistics like number of stored messages etc.');
DEFINE ('_UDDEADM_STATISTICS_CHECK', 'SHOW STATISTICS');
DEFINE ('_UDDEADM_MAINTENANCE_COUNT', 'Messages stored in database: ');
DEFINE ('_UDDEADM_MAINTENANCE_COUNT_RECIPIENT', 'Messages trashed by recipient: ');
DEFINE ('_UDDEADM_MAINTENANCE_COUNT_SENDER', 'Messages trashed by sender: ');
DEFINE ('_UDDEADM_MAINTENANCE_COUNT_TRASH', 'Messages on hold for purging: ');
DEFINE ('_UDDEADM_OVERWRITEITEMID_HEAD', 'Overwrite Itemid');
DEFINE ('_UDDEADM_OVERWRITEITEMID_EXP', 'Usually uddeIM tries to detect the correct Itemid when it is not set. In some cases it might be necessary to overwrite this value, e.g. when you use several menu links to uddeIM.');
DEFINE ('_UDDEADM_OVERWRITEITEMID_CURRENT', 'Detected Itemid is: ');
DEFINE ('_UDDEADM_USEITEMID_HEAD', 'Use Itemid');
DEFINE ('_UDDEADM_USEITEMID_EXP', 'Use this Itemid instead of the detected one.');
DEFINE ('_UDDEADM_SHOWLINK_HEAD', 'Use profile links');
DEFINE ('_UDDEADM_SHOWLINK_EXP', 'When set to <i>yes</i>, all usernames showing up in uddeIM will be displayed as links to the user profile.');
DEFINE ('_UDDEADM_SHOWPIC_HEAD', 'Show thumbnails');
DEFINE ('_UDDEADM_SHOWPIC_EXP', 'When set to <i>yes</i>, the thumbnail of the respective user will be displayed when reading a message.');
DEFINE ('_UDDEADM_THUMBLISTS_HEAD', 'Show thumbnails in lists');
DEFINE ('_UDDEADM_THUMBLISTS_EXP', 'Set to <i>yes</i> if you want to display thumbnails of users in the message lists overview (inbox, outbox, etc.)');
DEFINE ('_UDDEADM_FIREBOARD', 'Fireboard');
DEFINE ('_UDDEADM_CB', 'Community Builder');
DEFINE ('_UDDEADM_DISABLED', 'Disabled');
DEFINE ('_UDDEADM_ENABLED', 'Enabled');
DEFINE ('_UDDEIM_STATUS_FLAGGED', 'Quan trọng');
DEFINE ('_UDDEIM_STATUS_UNFLAGGED', '');
DEFINE ('_UDDEADM_ALLOWFLAGGED_HEAD', 'Allow message tagging');
DEFINE ('_UDDEADM_ALLOWFLAGGED_EXP', 'Allows message tagging (uddeIM shows a star in lists which can be highlighted to mark important messages).');
DEFINE ('_UDDEADM_REVIEWUPDATE', 'Important: When you have upgraded uddeIM from an earlier version please check the README. Sometimes you have to add or change database tables or fields!');
DEFINE ('_UDDEIM_ADDCCINFO', 'Thêm đồng gửi');
DEFINE ('_UDDEIM_CC', 'Đồng gửi:');
DEFINE ('_UDDEADM_TRUNCATE_HEAD', 'Truncate quoted text');
DEFINE ('_UDDEADM_TRUNCATE_EXP', 'Truncate quoted text to 2/3 of the maximum text length if it exceeds this limit.');
DEFINE ('_UDDEIM_PLUG_INBOXENTRIES', 'Thư đến ');
DEFINE ('_UDDEIM_PLUG_LAST', 'Tiếp ');
DEFINE ('_UDDEIM_PLUG_ENTRIES', ' thư');
DEFINE ('_UDDEIM_PLUG_STATUS', 'Tình trạng');
DEFINE ('_UDDEIM_PLUG_SENDER', 'Người gửi');
DEFINE ('_UDDEIM_PLUG_MESSAGE', 'Tin nhắn');
DEFINE ('_UDDEIM_PLUG_EMPTYINBOX', 'Xóa hết');

// New: 1.1
DEFINE ('_UDDEADM_NOTRASHACCESS_NOT', 'Access to trashcan not allowed.');
DEFINE ('_UDDEADM_NOTRASHACCESS_HEAD', 'Restrict trashcan access');
DEFINE ('_UDDEADM_NOTRASHACCESS_EXP', 'You can restrict the access to the trashcan. Usually the trashcan is available for all (<i>no restriction</i>). You can restrict the access to special users or to admins only, so groups with lower access rights cannot recycle a message.');
DEFINE ('_UDDEADM_NOTRASHACCESS_0', 'no restriction');
DEFINE ('_UDDEADM_NOTRASHACCESS_1', 'special users');
DEFINE ('_UDDEADM_NOTRASHACCESS_2', 'admins only');
DEFINE ('_UDDEADM_PUBHIDEUSERS_HEAD', 'Hide users from userlist');
DEFINE ('_UDDEADM_PUBHIDEUSERS_EXP', 'Enter user IDs which should be hidden from public userlist (e.g. 65,66,67).');
DEFINE ('_UDDEADM_HIDEUSERS_HEAD', 'Hide users from userlist');
DEFINE ('_UDDEADM_HIDEUSERS_EXP', 'Enter user IDs which should be hidden from userlist (e.g. 65,66,67). Admins will always see the complete list.');
DEFINE ('_UDDEIM_ERRORCSRF', 'CSRF attack recognized');
DEFINE ('_UDDEADM_CSRFPROTECTION_HEAD', 'CSRF protection');
DEFINE ('_UDDEADM_CSRFPROTECTION_EXP', 'This protects all forms against Cross-Site Request Forgery attacks. Usually this should be enabled. Only when you have strange problems switch it off.');
DEFINE ('_UDDEIM_CANTREPLYARCHIVE', 'Bạn không thể trả lời tin nhắn lưu trữ.');
DEFINE ('_UDDEIM_COULDNOTRECALLPUBLIC', 'Không thể khôi phục tin nhắn trả lời tới thành viên chưa đăng kí.');
DEFINE ('_UDDEADM_PUBREPLYS_HEAD', 'Allow replies');
DEFINE ('_UDDEADM_PUBREPLYS_EXP', 'Allow direct replies to messages from public users.');
DEFINE ('_UDDEIM_EMN_BODY_PUBLICWITHMESSAGE',
"Chào %user%,\n\n%you% đã gửi tin nhắn cho bạn tại %site%.\n__________________\n%pmessage%");
DEFINE ('_UDDEADM_PUBNAMESTEXT', 'Show realnames');
DEFINE ('_UDDEADM_PUBNAMESDESC', 'Show realnames or usernames in public frontend?');
DEFINE ('_UDDEIM_USERLIST', 'Danh sách');
DEFINE ('_UDDEIM_YOUHAVETOWAIT', 'Xin lỗi, bạn phải chờ trước khi có thể gửi tin nhắn tiếp theo');
DEFINE ('_UDDEADM_USERSET_LASTSENT', 'Last sent');
DEFINE ('_UDDEADM_TIMEDELAY_HEAD', 'Timedelay');
DEFINE ('_UDDEADM_TIMEDELAY_EXP', 'Time in seconds a user must wait before he can post the next message (0 for no time delay).');
DEFINE ('_UDDEADM_SECONDS', 'seconds');
DEFINE ('_UDDEIM_PUBLICSENT', 'Đã gửi tin nhắn.');
DEFINE ('_UDDEIM_ERRORINFROMNAME', 'Sai tên người gửi');
DEFINE ('_UDDEIM_ERRORINEMAIL', 'Sai địa chỉ email');
DEFINE ('_UDDEIM_YOURNAME', 'Tên bạn:');
DEFINE ('_UDDEIM_YOUREMAIL', 'Email:');
DEFINE ('_UDDEADM_VERSIONCHECK_USING', 'You are using uddeIM ');
DEFINE ('_UDDEADM_VERSIONCHECK_LATEST', 'You are already using the latest version of uddeIM.');
DEFINE ('_UDDEADM_VERSIONCHECK_CURRENT', 'The current version is ');
DEFINE ('_UDDEADM_VERSIONCHECK_INFO', 'Update information:');
DEFINE ('_UDDEADM_VERSIONCHECK_HEAD', 'Check for updates');
DEFINE ('_UDDEADM_VERSIONCHECK_EXP', 'This contacts uddeIM developer website to receive information about the current uddeIM version. Except the uddeIM version you use, no other personal information is transmitted.');
DEFINE ('_UDDEADM_VERSIONCHECK_CHECK', 'CHECK NOW');
DEFINE ('_UDDEADM_VERSIONCHECK_ERROR', 'Unable to receive version information.');
DEFINE ('_UDDEIM_NOSUCHLIST', 'Không tìm thấy nhóm liên lạc!');
DEFINE ('_UDDEIM_LISTSLIMIT_1', 'Vượt quá số người nhận (Tối đa: ');
DEFINE ('_UDDEADM_MAXONLISTS_HEAD', 'Max. number of entries');
DEFINE ('_UDDEADM_MAXONLISTS_EXP', 'Max. number of entries allowed per contact list.');
DEFINE ('_UDDEIM_LISTSNOTENABLED', 'Không cho phép sử dụng nhóm liên lạc');
DEFINE ('_UDDEADM_ENABLELISTS_HEAD', 'Enable contact lists');
DEFINE ('_UDDEADM_ENABLELISTS_EXP', 'uddeIM allows users to create contact lists. These lists can be used to send messages to multiple users. Do not forget to enable multiple recipients when you want to use contact lists.');
DEFINE ('_UDDEADM_ENABLELISTS_0', 'disabled');
DEFINE ('_UDDEADM_ENABLELISTS_1', 'registered users');
DEFINE ('_UDDEADM_ENABLELISTS_2', 'special users');
DEFINE ('_UDDEADM_ENABLELISTS_3', 'admins only');
DEFINE ('_UDDEIM_LISTSNEW', 'Tạo danh sách liên lạc mới');
DEFINE ('_UDDEIM_LISTSSAVED', 'Đã lưu nhóm liên lạc');
DEFINE ('_UDDEIM_LISTSUPDATED', 'Đã cập nhật nhóm liên lạc');
DEFINE ('_UDDEIM_LISTSDESC', 'Mô tả');
DEFINE ('_UDDEIM_LISTSNAME', 'Tên nhóm');
DEFINE ('_UDDEIM_LISTSNAMEWO', 'Tên nhóm(không dấu cách)');
DEFINE ('_UDDEIM_EDITLINK', 'Sửa');
DEFINE ('_UDDEIM_LISTS', 'Liên lạc');
DEFINE ('_UDDEIM_STATUS_READ', 'Đã đọc');
DEFINE ('_UDDEIM_STATUS_UNREAD', 'Chưa đọc');
DEFINE ('_UDDEIM_STATUS_ONLINE', 'Online');
DEFINE ('_UDDEIM_STATUS_OFFLINE', 'Offline');
DEFINE ('_UDDEADM_CBGALLERY_HEAD', 'Show CB gallery pictures');
DEFINE ('_UDDEADM_CBGALLERY_EXP', 'By default uddeIM does only show avatars users have uploaded. When you enable this setting uddeIM does also display pictures from the CB avatars gallery.');
DEFINE ('_UDDEADM_UNBLOCKCB_HEAD', 'Unblock CB connections');
DEFINE ('_UDDEADM_UNBLOCKCB_EXP', 'You can allow messages to recipients when the registered user is on the recipients CB connection list (even when the recipient is in a group which is blocked). This setting is independent from the individual blocking each user can configure when enabled (see settings above).');
DEFINE ('_UDDEIM_GROUPBLOCKED', 'Bạn không được phép gửi tin nhắn tới nhóm này.');
DEFINE ('_UDDEIM_ONEUSERBLOCKS', 'Người nhận đã khóa nick bạn.');
DEFINE ('_UDDEADM_BLOCKGROUPS_HEAD', 'Blocked groups (registered users)');
DEFINE ('_UDDEADM_BLOCKGROUPS_EXP', 'Groups to which registered users are not allowed to send messages to. This is for registered users only. Special users and admins are not affected by this setting. This setting is independent from the individual blocking each user can configure when enabled (see settings above).');
DEFINE ('_UDDEADM_PUBBLOCKGROUPS_HEAD', 'Blocked groups (public users)');
DEFINE ('_UDDEADM_PUBBLOCKGROUPS_EXP', 'Groups to which public users are not allowed to send messages to. This setting is independent from the individual blocking each user can configure when enabled (see settings above). When you block a group, users in this group cannot see the the option to enable the public frontend in their profile settings.');
DEFINE ('_UDDEADM_BLOCKGROUPS_1', 'Public user');
DEFINE ('_UDDEADM_BLOCKGROUPS_2', 'CB connection');
DEFINE ('_UDDEADM_BLOCKGROUPS_18', 'Registered user');
DEFINE ('_UDDEADM_BLOCKGROUPS_19', 'Author');
DEFINE ('_UDDEADM_BLOCKGROUPS_20', 'Editor');
DEFINE ('_UDDEADM_BLOCKGROUPS_21', 'Publisher');
DEFINE ('_UDDEADM_BLOCKGROUPS_23', 'Manager');
DEFINE ('_UDDEADM_BLOCKGROUPS_24', 'Admin');
DEFINE ('_UDDEADM_BLOCKGROUPS_25', 'SuperAdmin');
DEFINE ('_UDDEIM_NOPUBLICMSG', 'Người dùng chỉ chấp nhận tin nhắn từ các thành viên đã đăng kí.');
DEFINE ('_UDDEADM_PUBHIDEALLUSERS_HEAD', 'Hide from public "All users" list');
DEFINE ('_UDDEADM_PUBHIDEALLUSERS_EXP', 'You can hide certain groups to be listed in the public "All users" list. Note: this hides the names only, the users can still receive messages. Users who have not enabled Public Frontend will never be listed in this list.');
DEFINE ('_UDDEADM_HIDEALLUSERS_HEAD', 'Hide from "All users" list');
DEFINE ('_UDDEADM_HIDEALLUSERS_EXP', 'You can hide certain groups to be listed in the "All users" list. Note: this hides the names only, the users can still receive messages.');
DEFINE ('_UDDEADM_HIDEALLUSERS_0', 'none');
DEFINE ('_UDDEADM_HIDEALLUSERS_1', 'superadmins only');
DEFINE ('_UDDEADM_HIDEALLUSERS_2', 'admins only');
DEFINE ('_UDDEADM_HIDEALLUSERS_3', 'special users');
DEFINE ('_UDDEADM_PUBLIC', 'Public');
DEFINE ('_UDDEADM_PUBMODESHOWALLUSERS_HEAD', 'Behavior of "All users" link');
DEFINE ('_UDDEADM_PUBMODESHOWALLUSERS_EXP', 'Choose if the "All users" link should be suppressed in Public Frontend, displayed or if always all users should be shown.');
DEFINE ('_UDDEADM_USERSET_PUBLIC', 'Public Frontend');
DEFINE ('_UDDEADM_USERSET_SELPUBLIC', '- select public -');
DEFINE ('_UDDEIM_OPTIONS_F', 'Cho phép khách gửi tin nhắn');
DEFINE ('_UDDEIM_MSGLIMITREACHED', 'Vượt quá giới hạn tin nhắn!');
DEFINE ('_UDDEIM_PUBLICUSER', 'Khách');
DEFINE ('_UDDEIM_DELETEDUSER', 'Đã xóa thành viên');
DEFINE ('_UDDEADM_CAPTCHALEN_HEAD', 'Captcha length');
DEFINE ('_UDDEADM_CAPTCHALEN_EXP', 'Specifies how many characters a user must enter.');
DEFINE ('_UDDEADM_USECAPTCHA_HEAD', 'Captcha spam protection');
DEFINE ('_UDDEADM_USECAPTCHA_EXP', 'Specify who has to enter a captcha when sending a message');
DEFINE ('_UDDEADM_CAPTCHAF0', 'disabled');
DEFINE ('_UDDEADM_CAPTCHAF1', 'public users only');
DEFINE ('_UDDEADM_CAPTCHAF2', 'public and registered users');
DEFINE ('_UDDEADM_CAPTCHAF3', 'public, registered, special users');
DEFINE ('_UDDEADM_CAPTCHAF4', 'all users (incl. admins)');
DEFINE ('_UDDEADM_PUBFRONTEND_HEAD', 'Enable public frontend');
DEFINE ('_UDDEADM_PUBFRONTEND_EXP', 'When enabled public users can send messages to your registered users (those can specify in their personal settings if they want to use this feature).');
DEFINE ('_UDDEADM_PUBFRONTENDDEF_HEAD', 'Public frontend default');
DEFINE ('_UDDEADM_PUBFRONTENDDEF_EXP', 'This is the default value if a public user is allowed to send a message to a registered user.');
DEFINE ('_UDDEADM_PUBDEF0', 'disabled');
DEFINE ('_UDDEADM_PUBDEF1', 'enabled');
DEFINE ('_UDDEIM_WRONGCAPTCHA', 'Sai mã bảo vệ');

// New: 1.0
DEFINE ('_UDDEADM_NONEORUNKNOWN', 'none or unknown');
DEFINE ('_UDDEADM_DONATE', 'If you like uddeIM and want to support the development please make a small donation.');
// New: 1.0rc2
DEFINE ('_UDDEADM_BACKUPRESTORE_DATE', 'Configuration found in database: ');
DEFINE ('_UDDEADM_BACKUPRESTORE_HEAD', 'Backup and restore configuration');
DEFINE ('_UDDEADM_BACKUPRESTORE_EXP', 'You can backup your configuration to the database and restore it when necessary. This is useful when you update uddeIM or when you want to save a certain configuration because of testing.');
DEFINE ('_UDDEADM_BACKUPRESTORE_BACKUP', 'BACKUP');
DEFINE ('_UDDEADM_BACKUPRESTORE_RESTORE', 'RESTORE');
DEFINE ('_UDDEADM_CANCEL', 'Cancel');
// New: 1.0rc1
DEFINE ('_UDDEADM_LANGUAGECHARSET_HEAD', 'Language file character set');
DEFINE ('_UDDEADM_LANGUAGECHARSET_EXP', 'Usually <b>default</b> (ISO-8859-1) is the correct setting for Joomla 1.0 and <b>UTF-8</b> for Joomla 1.5.');
DEFINE ('_UDDEADM_LANGUAGECHARSET_UTF8', 'UTF-8');
DEFINE ('_UDDEADM_LANGUAGECHARSET_DEFAULT', 'default');
DEFINE ('_UDDEIM_READ_INFO_1', 'Tin nhắn đã đọc sẽ ở trong hộp thư đến trong vòng tối đa ');
DEFINE ('_UDDEIM_READ_INFO_2', ' ngày trước khi tự động bị xóa.');
DEFINE ('_UDDEIM_UNREAD_INFO_1', 'Tin nhắn chưa đọc sẽ ở trong hộp thư đến trong vòng tối đa ');
DEFINE ('_UDDEIM_UNREAD_INFO_2', ' ngày trước khi tự động bị xóa.');
DEFINE ('_UDDEIM_SENT_INFO_1', 'Tin nhắn gửi đi sẽ ở trong hộp thư đi trong vòng tối đa ');
DEFINE ('_UDDEIM_SENT_INFO_2', ' ngày trước khi tự động bị xóa.');
DEFINE ('_UDDEADM_DELETEREADAFTERNOTE_HEAD', 'Show inbox note for read messages');
DEFINE ('_UDDEADM_DELETEREADAFTERNOTE_EXP', 'Show inbox note <i>"Read messages will be deleted after n days"</i>');
DEFINE ('_UDDEADM_DELETEUNREADAFTERNOTE_HEAD', 'Show inbox note for unread messages');
DEFINE ('_UDDEADM_DELETEUNREADAFTERNOTE_EXP', 'Show inbox note <i>"Unread messages will be deleted after n days"</i>');
DEFINE ('_UDDEADM_DELETESENTAFTERNOTE_HEAD', 'Show outbox note for sent messages');
DEFINE ('_UDDEADM_DELETESENTAFTERNOTE_EXP', 'Show outbox note <i>"Sent messages will be deleted after n days"</i>');
DEFINE ('_UDDEADM_DELETETRASHAFTERNOTE_HEAD', 'Show trashcan note for trashed messages');
DEFINE ('_UDDEADM_DELETETRASHAFTERNOTE_EXP', 'Show trashcan note <i>"Trashed messages will be purged after n days"</i>');
DEFINE ('_UDDEADM_DELETESENTAFTER_HEAD', 'Sent messages kept for (days)');
DEFINE ('_UDDEADM_DELETESENTAFTER_EXP', 'Enter the number of days until <b>sent</b> messages will automatically be erased from the outbox.');
DEFINE ('_UDDEIM_SEND_TOALLSPECIAL', 'Gửi tới nhóm thành viên đặc biệt');
DEFINE ('_UDDEIM_SYSGM_WILLSENDTOALLSPECIAL', 'Tin nhắn tới <b>tất cả các thành viên đặc biệt</b>');
DEFINE ('_UDDEADM_USERSET_SELUSERNAME', '- select username -');
DEFINE ('_UDDEADM_USERSET_SELNAME', '- select name -');
DEFINE ('_UDDEADM_USERSET_EDITSETTINGS', 'Edit user settings');
DEFINE ('_UDDEADM_USERSET_EXISTING', 'existing');
DEFINE ('_UDDEADM_USERSET_NONEXISTING', 'non existing');
DEFINE ('_UDDEADM_USERSET_SELENTRY', '- select entry -');
DEFINE ('_UDDEADM_USERSET_SELNOTIFICATION', '- select notification -');
DEFINE ('_UDDEADM_USERSET_SELPOPUP', '- select popup -');
DEFINE ('_UDDEADM_USERSET_USERNAME', 'Username');
DEFINE ('_UDDEADM_USERSET_NAME', 'Name');
DEFINE ('_UDDEADM_USERSET_NOTIFICATION', 'Notification');
DEFINE ('_UDDEADM_USERSET_POPUP', 'Popup');
DEFINE ('_UDDEADM_USERSET_LASTACCESS', 'Last access');
DEFINE ('_UDDEADM_USERSET_NO', 'No');
DEFINE ('_UDDEADM_USERSET_YES', 'Yes');
DEFINE ('_UDDEADM_USERSET_UNKNOWN', 'unknown');
DEFINE ('_UDDEADM_USERSET_WHENOFFLINEEXCEPT', 'When offline (except replies)');
DEFINE ('_UDDEADM_USERSET_ALWAYSEXCEPT', 'Always (except replies)');
DEFINE ('_UDDEADM_USERSET_WHENOFFLINE', 'When offline');
DEFINE ('_UDDEADM_USERSET_ALWAYS', 'Always');
DEFINE ('_UDDEADM_USERSET_NONOTIFICATION', 'No notification');
DEFINE ('_UDDEADM_WELCOMEMSG', "Welcome to uddeIM!\n\nYou have succesfully installed uddeIM.\n\nTry viewing this message with different templates. You can set them in the administration backend of uddeIM.\n\nuddeIM is a project in development. If you find bugs or weaknesses, please write them to me so that we can make uddeIM better together.\n\nGood luck and have fun!");
DEFINE ('_UDDEADM_UDDEINSTCOMPLETE', 'uddeIM installation complete.');
DEFINE ('_UDDEADM_REVIEWSETTINGS', 'Please continue to the administration backend and review the settings.');
DEFINE ('_UDDEADM_REVIEWLANG', 'If you are running the CMS in a character set other than ISO 8859-1 make sure to adjust the settings accordingly.');
DEFINE ('_UDDEADM_REVIEWEMAILSTOP', 'After installation, all uddeIM e-mail traffic (e-mail notifications, fotgetmenot e-mails) is disabled so that no e-mails are sent as long as you are testing. Do not forget to disable "stop e-mail" in the backend when you are finished.');
DEFINE ('_UDDEADM_MAXRECIPIENTS_HEAD', 'Max. recipients');
DEFINE ('_UDDEADM_MAXRECIPIENTS_EXP', 'Max. number of recipients which are allowed per message (0=no limitation)');
DEFINE ('_UDDEIM_TOOMANYRECIPIENTS', 'Quá nhiều người nhận');
DEFINE ('_UDDEIM_STOPPEDEMAIL', 'Không thể gửi email.');
DEFINE ('_UDDEADM_SEARCHINSTRING_HEAD', 'Inside text searching');
DEFINE ('_UDDEADM_SEARCHINSTRING_EXP', 'Autocompleter searches inside the text (otherwise it searches from the beginning only)');
DEFINE ('_UDDEADM_MODESHOWALLUSERS_HEAD', 'Behavior of "All users" link');
DEFINE ('_UDDEADM_MODESHOWALLUSERS_EXP', 'Choose if the "All users" link should be suppressed, displayed or if always all users should be shown.');
DEFINE ('_UDDEADM_MODESHOWALLUSERS_0', 'Suppress "All Users" link');
DEFINE ('_UDDEADM_MODESHOWALLUSERS_1', 'Show "All Users" link');
DEFINE ('_UDDEADM_MODESHOWALLUSERS_2', 'Always show all users');
DEFINE ('_UDDEADM_CONFIGNOTWRITEABLE', 'Configuration is not writeable:');
DEFINE ('_UDDEADM_CONFIGWRITEABLE', 'Configuration is writeable:');
DEFINE ('_UDDEIM_FORWARDLINK', 'Chuyển tiếp');
DEFINE ('_UDDEIM_RECIPIENTFOUND', 'người nhận');
DEFINE ('_UDDEIM_RECIPIENTSFOUND', 'người nhận');
DEFINE ('_UDDEADM_MAILSYSTEM_MOSMAIL', 'mosMail');
DEFINE ('_UDDEADM_MAILSYSTEM_PHPMAIL', 'php mail (default)');
DEFINE ('_UDDEADM_MAILSYSTEM_HEAD', 'Mailsystem');
DEFINE ('_UDDEADM_MAILSYSTEM_EXP', 'Select mailsystem uddeIM should use to send notifications.');
DEFINE ('_UDDEADM_SHOWGROUPS_HEAD', 'Show Joomla groups');
DEFINE ('_UDDEADM_SHOWGROUPS_EXP', 'Show Joomla groups in general message list.');
DEFINE ('_UDDEADM_ALLOWFORWARDS_HEAD', 'Forwarding of messages');
DEFINE ('_UDDEADM_ALLOWFORWARDS_EXP', 'Allow forwarding of messages.');
DEFINE ('_UDDEIM_FWDFROM', 'Tin nhắn gốc từ');
DEFINE ('_UDDEIM_FWDTO', 'chuyển tiếp tới');

// New: 0.9+
DEFINE ('_UDDEIM_UNARCHIVE', 'Hủy lưu trữ');
DEFINE ('_UDDEIM_CANTUNARCHIVE', 'Không thể hủy lưu trữ tin nhắn');
DEFINE ('_UDDEADM_ALLOWMULTIPLERECIPIENTS_HEAD', 'Allow multiple recipients');
DEFINE ('_UDDEADM_ALLOWMULTIPLERECIPIENTS_EXP', 'Allow multiple recipients (comma separated).');
DEFINE ('_UDDEIM_CHARSLEFT', 'kí tự còn lại');
DEFINE ('_UDDEADM_SHOWTEXTCOUNTER_HEAD', 'Show text counter');
DEFINE ('_UDDEADM_SHOWTEXTCOUNTER_EXP', 'Shows a text counter which displays how many characters are left.');
DEFINE ('_UDDEIM_CLEAR', 'Xóa hết');
DEFINE ('_UDDEADM_ALLOWMULTIPLEUSER_HEAD', 'Append selected users to recipients');
DEFINE ('_UDDEADM_ALLOWMULTIPLEUSER_EXP', 'This allows selection of multiple recipients from "All users" list.');
DEFINE ('_UDDEADM_CBALLOWMULTIPLEUSER_HEAD', 'Append selected connections to recipients');
DEFINE ('_UDDEADM_CBALLOWMULTIPLEUSER_EXP', 'This allows selection of multiple recipients from "CB connections" list.');
DEFINE ('_UDDEADM_PMSFOUND', 'PMS found: ');
DEFINE ('_UDDEIM_ENTERNAME', 'Chưa nhập tên');
DEFINE ('_UDDEADM_USEAUTOCOMPLETE_HEAD', 'Use autocomplete');
DEFINE ('_UDDEADM_USEAUTOCOMPLETE_EXP', 'Use autocomplete for receiver names.');
DEFINE ('_UDDEADM_OBFUSCATING_HEAD', 'Key used for obfuscating');
DEFINE ('_UDDEADM_OBFUSCATING_EXP', 'Enter key which is used for message obfuscating. Do not change this value after message obfuscating has been enabled.');
DEFINE ('_UDDEADM_CFGFILE_NOTFOUND', 'Wrong confguration file found!');
DEFINE ('_UDDEADM_CFGFILE_FOUND', 'Version found:');
DEFINE ('_UDDEADM_CFGFILE_EXPECTED', 'Version expected:');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING', 'Converting configuration...');
DEFINE ('_UDDEADM_CFGFILE_DONE', 'Done!');
DEFINE ('_UDDEADM_CFGFILE_WRITEFAILED', 'Critical Error: Failed to write to configuration file:');

// New: 0.8+
DEFINE ('_UDDEIM_ENCRYPTDOWN', 'Tin nhắn đã bị mã hóa! - Không thể download!');
DEFINE ('_UDDEIM_WRONGPASSDOWN', 'Sai mật khẩu! - Không thể download!');
DEFINE ('_UDDEIM_WRONGPW', 'Sai mật khẩu! - Vui lòng liên hệ với admin!');
DEFINE ('_UDDEIM_WRONGPASS', 'Sai mật khẩu!');
DEFINE ('_UDDEADM_MAINTENANCE_D1', 'Wrong trash dates (inbox/outbox): ');
DEFINE ('_UDDEADM_MAINTENANCE_D2', 'Correcting wrong trash dates');
DEFINE ('_UDDEIM_TODP', 'Gửi tới: ');
DEFINE ('_UDDEADM_MAINTENANCE_PRUNE', 'Prune messages now');
DEFINE ('_UDDEADM_SHOWACTIONICONS_HEAD', 'Show action icons');
DEFINE ('_UDDEADM_SHOWACTIONICONS_EXP', 'When set to <b>yes</b>, action links will be displayed with an icon.');
DEFINE ('_UDDEIM_UNCHECKALL', 'Bỏ chọn');
DEFINE ('_UDDEIM_CHECKALL', 'Chọn tất cả');
DEFINE ('_UDDEADM_SHOWBOTTOMICONS_HEAD', 'Show bottom icons');
DEFINE ('_UDDEADM_SHOWBOTTOMICONS_EXP', 'When set to <b>yes</b>, bottom links will be displayed with an icon.');
DEFINE ('_UDDEADM_ANIMATED_HEAD', 'Use animated smileys');
DEFINE ('_UDDEADM_ANIMATED_EXP', 'Use animated smileys instead of the static ones.');
DEFINE ('_UDDEADM_ANIMATEDEX_HEAD', 'More animated smileys');
DEFINE ('_UDDEADM_ANIMATEDEX_EXP', 'Show more animated smileys.');
DEFINE ('_UDDEIM_PASSWORDREQ', 'Tin nhắn đã bị mã hóa - Yêu cầu mật khẩu');
DEFINE ('_UDDEIM_PASSWORD', '<b>Yêu cầu mật khẩu</b>');
DEFINE ('_UDDEIM_PASSWORDBOX', 'Mật khẩu');
DEFINE ('_UDDEIM_ENCRYPTIONTEXT', ' (nội dung mã hóa)');
DEFINE ('_UDDEIM_DECRYPTIONTEXT', ' (nội dung giải mã)');
DEFINE ('_UDDEIM_MORE', 'Thêm');
// uddeIM Module
DEFINE ('_UDDEMODULE_PRIVATEMESSAGES', 'Tin nhắn');
DEFINE ('_UDDEMODULE_NONEW', 'không mới');
DEFINE ('_UDDEMODULE_NEWMESSAGES', 'Tin nhắn mới: ');
DEFINE ('_UDDEMODULE_MESSAGE', 'tin nhắn');
DEFINE ('_UDDEMODULE_MESSAGES', 'tin nhắn');
DEFINE ('_UDDEMODULE_YOUHAVE', 'Bạn có');
DEFINE ('_UDDEMODULE_HELLO', 'Hi');
DEFINE ('_UDDEMODULE_EXPRESSMESSAGE', 'Tin nhắn nhanh');

// New: 0.7+
DEFINE ('_UDDEADM_USEENCRYPTION', 'Use encryption');
DEFINE ('_UDDEADM_USEENCRYPTIONDESC', 'Encrypt stored messages');
DEFINE ('_UDDEADM_CRYPT0', 'None');
DEFINE ('_UDDEADM_CRYPT1', 'Obfuscate messages');
DEFINE ('_UDDEADM_CRYPT2', 'Encrypt messages');
DEFINE ('_UDDEADM_NOTIFYDEFAULT_HEAD', 'Default for e-mail notification');
DEFINE ('_UDDEADM_NOTIFYDEFAULT_EXP', 'Default value for e-mail notification (for users who have not changed their preferences yet).');
DEFINE ('_UDDEADM_NOTIFYDEF_0', 'No notification');
DEFINE ('_UDDEADM_NOTIFYDEF_1', 'Always');
DEFINE ('_UDDEADM_NOTIFYDEF_2', 'Notification when offline');
DEFINE ('_UDDEADM_SUPPRESSALLUSERS_HEAD', 'Supress "All users" link');
DEFINE ('_UDDEADM_SUPPRESSALLUSERS_EXP', 'Supress "All users" link in write new message box (useful when lots of users are registered).');
DEFINE ('_UDDEADM_POPUP_HEAD','Popup notification');
DEFINE ('_UDDEADM_POPUP_EXP','Show a popup when a new message arrives (mod_uddeim or patched mod_cblogin is needed)');
DEFINE ('_UDDEIM_OPTIONS', 'Thiết lập khác');
DEFINE ('_UDDEIM_OPTIONS_EXP', 'Bạn có thể tùy biến các thiết lập khác tại đây.');
DEFINE ('_UDDEIM_OPTIONS_P', 'Hiện popup khi có tin nhắn mới');
DEFINE ('_UDDEADM_POPUPDEFAULT_HEAD', 'Popup notification by default');
DEFINE ('_UDDEADM_POPUPDEFAULT_EXP', 'Enable popup notification by default (for users who have not changed their preferences yet).');
DEFINE ('_UDDEADM_MAINTENANCE', 'Maintenance');
DEFINE ('_UDDEADM_MAINTENANCE_HEAD', 'Database maintenance');
DEFINE ('_UDDEADM_MAINTENANCE_CHECK', 'CHECK');
DEFINE ('_UDDEADM_MAINTENANCE_TRASH', 'REPAIR');
DEFINE ('_UDDEADM_MAINTENANCE_EXP', "When a user is purged from the database his messages are usually kept in the database. This function checks if it is necessary to trash orphaned messages and you can trash them if it is required.<br />This also checks the database for a few errors which will be corrected.");
DEFINE ('_UDDEADM_MAINTENANCE_MC1', "Checking...<br />");
DEFINE ('_UDDEADM_MAINTENANCE_MC2', "<i>#nnn (Username): [inbox|inbox trashed|outbox|outbox trashed]</i><br />");
DEFINE ('_UDDEADM_MAINTENANCE_MC3', "<i>inbox: messages stored in users inbox</i><br />");
DEFINE ('_UDDEADM_MAINTENANCE_MC4', "<i>inbox trashed: messages trashed from users inbox, but still in someones outbox</i><br />");
DEFINE ('_UDDEADM_MAINTENANCE_MC5', "<i>outbox: messages stored in users outbox</i><br />");
DEFINE ('_UDDEADM_MAINTENANCE_MC6', "<i>outbox trashed: messages trashed from users outbox, but still in someones inbox</i><br />");
DEFINE ('_UDDEADM_MAINTENANCE_MT1', "Trashing...<br />");
DEFINE ('_UDDEADM_MAINTENANCE_NOTFOUND', "not found (from/to/settings/blocker/blocked):");
DEFINE ('_UDDEADM_MAINTENANCE_MT2', "delete all preferences from user");
DEFINE ('_UDDEADM_MAINTENANCE_MT3', "delete blocking of user");
DEFINE ('_UDDEADM_MAINTENANCE_MT4', "trash all messages sent to deleted user in sender\'s outbox and deleted user\'s inbox");
DEFINE ('_UDDEADM_MAINTENANCE_MT5', "trash all messages sent from deleted user in his outbox and receiver\'s inbox");
DEFINE ('_UDDEADM_MAINTENANCE_NOTHINGTODO', '<b>Nothing to do</b><br />');
DEFINE ('_UDDEADM_MAINTENANCE_JOBTODO', '<b>Maintenance required</b><br />');

// New: 0.6+
DEFINE ('_UDDEADM_NAMESTEXT', 'Show realnames');
DEFINE ('_UDDEADM_NAMESDESC', 'Show realnames or usernames?');
DEFINE ('_UDDEADM_REALNAMES', 'Realnames');
DEFINE ('_UDDEADM_USERNAMES', 'Usernames');
DEFINE ('_UDDEADM_CONLISTBOX', 'Connections listbox');
DEFINE ('_UDDEADM_CONLISTBOXDESC', 'Show my connections in a listbox or in a table?');
DEFINE ('_UDDEADM_LISTBOX', 'Listbox');
DEFINE ('_UDDEADM_TABLE', 'Table');

DEFINE ('_UDDEIM_TRASHCAN_INFO', 'Tin nhắn sẽ ở trong thùng rác 24 giờ trước khi bị xóa vĩnh viễn. Bạn chỉ có thể xem những từ đầu tiên cảu tin nhắn. Để đọc được tin nhắn, bạn phải khôi phục lại nó.');
DEFINE ('_UDDEIM_TRASHCAN_INFO_1', 'Tin nhắn sẽ được lưu trữ trong thùng rác trong vòng ');
DEFINE ('_UDDEIM_TRASHCAN_INFO_2', ' giờ trước khi bị xóa vĩnh viễn. Bạn chỉ có thể nhìn thấy từ đầu tiên trong nội dung tin nhắn. Để đọc được tin nhắn bạn phải khôi phục lại tin nhắn.');
DEFINE ('_UDDEIM_RECALLEDMESSAGE_INFO', 'Tin nhắn này vừa được thu hồi, bạn có thể sửa và gửi lại nó.');
DEFINE ('_UDDEIM_COULDNOTRECALL', 'Không thu hồi được tin nhắn (có thể nó đã được đọc hoặc bị xóa.)');
DEFINE ('_UDDEIM_CANTRESTORE', 'Khôi phục tin nhắn thất bại. (Có thể tin nhắn đã được chuyển tới thùng rác trong thời gian dài, và đã bị xóa.)');
DEFINE ('_UDDEIM_COULDNOTRESTORE', 'Khôi phục tin nhắn thất bại.');
DEFINE ('_UDDEIM_DONTSEND', 'Không gửi');
DEFINE ('_UDDEIM_SENDAGAIN', 'Gửi lại');
DEFINE ('_UDDEIM_NOTLOGGEDIN', 'Bạn chưa đăng nhập.');
DEFINE ('_UDDEIM_NOMESSAGES_INBOX', '<b>Bạn không có tin nhắn nào.</b>');

DEFINE ('_UDDEIM_NOMESSAGES_OUTBOX', '<b>Hộp thư đi không có thư nào.</b>');
DEFINE ('_UDDEIM_NOMESSAGES_TRASHCAN', '<b>Thùng rác không có thư nào.</b>');
DEFINE ('_UDDEIM_INBOX', 'Thư đến');
DEFINE ('_UDDEIM_OUTBOX', 'Thư đi');
DEFINE ('_UDDEIM_TRASHCAN', 'Thùng rác');
DEFINE ('_UDDEIM_CREATE', 'Tin nhắn mới');
DEFINE ('_UDDEIM_UDDEIM', 'Tin nhắn');
DEFINE ('_UDDEIM_READSTATUS', 'Đọc tin');
DEFINE ('_UDDEIM_FROM', 'Từ');
DEFINE ('_UDDEIM_FROM_SMALL', 'từ');
DEFINE ('_UDDEIM_TO', 'Tới');
DEFINE ('_UDDEIM_TO_SMALL', 'tới');
DEFINE ('_UDDEIM_OUTBOX_WARNING', 'Hộp thư đi chứa các tin nhắn bạn đã gửi. Bạn có thể thu lại các tin nhắn đã gửi nếu nó chưa được đọc, và người nhận sẽ không thể đọc được những tin nhắn đó nữa.');
	// changed in 0.4

DEFINE ('_UDDEIM_RECALL', 'Thu hồi');
DEFINE ('_UDDEIM_RECALLTHISMESSAGE', 'Thu hồi tin nhắn');
DEFINE ('_UDDEIM_RESTORE', 'Khôi phục');
DEFINE ('_UDDEIM_MESSAGE', 'Tin nhắn');
DEFINE ('_UDDEIM_DATE', 'Ngày');
DEFINE ('_UDDEIM_DELETED', 'Ngày xóa');
DEFINE ('_UDDEIM_DELETE', 'Xóa');
DEFINE ('_UDDEIM_ONLINEPIC', 'images/icon_online.gif');
DEFINE ('_UDDEIM_OFFLINEPIC', 'images/icon_offline.gif');
DEFINE ('_UDDEIM_DELETELINK', 'Xóa');
DEFINE ('_UDDEIM_MESSAGENOACCESS', 'Tin nhắn không được hiển thị. <br />Lí do:<ul><li>Bạn không có quyên đọc tin nhắn này.</li><li>Tin nhắn đã bị xóa.</li></ul>');
DEFINE ('_UDDEIM_YOUMOVEDTOTRASH', '<b>Bạn đã xóa tin nhắn này.</b>');
DEFINE ('_UDDEIM_MESSAGEFROM', 'Tin nhắn từ ');
DEFINE ('_UDDEIM_MESSAGETO', 'Tin nhắn gửi từ bạn tới ');
DEFINE ('_UDDEIM_REPLY', 'Trả lời');
DEFINE ('_UDDEIM_SUBMIT', 'Gửi');
DEFINE ('_UDDEIM_DELETEREPLIED', 'Xóa tin nhắn đến sau khi trả lời');
DEFINE ('_UDDEIM_NOID', 'Lỗi: Không có người nhận. Tin nhắn chưa được gửi đi.');
DEFINE ('_UDDEIM_NOMESSAGE', 'Lỗi: Tin nhắn trống!');
DEFINE ('_UDDEIM_MESSAGE_REPLIEDTO', 'Đã gửi trả lời');
DEFINE ('_UDDEIM_MESSAGE_SENT', 'Đã gửi tin nhắn');
DEFINE ('_UDDEIM_MOVEDTOTRASH', ' và xóa tin nhắn đến');
DEFINE ('_UDDEIM_NOSUCHUSER', 'Không tìm thấy thành viên!');
DEFINE ('_UDDEIM_NOTTOYOURSELF', 'Bạn không thể tự gửi tin nhắn cho chính mình!');
DEFINE ('_UDDEIM_VIOLATION', '<b>Từ chối truy cập!</b> Bạn không có quyền thực hiện hành động này!');
DEFINE ('_UDDEIM_PRUNELINK', 'Dành cho admin: Lược bớt');

// Admin

DEFINE ('_UDDEADM_SETTINGS', 'uddeIM Administration');
DEFINE ('_UDDEADM_GENERAL', 'General');
DEFINE ('_UDDEADM_ABOUT', 'About');
DEFINE ('_UDDEADM_DATESETTINGS', 'Date/time');
DEFINE ('_UDDEADM_PICSETTINGS', 'Icons');
DEFINE ('_UDDEADM_DELETEREADAFTER_HEAD', 'Read messages kept for (days)');
DEFINE ('_UDDEADM_DELETEUNREADAFTER_HEAD', 'Unread messages kept for (days)');
DEFINE ('_UDDEADM_DELETETRASHAFTER_HEAD', 'Messages kept in trash for (days)');
DEFINE ('_UDDEADM_DAYS', 'day(s)');
DEFINE ('_UDDEADM_DELETEREADAFTER_EXP', 'Enter the number of days until <b>read</b> messages will be erased automatically from the inbox. If you do not want to erase messages automatically, enter a very high value (e.g. 36524 days are equivalent to one century). But keep in mind that the database can fill up quickly if you keep all messages.');
DEFINE ('_UDDEADM_DELETEUNREADAFTER_EXP', 'Enter the number of days until messages will be erased that have <b>not been read</b> by their intended recipient yet.');
DEFINE ('_UDDEADM_DELETETRASHAFTER_EXP', 'Enter the number of days until messages are erased from the trashcan. Decimal values are possible, e.g. to erase messages from the trashcan after 3 hours enter 0.125 as value.');
DEFINE ('_UDDEADM_DATEFORMAT_HEAD', 'Date display format');
DEFINE ('_UDDEADM_DATEFORMAT_EXP', 'Choose the format used when a date/time is being displayed. Months will be abbreviated according to your local language settings of Joomla (if a matching uddeIM language file is present).');
DEFINE ('_UDDEADM_LDATEFORMAT_HEAD', 'Longer date display');
DEFINE ('_UDDEADM_LDATEFORMAT_EXP', 'When displaying messages there is more space for the date/time string. Choose the date format to display when opening a message. For weekday names and months the local language settings of Joomla will be used (if a matching uddeIM language file is present).');
DEFINE ('_UDDEADM_ADMINIGNITIONONLY_HEAD', 'Deletions invoked');
DEFINE ('_UDDEADM_ADMINIGNITIONONLY_YES', 'by admins only');
DEFINE ('_UDDEADM_ADMINIGNITIONONLY_NO', 'by any user');
DEFINE ('_UDDEADM_ADMINIGNITIONONLY_MANUALLY', 'manually');
DEFINE ('_UDDEADM_ADMINIGNITIONONLY_EXP', 'Automatic deletions create heavy server load. If you choose <b>by admins only</b> automatic deletions are invoked when an admin checks his inbox. Choose this option if an admin is checking the inbox regulary. Small or rarely administered sites may choose <b>by any user</b>.');

	// above string changed in 0.4 
DEFINE ('_UDDEADM_SAVESETTINGS', 'Save settings');
DEFINE ('_UDDEADM_THISHASBEENSAVED', 'The following settings have been saved to config file:');
DEFINE ('_UDDEADM_SETTINGSSAVED', 'Settings have been saved.');
DEFINE ('_UDDEADM_ICONONLINEPIC_HEAD', 'Icon: User is online');
DEFINE ('_UDDEADM_ICONONLINEPIC_EXP', 'Enter the location of the icon to be displayed next to the username when this user is online.');
DEFINE ('_UDDEADM_ICONOFFLINEPIC_HEAD', 'Icon: User is offline');
DEFINE ('_UDDEADM_ICONOFFLINEPIC_EXP', 'Enter the location of the icon to be displayed next to the username when this user is offline.');
DEFINE ('_UDDEADM_ICONREADPIC_HEAD', 'Icon: Read message');
DEFINE ('_UDDEADM_ICONREADPIC_EXP', 'Enter the location of the icon to be displayed for read messages.');
DEFINE ('_UDDEADM_ICONUNREADPIC_HEAD', 'Icon: Unread message');
DEFINE ('_UDDEADM_ICONUNREADPIC_EXP', 'Enter the location of the icon to be displayed for unread messages.');
DEFINE ('_UDDEADM_MODULENEWMESS_HEAD', 'Module: New Messages Icon');
DEFINE ('_UDDEADM_MODULENEWMESS_EXP', 'This setting refers to the mod_uddeim module. Enter the location of the icon that this module shall display when there are new messages.');

// admin import tab

DEFINE ('_UDDEADM_UDDEINSTALL', 'uddeIM Installation');
DEFINE ('_UDDEADM_FINISHED', 'Installation is finished. Welcome to uddeIM. ');
DEFINE ('_UDDEADM_NOCB', '<span style="color: red;">You do not have Mambo Community Builder installed. You will not be able to use uddeIM.</span><br /><br />You might want to download <a href="http://www.mambojoe.com">Mambo Community Builder</a>.');
DEFINE ('_UDDEADM_CONTINUE', 'continue');
DEFINE ('_UDDEADM_PMSFOUND_1', 'There are ');
DEFINE ('_UDDEADM_PMSFOUND_2', ' messages in the old PMS installation. Do you want to import these messages into uddeIM?');
DEFINE ('_UDDEADM_IMPORT_EXP', 'This will not alter the old PMS messages or your installation. They will be kept intact and you can safely import them into uddeIM, even if you consider to continue using the old PMS. You should save any changes you made to the settings first before running the import! All messages that are already in your uddeIM database will remain intact.');
	// _UDDEADM_IMPORT_EXP above changed in 0.4
	
DEFINE ('_UDDEADM_IMPORT_YES', 'Import old PMS messages into uddeIM now');
DEFINE ('_UDDEADM_IMPORT_NO', 'No, do not import any messages');  
DEFINE ('_UDDEADM_IMPORTING', 'Please wait while messages are being imported.');
DEFINE ('_UDDEADM_IMPORTDONE', 'Done importing messages from old PMS. Do not run this installation script again because doing so will import the messages again and they will show up twice.'); 
DEFINE ('_UDDEADM_IMPORT', 'Import');
DEFINE ('_UDDEADM_IMPORT_HEADER', 'Import messages from old PMS');
DEFINE ('_UDDEADM_PMSNOTFOUND', 'No other PMS installation found. Import not possible.');
DEFINE ('_UDDEADM_ALREADYIMPORTED', '<span style="color: red;">You have already imported the messages from the old PMS into uddeIM.</span>');

// new in 0.3 Frontend
DEFINE ('_UDDEIM_BLOCKS', 'Đã khóa');
DEFINE ('_UDDEIM_YOUAREBLOCKED', 'Không gửi được (người nhận đã khóa nick của bạn)');
DEFINE ('_UDDEIM_BLOCKNOW', 'Chặn');
DEFINE ('_UDDEIM_BLOCKS_EXP', 'Dưới đây là danh sách các thành viên bạn đã chặn. Họ sẽ không thể tiếp tục gửi tin nhắn tới cho bạn.');
DEFINE ('_UDDEIM_NOBODYBLOCKED', 'Hiện tại bạn không chặn tin nhắn từ bất kì thành viên nào');
DEFINE ('_UDDEIM_YOUBLOCKED_PRE', 'Bạn đang chặn ');
DEFINE ('_UDDEIM_YOUBLOCKED_POST', ' thành viên.');
DEFINE ('_UDDEIM_UNBLOCKNOW', '[Mở khóa]');
DEFINE ('_UDDEIM_BLOCKALERT_EXP_ON', 'Khi các thành viên bị chặn gửi tin nhắn cho bạn, họ sẽ nhận được thông tin họ đã bị chặn và tin nhắn không được gửi.');
DEFINE ('_UDDEIM_BLOCKALERT_EXP_OFF', 'Người bị chặn sẽ không biết rằng bạn đã chặn họ.');
DEFINE ('_UDDEIM_CANTBLOCKADMINS', 'Bạn không thể chặn admin.');

// new in 0.3 Admin
DEFINE ('_UDDEADM_BLOCKSYSTEM_HEAD', 'Enable blocking system');
DEFINE ('_UDDEADM_BLOCKSYSTEM_EXP', 'When enabled, users can block other users. A blocked user can not send messages to the user who has blocked him. Admins can\'t be blocked.');
DEFINE ('_UDDEADM_BLOCKSYSTEM_YES', 'yes');
DEFINE ('_UDDEADM_BLOCKSYSTEM_NO', 'no');
DEFINE ('_UDDEADM_BLOCKALERT_HEAD', 'Blocked user information');
DEFINE ('_UDDEADM_BLOCKALERT_EXP', 'If set to <b>yes</b>, a blocked user will be informed that the message has not been sent because the recipient has blocked him. If set to <b>no</b>, the blocked user does not get any notification that the message has not been sent.');
DEFINE ('_UDDEADM_BLOCKALERT_YES', 'yes');
DEFINE ('_UDDEADM_BLOCKALERT_NO', 'no');
DEFINE ('_UDDEIM_BLOCKSDISABLED', 'Hệ thống chặn tin nhắn đã tắt');
// DEFINE ('_UDDEADM_DELETIONS', 'Messages'); 
	// translators info: comment out or delete line above to avoid double definition.
	// new definition right below.
DEFINE ('_UDDEADM_DELETIONS', 'Deletion'); // changed in 0.4
DEFINE ('_UDDEADM_BLOCK', 'Blocking');

// new in 0.4, admin
DEFINE ('_UDDEADM_INTEGRATION', 'Integration');
DEFINE ('_UDDEADM_EMAIL', 'E-mail');
DEFINE ('_UDDEADM_SHOWONLINE_HEAD', 'Show online status');
DEFINE ('_UDDEADM_SHOWONLINE_EXP', 'When set to <b>yes</b>, uddeIM displays every username with a small icon that informs if this user is online or offline.');
DEFINE ('_UDDEADM_ALLOWEMAILNOTIFY_HEAD', 'Allow e-mail notification');
DEFINE ('_UDDEADM_ALLOWEMAILNOTIFY_EXP', 'When set to <b>yes</b>, users can choose if they want to get an e-mail every time a new message arrives in the inbox.');
DEFINE ('_UDDEADM_EMAILWITHMESSAGE_HEAD', 'E-mail contains message');
DEFINE ('_UDDEADM_EMAILWITHMESSAGE_EXP', 'When set to <b>no</b>, this e-mail will only contain information about when and by whom the message was sent, but not the message itself.');
DEFINE ('_UDDEADM_LONGWAITINGEMAIL_HEAD', 'Forgetmenot e-mail');
DEFINE ('_UDDEADM_LONGWAITINGEMAIL_EXP', 'This feature sends an e-mail to users who have unread messages in their inbox for a very long time (set below). This setting is independent from the \'allow e-mail notification\'. If you do not want to send out any e-mail messages you have to turn off both.');
DEFINE ('_UDDEADM_LONGWAITINGDAYS_HEAD', 'Forgetmenot sent after day(s)');
DEFINE ('_UDDEADM_LONGWAITINGDAYS_EXP', 'If the forgetmenot feature (above) is set to <b>yes</b>, set here after how many days e-mail notifications about unread messages shall be dispatched.');
DEFINE ('_UDDEADM_FIRSTWORDSINBOX_HEAD', 'First characters list');
DEFINE ('_UDDEADM_FIRSTWORDSINBOX_EXP', 'You can set here how many characters of a message will be displayed in the inbox, outbox and trashcan.');
DEFINE ('_UDDEADM_MAXLENGTH_HEAD', 'Message maximum length');
DEFINE ('_UDDEADM_MAXLENGTH_EXP', 'Set the maximum length of a message (a message will be truncated automatically when its length exceeds this value). Set to \'0\' to allow for messages of any length (not recommended).');
DEFINE ('_UDDEADM_YES', 'yes');
DEFINE ('_UDDEADM_NO', 'no');
DEFINE ('_UDDEADM_ADMINSONLY', 'admins only');
DEFINE ('_UDDEADM_SYSTEM', 'System');
DEFINE ('_UDDEADM_SYSM_USERNAME_HEAD', 'System messages username');
DEFINE ('_UDDEADM_SYSM_USERNAME_EXP', 'uddeIM supports system messages. They do not have a sender and users can\'t reply to them. Enter here the default username alias for system messages (for example <b>Support</b> or <b>Help desk</b> or <b>Community Master</b>).');
DEFINE ('_UDDEADM_ALLOWTOALL_HEAD', 'Allow admins to send general messages');
DEFINE ('_UDDEADM_ALLOWTOALL_EXP', 'uddeIM supports general messages. They are sent to every user on your system. Use them sparingly.');
DEFINE ('_UDDEADM_EMN_SENDERNAME_HEAD', 'E-mail sender name');
DEFINE ('_UDDEADM_EMN_SENDERNAME_EXP', 'Enter the name from which e-mail notifications come from (for example <b>Your Site</b> or <b>Messaging Service</b>)');
DEFINE ('_UDDEADM_EMN_SENDERMAIL_HEAD', 'E-mail sender address');
DEFINE ('_UDDEADM_EMN_SENDERMAIL_EXP', 'Enter the e-mail address from which e-mail notifications are sent from (this should be the main contact e-mail address of your site.');
DEFINE ('_UDDEADM_VERSION', 'uddeIM version');
DEFINE ('_UDDEADM_ARCHIVE', 'Archive'); // translators info: headline for Archive system
DEFINE ('_UDDEADM_ALLOWARCHIVE_HEAD', 'Enable archive');
DEFINE ('_UDDEADM_ALLOWARCHIVE_EXP', 'Choose if users shall be allowed to store messages in an archive. Messages in the archive will not be deleted automatically.');
DEFINE ('_UDDEADM_MAXARCHIVE_HEAD', 'Max messages in archive');
DEFINE ('_UDDEADM_MAXARCHIVE_EXP', 'Set how many messages every user may store in the archive (no limit for admins).');
DEFINE ('_UDDEADM_COPYTOME_HEAD', 'Allow self copies');
DEFINE ('_UDDEADM_COPYTOME_EXP', 'Allows users to receive copies of messages they are sending. These copies will appear in the inbox.');
DEFINE ('_UDDEADM_MESSAGES', 'Messages');
DEFINE ('_UDDEADM_TRASHORIGINAL_HEAD', 'Suggest to trash original');
DEFINE ('_UDDEADM_TRASHORIGINAL_EXP', 'When activated this will put a checkbox next to the \'Send\' reply button called \'trash original\' that is checked by default. In this case a message will immediately be moved from the inbox to trashcan when a reply has been sent. This function reduces the number of messages kept in the database. Users can uncheck the box if they want to keep a message in the inbox.');
	// translators info: 'Send' is the same as _UDDEIM_SUBMIT, 
	// and 'trash original' the same as _UDDEIM_TRASHORIGINAL
	
DEFINE ('_UDDEADM_PERPAGE_HEAD', 'Messages per page');	
DEFINE ('_UDDEADM_PERPAGE_EXP', 'Define here the number of messages displayed per page in inbox, outbox, trashcan and archive.');
DEFINE ('_UDDEADM_CHARSET_HEAD', 'Used charset');
DEFINE ('_UDDEADM_CHARSET_EXP', 'If you\'re experiencing problems with non-latin character sets displayed, you can enter the charset uddeIM uses to convert database output to HTML code here. The default value is correct for most European languages.');
DEFINE ('_UDDEADM_MAILCHARSET_HEAD', 'Used mail charset');
DEFINE ('_UDDEADM_MAILCHARSET_EXP', 'If you\'re experiencing problems with non-latin character sets displayed, you can enter the charset uddeIM uses to send outgoing e-mails with. The default value is correct for most European languages.');
		// translators info: if you're translating into a language that uses a latin charset
		// (like English, Dutch, German, Swedish, Spanish, ... ) you might want to add a line
		// saying 'For usage in [mylanguage] the default value is correct.'
		
DEFINE ('_UDDEADM_EMN_BODY_NOMESSAGE_EXP', 'This is the content of the e-mail users will receive when the option is set above. The content of the message will not be in the e-mail. Keep the variables %you%, %user% and %site% intact. ');		
DEFINE ('_UDDEADM_EMN_BODY_WITHMESSAGE_EXP', 'This is the content of the e-mail users will receive when the option is set above. This e-mail will include the content of the message. Keep the variables %you%, %user%, %pmessage% and %site% intact. ');		
DEFINE ('_UDDEADM_EMN_FORGETMENOT_EXP', 'This is the content of the forgetmenot e-mail users will receive when the option is set above. Keep the variables %you% and %site% intact. ');		
DEFINE ('_UDDEADM_ENABLEDOWNLOAD_EXP', 'Allow users to download messages from their archive by sending them as e-mail to themselves.');
DEFINE ('_UDDEADM_ENABLEDOWNLOAD_HEAD', 'Allow download');	
DEFINE ('_UDDEADM_EXPORT_FORMAT_EXP', 'This is the format of the e-mail users will receive when they download their own messages from the archive. Keep the variables %user%, %msgdate% and %msgbody% intact. ');	
		// translators info: Don't translate %you%, %user%, etc. in the strings above. 

DEFINE ('_UDDEADM_INBOXLIMIT_HEAD', 'Set inbox limit');		
DEFINE ('_UDDEADM_INBOXLIMIT_EXP', 'You can include the number of messages in the inbox into the maximum number of archived messages. In this case, the number of messages in inbox and archive in total must not exceed the number set above. Alternatively, you can set the inbox limit without an archive. In this case, users may have no more than the number of messages set above in their inboxes. If the number is reached, they will no longer be able to reply to messages or to compose new ones until they delete old messages from the inbox or archive respectively (users will still be able to receive and read messages).');
DEFINE ('_UDDEADM_SHOWINBOXLIMIT_HEAD', 'Show limit usage at inbox');		
DEFINE ('_UDDEADM_SHOWINBOXLIMIT_EXP', 'Display how many messages users have stored (and how many they are allowed to store) in a line below the inbox.');
		
DEFINE ('_UDDEADM_ARCHIVETOTRASH_INTRO', 'You have turned off the archive. How do you want to handle messages that are saved in the archive?');		

DEFINE ('_UDDEADM_ARCHIVETOTRASH_LEAVE_LINK', 'Leave them');		
DEFINE ('_UDDEADM_ARCHIVETOTRASH_LEAVE_EXP', 'Leave them in the archive (user will not be able to access the messages and they will still count against message limits).');		
DEFINE ('_UDDEADM_ARCHIVETOTRASH_INBOX_LINK', 'Move to inbox');		
DEFINE ('_UDDEADM_ARCHIVETOTRASH_INBOX_DONE', 'Archived messages moved to inboxes');
DEFINE ('_UDDEADM_ARCHIVETOTRASH_INBOX_EXP', 'Messages will be moved to the inbox of the respective user (or to trash if they are older than allowed in the inbox).');		

		
// 0.4 frontend, admins only (no translation necessary)		
DEFINE ('_UDDEIM_VALIDFOR_1', 'Có giá trị trong ');
DEFINE ('_UDDEIM_VALIDFOR_2', ' giờ. 0=vĩnh viễn (Tự động xóa sau thời gian định trước)');
DEFINE ('_UDDEIM_WRITE_SYSM_GM', '[Tạo tin nhắn hệ thống hoặc tin nhắn chung]');
DEFINE ('_UDDEIM_WRITE_NORMAL', '[Tạo tin nhắn thông thường]');
DEFINE ('_UDDEIM_NOTALLOWED_SYSM_GM', 'Không cho phép tạo tin nhắn hệ thống và tin nhắn chung.');
DEFINE ('_UDDEIM_SYSGM_TYPE', 'Kiểu tin nhắn');
DEFINE ('_UDDEIM_HELPON_SYSGM', 'Trợ giuso trong hệ thống tin nhắn');
DEFINE ('_UDDEIM_HELPON_SYSGM_2', '(Mở với cửa sổ mới)');

DEFINE ('_UDDEIM_SYSGM_PLEASECONFIRM', 'Bạn chuẩn bị gửi tin nhắn với nội dung dưới đây, vui lòng xác nhận lại!');
DEFINE ('_UDDEIM_SYSGM_WILLSENDTOALL', 'Gửi tin nhắn tới <b>tất cả các thành viên</b>');
DEFINE ('_UDDEIM_SYSGM_WILLSENDTOALLADMINS', 'Gửi tin nhắn tới <b>nhóm admin</b>');
DEFINE ('_UDDEIM_SYSGM_WILLSENDTOALLLOGGED', 'Gửi tin nhắn tới <b>các thành viên đang online</b>');
DEFINE ('_UDDEIM_SYSGM_WILLDISABLEREPLY', 'Người nhận không thể trả lời tin nhắn này.');
DEFINE ('_UDDEIM_SYSGM_WILLSENDAS_1', 'Tin nhắn sẽ được gửi đi dưới tên người gửi là <b>');
DEFINE ('_UDDEIM_SYSGM_WILLSENDAS_2', '</b>');

DEFINE ('_UDDEIM_SYSGM_WILLEXPIRE', 'Tin nhắn sẽ hết hạn và bị xóa vào lúc ');
DEFINE ('_UDDEIM_SYSGM_WILLNOTEXPIRE', 'Tin nhắn vô thời hạn');
DEFINE ('_UDDEIM_SYSGM_CHECKLINK', '<b>Kiển tra liên kết (bằng cách nhấn vào liên kết) trước khi tiến hành!</b>');
DEFINE ('_UDDEIM_SYSGM_SHORTHELP', 'Chỉ sử dụng <b>tin nhắn hệ thống</b>:<br /> [b]<b>In đậm</b>[/b] [i]<em>In nghiêng</em>[/i]<br />
[url=http://www.someurl.com]some url[/url] hoặc [url]http://www.someurl.com[/url] là các liên kết');
DEFINE ('_UDDEIM_SYSGM_ERRORNORECIPS', 'Lỗi: Không có người nhận này. Tin nhắn chưa được gửi đi.');		

DEFINE ('_UDDEIM_CANTREPLY', 'Đây là tin nhắn hệ thống. Bạn không thể trả lời tin nhắn này.');
DEFINE ('_UDDEIM_EMNOFF', 'Email thông báo đã tắt. ');
DEFINE ('_UDDEIM_EMNON', 'Email thông báo đã bật. ');
DEFINE ('_UDDEIM_SETEMNON', '[bật]');
DEFINE ('_UDDEIM_SETEMNOFF', '[tắt]');
DEFINE ('_UDDEIM_EMN_BODY_NOMESSAGE',
"Chào %you%,\n\n%user% đã gửi tin nhắn cho bạn tại %site%. Hãy đăng nhập để đọc tin nhắn!");
DEFINE ('_UDDEIM_EMN_BODY_WITHMESSAGE',
"Chào %you%,\n\n%user% đã gửi tin nhắn sau cho bạn tại %site%. Hãy đăng nhập để trả lời tin nhắn!\n__________________\n%pmessage%");
DEFINE ('_UDDEIM_EMN_FORGETMENOT',
"Chào %you%,\n\nBạn có tin nhắn chưa đọc tại %site%. Hãy đăng nhập để đọc tin nhắn!");
DEFINE ('_UDDEIM_EXPORT_FORMAT', '
================================================================================
%user% (%msgdate%)
----------------------------------------
%msgbody%
================================================================================');
DEFINE ('_UDDEIM_EMN_SUBJECT', 'Ban co tin nhan tai %site%');
DEFINE ('_UDDEIM_SEND_ASSYSM', 'Gửi tin nhắn hệ thống (=Người nhận không thể trả lời)');
DEFINE ('_UDDEIM_SEND_TOALL', 'Gửi tới tất cả các thành viên');
DEFINE ('_UDDEIM_SEND_TOALLADMINS', 'Gửi tới nhóm admin');
DEFINE ('_UDDEIM_SEND_TOALLLOGGED', 'Gửi tới tất cả các thành viên online');

DEFINE ('_UDDEIM_UNEXPECTEDERROR_QUIT', 'Lỗi xảy ra: ');
DEFINE ('_UDDEIM_ARCHIVENOTENABLED', 'Không cho phép lưu trữ.');
DEFINE ('_UDDEIM_ARCHIVE_ERROR', 'Lỗi lưu trữ tin nhắn.');
DEFINE ('_UDDEIM_ARC_SAVED_1', 'Bạn đã lưu trữ ');
DEFINE ('_UDDEIM_ARC_SAVED_NONE', '<b>Bạn chưa lưu trữ tin nhắn nào.</b>'); 
DEFINE ('_UDDEIM_ARC_SAVED_NONE_2', '<b>Lưu trữ không có thư nào.</b>'); 
DEFINE ('_UDDEIM_ARC_SAVED_2', ' tin nhắn');
DEFINE ('_UDDEIM_ARC_SAVED_ONE', 'Bạn đã lưu trữ 1 tin nhắn');
DEFINE ('_UDDEIM_ARC_SAVED_3', 'Để lưu trữ thêm tin nhắn, bạn phải xóa bớt vào tin nhắn đã lưu trữ.');
DEFINE ('_UDDEIM_ARC_CANSAVEMAX_1', 'Bạn có thể lưu trữ tối đa ');
DEFINE ('_UDDEIM_ARC_CANSAVEMAX_2', ' tin nhắn.');
DEFINE ('_UDDEIM_INBOX_LIMIT_1', 'Bạn có ');
DEFINE ('_UDDEIM_INBOX_LIMIT_2', ' tin nhắn trong');
DEFINE ('_UDDEIM_INBOX_LIMIT_2_SINGULAR', ' tin nhắn trong'); // same as _UDDEIM_INBOX_LIMIT_2, but singular (as in one "message in your")
DEFINE ('_UDDEIM_ARC_UNIVERSE_ARC', 'lưu trữ');
DEFINE ('_UDDEIM_ARC_UNIVERSE_INBOX', 'hộp thư đến');
DEFINE ('_UDDEIM_ARC_UNIVERSE_BOTH', 'hộp thư đến và lưu trữ');
DEFINE ('_UDDEIM_INBOX_LIMIT_3', 'Cho phép tối đa ');
DEFINE ('_UDDEIM_INBOX_LIMIT_4', 'Bạn vẫn có thể nhận và đọc tin nhắn nhưng không thể gửi tin nhắn hoặc soạn tin nhắn mới cho đến khi bạn xóa bớt một vài tin nhắn.');
DEFINE ('_UDDEIM_SHOWINBOXLIMIT_1', 'Tin nhắn đã lưu trữ: ');
DEFINE ('_UDDEIM_SHOWINBOXLIMIT_2', '(Tối đa ');

DEFINE ('_UDDEIM_MESSAGE_ARCHIVED', 'Lưu tin nhắn vào hộp lưu trữ.');
DEFINE ('_UDDEIM_STORE', 'Lưu trữ');				// translators info: as in: 'store this message in archive now'
DEFINE ('_UDDEIM_BACK', 'Quay lại');
DEFINE ('_UDDEIM_TRASHCHECKED', 'Xóa các tin đã chọn');	// translators info: plural!
DEFINE ('_UDDEIM_SHOWALL', 'Xem tất cả');				// translators example "SHOW ALL messages"
DEFINE ('_UDDEIM_ARCHIVE', 'Lưu trữ');				// should be same as _UDDEADM_ARCHIVE
	
DEFINE ('_UDDEIM_ARCHIVEFULL', 'Hộp lưu trữ đã đầy.');	
	
DEFINE ('_UDDEIM_NOMSGSELECTED', 'Không có tin nhắn nào được chọn.');
DEFINE ('_UDDEIM_THISISACOPY', 'Sao lưu một tin nhắn đã gửi tới ');
DEFINE ('_UDDEIM_SENDCOPYTOME', 'Gửi một bản sao cho tôi');
DEFINE ('_UDDEIM_SENDCOPYTOARCHIVE', 'Sao lưu vào lưu trữ');
DEFINE ('_UDDEIM_TRASHORIGINAL', 'Xóa bản gốc');

DEFINE ('_UDDEIM_MESSAGEDOWNLOAD', 'Download tin nhắn');
DEFINE ('_UDDEIM_EXPORT_MAILED', 'Đã gửi email kèm với các tin nhắn');
DEFINE ('_UDDEIM_EXPORT_NOW', 'Gửi email cho tôi các tin nhắn đã chọn');
DEFINE ('_UDDEIM_EXPORT_MAIL_INTRO', 'Email này bao gồm các tin nhắn của bạn.');
DEFINE ('_UDDEIM_EXPORT_COULDNOTSEND', 'Không thể gửi email kèm các tin nhắn.');
DEFINE ('_UDDEIM_LIMITREACHED', 'Tin nhắn đã đầy! Không thể lưu trữ tiếp.');
DEFINE ('_UDDEIM_WRITEMSGTO', 'Gửi tin nhắn tới ');

$udde_smon[1]="Tháng 1";
$udde_smon[2]="Tháng 2";
$udde_smon[3]="Tháng 3";
$udde_smon[4]="Tháng 4";
$udde_smon[5]="Tháng 5";
$udde_smon[6]="Tháng 6";
$udde_smon[7]="Tháng 7";
$udde_smon[8]="Tháng 8";
$udde_smon[9]="Tháng 9";
$udde_smon[10]="Tháng 10";
$udde_smon[11]="Tháng 11";
$udde_smon[12]="Tháng 12";

$udde_lmon[1]="Tháng 1";
$udde_lmon[2]="Tháng 2";
$udde_lmon[3]="Tháng 3";
$udde_lmon[4]="Tháng 4";
$udde_lmon[5]="Tháng 5";
$udde_lmon[6]="Tháng 6";
$udde_lmon[7]="Tháng 7";
$udde_lmon[8]="Tháng 8";
$udde_lmon[9]="Tháng 9";
$udde_lmon[10]="Tháng 10";
$udde_lmon[11]="Tháng 11";
$udde_lmon[12]="Tháng 12";

$udde_lweekday[0]="CN";
$udde_lweekday[1]="Thứ 2";
$udde_lweekday[2]="Thứ 3";
$udde_lweekday[3]="Thứ 4";
$udde_lweekday[4]="Thứ 5";
$udde_lweekday[5]="Thứ 6";
$udde_lweekday[6]="Thứ 7";

$udde_sweekday[0]="Chủ nhật";
$udde_sweekday[1]="Thứ 2";
$udde_sweekday[2]="Thứ 3";
$udde_sweekday[3]="Thứ 4";
$udde_sweekday[4]="Thứ 5";
$udde_sweekday[5]="Thứ 6";
$udde_sweekday[6]="Thứ 7";

// new in 0.5 ADMIN

DEFINE ('_UDDEADM_TEMPLATEDIR_HEAD', 'uddeIM Template');
DEFINE ('_UDDEADM_TEMPLATEDIR_EXP', 'Choose the template you want uddeIM to use');
DEFINE ('_UDDEADM_SHOWCONNEX_HEAD', 'Show connections');
DEFINE ('_UDDEADM_SHOWCONNEX_EXP', 'Use <b>yes</b> if you have CB/CBE/JS installed and want to display the user\'s connections on the compose new message page.');
DEFINE ('_UDDEADM_SHOWSETTINGSLINK_HEAD', 'Show settings');
DEFINE ('_UDDEADM_SHOWSETTINGSLINK_EXP', 'The settings link appears automatically in uddeIM if you have e-mail notification or the blocking system activated. You can specify its position and you can turn it off completely.');
DEFINE ('_UDDEADM_SHOWSETTINGS_ATBOTTOM', 'yes, at bottom');
DEFINE ('_UDDEADM_ALLOWBB_HEAD', 'Allow BB code tags');
DEFINE ('_UDDEADM_FONTFORMATONLY', 'font formats only');
DEFINE ('_UDDEADM_ALLOWBB_EXP', 'Use <b>font formats only</b> to allow users to use the BB code tags for bold, italic, underline, font color and font size. When you set this option to <b>yes</b>, users are allowed to use <b>all</b> supported BB code tags (e.g. links and images).');
DEFINE ('_UDDEADM_ALLOWSMILE_HEAD', 'Allow Emoticons');
DEFINE ('_UDDEADM_ALLOWSMILE_EXP', 'When set to <b>yes</b>, emoticon codes like :-) are replaced with emoticon graphics in message display.');
DEFINE ('_UDDEADM_DISPLAY', 'Display');
DEFINE ('_UDDEADM_SHOWMENUICONS_HEAD', 'Show Menu Icons');
DEFINE ('_UDDEADM_SHOWMENUICONS_EXP', 'When set to <b>yes</b>, menu links will be displayed using an icon.');
DEFINE ('_UDDEADM_SHOWTITLE_HEAD', 'Component Title');
DEFINE ('_UDDEADM_SHOWTITLE_EXP', 'Enter the headline of the private messaging component, for example \'Private Messages\'. Leave empty if you do not want to display a headline.');
DEFINE ('_UDDEADM_SHOWABOUT_HEAD', 'Show About link');
DEFINE ('_UDDEADM_SHOWABOUT_EXP', 'Set to <b>yes</b> to show a link to the uddeIM software credits and license. This link will be placed at the bottom of the uddeIM output.');
DEFINE ('_UDDEADM_STOPALLEMAIL_HEAD', 'Stop e-mail');
DEFINE ('_UDDEADM_STOPALLEMAIL_EXP', 'Check this box to prevent uddeIM from sending out e-mails (e-mail notifications and forgetmenot e-mails) irrespective of the users\' settings, for example when testing the site.');
DEFINE ('_UDDEADM_GETPICLINK_HEAD', 'CB thumbnails in lists');
DEFINE ('_UDDEADM_GETPICLINK_EXP', 'Set to <b>yes</b> if you want to display Community Builder thumbnails in the message lists overview (inbox, outbox, etc.)');

// new in 0.5 FRONTEND

DEFINE ('_UDDEIM_SHOWUSERS', 'Xem thành viên');
DEFINE ('_UDDEIM_CONNECTIONS', 'Bạn bè');
DEFINE ('_UDDEIM_SETTINGS', 'Cấu hình');
DEFINE ('_UDDEIM_NOSETTINGS', 'Không có thiết lập nào được áp dụng.');
DEFINE ('_UDDEIM_ABOUT', 'About'); // as in "About uddeIM"
DEFINE ('_UDDEIM_COMPOSE', 'Soạn tin'); // as in "write new message", but only one word
DEFINE ('_UDDEIM_EMN', 'Thông báo qua Email');
DEFINE ('_UDDEIM_EMN_EXP', 'Cấu hình thông báo tin nhắn mới.');
DEFINE ('_UDDEIM_EMN_ALWAYS', 'Thông báo qua email nếu có tin nhắn mới');
DEFINE ('_UDDEIM_EMN_NONE', 'Không thông báo qua email');
DEFINE ('_UDDEIM_EMN_WHENOFFLINE', 'Thông báo qua email khi không online');
DEFINE ('_UDDEIM_EMN_NOTONREPLY', 'Không gửi thông báo với các thư trả lời');
DEFINE ('_UDDEIM_BLOCKSYSTEM', 'Chặn thành viên'); // Headline for blocking system in settings
DEFINE ('_UDDEIM_BLOCKSYSTEM_EXP', 'Bạn có thể chặn các thành viên để ngăn họ gửi tin nhắn tới bạn. Chọn <b>chặn</b> khi bạn xem tin nhắn từ họ.'); // block user is the same as _UDDEIM_BLOCKNOW
DEFINE ('_UDDEIM_SAVECHANGE', 'Lưu thay đổi');
DEFINE ('_UDDEIM_TOOLTIP_BOLD', 'BB code tags to produce bold text. Usage: [b]bold[/b]');
DEFINE ('_UDDEIM_TOOLTIP_ITALIC', 'BB code tags to produce italic text. Usage: [i]italic[/i]');
DEFINE ('_UDDEIM_TOOLTIP_UNDERLINE', 'BB code tags to produce underlined text. Usage: [u]underline[/u]');
DEFINE ('_UDDEIM_TOOLTIP_COLORRED', 'BB code tags to produce coloured letters. Usage [color=#XXXXXX]colored[/color] where XXXXXX is the hex code of the colour you want, for example FF0000 for red.');
DEFINE ('_UDDEIM_TOOLTIP_COLORGREEN', 'BB code tags to produce coloured letters. Usage [color=#XXXXXX]colored[/color] where XXXXXX is the hex code of the colour you want, for example 00FF00 for green.');
DEFINE ('_UDDEIM_TOOLTIP_COLORBLUE', 'BB code tags to produce coloured letters. Usage [color=#XXXXXX]colored[/color] where XXXXXX is the hex code of the colour you want, for example 0000FF for blue.');
DEFINE ('_UDDEIM_TOOLTIP_FONTSIZE1', 'BB code tags to produce very small letters. Usage: [size=1]very small text.[/size]');
DEFINE ('_UDDEIM_TOOLTIP_FONTSIZE2', 'BB code tags to produce small letters. Usage: [size=2] small text.[/size]');
DEFINE ('_UDDEIM_TOOLTIP_FONTSIZE4', 'BB code tags to produce big letters. Usage: [size=4]big text.[/size]');
DEFINE ('_UDDEIM_TOOLTIP_FONTSIZE5', 'BB code tags to produce very big letters. Usage: [size=5]very big text.[/size]');
DEFINE ('_UDDEIM_TOOLTIP_IMAGE', 'BB code tags to insert a link to an image. Usage: [img]Image-URL[/img]');
DEFINE ('_UDDEIM_TOOLTIP_URL', 'BB code tags to insert a hyperlink. Usage: [url]web address[/url]. Do not forget the http:// at the beginning of the web address.');
DEFINE ('_UDDEIM_TOOLTIP_CLOSEALLTAGS', 'Close all open BB code tags.');
