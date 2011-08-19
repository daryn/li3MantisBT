<?php

# Temporary file to insert the default settings for MantisBT into the database
# This should be whever the installation scripts end up.  Here now to allow building
# other parts of the app.

$sql = 'SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";';
$sql .= 'SET time_zone = "+00:00";';

# Table structure for table `settings`
$sql .= 'CREATE TABLE IF NOT EXISTS `settings` (';
$sql .= '	`id` int(11) NOT NULL AUTO_INCREMENT,';
$sql .= '	`name` varchar(64) NOT NULL,';
$sql .= '	`access_reqd` int(11) DEFAULT \'0\',';
$sql .= '	`type` int(11) DEFAULT ADMINISTRATOR,';
$sql .= '	`value` longtext NOT NULL,';
$sql .= '	`group` varchar(64) DEFAULT \'\',';
$sql .= '	`can_override` tinyint(1) NOT NULL,';
$sql .= '	PRIMARY KEY (`id`),';
$sql .= '	UNIQUE KEY `name` (`name`)';
$sql .= ') ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;';

/**
 *	name - the string name of the setting
 *	access_reqd - level of access required to modify the setting
 *	type - the type of the value for the setting ( 1-default, 1-integer, 2-string, 3-complex )
 *	value - The value of the setting
 *	group - The name of a group the setting should be displayed with for editing
 *	can_override - Boolean to allow some settings to be configured by other users.
 */

$sql .= "INSERT INTO settings ( 'name', 'access_reqd', 'type', 'value', 'group', 'can_override' )  VALUES";

# most of these paths can probably go away
# The path should be configured during installation
$sql .= "( 'path', " . ADMINISTRATOR . ", '2', 'http://localhost/mantisbt/', 'General', 0 ),"
$sql .= "( 'icon_path', " . ADMINISTRATOR . ", '2', '%path%images/', 'General', 0 ),";
$sql .= "( 'short_path', " . ADMINISTRATOR . ", '2', '$t_path', 'General', 0 ),";
$sql .= "( 'absolute_path', " . ADMINISTRATOR . ", '2', '" . realpath( dirname( __FILE__ ) . '/../..' ) . '/webroot/' . "', 'General', 0 ),";
$sql .= "( 'custom_strings_file', " . ADMINISTRATOR . ", '2', CONFIG_PATH . '/custom_strings_inc.php', 'General', 0 ),";
$sql .= "( 'manual_url', " . ADMINISTRATOR . ", '2', 'http://www.mantisbt.org/docs/master-1.2.x/', 'General', 0 ),";

$sql .= "( 'session_handler', " . ADMINISTRATOR . ", '2', 'php', 'Web Server', 0 ),";
$sql .= "( 'session_save_path', " . ADMINISTRATOR . ", '2', '', 'Web Server', 0 ), -- true/false @todo check this";
$sql .= "( 'session_validation', " . ADMINISTRATOR . ", '2', '1', 'Web Server', 0 ), -- true/false @todo check this";
$sql .= "( 'form_security_validation', " . ADMINISTRATOR . ", '2', '1', 'Web Server', 0 ), -- true/false";

# default is empty. this actually is excluded from the db so configure this on install
$sql .= "-- ( 'crypto_master_salt', " . ADMINISTRATOR . ", '2', '', 'Security and Cryptography', 0 ),";


$sql .= "( 'allow_signup', " . ADMINISTRATOR . ", '2', '1', 'Signup and Lost Password', '0' ),"; # true/false
$sql .= "( 'max_failed_login_count', " . ADMINISTRATOR . ", '2', '0', 'Signup and Lost Password', '0' ),"; # true/false

$sql .= "( 'notify_new_user_created_threshold_min', " . ADMINISTRATOR . ", '2'," . ADMINISTRATOR . ", 'Signup and Lost Password', '0' ),";
$sql .= "( 'send_reset_password_on', " . ADMINISTRATOR . ", '2', '1', 'Signup and Lost Password', '0' ), -- true/false";
$sql .= "( 'signup_use_captcha', " . ADMINISTRATOR . ", '2', '1', 'Signup and Lost Password', '0' ), -- true/false";
$sql .= "( 'system_font_folder', " . ADMINISTRATOR . ", '2', 'Signup and Lost Password', '' ),";
$sql .= "( 'font_per_captcha', " . ADMINISTRATOR . ", '2', 'arial.ttf', 'Signup and Lost Password', '0' ),";
$sql .= "( 'lost_password_feature', " . ADMINISTRATOR . ", '2', '1', 'Signup and Lost Password', '0' ), --true/false";
$sql .= "( 'max_lost_password_in_progress_count', " . ADMINISTRATOR . ", '2', '3', 'Signup and Lost Password', '0' ),";

# Email Settings
$sql .= "( 'webmaster_email', ADMINISTRATOR, '2', 'webmaster@example.com', 'Email Settings', '0' ),";
$sql .= "( 'from_email', ADMINISTRATOR, '2', 'noreply@example.com', 'Email Settings', '0' ),";
$sql .= "( 'from_name', ADMINISTRATOR, '2', 'Mantis Bug Tracker', 'Email Settings', '0' ),";
$sql .= "( 'return_path_email', ADMINISTRATOR, '2', 'admin@example.com', 'Email Settings', '0' ),";
$sql .= "( 'enable_email_notifications', ADMINISTRATOR, '2', '1', 'Email Settings', '0' ), -- true/false";

/**
 * The following two config options allow you to control who should get email
 * notifications on different actions/statuses.  The first option
 * (default_notify_flags) sets the default values for different user
 * categories.  The user categories are:
 *
 *      'reporter': the reporter of the bug
 *       'handler': the handler of the bug
 *       'monitor': users who are monitoring a bug
 *      'bugnotes': users who have added a bugnote to the bug
 *      'explicit': users who are explicitly specified by the code based on the
 *                  action (e.g. user added to monitor list).
 * 'threshold_max': all users with access <= max
 * 'threshold_min': ..and with access >= min
 *
 * The second config option (notify_flags) sets overrides for specific
 * actions/statuses. If a user category is not listed for an action, the
 * default from the config option above is used.  The possible actions are:
 *
 *             'new': a new bug has been added
 *           'owner': a bug has been assigned to a new owner
 *        'reopened': a bug has been reopened
 *         'deleted': a bug has been deleted
 *         'updated': a bug has been updated
 *         'bugnote': a bugnote has been added to a bug
 *         'sponsor': sponsorship has changed on this bug
 *        'relation': a relationship has changed on this bug
 *         'monitor': an issue is monitored.
 *        '<status>': eg: 'resolved', 'closed', 'feedback', 'acknowledged', etc.
 *                     this list corresponds to $g_status_enum_string
 *
 * If you wanted to have all developers get notified of new bugs you might add
 * the following lines to your config file:
 *
 * $g_notify_flags['new']['threshold_min'] = DEVELOPER;
 * $g_notify_flags['new']['threshold_max'] = DEVELOPER;
 *
 * You might want to do something similar so all managers are notified when a
 * bug is closed.  If you didn't want reporters to be notified when a bug is
 * closed (only when it is resolved) you would use:
 *
 * $g_notify_flags['closed']['reporter'] = OFF;
 *
 * @global array $g_default_notify_flags
 */

( 'default_notify_flags', ADMINISTRATOR, '2', '', 'Notification', 0 ),
-- $g_default_notify_flags = array( 'reporter'=> ON, 'handler'=> ON, 'monitor'=> ON, 'bugnotes'=> ON, 'explicit'=> ON, 'threshold_min' => NOBODY, 'threshold_max' => NOBODY );

( 'notify_flags', ADMINISTRATOR, '2', '', 'Notification', 0 ),
/**
 * We don't need to send these notifications on new bugs
 * (see above for info on this config option)
 * @todo (though I'm not sure they need to be turned off anymore
 *      - there just won't be anyone in those categories)
 *      I guess it serves as an example and a placeholder for this
 *      config option
 * @see $g_default_notify_flags
 * @global array $g_notify_flags
 */
-- $g_notify_flags['new'] = array( 'bugnotes' => OFF, 'monitor'  => OFF );
-- $g_notify_flags['monitor'] = array('reporter'=> OFF,'handler'=>OFF,'monitor'=>OFF,'bugnotes'=>OFF,'explicit'=>ON,'threshold_min'=>NOBODY,'threshold_max'=>NOBODY);

( 'email_receive_own', ADMINISTRATOR, '2', '0', 'Email Settings', '0' ), -- true/false
( 'validate_email', ADMINISTRATOR, '2', '1', 'Email Settings', '0' ), -- true/false
( 'check_mx_record', ADMINISTRATOR, '2', '0', 'Email Settings', '0' ), -- true/false
( 'allow_blank_email', ADMINISTRATOR, '2', '0', 'Email Settings', '0' ), -- true/false
( 'limit_email_domain', ADMINISTRATOR, '2', '0', 'Email Settings', '0' ),
( 'show_user_email_threshold', ADMINISTRATOR, '2', NOBODY, 'Email Settings', '0' ),
( 'show_user_realname_threshold', ADMINISTRATOR, '2', NOBODY, 'Email Settings', '0' ),
( 'mail_priority', ADMINISTRATOR, '2', '3', 'Email Settings', '0' ),
( 'phpMailer_method', ADMINISTRATOR, '2', PHPMAILER_METHOD_MAIL, 'Email Settings', '0' ),
( 'smtp_host', ADMINISTRATOR, '2', 'localhost', 'Email Settings', '0' ),
( 'smtp_username', ADMINISTRATOR, '2', '', 'Email Settings', '0' ),
( 'smtp_password', ADMINISTRATOR, '2', '', 'Email Settings', '0' ),
( 'smtp_connection_mode', ADMINISTRATOR, '2', '', 'Email Settings', '0' ),
( 'smtp_port', ADMINISTRATOR, '2', '25', 'Email Settings', '0' ),
( 'email_send_using_cronjob', ADMINISTRATOR, '2', '0', 'Email Settings', '0' ), -- true/false
( 'email_set_category', ADMINISTRATOR, '2', '0', 'Email Settings', '0' ), -- true/false
( 'email_separator1', ADMINISTRATOR, '2', '======================================================================', 'Email Settings', '0' ),
( 'email_separator2', ADMINISTRATOR, '2', '----------------------------------------------------------------------', 'Email Settings', '0' ),
( 'email_padding_length', ADMINISTRATOR, '2', '28', 'Email Settings', '0' ),

-- MantisBT Version String *
( 'show_version', ADMINISTRATOR, '2', OFF, 'General', '0' ),
( 'version_suffix', ADMINISTRATOR, '2', '', 'General', '0' ),
( 'copyright_statement', ADMINISTRATOR, '2', '', 'General', '0' ),

-- MantisBT Language Settings *
( 'default_language', ADMINISTRATOR, '2', 'auto', 'Globalization', '0' ),
( 'language_choices', ADMINISTRATOR, '2', '', 'Globalization', '0' ),
-- $g_language_choices_arr	= array( 'auto', 'afrikaans', 'amharic', 'arabic', 'arabicegyptianspoken', 'breton', 'bulgarian', 'catalan', 'chinese_simplified', 'chinese_traditional', 'croatian', 'czech', 'danish', 'dutch', 'english', 'estonian', 'finnish', 'french', 'galician', 'german', 'greek', 'hebrew', 'hungarian', 'icelandic', 'italian', 'japanese', 'korean', 'latvian', 'lithuanian', 'macedonian', 'norwegian_bokmal', 'norwegian_nynorsk', 'occitan', 'polish', 'portuguese_brazil', 'portuguese_standard', 'ripoarisch', 'romanian', 'russian', 'serbian', 'slovak', 'slovene', 'spanish', 'swissgerman', 'swedish', 'tagalog', 'turkish', 'ukrainian', 'urdu', 'volapuk', );

( 'language_auto_map', ADMINISTRATOR, '2', '', 'Globalization', '0' ),
--$g_language_auto_map = array( 'af' => 'afrikaans', 'am' => 'amharic', 'ar' => 'arabic', 'arz' => 'arabicegyptianspoken', 'bg' => 'bulgarian', 'br' => 'breton', 'ca' => 'catalan', 'zh-cn, zh-sg, zh' => 'chinese_simplified', 'zh-hk, zh-tw' => 'chinese_traditional', 'cs' => 'czech', 'da' => 'danish', 'nl-be, nl' => 'dutch', 'en-us, en-gb, en-au, en' => 'english', 'et' => 'estonian', 'fi' => 'finnish', 'fr-ca, fr-be, fr-ch, fr' => 'french', 'gl' => 'galician', 'gsw' => 'swissgerman', 'de-de, de-at, de-ch, de' => 'german', 'he' => 'hebrew', 'hu' => 'hungarian', 'hr' => 'croatian', 'is' => 'icelandic', 'it-ch, it' => 'italian', 'ja' => 'japanese', 'ko' => 'korean', 'ksh' => 'ripoarisch', 'lt' => 'lithuanian', 'lv' => 'latvian', 'mk' => 'macedonian', 'no' => 'norwegian_bokmal', 'nn' => 'norwegian_nynorsk', 'oc' => 'occitan', 'pl' => 'polish', 'pt-br' => 'portuguese_brazil', 'pt' => 'portuguese_standard', 'ro-mo, ro' => 'romanian', 'ru-mo, ru-ru, ru-ua, ru' => 'russian', 'sr' => 'serbian', 'sk' => 'slovak', 'sl' => 'slovene', 'es-mx, es-co, es-ar, es-cl, es-pr, es' => 'spanish', 'sv-fi, sv' => 'swedish', 'tl' => 'tagalog', 'tr' => 'turkish', 'uk' => 'ukrainian', 'vo' => 'volapuk', );

( 'fallback_language', ADMINISTRATOR, '2', 'english', 'Globalization', '0' ),

-- MantisBT Display Settings *
( 'window_title', ADMINISTRATOR, '2', 'MantisBT', 'Templates', '0' ),
( 'page_title', ADMINISTRATOR, '2', '', 'Templates', '0' ),
( 'favicon_image', ADMINISTRATOR, '2', 'images/favicon.ico', 'Templates', '0' ),
( 'logo_image', ADMINISTRATOR, '2', 'images/mantis_logo.gif', 'Templates', '0' ),
( 'logo_url', ADMINISTRATOR, '2', '%default_home_page%', 'Templates', '0' ),
( 'enable_project_documentation', ADMINISTRATOR, '2', OFF, 'Templates', '0' ),
( 'show_footer_menu', ADMINISTRATOR, '2', OFF, 'Templates', '0' ),

-- show_project_menu_bar should be renamed for different css/template styles
( 'show_project_menu_bar', ADMINISTRATOR, '2', OFF, 'Templates', '0' ),

( 'show_assigned_names', ADMINISTRATOR, '2', ON, 'Templates', '0' ),
( 'show_priority_text', ADMINISTRATOR, '2', OFF, 'Templates', '0' ),
( 'priority_significant_threshold', ADMINISTRATOR, '2', 'HIGH', 'Templates', '0' ),
( 'severity_significant_threshold', ADMINISTRATOR, '2', 'MAJOR', 'Templates', '0' ),

( 'view_issues_page_columns', ADMINISTRATOR, '2', '', 'Templates', '0' ),
-- $g_view_issues_page_columns = array ( 'selection', 'edit', 'priority', 'id', 'sponsorship_total', 'bugnotes_count', 'attachment', 'category_id', 'severity', 'status', 'last_updated', 'summary');

( 'print_issues_page_columns', ADMINISTRATOR, '2', '', 'Templates', '0' ),
-- $g_print_issues_page_columns = array ( 'selection', 'priority', 'id', 'sponsorship_total', 'bugnotes_count', 'attachment', 'category_id', 'severity', 'status', 'last_updated', 'summary');

( 'csv_issues_page_columns', ADMINISTRATOR, '2', '', 'Templates', '0' ),
-- $g_csv_columns = array ( 'id', 'project_id', 'reporter_id', 'handler_id', 'priority', 'severity', 'reproducibility', 'version', 'projection', 'category_id', 'date_submitted', 'eta', 'os', 'os_build', 'platform', 'view_state', 'last_updated', 'summary', 'status', 'resolution', 'fixed_in_version');

( 'excel_issues_page_columns', ADMINISTRATOR, '2', '', 'Templates', '0' ),
-- $g_excel_columns = array ( 'id', 'project_id', 'reporter_id', 'handler_id', 'priority', 'severity', 'reproducibility', 'version', 'projection', 'category_id', 'date_submitted', 'eta', 'os', 'os_build', 'platform', 'view_state', 'last_updated', 'summary', 'status', 'resolution', 'fixed_in_version');

( 'show_bug_project_links', ADMINISTRATOR, '2', ON, 'Templates', '0' ),
( 'status_legend_position', ADMINISTRATOR, '2', 'STATUS_LEGEND_POSITION_BOTTOM', 'Templates', '0' ),
( 'status_percent_legend', ADMINISTRATOR, '2', OFF, 'Templates', '0' ),
( 'filter_position', ADMINISTRATOR, '2', 'FILTER_POSITION_TOP', 'Templates', '0' ),
( 'action_button_position', ADMINISTRATOR, '2', 'POSITION_BOTTOM', 'Templates', '0' ),
( 'show_product_version', ADMINISTRATOR, '2', 'AUTO', 'Templates', '0' ),
( 'show_version_dates_threshold', ADMINISTRATOR, '2', NOBODY, 'Templates', '0' ),
( 'show_realname', ADMINISTRATOR, '2', OFF, 'Templates', '0' ),
( 'differentiate_duplicates', ADMINISTRATOR, '2', OFF, 'Templates', '0' ), -- not complete
( 'sort_by_last_name', ADMINISTRATOR, '2', OFF, 'Templates', '0' ),
( 'show_avatar', ADMINISTRATOR, '2', OFF, 'Templates', '0' ),
( 'show_avatar_threshold', ADMINISTRATOR, '2', DEVELOPER, 'Templates', '0' ),
( 'default_avatar', ADMINISTRATOR, '2', '%path%images/no_avatar.png', 'Templates', '0' ),
( 'show_changelog_dates', ADMINISTRATOR, '2', ON, 'Templates', '0' ),
( 'show_roadmap_dates', ADMINISTRATOR, '2', ON, 'Templates', '0' ),

-- MantisBT Time Settings *
( 'cookie_time_length', ADMINISTRATOR, '2', '30000000', 'Expiries', '0' ),
( 'content_expire', ADMINISTRATOR, '2', '0', 'Expiries', '0' ),
( 'long_process_timeout', ADMINISTRATOR, '2', '0', 'Expiries', '0' ),

-- MantisBT Date Settings *
( 'short_date_format', ADMINISTRATOR, '2', 'Y-m-d', 'Date/Time', '0' ),
( 'normal_date_format', ADMINISTRATOR, '2', 'Y-m-d H:i', 'Date/Time', '0' ),
( 'complete_date_format', ADMINISTRATOR, '2', 'Y-m-d H:i T', 'Date/Time', '0' ),
( 'calendar_js_date_format', ADMINISTRATOR, '2', '\%Y-\%m-\%d \%H:\%M', 'Date/Time', '0' ),
( 'calendar_date_format', ADMINISTRATOR, '2', 'Y-m-d H:i', 'Date/Time', '0' ),
( 'default_timezone', ADMINISTRATOR, '2', '', 'Date/Time', '0' ),

-- MantisBT News Settings *
( 'news_enabled', ADMINISTRATOR, '2', OFF, 'News', '0' ),
( 'news_limit_method', ADMINISTRATOR, '2', 'BY_LIMIT', 'News', '0' ),
( 'news_view_limit', ADMINISTRATOR, '2', '7', 'News', '0' ),
( 'news_view_limit_days', ADMINISTRATOR, '2', '30', 'News', '0' ),
( 'private_news_threshold', ADMINISTRATOR, '2', DEVELOPER, 'News', '0' ),

-- MantisBT Default Preferences *
( 'admin_checks', ADMINISTRATOR, '2', ON, 'General', '0' ),
( 'reauthentication', ADMINISTRATOR, '2', ON, 'General', '0' ),
( 'reauthentication_expiry', ADMINISTRATOR, '2', 'TOKEN_EXPIRY_AUTHENTICATED', 'General', '0' ),

( 'default_new_account_access_level', ADMINISTRATOR, '2', REPORTER, 'General', '0' ),
( 'default_bug_view_status', ADMINISTRATOR, '2', 'VS_PUBLIC', 'General', '0' ),
( 'default_bug_steps_to_reproduce', ADMINISTRATOR, '2', '', 'General', '0' ),
( 'default_bug_additional_info', ADMINISTRATOR, '2', '', 'General', '0' ),
( 'default_bugnote_view_status', ADMINISTRATOR, '2', 'VS_PUBLIC', 'General', '0' ),
( 'default_bug_resolution', ADMINISTRATOR, '2', 'OPEN', 'General', '0' ),
( 'default_bug_severity', ADMINISTRATOR, '2', 'MINOR', 'General', '0' ),
( 'default_bug_priority', ADMINISTRATOR, '2', 'NORMAL', 'General', '0' ),
( 'default_bug_reproducibility', ADMINISTRATOR, '2', 'REPRODUCIBILITY_HAVENOTTRIED', 'General', '0' ),
( 'default_bug_projection', ADMINISTRATOR, '2', 'PROJECTION_NONE', 'General', '0' ),
( 'default_bug_eta', ADMINISTRATOR, '2', 'ETA_NONE', 'General', '0' ),
( 'default_category_for_moves', ADMINISTRATOR, '2', '1', 'General', '0' ),
( 'default_limit_view', ADMINISTRATOR, '2', '50', 'General', '0' ),
( 'default_show_changed', ADMINISTRATOR, '2', '6', 'General', '0' ),
( 'hide_status_default', ADMINISTRATOR, '2', 'CLOSED', 'General', '0' ),
( 'show_sticky_issues', ADMINISTRATOR, '2', ON, 'General', '0' ),
( 'min_refresh_delay', ADMINISTRATOR, '2', '10', 'General', '0' ),
( 'default_refresh_delay', ADMINISTRATOR, '2', '30', 'General', '0' ),
( 'default_redirect_delay', ADMINISTRATOR, '2', '2', 'General', '0' ),
( 'default_bugnote_order', ADMINISTRATOR, '2', 'ASC', 'General', '0' ),

( 'default_email_on_new', ADMINISTRATOR, '2', ON, 'Notifications', '0' ),
( 'default_email_on_assigned', ADMINISTRATOR, '2', ON, 'Notifications', '0' ),
( 'default_email_on_feedback', ADMINISTRATOR, '2', ON, 'Notifications', '0' ),
( 'default_email_on_resolved', ADMINISTRATOR, '2', ON, 'Notifications', '0' ),
( 'default_email_on_closed', ADMINISTRATOR, '2', ON, 'Notifications', '0' ),
( 'default_email_on_reopened', ADMINISTRATOR, '2', ON, 'Notifications', '0' ),
( 'default_email_on_bugnote', ADMINISTRATOR, '2', ON, 'Notifications', '0' ),
( 'default_email_on_status', ADMINISTRATOR, '2', '0', 'Notifications', '0' ),
( 'default_email_on_priority', ADMINISTRATOR, '2', '0', 'Notifications', '0' ),
( 'default_email_on_new_minimum_severity', ADMINISTRATOR, '2', OFF, 'Notifications', '0' ),
( 'default_email_on_assigned_minimum_severity', ADMINISTRATOR, '2', OFF, 'Notifications', '0' ),
( 'default_email_on_feedback_minimum_severity', ADMINISTRATOR, '2', OFF, 'Notifications', '0' ),
( 'default_email_on_resolved_minimum_severity', ADMINISTRATOR, '2', OFF, 'Notifications', '0' ),
( 'default_email_on_closed_minimum_severity', ADMINISTRATOR, '2', OFF, 'Notifications', '0' ),
( 'default_email_on_reopened_minimum_severity', ADMINISTRATOR, '2', OFF, 'Notifications', '0' ),
( 'default_email_on_bugnote_minimum_severity', ADMINISTRATOR, '2', OFF, 'Notifications', '0' ),
( 'default_email_on_status_minimum_severity', ADMINISTRATOR, '2', OFF, 'Notifications', '0' ),
( 'default_email_on_priority_minimum_severity', ADMINISTRATOR, '2', OFF, 'Notifications', '0' ),
( 'default_email_bugnote_limit', ADMINISTRATOR, '2', '0', 'General', '0' ),

-- MantisBT Summary Settings *
( 'reporter_summary_limit', ADMINISTRATOR, '2', '10', 'Summary', '0' ),
( 'date_partitions', ADMINISTRATOR, '2', '', 'Summary', '0' ),
-- $g_date_partitions = array( 1, 2, 3, 7, 30, 60, " . ADMINISTRATOR . ", 180, 365);
( 'summary_category_include_project', ADMINISTRATOR, '2', OFF, 'Summary', '0' ),
( 'view_summary_threshold', ADMINISTRATOR, '2', MANAGER, 'Summary', '0' ),
( 'severity_multipliers', ADMINISTRATOR, '2', '', 'Summary', '0' ),
-- $g_severity_multipliers = array( FEATURE => 1, TRIVIAL => 2, TEXT=> 3, TWEAK=> 2, MINOR=> 5, MAJOR=> 8, CRASH=> 8, BLOCK=> 10);
( 'resolution_multipliers', ADMINISTRATOR, '2', '', 'Summary', '0' ),
-- $g_resolution_multipliers = array( UNABLE_TO_DUPLICATE => 2, NOT_FIXABLE=> 1, DUPLICATE=> 3, NOT_A_BUG=> 5, SUSPENDED=> 1, WONT_FIX=> 1 );

-- MantisBT Bugnote Settings *
( 'bugnote_order', ADMINISTRATOR, '2', 'DESC', 'Bugnotes', '0' ),

-- MantisBT Bug History Settings *
( 'history_default_visible', ADMINISTRATOR, '2', ON, 'Bug History', '0' ),
( 'history_order', ADMINISTRATOR, '2', 'ASC', 'Bug History', '0' ),

-- MantisBT Reminder Settings *
( 'store_reminders', ADMINISTRATOR, '2', ON, 'Reminders', '0' ),
( 'reminder_recipients_monitor_bug', ADMINISTRATOR, '2', ON, 'Reminders', '0' ),
( 'default_reminder_view_status', ADMINISTRATOR, '2', 'VS_PUBLIC', 'Reminders', '0' ),
( 'reminder_receive_threshold', ADMINISTRATOR, '2', DEVELOPER, 'Reminders', '0' ),

-- MantisBT Sponsorship Settings *
( 'enable_sponsorship', ADMINISTRATOR, '2', OFF, 'Sponsorship', '0' ),
( 'sponsorship_currency', ADMINISTRATOR, '2', 'US$', 'Sponsorship', '0' ),
( 'view_sponsorship_total_threshold', ADMINISTRATOR, '2', VIEWER, 'Sponsorship', '0' ),
( 'view_sponsorship_details_threshold', ADMINISTRATOR, '2', VIEWER, 'Sponsorship', '0' ),
( 'sponsor_threshold', ADMINISTRATOR, '2', REPORTER, 'Sponsorship', '0' ),
( 'handle_sponsored_bugs_threshold', ADMINISTRATOR, '2', DEVELOPER, 'Sponsorship', '0' ),
( 'assign_sponsored_bugs_threshold', ADMINISTRATOR, '2', MANAGER, 'Sponsorship', '0' ),
( 'minimum_sponsorship_amount', ADMINISTRATOR, '2', '5', 'Sponsorship', '0' ),

-- MantisBT File Upload Settings *
( 'allow_file_upload', ADMINISTRATOR, '2', ON, 'File Uploads', '0' ),
( 'file_upload_method', ADMINISTRATOR, '2', DATABASE, 'File Uploads', '0' ),
( 'attachments_file_permissions', ADMINISTRATOR, '2', '0400', 'File Uploads', '0' ),
( 'file_upload_ftp_server', ADMINISTRATOR, '2', 'ftp.myserver.com', 'File Uploads', '0' ),
( 'file_upload_ftp_user', ADMINISTRATOR, '2', 'readwriteuser', 'File Uploads', '0' ),
( 'file_upload_ftp_pass', ADMINISTRATOR, '2', 'readwritepass', 'File Uploads', '0' ),
( 'max_file_size', ADMINISTRATOR, '2', '5000000', 'File Uploads', '0' ),
( 'allowed_files', ADMINISTRATOR, '2', '', 'File Uploads', '0' ),
( 'disallowed_files', ADMINISTRATOR, '2', '', 'File Uploads', '0' ),
( 'document_files_prefix', ADMINISTRATOR, '2', 'doc', 'File Uploads', '0' ),
( 'absolute_path_default_upload_folder', ADMINISTRATOR, '2', '', 'File Uploads', '0' ),
( 'file_download_xsendfile_enabled', ADMINISTRATOR, '2', OFF, 'File Uploads', '0' ),
( 'file_download_xsendfile_header_name', ADMINISTRATOR, '2', 'X-Sendfile', 'File Uploads', '0' ),

-- MantisBT HTML Settings *
( 'html_make_links', ADMINISTRATOR, '2', ON, 'HTML', '0' ),
( 'html_valid_tags', ADMINISTRATOR, '2', 'p, li, ul, ol, br, pre, i, b, u, em, strong', 'HTML', '0' ),
( 'html_valid_tags_single_line', ADMINISTRATOR, '2', 'i, b, u, em, strong', 'HTML', '0' ),
( 'max_dropdown_length', ADMINISTRATOR, '2', '40', 'HTML', '0' ),
( 'wrap_in_preformatted_text', ADMINISTRATOR, '2', ON, 'HTML', '0' ),
( 'hr_size', ADMINISTRATOR, '2', '1', 'HTML', '0' ),
( 'hr_width', ADMINISTRATOR, '2', '50', 'HTML', '0' ),

-- MantisBT LDAP Settings *
( 'ldap_server', ADMINISTRATOR, '2', 'ldaps://ldap.example.com.au', 'LDAP', '0' ),
( 'ldap_root_dn', ADMINISTRATOR, '2', 'dc=example,dc=com,dc=au', 'LDAP', '0' ),
( 'ldap_organization', ADMINISTRATOR, '2', '', 'LDAP', '0' ),
( 'ldap_uid_field', ADMINISTRATOR, '2', 'uid', 'LDAP', '0' ),
( 'ldap_realname_field', ADMINISTRATOR, '2', 'cn', 'LDAP', '0' ),
( 'ldap_bind_dn', ADMINISTRATOR, '2', '', 'LDAP', '0' ),
( 'ldap_bind_passwd', ADMINISTRATOR, '2', '', 'LDAP', '0' ),
( 'use_ldap_email', ADMINISTRATOR, '2', OFF, 'LDAP', '0' ),
( 'use_ldap_realname', ADMINISTRATOR, '2', OFF, 'LDAP', '0' ),
( 'ldap_protocol_version', ADMINISTRATOR, '2', '0', 'LDAP', '0' ),
( 'ldap_follow_referrals', ADMINISTRATOR, '2', ON, 'LDAP', '0' ),
( 'ldap_simulation_file_path', ADMINISTRATOR, '2', '', 'LDAP', '0' ),

-- Status Settings *
( 'bug_submit_status', ADMINISTRATOR, '2', NEW_, 'Bug Status', '0' ),
( 'bug_assigned_status', ADMINISTRATOR, '2', ASSIGNED, 'Bug Status', '0' ),
( 'bug_reopen_status', ADMINISTRATOR, '2', FEEDBACK, 'Bug Status', '0' ),
( 'bug_feedback_status', ADMINISTRATOR, '2', FEEDBACK, 'Bug Status', '0' ),
( 'bug_reassign_on_feedback', ADMINISTRATOR, '2', ON, 'Bug Status', '0' ),
( 'bug_reopen_resolution', ADMINISTRATOR, '2', REOPENED, 'Bug Status', '0' ),
( 'bug_duplicate_resolution', ADMINISTRATOR, '2', DUPLICATE, 'Bug Status', '0' ),
( 'bug_readonly_status_threshold', ADMINISTRATOR, '2', RESOLVED, 'Bug Status', '0' ),
( 'bug_resolved_status_threshold', ADMINISTRATOR, '2', RESOLVED, 'Bug Status', '0' ),
( 'bug_resolution_fixed_threshold', ADMINISTRATOR, '2', FIXED, 'Bug Status', '0' ),
( 'bug_resolution_not_fixed_threshold', ADMINISTRATOR, '2', UNABLE_TO_DUPLICATE, 'Bug Status', '0' ),
( 'bug_closed_status_threshold', ADMINISTRATOR, '2', CLOSED, 'Bug Status', '0' ),
( 'auto_set_status_to_assigned', ADMINISTRATOR, '2', ON, 'Bug Status', '0' ),
( 'status_enum_workflow', ADMINISTRATOR, '2', '', 'Bug Status', '0' ),

-- Bug Attachments Settings *
( 'fileinfo_magic_db_file', ADMINISTRATOR, '2', '', 'Bug Attachments', '0' ),
( 'preview_attachments_inline_max_size', ADMINISTRATOR, '2', 256*1024, 'Bug Attachments', '0' ),
( 'preview_text_extensions', ADMINISTRATOR, '2', '', 'Bug Attachments', '0' ),
-- $g_preview_text_extensions = array( '', 'txt', 'diff', 'patch');

( 'preview_image_extensions', ADMINISTRATOR, '2', '', 'Bug Attachments', '0' ),
-- $g_preview_image_extensions = array( 'bmp', 'png', 'gif', 'jpg', 'jpeg');

( 'preview_max_width', ADMINISTRATOR, '2', '0', 'Bug Attachments', '0' ),
( 'preview_max_height', ADMINISTRATOR, '2', '250', 'Bug Attachments', '0' ),
( 'show_attachment_indicator', ADMINISTRATOR, '2', OFF, 'Bug Attachments', '0' ),
( 'inline_file_exts', ADMINISTRATOR, '2', 'gif,png,jpg,jpeg,bmp', 'Bug Attachments', '0' ),
( 'view_attachments_threshold', ADMINISTRATOR, '2', VIEWER, 'Bug Attachments', '0' ),
( 'download_attachments_threshold', ADMINISTRATOR, '2', VIEWER, 'Bug Attachments', '0' ),
( 'delete_attachments_threshold', ADMINISTRATOR, '2', DEVELOPER, 'Bug Attachments', '0' ),
( 'allow_view_own_attachments', ADMINISTRATOR, '2', ON, 'Bug Attachments', '0' ),
( 'allow_download_own_attachments', ADMINISTRATOR, '2', ON, 'Bug Attachments', '0' ),
( 'allow_delete_own_attachments', ADMINISTRATOR, '2', OFF, 'Bug Attachments', '0' ),

-- Field Visibility
( 'enable_eta', ADMINISTRATOR, '2', OFF, 'Field Visibilty', '0' ),
( 'enable_projection', ADMINISTRATOR, '2', OFF, 'Field Visibilty', '0' ),
( 'enable_product_build', ADMINISTRATOR, '2', OFF, 'Field Visibilty', '0' ),
( 'bug_report_page_fields', ADMINISTRATOR, '2', '', 'Field Visibilty', '0' ),
-- $g_bug_report_page_fields = array( 'additional_info', 'attachments', 'category_id', 'due_date', 'handler', 'os', 'os_version', 'platform', 'priority', 'product_build', 'product_version', 'reproducibility', 'severity', 'steps_to_reproduce', 'target_version', 'view_state',);

( 'bug_view_page_fields', ADMINISTRATOR, '2', '', 'Field Visibilty', '0' ),
-- $g_bug_view_page_fields = array ( 'additional_info', 'attachments', 'category_id', 'date_submitted', 'description', 'due_date', 'eta', 'fixed_in_version', 'handler', 'id', 'last_updated', 'os', 'os_version', 'platform', 'priority', 'product_build', 'product_version', 'project', 'projection', 'reporter', 'reproducibility', 'resolution', 'severity', 'status', 'steps_to_reproduce', 'summary', 'tags', 'target_version', 'view_state',);

( 'bug_print_page_fields', ADMINISTRATOR, '2', '', 'Field Visibilty', '0' ),
-- $g_bug_print_page_fields = array ( 'additional_info', 'attachments', 'category_id', 'date_submitted', 'description', 'due_date', 'eta', 'fixed_in_version', 'handler', 'id', 'last_updated', 'os', 'os_version', 'platform', 'priority', 'product_build', 'product_version', 'project', 'projection', 'reporter', 'reproducibility', 'resolution', 'severity', 'status', 'steps_to_reproduce', 'summary', 'tags', 'target_version', 'view_state',);

( 'bug_update_page_fields', ADMINISTRATOR, '2', '', 'Field Visibilty', '0' ),
-- $g_bug_update_page_fields = array ( 'additional_info', 'category_id', 'date_submitted', 'description', 'due_date', 'eta', 'fixed_in_version', 'handler', 'id', 'last_updated', 'os', 'os_version', 'platform', 'priority', 'product_build', 'product_version', 'project', 'projection', 'reporter', 'reproducibility', 'resolution', 'severity', 'status', 'steps_to_reproduce', 'summary', 'target_version', 'view_state',);

( 'bug_change_status_page_fields', ADMINISTRATOR, '2', '', 'Field Visibilty', '0' ),
-- $g_bug_change_status_page_fields = array ( 'additional_info', 'attachments', 'category_id', 'date_submitted', 'description', 'due_date', 'eta', 'fixed_in_version', 'handler', 'id', 'last_updated', 'os', 'os_version', 'platform', 'priority', 'product_build', 'product_version', 'project', 'projection', 'reporter', 'reproducibility', 'resolution', 'severity', 'status', 'steps_to_reproduce', 'summary', 'tags', 'target_version', 'view_state',);

-- MantisBT Misc Settings *
( 'report_bug_threshold', ADMINISTRATOR, '2', REPORTER, 'Access Thresholds', '0' ),
( 'update_bug_threshold', ADMINISTRATOR, '2', UPDATER, 'Access Thresholds', '0' ),
( 'monitor_bug_threshold', ADMINISTRATOR, '2', REPORTER, 'Access Thresholds', '0' ),
( 'monitor_add_others_bug_threshold', ADMINISTRATOR, '2', DEVELOPER, 'Access Thresholds', '0' ),
( 'monitor_delete_others_bug_threshold', ADMINISTRATOR, '2', DEVELOPER, 'Access Thresholds', '0' ),
( 'private_bug_threshold', ADMINISTRATOR, '2', DEVELOPER, 'Access Thresholds', '0' ),
( 'handle_bug_threshold', ADMINISTRATOR, '2', DEVELOPER, 'Access Thresholds', '0' ),
( 'update_bug_assign_threshold', ADMINISTRATOR, '2', '%handle_bug_threshold%', 'Access Thresholds', '0' ),
( 'private_bugnote_threshold', ADMINISTRATOR, '2', DEVELOPER, 'Access Thresholds', '0' ),
( 'view_handler_threshold', ADMINISTRATOR, '2', VIEWER, 'Access Thresholds', '0' ),
( 'view_history_threshold', ADMINISTRATOR, '2', VIEWER, 'Access Thresholds', '0' ),
( 'bug_reminder_threshold', ADMINISTRATOR, '2', DEVELOPER, 'Access Thresholds', '0' ),
( 'bug_revision_drop_threshold', ADMINISTRATOR, '2', MANAGER, 'Access Thresholds', '0' ),
( 'upload_project_file_threshold', ADMINISTRATOR, '2', MANAGER, 'Access Thresholds', '0' ),
( 'upload_bug_file_threshold', ADMINISTRATOR, '2', REPORTER, 'Access Thresholds', '0' ),
( 'add_bugnote_threshold', ADMINISTRATOR, '2', REPORTER, 'Access Thresholds', '0' ),
( 'update_bugnote_threshold', ADMINISTRATOR, '2', DEVELOPER, 'Access Thresholds', '0' ),
( 'view_proj_doc_threshold', ADMINISTRATOR, '2', ANYBODY, 'Access Thresholds', '0' ),
( 'manage_site_threshold', ADMINISTRATOR, '2', MANAGER, 'Access Thresholds', '0' ),
( 'admin_site_threshold', ADMINISTRATOR, '2', ADMINISTRATOR, 'Access Thresholds', '0' ),
( 'manage_project_threshold', ADMINISTRATOR, '2', MANAGER, 'Access Thresholds', '0' ),
( 'manage_news_threshold', ADMINISTRATOR, '2', MANAGER, 'Access Thresholds', '0' ),
( 'delete_project_threshold', ADMINISTRATOR, '2', ADMINISTRATOR, 'Access Thresholds', '0' ),
( 'create_project_threshold', ADMINISTRATOR, '2', ADMINISTRATOR, 'Access Thresholds', '0' ),
( 'private_project_threshold', ADMINISTRATOR, '2', ADMINISTRATOR, 'Access Thresholds', '0' ),
( 'project_user_threshold', ADMINISTRATOR, '2', MANAGER, 'Access Thresholds', '0' ),
( 'manage_user_threshold', ADMINISTRATOR, '2', ADMINISTRATOR, 'Access Thresholds', '0' ),
( 'delete_bug_threshold', ADMINISTRATOR, '2', DEVELOPER, 'Access Thresholds', '0' ),
( 'delete_bugnote_threshold', ADMINISTRATOR, '2', '%delete_bug_threshold%', 'Access Thresholds', '0' ),
( 'move_bug_threshold', ADMINISTRATOR, '2', DEVELOPER, 'Access Thresholds', '0' ),
( 'set_view_status_threshold', ADMINISTRATOR, '2', REPORTER, 'Access Thresholds', '0' ),
( 'change_view_status_threshold', ADMINISTRATOR, '2', UPDATER, 'Access Thresholds', '0' ),
( 'show_monitor_list_threshold', ADMINISTRATOR, '2', DEVELOPER, 'Access Thresholds', '0' ),
( 'stored_query_use_threshold', ADMINISTRATOR, '2', REPORTER, 'Access Thresholds', '0' ),
( 'stored_query_create_threshold', ADMINISTRATOR, '2', DEVELOPER, 'Access Thresholds', '0' ),
( 'stored_query_create_shared_threshold', ADMINISTRATOR, '2', MANAGER, 'Access Thresholds', '0' ),
( 'update_readonly_bug_threshold', ADMINISTRATOR, '2', MANAGER, 'Access Thresholds', '0' ),
( 'view_changelog_threshold', ADMINISTRATOR, '2', VIEWER, 'Access Thresholds', '0' ),
( 'view_roadmap_threshold', ADMINISTRATOR, '2', VIEWER, 'Access Thresholds', '0' ), -- @todo this originally was roadmap_view_threshold. consider when migrating old sites
( 'update_roadmap_threshold', ADMINISTRATOR, '2', DEVELOPER, 'Access Thresholds', '0' ), -- @todo this originally was roadmap_update_threshold. consider when migrating old sites
( 'update_bug_status_threshold', ADMINISTRATOR, '2', DEVELOPER, 'Access Thresholds', '0' ),
( 'reopen_bug_threshold', ADMINISTRATOR, '2', DEVELOPER, 'Access Thresholds', '0' ),
( 'report_issues_for_unreleased_versions_threshold', ADMINISTRATOR, '2', DEVELOPER, 'Access Thresholds', '0' ),
( 'set_bug_sticky_threshold', ADMINISTRATOR, '2', MANAGER, 'Access Thresholds', '0' ),
( 'development_team_threshold', ADMINISTRATOR, '2', DEVELOPER, 'Access Thresholds', '0' ),
( 'set_status_threshold', ADMINISTRATOR, '2', '', 'Access Thresholds', '0' ),
( 'bugnote_user_edit_threshold', ADMINISTRATOR, '2', '%update_bugnote_threshold%', 'Access Thresholds', '0' ),
( 'bugnote_user_delete_threshold', ADMINISTRATOR, '2', '%delete_bugnote_threshold%', 'Access Thresholds', '0' ),
( 'bugnote_user_change_view_state_threshold', ADMINISTRATOR, '2', '%change_view_status_threshold%', 'Access Thresholds', '0' ),
( 'manage_configuration_threshold', ADMINISTRATOR, '2', MANAGER, 'Access Thresholds', '0' ), -- this is for a project
( 'view_configuration_threshold', ADMINISTRATOR, '2', ADMINISTRATOR, 'Access Thresholds', '0' ), -- this is for the system
( 'set_configuration_threshold', ADMINISTRATOR, '2', ADMINISTRATOR, 'Access Thresholds', '0' ), -- this is for the system
( 'create_permalink_threshold', ADMINISTRATOR, '2', DEVELOPER, 'Access Thresholds', '0' ),

( 'allow_no_category', ADMINISTRATOR, '2', OFF, 'General', '0' ),
( 'login_method', ADMINISTRATOR, '2', 'MD5', 'General', '0' ), -- this value is a constant
( 'limit_reporters', ADMINISTRATOR, '2', OFF, 'General', '0' ),
( 'allow_reporter_close', ADMINISTRATOR, '2', OFF, 'General', '0' ),
( 'allow_reporter_reopen', ADMINISTRATOR, '2', ON, 'General', '0' ),
( 'allow_reporter_upload', ADMINISTRATOR, '2', ON, 'General', '0' ),
( 'allow_account_delete', ADMINISTRATOR, '2', OFF, 'General', '0' ),
( 'allow_anonymous_login', ADMINISTRATOR, '2', OFF, 'General', '0' ),
( 'anonymous_account', ADMINISTRATOR, '2', '', 'General', '0' ),
( 'bug_link_tag', ADMINISTRATOR, '2', '#', 'General', '0' ),
( 'bugnote_link_tag', ADMINISTRATOR, '2', '~', 'General', '0' ),
( 'bug_count_hyperlink_prefix', ADMINISTRATOR, '2', 'view_all_set.php?type=1&amp;temporary=y', 'General', '0' ),
( 'user_login_valild_regex', ADMINISTRATOR, '2', '/^([a-z\d\-.+_ ]+(@[a-z\d\-.]+\.[a-z]{2,4})?)$/i', 'General', '0' ),
( 'default_manage_user_prefix', ADMINISTRATOR, '2', 'ALL', 'General', '0' ),
( 'default_manage_tag_prefix', ADMINISTRATOR, '2', 'ALL', 'General', '0' ),
( 'csv_separator', ADMINISTRATOR, '2', ',', 'General', '0' ),

-- MantisBT Look and Feel Variables *
( 'status_colors', ADMINISTRATOR, '2', ',', 'Templates', '0' ),
-- $g_status_colors = array( 'new'=>'#fcbdbd','feedback'=>'#e3b7eb','acknowledged'=>'#ffcd85','confirmed'=>'#fff494','assigned'=>'#c2dfff','resolved'=>'#d2f5b0','closed'=>'#c9ccc4');

( 'display_project_padding', ADMINISTRATOR, '2', '3', 'Templates', '0' ),
( 'display_bug_padding', ADMINISTRATOR, '2', '7', 'Templates', '0' ),
( 'display_bugnote_padding', ADMINISTRATOR, '2', '7', 'Templates', '0' ),
( 'colour_project', ADMINISTRATOR, '2', 'LightGreen', 'Templates', '0' ),
( 'colour_global', ADMINISTRATOR, '2', 'LightBlue', 'Templates', '0' ),

-- MantisBT Cookie Variables *
( 'cookie_path', ADMINISTRATOR, '2', '/', 'Cookies', '0' ),
( 'cookie_domain', ADMINISTRATOR, '2', '', 'Cookies', '0' ),
( 'cookie_version', ADMINISTRATOR, '2', 'v8', 'Cookies', '0' ),
( 'cookie_prefix', ADMINISTRATOR, '2', 'MANTIS', 'Cookies', '0' ),
( 'string_cookie', ADMINISTRATOR, '2', '%cookie_prefix%_STRING_COOKIE', 'Cookies', '0' ),
( 'project_cookie', ADMINISTRATOR, '2', '%cookie_prefix%_PROJECT_COOKIE', 'Cookies', '0' ),
( 'view_all_cookie', ADMINISTRATOR, '2', '%cookie_prefix%_VIEW_ALL_COOKIE', 'Cookies', '0' ),
( 'manage_cookie', ADMINISTRATOR, '2', '%cookie_prefix%_MANAGE_COOKIE', 'Cookies', '0' ),
( 'logout_cookie', ADMINISTRATOR, '2', '%cookie_prefix%_LOGOUT_COOKIE', 'Cookies', '0' ),
( 'bug_list_cookie', ADMINISTRATOR, '2', '%cookie_prefix%_BUG_LIST_COOKIE', 'Cookies', '0' ),

-- MantisBT Filter Variables *
( 'filter_by_custom_fields', ADMINISTRATOR, '2', ON, 'Filters', '0' ),
( 'filter_custom_fields_per_row', ADMINISTRATOR, '2', '8', 'Filters', '0' ),
( 'view_filters', ADMINISTRATOR, '2', SIMPLE_DEFAULT, 'Filters', '0' ), -- value is from a php constant
( 'use_dynamic_filters', ADMINISTRATOR, '2', ON, 'Filters', '0' ), -- value is from a php constant
( 'create_short_url', ADMINISTRATOR, '2', 'http://tinyurl.com/create.php?url=%s', 'Filters', '0' ),

-- MantisBT Database Table Variables *
( 'db_table_prefix', ADMINISTRATOR, '2', 'mantis', 'Database', '0' ),
( 'db_table_suffix', ADMINISTRATOR, '2', '_table', 'Database', '0' ),

-- MantisBT Enum Strings *
( 'access_levels_enum_string', ADMINISTRATOR, '2', '10:viewer,25:reporter,40:updater,55:developer,70:manager,90:administrator', 'Enumeration Strings', '0' ),
( 'project_status_enum_string', ADMINISTRATOR, '2', '10:development,30:release,50:stable,70:obsolete', 'Enumeration Strings', '0' ),
( 'project_view_state_enum_string', ADMINISTRATOR, '2', '10:public,50:private', 'Enumeration Strings', '0' ),
( 'view_state_enum_string', ADMINISTRATOR, '2', '10:public,50:private', 'Enumeration Strings', '0' ),
( 'priority_enum_string', ADMINISTRATOR, '2', '10:none,20:low,30:normal,40:high,50:urgent,60:immediate', 'Enumeration Strings', '0' ),
( 'severity_enum_string', ADMINISTRATOR, '2', '10:feature,20:trivial,30:text,40:tweak,50:minor,60:major,70:crash,80:block', 'Enumeration Strings', '0' ),
( 'reproducibility_enum_string', ADMINISTRATOR, '2', '10:always,30:sometimes,50:random,70:have not tried,90:unable to duplicate,100:N/A', 'Enumeration Strings', '0' ),
( 'status_enum_string', ADMINISTRATOR, '2', '10:new,20:feedback,30:acknowledged,40:confirmed,50:assigned,80:resolved,90:closed', 'Enumeration Strings', '0' ),
( 'resolution_enum_string', ADMINISTRATOR, '2', '10:open,20:fixed,30:reopened,40:unable to duplicate,50:not fixable,60:duplicate,70:not a bug,80:suspended,90:wont fix', 'Enumeration Strings', '0' ),
( 'projection_enum_string', ADMINISTRATOR, '2', '10:none,30:tweak,50:minor fix,70:major rework,90:redesign', 'Enumeration Strings', '0' ),
( 'eta_enum_string', ADMINISTRATOR, '2', '10:none,20:< 1 day,30:2-3 days,40:< 1 week,50:< 1 month,60:> 1 month', 'Enumeration Strings', '0' ),
( 'sponsorship_enum_string', ADMINISTRATOR, '2', '0:Unpaid,1:Requested,2:Paid', 'Enumeration Strings', '0' ),
( 'custom_field_type_enum_string', ADMINISTRATOR, '2', '0:string,1:numeric,2:float,3:enum,4:email,5:checkbox,6:list,7:multiselection list,8:date,9:radio,10:textarea', 'Enumeration Strings', '0' ),

-- MantisBT Javascript Variables *
( 'use_javascript', ADMINISTRATOR, '2', ON, 'Templates', '0' ),
( 'compress_html', ADMINISTRATOR, '2', ON, 'Templates', '0' ),


-- Include files *
( 'bottom_include_page', ADMINISTRATOR, '2', '%absolute_path%', 'Templates', '0' ),
( 'top_include_page', ADMINISTRATOR, '2', '%absolute_path%', 'Templates', '0' ),
( 'css_include_page', ADMINISTRATOR, '2', 'default.css', 'Templates', '0' ),
( 'css_rtl_include_page', ADMINISTRATOR, '2', 'rtl.css', 'Templates', '0' ),
( 'meta_include_page', ADMINISTRATOR, '2', '%absolute_path%meta_inc.php', 'Templates', '0' ),
( 'default_home_page', ADMINISTRATOR, '2', 'my_view_page.php', 'Templates', '0' ),
( 'logout_redirect_page', ADMINISTRATOR, '2', 'login_page.php', 'Templates', '0' ),
( 'custom_headers', ADMINISTRATOR, '2', '', 'Templates', '0' ),

-- these were commented out
-- ( 'allow_browser_cache', ADMINISTRATOR, '2', ON, 'Templates', '0' ),
-- ( 'allow_file_cache', ADMINISTRATOR, '2', ON, 'Templates', '0' ),


-- Custom Fields *
( 'manage_custom_fields_threshold', ADMINISTRATOR, '2', ADMINISTRATOR, 'Access Thresholds', '0' ),
( 'custom_field_link_threshold', ADMINISTRATOR, '2', MANAGER, 'Access Thresholds', '0' ),
( 'custom_field_edit_after_create', ADMINISTRATOR, '2', ON, 'Custom Fields', '0' ),

( 'main_menu_custom_options', ADMINISTRATOR, '2', '', 'Templates', '0' ),
( 'file_type_icons', ADMINISTRATOR, '2', '', 'Templates', '0' ),
-- $g_file_type_icons = array( ''	=> 'text.gif', '7z'	=> 'zip.gif', 'ace'	=> 'zip.gif', 'arj'	=> 'zip.gif', 'bz2'	=> 'zip.gif', 'c'	=> 'cpp.gif', 'chm'	=> 'chm.gif', 'cpp'	=> 'cpp.gif', 'css'	=> 'css.gif', 'csv'	=> 'csv.gif', 'cxx'	=> 'cpp.gif', 'diff'	=> 'text.gif', 'doc'	=> 'doc.gif', 'docx'	=> 'doc.gif', 'dot'	=> 'doc.gif', 'eml'	=> 'eml.gif', 'htm'	=> 'html.gif', 'html'	=> 'html.gif', 'gif'	=> 'gif.gif', 'gz'	=> 'zip.gif', 'jpe'	=> 'jpg.gif', 'jpg'	=> 'jpg.gif', 'jpeg'	=> 'jpg.gif', 'log'	=> 'text.gif', 'lzh'	=> 'zip.gif', 'mhtml'	=> 'html.gif', 'mid'	=> 'mid.gif', 'midi'	=> 'mid.gif', 'mov'	=> 'mov.gif', 'msg'	=> 'eml.gif', 'one'	=> 'one.gif', 'patch'	=> 'text.gif', 'pcx'	=> 'pcx.gif', 'pdf'	=> 'pdf.gif', 'png'	=> 'png.gif', 'pot'	=> 'pot.gif', 'pps'	=> 'pps.gif', 'ppt'	=> 'ppt.gif', 'pptx'	=> 'ppt.gif', 'pub'	=> 'pub.gif', 'rar'	=> 'zip.gif', 'reg'	=> 'reg.gif', 'rtf'	=> 'doc.gif', 'tar'	=> 'zip.gif', 'tgz'	=> 'zip.gif', 'txt'	=> 'text.gif', 'uc2'	=> 'zip.gif', 'vsd'	=> 'vsd.gif', 'vsl'	=> 'vsl.gif', 'vss'	=> 'vsd.gif', 'vst'	=> 'vst.gif', 'vsu'	=> 'vsd.gif', 'vsw'	=> 'vsd.gif', 'vsx'	=> 'vsd.gif', 'vtx'	=> 'vst.gif', 'wav'	=> 'wav.gif', 'wbk'	=> 'wbk.gif', 'wma'	=> 'wav.gif', 'wmv'	=> 'mov.gif', 'wri'	=> 'wri.gif', 'xlk'	=> 'xls.gif', 'xls'	=> 'xls.gif', 'xlsx'	=> 'xls.gif', 'xlt'	=> 'xlt.gif', 'xml'	=> 'xml.gif', 'zip'	=> 'zip.gif', '?'	=> 'generic.gif' );

( 'status_icon_arr', ADMINISTRATOR, '2', '', 'Templates', '0' ),
-- $g_status_icon_arr = array ( NONE      => '', LOW       => 'priority_low_1.gif', NORMAL    => 'priority_normal.gif', HIGH      => 'priority_1.gif', URGENT    => 'priority_2.gif', IMMEDIATE => 'priority_3.gif');

( 'sort_icon_arr', ADMINISTRATOR, '2', '', 'Templates', '0' ),
-- $g_sort_icon_arr = array ( ASCENDING  => 'up.gif', DESCENDING => 'down.gif');
( 'unread_icon_arr', ADMINISTRATOR, '2', '', 'Templates', '0' ),
-- $g_unread_icon_arr = array ( READ   => 'mantis_space.gif', UNREAD => 'unread.gif');

-- My View Settings *
( 'my_view_bug_count', ADMINISTRATOR, '2', '10', 'Templates', '0' ),
( 'my_view_boxes', ADMINISTRATOR, '2', '', 'Templates', '0' ),
-- $g_my_view_boxes = array ( 'assigned'      => '1', 'unassigned'    => '2', 'reported'      => '3', 'resolved'      => '4', 'recent_mod'    => '5', 'monitored'     => '6', 'feedback'      => '0', 'verify'        => '0', 'my_comments'   => '0');
( 'my_view_boxes_fixed_position', ADMINISTRATOR, '2', ON, 'Templates', '0' ),

( 'rss_enabled', ADMINISTRATOR, '2', ON, 'General', '0' ),

( 'relationship_graph_enable', ADMINISTRATOR, '2', OFF, 'Relationships', '0' ),
( 'dot_tool', ADMINISTRATOR, '2', '/usr/bin/dot', 'Relationships', '0' ),
( 'neato_tool', ADMINISTRATOR, '2', '/usr/bin/neato', 'Relationships', '0' ),
( 'relationship_graph_fontname', ADMINISTRATOR, '2', 'Arial', 'Relationships', '0' ),
( 'relationship_graph_fontsize', ADMINISTRATOR, '2', '8', 'Relationships', '0' ),
( 'relationship_graph_orientation', ADMINISTRATOR, '2', 'horizontal', 'Relationships', '0' ),
( 'relationship_graph_max_depth', ADMINISTRATOR, '2', '2', 'Relationships', '0' ),
( 'relationship_graph_view_on_click', ADMINISTRATOR, '2', OFF, 'Relationships', '0' ),

( 'backward_year_count', ADMINISTRATOR, '2', '4', 'Custom Fields', '0' ),
( 'forward_year_count', ADMINISTRATOR, '2', '4', 'Custom Fields', '0' ),

( 'custom_group_actions', ADMINISTRATOR, '2', '', 'General', '0' ), -- array

( 'wiki_enable', ADMINISTRATOR, '2', ON, 'Wiki', '0' ),
( 'wiki_engine', ADMINISTRATOR, '2', '', 'Wiki', '0' ),
( 'wiki_root_namespace', ADMINISTRATOR, '2', 'mantis', 'Wiki', '0' ),
( 'wiki_engine_url', ADMINISTRATOR, '2', $t_protocol . '://' . $t_host . '/%wiki_engine%/', 'Wiki', '0' ),

( 'recently_visited', ADMINISTRATOR, '2', ON, 'Templates', '0' ),
( 'recently_visited_count', ADMINISTRATOR, '2', '5', 'Templates', '0' ),

( 'tag_separator', ADMINISTRATOR, '2', ',', 'General', '0' ),
( 'tag_view_threshold', ADMINISTRATOR, '2', VIEWER, 'Access Thresholds', '0' ),
( 'tag_attach_threshold', ADMINISTRATOR, '2', REPORTER, 'Access Thresholds', '0' ),
( 'tag_detach_threshold', ADMINISTRATOR, '2', DEVELOPER, 'Access Thresholds', '0' ),
( 'tag_detach_own_threshold', ADMINISTRATOR, '2', REPORTER, 'Access Thresholds', '0' ),
( 'tag_create_threshold', ADMINISTRATOR, '2', REPORTER, 'Access Thresholds', '0' ),
( 'tag_edit_threshold', ADMINISTRATOR, '2', DEVELOPER, 'Access Thresholds', '0' ),
( 'tag_edit_own_threshold', ADMINISTRATOR, '2', REPORTER, 'Access Thresholds', '0' ),

# Time tracking
( 'time_tracking_enabled', ADMINISTRATOR, '2', OFF, 'Time Tracking', '0' ),
( 'time_tracking_with_billing', ADMINISTRATOR, '2', OFF, 'Time Tracking', '0' ),
( 'time_tracking_stopwatch', ADMINISTRATOR, '2', OFF, 'Time Tracking', '0' ),
( 'time_tracking_view_threshold', ADMINISTRATOR, '2', DEVELOPER, 'Access Thresholds', '0' ),
( 'time_tracking_edit_threshold', ADMINISTRATOR, '2', DEVELOPER, 'Access Thresholds', '0' ),
( 'time_tracking_reporting_threshold', ADMINISTRATOR, '2', MANAGER, 'Access Thresholds', '0' ),
( 'time_tracking_reporting_without_note', ADMINISTRATOR, '2', ON, 'Time Tracking', '0' ),

# Profile Related Settings
( 'enable_profiles', ADMINISTRATOR, '2', ON, 'Profiles', '0' ),
( 'add_profile_threshold', ADMINISTRATOR, '2', REPORTER, 'Access Thresholds', '0' ),
( 'manage_global_profile_threshold', ADMINISTRATOR, '2', MANAGER, 'Access Thresholds', '0' ),
( 'allow_freetext_in_profile_fields', ADMINISTRATOR, '2', ON, 'Profiles', '0' ),

# Twitter Settings
( 'twitter_username', ADMINISTRATOR, '2', '', 'Twitter', '0' ),
( 'twitter_password', ADMINISTRATOR, '2', '', 'Twitter', '0' ),

# Plugin System
( 'plugins_enabled', ADMINISTRATOR, '2', ON, 'Plugins', '0' ),
( 'plugin_path', ADMINISTRATOR, '2', '%absolute_path%plugins/', 'Plugins', '0' ),
( 'manage_plugin_threshold', ADMINISTRATOR, '2', ADMINISTRATOR, 'Access Thresholds', '0' ),
( 'plugins_force_installed', ADMINISTRATOR, '2', '', 'Plugins', '0' ), -- array

# Due Date
( 'due_date_update_threshold', ADMINISTRATOR, '2', NOBODY, 'Access Thresholds', '0' ),
( 'due_date_view_threshold', ADMINISTRATOR, '2', NOBODY, 'Access Thresholds', '0' ),

# Sub-projects
( 'subprojects_inherit_categories', ADMINISTRATOR, '2', ON, 'Projects', '0' ),
( 'subprojects_inherit_versions', ADMINISTRATOR, '2', ON, 'Projects', '0' ),

# Debugging / Developer Settings
( 'show_timer', ADMINISTRATOR, '2', OFF, 'Debug', '0' ),
( 'show_memory_usage', ADMINISTRATOR, '2', OFF, 'Debug', '0' ),
( 'debug_email', ADMINISTRATOR, '2', OFF, 'Debug', '0' ),
( 'show_queries_count', ADMINISTRATOR, '2', OFF, 'Debug', '0' ),
( 'show_friendly_errors', ADMINISTRATOR, '2', OFF, 'Debug', '0' ),
( 'log_level', ADMINISTRATOR, '2', LOG_NONE, 'Debug', '0' ),
( 'log_destination', ADMINISTRATOR, '2', '', 'Debug', '0' ),
( 'show_log_threshold', ADMINISTRATOR, '2', ADMINISTRATOR, 'Access Thresholds', '0' ),

( 'global_settings', ADMINISTRATOR, '2', '', 'General', '0' );
# $g_global_settings = array( 'global_settings', 'admin_checks', 'allow_signup', 'anonymous', 'compress_html', 'content_expire', 'cookie', 'crypto_master_salt', 'custom_headers', 'database_name', '^db_', 'form_security_', 'hostname', 'html_valid_tags', 'language', 'login_method', 'plugins_enabled', 'plugins_installed', 'session_', 'show_queries_', 'use_javascript', 'version_suffix', '[^_]file[(_(?!threshold))$]', '[^_]path[_$]', '_page$', '_table$', '_url$', 'show_friendly_errors',);