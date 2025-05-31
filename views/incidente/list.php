<!-- views/incidente/list.php -->
<?php include 'views/layout/header.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Incidentes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h1>Lista de Incidentes</h1>
     <div class="search-container">
        <form method="GET" action="index.php" class="form-inline">
            <input type="hidden" name="entity" value="incidente">
            <input type="hidden" name="action" value="index">
            <input type="number" name="search_id" class="form-control" placeholder="Buscar por ID" 
            value="<?= isset($_GET['search_id']) ? htmlspecialchars($_GET['search_id']) : '' ?>">
            <button type="submit" class="btn btn-primary">Buscar</button>
            <?php if (!empty($_GET['search_id'])): ?>
                <a href="index.php?entity=incidente&action=index" class="btn btn-secondary">Mostrar todos</a>
            <?php endif; ?>
        </form>
    </div>
    
    <?php if (!empty($searchResultMessage)): ?>
        <div class="alert alert-info"><?= $searchResultMessage ?></div>
    <?php endif; ?>
    <a href="index.php?entity=incidente&action=create" class="btn btn-primary mb-3">Crear Incidente</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Descripción</th>
                <th>Fecha de Ocurrencia</th>
                <th>Estado</th>
                <th>Usuario</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($incidentes as $incidente): ?>
            <tr>
                <td><?= $incidente['id'] ?></td>
                <td><?= $incidente['descripcion'] ?></td>
                <td><?= $incidente['fecha_ocurrencia'] ?></td>
                <td><?= $incidente['estado_nombre'] ?></td>
                <td><?= $incidente['usuario_nombre'] ?></td>
                <td>
                    <a href="index.php?entity=incidente&action=show&id=<?= $incidente['id'] ?>" class="btn btn-info btn-sm">Ver</a>
                    <a href="index.php?entity=incidente&action=edit&id=<?= $incidente['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                    <a href="index.php?entity=incidente&action=delete&id=<?= $incidente['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro?')">Eliminar</a>
					<a href="index.php?entity=incidente&action=planes_accion&id=<?= $incidente['id'] ?>" class="btn btn-secondary btn-sm">Planes de Acción</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>