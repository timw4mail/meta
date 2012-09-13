<p class="breadcrumbs">
<a href="<?= miniMVC\site_url('') ?>">Genres</a> > <?= $genre ?>
</p>

<form class="add" action="<?= miniMVC\site_url("genre/add_category") ?>" method="post">
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
		<a href="<?= miniMVC\site_url("category/{$id}") ?>"><?= $cat ?></a>
		<span class="modify" id="category_<?=$id ?>">
			<button class="edit">Edit</button>
			<button class="delete">Delete</button>
		</span>
		<ul>
		<?php /* $sarray = $this->data_model->get_sections($id); ?>
		<?php foreach($sarray as $sid => $section): ?>
			<li>
				<a href="<?= miniMVC\site_url("section/{$sid}") ?>"><?= $section ?></a>
				<span class="modify" id="section_<?=$id ?>">
					<button class="edit">Edit</button>
					<button class="delete">Delete</button>
				</span>
			</li>
		<?php endforeach */ ?>
		</ul>
	</li>
<?php endforeach ?>
</ul>

