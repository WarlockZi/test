<?php


namespace app\Repository;


use app\model\Question;
use \app\view\Test\TestView;

class QuestionRepository
{

	public static function empty($test)
	{
		$question = new Question;
		$question = $question->fillable;
		$question['id'] = 0;
		$parentSelector = TestView::questionParentSelector($test['id']);
		ob_start();
		include ROOT . '/app/view/Question/edit_BlockQuestion.php';
		return ob_get_clean();

	}

	public static function getQuestion($question,$parentSelector='')
	{
		ob_start();
		include ROOT . '/app/view/Question/edit_BlockQuestion.php';
		return ob_get_clean();
	}


}