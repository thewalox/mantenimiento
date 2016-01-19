<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Secciones_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public function add_seccion($desc, $planta){
		$sql = "INSERT INTO secciones (desc_seccion, idplanta, estado)
				VALUES (UPPER(". $this->db->escape($desc) ."), ". $this->db->escape($planta) .", 'A')";
		//echo $sql;
		if ($this->db->simple_query($sql)){
        	$mensaje =  2; //Exito
		}else{
        	$mensaje = 3; //Error
		}

		return $mensaje;
		
	}

	public function edit_seccion($codigo, $desc, $planta){
		$sql = "UPDATE secciones SET desc_seccion = UPPER(". $this->db->escape($desc) ."),
				idplanta = ". $this->db->escape($planta) ."
				WHERE idseccion = '$codigo'";
		//echo($sql);
		if ($this->db->simple_query($sql)){
        	$mensaje =  2; //Exito
		}else{
        	$mensaje = 3; //Error
		}

		return $mensaje;
		
	}

	public function elimina_seccion($codigo){
		$sql = "UPDATE secciones SET estado = 'I'
				WHERE idseccion = '$codigo'";
		//echo $sql;			
		if ($this->db->simple_query($sql)){
        	$mensaje =  2; //Exito
		}else{
        	$mensaje = 3; //Error
		}

		return $mensaje;
		
	}

	public function get_secciones($limit, $segmento){
		$sql = "SELECT s.idseccion, s.desc_seccion, p.desc_planta
				FROM secciones s
				INNER JOIN plantas p ON p.idplanta = s.idplanta
				WHERE s.estado = 'A'
				ORDER BY s.idseccion ";

		if($limit != 0){
			$sql .= "LIMIT ". $segmento ." , ". $limit;
		}

		//echo $sql;

		$res = $this->db->query($sql);
		return $res->result_array();
		
	}

	function get_total_secciones(){
		$this->db->from('secciones')->where('estado', 'A');
		return $this->db->count_all_results();
  	}

  	public function get_seccion_by_id($id){
		$sql = "SELECT * FROM secciones where idseccion = '$id' and estado = 'A'";
		//echo($sql);
		$res = $this->db->query($sql);
		return $res->row();
		
	}

	public function get_secciones_by_criterio($filtro){
		$sql = "SELECT s.idseccion, s.desc_seccion, p.desc_planta
				FROM secciones s
				INNER JOIN plantas p ON p.idplanta = s.idplanta
				WHERE (s.idseccion LIKE '%". $filtro ."%' 
				OR s.desc_seccion like '%". $filtro ."%' 
				OR p.desc_planta like '%". $filtro ."%') 
				AND s.estado = 'A' 
				ORDER BY s.idseccion";
				//echo($sql);
		$res = $this->db->query($sql);
		return $res->result_array();
		
	}

}