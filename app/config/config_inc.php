<?php
# Database Variables
$g_hostname = 'localhost';
$g_db_type = 'mysqli';
$g_database_name = 'mbt_bugtracker';
$g_db_username = 'mantis';
$g_db_password = 'super';

$g_manage_user_threshold = MANAGER;
$g_send_reset_password  = OFF;

# Email Variables
$g_administrator_email  = 'mantis@iivip.com';
$g_webmaster_email      = 'mantis@iivip.com';
$g_from_email           = 'mantis@iivip.com';
$g_return_path_email    = 'mantis@iivip.com';
$g_phpMailer_method		= 1;

$g_view_issues_page_columns = array ( 'selection', 'edit', 'priority', 'id', 'custom_bug:Ticket Type', 'bugnotes_count', 'reporter_id', 'handler_id', 'category_id', 'severity', 'status', 'last_updated', 'summary' );
$g_print_issues_page_columns = array ( 'selection', 'id', 'severity', 'status', 'custom_bug:Phase', 'custom_bug:Customer Reference', 'summary' );
$g_csv_columns = array ( 'selection', 'id', 'severity', 'status', 'resolution', 'custom_bug:Phase', 'custom_bug:RCA', 'version', 'fixed_in_version', 'custom_bug:Customer Reference', 'summary' );

$g_resolution_enum_string 	= '10:open,20:fixed,40:unable to duplicate,60:duplicate,90:wont fix';
$g_status_enum_string 		= '10:new,20:pending,50:assigned,55:reopened,80:resolved,85:verified,90:closed';
$g_access_levels_enum_string = '10:viewer,25:reporter,40:updater,55:developer,70:manager,90:administrator';
$g_priority_enum_string     = '10:none,20:low,30:normal,40:high,50:urgent,60:immediate';
$g_severity_enum_string		= '10:enhancement,20:trivial,50:minor,60:major,70:critical,80:block';

$g_view_filters = ADVANCED_ONLY;

# File Upload Settings
$g_allow_file_upload	= ON;
$g_status_colors['pending']		= '#ff50a8';
$g_status_colors['board'] 		= '#ffcd85';
$g_status_colors['director']	= '#fff494';
$g_status_colors['backlog']		= '#ffffb0';
$g_status_colors['development']	= '#d2f5b0';
$g_status_colors['verified']	= '#ffffb0';
$g_status_colors['reopened']	= '#CB9090';
$g_status_colors['unconfirmed']	= '#ffa0a0';
#$g_status_colors['new']	= '#fffb0';#confirmed

$g_show_footer_menu     = OFF;

# allow users to signup for their own accounts.
# Mail settings must be correctly configured in order for this to work
$g_allow_signup         = OFF;

# Wiki Integration
$g_wiki_enable = ON;
$g_wiki_engine = 'mediawiki';
$g_wiki_root_namespace = 'mantis';
$g_wiki_engine_url = $t_protocol . '://wiki/';

# Mantis JPGRAPH Addon
$g_use_jpgraph			= OFF;
$g_jpgraph_path			= '.' . DIRECTORY_SEPARATOR . 'jpgraph' . DIRECTORY_SEPARATOR;   # dont forget the ending slash!
$g_jpgraph_antialias	= ON;
$g_graph_font = '';
$g_graph_window_width = 800;
$g_graph_bar_aspect = 0.9;
$g_graph_summary_graphs_per_row = 2;

# Bug Relationships
$g_relationship_graph_enable		= ON;
$g_relationship_graph_orientation	= 'horizontal';
$g_relationship_graph_max_depth		= 2;
$g_relationship_graph_view_on_click	= OFF;
$g_dot_tool = '/usr/bin/dot';
$g_neato_tool = '/usr/bin/neato';

# Custom Group Actions
$g_custom_group_actions = array(
	array(
		'action'=>'EXT_MOVE',
		'label'=>'actiongroup_menu_move'
	),
);

$g_allow_browser_cache = ON;
#$g_bug_reopen_status = REOPEN;
$g_bug_reopen_resolution = OPEN;
$g_news_enabled = OFF;
$g_manage_news_threshold = DEVELOPER;
$g_default_advanced_report = ON;
$g_month_day_year_date_format = 'm/d/Y';
$g_short_date_format    = 'm/d/Y';
$g_normal_date_format   = 'm/d/Y H:i';
$g_complete_date_format = 'm/d/Y H:i T';
$g_default_bug_view_status = VS_PRIVATE;
$g_default_bugnote_order        = 'DESC';

$g_path = 'http://mantisbt.local/';
$g_short_path = ''; # overwrite short path because mantis bug is adding an extra slash on cvs1 server only
$g_show_assigned_names = OFF;
$g_show_queries_count = ON;
$g_show_queries_list = ON;

$g_allow_no_category = ON;
# ================= Page fields ==============================================
$g_bug_report_page_fields = array(
	'category_id',
	'handler',
	'priority',
	'severity',
	'platform',
	#'product_version',
	'target_version',
	'summary',
	'description',
	'attachments',
	'due_date',
);
$g_bug_view_page_fields = array (
	'id',
	'project',
	'category_id',
	'date_submitted',
	'last_updated',
	'reporter',
	'handler',
	'priority',
	'severity',
	'status',
	'resolution',
	'projection',
	'eta',
	'platform',
	'product_version',
	'target_version',
	'fixed_in_version',
	'summary',
	'description',
	'tags',
	'attachments',
	'due_date',
);
$g_bug_print_page_fields = array (
	'id',
	'project',
	'category_id',
	'date_submitted',
	'last_updated',
	'reporter',
	'handler',
	'priority',
	'severity',
	'status',
	'resolution',
	'projection',
	'eta',
	'platform',
	'product_version',
	'target_version',
	'fixed_in_version',
	'summary',
	'description',
	'tags',
	'attachments',
	'due_date',
);
$g_bug_update_page_fields = array (
	'id',
	'project',
	'category_id',
	'date_submitted',
	'last_updated',
	'reporter',
	'handler',
	'priority',
	'severity',
	'status',
	'resolution',
	'projection',
	'eta',
	'platform',
	'product_version',
	'target_version',
	'fixed_in_version',
	'summary',
	'description',
	'attachments',
	'due_date',
#	'view_state',
);
$g_bug_change_status_page_fields = array (
	'id',
	'project',
	'category_id',
	'date_submitted',
	'last_updated',
	'reporter',
	'handler',
	'priority',
	'severity',
	'status',
	'resolution',
	'projection',
	'eta',
	'platform',
	'product_version',
	'target_version',
	'fixed_in_version',
	'summary',
	'description',
	'tags',
	'attachments',
	'due_date',
);

$g_enable_email_notification	= ON;#disable for testing
$g_debug_email = 'daryn@iivip.com';
#$g_logo_image = 'images/small_icon.gif';
$g_show_realname = ON;
$g_show_user_realname_threshold = DEVELOPER;
$g_crypto_master_salt='c30iKZwvD/h61MFvo2l3DtGvMkQ14b8+H9hTx9yhta9iZFySWzqs3A2p6qVYC/hVw775NLUvSnI7XvH+EaNY0g==';

$g_show_product_version = ON;
#$g_css_include_file = 'ii_custom.css';

$g_due_date_update_threshold = DEVELOPER;
$g_due_date_view_threshold = DEVELOPER;
$g_bug_readonly_status_threshold = CLOSED;
$g_update_readonly_bug_threshold = DEVELOPER;
$g_bug_link_tag = 'issue:';
$g_show_memory_usage = ON;
$g_show_timer = ON;