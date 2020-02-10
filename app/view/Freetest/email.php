<html>
  <body style='font-family:Arial,sans-serif;'>
    <h2 style='font-weight:bold;border-bottom:1px dotted #ccc;'>Дата заполнения   -<?= date('Y-m-d H:i:s') ?></h2>
    <p><strong>Название теста: </strong> <?=$testName?></p>
    <p><strong>От кого: </strong>  <?=$userName?></p>
    <p><strong>Результат: </strong>  <?= $errorCnt ?> ошибок из <?= $questCnt ?></p>
    <p><strong> <a href = "<?= $httpRes;//'file://'.$fileWin ?>" target="_blank"> Ссылка на страницу с результатами  </a></strong> </p>
    
  </body>
</html>