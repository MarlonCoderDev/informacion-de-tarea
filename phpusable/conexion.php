<?php
// archivo: conexion.php

class Conexion {
    private $host = "localhost";
    private $dbname = "base1";
    private $username = "root";
    private $password = "";
    public $conexion;

    public function __construct() {
        try {
            $this->conexion = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}

?>