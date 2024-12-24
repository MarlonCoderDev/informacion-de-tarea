<?php
session_start();
require_once 'crud_usuario.php';

header('Content-Type: application/json');

$crud = new CrudUsuario();
$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'register') {
        // Registro de nuevo usuario
        if (empty($_POST['nombre']) || empty($_POST['email']) || empty($_POST['password'])) {
            $response = array('success' => false, 'message' => 'Todos los campos son requeridos');
        } else {
            $usuario = new Usuario($_POST['nombre'], $_POST['email'], $_POST['password']);
            
            if ($crud->crear($usuario)) {
                $response = array('success' => true, 'message' => 'Usuario registrado exitosamente');
            } else {
                $response = array('success' => false, 'message' => 'Error al registrar usuario');
            }
        }
    } else {
        // Login de usuario
        if (empty($_POST['email']) || empty($_POST['password'])) {
            $response = array('success' => false, 'message' => 'Email y contraseña son requeridos');
        } else {
            $usuario = $crud->validarLogin($_POST['email'], $_POST['password']);
            
            if ($usuario) {
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nombre'] = $usuario['nombre'];
                $_SESSION['usuario_email'] = $usuario['email'];
                
                $response = array('success' => true, 'message' => 'Login exitoso');
            } else {
                $response = array('success' => false, 'message' => 'Email o contraseña incorrectos');
            }
        }
    }
}

echo json_encode($response);