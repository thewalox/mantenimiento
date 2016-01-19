<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Solicitudes_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public function add_solicitud($fecdoc, $cedula, $servicio, $tipo, $maquina, $orden, $detalle){
		$sql = "INSERT INTO Solicitudes (fecha_solicitud, idempleado, servicio, tipo_mtto, 
				idmaquina, orden_prod, detalle, estado)
				VALUES (". $this->db->escape($fecdoc) . ", ". $this->db->escape($cedula) . ", ". 
				$this->db->escape($servicio) . ", ". $this->db->escape($tipo) . ", ". 
				$this->db->escape($maquina) . ", UPPER(". $this->db->escape($orden) ."), UPPER(". 
				$this->db->escape($detalle) ."), 'P')";
		//echo $sql;
		if ($this->db->simple_query($sql)){
        	return $this->db->insert_id(); //Exito
		}else{
        	return false; //Error
		}

		//return $mensaje;
		
	}

	public function cerrar_solicitud($id, $usuario, $tiposol, $dias, $diagnostico, $solucion){
		$sql = "UPDATE solicitudes SET tipo_solucion = ". $this->db->escape($tiposol) .",
				dias_solucion = ". $this->db->escape($dias) .",
				diagnostico = UPPER(". $this->db->escape($diagnostico) ."),
				solucion = UPPER(". $this->db->escape($solucion) ."),
				fecha_solucion = NOW(), usuario_solucion = ". $this->db->escape($usuario) .",
				estado = 'C'
				WHERE idsolicitud = '$id'";
		//echo($sql);
		if ($this->db->simple_query($sql)){
			return true;
        	//$mensaje =  2; //Exito
		}else{
        	return false;
        	//$mensaje = 3; //Error
		}

		//return $mensaje;
		
	}

	public function elimina_maquina($codigo){
		$sql = "UPDATE Solicitudes SET estado = 'I'
				WHERE idmaquina = '$codigo'";
		//echo $sql;			
		if ($this->db->simple_query($sql)){
        	$mensaje =  2; //Exito
		}else{
        	$mensaje = 3; //Error
		}

		return $mensaje;
		
	}

	public function get_solicitudes($limit, $segmento){
		$sql = "SELECT s.idsolicitud, s.fecha_solicitud, 
				CASE WHEN s.servicio = 'IN' THEN 'INMEDIATO' ELSE 'NO INMEDIATO' END AS servicio,
				CASE WHEN s.tipo_mtto = 'P' THEN 'PREVENTIVO' ELSE 'CORRECTIVO' END AS tipo_mtto,
				CASE WHEN s.estado = 'P' THEN 'PENDIENTE' ELSE 'CERRADA' END AS estado,
				CASE WHEN s.estado = 'P' THEN 'warning' ELSE 'success' END AS color
				FROM solicitudes s
				ORDER BY s.idsolicitud DESC ";

		if($limit != 0){
			$sql .= "LIMIT ". $segmento ." , ". $limit;
		}

		//echo $sql;

		$res = $this->db->query($sql);
		return $res->result_array();
		
	}

	function get_total_solicitudes(){
		$this->db->from('Solicitudes')->where('estado');
		return $this->db->count_all_results();
  	}

  	public function get_solicitud_by_id($id, $opcion){
		

		if ($opcion == 1) {
			//Editar Solicitud
			$sql = "SELECT s.idsolicitud, s.fecha_solicitud, 
					CASE WHEN s.servicio = 'IN' THEN 'INMEDIATO' ELSE 'NO INMEDIATO' END AS servicio,
					CASE WHEN s.tipo_mtto = 'P' THEN 'PREVENTIVO' ELSE 'CORRECTIVO' END AS tipo_mtto,
					CASE WHEN s.estado = 'P' THEN 'PENDIENTE' ELSE 'CERRADA' END AS estado,
					s.idempleado, e.nombre, d.desc_departamento, s.idmaquina, m.desc_maquina, se.desc_seccion,
					p.desc_planta, s.orden_prod, s.detalle, DATEDIFF(NOW(), s.fecha_solicitud) AS dias
					FROM solicitudes s
					INNER JOIN empleados  e ON e.idempleado = s.idempleado
					INNER JOIN departamentos d ON d.iddepartamento = e.iddepartamento
					LEFT JOIN maquinas m ON m.idmaquina = s.idmaquina
					LEFT JOIN secciones se ON se.idseccion = m.idseccion
					LEFT JOIN plantas p ON p.idplanta = se.idplanta
					WHERE s.idsolicitud = '$id' AND s.estado = 'P'
					ORDER BY s.idsolicitud DESC"; 
			
		}else{
			//Ver Solicitud
			$sql = "SELECT s.idsolicitud, s.fecha_solicitud, 
					CASE WHEN s.servicio = 'IN' THEN 'INMEDIATO' ELSE 'NO INMEDIATO' END AS servicio,
					CASE WHEN s.tipo_mtto = 'P' THEN 'PREVENTIVO' ELSE 'CORRECTIVO' END AS tipo_mtto,
					CASE WHEN s.estado = 'P' THEN 'PENDIENTE' ELSE 'CERRADA' END AS estado,
					s.idempleado, e.nombre, d.desc_departamento, s.idmaquina, m.desc_maquina, se.desc_seccion,
					p.desc_planta, s.orden_prod, s.detalle, 
					CASE 
					WHEN s.tipo_solucion = 'E' THEN 'ELECTRICO'
					WHEN s.tipo_solucion = 'M' THEN 'MECANICO'
					WHEN s.tipo_solucion = 'O' THEN 'OTROS'
					ELSE '' END AS tipo_solucion, s.dias_solucion AS dias,
					s.diagnostico, s.solucion, s.fecha_solucion, s.usuario_solucion
					FROM solicitudes s
					INNER JOIN empleados  e ON e.idempleado = s.idempleado
					INNER JOIN departamentos d ON d.iddepartamento = e.iddepartamento
					LEFT JOIN maquinas m ON m.idmaquina = s.idmaquina
					LEFT JOIN secciones se ON se.idseccion = m.idseccion
					LEFT JOIN plantas p ON p.idplanta = se.idplanta
					WHERE s.idsolicitud = '$id'
					ORDER BY s.idsolicitud DESC";
		}
		
		
		//echo($sql);
		$res = $this->db->query($sql);
		return $res->row();
		
	}

	public function get_Solicitudes_by_criterio($filtro){
		$sql = "SELECT m.idmaquina, m.desc_maquina, s.desc_seccion
				FROM Solicitudes m
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