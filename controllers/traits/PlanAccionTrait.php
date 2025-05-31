<?php

trait PlanAccionTrait
{
    /**
     * Maneja la visualización de planes de acción
     */
    protected function handleShowPlanesAccion($id_registro, $tipo_registro, $view_path)
    {
        // Obtener el registro
        $registro = $this->model->getById($id_registro);

        if (!$registro) {
            throw new Exception("No se encontró el $tipo_registro con ID $id_registro");
        }

        $planesAccion = $this->planAccionModel->getByRegistro($id_registro, $tipo_registro);
        $estados = $this->estadoModel->getAll();
        $usuarios = $this->usuarioModel->getAll();

        if ($tipo_registro == 'INCIDENTE') {
            $incidente = $registro;
        } elseif ($tipo_registro == 'HALLAZGO') {
            $hallazgo = $registro;
        }

        require $view_path;
    }

    /**
     * Inserta un nuevo plan de acción
     */
    protected function handleInsertPlanAccion($id_registro, $tipo_registro, $data, $redirect_entity)
    {
        $id_plan_accion = $this->planAccionModel->insert([
            'descripcion' => $data['descripcion'],
            'id_usuario' => $data['id_usuario'],
            'fecha_inicio' => $data['fecha_inicio'],
            'fecha_fin' => $data['fecha_fin'],
            'id_estado' => $data['id_estado']
        ]);

        if ($id_plan_accion) {
            $this->planAccionModel->linkToRegistro($id_plan_accion, $id_registro, $tipo_registro);
        }

        header("Location: index.php?entity=$redirect_entity&action=planes_accion&id=$id_registro");
        exit();
    }

    /**
     * Actualiza un plan de acción existente
     */
    protected function handleUpdatePlanAccion($id_registro, $tipo_registro, $id_plan_accion, $data, $redirect_entity)
    {
        $this->planAccionModel->update($id_plan_accion, [
            'descripcion' => $data['descripcion'],
            'id_usuario' => $data['id_usuario'],
            'fecha_inicio' => $data['fecha_inicio'],
            'fecha_fin' => $data['fecha_fin'],
            'id_estado' => $data['id_estado']
        ]);

        header("Location: index.php?entity=$redirect_entity&action=planes_accion&id=$id_registro");
        exit();
    }

    /**
     * Elimina un plan de acción
     */
    protected function handleDeletePlanAccion($id_registro, $tipo_registro, $id_plan_accion, $redirect_entity)
    {
        $this->planAccionModel->unlinkFromRegistro($id_plan_accion, $id_registro, $tipo_registro);
        $this->planAccionModel->delete($id_plan_accion);

        header("Location: index.php?entity=$redirect_entity&action=planes_accion&id=$id_registro");
        exit();
    }

    /**
     * Asocia un plan de acción existente a otro registro
     */
    protected function handleAsociarPlanExistente($id_registro, $tipo_registro, $id_plan_accion, $redirect_entity)
    {
        $this->planAccionModel->linkToRegistro($id_plan_accion, $id_registro, $tipo_registro);
        header("Location: index.php?entity=$redirect_entity&action=planes_accion&id=$id_registro");
        exit();
    }
}
