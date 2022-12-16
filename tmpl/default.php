<?php defined('_JEXEC') or die; ?>
<div class="<?php echo $moduleclass; ?><?php echo ((int) $append_moduleclass === 1) ? $moduleclass_sfx : ''; ?>">
	<?php echo $module->content; ?>
</div>
