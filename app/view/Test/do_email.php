<html>
  <body style='font-family:Arial,sans-serif;'>
    <h2 style='font-weight:bold;border-bottom:1px dotted #ccc;'>Дата заполнения   <?= date('Y-m-d H:i:s') ?></h2>
    <p><strong>Студент: </strong>  <?=$data['userName']?></p>
    <p><strong>Название теста: </strong> <?=$data['test_name']?></p>
    <p><strong>Вопросов: </strong>  <?= $data['questionCnt'] ?></p>
    <p><strong>Ошибок: </strong>  <?=$data['errorCnt'] ?> </p>
    <p><strong> <a href = "<?= $results_link;//'file://'.$fileWin ?>"
                   target="_blank"> Ссылка на страницу с результатами  </a>
	    </strong>
    </p>
    
  </body>
</html>