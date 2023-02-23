<?php


namespace app\view\Question;


use app\model\Test;
use app\Repository\QuestionRepository;
use app\view\Test\TestView;

class QuestionView
{

	public static function getEditContent(Test $test)
	{
		$parentSelector = TestView::questionParentSelector($test->id);
		$content = self::getContent($test, $parentSelector);
		$rules = self::getRules();

		return "<div class='test-edit__content'>{$content}{$rules}</div>";
	}

	public static function getEditQuestions($test, $parentSelector)
	{
		$questions = '';
		foreach ($test->questions as $question) {
			$questions .= QuestionRepository::getQuestion($question, $parentSelector);
		}
		return $questions;
	}

	private static function getRules()
	{
		ob_start();
		include ROOT . '/app/view/Test/Admin/edit_rules.php';
		return ob_get_clean();
	}

	private static function getContent($test, $parentSelector)
	{
		ob_start();
		include ROOT . '/app/view/Question/Admin/edit_questions.php';
		return ob_get_clean();
	}

}