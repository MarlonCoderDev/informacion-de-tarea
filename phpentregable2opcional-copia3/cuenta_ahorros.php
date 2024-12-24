<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión - Cuenta de Ahorros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Sistema de Gestión</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="cuenta.php">
                            <i class="fas fa-users"></i> Gestión de Usuarios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="cuenta_ahorros.php">
                            <i class="fas fa-piggy-bank"></i> Cuenta de Ahorros
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <span class="nav-link">Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">
                            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Sistema de Cuenta de Ahorros</h5>
            </div>
            <div class="card-body">
                <form id="cuentaForm" class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Número de Cuenta</label>
                            <input type="text" class="form-control" id="numeroCuenta" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Titular</label>
                            <input type="text" class="form-control" id="titular" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Saldo Inicial</label>
                            <input type="number" class="form-control" id="saldoInicial" value="0" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Crear Cuenta</button>
                </form>

                <div id="operaciones" style="display: none;">
                    <h5>Operaciones</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="number" class="form-control" id="montoOperacion" placeholder="Monto">
                                <button class="btn btn-success" id="btnDepositar">Depositar</button>
                                <button class="btn btn-warning" id="btnRetirar">Retirar</button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-info" id="btnConsultar">Consultar Saldo</button>
                        </div>
                    </div>

                    <div class="alert alert-info" id="resultado" style="display: none;"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            let saldo = 0;

            $('#cuentaForm').on('submit', function(e) {
                e.preventDefault();

                const numeroCuenta = $('#numeroCuenta').val();
                const titular = $('#titular').val();
                saldo = parseFloat($('#saldoInicial').val());

                if (!numeroCuenta || !titular || isNaN(saldo)) {
                    alert('Por favor, complete todos los campos correctamente.');
                    return;
                }

                $('#operaciones').show();
                alert(`Cuenta creada: \nNúmero: ${numeroCuenta}\nTitular: ${titular}\nSaldo inicial: ${saldo}`);
            });

            $('#btnDepositar').on('click', function() {
                const monto = parseFloat($('#montoOperacion').val());

                if (isNaN(monto) || monto <= 0) {
                    alert('Ingrese un monto válido para depositar.');
                    return;
                }

                saldo += monto;
                $('#resultado').show().text(`Depósito realizado. Saldo actual: ${saldo.toFixed(2)}`).delay(3000).fadeOut();
            });

            $('#btnRetirar').on('click', function() {
                const monto = parseFloat($('#montoOperacion').val());

                if (isNaN(monto) || monto <= 0) {
                    alert('Ingrese un monto válido para retirar.');
                    return;
                }

                if (monto > saldo) {
                    alert('No hay saldo suficiente para realizar esta operación.');
                    return;
                }

                saldo -= monto;
                $('#resultado').show().text(`Retiro realizado. Saldo actual: ${saldo.toFixed(2)}`).delay(3000).fadeOut();
            });

            $('#btnConsultar').on('click', function() {
                $('#resultado').show().text(`Saldo actual: ${saldo.toFixed(2)}`).delay(3000).fadeOut();
            });
        });
    </script>
</body>
</html>
