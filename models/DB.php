<?php

class DB extends PDO {
    public function __construct() {
        $dsn = 'mysql:host=localhost;dbname=app-mvc;charset=utf8';
        $username = 'root';
        $password = '1995';

        try {
            parent::__construct($dsn, $username, $password);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Error en la conexión: ' . $e->getMessage();
        }
    }
}