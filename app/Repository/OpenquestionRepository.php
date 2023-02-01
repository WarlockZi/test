<?php


namespace app\Repository;


use app\model\Opentest;

class OpenquestionRepository
{

	public static function empty($test)
	{
		$question = new Opentest();
		$question = $question->fillable;
		$question['id'] = 0;
		$parentSelector = \app\view\OpenTest\OpentestView::questionParentSelector($test['id']);
		ob_start();
		include ROOT . '/app/view/Openquestion/q-edit.php';
		return ob_get_clean();

	}

	public static function getQuestion($question,$parentSelector='')
	{
		ob_start();
		include ROOT . '/app/view/Question/edit_BlockQuestion.php';
		return ob_get_clean();
	}


}