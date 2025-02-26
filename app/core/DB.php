<?php

namespace app\core;

use Exception;
use PDO;
use PDOException;

class DB {

    public PDO $pdo;
    protected static DB $instance;
    protected static array $queries = [];

    public function __construct() {

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb3_general_ci",
        ];
        try {
            $this->pdo = new PDO(env('DB_DSN'), env('DB_USER'), env('DB_PASSWORD'), $options);
        } catch (PDOException $e) {
            die('Подключение не удалось: ' . $e->getMessage());
        }
    }

    public static function instance(): DB
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function execute($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        try {
           return $stmt->execute($params);
        } catch (Exception $ex) {
           exit($ex);
        }
    }

    public function query($sql, $params = []): false|array
    {
        $stmt = $this->pdo->prepare($sql);
        $res = $stmt->execute($params);
        if ($res !== false) {
            return $stmt->fetchAll();
        }
        return [];
    }

}
