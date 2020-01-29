<?php

namespace app\core;

class DB {

    public $pdo;
    protected static $instance;
//    protected static $countSql;
//    protected static $queries = [];

    public function __construct() {

        $db = require CONFIG;
        $db = $db['config_db'];
		//exit(var_dump($db));
        $options = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        ];
        // Проверка корректности подключения
        try {
            $this->pdo = new \PDO($db['dsn'], $db['user'], $db['password'], $options);
        } catch (PDOException $e) {
            die('Подключение не удалось: ' . $e->getMessage());
        }
    }

    public static function instance() {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    // Метод используется, когда требуется только определить true или false
    public function execute($sql, $params = []) {
//        self::$countSql++;
//        self::$queries[] = $sql;
        $stmt = $this->pdo->prepare($sql);
        try {
           return $stmt->execute($params);
        } catch (Exception $ex) {
           exit($ex);
        }
    }


    public function query($sql, $params = []) {
//        self::$countSql++;
//        self::$queries[] = $sql;
        $stmt = $this->pdo->prepare($sql);
        $res = $stmt->execute($params);
        if ($res !== FALSE) {
            return $stmt->fetchAll();
        }
        return [];
    }

    /**
     * Устанавливает соединение с базой данных
     * @return \PDO <p>Объект класса PDO для работы с БД</p>
     */
    public static function getConnection() {
        // Получаем параметры подключения из файла
        $params = include(ROOT . '/config/config_db.php');
        $options = array(
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"
        );

        // Устанавливаем соединение
        try {
            $db = new \PDO($params['dsn'], $params['user'], $params['password'], $options);
        } catch (Exception $e) {
            echo 'Выброшено исключение: ', $e->getMessage(), "\n";
        }

        return $db;
    }

}
