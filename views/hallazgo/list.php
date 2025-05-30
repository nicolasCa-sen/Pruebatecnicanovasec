<!-- views/hallazgo/list.php -->
<?php include 'views/layout/header.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Hallazgos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h1>Lista de Hallazgos</h1>
    <a href="index.php?entity=hallazgo&action=create" class="btn btn-primary mb-3">Crear Hallazgo</a>
    <form method="get" class="form-inline mb-3">
    <input type="hidden" name="entity" value="hallazgo">
    <input type="hidden" name="action" value="index">
    <label for="id_proceso_origen" class="mr-2">Filtrar por Proceso Origen:</label>
    <select name="id_proceso_origen" id="id_proceso_origen" class="form-control mr-2" onchange="this.form.submit()">
        <option value="">-- Todos --</option>
        <?php foreach ($procesos as $proceso): ?>
            <option value="<?= $proceso['id'] ?>" <?= (isset($_GET['id_proceso_origen']) && $_GET['id_proceso_origen'] == $proceso['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($proceso['nombre']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <noscript><button type="submit" class="btn btn-secondary">Filtrar</button></noscript>
</form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Usuario</th>
                <th>Proceso Origen</th>
                <th>Procesos</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($hallazgos as $hallazgo): ?>
            <tr>
                <td><?= $hallazgo['id'] ?></td>
                <td><?= $hallazgo['titulo'] ?></td>
                <td><?= $hallazgo['descripcion'] ?></td>
                <td>
                    <select class="estado-select" data-id="<?= $hallazgo['id'] ?>">
                        <?php foreach ($estados as $estado): ?>
                        <option value="<?= $estado['id'] ?>" <?= $estado['id'] == $hallazgo['id_estado'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($estado['nombre']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td><?= $hallazgo['usuario_nombre'] ?></td>
                <td><?= $hallazgo['proceso_origen_nombre'] ?></td>
                <td>
                    <ul>
                        <?php foreach ($hallazgo['procesos'] as $proceso): ?>
                            <li><?= $proceso['nombre'] ?></li>
                        <?php endforeach; ?>
                    </ul>
                </td>
                <td>
                    <a href="index.php?entity=hallazgo&action=show&id=<?= $hallazgo['id'] ?>" class="btn btn-info btn-sm">Ver</a>
                    <a href="index.php?entity=hallazgo&action=edit&id=<?= $hallazgo['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                    <a href="index.php?entity=hallazgo&action=delete&id=<?= $hallazgo['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro?')">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>
<script src="assets/js/hallazgos.js"></script>

</body>
</html>