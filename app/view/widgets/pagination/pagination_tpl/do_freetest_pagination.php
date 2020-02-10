<?
$count_questions = count($questions);
// Получаем массив id вопросов  
$keys = array_keys($questions);
?>

<div class="pagination">
  <? for ($i = 1; $i <= $count_questions; $i++): ?>

    <? $key = array_shift($keys); ?>
    <? if ($i == 1) : ?>
      <a href="#question-' . $key . '" class="nav-active"><div><?= $i ?></div></a>
    <? else: ?>
      <a href="#question-' . $key . '" class = "p-no-active" ><div><?= $i ?></div></a>
        <? endif; ?>
      <? endfor; ?>

</div>