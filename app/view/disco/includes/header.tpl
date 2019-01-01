<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height, target-densitydpi=device-dpi" />
	<script type="text/javascript">
		window.raiz = "<?= RAIZ?>";
	</script>
	<link rel="stylesheet" type="text/css" href="<?= VIEW?>style/normalize.css">
	<link href="<?= VIEW?>../../../vendor/fortawesome/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<script src="<?= VIEW?>../../../vendor/components/jquery/jquery.min.js"></script>
	<link href="<?= VIEW?>../../../vendor/twitter/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="<?= VIEW?>../../../vendor/twitter/bootstrap/dist/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="<?= VIEW?>style/app.css">
	<link rel="stylesheet" type="text/css" href="<?= VIEW?>style/toast.css">
	<script src="<?= VIEW?>js/jquery.ui.min.js"></script>
	<script src="<?= VIEW?>js/jquery.hotkeys.js"></script>
	<script src="<?= VIEW?>js/toast.min.js"></script>
	<script src="<?= VIEW?>js/app.js"></script>
	<title>Musimals - <?= (isset($title) ? $title : 'Home')?></title>
	<meta name="mobile-web-app-capable" content="yes">
	<link rel="icon" sizes="250x250" href="<?= VIEW?>img/smallicon.png">
	<link rel="manifest" href="<?= VIEW?>manifest.json">
</head>
<body id="body" name="body">