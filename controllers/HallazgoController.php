<?php
// controllers/HallazgoController.php
require_once 'models/HallazgoModel.php';
require_once 'models/ProcesoModel.php';
require_once 'models/EstadoModel.php';
require_once 'models/UsuarioModel.php';
require_once 'models/PlanAccionModel.php';
require_once 'Traits/PlanAccionTrait.php';

class HallazgoController {
    use PlanAccionTrait;
    private $model;
    private $procesoModel;
    private $estadoModel;
    private $usuarioModel;
    private $planAccionModel;

    public function __construct($pdo) {
        $this->model = new HallazgoModel($pdo);
        $this->procesoModel = new ProcesoModel($pdo);
        $this->estadoModel = new EstadoModel($pdo);
        $this->usuarioModel = new UsuarioModel($pdo);
        $this->planAccionModel = new PlanAccionModel($pdo);
    }

    public function index() {

        $id_proceso_origen = $_GET['id_proceso_origen'] ?? null;

        $hallazgos = $this->model->getAll($id_proceso_origen);
        $procesos = $this->procesoModel->getAll();
        $estados = $this->estadoModel->getAll(); // AÑADIR si no está
        require 'views/hallazgo/list.php';
    }

    public function show($id) {
        $hallazgo = $this->model->getById($id);
        require 'views/hallazgo/show.php';
    }

    public function create() {
        $procesos = $this->procesoModel->getAll();
        $estados = $this->estadoModel->getAll();
        $usuarios = $this->usuarioModel->getAll();
        require 'views/hallazgo/create.php';
    }

    public function insert($data) {
        $titulo = $data['titulo'];
        $descripcion = $data['descripcion'];
        $proceso_ids = $data['procesos'] ?? [];
        $id_estado = $data['id_estado'];
        $id_usuario = $data['id_usuario'];
        $id_proceso_origen = $data['id_proceso_origen'] ?? null;

        $this->model->insert($titulo, $descripcion, $proceso_ids, $id_estado, $id_usuario, $id_proceso_origen);
        header('Location: index.php?entity=hallazgo&action=index');
    }

    public function edit($id) {
        $hallazgo = $this->model->getById($id);
        $procesos = $this->procesoModel->getAll();
        $estados = $this->estadoModel->getAll();
        $usuarios = $this->usuarioModel->getAll();
        $selectedProcesos = $this->model->getProcesos($hallazgo['id']);
        $selectedProcesoIds = array_column($selectedProcesos, 'id');
        require 'views/hallazgo/edit.php';
    }

    public function update($id, $data) {
        $titulo = $data['titulo'];
        $descripcion = $data['descripcion'];
        $proceso_ids = $data['procesos'] ?? [];
        $id_estado = $data['id_estado'];
        $id_usuario = $data['id_usuario'];
            $id_proceso_origen = $data['id_proceso_origen'] ?? null;

        $this->model->update($id, $titulo, $descripcion, $proceso_ids, $id_estado, $id_usuario, $id_proceso_origen);
        header('Location: index.php?entity=hallazgo&action=index');
    }

    public function delete($id) {
        $this->model->delete($id);
        header('Location: index.php?action=index');
    }

    public function updateEstado() {
    $id = $_POST['id'] ?? null;
    $id_estado = $_POST['id_estado'] ?? null;

    if ($id && $id_estado) {
        $this->model->updateEstado($id, $id_estado);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
    }public function planesAccion($id_hallazgo) {
        $this->handleShowPlanesAccion($id_hallazgo, 'HALLAZGO', 'views/hallazgo/planes_accion.php');
    }

    public function insertPlanAccion($id_hallazgo, $data) {
        $this->handleInsertPlanAccion($id_hallazgo, 'HALLAZGO', $data, 'hallazgo');
    }

    public function updatePlanAccion($id_hallazgo, $id_plan_accion, $data) {
        $this->handleUpdatePlanAccion($id_hallazgo, 'HALLAZGO', $id_plan_accion, $data, 'hallazgo');
    }

    public function deletePlanAccion($id_hallazgo, $id_plan_accion) {
        $this->handleDeletePlanAccion($id_hallazgo, 'HALLAZGO', $id_plan_accion, 'hallazgo');
    }

    public function asociarPlanExistente($id_hallazgo, $id_plan_accion) {
        $this->handleAsociarPlanExistente($id_hallazgo, 'HALLAZGO', $id_plan_accion, 'hallazgo');
    }
}
?>