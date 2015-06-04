<form method="post" action="javascript:meta.update_item()" id="edit_form">
	<fieldset>
		<legend>Edit <?= ucfirst($type) ?></legend>
		<dl>
		<?php if ($type != 'data'): ?>
			<dt><label for="name"><?= ucfirst($type) ?></label></dt>
			<dd><input type="text" value="<?= $val ?>" name="name" id="name" /></dd>
		<?php else: ?>
			<dt><label for="name">Name:</label></dt>
			<dd><input type="text" value="<?= $name ?>" id="name" name="name" /></dd>

			<dt><label for="val">Value:</label></dt>
			<dd><textarea id="val" name="val" rows="5" cols="40"><?= $val ?></textarea></dd>
		<?php endif ?>
			<dt>
				<input type="hidden" id="id" name="id" value="<?= $id ?>" />
				<input type="hidden" id="type" name="type" value="<?= $type ?>" />
			</dt>
			<dd><button type="submit" class="save">Save Changes</button></dd>
		</dl>
	</fieldset>
</form>