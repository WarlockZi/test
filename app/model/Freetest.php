<?php

namespace app\model;

use app\model\Model;


class Freetest extends Model {

   public $table = 'freetest';


   public function qAdd() {
      $row[] = $tId = $_POST['testid'];
      $row['sort'] = $sort = $_POST['questQnt'];
      $row['question'] = '';
      $row['key_words'] = [];
      $sql = "SHOW TABLE STATUS FROM vitex_test LIKE 'freetest_quest'";
      $next = $this->findBySql($sql)[0];
      $row['qid'] = $qId = $next['Auto_increment'];

      $params = [$tId, $sort];
      $sql = "INSERT INTO freetest_quest (parent,sort) VALUES (?,?)";

      ob_start();
      require APP . '/view/Freetest/editBlockQuestion.php';
      $question = ob_get_clean();

      $block = $question;
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

      $testName = $_POST['name'];
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
             (int) $_POST['parentTest']];

         $sql = 'UPDATE test SET name = ?, parentTest = ?, isTest = ?, sort = ?, enable = ? WHERE id = ?';
         $this->insertBySql($sql, $params);
         if ($testName) { // чтобы поменять название в спске и названии
            echo $testName;
         }
      } else {// Это новый тест
         if ($_POST['name']) {// Ообязательно заполняем имя теста
            $this->tAdd();
         } else {
            return FALSE;
         }
      }
   }

   public function freetestParams() {

      if (isset($_POST['testId']) && $_POST['testId']) {// Значит открыли существующий тест
         $tId = $_POST['testId'];
         $sql = 'SELECT * FROM freetest  WHERE id = ?';
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
            if ($testDep['id'] == $test['parentTest']) {
               $depOptions .= '<option value = ' . $testDep['id'] . ' selected >' . $testDep['name'] . '</option>';
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


//   public function send_mail_Freetest() {
//      $this->send_result_mail('/results/freetest/', '/freetest/results/');
//   }

   public function resultFreetest() {

      $correct_answers = $_SESSION['key_words'];
      exit(json_encode($correct_answers));
   }


   public function QPic() {

      $fid = $_POST['fid'];
      $nameRu = basename($_FILES['file']['name']); // защита файловой системы - получает имя переданного файла

      $sql = 'SELECT nameHash FROM pic WHERE nameRu = ?';
      $params = [$nameRu];
      $pic = $this->findBySql($sql, $params);

      // не нашли такой картинки в таблице pic по русскому имени
      if (empty($pic)) {

         $nameHash = $fid .  round(microtime(true)) . substr($nameRu, -4); // напр. 4526q1541554561.jpg
         $to = $_SERVER['DOCUMENT_ROOT'] . "/" . "pic/" . $nameHash;   //"/" . $nameHash;
         // Перемещаем из tmp папки (прописана в php.config)
         move_uploaded_file($_FILES['file']['tmp_name'], $to);

         $sql = 'UPDATE freetest_quest SET  picq = ? WHERE id = ?';
         $params = [$nameHash, $fid];

         $params = [$nameHash, $nameRu];
         $sql = "INSERT INTO pic (nameHash, nameRu) VALUES (?,?)";
         $this->insertBySql($sql, $params);
// нашли в таблице pic картинку с таким названием хеш берем из таблицы
      } else {
         $nameHash = $pic[0]['nameHash'];

         $to = $_SERVER['DOCUMENT_ROOT'] . "/" .  "pic/" . $nameHash;   //"/" . $nameHash;
         // Перемещаем из tmp папки (прописана в php.config)
         move_uploaded_file($_FILES['file']['tmp_name'], $to);

         $sql = 'UPDATE freetest_quest SET  picq = ? WHERE id = ?';
         $params = [$nameHash, $fid];
         $res = $this->insertBySql($sql, $params);
      }
   }

}
