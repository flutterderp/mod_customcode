<?php defined('_JEXEC') or die; ?>
<div class="customcode<?php echo ((int) $append_moduleclass === 1) ? $moduleclass_sfx : ''; ?>">
	<?php echo $module->content; ?>
</div>
