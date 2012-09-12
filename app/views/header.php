
<head>
<?= $meta ?>
<?= $css ?>
<?= $head_tags ?>
<title><?=  $title ?></title>
<?php if (!empty($base)) { ?><base href="<?=$base ?>" /><?php } ?>
<?= $head_tags ?>
<?= $head_js ?>
</head>
<body<?= (!empty($body_class)) ? "class=\"" . $body_class . "\"" : ""; ?><?= (!empty($body_id)) ? " id=\"" . $body_id . "\"" : ""; ?>>
<script type="text/javascript">
	var APP_URL = '<?= \miniMVC\site_url(); ?>';
	var ASSET_URL = APP_URL.replace('index.php/', '') + 'assets/';
</script>
<h1><a href="<?= miniMVC\site_url('') ?>">Meta</a></h1>
[<a href="<?= miniMVC\site_url('outline')?>">Data Outline</a>]<br />