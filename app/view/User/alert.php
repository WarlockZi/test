<div class="overlay"></div>

<div class="messageBox">
	<div class="messageTitleBar">
		<div class="messageTitle">Сообщение</div>
	</div>

	<div class="msg">
		<? foreach ($msg as $k => $mes): ?>
			<div class="msgText"><?=$mes?></div>
		<? endforeach; ?>
	</div>
	<div class="messageClose">Закрыть</div>
</div>

