<div class="page-name">Результаты тестов</div>

<div class="test-results__table">
   <? use app\core\Icon;

   foreach ($res as $i): ?>
       <div class="item" data-row="<?= $i['id'] ?>"> <?= $i['user']; ?></div>
       <a class="item" data-row="<?= $i['id'] ?>" href='<?= '/adminsc/testresult/result/' . $i['id']; ?>'
          class="test-result"><?= $i['testname']; ?></a>
       <div class="item <?= $i['errorCnt'] ? 'error' : 'suc' ?>" data-row="<?= $i['id'] ?>">
           вопр - <?= $i['questionCnt']; ?>
           ошибок - <?= $i['errorCnt']; ?>
       </div>
       <div class="item" data-row="<?= $i['id'] ?>"> <?= $i['date']; ?></div>

       <div class="item del-btn <?= \app\model\$user->can(['test-results_del']) ? 'del' : ''; ?>"
            data-row="<?= $i['id'] ?>">
          <?= Icon::trashIcon(); ?>
       </div>
   <? endforeach; ?>
</div>
