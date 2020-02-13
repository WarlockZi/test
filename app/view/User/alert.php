<div class="overlay"></div>

<div class="messageBox">
	<div class="messageTitleBar">
		<div class="messageTitle">Сообщение</div>
	</div>

	<div class="msg">
		<? foreach ($msg as $k => $Msg): ?>
			<div class="msgText">- <?= $Msg ?></div>
		<? endforeach; ?>
	</div>
	<div class="messageClose">Закрыть</div>
</div>

<script>

    var overlay = document.querySelector(".overlay"),
        box = document.querySelector(".messageBox"),
        clos = document.querySelector(".messageClose");
    overlay.addEventListener("click", function () {
        overlay.autocomplete.display = 'none';
        box.autocomplete.display = 'none';
    });
    clos.addEventListener("click", function () {
        overlay.autocomplete.display = 'none';
        box.autocomplete.display = 'none';
    });
