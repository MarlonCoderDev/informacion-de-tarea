<!-- archivo: index.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión</title>
    <link rel="stylesheet" href="estilos.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="form-container">
        <h2>Inicio de Sesión</h2>
        <form id="loginForm">
            <input type="text" name="nombre" placeholder="Usuario" required>
            <input type="password" name="clave" placeholder="Contraseña" required>
            <button type="submit">Ingresar</button>
        </form>
        <p><a href="registrarse.php">¿No tienes una cuenta? Regístrate</a></p>
    </div>

    <script>
        $("#loginForm").submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: "autenticar.php",
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    if (response === "success") {
                        window.location.href = "cuenta.php";
                    } else {
                        alert("Usuario o contraseña incorrectos.");
                    }
                }
            });
        });
    </script>
</body>
</html>