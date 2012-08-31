<form method="post" action="<?= $action ?>">
	<fieldset>
		<legend>Edit <?= ucfirst($type) ?></legend>
		<dl>
		<?php if ($type != 'data'): ?>
			<dt><label for="<?= $field_name ?>"><?= $type ?></label></dt>
			<dd><input type="text" value="<?= $field_val ?>" name="<?= $field_name ?>" id="<?= $field_name ?>" /></dd>
		<?php else: ?>
			<dt><label for="key">Name:</label></dt>
			<dd><input type="text" value="<?= $name ?>" id="name" name="name" /></dd>

			<dt><label for="val">Value:</label></dt>
			<dd><textarea name="val" rows="5" cols="40"><?= $val ?></textarea></dd>
		<?php endif ?>
			<dt><input type="hidden" name="<?= $type ?>_id" value="<?= $field_id ?>" /></dt>
			<dd><button type="submit">Save Changes</button></dd>
		</dl>
	</fieldset>
</form>