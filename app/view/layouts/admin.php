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

	<?= $this->assets->getCss() ?>
</head>

<body>

<div class="admin-layout__container">

	<?= $this->getHeader(); ?>


	<div class="admin-layout__content">

		 <?= Error::getErrorHtml() ?>

		<div class="adm-content">
				<?= $this->getContent(); ?>
		</div

	</div>

	<div class="led"></div>
</div>

<?= $this->getFooter();//::getAdminFooter() ?>

<?= $this->assets->getJs() ?>

</body>
</html>