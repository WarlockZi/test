<?php

namespace app\controller;

use app\core\App;
use app\model\Openanswer;
use app\model\Openquestion;


class OpenquestionController Extends AppController
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
			$qId = Openquestion::updateOrCreate($question);
			if ($qId === false) {
				return;
			} elseif (is_int($qId)) {
				if ($answers) {
					foreach ($answers as $answer) {
						$answer['parent_question'] = $qId;
						Answer::updateOrCreate($answer);
					}
				}
				exit(json_encode([
					'id' => $qId,
					'msg' => 'Вопросы и ответы сохранены',
					'paginationButton' => $pagination = "<div data-pagination = $q_id class='nav-active'>{$sort}</div>"
				]));
			} elseif ($qId === true) {
				foreach ($answers as $answer) {
					Answer::updateOrCreate($answer);
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
			Question::update($q);
			exit(json_encode(['msg' => 'ok']));
		}
	}



	public function actionUpdate()
	{
		Question::updateOrCreate($this->req['question']);

		foreach ($this->req['answers'] as $answer) {
			Answer::updateOrCreate($answer);
		}
		exit(json_encode(['msg' => 'Saved']));
	}

	public function actionDelete()
	{
		$q_id = $this->ajax['q_id'];

		$answers = Answer::findAllWhere('parent_question', $q_id);
		foreach ($answers as $answer) {
			Answer::delete($answer['id']);
		}
		Question::delete($q_id);
		exit(json_encode(['msg' => 'Вопрос и ответы удалены', 'q_id' => $q_id]));
	}

	public function actionImage()
	{
		$q_id = $this->ajax['q_id'];

		$answers = Answer::findOneWhere('parent_question', $q_id);
		foreach ($answers as $answer) {
			Answer::delete($answer['id']);
		}
		Question::delete($q_id);
		exit(json_encode(['msg' => 'ok', 'q_id' => $q_id]));
	}

	public function actionSort()
	{
		$q_ids = $this->ajax['toChange'];
		Openquestion::sort($q_ids);
		exit(json_encode(['msg' => 'Сортировка сохранена']));
	}

}
