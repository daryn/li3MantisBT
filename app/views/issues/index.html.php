<?php

$self = $this;

#$t_filter = current_user_get_bug_filter();
# NOTE: this check might be better placed in current_user_get_bug_filter()
#if ( $t_filter === false ) {
#	$t_filter = filter_get_default();
#}

#list( $t_sort, ) = explode( ',', $t_filter['sort'] );
#list( $t_dir, ) = explode( ',', $t_filter['dir'] );

#$g_checkboxes_exist = false;

#$t_icon_path = config_get( 'icon_path' );

# Improve performance by caching category data in one pass
#if ( helper_get_current_project() > 0 ) {
#	category_get_all_rows( helper_get_current_project() );
#} else {
#	$t_categories = array();
#	foreach ($rows as $t_row) {
#		$t_categories[] = $t_row->category_id;
#	}
#	category_cache_array_rows( array_unique( $t_categories ) );
#}
#$t_columns = helper_get_columns_to_view( COLUMNS_TARGET_VIEW_PAGE );

#$col_count = count( $t_columns );

#$t_filter_position = config_get( 'filter_position' );

# -- ====================== FILTER FORM ========================= --
#if ( ( $t_filter_position & FILTER_POSITION_TOP ) == FILTER_POSITION_TOP ) {
#	filter_draw_selection_area( $f_page_number );
#}
# -- ====================== end of FILTER FORM ================== --


# -- ====================== BUG LIST ============================ --

#$t_status_legend_position = config_get( 'status_legend_position' );

#if ( $t_status_legend_position == STATUS_LEGEND_POSITION_TOP || $t_status_legend_position == STATUS_LEGEND_POSITION_BOTH ) {
#	html_status_legend();
#}
#?>

<form name="bug_action" method="get" action="bug_actiongroup_page.php">
    <table id="buglist" class="width100" cellspacing="1">
        <thead>
            <tr class="buglist-nav">
				<?php foreach( $issues->columns AS $col ) { ?>
                <td class="form-title" colspan="<?php echo $issue->count(); ?>">
                    <span class="floatleft">
                        <?php # -- Viewing range info --
                        $v_start = 0;
			            $v_end   = 0;

			            if ( $issues->count() > 0 ) {
				            $v_start = /*$t_filter['per_page']*/ 50 * (/*$f_page_number*/1 - 1) + 1;
				            $v_end = $v_start + $issues->count() - 1;
			            }
                        ?>
			            <?= $t( 'Issues list viewing bugs n - (n + bugs per page) title' ); ?>
			            ( <?= $v_start; ?>-<?=$v_end;?>/<?= $issues->count(); ?>)
                    </span>

                    <span class="floatleft small"><?php
			        # -- Print and Export links --
			        echo '&#160;';
                    $self->html->link( $t( 'Issues list print all bug page link'), 'print_all_bug_page.php');
			        echo '&#160;';
                    $self->html->link( $t( 'Issues list csv export link'), 'csv_export.php');
			        echo '&#160;';
                    $self->html->link( $t( 'Issues list excel export link'), 'excel_xml_export.php');

#			        $t_event_menu_options = $t_links = event_signal( 'EVENT_MENU_FILTER' );

#			        foreach ( $t_event_menu_options as $t_plugin => $t_plugin_menu_options ) {
#				        foreach ( $t_plugin_menu_options as $t_callback => $t_callback_menu_options ) {
#					        if ( !is_array( $t_callback_menu_options ) ) {
#						        $t_callback_menu_options = array( $t_callback_menu_options );
#					        }

#					        foreach ( $t_callback_menu_options as $t_menu_option ) {
#						        print_bracket_link_prepared( $t_menu_option );
#					        }
#				        }
#			        } ?>
                    </span>
		            <span class="floatright small"><?php
			        # -- Page number links --
			        #$f_filter	= gpc_get_int( 'filter', 0);
			        #print_page_links( 'view_all_bug_page.php', 1, $t_page_count, (int)$f_page_number, $f_filter ); ?>
                    </span>
	            </td>
				<?php } ?>
            </tr>
            <tr class="buglist-headers row-category">
            <?php
            #	foreach( $t_columns as $t_column ) {
            #		$t_title_function = 'print_column_title';
            #		helper_call_custom_function( $t_title_function, array( $t_column ) );
            #	}
            ?>
            </tr>
            <tr class="spacer">
	            <td colspan="<?php #echo $col_count; ?>"></td>
            </tr>
        </thead>
        <tbody>
        <?php
        # $t_in_stickies = ( $t_filter && ( 'on' == $t_filter[FILTER_PROPERTY_STICKY] ) );

	    # pre-cache custom column data
        # columns_plugin_cache_issue_data( $p_rows );
	    # -- Loop over bug rows --
        foreach( $issues AS $issue ) {
		    if ( ( 0 == $issue->sticky ) && ( 0 == $issue->key ) ) {
			    $inStickies = false;
		    }
		    if ( ( 0 == $issue->sticky ) && $inStickies ) {	# demarcate stickies, if any have been shown ?>
            <tr>
			    <td class="left" colspan="<?php #echo count( $t_columns ); ?>" bgcolor="#999999">&#160;</td>
		    </tr>
            <?php
			$inStickies = false;
		    }
            ?>
		    <tr class="<?#= $this->issue->statusLabel( $issue->status ); ?>">
            <?php
#		    foreach( $t_columns as $t_column ) {
            # $t_column_value_function = 'print_column_value';
            # helper_call_custom_function( $t_column_value_function, array( $t_column, $t_row ) );
#		    }
            ?>
		    </tr>
            <?php
	    }
        # -- ====================== end of BUG LIST ========================= --

        # -- ====================== MASS BUG MANIPULATION =================== --
        # @@@ ideally buglist-footer would be in <tfoot>, but that's not possible due to global g_checkboxes_exist set via write_bug_rows()
        ?>
            <tr class="buglist-footer">
                <td class="left" colspan="<?php echo $col_count; ?>">
                    <span class="floatleft">
                    <?php
#                    if ( $g_checkboxes_exist && ON == config_get( 'use_javascript' ) ) {
#			            echo '<input type="checkbox" id="bug_arr_all" name="bug_arr_all" value="all" class="check_all" />';
#			            echo '<label for="bug_arr_all">' . lang_get( 'select_all' ) . '</label>';
#		            }

#                    if ( $g_checkboxes_exist ) {
                    ?>
                        <select name="action">
                            <?php #print_all_bug_action_option_list( $t_unique_project_ids ) ?>
                        </select>
                        <input type="submit" class="button" value="<?= $t( 'Issues list bug action form submit button' ); ?>" />
                    <?php
#		            } else {
#                        echo '&#160;';
#		            }
                    ?>
                    </span>
			        <span class="floatright small">
				    <?php
			        # $f_filter	= gpc_get_int( 'filter', 0);
			        # print_page_links( 'view_all_bug_page.php', 1, $t_page_count, (int)$f_page_number, $f_filter );
				    ?>
			        </span>
		        </td>
	        </tr>
            <?php # -- ====================== end of MASS BUG MANIPULATION ========================= -- ?>
        </tbody>
    </table>
</form>

<?php

#if ( $t_status_legend_position == STATUS_LEGEND_POSITION_BOTTOM || $t_status_legend_position == STATUS_LEGEND_POSITION_BOTH ) {
#	html_status_legend();
#}

# -- ====================== FILTER FORM ========================= --
#if ( ( $t_filter_position & FILTER_POSITION_BOTTOM ) == FILTER_POSITION_BOTTOM ) {
#	filter_draw_selection_area( $f_page_number );
#}
# -- ====================== end of FILTER FORM ================== --