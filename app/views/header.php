
<head>
<?= $meta ?>
<title><?=  $title ?></title>
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
<?= $css ?>
<?= $head_tags ?>
<?php if (!empty($base)) { ?><base href="<?=$base ?>" /><?php } ?>
<?= $head_tags ?>
<?= $head_js ?>
</head>
<body<?= (!empty($body_class)) ? "class=\"" . $body_class . "\"" : ""; ?><?= (!empty($body_id)) ? " id=\"" . $body_id . "\"" : ""; ?>>
<?= $this->load_view('theme_header', [], TRUE); ?>