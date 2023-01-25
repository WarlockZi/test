<?php


namespace app\Repository;


use app\model\Answer;

class AnswerRepository
{

	public static function empty()
	{
		$answer = new Answer;
		$i = -1;
		ob_start();
		include ROOT . '/app/view/Question/edit_BlockAnswer.php';
		return ob_get_clean();
	}

	public static function getAnswer(int $i, Answer $answer)
	{
		include ROOT . "/app/view/Question/edit_BlockAnswer.php";
	}


}