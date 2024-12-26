<?php
require_once 'conexion.php';
require_once 'usuario.php';

class CrudUsuario {
    private $conn;
    
    public function __construct() {
        $this->conn = Conexion::getInstancia()->getConexion();
    }
    
    public function crear(Usuario $usuario) {
        try {
            $sql = "INSERT INTO usuarios (nombre, email, clave) VALUES (:nombre, :email, :clave)";
            $stmt = $this->conn->prepare($sql);
            
            $nombre = $usuario->getNombre();
            $email = $usuario->getEmail();
            $clave = password_hash($usuario->getClave(), PASSWORD_DEFAULT);
            
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':clave', $clave);
            
            return $stmt->execute();
        } catch(PDOException $e) {
            echo "Error al crear usuario: " . $e->getMessage();
            return false;
        }
    }
    
    public function leer($id = null) {
        try {
            if ($id) {
                $sql = "SELECT * FROM usuarios WHERE id = :id";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                return $stmt->fetch();
            } else {
                $sql = "SELECT * FROM usuarios";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll();
            }
        } catch(PDOException $e) {
            echo "Error al leer usuario(s): " . $e->getMessage();
            return false;
        }
    }
    
    public function actualizar(Usuario $usuario) {
        try {
            $sql = "UPDATE usuarios SET nombre = :nombre, email = :email WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            
            $id = $usuario->getId();
            $nombre = $usuario->getNombre();
            $email = $usuario->getEmail();
            
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':email', $email);
            
            return $stmt->execute();
        } catch(PDOException $e) {
            echo "Error al actualizar usuario: " . $e->getMessage();
            return false;
        }
    }
    
    public function eliminar($id) {
        try {
            $sql = "DELETE FROM usuarios WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch(PDOException $e) {
            echo "Error al eliminar usuario: " . $e->getMessage();
            return false;
        }
    }
    
    public function validarLogin($email, $clave) {
        try {
            $sql = "SELECT * FROM usuarios WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            $usuario = $stmt->fetch();
            if ($usuario && password_verify($clave, $usuario['clave'])) {
                return $usuario;
            }
            return false;
        } catch(PDOException $e) {
            echo "Error al validar login: " . $e->getMessage();
            return false;
        }
    }
}