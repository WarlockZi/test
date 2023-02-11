<?php


namespace app\Repository;


use app\model\Question;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


class QuestionRepository
{

	public static function shuffleAnswers(Collection $questions)
	{
		return $questions->map(function ($q) {
			$q->setRelation('answers',$q->answers->shuffle());
			return $q;
		});
	}

	public static function empty(Model $test, string $parentSelector)
	{
		$question = new Question();
		$question = $question->getFillable();
		$question['id'] = 0;
		ob_start();
		include ROOT . '/app/view/Question/edit_BlockQuestion.php';
		return ob_get_clean();

	}

	public static function getQuestion($question, $parentSelector = '')
	{
		ob_start();
		include ROOT . '/app/view/Question/edit_BlockQuestion.php';
		return ob_get_clean();
	}


}