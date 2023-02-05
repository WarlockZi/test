<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\model\Test;
use app\Repository\AnswerRepository;
use app\Repository\QuestionRepository;
use app\view\OpenTest\OpentestView;
use app\view\View;
use Illuminate\Database\Eloquent\Collection;


class TestController extends AppController
{
	public function actionDo(): void
	{
		$page_name = 'Прохождение тестов';
		$this->set(compact('page_name'));

		if (isset($this->route['id'])) {
			$id = (int)$this->route['id'] ?? 0;
			$test = Test::with('questions.answers')
				->find($id);

			if ($test) {
				if ($test->questions) {
//					$test->questions =
						$new = QuestionRepository::shuffleAnswers($test->questions);
					AnswerRepository::cacheCorrectAnswers($test->questions);
				}
				$pagination = Test::pagination($new ?? '');
				$this->set(compact('test', 'pagination'));
			}
			$this->set(compact('test'));
		}
	}

	public function __construct(array $route)
	{
		parent::__construct($route);
	}

	public function actionEdit()
	{
		if ($this->ajax) {
			$id = Test::update($this->ajax);
			$this->exitJson(['id' => $id]);
		}
		if (isset($this->route['id'])) {
			$id = $this->route['id'];
			$item = OpentestView::item($id);
			$this->set(compact('item'));
		}
	}

	public function actionIndex()
	{
		View::setMeta('Система тестирования', 'Система тестирования', 'Система тестирования');
	}

	public function actionPathshow()
	{
		$this->layout = 'admin';
		$this->view = 'edit_show';
		$page_name = 'Создание папки';
		$this->set(compact('page_name'));

		$paths = $this->paths();
		$this->set(compact('paths'));

		$test['isTest'] = 0;
		$rootTests = Test::where('isTest', 0)->get()->toArray();
		$this->set(compact('rootTests', 'test'));
	}

	public function actionGetCorrectAnswers()
	{
		$this->exitJson(($_SESSION['correct_answers']));
	}

//  function shuffle_assoc($array)
//  {
//    $keys = array_keys($array);
//    shuffle($keys);
//    foreach ($keys as $key) {
//      $new[$key] = $array[$key];
//    }
//    return $new;
//  }





	public function actionPaths()
	{
		exit(json_encode($this->paths()));
	}

	private function paths()
	{
		return Test::where('isTest', '0')->get()->toArray();
	}

	public function actionTests()
	{
		$this->exitJson(Test::where('isTest', '1')->get()->toArray());
	}


}
