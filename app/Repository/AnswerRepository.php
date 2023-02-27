<?php


namespace app\Repository;


use app\model\Answer;
use app\model\Test;
use Illuminate\Database\Eloquent\Collection;

class AnswerRepository
{

	public static function empty()
	{
		$answer = new Answer;
		$i = -1;
		ob_start();
		include ROOT . '/app/view/Question/Admin/edit_BlockAnswer.php';
		return ob_get_clean();
	}

	public static function getAnswer(int $i, Answer $answer)
	{
		include ROOT . "/app/view/Question/Admin/edit_BlockAnswer.php";
	}


	public static function cacheCorrectAnswers(Test $test): void
	{
		$res = $test->questions->map(function ($q) {
				return $q->answers->filter(function ($v, $k) {
					return $v->correct_answer === 1;
				});
			})
				->flatten()
				->pluck('id') ?? '';
		$_SESSION['correct_answers'] = $res->toArray();
	}


}