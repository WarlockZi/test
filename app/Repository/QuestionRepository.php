<?php


namespace app\Repository;


use app\core\FS;
use app\model\Question;
use app\model\Test;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


class QuestionRepository
{

	public static function shuffleAnswers(Test $test): Collection
	{
		if (!$test || !$test->questions) return null;
		return $test->questions->map(function ($q) {
			$q->setRelation('answers', $q->answers->shuffle());
			return $q;
		});
	}

	public static function empty(Model $test, string $parentSelector)
	{
		$question = new Question();
		$question = $question->getFillable();
		$question['id'] = 0;
		return FS::getFileContent(ROOT . '/app/view/Question/Admin/edit_BlockQuestion.php');
	}

	public static function getQuestion($question, $parentSelector = '')
	{
		ob_start();
		include ROOT . '/app/view/Question/Admin/edit_BlockQuestion.php';
		return ob_get_clean();
	}


}