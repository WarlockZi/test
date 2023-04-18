<?

use app\core\Error;

?>
<!DOCTYPE html>
<html>
<!--ADMIN-LAYOUT-->
<head>
	<meta name="token" content="<?= $_SESSION['token'] ?>">
	<meta name="robots" content="noindex,nofollow"/>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="/public/favicon.ico" type="image/x-icon">


	<!--	<link href="https://cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">-->
	<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
	<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>



	<script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-core.min.js"></script>
	<script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-circular-gauge.min.js"></script>
	<script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-pie.min.js"></script>
	<script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
	<script src="https://cdn.anychart.com/releases/v8/js/anychart-ui.min.js"></script>
	<script src="https://cdn.anychart.com/releases/v8/js/anychart-exports.min.js"></script>
	<link href="https://cdn.anychart.com/releases/v8/css/anychart-ui.min.css" type="text/css" rel="stylesheet">
	<link href="https://cdn.anychart.com/releases/v8/fonts/css/anychart-font.min.css" type="text/css" rel="stylesheet">
	<script src="https://cdn.anychart.com/geodata/latest/countries/slovakia/slovakia.js"></script>
	<script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
	<script src="https://cdn.anychart.com/releases/v8/js/anychart-ui.min.js"></script>
	<script src="https://cdn.anychart.com/releases/v8/js/anychart-exports.min.js"></script>
	<script src="https://cdn.anychart.com/releases/v8/js/anychart-map.min.js"></script>
	<script src="https://cdn.anychart.com/releases/v8/js/anychart-data-adapter.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.3.15/proj4.js"></script>
	<script src="https://cdn.anychart.com/releases/v8/themes/dark_blue.min.js"></script>
	<link href="https://cdn.anychart.com/releases/v8/css/anychart-ui.min.css" type="text/css" rel="stylesheet">
	<link href="https://cdn.anychart.com/releases/v8/fonts/css/anychart-font.min.css" type="text/css" rel="stylesheet">

	<?= $this->assets->getCss() ?>
</head>

<body>

<div class="admin-layout__container">

	<?= $this->getHeader(); ?>


	<div class="admin-layout__content">

		<div class="adm-content">
		 <?= Error::getErrorHtml() ?>
				<?= $this->getContent(); ?>
		</div

	</div>

	<div class="led"></div>
</div>

<?= $this->getFooter();//::getAdminFooter() ?>

<?= $this->assets->getJs() ?>

</body>
</html>