<!DOCTYPE html>
<html lang="en">

<head>
	<title>Giúp việc</title>
	<meta name="robots" content="noindex,nofollow" />
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/css/reset.css">
	<link rel="stylesheet" href="/css/header.css">
	<? foreach ($style as $style) { ?>
		<link rel="stylesheet" href="<?= $style ?>">
	<? } ?>
</head>

<body>
	<?
	require_once APPPATH . '/views/home/includes/'.$header.'.php';
	$this->load->view($page_name);
	require_once APPPATH . '/views/home/includes/'.$footer.'.php';
	?>
	<script src="/scripts/jquery.min.js"></script>
	<? foreach ($js as $js) { ?>
		<script type="text/javascript" src="<?= $js ?>"></script>
	<?}?>
</body>

</html>
