<?php

namespace app\model;

use app\core\Base\Model;
use app\core\App;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Test extends Model {

   public $table = 'test';

   public function testParams() {

      if (isset($_POST['testId']) && $_POST['testId']) {// Значит открыли существующий тест
         $tId = $_POST['testId'];
         // Получим запрашиваемый тест
         $sql = 'SELECT * FROM test  WHERE id = ?';
         $param = [$tId];
         $test = $this->findBySql($sql, $param)[0];
         // Заполняем список enable "ненулевых" тестов
         $testList = $this->findAll();
         // Удаляем из списка ссылку на самого себя(тест)
         unset($testList[$tId - 1]);
         // если это тест, делаем активным тест, иначе по умолчанию будет папка
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

   public function aqPicDel() {

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

   public function QPic() {

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

   public function aUpd() {

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

   public function qUpd() {

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

//   public function scriptOnce() {
//
//      $paths = '/pic';
//
//      echo $paths;
//      exit();
//
//      foreach (glob("$paths/*.{jpg,png,JPG}", GLOB_BRACE) as $docFile) {
//         echo $docFile;
//         $doc = str_replace($paths . '/', '', $docFile);
//         $picNameOld = "pic/" . $doc; //mb_convert_encoding($doc, 'utf8', 'windows-1251');
//         $picNameNew = substr(round(microtime(true), 3) * 1000, -8) . substr($picNameOld, -4);
//
//         //$sql = '(SELECT picq, '' FROM question where picq = ?)
//         //UNION ALL (SELECT '', pica FROM answer WHERE pica = ?)';
//         $sql = "(SELECT pica, 'picq' FROM `answer`where pica = ?) UNION (SELECT '', picq FROM `question` where picq = ?)";
//         $params = [$picNameOld, $picNameOld];
//         $res = $this->findBySql($sql, $params);
//         echo debug($res);
//
//         if ($res) {// если или в вопросах или в ответах  этa картинкa, запишем ее имя в таблицу pic
//            $sql = 'INSERT INTO pic1 (nameHash, nameRu) VALUES (?,?)';
//            $params = [$picNameNew, $picNameOld];
//            $this->insertBySql($sql, $params);
//
//            // обновим в таблице вопросов 
//            $sql = 'UPDATE question1 SET  picq = ? WHERE picq = ?';
//            $params = [$picNameNew, $picNameOld];
//            $this->insertBySql($sql, $params);
//
//            // обновим в таблице ответов 
//            $sql = 'UPDATE answer1 SET  pica = ? WHERE pica = ?';
//            $params = [$picNameNew, $picNameOld];
//            $this->insertBySql($sql, $params);
//
//            rename($docFile, "$paths/$picNameNew");
//         }
//      }
//   }

   public function aAdd() {


// Получаем id следующего ответа
      $sql = "SHOW TABLE STATUS FROM vitex_test LIKE 'answer'";
      $next = $this->findBySql($sql)[0];
      $row['qid'] = $_POST['qid'];
      $row['id'] = $next['Auto_increment'];
      $row['answer'] = "";
      $picA = "";
      $correctAnswer = "";

      $params = [$row['qid']];
      $sql = "INSERT INTO answer (parent_question) VALUES (?)";
      $this->insertBySql($sql, $params);

      include APP . '/view/Test/editBlockAnswer.php';
   }

   public function qAdd() {

      $tId = $_POST['testid'];
      $sort = $_POST['questQnt'];
      //exit($sort);
      $picQ = '';
      $textQuestion = '';
      $picA = '';
      $answerText = '';
      $corrAnswer = '';

// Следующий id вопроса
      $sql = "SHOW TABLE STATUS FROM vitex_test LIKE 'question'";
      $next = $this->findBySql($sql)[0];
      $qId = $next['Auto_increment'];

// Получаем id следующего ответа
      $sql = "SHOW TABLE STATUS FROM vitex_test LIKE 'answer'";
      $next = $this->findBySql($sql)[0];
      $aId = $next['Auto_increment'];

////////////////////////        
      $params = [$tId, $sort];
      $sql = "INSERT INTO question (parent,sort) VALUES (?,?)";
      $this->insertBySql($sql, $params);

      $params = [$qId];
      $sql = "INSERT INTO answer (parent_question) VALUES (?)";
      $this->insertBySql($sql, $params);
      
      $row['answer'] = '';
      $correctAnswer = '';
      $picA = '';
      $picQ = '';
      $row['qustion'] = "";
      $row['qid'] = $qId;
      $row['sort'] = $sort;
      $row['id'] = $aId;

      ob_start();
      require APP . '/view/Test/editBlockQuestion.php';
      $question = ob_get_clean();
      
      ob_start();
      require APP . '/view/Test/editBlockAnswer.php';
      $answer = ob_get_clean();
      ob_end_clean();

      $block = $question . $answer;
      $pagination = "<a href='#question-$qId' class='nav-active'>$sort</a>";

      $data = compact("pagination", "tId", "block");
      // Превратим объект в строку JSON
      echo $json = json_encode($data);
   }

   public function tAdd() {

      $testName = $_POST['test_name'];
      $parent = (int) $_POST['parent'];
      $isTest = (int) $_POST['isTest'];
      $row['sort'] = $sort = (int) $_POST['sort'];
      $enable = (int) $_POST['enable'];

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

   public function tUpd() {


      if ($_POST['testId']) {// Это существующий тест
         $testName = $_POST['testName'];
         $params = [$testName,
             (int) $_POST['parentTest'],
             (int) $_POST['isTest'],
             (int) $_POST['sort'],
             (int) $_POST['enable'],
             (int) $_POST['testId']];
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

   public function delete_a() {

      $aId = $_POST['aid'];
      $qId = $_POST['qid'];

      $sql = 'SELECT id FROM answer WHERE parent_question = ?';
      $param = [$qId];
      $res = $this->findBySql($sql, $param);
      // Получим количество ответов на данный вопрос
      $rowCnt = count($res);

      if ($rowCnt > 1) {
         echo $rowCnt;

         $sql = 'DELETE FROM answer WHERE id = ?';
         $param = [$aId];
         $res1 = $this->insertBySql($sql, $param);
      };
   }

   public function delete_q_a() {
      
      $this->del('answer', $_POST['aid']);
      $this->del('question', $_POST['qid']);

//      $sql = 'DELETE FROM answer WHERE id = ?';
//      $param = [$_POST['aid']];
//      $res1 = $this->insertBySql($sql, $param);

//      $sql = 'DELETE FROM question WHERE id = ?';
//      $param = [$_POST['qid']];
//      $res1 = $this->insertBySql($sql, $param);
   }

   public function tDel() {

      if ($_POST['tId']) {
         $tId = (int) $_POST['tId'];

         $sql = 'SELECT id FROM question WHERE parent = ?';
         $param = [$tId];
         $quest = $this->findBySql($sql, $param);

         foreach ($quest as $qId) {
            $id = (int) $qId['qid'];
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

   static function shuffle_assoc($array) {
      $keys = array_keys($array);
      shuffle($keys);
      foreach ($keys as $key) {
         $new[$key] = $array[$key];
      }
      return $new;
   }

   /**
    * Получаем массив вопросов+ответы + название теста<br/>
    * @param integer $testId <p>id теста</p>
    * @return array <p>Массив вопросов/ответов + название теста</p>
    */
   public function getTestData($testId = 1) {

      $sql = 'SELECT q.id, q.qustion, q.picq,q.parent, a.id, a.answer, a.pica, a.correct_answer,a.parent_question,test.enable,test.isTest, test.test_name ,q.sort
            FROM question q
            LEFT JOIN answer a
            ON q.id = a.parent_question
            LEFT JOIN test
            ON test.id = q.parent
            WHERE q.parent = ?
            ORDER BY q.sort+0
            '; // +0 для сортировки чисел, чтобы не было 2>10 // AND test.enable = :testEnable

      $params = [$testId];
      $result = $this->findBySql($sql, $params);

      if (!$result) {//Если не нашли тест по номеру вернем FALSE
         return FALSE;
      } elseif ($result[0]['isTest'] == 0) {// Это не тест, а папка для тестов
         return 0;
      }
      $data = null;

      $data['test_name'] = $result[0]['test_name'];
      $data['testId'] = $result[0]['parent'];

      $prevQuest = 0;

      foreach ($result as $row) {

         if ( $prevQuest != $row['parent_question'] && $prevQuest != 0) {

            $data[$prevQuest] = self::shuffle_assoc($data[$prevQuest]);
         }
         $data[$row['parent_question']][0]['question_text'] = htmlentities($row['qustion']);
         $data[$row['parent_question']][0]['question_pic'] = $row['picq'];
         $data[$row['parent_question']][$row['id']]['answer_text'] = htmlentities($row['answer']);
         $data[$row['parent_question']][$row['id']]['answer_pic'] = $row['pica'];

         if ($row['correct_answer'] == 1) {
            $data['correct_answers'][] = $row['id'];
         }
         $prevQuest = $row['parent_question'];
      }

      return $data;
   }

   public function getTestDataToEdit($testId) {

      $sql = 'SELECT q.id AS qid, q.qustion,q.picq,q.parent, a.id, a.answer,a.correct_answer,a.pica, a.parent_question,test.enable,test.test_name,q.sort 
        FROM question q
        LEFT JOIN answer a
        ON q.id = a.parent_question
        LEFT JOIN test
        ON test.id = q.parent
        WHERE q.parent = ?
        ORDER by q.sort, a.id
        ';

      $params = [$testId];
      $res = $this->findBySql($sql, $params);

      if (!$res) {//Если не нашли тест по номеру вернем FALSE
         return FALSE;
      }

      return $res;
   }

   /**
    * Возвращает навигацию <br/>
    * @return array <p>Массив вопросов</p>
    */
   public function pagination($test_data) {

      // Удалим название теста из массива. Оно нам не понадобится
      unset($test_data['test_name']);
      unset($test_data['testId']);
      unset($test_data['correct_answers']);
      // Получаем количество вопросов
      $count_questions = count($test_data);
      // Получаем массив id вопросов  
      $keys = array_keys($test_data);

      $pagination = '<div class="pagination">';
      for ($i = 1; $i <= $count_questions; $i++) {
         // Убираем ключи, оставляем только значения
         $key = array_shift($keys);
         if ($i == 1) {
            $pagination .= '<a href="#question-' . $key . '" class="nav-active"><div>' . $i . '</div></a>';
         } else {
            $pagination .= '<a href="#question-' . $key . '" class = "p-no-active" ><div>' . $i . '</div></a>';
         }
      }

      $pagination .= '</div>';

      return $pagination;
   }

   public function paginationEdit($test_data, $testId) {

      $params = [$testId];
      $sql = "SELECT `id`, `sort`, `parent` FROM `question` WHERE `parent` = ? ORDER BY `sort`";
      $questionIds = $this->findBySql($sql, $params);

      $pagination = '<div class="pagination">';
      $i = 1;
      foreach ($questionIds as $val => $qid) {
         if ($i == 1) {
            $pagination .= '<a href="#question-' . $qid['id'] . '" class="nav-active">' . $i . '</a>';
         } else {
            $pagination .= '<a href="#question-' . $qid['id'] . '" class = "p-no-active" >' . $i . '</a>';
         }
         $i++;
      }
      $pagination .= "<a href='#' class='add-question p-no-active'>+</a>";
      $pagination .= '</div>';
      return $pagination;
   }

   public function getCorrectAnswers() {

      $correct_answers = $_SESSION['correct_answers'];
      exit(json_encode($correct_answers));
   }

   public function send_mail() {

      $this->send_result_mail('/results/test/', '/test/results/');
      
   }

}
