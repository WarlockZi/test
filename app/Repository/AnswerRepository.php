<?php


namespace app\Repository;


use app\model\Answer;

class AnswerRepository
{

	public static function empty(int $i = 0)
	{
		$an = new Answer;
		$an = $an->getFillable();
		foreach ($an as $index => $item) {
			$a[$item] = '';
		}
		$a['id'] = 0;
		ob_start();
		include ROOT . '/app/view/Question/edit_BlockAnswer.php';
		return ob_get_clean();
	}

	public static function getAnswer(int $i, array $a)
	{
		include ROOT . "/app/view/Question/edit_BlockAnswer.php";
	}


}