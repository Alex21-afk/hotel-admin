<?php

class Database {
    private $host = "localhost";
    private $dbname = "hotel_admin";
    private $username = "root";
    private $password = "";
    private static $instance = null;

    private function __construct() {}

    public static function connect() {
        if (self::$instance === null) {
            try {
                self::$instance = new PDO(
                    "mysql:host=localhost;dbname=hotel_admin;charset=utf8",
                    "root",
                    ""
                );
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Error en la conexión: " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
