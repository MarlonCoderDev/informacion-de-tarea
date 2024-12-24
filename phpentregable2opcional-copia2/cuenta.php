<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}

require_once 'crud_usuario.php';
$crud = new CrudUsuario();
$usuarios = $crud->leer();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión - Panel Principal</title>
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
                        <a class="nav-link active" href="#" id="showCrud">
                            <i class="fas fa-users"></i> Gestión de Usuarios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="showMain">
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
        <!-- Sección CRUD (Gestión de Usuarios) -->
        <div id="crudSection">
            <div class="mb-4">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="fas fa-user-plus"></i> Agregar Usuario
                </button>
            </div>

            <!-- Tabla de usuarios -->
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Gestión de Usuarios</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($usuarios as $usuario): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                                    <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary edit-user" 
                                                data-id="<?php echo $usuario['id']; ?>"
                                                data-nombre="<?php echo htmlspecialchars($usuario['nombre']); ?>"
                                                data-email="<?php echo htmlspecialchars($usuario['email']); ?>"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editUserModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger delete-user" 
                                                data-id="<?php echo $usuario['id']; ?>">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección Main (Cuenta de Ahorros) -->
        <div id="mainSection" style="display: none;">
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

                        <div class="alert alert-info" id="resultado" style="display: none;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para agregar usuario -->
    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="addUserForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contraseña</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para editar usuario -->
    <div class="modal fade" id="editUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editUserForm">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="nombre" id="edit_nombre" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="edit_email" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Cambiar entre secciones
            $('#showCrud').click(function(e) {
                e.preventDefault();
                $('#crudSection').show();
                $('#mainSection').hide();
                $('#showCrud').parent().addClass('active');
                $('#showMain').parent().removeClass('active');
            });

            $('#showMain').click(function(e) {
                e.preventDefault();
                $('#crudSection').hide();
                $('#mainSection').show();
                $('#showMain').parent().addClass('active');
                $('#showCrud').parent().removeClass('active');
            });

            // Manejar la creación de cuenta
            $('#cuentaForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: 'main_actions.php',
                    data: {
                        action: 'crear',
                        numeroCuenta: $('#numeroCuenta').val(),
                        titular: $('#titular').val(),
                        saldoInicial: $('#saldoInicial').val()
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#operaciones').show();
                            $('#cuentaForm').hide();
                            $('#resultado').text(response.message).show();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    }
                });
            });

            // Manejar operaciones
            $('#btnDepositar').click(function() {
                realizarOperacion('depositar');
            });

            $('#btnRetirar').click(function() {
                realizarOperacion('retirar');
            });

            $('#btnConsultar').click(function() {
                realizarOperacion('consultar');
            });

            function realizarOperacion(tipo) {
                $.ajax({
                    type: 'POST',
                    url: 'main_actions.php',
                    data: {
                        action: tipo,
                        monto: $('#montoOperacion').val(),
                        numeroCuenta: $('#numeroCuenta').val()
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#resultado').text(response.message).show();
                    }
                });
            }

            // Agregar usuario
            $('#addUserForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: 'crud_actions.php',
                    data: $(this).serialize() + '&action=create',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert('Usuario agregado exitosamente');
                            location.reload();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    }
                });
            });

            // Cargar datos para editar
            $('.edit-user').click(function() {
                $('#edit_id').val($(this).data('id'));
                $('#edit_nombre').val($(this).data('nombre'));
                $('#edit_email').val($(this).data('email'));
            });

            // Editar usuario
            $('#editUserForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: 'crud_actions.php',
                    data: $(this).serialize() + '&action=update',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert('Usuario actualizado exitosamente');
                            location.reload();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    }
                });
            });

            // Eliminar usuario
            $('.delete-user').click(function() {
                if (confirm('¿Está seguro de eliminar este usuario?')) {
                    var id = $(this).data('id');
                    $.ajax({
                        type: 'POST',
                        url: 'crud_actions.php',
                        data: {
                            action: 'delete',
                            id: id
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                alert('Usuario eliminado exitosamente');
                                location.reload();
                            } else {
                                alert('Error: ' + response.message);
                            }
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
