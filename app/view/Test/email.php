<html>
  <body style='font-family:Arial,sans-serif;'>
    <h2 style='font-weight:bold;border-bottom:1px dotted #ccc;'>Дата заполнения   <?= date('Y-m-d H:i:s') ?></h2>
    <p><strong>Студент: </strong>  <?=$userName?></p>
    <p><strong>Название теста: </strong> <?=$testName?></p>
    <p><strong>Вопросов: </strong>  <?= $questCnt ?></p>
    <p><strong>Ошибок: </strong>  <?= $errorCnt ?> </p>
    <p><strong> <a href = "<?= $results_link;//'file://'.$fileWin ?>" target="_blank"> Ссылка на страницу с результатами  </a></strong> </p>
    
  </body>
</html>