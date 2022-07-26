<?php

namespace app\controller;

use app\model\Model;
use app\model\Question;
use app\model\Test;
use app\model\User;
use app\view\components\Builders\ItemFieldBuilder;
use app\view\components\CustomCatalogItem\CustomCatalogItem;
use app\view\components\CustomSelect\CustomSelect;
use app\view\components\MyItem\MyItem;
use app\view\components\MySelect\MySelect;
use app\view\Test\TestView;
use app\view\View;


class TestController extends AppController
{
	public $table = 'test';
	public $model = 'test';

	public function __construct(array $route)
	{
		parent::__construct($route);
		$this->autorize();
		$this->layout = 'admin';
		View::setJs('admin.js');
		View::setCss('admin.css');
	}

	public function actionIndex()
	{
		View::setMeta('Система тестирования', 'Система тестирования', 'Система тестирования');
	}

	public function actionUpdate()
	{
		if ($this->ajax) {
			$id = Test::update($this->ajax);
			$this->exitJson(['id' => $id]);
		}

		$this->view = 'edit_update';

		$page_name = 'Редактирование тестов';
		$this->set(compact('page_name'));

		$id = $this->route['id'];
		$test = Test::findOneWhere('id', $id);
		$this->set(compact('test'));

		$item = $test;
		$item = MyItem::build(Test::class, $id)
			->del()
			->save()
			->field(
				ItemFieldBuilder::build('id')
					->name('ID')
					->get()
			)
			->field(
				ItemFieldBuilder::build('name')
					->name('Наименование')
					->contenteditable(true)
					->get()
			)
			->field(
				ItemFieldBuilder::build('enable')
					->name('Показывать')
					->type('select')
					->html(TestView::enabled($item))
					->get()
			)
			->field(
				ItemFieldBuilder::build('parent')
					->name('Принадлежит')
					->html(TestView::belongsTo($item))
					->type('select')
					->get()
			)
			->get();
//		$item = include ROOT . '/app/view/Test/getItem.php';;
		$this->set(compact('item'));
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
		$rootTests = Test::findAllWhere('isTest', 0);
		$this->set(compact('rootTests', 'test'));
	}


	public function actionUpdateOrCreate()
	{
		if ($this->ajax) {

			if ($id = Test::updateOrCreate($this->ajax)) {
				$q_id = Question::create(['parent' => $id - 1]);
				if (Question::where('parent', '=', $id - 1)) {

					$this->exitJson(['id' => $id]);
				}
			}
		}
	}

	public function actionDelete()
	{
		if (User::can($this->user, 'test_delete') || defined('SU')) {
			if (Test::delete($this->ajax['id'])) {
				$this->exitWithPopup('ok');
			}
		}
		$this->ajax['test']['enable'] = 0;
		$this->ajax['test']['id'] = $this->ajax['id'];
		Test::update($this->ajax['test']);
		exit(json_encode(['notAdmin' => true]));
	}


	public function actionGetCorrectAnswers()
	{
		$this->exitJson(($_SESSION['correct_answers']));
	}

	public function actionDo(): void
	{
		$page_name = 'Прохождение тестов';
		$this->set(compact('page_name'));

		$testId = isset($this->route['id']) ? (int)$this->route['id'] : 0;
		$test = Test::findOneWhere('id', $testId) ?? '';
		if ($test) {
			$questions
				= Question::where('parent', '=', $testId)
				->with('answer')
				->get();
			if ($questions->items) {
				$this->shuffleAnswers($questions->items);
				$this->cacheCorrectAnswers($questions->items);
			}
			$testData = $questions->items ?? '';
			$pagination = Test::pagination($testData, false, $test) ?? '';
			$this->set(compact('testData', 'pagination'));
		}
		$this->set(compact('test'));
	}

	public function actionEdit()
	{

//		View::setCss('common.css');
		$page_name = 'Редактирование тестов';
		$this->set(compact('page_name'));

		$id = isset($this->route['id']) ? (int)$this->route['id'] : 0;
		if ($id) {
			$test = Test::findOneWhere('id', $id);

			if ($test) {
				if ($test['isTest']) {
					$questions
						= Question::where('parent', '=', $id)
						->with('answer')
						->orderBy('sort')
						->get();
					if (!$questions) {
						$id = Question::create(['parent' => $id]);
						$question = Question::findOneWhere('id', $id - 1);
						$this->set(compact('question'));

						$tests = Test::findAllWhere('isTest', '1');
						$this->set(compact('tests'));
					}
				} else {
					$test['children'] = Test::findAllWhere('parent', $id);;
				}

				$this->set(compact('test'));
				$questions = $questions->items ?? '';
				$this->set(compact('questions'));
			}
		}
	}


	private function getEnableCustomSelect($tree, $selected)
	{
		return new CustomSelect([
			'selectClassName' => 'custom-select',
			'title' => 'Показывать пользователям',
			'field' => 'enable',
			'tab' => '&nbsp;&nbsp;&nbsp;',
			'initialOption' => true,
			'initialOptionValue' => 0,
			'initialOptionLabel' => '--',
			'optionName' => 'name',
			'tree' => [0 => 'да', 1 => 'нет'],
			'selected' => $selected,
		]);
	}

	private function getParentCustomSelect($tree, $selected)
	{
		return new CustomSelect([
			'selectClassName' => 'custom-select',
			'title' => 'Лежит в папке',
			'field' => 'parent',
			'tab' => '&nbsp;&nbsp;&nbsp;',
			'initialOption' => true,
			'initialOptionValue' => 0,
			'initialOptionLabel' => '--',
			'optionName' => 'name',
			'tree' => $tree,
			'selected' => $selected
		]);
	}


	private function getItem($item, $chiefs, $subordinates, $subordinates1)
	{
		return new CustomCatalogItem(
			[
				'item' => $item,
				'modelName' => $this->modelName,
				'tableClassName' => $this->tableName,
				'fields' => [
					'id' => [
						'className' => 'id',
						'field' => 'id',
						'name' => 'ID',
						'contenteditable' => '',
						'width' => '50px',
						'data-type' => 'number',
					],
					'name' => [
						'className' => 'name',
						'field' => 'name',
						'name' => 'Наименование',
						'width' => '1fr',
						'contenteditable' => 'contenteditable',
						'data-type' => 'string',
					],
					'full_name' => [
						'className' => 'fullname',
						'field' => 'full_name',
						'name' => 'Полное наименование',
						'width' => '1fr',
						'contenteditable' => 'contenteditable',
						'data-type' => 'string',
					],
					'chief' => [
						'className' => 'chief',
						'field' => 'chief',
						'name' => 'Подчиняется',
						'width' => '1fr',
						'contenteditable' => false,
						'data-type' => 'select',
						'select' => $chiefs,
					],
					'subourdinate' => [
						'className' => 'fullname',
						'field' => '$subordinate',
						'name' => 'Управляет',
						'width' => '1fr',
						'data-type' => 'select',
						'select' => $subordinates,
					],
					'subourdinate1' => [
						'className' => 'fullname',
						'field' => '$subordinate',
						'name' => 'Управляет',
						'width' => '1fr',
						'data-type' => 'multiselect',
						'select' => $subordinates1,
					],
				],
				'delBttn' => 'ajax',
				'toListBttn' => true,
				'saveBttn' => 'ajax',//'redirect'
			]
		);
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
			if (isset($question['Answer'])) {
				$new = $this->shuffle_assoc($question['Answer']);
				$question['Answer'] = $new;
			}
		}
	}

	private function cacheCorrectAnswers(array $arr): void
	{
		foreach ($arr as $q) {
			if (isset($q['Answer'])) {
				foreach ($q['Answer'] as $answer) {
					if ($answer['correct_answer']) {
						$correctAnswers[] = $answer['id'];
					}
				}
			}
		}
		$_SESSION['correct_answers'] = $correctAnswers ?? '';
	}

	public function actionPaths()
	{
		exit(json_encode($this->paths()));
	}

	private function paths()
	{
		return Test::findAllWhere('isTest', '0');
	}

	public function actionTests()
	{
		$this->exitJson(Test::findAllWhere('isTest', '1'));
	}




//	public function actionCreate()
//	{
//		if ($this->ajax) {
//
//			if ($id = Test::create($this->ajax)) {
//				$q_id = Question::create();
//				exit(json_encode([
//					'id' => $id,
//				]));
//			}
//		}
//	}
}
