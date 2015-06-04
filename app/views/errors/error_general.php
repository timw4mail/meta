<!DOCTYPE HTML>
<html>
<head>
	<title>404 Not Found</title>
	<style type="text/css">
	div{position:relative; margin:0.5em auto; padding:0.5em; width:95%; border:1px solid #924949; background: #f3e6e6;}
	</style>
</head>
<body>
	<div class="message error">
		<?php if (isset($title)) : ?>
		<h1><?= $title ?></h1>
		<?php endif ?>

		<?= $message; ?>

	</div>
</body>
</html>