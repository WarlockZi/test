<?php

namespace app\core;

class DB {

    public $pdo;
    protected static $instance;
    protected static $countSql;
    protected static $queries = [];

    public function __construct() {

        $db = require ROOT . '/app/core/config.php';
        $db = $db['config_db'];
        $options = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        ];
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
        if ($res !== false) {
            return $stmt->fetchAll();
        }
        return [];
    }

    public static function getConnection() {
        $params = include(ROOT . '/config/config_db.php');
        $options = array(
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"
        );

        try {
            $db = new \PDO($params['dsn'], $params['user'], $params['password'], $options);
        } catch (Exception $e) {
            echo 'Выброшено исключение: ', $e->getMessage(), "\n";
        }

        return $db;
    }

}
