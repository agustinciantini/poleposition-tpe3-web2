<?php
require_once './app/models/ResultadosModel.php';
require_once './app/views/APIView.php';

class ResultadosAPIController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new ResultadosModel();
        $this->view = new APIView();
    }
    
    public function getAllResultados($req, $res) {
        $orderBy = null;
        $orderDirection = null;
        $filter_piloto = null; 
        $filter_carrera = null; 
        $page=null;
        $limit=null;

        if(!$res->user) {
            return $this->view->response("No estás autorizado, inicia sesión porfavor.", 401);
        }

        if(isset($req->query->orderBy)){
            $orderBy = $req->query->orderBy;
        }
        if(isset($req->query->orderDirection)){
            $orderDirection  = $req->query->orderDirection;
        }
        if(isset($req->query->filter_piloto)){ 
            $filter_piloto  = $req->query->filter_piloto;
        }
        if(isset($req->query->filter_carrera)){
            $filter_carrera  = $req->query->filter_carrera;
        }
        
        // Paginacion
        if(isset($req->query->page) && is_numeric($req->query->page)){
            if(isset($req->query->limit) && is_numeric($req->query->limit)) {
                $limit = $req->query->limit;
                $page = ($req->query->page - 1) * $limit; 
            } else {
                // Si no hay limit, se usa el page como offset directo
                $page = $req->query->page;
            }
         }
        if(isset($req->query->limit) && is_numeric($req->query->limit) && $limit === null){
            $limit = $req->query->limit;
        }
        
        $resultados = $this->model->getResultados( $orderBy , $orderDirection, $filter_piloto, $filter_carrera, $page, $limit);
        
        if(!$resultados){ 
            return $this->view->response('No hay resultados de carreras disponibles.', 404);
        }
        return $this->view->response($resultados , 200);
    }

    public function getResultado($req, $res) {
        $id = $req->params->id; 

        $resultado = $this->model->getResultado($id); 

        if(!$resultado) {
            return $this->view->response("El resultado con el id=$id no existe.", 404);
        }
        
        return $this->view->response($resultado , 200);
    }

    public function deleteResultado($req, $res) {
        $id = $req->params->id; 
        
        $resultado = $this->model->getResultado($id);  

        if (!$resultado) {
            return $this->view->response("El resultado con el id=$id no existe.", 404);
        }

        $this->model->deleteResultado($id);
        return $this->view->response("El resultado con el id=$id se eliminó con éxito.", 200);
    }

    public function createResultado($req, $res) {
        
        // La variable $data contiene el objeto decodificado del cuerpo JSON
        $data = $req->body;

        // Validar que se recibieron datos
        if (is_null($data) || empty($data->piloto_id) || empty($data->carrera_id) || empty($data->posicion) || empty($data->tiempo)) {
            return $this->view->response('Faltan completar datos: piloto_id, carrera_id, posicion y tiempo.', 400);
        }

        // Obtiene los datos
        $piloto_id = $data->piloto_id;
        $carrera_id = $data->carrera_id;
        $posicion = $data->posicion;
        $tiempo = $data->tiempo;

        // Insertar el resultaddo
        $id = $this->model->createResultado($piloto_id, $carrera_id, $posicion, $tiempo);

        if (!$id) {
            return $this->view->response("Error al insertar el resultado.", 500);
        }

        // Devolver el resultado insertado
        $resultado = $this->model->getResultado($id);
        return $this->view->response($resultado, 201);
    }

    public function updateResultado($req, $res) {
        $id = $req->params->id; 
        $data = $req->body; // Obtenemos los datos del cuerpo

        // Verificar que el resultado exista
        $resultado = $this->model->getResultado($id);
        if (!$resultado) {
            return $this->view->response("El resultado con el id=$id no existe.", 404);
        }

        // Validar que $data no es null y que tiene todos los campos
        if (is_null($data) || empty($data->piloto_id) || empty($data->carrera_id) || empty($data->posicion) || empty($data->tiempo)) {
            return $this->view->response('Faltan completar datos: piloto_id, carrera_id, posicion y tiempo.', 400);
        }

        // Obtiene los datos
        $piloto_id = $data->piloto_id;
        $carrera_id = $data->carrera_id;
        $posicion = $data->posicion;
        $tiempo = $data->tiempo;

        // Actualizar el resultado
        $this->model->updateResultado($id, $piloto_id, $carrera_id, $posicion, $tiempo);

        // Devolver el resultado modificado
        $resultado = $this->model->getResultado($id);
        $this->view->response($resultado, 200);
    }
}