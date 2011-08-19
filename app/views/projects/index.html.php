<?php

use app\models\Menus;

# MantisBT - A PHP based bugtracking system

$self = $this;

$this->title( $t('Manage projects page heading title' ) );
$this->styles('<link rel="stylesheet" type="text/css" href="/css/tables.css" />');

$manageMenu = function() use ($self) {
	$manageMenu = Menus::getMenu('manage', array());
	$out = '';
	if( $manageMenu ) {
		$out .= $self->html->htmlMenu($manageMenu['list'], $manageMenu['options']);
	}
	return $out;
};

$projectRow = function($project, $level ) use ($self) {
	$class = 'project-level-' . $level;
	#echo trans_bool( $t_project['enabled'] )
	#echo string_display_links( $t_project['description'] )

	$out = '<tr>';
	$out .= '<td class="' . $class . '">';
	$out .= $self->html->link( $project->name, $self->url(array('Projects::edit','id' => $project->id)));
	$out .= '</td>';
	$out .= '<td>' . $project->status($project) . '</td>';
	$out .= '<td>' . $project->enabled . '</td>';
	$out .= '<td>' . $project->viewState($project) . '</td>';
	$out .= '<td>' . $project->description . '</td>';
	$out .= '</tr>';
	return $out;
};

$printProjects = function($projects, $level = 1) use ($self, &$printProjects, $projectRow) {
	$out = '';
	foreach ($projects as $project) {
		$out .= $projectRow($project, $level);
		if($project->children && $project->children->count()) {
			$out .= $printProjects($project->children, ($level+1));
		}
	}
	return $out;
};

#print_manage_menu( 'manage_proj_page.php' );
echo $manageMenu();

# Project Menu Form BEGIN
?>
<div id="manage-project-div" class="form-container">
	<h2><?=$t('Heading for managing a list of projects'); ?></h2>

	<?php
	# Check the user's global access level before allowing project creation
	#	if ( access_has_global_level ( config_get( 'create_project_threshold' ) ) )
	?>
	<?=$this->html->link($t('Projects list create new project link'), $this->url('Projects::create')); ?>

	<table cellspacing="1" cellpadding="5" border="1">
		<tr class="row-category">
			<?php
				# @todo these headings need sort links with direction icons;
				# @todo determine sort direction and class for each column
				$sortDir = 'sortAsc';
			?>

			<td><?=$this->html->link($t('Projects list name field column heading'), 'projects', array('class'=>$sortDir)); ?></td>
			<td><?=$this->html->link($t('Projects list status field column heading'), 'projects', array('class'=>$sortDir)); ?></td>
			<td><?=$this->html->link($t('Projects list enabled field column heading'), 'projects', array('class'=>$sortDir)); ?></td>
			<td><?=$this->html->link($t('Projects list view status field column heading'), 'projects', array('class'=>$sortDir)); ?></td>
			<td><?=$this->html->link($t('Projects list description field column heading'), 'projects', array('class'=>$sortDir)); ?></td>
		</tr>
		<?php echo $printProjects( $projects );
#		foreach ( $projects as $project ) {
#			echo $projectRow($project);

#			$t_subprojects = project_hierarchy_get_subprojects( $t_project_id, true );
#			if( $project->children->count() ) {
#				foreach ( $project->children as $child) {
#					echo $projectRow($child, 1);
#				}
#			}
#		}
		?>
	</table>
</div>

<div id="categories" class="form-container">
	<h2><?=$t( 'Project list global categories section heading' ) ?></h2>
	<table cellspacing="1" cellpadding="5" border="1"><?php
#		$t_categories = category_get_all_rows( ALL_PROJECTS );
		if ( $categories->count() > 0 ) { ?>
		<tr class="row-category">
			<td><?=$t( 'Project category list category name column heading' ) ?></td>
			<td><?=$t( 'Project category list category assigned to column heading' ) ?></td>
			<td class="center"><?=$t( 'Project category list actions column heading' ) ?></td>
		</tr><?php
		}

	foreach ( $categories as $category ) {
#		$t_id = $t_category['id'];

#		$t_name = $t_category['name'];
#		if ( NO_USER != $t_category['user_id'] && user_exists( $t_category['user_id'] )) {
#			$t_user_name = user_get_name( $t_category['user_id'] );
#		} else {
#			$t_user_name = '';
#		} ?>

		<tr <?php #echo helper_alternate_class() ?>>
			<td><?=$category->id; ?></td>
			<?php #echo string_display( category_full_name( $t_category['id'], false ) )  ?>
			<td><?=$category->user_id; ?></td>
			<?php #echo string_display_line( $t_user_name ) ?>
			<td class="center">
				<?php
#					$t_id = urlencode( $t_id );
#					$t_project_id = urlencode( ALL_PROJECTS );

					#print_button( "manage_proj_cat_edit_page.php?id=$t_id&project_id=$t_project_id", lang_get( 'edit_link' ) );
				?>
					<?=$t('Project category list category actions edit link title'); ?>
					&#160;
					<?=$t('Project category list category actions delete link title'); ?>
					<?php #print_button( "manage_proj_cat_delete.php?id=$t_id&project_id=$t_project_id", lang_get( 'delete_link' ) ); ?>
			</td>
		</tr><?php
	} # end for loop ?>
	</table>

	<?=$this->form->create(null,array('id' => 'manage-project-add-global-category-form','action' => 'projects/category/add')); ?>
		<?=$this->security->requestToken(array('id' => 'manage-project-add-global-category-form'));?>
		<fieldset>
			<?=$this->form->field('project_id', array('type'=>'hidden', 'value'=> ALL_PROJECTS));?>
			<?=$this->form->field( 'name', array(
				'type' => 'field-hidden',
				'label' => '',
				'size' => 32,
				'maxlength' => 128));?>
			<?=$this->form->submit( $t( 'Projects list add global category submit button title')); ?>
		</fieldset>
	<?=$this->form->end(); ?>
</div>