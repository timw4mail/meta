<p class="breadcrumbs">Genres</p>

<form class="add" action="<?= Meta\Base\site_url("genre/add") ?>" method="post">
	<fieldset>
		<legend>Add Genre</legend>
		<dl>
			<!-- Weird tag wrapping is intentional for display: inline-block -->
			<dt><label for="genre">Genre name:</label></dt><dd>
				<input type="text" name="genre" id="genre" /></dd>

			<dt>&nbsp;</dt><dd>
				<button type="submit" class="save">Add Genre</button></dd>
		</dl>
	</fieldset>
</form>

<h3>Genres</h3>
<ul class="list">
<?php foreach($genres as $id => $name): ?>
	<li>
		<a href="<?= Meta\Base\site_url("genre/detail/{$id}") ?>">
			<?= $name ?>
		</a>
		<span class="modify" data-id="<?= $id ?>" data-type="genre" data-parent="<?=$id ?>">
			<button class="edit">Edit Genre</button>
			<button class="delete">Delete Genre</button>
		</span>
	</li>
<?php endforeach ?>
</ul>