<?php

class Database {
    private $host;
    private $dbname;
    private $username;
    private $password;
    private static $instance = null;

    private function __construct() {
        $this->host     = getenv('DB_HOST') ?: 'localhost';
        $this->dbname   = getenv('DB_NAME') ?: 'hotel_admin';
        $this->username = getenv('DB_USER') ?: 'root';
        $this->password = getenv('DB_PASS') ?: '';
    }

    public static function connect(): PDO {
        if (self::$instance === null) {
            $db = new self();
            $dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', $db->host, $db->dbname, 'utf8mb4');

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
                // PDO::ATTR_PERSISTENT      => true, // opcional
            ];

            try {
                self::$instance = new PDO($dsn, $db->username, $db->password, $options);
            } catch (PDOException $e) {
                // No terminar el script; propagar/registrar para manejo superior
                throw new RuntimeException('Error en la conexión a la base de datos', 0, $e);
            }
        }

        return self::$instance;
    }

    // Evitar clonación y deserialización del singleton
    private function __clone() {}
    public function __wakeup() { throw new \Exception('No puede deserializarse.'); }
}
// ...existing code...