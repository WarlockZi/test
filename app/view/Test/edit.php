<section>
<div class= "container-edit-test">
	
	<div class = 'test-menu-wrap'>
		<div class = 'add-test'>Добавить тест</div>

        <? 
        new app\view\widgets\menu\Menu([
            'tpl' => ROOT.PROJ."/app/view/widgets/menu/menu_tpl/edit_test_menu.php",
            'cache' => 60,
        ]);
        ?>

	</div>

    <div class="content">
	<?if (isset($testDataToEdit)&&!isset($error)&&!$testDataToEdit==0):// Проверим, чтобы запрашивали конкретный тест?>
<!--        <div class="add-question" data-tooltip="Добавить вопрос">+
            <div id="tooltip"></div>
        </div>-->
        

        <p class="test-name" name = "test_id" value = "<?= $testId ?>"><?=$testDataToEdit[0]['test_name'] ?></p>
        <?= $pagination ?>

        <? $q = '' ?>
        <? foreach ($testDataToEdit as $row): ?>
		<? $picQ = $row['picq'] == "" ? "" : "<img id = 'imq".$row['qid']."'   src= ".PROJ.'/pic/' . $row['picq'] .  ">";?>
        <? if ($q == ''): // Выводим вопрос в первый раз  ' data-id = ' . $row['picq'] ?>
		<?  require APP . '/view/Test/editBlockQuestion.php'; ?>
                <? $q = $row['qid'] ?>

                <!--следующие вопросы-->   
        <? elseif ($q !== $row['qid']):// Если id вопроса не совпадает с предыдущим - это следующий вопрос   ?>
                <!--закончим предыдущий ответ-->
                <? $q = $row['qid'] ?>

		</div>
    
		<? require APP . '/view/Test/editBlockQuestion.php' ?>

		<? endif; ?>

		<? $correctAnswer = $row['correct_answer'] == 1 ? "checked" : "";
		$picA = $row['pica'] == "" ? "" : '<img id = "ima'.$row['id'].'"   src= '.PROJ.'/pic/' . $row['pica'] . '   data-id = ' . $row['pica'] . "'>";
		?>

		<? require APP . '/view/Test/editBlockAnswer.php' ?>

		<? endforeach; ?>

	<? else: ?>

		<?=$error?>

	<? endif; ?>
    </div>

</div>
</section>