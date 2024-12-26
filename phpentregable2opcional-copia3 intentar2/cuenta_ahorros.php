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
                <div id="operaciones" style="display: none;" class="mt-4">
                    <h5 class="mb-3">Operaciones</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="number" class="form-control" id="montoOperacion" placeholder="Monto" step="0.01" min="0">
                                <button class="btn btn-success" id="btnDepositar">
                                    <i class="fas fa-plus"></i> Depositar
                                </button>
                                <button class="btn btn-warning" id="btnRetirar">
                                    <i class="fas fa-minus"></i> Retirar
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-info w-100" id="btnConsultar">
                                <i class="fas fa-search"></i> Consultar Saldo
                            </button>
                        </div>
                    </div>
                    
                    <div id="resultado" class="alert mt-3" style="display: none;"></div>
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
                const saldoInicial = parseFloat($('#saldoInicial').val()) || 0;

                if (!numeroCuenta || !titular) {
                    alert('Por favor, complete todos los campos correctamente.');
                    return;
                }

                // Mostrar el panel de operaciones inmediatamente
                $('#operaciones').show();
                saldo = saldoInicial;
                
                // Deshabilitar el formulario de creación
                $('#numeroCuenta').prop('disabled', true);
                $('#titular').prop('disabled', true);
                $('#saldoInicial').prop('disabled', true);
                $(this).find('button[type="submit"]').prop('disabled', true);

                // Mostrar mensaje de éxito
                alert(`Cuenta creada exitosamente:\nNúmero: ${numeroCuenta}\nTitular: ${titular}\nSaldo inicial: $${saldoInicial}`);
            });

            $('#btnDepositar').on('click', function() {
                const monto = parseFloat($('#montoOperacion').val());

                if (isNaN(monto) || monto <= 0) {
                    alert('Ingrese un monto válido para depositar.');
                    return;
                }

                saldo += monto;
                $('#resultado')
                    .removeClass()
                    .addClass('alert alert-success')
                    .text(`Depósito realizado. Saldo actual: $${saldo.toFixed(2)}`)
                    .show()
                    .delay(3000)
                    .fadeOut();
                
                $('#montoOperacion').val('');
            });

            $('#btnRetirar').on('click', function() {
                const monto = parseFloat($('#montoOperacion').val());

                if (isNaN(monto) || monto <= 0) {
                    alert('Ingrese un monto válido para retirar.');
                    return;
                }

                if (monto > saldo) {
                    alert('Saldo insuficiente para realizar esta operación.');
                    return;
                }

                saldo -= monto;
                $('#resultado')
                    .removeClass()
                    .addClass('alert alert-info')
                    .text(`Retiro realizado. Saldo actual: $${saldo.toFixed(2)}`)
                    .show()
                    .delay(3000)
                    .fadeOut();
                
                $('#montoOperacion').val('');
            });

            $('#btnConsultar').on('click', function() {
                $('#resultado')
                    .removeClass()
                    .addClass('alert alert-primary')
                    .text(`Saldo actual: $${saldo.toFixed(2)}`)
                    .show()
                    .delay(3000)
                    .fadeOut();
            });
        });
    </script>
</body>
</html>
