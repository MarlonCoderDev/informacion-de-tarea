<?php
class Conexion {
    private static $instancia = null;
    private $conn;
    
    private function __construct() {
        try {
            // Configura estos valores según tu base de datos
            $host = "localhost";
            $dbname = "sistema_usuarios";
            $username = "root";
            $password = "";
            
            $this->conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            die();
        }
    }
    
    public static function getInstancia() {
        if (self::$instancia === null) {
            self::$instancia = new self();
        }
        return self::$instancia;
    }
    
    public function getConexion() {
        return $this->conn;
    }
}