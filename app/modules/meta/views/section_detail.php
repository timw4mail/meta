<h2><?= $section ?></h2>

<p class="breadcrumbs">
	<a href="<?= miniMVC\site_url('') ?>">Genres</a> >
	<a href="<?= miniMVC\site_url('genres/detail/'.$p['genre_id']) ?>"><?= $p['genre'] ?></a> >
	<a href="<?= miniMVC\site_url('category/detail/'.$p['category_id']) ?>"><?= $p['category'] ?></a> >
	<?= $section ?>
</p>

<form action="<?= miniMVC\site_url("section/add_data") ?>" method="post">
	<fieldset>
		<legend>Add Data</legend>
		<dl>
			<!-- Weird tag wrapping is intentional for display: inline-block -->
			<dt><label for="name">Name:</label></dt><dd>
				<input type="text" name="name[]" id="section" /></dd>

			<dt><label for="val">Value:</label></dt><dd>
				<textarea id="input" name="val[]" rows="5" cols="40"></textarea></dd>

			<dt><input type="hidden" name="section_id" value="<?= $section_id ?>" /></dt><dd>
				<button type="submit" class="save">Save Data</button></dd>
		</dl>
	</fieldset>
</form>

<?php if ( ! empty($sdata)): ?>

	<?php foreach($sdata as $d): ?>
		<?php foreach($d as $k => $v): ?>
		<?php $class = (strpos($v, "<br />") !== FALSE) ? 'multiline' : 'pair' ?>
		<dl class="<?= $class ?>">

			<dt><?= $k ?></dt>
			<dd><?= $v ?></dd>

		</dl>
		<?php endforeach ?>
	<?php endforeach ?>

<?php endif ?>