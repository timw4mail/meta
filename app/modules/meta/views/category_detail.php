<p class="breadcrumbs">
<a href="<?= miniMVC\site_url('') ?>">Genres</a> > <a href="<?= miniMVC\site_url('genre/detail/'.$genre['id']) ?>"><?= $genre['genre'] ?></a> > <?= $category ?>
</p>

<form class="add" action="<?= miniMVC\site_url("category/add_section") ?>" method="post">
	<fieldset>
		<legend>Add Section</legend>
		<dl>
			<!-- Weird tag wrapping is intentional for display: inline-block -->
			<dt><label for="section">Section name:</label></dt><dd>
				<input type="text" name="section" id="section" /></dd>

			<dt><input type="hidden" name="category_id" value="<?= $category_id ?>" /></dt><dd>
				<button type="submit" class="save">Add Section</button></dd>
		</dl>
	</fieldset>
</form>
<script src="<?= SCRIPT_PATH.'wysiwyg'; ?>"></script>
<h3>Sections</h3>
<ul class="list">
<?php foreach($sections as $id => $section): ?>
	<?php if (is_array($section)) list($section, $d) = $section ?>
	<li>
		<h4><a href="<?= miniMVC\site_url("section/detail/{$id}") ?>"><?= $section ?></a></h4>
		<span class="modify" data-id="<?= $id ?>" data-type="section" data-parent="<?= $category_id ?>">
			<button class="edit">Edit</button>
			<button class="delete">Delete</button>
		</span>

		<?php if ( ! empty($d)): ?>
		<?php foreach($d as $did => $dd): ?>
			<?php foreach($dd as $k => $v): ?>
			<?php $class = (strpos($v, "<ul>") !== FALSE || strpos($v, "<br />") !== FALSE) ? 'multiline' : 'pair' ?>
			<dl class="<?= $class ?>">
				<dt><?= $k ?></dt>
				<dd>
					<?= $v ?>
				</dd>
			</dl>
			<?php endforeach ?>
		<?php endforeach ?>
		<?php endif ?>

		<?php $d = array(); // Don't let data linger ?>

	</li>
<?php endforeach ?>
</ul>