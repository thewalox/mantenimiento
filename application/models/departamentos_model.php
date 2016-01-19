<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Departamentos_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public function add_departamento($descripcion){
		$sql = "INSERT INTO departamentos (desc_departamento, estado)
				VALUES (UPPER(". $this->db->escape($descripcion) ."), 'A')";
		//echo $sql;
		if ($this->db->simple_query($sql)){
        	$mensaje =  2; //Exito
		}else{
        	$mensaje = 3; //Error
		}

		return $mensaje;
		
	}

	public function edit_departamento($codigo, $desc){
		$sql = "UPDATE departamentos SET desc_departamento = UPPER(". $this->db->escape($desc) .")
				WHERE iddepartamento = '$codigo'";
		//echo($sql);
		if ($this->db->simple_query($sql)){
        	$mensaje =  2; //Exito
		}else{
        	$mensaje = 3; //Error
		}

		return $mensaje;
		
	}

	public function elimina_departamento($codigo){
		$sql = "UPDATE departamentos SET estado = 'I'
				WHERE iddepartamento = '$codigo'";
		//echo $sql;			
		if ($this->db->simple_query($sql)){
        	$mensaje =  2; //Exito
		}else{
        	$mensaje = 3; //Error
		}

		return $mensaje;
		
	}

	public function get_departamentos($limit, $segmento){
		$sql = "SELECT * FROM departamentos WHERE estado = 'A' ORDER BY iddepartamento ";

		if($limit != 0){
			$sql .= "LIMIT ". $segmento ." , ". $limit;
		}

		//echo $sql;

		$res = $this->db->query($sql);
		return $res->result_array();
		
	}

	function get_total_departamentos(){
		$this->db->from('departamentos')->where('estado', 'A');
		return $this->db->count_all_results();
  	}

  	public function get_departamento_by_id($id){
		$sql = "SELECT * FROM departamentos where iddepartamento = '$id' and estado = 'A'";
		//echo($sql);
		$res = $this->db->query($sql);
		return $res->row();
		
	}

	public function get_departamentos_by_criterio($filtro){
		$sql = "SELECT *
				FROM departamentos
				WHERE (iddepartamento LIKE '%". $filtro ."%' 
				OR desc_departamento like '%". $filtro ."%') 
				AND estado = 'A' 
				ORDER BY iddepartamento";
				//echo($sql);
		$res = $this->db->query($sql);
		return $res->result_array();
		
	}

}