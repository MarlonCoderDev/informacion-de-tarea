<?php
session_start();
require_once 'crud_usuario.php';

header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit();
}

$crud = new CrudUsuario();
$response = ['success' => false, 'message' => 'Acción no válida'];

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'create':
            if (!empty($_POST['nombre']) && !empty($_POST['email']) && !empty($_POST['password'])) {
                $usuario = new Usuario($_POST['nombre'], $_POST['email'], $_POST['password']);
                if ($crud->crear($usuario)) {
                    $response = ['success' => true, 'message' => 'Usuario creado exitosamente'];
                } else {
                    $response = ['success' => false, 'message' => 'Error al crear usuario'];
                }
            }
            break;

        case 'update':
            if (!empty($_POST['id']) && !empty($_POST['nombre']) && !empty($_POST['email'])) {
                $usuario = new Usuario($_POST['nombre'], $_POST['email']);
                $usuario->setId($_POST['id']);
                if ($crud->actualizar($usuario)) {
                    $response = ['success' => true, 'message' => 'Usuario actualizado exitosamente'];
                } else {
                    $response = ['success' => false, 'message' => 'Error al actualizar usuario'];
                }
            }
            break;

        case 'delete':
            if (!empty($_POST['id'])) {
                if ($crud->eliminar($_POST['id'])) {
                    $response = ['success' => true, 'message' => 'Usuario eliminado exitosamente'];
                } else {
                    $response = ['success' => false, 'message' => 'Error al eliminar usuario'];
                }
            }
            break;
    }
}

echo json_encode($response);
?>