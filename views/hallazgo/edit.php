<!-- views/hallazgo/edit.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Hallazgo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php include 'views/layout/header.php'; ?>
<div class="container mt-4">
    <h1>Editar Hallazgo</h1>
    <form action="index.php?entity=hallazgo&action=edit&id=<?= $hallazgo['id'] ?>" method="POST">
        <div class="form-group">
            <label for="titulo">Título</label>
            <input type="text" class="form-control" id="titulo" name="titulo" value="<?= $hallazgo['titulo'] ?>" required>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" required><?= $hallazgo['descripcion'] ?></textarea>
        </div>
        <div class="form-group">
            <label for="id_estado">Estado</label>
            <select class="form-control" id="id_estado" name="id_estado" required>
                <?php foreach ($estados as $estado): ?>
                    <option value="<?= $estado['id'] ?>" <?= ($estado['id'] == $hallazgo['id_estado']) ? 'selected' : '' ?>>
                        <?= $estado['nombre'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="id_usuario">Usuario Responsable</label>
            <select class="form-control" id="id_usuario" name="id_usuario" required>
                <?php foreach ($usuarios as $usuario): ?>
                    <option value="<?= $usuario['id'] ?>" <?= ($usuario['id'] == $hallazgo['id_usuario']) ? 'selected' : '' ?>>
                        <?= $usuario['nombre'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="procesos">Procesos Afectados</label>
            <div class="form-group mb-4">
                <small class="form-text text-muted mb-2">Seleccione todos los procesos impactados por este hallazgo</small>
                <div class="process-list-container">
                    <div class="form-row">
                        <?php foreach (array_chunk($procesos, ceil(count($procesos)/3)) as $procesos_columna): ?>
                        <div class="col-md-4">
                            <?php foreach ($procesos_columna as $proceso): ?>
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input"
                                    id="proceso_<?= $proceso['id'] ?>"
                                    name="procesos[]"
                                    value="<?= $proceso['id'] ?>"
                                    <?= in_array($proceso['id'], $selectedProcesoIds) ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="proceso_<?= $proceso['id'] ?>">
                                    <?= $proceso['nombre'] ?>
                                </label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="id_proceso_origen">Proceso Origen</label>
            <select class="form-control" id="id_proceso_origen" name="id_proceso_origen" required>
            <option value="">Seleccione un proceso</option>
                <?php foreach ($procesos as $proceso): ?>
                    <option value="<?= $proceso['id'] ?>" <?= ($proceso['id'] == $hallazgo['id_proceso_origen']) ? 'selected' : '' ?>>
                <?= $proceso['nombre'] ?>
            </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="index.php?entity=hallazgo&action=index" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
