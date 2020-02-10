<?php

namespace app\model;

use app\core\Base\Model;


class Freetest extends Model {

   public $table = 'freetest';

   public function qDel() {
      $param = [(int) $_POST['qId']];
      $sql = 'DELETE FROM freetest_quest WHERE id = ?';
      $res1 = $this->insertBySql($sql, $param);
      exit($_POST['qId']);
   }

   public function qAdd() {

      $row[] = $tId = $_POST['testid'];
      $row['sort'] = $sort = $_POST['questQnt'];
      $row['question'] = '';
      $row['key_words'] = [];
      $picQ = '';
      $textQuestion = '';

      $sql = "SHOW TABLE STATUS FROM vitex_test LIKE 'freetest_quest'";
      $next = $this->findBySql($sql)[0];
      $row['qid'] = $qId = $next['Auto_increment'];


      $params = [$tId, $sort];
      $sql = "INSERT INTO freetest_quest (parent,sort) VALUES (?,?)";
      $this->insertBySql($sql, $params);


      ob_start();
      require APP . '/view/Freetest/editBlockQuestion.php';
      $question = ob_get_clean();

      $block = $question;
      $pagination = "<a href='#question-$qId' class='nav-active'>$sort</a>";

      $data = compact("pagination", "tId", "block");
      echo $json = json_encode($data);
   }

   public function aqPicDel() {

      if ($_POST['qid'] && isset($_POST['qid'])) {

         $param = [$_POST['qid']];
         $sql = 'UPDATE freetest_quest SET picq = "" WHERE id = ?';
         $this->insertBySql($sql, $param);
      }
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
      $sql = 'UPDATE freetest_quest SET  question = ? ' . $qPicStr . $sortStr . 'WHERE id = ?';
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

   public function tAdd() {

      $testName = $_POST['test_name'];
      $parentTest = (int) $_POST['parentTest'];
      $isTest = (int) $_POST['isTest'];
      $row['sort'] = $sort = (int) $_POST['sort'];
      $enable = (int) $_POST['enable'];

      // Следующий id теста 
      $sql = "SHOW TABLE STATUS FROM vitex_test LIKE 'freetest'";
      $nextTest = $this->findBySql($sql)[0];
      $tId = $nextTest['Auto_increment'];

      // Следующий id  вопроса
      $sql = "SHOW TABLE STATUS FROM vitex_test LIKE 'freetest_quest'";
      $next = $this->findBySql($sql)[0];
      $row['qid'] = $qId = $next['Auto_increment'];

/////////////////////////////
      $params = [$tId, $testName, $parentTest, $isTest, $sort, $enable];
      $sql = 'INSERT INTO freetest (id,name,parentTest,isTest,sort,enable) VALUES (?,?,?,?,?,?)';
      $this->insertBySql($sql, $params);

      $params = [$tId];
      $sql = "INSERT INTO freetest_quest (parent) VALUES (?)";
      $this->insertBySql($sql, $params);

      $picQ = '';
      $row['question'] = "";
      $row['key_words'] = [];

      ob_start();
      require APP . '/view/Freetest/editBlockQuestion.php';
      $question = ob_get_clean();
      ob_end_clean();


      $pagination = "<div class='pagination'><a href='#question-$qId' class='nav-active'>1</a></div>";
      $pagination .= "<a href='#' class='add-question'>+</a>";
      $menuItem = "<li>
            <div class = 'test-params icon-menu' data-testid = $tId></div>
            <a href = '/freetest/edit/$tId'>$testName</a>
        </li >";

      $data = compact("pagination", "tId", "testName", "question", "menuItem");
      echo $json = json_encode($data);
   }

   public function tDel() {

      if ($_POST['tId']) {
         $tId = (int) $_POST['tId'];

         $sql = 'SELECT id FROM freetest_quest WHERE parent = ?';
         $param = [$tId];
         $quest = $this->findBySql($sql, $param);

         $param = [$tId];
         $sql = 'DELETE FROM freetest_quest WHERE parent = ?';
         $this->insertBySql($sql, $param);

         $sql = 'DELETE FROM freetest WHERE id = ?';
         $this->insertBySql($sql, $param);
      }
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
         $sql = 'UPDATE test SET test_name = ?, parentTest = ?, isTest = ?, sort = ?, enable = ? WHERE id = ?';
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

   public function freetestParams() {

      if (isset($_POST['testId']) && $_POST['testId']) {// Значит открыли существующий тест
         $tId = $_POST['testId'];
         // Получим запрашиваемый тест
         $sql = 'SELECT * FROM freetest  WHERE id = ?';
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
            if ($testDep['id'] == $test['parentTest']) {
               $depOptions .= '<option value = ' . $testDep['id'] . ' selected >' . $testDep['test_name'] . '</option>';
            } else {
               $depOptions .= '<option value = ' . $testDep['id'] . '>' . $testDep['name'] . '</option>';
            }
         }
      } else {// Добавляем новый тест
         $test['id'] = 0;
         $test['name'] = '';
         $test['sort'] = 0;
         $selected = '';
         $checked = 0;
         $testList = $this->findAll();
         $depOptions = '<option value = "0">Не принадлежит</option>';
         foreach ($testList as $testDep) {
            $depOptions .= '<option value = ' . $testDep['id'] . '>' . $testDep['name'] . '</option>';
         }
      }

      include APP . '/view/Freetest/freetestParams.php';
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
      $sql = "SELECT `id`, `sort`, `parent` FROM `freetest_quest` WHERE `parent` = ? ORDER BY `sort`";
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
      $pagination .= "<a href='#' class='add-question'>+</a>";
      $pagination .= '</div>';
      return $pagination;
   }

   public function send_mail_Freetest() {
      
      $this->send_result_mail('/results/freetest/', '/freetest/results/');

   }

   public function resultFreetest() {

      $correct_answers = $_SESSION['key_words'];
      exit(json_encode($correct_answers));
   }

   public function getFreetestData($testId) {

      $sql = '
        SELECT q.id, q.picq, q.question, q.key_words, q.sort, q.parent, freetest.name  
        FROM freetest_quest q
        LEFT JOIN freetest
        ON freetest.id = q.parent
        WHERE q.parent = ?
        ORDER by q.sort
        ';

      $params = [$testId];
      $res = $this->findBySql($sql, $params);

      if (!$res) {//Если не нашли тест по номеру вернем FALSE
         return FALSE;
      }
      $key_words = [];
      $i = 0;
      foreach ($res as $qid => $question) {
         $key_words[$question['id']] = $question['key_words'];
      }
      $res['key_words'] = $key_words;

      return $res;
   }

   public function getFreeTestDataToEdit($testId) {

      $sql = '
      SELECT q.id AS qid, q.question, q.picq, q.parent, q.key_words, q.sort, freetest.enable, freetest.name
        FROM freetest_quest q
        LEFT JOIN freetest
        ON freetest.id = q.parent
        WHERE q.parent = ?
        ORDER by q.sort
        ';

      $params = [$testId];
      $res = $this->findBySql($sql, $params);

      if (!$res) {//Если не нашли тест по номеру вернем FALSE
         return FALSE;
      }
      foreach ($res as $key => $value) {
         $res[$key]['key_words'] = explode(',', $res[$key]['key_words']);
      }

      return $res;
   }

   public function addKey() {

      $str = $_POST['str'];
      $qid = (int) $_POST['qid'];

      $Test = new Test;

      $sql = "UPDATE freetest_quest SET key_words = ? where id = ?";
      $params = [$str, $qid];
      $Test->insertBySql($sql, $params);
   }

   public function QPic() {

      $fid = $_POST['fid'];
      $nameRu = basename($_FILES['file']['name']); // защита файловой системы - получает имя переданного файла

      $sql = 'SELECT nameHash FROM pic WHERE nameRu = ?';
      $params = [$nameRu];
      $pic = $this->findBySql($sql, $params);

      // не нашли такой картинки в таблице pic по русскому имени
      if (empty($pic)) {

         $nameHash = $fid . $pref . round(microtime(true)) . substr($nameRu, -4); // напр. 4526q1541554561.jpg
         $to = $_SERVER['DOCUMENT_ROOT'] . "/" . PROJ . "pic/" . $nameHash;   //"/" . $nameHash; 
         // Перемещаем из tmp папки (прописана в php.config)
         move_uploaded_file($_FILES['file']['tmp_name'], $to);

         $sql = 'UPDATE freetest_quest SET  picq = ? WHERE id = ?';
         $params = [$nameHash, $fid];
         $res = $this->insertBySql($sql, $params);

         $params = [$nameHash, $nameRu];
         $sql = "INSERT INTO pic (nameHash, nameRu) VALUES (?,?)";
         $this->insertBySql($sql, $params);
// нашли в таблице pic картинку с таким названием хеш берем из таблицы
      } else {
         $nameHash = $pic[0]['nameHash'];

         $to = $_SERVER['DOCUMENT_ROOT'] . "/" . PROJ . "pic/" . $nameHash;   //"/" . $nameHash; 
         // Перемещаем из tmp папки (прописана в php.config)
         move_uploaded_file($_FILES['file']['tmp_name'], $to);

         $sql = 'UPDATE freetest_quest SET  picq = ? WHERE id = ?';
         $params = [$nameHash, $fid];
         $res = $this->insertBySql($sql, $params);
      }
   }

}
