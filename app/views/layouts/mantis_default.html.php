<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2011, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */
use lithium\core\Environment;
use lithium\util\Validator;
use app\models\Menus;
use app\models\Settings;

$settings = Settings::all();

$self = $this;

$loginInfo = function() use ($self, $t, $settings, $currentUser) {
	$out = '<div id="login-info">';
	if( $currentUser->isAnonymous() ) {
#		$t_return_page = $_SERVER['SCRIPT_NAME'];
#		if( isset( $_SERVER['QUERY_STRING'] ) ) {
#			$t_return_page .= '?' . $_SERVER['QUERY_STRING'];
#		}
#
#		$t_return_page = string_url( $t_return_page );
#
		$out .= '<span id="logged-anon-label">' . $t('Login info anonymous user label') . '</span>';
		$out .= '<span id="login-link">';
#		$out .= '<a href="' . $self->url( 'login_page.php?return=' . $t_return_page ) . '">' . lang_get( 'login_link' ) . '</a>';
		$out .= $self->html->link($t('Login link'), $self->url('Session::add'), array('title' => $t('Login link')));
		$out .= '</span>';

		if( $settings->allow_signup == ON ) {
			$out .= '<span id="signup-link">';
			$out .= $self->html->link($t('Signup link'), $self->url('Users::signup'), array('title' => $t('Signup link')));
			$out .= '</span>';
		}
	} else {
		$out .= '<span id="logged-in-label">' . $t('Login info logged in as label') . '</span>';
		$out .= '<span id="logged-in-user">' . $currentUser->username . '</span>';
		$out .= '<span id="logged-in">';
		$out .= ( $currentUser->realname ) ?  '<span id="logged-in-realname">' . $self->escape( $currentUser->realname ) . '</span>' : '';
		$out .= '<span id="logged-in-accesslevel" class="' . $currentUser->accessLevelCss($currentUser) . '">' . $currentUser->accessLevel() . '</span>';
		$out .= '</span>';
	}
	$out .='</div>';
	return $out;
};


$topBanner = function() use ($self, $settings) {
	$logoImage = $self->path( 'img/' . $settings->logo_image, array('check' => true ));
	if($logoImage) {
		echo '<div id="banner">';
		if( Validator::isBlank( $settings->logo_url )) {
			echo $self->html->link( $self->html->image( $logoImage, array( 'id'=>'logo-image', 'alt' => 'Mantis Bug Tracker')), $settings->logo_url, array( 'id'=>'logo-link', 'escape' => false ));
		} else {
			echo $self->html->image( $logoImage, array( 'id'=>'logo-image', 'alt' => 'Mantis Bug Tracker'));
		}
		echo '</div>';
	}
};

# Print the page execution time
# @todo requestTime is temporary. figure out where it should really be
$requestTime = '.0001234';
$executionTime = function () use ($t, $settings, $requestTime) {
	$out = '';
	if ( $settings->show_timer ) {
		$out .= '<p id="page-execution-time">';
		$out .= $t('Page execution time label');
		$out .= number_format( microtime( true ) - $requestTime, 4 );
		$out .= $t('Page execution time unit');
		$out .= '</p>';
	}
	return $out;
};

$memoryUsage = function() use ($t, $settings) {
	$out = '';
	if ($settings->show_memory_usage) {
		$out .= '<p id="page-memory-usage">';
		$out .= $t('Memory usage in kb label');
		$out .= number_format( memory_get_peak_usage() / 1024 );
		$out .= $t('Memory usage in kb unit');
		$out .= '</p>';
	}
	return $out;
};

$mainMenu = function() use ($self) {
	$mainMenu = Menus::getMenu('main', array());
	$out = '';
	if( $mainMenu ) {
		$out .= $self->html->htmlMenu($mainMenu['list'], $mainMenu['options']);
	}
	return $out;
};
?>
<!doctype html>
<html>
	<head>
		<?php echo $this->html->charset();?>
		<title>Application > <?php echo $this->title(); ?></title>
		<?php
			$includeCss = $settings->css_include_file;
			echo $this->html->style(array($includeCss, 'jquery-ui.css' ));
			if( $t('directionality') == 'rtl' ) {
				echo $this->html->style(array( $settings->css_rtl_include_file ));
			}
			?>
			<style type="text/css">
				div.form-container fieldset.has-required:after {
					position: absolute;
					margin: -1.75em 0em 0em .5em;
					font-size: 8pt;
					content: '* <?= $t( 'required' ); ?>';
					color: red;
				}
			</style>
		<?php echo $this->scripts(); ?>
		<?php echo $this->html->link('Icon', null, array('type' => 'icon')); ?>
	</head>
	<body class="app">
		<div id="mantis">
			<?=$topBanner();?>
			<?php echo $loginInfo($currentUser);?>
			<form method="post" action="jump_to_bug.php" class="bug-jump-form">
				<fieldset class="bug-jump">
					<input type="hidden" name="bug_label" value="<?=$t('issue_id');?>" />
					<input type="text" name="bug_id" size="10" class="small" />&#160;
					<input type="submit" class="button-small" value="<?=$t( 'jump' );?>" />&#160;
				</fieldset>
			</form>
			<?php echo $mainMenu();?>
			<div id="content">
				<?php echo $this->content(); ?>
			</div>
		<?php
		# If a user is logged in, update their last visit time.
		# We do this at the end of the page so that:
		#  1) we can display the user's last visit time on a page before updating it
		#  2) we don't invalidate the user cache immediately after fetching it
		#  3) don't do this on the password verification or update page, as it causes the
		#    verification comparison to fail
#		if ( auth_is_user_authenticated() && !current_user_is_anonymous() && !( is_page_name( 'verify.php' ) || is_page_name( 'account_update.php' ) ) ) {
#			$t_user_id = auth_get_current_user_id();
#			user_update_last_visit( $t_user_id );
#		}
		?>

		<div id="footer">
			<hr />
			<div id="powered-by-mantisbt-logo">
			<?php $poweredBy = $t('Powered by MantisBT description'); ?>
			<?=$this->html->link(
				$this->html->image( 'mantis_logo_button.gif', array( 'alt' => $poweredBy )),
				'http://www.mantisbt.org', array( 'title'=>$poweredBy, 'escape' => false));
			?>
		</div>
		<?php
		# Show optional user-specificed custom copyright statement
		if ( $settings->copyright_statement ) {
		?>
			<address id="user-copyright"><?=$settings->copyright_statement; ?></address>
		<?php
		}

		# Show MantisBT version and copyright statement
		$versionSuffix = '';
		$copyrightYears = '';
		if ( $settings->show_version ) {
			$versionSuffix = ' ' . MANTIS_VERSION . $settings->version_suffix;
			$copyrightYears = ' 2000 - 2011';
		}
		$gnuLicense = 'GNU General Public License (GPL) version 2';
		$gnuUrl = 'http://www.gnu.org/licenses/old-licenses/gpl-2.0.html';
		?>
		<address id="mantisbt-copyright">
			<?=$t( 'Powered by' ); ?>
			<?=$this->html->link(
				'Mantis Bug Tracker',
				'http://www.mantisbt.org',
				array( 'title'=>$t('Powered by MantisBT description'))
			); ?>
			(MantisBT)
			<?=$versionSuffix; ?>.
			<?=$t( 'copyright' ); ?>&copy;
			<?=$copyrightYears;?>
			<?=$t( 'MantisBT contributors' ); ?>
			<?=$t( 'Licensed under the terms of the' );?>
			<?=$this->html->link( $gnuLicense, $gnuUrl, array( 'title'=>$gnuLicense )); ?>
			<?=$t( 'or a later version' );?>
		</address>
		<address id="webmaster-contact-information">
			<?=$t('Webmaster contact information' );?>
			<?=$this->html->link( $settings->webmaster_email,
				'mailto:' . $settings->webmaster_email,
				array( 'title'=> $t('Webmaster contact link title')));?>
		</address>
		<?php
#		event_signal( 'EVENT_LAYOUT_PAGE_FOOTER' );
		# Print horizontal rule if any debugging stats follow
		if ( $settings->show_timer || $settings->show_memory_usage || $settings->show_queries_count ) {
			echo "\t<hr />\n";
		}
		?>
		<?php echo $executionTime(); ?>
		<?php echo $memoryUsage(); ?>
		<?php

		# Determine number of unique queries executed
/*		if ( $settings->show_queries_count ) {
			$totalQueriesCount = count( $g_queries_array );
			$t_unique_queries_count = 0;
			$t_total_query_execution_time = 0;
			$t_unique_queries = array();
			for ( $i = 0; $i < $totalQueriesCount; $i++ ) {
				if ( !in_array( $g_queries_array[$i][0], $t_unique_queries ) ) {
					$t_unique_queries_count++;
					$g_queries_array[$i][3] = false;
					array_push( $t_unique_queries, $g_queries_array[$i][0] );
				} else {
					$g_queries_array[$i][3] = true;
				}
				$t_total_query_execution_time += $g_queries_array[$i][1];
			}
			?>
			<?php
			#$totalQueriesExecuted = sprintf( lang_get( 'total_queries_executed' ), $totalQueriesCount );
			#echo "\t<p id=\"total-queries-count\">$totalQueriesExecuted</p>\n";
			#if ( $settings->db_log_queries ) {
			#	$t_unique_queries_executed = sprintf( lang_get( 'unique_queries_executed' ), $t_unique_queries_count );
			#	echo "\t<p id=\"unique-queries-count\">$t_unique_queries_executed</p>\n";
			#}
			#$totalQueryTime = sprintf( lang_get( 'total_query_execution_time' ), $t_total_query_execution_time );
			#?>
			#<p id="total-query-execution-time"><?=$totalQueryTime;?></p>
			<?php
		}
*/
		# Print table of log events
		#log_print_to_page();
		?>
			</div>
			<?php #event_signal( 'EVENT_LAYOUT_BODY_END' ); ?>
		</div>
	</body>
</html>