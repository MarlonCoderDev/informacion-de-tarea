<?php
// archivo: usuario.php

class Usuario {
    private $id;
    private $nombre;
    private $clave;
    private $email;

    public function __construct($nombre, $clave, $email) {
        $this->nombre = $nombre;
        $this->clave = password_hash($clave, PASSWORD_DEFAULT);
        $this->email = $email;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getClave() {
        return $this->clave;
    }

    public function getEmail() {
        return $this->email;
    }

    public function registrar($conexion) {
        $sql = "INSERT INTO usuarios (nombre, clave, email) VALUES (:nombre, :clave, :email)";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':clave', $this->clave);
        $stmt->bindParam(':email', $this->email);
        return $stmt->execute();
    }

    public static function autenticar($conexion, $nombre, $clave) {
        $sql = "SELECT * FROM usuarios WHERE nombre = :nombre";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($clave, $usuario['clave'])) {
            return $usuario;
        }
        return false;
    }
}

?>