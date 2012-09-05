<h2><?= $genre ?></h2>

<p class="breadcrumbs">
<a href="<?= miniMVC\site_url('') ?>">Genres</a> > <?= $genre ?>
</p>

<form action="<?= miniMVC\site_url("genre/add_category") ?>" method="post">
	<fieldset>
		<legend>Add Category</legend>
		<dl>
			<!-- Weird tag wrapping is intentional for display: inline-block -->
			<dt><label for="category">Category name:</label></dt><dd>
				<input type="text" name="category" id="category" /></dd>

			<dt><input type="hidden" name="genre_id" value="<?= $genre_id ?>" /></dt><dd>
				<button type="submit">Add Category</button></dd>
		</dl>
	</fieldset>
</form>

<ul>
<?php foreach($categories as $id => $cat): ?>
	<li><a href="<?= miniMVC\site_url("category/detail/{$id}") ?>"><?= $cat ?></a></li>
<?php endforeach ?>
</ul>

