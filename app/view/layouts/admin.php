<?

use app\view\Footer\Footer;
use \app\view\Header\Header;
use \app\core\Error;

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
	<!-- Include the Quill library -->
	<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

	<? $this::getCSS() ?>
</head>

<body>

<div class="admin-layout__container">

	<?= Header::getAdminHeader(); ?>


	<div class="admin-layout__content">

		 <?= Error::getErrorHtml() ?>

		 <?= $content ?>

	</div>

	<div class="led"></div>
</div>

<?= Footer::getAdminFooter() ?>

<? $this::getJS() ?>

</body>
</html>