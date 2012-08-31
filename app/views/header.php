
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
<h1><a href="<?= miniMVC\site_url('') ?>">Meta</a></h1>