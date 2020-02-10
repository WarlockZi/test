<div class="overlay"></div>

<div class="messageBox">
	<div class="messageTitleBar">
		<div class="messageTitle">Сообщение</div>
	</div>
	
	<div class="msg">
		<? foreach ($msg as $k => $Msg):?>
			<div class="msgText">- <?=$Msg?></div>
		<? endforeach;?>
	</div>
	<div class="messageClose">Закрыть</div>
</div>
    <script type="text/javascript">
      var close = document.querySelector('.messageClose'),
              overlay = document.querySelector('.overlay'),
              box = document.querySelector('.messageBox')
      ;
      debugger;
      close.onclick = function(){
        overlay.style.display = "none";
        box.style.display = "none";
        window.location.replace('/freetest');
      };

    </script>