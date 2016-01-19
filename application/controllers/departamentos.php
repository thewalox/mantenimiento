<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Departamentos extends CI_controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model("Departamentos_model");

		$this->load->library('form_validation');

	}

	function form_crear(){

		if (!$this->session->userdata('sess_id_user')) {
		   	redirect("login");
		}else{
			$datos["titulo"] = " .: Mantenimiento :.";

		    $this->load->view("header", $datos);
		    $this->load->view("departamentos/crear_departamentos", $datos);
		    $this->load->view("footer", $datos);
		    $this->load->view("fin", $datos);
		}
		
	}

	function crear_departamento(){
		$datos["titulo"] = " .: Mantenimiento :.";

		$this->form_validation->set_rules('descripcion', 'Descripcion', 'required');

		$this->form_validation->set_message('required','El campo %s es obligatorio');

	    if($this->form_validation->run()!=false){
			$datos["mensaje"] = $this->Departamentos_model->add_departamento($this->input->post("descripcion"));
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
			$config['base_url'] = base_url().'departamentos/form_buscar/';
			$config['total_rows'] = $this->Departamentos_model->get_total_departamentos();
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

			$datos["departamento"] = $this->Departamentos_model->get_departamentos($config['per_page'], $desde);

			$this->pagination->initialize($config);

		    $this->load->view("header", $datos);
		    $this->load->view("departamentos/buscar_departamento", $datos);
		    $this->load->view("footer", $datos);
		    $this->load->view("fin", $datos);
		}
		
	}

	function form_editar($id){

		if (!$this->session->userdata('sess_id_user')) {
		   	redirect("login");
		}else{
			$datos["titulo"] = " .: Mantenimiento :.";

			$datos["departamento"] = $this->Departamentos_model->get_departamento_by_id($id);
			//print_r($datos);

		    $this->load->view("header", $datos);
		    $this->load->view("departamentos/editar_departamento", $datos);
		    $this->load->view("footer", $datos);
		    $this->load->view("fin", $datos);
		}
		
	}

	function editar_departamento(){

		$this->form_validation->set_rules('codigo', 'Codigo', 'required');
		$this->form_validation->set_rules('descripcion', 'Descripcion', 'required');

		$this->form_validation->set_message('required','El campo %s es obligatorio');

	    if($this->form_validation->run()!=false){
			$datos["mensaje"] = $this->Departamentos_model->edit_departamento($this->input->post("codigo"), $this->input->post("descripcion"));
		}else{
			$datos["mensaje"] = validation_errors(); //incorrecto
		}

		echo json_encode($datos);

		//$this->form_editar($this->input->post("id"));	
	    
	}

	function eliminar_departamento($id){
		
		$datos["mensaje"] = $this->Departamentos_model->elimina_departamento($id);
		redirect('departamentos/form_buscar');
	}

	function get_departamentos_criterio(){
		$datos = $this->Departamentos_model->get_departamentos_by_criterio($this->input->get("filtro"));
		echo json_encode($datos);
	}

}