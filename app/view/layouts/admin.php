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
<!--	<script type="module" src="http://localhost:5000/@vite/client"></script>-->
<!--	<script type="module" src="http://localhost:4173/dist/assets/admin.js"></script>-->
<!--	<script type="module" src="http://localhost:5000/dist/assets/index.js"></script>-->

	<?= $this->assets->getCss() ?>
	<?= $this->assets->getCDNCss() ?>
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

<?= $this->getFooter();?>

<?= $this->assets->getJs() ?>
<?= $this->assets->getCDNJs() ?>

</body>
</html>