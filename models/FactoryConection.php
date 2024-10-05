<?php

class FactoryConection {
    private static $instance = null;
    private $connection;

    private function __construct() {
        $this->connection = new PDO('mysql:host=localhost;dbname=sistema_postagem', 'root', '270275');
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new FactoryConection();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }
}

