<?php
session_start();
require_once 'main.php';

header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit();
}

$response = ['success' => false, 'message' => 'Acción no válida'];

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'crear':
            if (!empty($_POST['numeroCuenta']) && !empty($_POST['titular'])) {
                $saldoInicial = !empty($_POST['saldoInicial']) ? floatval($_POST['saldoInicial']) : 0;
                $_SESSION['cuenta'] = new CuentaAhorros($_POST['numeroCuenta'], $_POST['titular'], $saldoInicial);
                $response = ['success' => true, 'message' => 'Cuenta creada exitosamente'];
            }
            break;

        case 'depositar':
            if (isset($_SESSION['cuenta']) && !empty($_POST['monto'])) {
                if ($_SESSION['cuenta']->depositar(floatval($_POST['monto']))) {
                    $response = ['success' => true, 'message' => 'Depósito realizado exitosamente'];
                } else {
                    $response = ['success' => false, 'message' => 'Error al realizar el depósito'];
                }
            }
            break;

        case 'retirar':
            if (isset($_SESSION['cuenta']) && !empty($_POST['monto'])) {
                if ($_SESSION['cuenta']->retirar(floatval($_POST['monto']))) {
                    $response = ['success' => true, 'message' => 'Retiro realizado exitosamente'];
                } else {
                    $response = ['success' => false, 'message' => 'Error al realizar el retiro'];
                }
            }
            break;

        case 'consultar':
            if (isset($_SESSION['cuenta'])) {
                $saldo = $_SESSION['cuenta']->consultarSaldo();
                $response = ['success' => true, 'message' => 'Saldo actual: $' . number_format($saldo, 2)];
            }
            break;
    }
}

echo json_encode($response);
?>