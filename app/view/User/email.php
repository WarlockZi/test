<html>
	<body style='font-family:Arial,sans-serif;'>
	<p><strong> Для подтверждения почты перейдите по ссылке</strong>
		<a style='cursor:pointer;' target="_blank" href=<?=
<<<here
"{$_SERVER['REQUEST_SCHEME']}://
{$_SERVER['SERVER_NAME']}
/user/confirm?hash={$hash}">
here; ?>
Подтверждение почты
		</a>
	</p>
	<a href="https://vitexopt.ru/user/unsubscribe?email=<?=$hash?>">Отписаться от рассылки</a>
  </body>
</html></html>