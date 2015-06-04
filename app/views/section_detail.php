<p class="breadcrumbs">
	<a href="<?= miniMVC\site_url('') ?>">Genres</a> >
	<a href="<?= miniMVC\site_url('genres/detail/'.$p['genre_id']) ?>"><?= $p['genre'] ?></a> >
	<a href="<?= miniMVC\site_url('category/detail/'.$p['category_id']) ?>"><?= $p['category'] ?></a> >
	<?= $section ?>
</p>
<form class="add" action="<?= miniMVC\site_url("section/add_data") ?>" method="post" onsubmit="window.edit_wysiwyg.toggle()">
	<fieldset>
		<legend>Add Data</legend>
		<dl>
			<!-- Weird tag wrapping is intentional for display: inline-block -->
			<dt><label for="name">Name:</label></dt><dd>
				<input type="text" name="name[]" id="section" /></dd>

			<dt><label for="val">Value:</label></dt><dd>
				<textarea id="val" name="val[]" rows="5" cols="40"></textarea></dd>

			<dt><input type="hidden" name="section_id" value="<?= $section_id ?>" /></dt><dd>
				<button type="submit" class="save">Save Data</button></dd>
		</dl>
	</fieldset>
</form>

<h3>Data</h3>
<?php if ( ! empty($sdata)): ?>
	<?php foreach($sdata as $d_id => $d): ?>
		<?php foreach($d as $k => $v): ?>
		<?php $class = (strpos($v, "<ul>") !== FALSE || strpos($v, "<br />") !== FALSE) ? 'multiline' : 'pair' ?>
		<dl class="<?= $class ?>">
			<dt>
				<?= $k ?>
				<span class="modify" data-type="data" data-id="<?=$d_id ?>" data-parent="<?= $section_id ?>">
					<button class="edit">Edit Data</button>
					<button class="delete">Delete Data</button>
				</span>
			</dt>
			<dd><?= $v ?></dd>
		</dl>
		<?php endforeach ?>
	<?php endforeach ?>
<?php endif ?>