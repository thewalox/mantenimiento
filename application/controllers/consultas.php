<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Consultas extends CI_controller
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model("Consultas_model");
		$this->load->model("Transportadores_model");
		
	}

	function form_consulta_factura(){
		if (!$this->session->userdata('sess_id_user')) {
		   	redirect("login");
		}else{
			$datos["titulo"] = " .: Logic :.";

			$datos["transportadores"] = $this->Transportadores_model->get_transportadores(0, 0);

		    $this->load->view("header", $datos);
		    $this->load->view("consultas/filtrar_facturas", $datos);
		    $this->load->view("footer", $datos);
		    $this->load->view("fin", $datos);
		}
	}

	function filtrar_facturas(){
		$datos = $this->Consultas_model->filtra_facturas($this->input->post("estado"), $this->input->post("tipo"),$this->input->post("fecini"), $this->input->post("fecfin"), $this->input->post("fecenvio"), $this->input->post("transp"), $this->input->post("planilla"));
		echo json_encode($datos);
	}

}