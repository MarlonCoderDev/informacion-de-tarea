<?php
// archivo: autenticar.php

require_once 'conexion.php';
require_once 'usuario.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conexion = (new Conexion())->conexion;

    $nombre = $_POST['nombre'];
    $clave = $_POST['clave'];

    $usuario = Usuario::autenticar($conexion, $nombre, $clave);

    if ($usuario) {
        $_SESSION['usuario_id'] = $usuario['id'];
        echo "success";
    } else {
        echo "error";
    }
}

?>