<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maquinas_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public function add_maquina($codigo, $desc, $seccion){
		$sql = "INSERT INTO maquinas (idmaquina, desc_maquina, idseccion, estado)
				VALUES (". $this->db->escape($codigo) .", UPPER(". $this->db->escape($desc) ."), ". 
				$this->db->escape($seccion) .", 'A')";
		//echo $sql;
		if ($this->db->simple_query($sql)){
        	$mensaje =  2; //Exito
		}else{
        	$mensaje = 3; //Error
		}

		return $mensaje;
		
	}

	public function edit_maquina($codigo, $desc, $seccion){
		$sql = "UPDATE maquinas SET desc_maquina = UPPER(". $this->db->escape($desc) ."),
				idseccion = ". $this->db->escape($seccion) ."
				WHERE idmaquina = '$codigo'";
		//echo($sql);
		if ($this->db->simple_query($sql)){
        	$mensaje =  2; //Exito
		}else{
        	$mensaje = 3; //Error
		}

		return $mensaje;
		
	}

	public function elimina_maquina($codigo){
		$sql = "UPDATE maquinas SET estado = 'I'
				WHERE idmaquina = '$codigo'";
		//echo $sql;			
		if ($this->db->simple_query($sql)){
        	$mensaje =  2; //Exito
		}else{
        	$mensaje = 3; //Error
		}

		return $mensaje;
		
	}

	public function get_maquinas($limit, $segmento){
		$sql = "SELECT m.idmaquina, m.desc_maquina, s.desc_seccion
				FROM maquinas m
				INNER JOIN secciones s ON s.idseccion = m.idseccion
				WHERE m.estado = 'A'
				ORDER BY m.idmaquina ";

		if($limit != 0){
			$sql .= "LIMIT ". $segmento ." , ". $limit;
		}

		//echo $sql;

		$res = $this->db->query($sql);
		return $res->result_array();
		
	}

	function get_total_maquinas(){
		$this->db->from('maquinas')->where('estado', 'A');
		return $this->db->count_all_results();
  	}

  	public function get_maquina_by_id($id){
		$sql = "SELECT * FROM maquinas where idmaquina = '$id' and estado = 'A'";
		//echo($sql);
		$res = $this->db->query($sql);
		return $res->row();
		
	}

	public function get_maquinas_by_criterio($filtro){
		$sql = "SELECT m.idmaquina, m.desc_maquina, s.desc_seccion
				FROM maquinas m
				INNER JOIN secciones s ON s.idseccion = m.idseccion
				WHERE (m.idmaquina LIKE '%". $filtro ."%' 
				OR m.desc_maquina like '%". $filtro ."%' 
				OR s.desc_seccion like '%". $filtro ."%') 
				AND m.estado = 'A' 
				ORDER BY m.idmaquina";
				//echo($sql);
		$res = $this->db->query($sql);
		return $res->result_array();
		
	}

}