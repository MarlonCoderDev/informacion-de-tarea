<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="logo-container">
            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#4f46e5" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <path d="M12 6v6l4 2"/>
            </svg>
        </div>
        <h2>Iniciar Sesión</h2>
        <form action="controller_login.php" method="POST">
            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" required 
                       placeholder="tu@email.com">
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required
                       placeholder="••••••••">
            </div>
            <button type="submit" class="btn">Ingresar</button>
        </form>
        <div class="auth-links">
            <a href="registrarse.php" class="link">¿No tienes cuenta? Regístrate aquí</a>
        </div>
    </div>
</body>
</html>