<p class="breadcrumbs">
<a href="<?= \Meta\Base\site_url('') ?>">Genres</a> > <?= $genre ?>
</p>

<form class="add" action="<?= \Meta\Base\site_url("genre/add_category") ?>" method="post">
	<fieldset>
		<legend>Add Category</legend>
		<dl>
			<!-- Weird tag wrapping is intentional for display: inline-block -->
			<dt><label for="category">Category name:</label></dt><dd>
				<input type="text" name="category" id="category" /></dd>

			<dt><input type="hidden" name="genre_id" value="<?= $genre_id ?>" /></dt><dd>
				<button type="submit" class="save">Add Category</button></dd>
		</dl>
	</fieldset>
</form>
<h3>Categories</h3>
<ul class="list">
<?php foreach($categories as $id => $cat): ?>
	<li>
		<a href="<?= \Meta\Base\site_url("category/detail/{$id}") ?>"><?= $cat ?></a>
		<span class="modify" data-type="category" data-id="<?=$id ?>" data-parent="<?=$genre_id ?>">
			<button class="edit">Edit Category</button>
			<button class="delete">Delete Category</button>
		</span>
	</li>
<?php endforeach ?>
</ul>

