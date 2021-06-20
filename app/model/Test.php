<?php

namespace app\model;

use app\model\Model;
use app\core\App;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Test extends Model
{

	public $table = 'test';

	public function testParams()
	{

		if (isset($_POST['testId']) && $_POST['testId']) {// Значит открыли существующий тест
			$tId = $_POST['testId'];
			$sql = 'SELECT * FROM test  WHERE id = ?';
			$param = [$tId];
			$test = $this->findBySql($sql, $param)[0];
			$testList = $this->findAll();
			unset($testList[$tId - 1]);
			$selected = '';
			if ($test['isTest'] == 1) {
				$selected = 'selected';
			}
			$checked = 0;
			if ($test['enable'] == 1) {
				$checked = 'checked';
			}
			$depOptions = '<option value = "0">Не принадлежит</option>';
			foreach ($testList as $testDep) {
				// Проставим от какого теста зависит
				if ($testDep['id'] == $test['parent']) {
					$depOptions .= '<option value = ' . $testDep['id'] . ' selected >' . $testDep['test_name'] . '</option>';
				} else {
					$depOptions .= '<option value = ' . $testDep['id'] . '>' . $testDep['test_name'] . '</option>';
				}
			}
		} else {// Добавляем новый тест
			$test['id'] = 0;
			$test['test_name'] = '';
			$test['sort'] = 0;
			$selected = '';
			$checked = 0;
			$testList = $this->findAll();
			$depOptions = '<option value = "0">Не принадлежит</option>';
			foreach ($testList as $testDep) {
				$depOptions .= '<option value = ' . $testDep['id'] . '>' . $testDep['test_name'] . '</option>';
			}
		}

		include APP . '/view/Test/testParams.php';
	}

	public function aqPicDel()
	{

		if (isset($_POST['aid']) && $_POST['aid']) {
			$param = [$_POST['aid']];
			$sql = 'UPDATE answer SET pica = NULL WHERE id = ?';
			$this->insertBySql($sql, $param);
		}
		if ($_POST['qid'] && isset($_POST['qid'])) {

			$param = [$_POST['qid']];
			$sql = 'UPDATE question SET picq = "" WHERE id = ?';
			$this->insertBySql($sql, $param);
		}
	}

	public function QPic()
	{

		$fid = $_POST['fid'];
		$pref = $_POST['pref'];
		$nameRu = basename($_FILES['file']['name']); // защита файловой системы - получает имя переданного файла

		$sql = 'SELECT nameHash FROM pic WHERE nameRu = ?';
		$params = [$nameRu];
		$pic = $this->findBySql($sql, $params);

		// не нашли такой картинки в таблице pic по русскому имени
		if (empty($pic)) {

			$nameHash = $fid . $pref . round(microtime(true)) . substr($nameRu, -4); // напр. 4526q1541554561.jpg
			$to = $_SERVER['DOCUMENT_ROOT'] . "/" . PROJ . "/pic/" . $nameHash;   //"/" . $nameHash;
			// Перемещаем из tmp папки (прописана в php.config)
			move_uploaded_file($_FILES['file']['tmp_name'], $to);

			if ($pref == "q") {// это картинка для вопроса, сохраним ее
				$sql = 'UPDATE question SET  picq = ? WHERE id = ?';
				$params = [$nameHash, $fid];
				$res = $this->insertBySql($sql, $params);

				$params = [$nameHash, $nameRu];
				$sql = "INSERT INTO pic (nameHash, nameRu) VALUES (?,?)";
				$this->insertBySql($sql, $params);
			} elseif ($pref == "a") {
				$sql = 'UPDATE answer SET  pica = ? WHERE id = ?';
				$params = [$nameHash, $fid];
				$res = $this->insertBySql($sql, $params);

				$params = [$nameHash, $nameRu];
				$sql = "INSERT INTO pic (nameHash, nameRu) VALUES (?,?)";
				$this->insertBySql($sql, $params);
			}
// нашли в таблице pic картинку с таким названием хеш берем из таблицы
		} else {
			$nameHash = $pic[0]['nameHash'];

			$to = $_SERVER['DOCUMENT_ROOT'] . "/" . PROJ . "/pic/" . $nameHash;   //"/" . $nameHash;
			// Перемещаем из tmp папки (прописана в php.config)
			move_uploaded_file($_FILES['file']['tmp_name'], $to);

			if ($pref == "q") {// это картинка для вопроса
				$sql = 'UPDATE question SET  picq = ? WHERE id = ?';
				$params = [$nameHash, $fid];
				$res = $this->insertBySql($sql, $params);
			} elseif ($pref == "a") {
				$sql = 'UPDATE answer SET  pica = ? WHERE id = ?';
				$params = [$nameHash, $fid];
				$res = $this->insertBySql($sql, $params);
			}
		}
	}

	public function aUpd()
	{
		$aId = $_POST['aid'];
		$aText = $_POST['atext'];
		$rightAnswer = $_POST['right_answer'];
		if (isset($_POST['apic'])) {
			$aPic = $_POST['apic'];
			// Отсекаем из пути папку Проекта,если добавили
			if (!strpos($aPic, PROJ)) {
				$aPic = substr($aPic, 6);
			}
			$aPicStr = ', pica = ?';
		} else {
			$aPicStr = '';
		}
		$sql = 'UPDATE answer SET  answer = ?, correct_answer = ?' . $aPicStr . ' WHERE id = ?';
		$params = [$aText, $rightAnswer];
		if (isset($_POST['apic'])) {
			array_push($params, $aPic);
		}
		array_push($params, $aId);

		$res = $this->insertBySql($sql, $params);
	}

	public function qUpd()
	{
		$qId = $_POST['qid'];
		$qText = $_POST['qtext'];

		if (isset($_POST['qpic'])) {
			$qPic = $_POST['qpic'];
			// Отсекаем из пути папку Проекта,если добавили
			if (!strpos($qPic, PROJ)) {
				$qPic = substr($qPic, 6);
			}
			$qPicStr = ', picq = ? ';
		} else {
			$qPicStr = '';
		}
		if (isset($_POST['sort'])) {
			$sort = $_POST['sort'];
			$sortStr = ', sort = ? ';
		} else {
			$sortStr = '';
		}
		$sql = 'UPDATE question SET  qustion = ? ' . $qPicStr . $sortStr . 'WHERE id = ?';
		$params = [$qText];

		if (isset($_POST['qpic'])) {
			array_push($params, $qPic);
		}
		if (isset($_POST['sort'])) {
			array_push($params, $sort);
		}
		array_push($params, $qId);
		$res = $this->insertBySql($sql, $params);
	}

//	public function aAdd()
//	{
//
//
//// Получаем id следующего ответа
//		$sql = "SHOW TABLE STATUS FROM vitex_test LIKE 'answer'";
//		$next = $this->findBySql($sql)[0];
//		$row['qid'] = $_POST['qid'];
//		$row['id'] = $next['Auto_increment'];
//		$row['answer'] = "";
//		$picA = "";
//		$correctAnswer = "";
//
//		$params = [$row['qid']];
//		$sql = "INSERT INTO answer (parent_question) VALUES (?)";
//		$this->insertBySql($sql, $params);
//
//		include APP . '/view/Test/editBlockAnswer.php';
//	}


	public function tAdd()
	{
		$testName = $_POST['test_name'];
		$parent = (int)$_POST['parent'];
		$isTest = (int)$_POST['isTest'];
		$row['sort'] = $sort = (int)$_POST['sort'];
		$enable = (int)$_POST['enable'];

		// Следующий id теста
		$sql = "SHOW TABLE STATUS FROM vitex_test LIKE 'test'";
		$nextTest = $this->findBySql($sql)[0];
		$tId = $nextTest['Auto_increment'];

		// Следующий id ответа
		$sql = "SHOW TABLE STATUS FROM vitex_test LIKE 'question'";
		$next = $this->findBySql($sql)[0];
		$row['qid'] = $qId = $next['Auto_increment'];

		// Следующий id вопроса
		$sql = "SHOW TABLE STATUS FROM vitex_test LIKE 'answer'";
		$next = $this->findBySql($sql)[0];
		$row['id'] = $aId = $next['Auto_increment'];

/////////////////////////////
		$params = [$tId, $testName, $parent, $isTest, $sort, $enable];
		$sql = 'INSERT INTO test (id,test_name,parent,isTest,sort,enable) VALUES (?,?,?,?,?,?)';
		$this->insertBySql($sql, $params);

		$params = [$tId];
		$sql = "INSERT INTO question (parent) VALUES (?)";
		$this->insertBySql($sql, $params);

		$params = [$qId];
		$sql = "INSERT INTO answer (parent_question) VALUES (?)";
		$this->insertBySql($sql, $params);


		$row['answer'] = '';
		$correctAnswer = '';
		$picA = '';
		$picQ = '';
		$row['qustion'] = "";


		ob_start();
		require APP . '/view/Test/editBlockQuestion.php';
		$question = ob_get_clean();
		ob_start();
		require APP . '/view/Test/editBlockAnswer.php';
		$answer = ob_get_clean();
		ob_end_clean();


		$pagination = "<div class='pagination'><a href='#question-$qId' class='nav-active'>1</a></div>";
		$pagination .= "<a href='#' class='add-question p-no-active'>+</a>";
		$menuItem = "<li>
            <div class = 'test-params icon-menu' data-testid = $tId></div>
            <a href = '/test/edit/$tId'>$testName</a>
        </li >";

		$data = compact("pagination", "tId", "testName", "question", "answer", "menuItem");
		// Превратим объект в строку JSON
		echo $json = json_encode($data);
	}

	public function tUpd()
	{
		if ($_POST['testId']) {// Это существующий тест
			$testName = $_POST['testName'];
			$params = [$testName,
				(int)$_POST['parentTest'],
				(int)$_POST['isTest'],
				(int)$_POST['sort'],
				(int)$_POST['enable'],
				(int)$_POST['testId']];
			$sql = 'UPDATE test SET test_name = ?, parent = ?, isTest = ?, sort = ?, enable = ? WHERE id = ?';
			$this->insertBySql($sql, $params);
			if ($testName) { // чтобы поменять название в спске и названии
				echo $testName;
			}
		} else {// Это новый тест
			if ($_POST['test_name']) {// Ообязательно заполняем имя теста
				$this->tAdd();
			} else {
				return FALSE;
			}
		}
	}

	public function delete_a()
	{
		$aId = $_POST['a_id'];
		$arr['table'] = 'answer';
		$arr['field'] = 'id';
		$arr['val'] = $aId;
		$arr['token'] = $aId;
		$this->delete($arr);
	}

	public
	function delete_q_a()
	{

		$this->del('answer', $_POST['aid']);
		$this->del('question', $_POST['qid']);
	}

	public
	function tDel()
	{
		if ($_POST['tId']) {
			$tId = (int)$_POST['tId'];

			$sql = 'SELECT id FROM question WHERE parent = ?';
			$param = [$tId];
			$quest = $this->findBySql($sql, $param);

			foreach ($quest as $qId) {
				$id = (int)$qId['qid'];
				$param = [$id];
				$sql = 'DELETE FROM answer WHERE parent_question = ?';
				$this->insertBySql($sql, $param);
			}

			$param = [$tId];
			$sql = 'DELETE FROM question WHERE parent = ?';
			$this->insertBySql($sql, $param);

			$sql = 'DELETE FROM test WHERE id = ?';
			$this->insertBySql($sql, $param);
		}
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

	public function getTestData($testId, bool $shuffle = false)
	{
//		$testId = $testId ?? '(SELECT id FROM test limit 1)';
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
		$result = $this->findBySql($sql, $params);

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

		return $data;
	}

//	public
//	function getTestDataToEdit($testId)
//	{
//		$sql = <<<here
//SELECT q.id AS qid, q.qustion, q.picq,q.parent, a.id, a.answer, a.correct_answer, a.pica, a.parent_question, test.enable, test.test_name, q.sort
//FROM question q
//LEFT JOIN answer a
//ON q.id = a.parent_question
//LEFT JOIN test
//ON test.id = q.parent
//WHERE q.parent = ?
//ORDER by q.sort, a.id
//here;
//		$params = [$testId];
//		$res = $this->findBySql($sql, $params);
//
//		return $res ?? false;
//	}


	public function pagination(array $items, $addBtn)
	{
		$pagination = '<div class="pagination">';
		$i = 0;
		foreach ($items as $id => $el) {
			$i++;
			$d = <<<heretext
<div data-pagination=$id>$i</div>
heretext;
			$pagination .= $d;
		}
		if ($addBtn) {
			$pagination .= "<div class='add-question'>+</div>";
		}

		return $pagination . '</div>';
	}

	public function getCorrectAnswers()
	{
		$correct_answers = $_SESSION['testData']['correct_answers'];
		exit(json_encode($correct_answers));
	}

	public function send_mail()
	{
		$this->send_result_mail('/results/test/', '/test/results/');
	}

}
