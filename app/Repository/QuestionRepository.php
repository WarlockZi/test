<?php


namespace app\Repository;


use app\model\Question;
use \app\view\Test\TestView;
use Illuminate\Database\Eloquent\Model;

class QuestionRepository
{

	public static function empty(Model $test, string $parentSelector)
	{
		$question = new Question();
		$question = $question->getFillable();
		$question['id'] = 0;
//		$parentSelector = TestView::questionParentSelector($test['id']);
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