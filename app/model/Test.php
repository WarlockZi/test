<?php

namespace app\model;


class Test extends Model
{

	public $table = 'test';
	public $model = 'test';

	public $fillable = [
		'id' => 0,
		'name' => '...',
		'enable' => 0,
		'parent' => 0,
		'isTest' => 1,
	];

	public $hasMany = [];

	public function questions(){
		$id = $this->items[0]['id'];
		return Question::findAllWhere('parent', $id);
	}


	static function shuffle_assoc($array)
	{
		$keys = array_keys($array);
		shuffle($keys);
		foreach ($keys as $key) {
			$new[$key] = $array[$key];
		}
		return $new;
	}



	public static function getTestData($testId, bool $shuffle = false)
	{
		$model = new self();

		$sql =
			<<<her
SELECT i.path, i.name,
       iq.path as qpath, iq.name as qname, 
       q.qustion, q.sort, a.answer, a.correct_answer, q.id as q_id, a.id as a_id
FROM question q
LEFT JOIN answer a
	ON a.parent_question=q.id 
    
left join image_morph im
   on im.type='answer' and im.type_id=a.id
left join images i 
   on i.id=im.image_id
    
left join image_morph imq
   on imq.type='question' and imq.type_id=q.id
left join images iq 
   on iq.id=imq.image_id

WHERE q.parent = ?
ORDER by q.sort+0,q.qustion
her;

		// +0 для сортировки чисел, чтобы не было 2>10 // AND test.enable = :testEnable
		$params = [$testId];
		$result = $model->findBySql($sql, $params);

		$data = [];
		$prevQuest = 0;

		foreach ($result as $row) {
			$q_id = $row['q_id'];
			if ($prevQuest != $q_id) {
				$data[$q_id][0]['question_text'] = htmlentities($row['qustion']);
				$data[$q_id][0]['question_pic'] = ($row['qpath'] && $row['qname']) ? $row['qpath'] . '/' . $row['qname'] : '';
				$data[$q_id][0]['sort'] = $row['sort'];
				if ($prevQuest && $shuffle) {
					$data[$prevQuest] = self::shuffle_assoc($data[$prevQuest]);
				}
			}
			$a_id = $row['a_id'];
			$data[$q_id][$a_id]['answer_text'] = htmlentities($row['answer']);
			$data[$q_id][$a_id]['answer_pic'] = ($row['path'] && $row['name']) ? $row['path'] . '/' . $row['name'] : '';
			$data[$q_id][$a_id]['correct_answer'] = $row['correct_answer'];

			if ($row['correct_answer'] == 1) {
				$data['correct_answers'][] = $row['a_id'];
			}
			$prevQuest = $q_id;
		}
		$_SESSION['correct_answers'] = $data['correct_answers'] ?? null;

		return $data ?? [];
	}

	public static function getCorrectAnswers()
	{
		exit(json_encode($_SESSION['correct_answers']));
	}

	public function getChildren($id)
	{
		$children = $this->findAllWhere('parent', $id);
		return $children;
	}

	public static function pagination(array $items, $addBtn)
	{
		$pagination = '<div class="pagination">';
		$i = 0;
		foreach ($items as $id => $el) {
			$i++;
			$d = "<div data-pagination={$id}>{$i}</div>";
			$pagination .= $d;
		}

		if ($addBtn) {
			$pagination .= "<div class='pagination__add-question'>+</div>";
		}
		return $pagination . '</div></div>';
	}

}
