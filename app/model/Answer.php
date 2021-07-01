<?php

namespace app\model;

use app\core\App;
use app\model\Model;


class Answer extends Model
{
	protected $table = 'answer';
	protected $model = 'answer';
	protected $answer = [
		'parent_question'=>null,
		'answer'=>'',
		'correct_answer'=>'0',
		'pica'=>''
	];

	public function show($id, $q_id)//qAdd()
	{
		$params = [$q_id];
		$sql = "INSERT INTO {$this->table} (parent_question) VALUES (?)";
		$this->insertBySql($sql, $params);
		$answer = $this->answer;

		exit(require ROOT. '/app/view/Test/editBlockAnswer.php');
	}
	public function delete($id)
	{
		return parent::delete($id); // TODO: Change the autogenerated stub

	}

}