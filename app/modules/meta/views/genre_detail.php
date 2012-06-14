<h1>meta</h1>
<h3><?= $genre ?></h3>

<h4>Genre Categories</h4>
<ul class="list">
<?php foreach($categories as $id => $cat): ?>
	<li><a href="<?= miniMVC\site_url("category/detail/{$id}") ?>"><?= $cat ?></a></li>
<?php endforeach ?>
</ul>

<form action="<?= miniMVC\site_url("category/add") ?>" method="post">
	<fieldset>
		<lengend>Add Category</lengend>
		<dl>
			<!-- Weird tag wrapping is intentional for display: inline-block -->
			<dt><label for="category">Category name:</label></dt><dd>
				<input type="text" name="category" id="category" /></dd>

			<dt><input type="hidden" name="genre_id" value="<?= $genre_id ?>" /></dt><dd>
				<button type="submit">Add Category</button></dd>
		</dl>
	</fieldset>
</form>