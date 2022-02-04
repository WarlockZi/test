<?php

namespace app\model;

use app\core\App;
use app\model\Model;


class Planning extends Model
{
	protected $table = 'planning';
	protected $model = 'planning';
	protected $fillable = [
		'employee'=>null,
		'plan'=>'',
		'do'=>[],
	];

//	public function show($id, $q_id)//qAdd()
//	{
//		$params = [$q_id];
//		$sql = "INSERT INTO {$this->table} (parent_question) VALUES (?)";
//		$this->insertBySql($sql, $params);
//		$answer = $this->fillable;
//
//		exit(include ROOT. '/app/view/Test/editBlockAnswer.php');
//	}
	public function delete($id)
	{
		return parent::delete($id);

	}
	public function create($value=[])
	{
		return parent::create($value);
	}

}