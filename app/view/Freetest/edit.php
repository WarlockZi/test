<section>
  <div class= "container-edit-test">

    <div class = 'test-menu-wrap'>
      <div class = 'add-freetest'>Добавить тест</div>

      <?
      new app\view\widgets\menu\Menu([
          'tpl' => ROOT . "/app/view/widgets/menu/menu_tpl/edit_freetest_menu.php",
          'cache' => 60,
          'sql' => 'SELECT * FROM freetest',
      ]);
      ?>

    </div>

    <div class="content">
      <? if (isset($freeTestDataToEdit) && !isset($error) && !$freeTestDataToEdit == 0):// Проверим, чтобы запрашивали конкретный тест?>


        <p class="test-name" name = "test_id" value = "<?= $testId ?>"><?= $freeTestDataToEdit[0]['name'] ?></p>
        <?= $pagination ?>

        <? $q = '' ?>
        <? foreach ($freeTestDataToEdit as $row): ?>
          <? $picQ = $row['picq'] == "" ? "" : "<img id = 'imq" . $row['qid'] . "'   src= " . PROJ . '/pic/' . $row['picq'] . ">"; ?>
          <? if ($q == ''): // Выводим вопрос в первый раз  ' data-id = ' . $row['picq'] ?>
            <? require APP . '/view/Freetest/editBlockQuestion.php'; ?>
            <? $q = $row['qid'] ?>

            <!--следующие вопросы-->   
          <? elseif ($q !== $row['qid']):// Если id вопроса не совпадает с предыдущим - это следующий вопрос   ?>
            <!--закончим предыдущий ответ-->
            <? $q = $row['qid'] ?>

          </div>

          <? require APP . '/view/Freetest/editBlockQuestion.php' ?>

        <? endif; ?>


      <? endforeach; ?>

    <? else: ?>

      <?= $error ?>

    <? endif; ?>
  </div>

</div>
</section>