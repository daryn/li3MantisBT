<?php
$this->title( $t('Manage settings edit setting page heading title' ) );

?>
<div id="manage-settings-edit-div" class="form-container">
	<?=$this->form->create(); ?>
	<?=$this->form->field( 'username', array('value'=>$setting->username ) );?>
	<?=$this->form->field( 'project_id', array('type' => 'select', 'list'=>array() ));?>
	<?=$this->form->field( 'id', array('value'=>$setting->id ) );?>
	<?=$this->form->field( 'type', array('type' => 'select', 'list'=>array() ));?>
	<?=$this->form->field( 'value', array('type' => 'textarea', 'value'=>$setting->value ) );?>
	<?=$this->form->submit( $t( 'Edit setting submit button' ) ); ?>
	<?=$this->form->end(); ?>
</div>