<?= $this->load_view('theme_footer', ['queries' => $this->queries], TRUE); ?>
<?php if ($foot_js != ""): ?>
	<?= $foot_js ?>
<?php endif ?>
</body>
</html>