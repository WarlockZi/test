<section>
  <div class= "container-do-test">

    <div class = 'test-menu-wrap'>
      <?
      new app\view\widgets\menu\Menu([
          'tpl' => ROOT . "/app/view/widgets/menu/menu_tpl/do_freetest_menu.php",
          'cache' => 60,
          'sql' => "SELECT * FROM freetest WHERE enable = '1'"
      ]);
      ?>
    </div>

    <div class= "content"> 
      <? if (!isset($error)): ?>

        <div class ="test-name"><?= $testName; ?></div>

        <?
        new app\view\widgets\pagination\Pagination([
            'id' => $this->route['alias'],
            'testData' => $testData,
            'tpl' => ROOT . "/app/view/widgets/pagination/pagination_tpl/do_freetest_pagination.php",
            'cache' => 60,
            'sql' => "SELECT * FROM freetest_quest WHERE parent = ?"
        ]);

        $i = 1;
        ?>

        <div class="test-data">



          <? foreach ($testData as $id_quest => $item): ?>
            <div class="question" data-id="<? echo $item['id']; ?>" id="question-<?= $item['id']; ?>">


              <div class="q">
                <div class="num"><?= $i++ ?></div>
                <div class="q-text"><?= $item['question'] ?></div>

                <? if (isset($item['picq']) && $item['picq']): ?>
                  <div class="qpic">
                    <img class="test-qpic"  src="<?= PROJ . '/pic/' . $item['picq'] ?>" alt="<?= substr($item['picq'], 5); ?>">
                  </div>
                <? endif; ?>


              </div>

              <div  class = "freetest-text-editable" data-textarea="<?=$item['id']?>" contenteditable="true"></div>
            </div>

          <? endforeach; ?>
        </div>

        <a class = "button" id = "finish-freetest" data-id = "<?= $testId; ?>">ЗАКОНЧИТЬ ТЕСТ</a>

      </div> 

    <? //else: ?>
    

      <?//= $error ?>
    <? endif; ?>

</section>