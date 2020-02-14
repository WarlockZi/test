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
</script>
<style>
	.overlay{
		width:100%;
		height:100%;
		background-color:#000;
		z-index: 1000;
		position:fixed;
		top:0;
		left:0;
		opacity:0.5;
		display:none;
	}
	.messageBox{
		display: flex;
		flex-direction:column;
		width: 30%;
		min-width: 241px;
		position: fixed;
		top: 10vw;
		left: 30%;
		background-color: #eff4ee;
		z-index: 10001;
		line-height: 25px;
		font-size: 14px;
		font-family: 'Roboto', sans-serif;
	}
	.messageBox>div{
		padding: 10px;
	}
	.messageTitleBar{
		display: flex;
		text-transform:uppercase;
	}
	.messageTitle{
		flex:1;
		color: #80868e;
		padding-left: 20px;
		font-weight: 800;
	}
	.messageClose{
		display: flex;
		justify-content: center;
		flex: 1;
		transition: .5s;
		color: #494949;
		background: #ccc;
		text-transform: uppercase;
		font-weight: 800;
		cursor: pointer;
	}
	.messageClose:hover{
		background: #4cb000;
		transition:.3s;
		color: #000;
		font-weight: 800;
	}
	.msg div{
		color: #6e6e6e;
		font-size: 20px;
		padding: 0 30px;
	}
	.msg{
		min-height:100px;
		background: #fff;
	}

	.msg a{
		text-decoration: underline;
		color: #1d5bff;
		font-weight: 800;
		padding: 3px;
	}
</style>