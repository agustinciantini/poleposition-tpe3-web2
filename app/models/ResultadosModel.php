<?php

class ResultadosModel {
    private $db;

    public function __construct() {
       $this->db = new PDO('mysql:host=localhost;dbname=poleposition;charset=utf8', 'root', '');
    }
 
    // Obtener todos los resultados con opción de ordenar y filtrar
    public function getResultados($orderBy = null , $ordenDirection = ' ASC', $filter_piloto=null, $filter_carrera=null, $page, $limit) {
        
        $sql = 'SELECT r.*, p.nombre, p.apellido, c.fecha, c.vueltas FROM resultados r JOIN pilotos p ON r.piloto_id = p.piloto_id JOIN carreras c ON r.carrera_id = c.carrera_id';
        
        $filtros=[];
        $params = [];

        if($filter_piloto != null){
            array_push($filtros,' r.piloto_id = ? ');
            array_push($params, $filter_piloto);
        }
        if($filter_carrera != null){
            array_push($filtros,' r.carrera_id = ? ');
            array_push($params, $filter_carrera);
        }

        if(!empty($filtros)){
            $sql .= ' WHERE ';
            $sql .= implode(' AND ', $filtros);
        }

        // Ordenamiento
        if ($orderBy) {
            $sql .= ' ORDER BY ';
            switch($orderBy) {
                case 'posicion':
                    $sql .= ' r.posicion';
                    break;
                case 'tiempo':
                     $sql .= ' r.tiempo';
                    break;
                case 'piloto':
                     $sql .= ' p.apellido';
                    break;
                case 'carrera':
                     $sql .= ' c.fecha';
                    break;
                default:
                    $sql .= ' r.resultado_id';
            }
            if($ordenDirection === 'DESC'){
                $sql .= ' DESC';
            }else{
                $sql .= ' ASC';
            }
        }
        
        // Paginacion
        if($limit != null && is_numeric($limit)){
            $sql .= ' LIMIT '.$limit;
        }
        if($page != null && is_numeric($page)){
            $sql .= ' OFFSET '.$page; 
        }

        $query = $this->db->prepare($sql);
        $query->execute($params);    
        
        $resultados = $query->fetchAll(PDO::FETCH_OBJ);
    
        return $resultados;
    }


    // Obtener un resultado específico por su ID (resultado_id).
    public function getResultado($id) {
        $sql = 'SELECT r.*, p.nombre, p.apellido, c.fecha, c.vueltas FROM resultados r JOIN pilotos p ON r.piloto_id = p.piloto_id JOIN carreras c ON r.carrera_id = c.carrera_id WHERE r.resultado_id = ?';
        $query = $this->db->prepare($sql);
        $query->execute([$id]);
    
        $resultado = $query->fetch(PDO::FETCH_OBJ);
    
        return $resultado;
    }

    // Insertar un nuevo resultado.
    public function createResultado($piloto_id, $carrera_id, $posicion, $tiempo) {
        $query = $this->db->prepare('INSERT INTO resultados(piloto_id, carrera_id, posicion, tiempo) VALUES (?, ?, ?, ?)');
        $query->execute([$piloto_id, $carrera_id, $posicion, $tiempo]);
    
        $id = $this->db->lastInsertId();
    
        return $id;
    }

    // Eliminar un resultado.
    public function deleteResultado($id) {
        $query = $this->db->prepare('DELETE FROM resultados WHERE resultado_id = ?');
        $query->execute([$id]);
    }

    // Actualizar un resultado.
    public function updateResultado($id, $piloto_id, $carrera_id, $posicion, $tiempo) {
        $query = $this->db->prepare('UPDATE resultados SET piloto_id = ?, carrera_id = ?, posicion = ?, tiempo = ? WHERE resultado_id = ?');
        $query->execute([$piloto_id, $carrera_id, $posicion, $tiempo, $id]);
    }
}