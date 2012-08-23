<h3><?= $category ?></h3>

<h4>Category Sections</h4>
<ul class="list">
<?php foreach($sections as $id => $section): ?>
	<li><a href="<?= miniMVC\site_url("section/detail/{$id}") ?>"><?= $section ?></a></li>
<?php endforeach ?>
</ul>

<form action="<?= miniMVC\site_url("section/add") ?>" method="post">
	<fieldset>
		<lengend>Add Section</lengend>
		<dl>
			<!-- Weird tag wrapping is intentional for display: inline-block -->
			<dt><label for="section">Section name:</label></dt><dd>
				<input type="text" name="section" id="section" /></dd>

			<dt><input type="hidden" name="category_id" value="<?= $category_id ?>" /></dt><dd>
				<button type="submit">Add Section</button></dd>
		</dl>
	</fieldset>
</form>