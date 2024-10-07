<?php

class FactoryConection {
    private static $instance = null;
    private $connection;

    private function __construct() {
        $options = [
            PDO::MYSQL_ATTR_SSL_CA => __DIR__ . '/../config/isrgrootx1.pem', // Caminho absoluto
        ];

        try {
            $this->connection = new PDO(
                'mysql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT') . ';dbname=' . getenv('DB_NAME'),
                getenv('DB_USER'),
                getenv('DB_PASSWORD'),
                $options
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Erro ao conectar ao banco de dados: ' . $e->getMessage();
            exit();
        }
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
