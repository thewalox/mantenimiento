<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Secciones extends CI_controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model("Secciones_model");
		$this->load->model("Plantas_model");

		$this->load->library('form_validation');

	}

	function form_crear(){

		if (!$this->session->userdata('sess_id_user')) {
		   	redirect("login");
		}else{
			$datos["titulo"] = " .: Mantenimiento :.";

			$datos["planta"] = $this->Plantas_model->get_plantas();

		    $this->load->view("header", $datos);
		    $this->load->view("secciones/crear_secciones", $datos);
		    $this->load->view("footer", $datos);
		    $this->load->view("fin", $datos);
		}
		
	}

	function crear_seccion(){
		$datos["titulo"] = " .: Mantenimiento :.";

		$this->form_validation->set_rules('desc', 'Descripcion', 'required');

		$this->form_validation->set_rules('planta', 'Planta', 'required|callback_check_default');

		$this->form_validation->set_message('required','El campo %s es obligatorio');
		$this->form_validation->set_message('check_default','Seleccione un valor para el campo %s');

	    if($this->form_validation->run()!=false){
			$datos["mensaje"] = $this->Secciones_model->add_seccion($this->input->post("desc"), $this->input->post("planta"));
		}else{
			$datos["mensaje"] = validation_errors(); //incorrecto
		}

		echo json_encode($datos);
		
	}

	function form_buscar(){

		if (!$this->session->userdata('sess_id_user')) {
		   	redirect("login");
		}else{
			$this->load->library('pagination');

			/*Se personaliza la paginación para que se adapte a bootstrap*/
			$config['base_url'] = base_url().'secciones/form_buscar/';
			$config['total_rows'] = $this->Secciones_model->get_total_secciones();
			$config['per_page'] = 10;
			$desde = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		    $config['cur_tag_open'] = '<li class="active"><a href="#">';
		    $config['cur_tag_close'] = '</a></li>';
		    $config['num_tag_open'] = '<li>';
		    $config['num_tag_close'] = '</li>';
		    $config['last_link'] = FALSE;
		    $config['first_link'] = FALSE;
		    $config['next_link'] = '&raquo;';
		    $config['next_tag_open'] = '<li>';
		    $config['next_tag_close'] = '</li>';
		    $config['prev_link'] = '&laquo;';
		    $config['prev_tag_open'] = '<li>';
		    $config['prev_tag_close'] = '</li>';

			$datos["titulo"] = " .: Mantenimiento :.";

			$datos["seccion"] = $this->Secciones_model->get_secciones($config['per_page'], $desde);

			$this->pagination->initialize($config);

		    $this->load->view("header", $datos);
		    $this->load->view("secciones/buscar_seccion", $datos);
		    $this->load->view("footer", $datos);
		    $this->load->view("fin", $datos);
		}
		
	}

	function form_editar($id){

		if (!$this->session->userdata('sess_id_user')) {
		   	redirect("login");
		}else{
			$datos["titulo"] = " .: Mantenimiento :.";

			$datos["seccion"] = $this->Secciones_model->get_seccion_by_id($id);
			$datos["planta"] = $this->Plantas_model->get_plantas();
			//print_r($datos);

		    $this->load->view("header", $datos);
		    $this->load->view("secciones/editar_seccion", $datos);
		    $this->load->view("footer", $datos);
		    $this->load->view("fin", $datos);
		}
		
	}

	function editar_seccion(){

		$this->form_validation->set_rules('codigo', 'Codigo', 'required');
		$this->form_validation->set_rules('desc', 'Descripcion', 'required');

		$this->form_validation->set_rules('planta', 'Planta', 'required|callback_check_default');

		$this->form_validation->set_message('required','El campo %s es obligatorio');
		$this->form_validation->set_message('check_default','Seleccione un valor para el campo %s');

	    if($this->form_validation->run()!=false){
			$datos["mensaje"] = $this->Secciones_model->edit_seccion($this->input->post("codigo"), $this->input->post("desc"), $this->input->post("planta"));
		}else{
			$datos["mensaje"] = validation_errors(); //incorrecto
		}

		echo json_encode($datos);

		//$this->form_editar($this->input->post("id"));	
	    
	}

	function eliminar_seccion($id){
		
		$datos["mensaje"] = $this->Secciones_model->elimina_seccion($id);
		redirect('secciones/form_buscar');
	}

	function get_secciones_criterio(){
		$datos = $this->Secciones_model->get_secciones_by_criterio($this->input->get("filtro"));
		echo json_encode($datos);
	}

	function check_default($valor_post){
		if($valor_post == '0'){ 
      		return FALSE;
    	}else{
  			return TRUE;
  		}
	}

}