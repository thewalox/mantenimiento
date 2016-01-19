<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Consultas_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();		
	}

	public function filtra_facturas($estado, $tipodoc, $fecini, $fecfin, $fecenvio, $transp, $planilla){
		$sql = "SELECT docnum, cardname, itemcode, itemdesc, cantidad_real, city, slpname,
				CASE 
				estado_factura 
				WHEN '0' THEN 'Por Despachar'
				WHEN 'P' THEN 'Pendiente'
				WHEN 'OK' THEN 'Ok'
				END AS estado_factura 
				FROM log_facturas_sap
				WHERE empresa = '". $this->session->userdata('sess_empresa') ."'";
				

		if($estado != "ALL"){
			$sql .= " AND estado_factura = ". $this->db->escape($estado);
		}

		if($tipodoc != "0"){
			$sql .= " AND tipodoc = ". $this->db->escape($tipodoc);
		}

		if(! empty($fecini) and ! empty($fecfin)){
			$sql .= " AND docdate BETWEEN (". $this->db->escape($fecini) .") AND (". $this->db->escape($fecfin) .")";
		}

		if(! empty($fecenvio)){
			$sql .= " AND fecha_envio = ". $this->db->escape($fecenvio);
		}

		if($transp != "0"){
			$sql .= " AND transportador = ". $this->db->escape($transp);
		}

		if(! empty($planilla)){
			$sql .= " AND planilla = ". $this->db->escape($planilla);
		}

		$sql .= " ORDER BY docnum DESC, itemcode";

		//echo $sql;
		$res = $this->db->query($sql);
		return $res->result_array();
		
	}

}