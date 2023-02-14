<?
$count_questions = count($questions);
$keys = array_keys($questions);
?>

<div class="pagination">
	<? for ($i = 1; $i <= $count_questions; $i++): ?>

		<? $key = array_shift($keys); ?>
		<div data-id= <?= $key ?>  class = "p-no-active" >
		<div><?= $i ?></div></a>

	<? endfor; ?>

</div>