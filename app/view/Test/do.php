<section>
  <div class= "container-do-test">

    <div class = 'test-menu-wrap'>
        <?
        if (!$menuTestDo = 
           app\core\App::$app->cache->get('menuTestDo')
           && !DEBU
           ) {
            ob_start();
            new app\view\widgets\menu\Menu([
                'tpl' => ROOT . "/app/view/widgets/menu/menu_tpl/do_test_menu.php",
                'cache' => 60,
                'sql' => "SELECT * FROM test WHERE enable = '1'"
            ]);
            echo $menuTestDo = ob_get_clean();

            app\core\App::$app->cache->set('menuTestDo', $menuTestDo, 60 * 5);
        } else {
            echo $menuTestDo;
        }
        ?>
    </div>

    <div class= "content"> 

      <? if (isset($testData) && !isset($error) && !$testData == 0):// Проверим, чтобы запрашивали конекретный тест?>


          <div class ="test-name"><?= $testName; ?></div>

          <?=
          $pagination;
          $i = 1;
          ?>

          <div class="test-data">

    <? foreach ($testData as $id_quest => $item): ?>
                <div class="question" data-id="<? echo $id_quest; ?>" id="question-<?= $id_quest; ?>">


                  <div class="q">
                    <div class="num"><?= $i++ ?></div>
                    <div class="q-text"><?= $item[0]['question_text'] ?></div>

        <? if ($item[0]['question_pic']): ?>
                        <div class="qpic">
                          <img class="test-qpic"  src="<?= PROJ . '/pic/' . $item[0]['question_pic'] ?>" alt="<?= substr($item[0]['question_pic'], 5); ?>">
                        </div>
                    <? endif; ?>
                    <? unset($item[0]); ?>

                    <? foreach ($item as $id_answer => $answer): ?>
            <? if (is_array($answer)and $id_answer !== 'correct_answer'): //выложим ответы               ?>

                            <div class="a">
                              <hr size=1,5px width=85% align="left">
                              <input type="checkbox" name="question-<?= $id_quest ?>" 
                                     id="answer-<?= $id_answer ?>" value = "<?= $id_answer ?>">
                              <label for="answer-<?= $id_answer ?>"><?= $answer['answer_text'] ?></label>

                <? if ($answer['answer_pic']): ?>
                                  <div class="apic">
                                    <img src="<?= PROJ . '/pic/' . $answer['answer_pic'] ?>" alt="">
                                  </div>
                <? endif ?>


                            </div>
                        <? endif; ?>
        <? endforeach; ?>
                  </div>
                </div>
    <? endforeach; ?>
          </div>

          <a class = "button" id = "btnn" data-id = "<?= $testId; ?>">ЗАКОНЧИТЬ ТЕСТ</a>
      <? else: ?>

          <?= $error ?>

<? endif; ?>
    </div> 

</section>