<!-- archivo: registrarse.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="form-container">
        <h2>Registro</h2>
        <form action="registrar.php" method="POST">
            <input type="text" name="nombre" placeholder="Usuario" required>
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <input type="password" name="clave" placeholder="Contraseña" required>
            <button type="submit">Registrarse</button>
        </form>
        <p><a href="index.php">¿tienes una cuenta? iniciar sesion</a></p>
    </div>
</body>
</html>