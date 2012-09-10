<h2>Genres</h2>

<form action="<?= miniMVC\site_url("genre/add") ?>" method="post">
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

<ul>
<?php foreach($genres as $id => $name): ?>
	<li>
		<a href="<?= miniMVC\site_url("genre/{$id}") ?>">
			<?= $name ?>
		</a>
		<span class="modify" id="genre_<?=$id ?>">
			<button class="edit">Edit</button>
			<button class="delete">Delete</button>
		</span>
	</li>
<?php endforeach ?>
</ul>