<p class="breadcrumbs">Outline</p>

<dl class="outline">
	<dt>Genre</dt>
	<dd>
		<ul>
			<li>Category
				<ul>
					<li>Section</li>
				</ul>
			</li>
		</ul>
	</dd>
</dl>
<hr />
<dl class="outline">
<?php if (isset($outline)): ?>
<?php foreach($outline as $genre_id => $genre_array): ?>

	<!-- Genres -->
	<?php foreach($genre_array as $genre => $cat_array): ?>
	<dt>
		<a href="<?= \miniMVC\site_url("genre/{$genre_id}") ?>"><?= $genre ?></a>
	</dt>
	<dd>

		<?php foreach($cat_array as $cat_id => $cname_array): ?>
		<ul>
			<!-- Categories -->
			<?php foreach($cname_array as $category => $sect_array): ?>
			<li>
				<a href="<?= \miniMVC\site_url("category/{$cat_id}") ?>"><?= $category ?></a>

				<?php if ( ! empty($sect_array)): ?>
				<ul>
					<!-- Sections -->
					<?php foreach($sect_array as $section_id => $section): ?>
					<li>
						<a href="<?= \miniMVC\site_url("section/{$section_id}") ?>">
							<?= $section ?>
						</a>
					</li>
					<?php endforeach ?>
					<!-- / Sections -->
				</ul>
				<?php endif ?>

			</li>
			<?php endforeach ?>
			<!-- / Categories -->
		</ul>
		<?php endforeach; ?>

	</dd>
	<?php endforeach ?>
	<!-- / Genres -->

<?php endforeach ?>
<?php endif ?>
</dl>