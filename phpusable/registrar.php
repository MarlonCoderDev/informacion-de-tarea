<?php
// archivo: registrar.php

require_once 'conexion.php';
require_once 'usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conexion = (new Conexion())->conexion;

    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $clave = $_POST['clave'];

    $usuario = new Usuario($nombre, $clave, $email);

    if ($usuario->registrar($conexion)) {
        header("Location: index.php");
    } else {
        echo "Error al registrar el usuario.";
    }
}

?>
