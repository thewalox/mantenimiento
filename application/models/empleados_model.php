<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empleados_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public function add_empleado($cedula, $nombre, $dep){
		$sql = "INSERT INTO empleados (idempleado, nombre, iddepartamento, estado)
				VALUES (". $this->db->escape($cedula) .", UPPER(". $this->db->escape($nombre) ."), ".
				$this->db->escape($dep) .", 'A')";
		//echo $sql;
		if ($this->db->simple_query($sql)){
        	$mensaje =  2; //Exito
		}else{
        	$mensaje = 3; //Error
		}

		return $mensaje;
		
	}

	public function edit_empleado($cedula, $nombre, $dep){
		$sql = "UPDATE empleados SET nombre = UPPER(". $this->db->escape($nombre) ."),
				iddepartamento = ". $this->db->escape($dep) ."
				WHERE idempleado = '$cedula'";
		//echo($sql);
		if ($this->db->simple_query($sql)){
        	$mensaje =  2; //Exito
		}else{
        	$mensaje = 3; //Error
		}

		return $mensaje;
		
	}

	public function elimina_empleado($codigo){
		$sql = "UPDATE empleados SET estado = 'I'
				WHERE idempleado = '$codigo'";
		//echo $sql;			
		if ($this->db->simple_query($sql)){
        	$mensaje =  2; //Exito
		}else{
        	$mensaje = 3; //Error
		}

		return $mensaje;
		
	}

	public function get_empleados($limit, $segmento){
		$sql = "SELECT e.idempleado, e.nombre, d.desc_departamento
				FROM empleados e
				INNER JOIN departamentos d ON d.iddepartamento = e.iddepartamento
				WHERE e.estado = 'A' 
				ORDER BY e.idempleado ";

		if($limit != 0){
			$sql .= "LIMIT ". $segmento ." , ". $limit;
		}

		//echo $sql;

		$res = $this->db->query($sql);
		return $res->result_array();
		
	}

	function get_total_empleados(){
		$this->db->from('empleados')->where('estado', 'A');
		return $this->db->count_all_results();
  	}

  	public function get_empleado_by_id($id){
		$sql = "SELECT * FROM empleados where idempleado = '$id' and estado = 'A'";
		//echo($sql);
		$res = $this->db->query($sql);
		return $res->row();
		
	}

	public function get_empleados_by_criterio($filtro){
		$sql = "SELECT e.idempleado, e.nombre, d.desc_departamento
				FROM empleados e
				INNER JOIN departamentos d ON d.iddepartamento = e.iddepartamento
				WHERE (e.idempleado LIKE '%". $filtro ."%' 
				OR e.nombre like '%". $filtro ."%' 
				OR d.desc_departamento like '%". $filtro ."%') 
				AND e.estado = 'A' 
				ORDER BY e.idempleado";
				//echo($sql);
		$res = $this->db->query($sql);
		return $res->result_array();
		
	}

}