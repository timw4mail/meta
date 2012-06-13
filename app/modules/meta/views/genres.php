<h1>Meta</h1>
<h3>Genres</h3>

<ul class="list">
<?php foreach($genres as $id => $name): ?>
	<li><a href="<?= miniMVC\site_url("genre/{$id}") ?>"><?= $name ?></a></li>
<?php endforeach ?>
</ul>

<form action="<?= miniMVC\site_url("genre/add") ?>" method="post">
	<fieldset>
		<lengend>Add Genre</lengend>
		<dl>
			<!-- Weird tag wrapping is intentional for display: inline-block -->
			<dt><label for="genre">Genre name:</label></dt><dd>
				<input type="text" name="genre" id="genre" /></dd>

			<dt>&nbsp;</dt><dd>
				<button type="submit">Add Genre</button></dd>
		</dl>
	</fieldset>
</form>