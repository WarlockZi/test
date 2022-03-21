<?php

namespace app\controller;

//use app\model\User;
//use app\model\Test;
//use app\view\View;
//use app\view\widgets\menu\Menu;
use app\core\App;
use app\model\Answer;
use app\model\Question;
use mysql_xdevapi\Exception;

class QuestionController Extends AppController
{
	private $req;

	public function __construct(array $route)
	{
		parent::__construct($route);
		$this->autorize();
		$this->req = json_decode($_POST['param'], true);
	}

	public function actionShow()
	{
		$id = App::$app->answer->autoincrement();
		$q_id = App::$app->question->autoincrement();

		$sort = $this->req['questCount'] + 1;
		$block[0]['question_text'] = '';
		$block[0]['question_pic'] = '/srvc/nophoto-min.jpg';
		$block[0]['sort'] = $sort;
		$block[$id]['answer_text'] = '';
		$block[$id]['correct_answer'] = '';

		ob_start();
		require ROOT . '/app/view/Test/edit_BlockQuestion.php';
		$block = ob_get_clean();
		$testid = $this->req['testid'];
		$data = compact("testid", "block");
		exit($json = json_encode($data));
	}

	public function actionUpdateOrCreate()
	{
		try {
			$answers = $this->req['answers'] ?? '';
			$question = $this->req['question'] ?? '';
			$q_id = $this->req['question']['id'] ?? '';
			$sort = $this->req['question']['sort'] ?? '';
			$qId = App::$app->question->updateOrCreate($q_id, $question);
			if ($qId === false) {
				return;
			} elseif (is_int($qId)) {
				if ($answers) {
					foreach ($answers as $answer) {
						$answer['parent_question'] = $qId;
						App::$app->answer->updateOrCreate($answer['id'], $answer);
					}
				}
				exit(json_encode([
					'id' => $qId,
					'msg' => 'Вопросы и ответы сохранены',
					'paginationButton' => $pagination = "<div data-pagination = $q_id class='nav-active'>{$sort}</div>"
				]));
			} elseif ($qId === true) {
				foreach ($answers as $answer) {
					App::$app->answer->updateOrCreate($answer['id'], $answer);
				}
				exit(json_encode([
					'msg' => 'Вопросы и ответы сохранены']));
			}

		} catch (Exception $exception) {
			exit($exception->getMessage());
		};
	}





	public function actionChangeParent()
	{
		if ($ids = $this->ajax) {
			$id = $ids['id'];
			$testId = $ids['test_id'];
			$q = Question::findOneWhere('id',$id);
			$q['parent'] = $testId;
			App::$app->question->update($q);
			exit(json_encode(['msg' => 'ok']));
		}
	}





	public function actionUpdate()
	{
		App::$app->question->updateOrCreate($this->req['question']['id'], $this->req['question']);

		foreach ($this->req['answers'] as $answer) {
			App::$app->answer->updateOrCreate($answer['id'], $answer);
		}
		exit(json_encode(['msg' => 'Saved']));
	}

	public function actionDelete()
	{
		$q_id = $this->ajax['q_id'];

		$answers = Answer::findAllWhere('parent_question', $q_id);
		foreach ($answers as $answer) {
			App::$app->answer->delete($answer['id']);
		}
		App::$app->question->delete($q_id);
		exit(json_encode(['msg' => 'Вопрос и ответы удалены', 'q_id' => $q_id]));
	}

	public function actionImage()
	{
		$q_id = $this->ajax['q_id'];

		$answers = Answer::findOneWhere('parent_question', $q_id);
		foreach ($answers as $answer) {
			App::$app->answer->delete($answer['id']);
		}
		App::$app->question->delete($q_id);
		exit(json_encode(['msg' => 'ok', 'q_id' => $q_id]));
	}

	public function actionSort()
	{
		$q_ids = $this->ajax['toChange'];
		App::$app->question->sort($q_ids);
		exit(json_encode(['msg' => 'Сортировка сохранена']));
	}

}
