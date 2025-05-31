<?php
// controllers/IncidenteController.php
require_once 'models/IncidenteModel.php';
require_once 'models/EstadoModel.php';
require_once 'models/UsuarioModel.php';
require_once 'models/PlanAccionModel.php';
require_once 'Traits/PlanAccionTrait.php';

class IncidenteController {

    use PlanAccionTrait;

    private $model;
    private $estadoModel;
    private $usuarioModel;
    private $planAccionModel;

    public function __construct($pdo) {
        $this->model = new IncidenteModel($pdo);
        $this->estadoModel = new EstadoModel($pdo);
        $this->usuarioModel = new UsuarioModel($pdo);
        $this->planAccionModel = new PlanAccionModel($pdo);
    }

    public function index() {
        $incidentes = $this->model->getAll();
        require 'views/incidente/list.php';
    }

    public function show($id) {
        $incidente = $this->model->getById($id);
        require 'views/incidente/show.php';
    }

    public function create() {
        $estados = $this->estadoModel->getAll();
        $usuarios = $this->usuarioModel->getAll();
        require 'views/incidente/create.php';
    }

    public function insert($data) {
        $descripcion = $data['descripcion'];
        $fecha_ocurrencia = $data['fecha_ocurrencia'];
        $id_estado = $data['id_estado'];
        $id_usuario = $data['id_usuario'];

        $this->model->insert($descripcion, $fecha_ocurrencia, $id_estado, $id_usuario);
        header('Location: index.php?entity=incidente&action=index');
    }

    public function edit($id) {
        $incidente = $this->model->getById($id);
        $estados = $this->estadoModel->getAll();
        $usuarios = $this->usuarioModel->getAll();
        require 'views/incidente/edit.php';
    }

    public function update($id, $data) {
        $descripcion = $data['descripcion'];
        $fecha_ocurrencia = $data['fecha_ocurrencia'];
        $id_estado = $data['id_estado'];
        $id_usuario = $data['id_usuario'];

        $this->model->update($id, $descripcion, $fecha_ocurrencia, $id_estado, $id_usuario);
        header('Location: index.php?entity=incidente&action=index');
    }

    public function delete($id) {
        $this->model->delete($id);
        header('Location: index.php?entity=incidente&action=index');
    }

	// Método para manejar la solicitud de planes de acción
 public function planesAccion($id_incidente) {
        $this->handleShowPlanesAccion($id_incidente, 'INCIDENTE', 'views/incidente/planes_accion.php');
    }

    public function insertPlanAccion($id_incidente, $data) {
        $this->handleInsertPlanAccion($id_incidente, 'INCIDENTE', $data, 'incidente');
    }

    public function updatePlanAccion($id_incidente, $id_plan_accion, $data) {
        $this->handleUpdatePlanAccion($id_incidente, 'INCIDENTE', $id_plan_accion, $data, 'incidente');
    }

    public function deletePlanAccion($id_incidente, $id_plan_accion) {
        $this->handleDeletePlanAccion($id_incidente, 'INCIDENTE', $id_plan_accion, 'incidente');
    }
}
?>