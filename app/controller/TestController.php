<?php

namespace app\controller;

use app\model\Illuminate\Test;
use app\model\Illuminate\Question;
use app\model\User;
use app\view\Test\TestView;
use app\view\View;


class TestController extends AppController
{

	public $model = Test::class;
//	public $modelName = 'test';

	public function __construct(array $route)
	{
		parent::__construct($route);
	}

	public function actionDo(): void
	{
		$page_name = 'Прохождение тестов';
		$this->set(compact('page_name'));

		$testId = isset($this->route['id']) ? (int)$this->route['id'] : 0;
		$test = Test::find($testId);
		if ($test) {
			$questions
				= Question::where('test_id',$testId)
				->with('answers')
				->get()->toArray();
			if ($questions) {
				$this->shuffleAnswers($questions);
				$this->cacheCorrectAnswers($questions);
			}
			$testData = $questions;
			$pagination = Test::pagination($testData, false, $test) ?? '';
			$this->set(compact('testData', 'pagination'));
		}
		$this->set(compact('test'));
	}

	public function actionEdit()
	{
		if ($this->ajax) {
			$id = Test::update($this->ajax);
			$this->exitJson(['id' => $id]);
		}
		if (isset($this->route['id'])) {
			$id = $this->route['id'];
			$item = TestView::item($id);
			$this->set(compact('item'));
		}
	}
	public function actionIndex()
	{
		View::setMeta('Система тестирования', 'Система тестирования', 'Система тестирования');
	}

	public function actionShow()
	{
		$this->view = 'edit_show';

		$page_name = 'Создание теста';
		$this->set(compact('page_name'));

		$paths = $this->paths();
		$this->set(compact('paths'));

		$test['isTest'] = 1;
		$this->set(compact('test'));
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


//	public function actionUpdateOrCreate()
//	{
//		if ($this->ajax) {
//
//			if ($id = Test::updateOrCreate($this->ajax)) {
//				$q_id = Question::create(['parent' => $id - 1]);
//				if (Question::where('parent', '=', $id - 1)) {
//
//					$this->exitJson(['id' => $id]);
//				}
//			}
//		}
//	}

//	public function actionDelete()
//	{
//		if (User::can($this->user, 'test_delete') || defined('SU')) {
//			if (Test::delete($this->ajax['id'])) {
//				$this->exitWithPopup('ok');
//			}
//		}
//		$this->ajax['test']['enable'] = 0;
//		$this->ajax['test']['id'] = $this->ajax['id'];
//		Test::update($this->ajax['test']);
//		exit(json_encode(['notAdmin' => true]));
//	}


	public function actionGetCorrectAnswers()
	{
		$this->exitJson(($_SESSION['correct_answers']));
	}

	function shuffle_assoc($array)
	{
		$keys = array_keys($array);
		shuffle($keys);
		foreach ($keys as $key) {
			$new[$key] = $array[$key];
		}
		return $new;
	}

	private function shuffleAnswers(array &$arr): void
	{
		foreach ($arr as $index => &$question) {
			if (isset($question['answers'])&& count($question['answers'])) {
				$new = $this->shuffle_assoc($question['answers']);
				$question['answers'] = $new;
			}
		}
	}

	private function getCorrectAnswers(array $arr): array
	{
		$correctAnswers =[];
		foreach ($arr as $q) {
			if (isset($q['answers'])) {
				foreach ($q['answers'] as $answer) {
					if ($answer['correct_answer']) {
						$correctAnswers[] = $answer['id'];
					}
				}
			}
		}
		return $correctAnswers;
	}

	private function cacheCorrectAnswers(array $arr): void
	{
		$correctAnswers = $this->getCorrectAnswers($arr);
		$_SESSION['correct_answers'] = $correctAnswers ?? '';
	}

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
