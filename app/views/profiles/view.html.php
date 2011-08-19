
<div class="section-container">
	<h2><?= $t( 'View profile page title' ) ?></h2>
	<div class="field-container">
		<span class="display-label"><span><?=$t('View profile page platform field label'); ?></span></span>
		<span class="display-value"><span><?=$profile->platform;?></span></span>
		<span class="label-style"></span>
	</div>
	<div class="field-container">
		<span class="display-label"><span><?=$t('View profile page os field label'); ?></span></span>
		<span class="display-value"><span><?=$profile->os;?></span></span>
		<span class="label-style"></span>
	</div>
	<div class="field-container">
		<span class="display-label"><span><?=$t('View profile page os build field label'); ?></span></span>
		<span class="display-value"><span><?=$profile->os_build;?></span></span>
		<span class="label-style"></span>
	</div>
	<span class="section-links">
	</span>
</div>