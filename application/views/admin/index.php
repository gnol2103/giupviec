<!DOCTYPE html>
<html lang="en">

<head>
	<title>Admin|Máy chấm công</title>
	<meta name="robots" content="noindex,nofollow" />
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<meta name="description" content="" />
	<meta name="author" content="" />
	<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
	<link href="/css/admin/styles.css" rel="stylesheet" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
	<?
	require_once APPPATH . '/views/admin/includes/header.php'; ?>
	<div id="layoutSidenav">
		<?
		require_once APPPATH . '/views/admin/includes/nav_bar.php';
		?>
		<div id="layoutSidenav_content">
			<?
			$this->load->view($page_name);
			require_once APPPATH . '/views/admin/includes/footer.php';
			?>
		</div>
	</div>
	<script src="/scripts/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
	<script src="/scripts/admin/scripts.js"></script>
	<script src="/scripts/admin/datatables-simple-demo.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
	<script src="/ckeditor446/ckeditor.js"></script>
	<?
	if (isset($js)) {
	?>
		<script src="<?= $js ?>"></script>
	<?
	}
	?>
</body>

</html>
