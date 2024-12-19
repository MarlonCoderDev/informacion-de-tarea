<?php
// archivo: cuenta.php

session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

echo "Bienvenido a tu cuenta.";
?>