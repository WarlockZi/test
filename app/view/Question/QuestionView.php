<?php


namespace app\view\Question;


use app\core\FS;
use app\model\Question;
use app\model\Test;
use app\Repository\ImageRepository;
use app\Repository\QuestionRepository;
use app\view\Test\TestView;

class QuestionView
{

	public static function getImg(Question $question): string
	{
		if ($question->picq) {
			$src = ImageRepository::getImg('/pic/' . $question->picq);
			return "<div class='qpic'><img class='test-qpic' src='{$src}'</div>";
		}
		return '';
	}

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
		return FS::getFileContent(ROOT . '/app/view/Test/Admin/edit_rules.php');
	}

	private static function getContent($test, $parentSelector)
	{
		return FS::getFileContent(ROOT . '/app/view/Question/Admin/edit_questions.php');
	}

}