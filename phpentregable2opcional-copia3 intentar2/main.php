<?php
require_once 'conexion.php';

class CuentaAhorros {
    private $id;
    private $numeroCuenta;
    private $titular;
    private $saldo;
    private $conn;

    public function __construct($numeroCuenta, $titular, $saldoInicial = 0) {
        $this->numeroCuenta = $numeroCuenta;
        $this->titular = $titular;
        $this->saldo = $saldoInicial;
        $this->conn = Conexion::getInstancia()->getConexion();
        $this->crearCuentaEnBD();
    }

    private function crearCuentaEnBD() {
        try {
            // Crear tabla si no existe
            $sql = "CREATE TABLE IF NOT EXISTS cuentas_ahorro (
                id INT AUTO_INCREMENT PRIMARY KEY,
                numero_cuenta VARCHAR(20) UNIQUE,
                titular VARCHAR(100),
                saldo DECIMAL(10,2),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
            $this->conn->exec($sql);

            // Insertar la cuenta
            $sql = "INSERT INTO cuentas_ahorro (numero_cuenta, titular, saldo) 
                   VALUES (:numero_cuenta, :titular, :saldo)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':numero_cuenta', $this->numeroCuenta);
            $stmt->bindParam(':titular', $this->titular);
            $stmt->bindParam(':saldo', $this->saldo);
            $stmt->execute();
            
            $this->id = $this->conn->lastInsertId();
        } catch(PDOException $e) {
            echo "Error al crear cuenta: " . $e->getMessage();
        }
    }

    public function depositar($monto) {
        if ($monto <= 0) {
            echo "El monto debe ser mayor a 0\n";
            return false;
        }

        try {
            $this->conn->beginTransaction();
            
            $sql = "UPDATE cuentas_ahorro SET saldo = saldo + :monto 
                   WHERE numero_cuenta = :numero_cuenta";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':monto', $monto);
            $stmt->bindParam(':numero_cuenta', $this->numeroCuenta);
            $stmt->execute();
            
            $this->saldo += $monto;
            $this->conn->commit();
            
            echo "Depósito exitoso. Nuevo saldo: $" . number_format($this->saldo, 2) . "\n";
            return true;
        } catch(PDOException $e) {
            $this->conn->rollBack();
            echo "Error en el depósito: " . $e->getMessage() . "\n";
            return false;
        }
    }

    public function retirar($monto) {
        if ($monto <= 0) {
            echo "El monto debe ser mayor a 0\n";
            return false;
        }

        if ($monto > $this->saldo) {
            echo "Saldo insuficiente\n";
            return false;
        }

        try {
            $this->conn->beginTransaction();
            
            $sql = "UPDATE cuentas_ahorro SET saldo = saldo - :monto 
                   WHERE numero_cuenta = :numero_cuenta";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':monto', $monto);
            $stmt->bindParam(':numero_cuenta', $this->numeroCuenta);
            $stmt->execute();
            
            $this->saldo -= $monto;
            $this->conn->commit();
            
            echo "Retiro exitoso. Nuevo saldo: $" . number_format($this->saldo, 2) . "\n";
            return true;
        } catch(PDOException $e) {
            $this->conn->rollBack();
            echo "Error en el retiro: " . $e->getMessage() . "\n";
            return false;
        }
    }

    public function consultarSaldo() {
        try {
            $sql = "SELECT saldo FROM cuentas_ahorro WHERE numero_cuenta = :numero_cuenta";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':numero_cuenta', $this->numeroCuenta);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->saldo = $result['saldo'];
            
            echo "Saldo actual: $" . number_format($this->saldo, 2) . "\n";
            return $this->saldo;
        } catch(PDOException $e) {
            echo "Error al consultar saldo: " . $e->getMessage() . "\n";
            return false;
        }
    }
}

// Método Main para probar la funcionalidad
function main() {
    try {
        echo "=== SISTEMA DE CUENTA DE AHORROS ===\n\n";
        
        // Crear una nueva cuenta
        $cuenta = new CuentaAhorros("1001", "Juan Pérez", 1000);
        echo "Cuenta creada exitosamente\n";
        
        // Consultar saldo inicial
        echo "\nConsultando saldo inicial:\n";
        $cuenta->consultarSaldo();
        
        // Realizar un depósito
        echo "\nRealizando depósito de $500:\n";
        $cuenta->depositar(500);
        
        // Realizar un retiro
        echo "\nRealizando retiro de $300:\n";
        $cuenta->retirar(300);
        
        // Intentar retirar más del saldo disponible
        echo "\nIntentando retirar $2000:\n";
        $cuenta->retirar(2000);
        
        // Consultar saldo final
        echo "\nConsultando saldo final:\n";
        $cuenta->consultarSaldo();
        
    } catch(Exception $e) {
        echo "Error en la ejecución: " . $e->getMessage() . "\n";
    }
}

// Ejecutar el método main
main();
?>