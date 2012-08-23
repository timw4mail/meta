<h3>Data Outline</h3>

<ul class="outline">
<?php if (isset($outline)): ?>
	
	<?php foreach($outline as $genre_id => $genre_array): ?>
		<?php foreach($genre_array as $genre => $cat_array): ?>
		<li>
			<a href="<?= \miniMVC\site_url("genre/{$genre_id}") ?>"><?= $genre ?></a>
			
			<?php foreach($cat_array as $cat_id => $cname_array): ?>
			<ul>
				<?php foreach($cname_array as $category => $sect_array): ?>
				<li>
					<a href="<?= \miniMVC\site_url("category/{$cat_id}") ?>"><?= $category ?></a>
					
					<?php if ( ! empty($sect_array)): ?>
					<ul>
						<?php foreach($sect_array as $section_id => $section): ?>
						<li>
							<a href="<?= \miniMVC\site_url("section/{$section_id}") ?>">
								<?= $section ?>
							</a>
						</li>
						<?php endforeach ?>
					</ul>
					<?php endif ?>
					
				</li>
				<?php endforeach ?>
			</ul>
			<?php endforeach; ?>
			
		</li>
		<?php endforeach ?>
	<?php endforeach ?>
	
<?php endif ?>
</ul>