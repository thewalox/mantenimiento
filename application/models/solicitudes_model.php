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

	public function cerrar_solicitud($id, $usuario, $tiposol, $dias, $diagnostico, $solucion, $tecnico, $pendiente, $est_pend){
		$sql = "UPDATE solicitudes SET tipo_solucion = ". $this->db->escape($tiposol) .",
				dias_solucion = ". $this->db->escape($dias) .",
				diagnostico = UPPER(". $this->db->escape($diagnostico) ."),
				solucion = UPPER(". $this->db->escape($solucion) ."),
				fecha_solucion = NOW(), usuario_solucion = ". $this->db->escape($usuario) .",
				tecnico = UPPER(". $this->db->escape($tecnico) ."),
				pendiente = UPPER(". $this->db->escape($pendiente) ."),
				estado_pendiente = ". $this->db->escape($est_pend) .",
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

	public function elimina_solicitud($codigo){
		$sql = "UPDATE solicitudes SET estado = 'X'
				WHERE idsolicitud = '$codigo'";
		//echo $sql;			
		if ($this->db->simple_query($sql)){
        	return true; //Exito
		}else{
        	return false; //Error
		}
		
	}

	public function get_solicitudes($limit, $segmento){
		$sql = "SELECT s.idsolicitud, s.fecha_solicitud, 
				CASE WHEN s.servicio = 'IN' THEN 'INMEDIATO' ELSE 'NO INMEDIATO' END AS servicio,
				CASE WHEN s.tipo_mtto = 'P' THEN 'PREVENTIVO' ELSE 'CORRECTIVO' END AS tipo_mtto,
				CASE WHEN s.estado = 'P' THEN 'EN PROCESO' ELSE 'CERRADA' END AS estado,
				CASE WHEN s.estado = 'P' THEN 'warning' ELSE 'success' END AS color
				FROM solicitudes s
				WHERE s.estado <> 'X'
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
					CASE WHEN s.estado = 'P' THEN 'EN PROCESO' ELSE 'CERRADA' END AS estado,
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
					CASE WHEN s.estado = 'P' THEN 'EN PROCESO' ELSE 'CERRADA' END AS estado,
					s.idempleado, e.nombre, d.desc_departamento, s.idmaquina, m.desc_maquina, se.desc_seccion,
					p.desc_planta, s.orden_prod, s.detalle, 
					CASE 
					WHEN s.tipo_solucion = 'E' THEN 'ELECTRICO'
					WHEN s.tipo_solucion = 'M' THEN 'MECANICO'
					WHEN s.tipo_solucion = 'O' THEN 'OTROS'
					ELSE '' END AS tipo_solucion, s.dias_solucion AS dias,
					s.diagnostico, s.solucion, s.fecha_solucion, s.usuario_solucion, s.tecnico, s.pendiente, 
					CASE 
					WHEN s.estado_pendiente = 'P' THEN 'PENDIENTE' 
					WHEN s.estado_pendiente = 'C' THEN 'CUMPLIDA' 
					ELSE 'NO APLICA' END as estado_pendiente
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

	public function get_solicitudes_by_criterio($id, $fecsol, $estado, $servicio, $tipo, $idmaq){
		$sql = "SELECT s.idsolicitud, s.fecha_solicitud, 
				CASE WHEN s.servicio = 'IN' THEN 'INMEDIATO' ELSE 'NO INMEDIATO' END AS servicio,
				CASE WHEN s.tipo_mtto = 'P' THEN 'PREVENTIVO' ELSE 'CORRECTIVO' END AS tipo_mtto,
				CASE WHEN s.estado = 'P' THEN 'EN PROCESO' ELSE 'CERRADA' END AS estado,
				CASE WHEN s.estado = 'P' THEN 'warning' ELSE 'success' END AS color
				FROM solicitudes s
				WHERE s.estado <> 'X' ";

		if($id != ""){
			$sql .= " AND s.idsolicitud = ". $this->db->escape($id);
		}

		if($fecsol != ""){
			$sql .= " AND s.fecha_solicitud = ". $this->db->escape($fecsol);
		}

		if($estado != "0"){
			$sql .= " AND s.estado = ". $this->db->escape($estado);
		}

		if($servicio != "0"){
			$sql .= " AND s.servicio = ". $this->db->escape($servicio);
		}

		if($tipo != "0"){
			$sql .= " AND s.tipo_mtto = ". $this->db->escape($tipo);
		}

		if($idmaq != ""){
			$sql .= " AND s.idmaquina = ". $this->db->escape($idmaq);
		}

		$sql .=	" ORDER BY s.idsolicitud DESC ";

		//echo $sql;

		$res = $this->db->query($sql);
		return $res->result_array();
		
	}

}