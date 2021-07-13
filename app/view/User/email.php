<?use app\model\Mail;?>
<html>
	<body style='font-family:Arial,sans-serif;'>
	<p><strong>Для подтверждения почты перейдите по ссылке</strong>
		<a style='cursor:pointer;'
		   target="_blank"
		   href="<?=$href;?>
		   ">
			Подтверждение почты
		</a>
	</p>
	<p style="margin:300px;"></p>
	<a href="https://vitexopt.ru/user/unsubscribe?email=<?=$hash?>">Отписаться от рассылки</a>
  </body>
</html>