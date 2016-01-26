<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maquinas extends CI_controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model("Maquinas_model");
		$this->load->model("Secciones_model");

		$this->load->library('form_validation');

	}

	function form_crear(){

		if (!$this->session->userdata('sess_id_user')) {
		   	redirect("login");
		}else{
			$datos["titulo"] = " .: Mantenimiento :.";

			$datos["seccion"] = $this->Secciones_model->get_secciones(0,0);

		    $this->load->view("header", $datos);
		    $this->load->view("maquinas/crear_maquinas", $datos);
		    $this->load->view("footer", $datos);
		    $this->load->view("fin", $datos);
		}
		
	}

	function crear_maquina(){
		$datos["titulo"] = " .: Mantenimiento :.";

		$this->form_validation->set_rules('codigo', 'Codigo', 'required');
		$this->form_validation->set_rules('desc', 'Descripcion', 'required');

		$this->form_validation->set_rules('seccion', 'Seccion', 'required|callback_check_default');

		$this->form_validation->set_message('required','El campo %s es obligatorio');
		$this->form_validation->set_message('check_default','Seleccione un valor para el campo %s');

	    if($this->form_validation->run()!=false){
			$datos["mensaje"] = $this->Maquinas_model->add_maquina($this->input->post("codigo"), $this->input->post("desc"), $this->input->post("seccion"), $this->input->post("marca"), $this->input->post("modelo"), $this->input->post("serial"));
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
			$config['base_url'] = base_url().'maquinas/form_buscar/';
			$config['total_rows'] = $this->Maquinas_model->get_total_maquinas();
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

			$datos["maquina"] = $this->Maquinas_model->get_maquinas($config['per_page'], $desde);

			$this->pagination->initialize($config);

		    $this->load->view("header", $datos);
		    $this->load->view("maquinas/buscar_maquina", $datos);
		    $this->load->view("footer", $datos);
		    $this->load->view("fin", $datos);
		}
		
	}

	function form_editar($id){

		if (!$this->session->userdata('sess_id_user')) {
		   	redirect("login");
		}else{
			$datos["titulo"] = " .: Mantenimiento :.";

			$datos["maquina"] = $this->Maquinas_model->get_maquina_by_id($id);
			$datos["seccion"] = $this->Secciones_model->get_secciones(0,0);
			//print_r($datos);

		    $this->load->view("header", $datos);
		    $this->load->view("maquinas/editar_maquina", $datos);
		    $this->load->view("footer", $datos);
		    $this->load->view("fin", $datos);
		}
		
	}

	function editar_maquina(){

		$this->form_validation->set_rules('codigo', 'Codigo', 'required');
		$this->form_validation->set_rules('desc', 'Descripcion', 'required');

		$this->form_validation->set_rules('seccion', 'Seccion', 'required|callback_check_default');

		$this->form_validation->set_message('required','El campo %s es obligatorio');
		$this->form_validation->set_message('check_default','Seleccione un valor para el campo %s');

	    if($this->form_validation->run()!=false){
			$datos["mensaje"] = $this->Maquinas_model->edit_maquina($this->input->post("codigo"), $this->input->post("desc"), $this->input->post("seccion"), $this->input->post("marca"), $this->input->post("modelo"), $this->input->post("serial"));
		}else{
			$datos["mensaje"] = validation_errors(); //incorrecto
		}

		echo json_encode($datos);

		//$this->form_editar($this->input->post("id"));	
	    
	}

	function eliminar_maquina($id){
		
		$datos["mensaje"] = $this->Maquinas_model->elimina_maquina($id);
		redirect('maquinas/form_buscar');
	}

	function get_maquinas_criterio(){

		//se valida la variable get term para las busquedas que se realizan a traves de jquey UI

		if (isset($_GET['term'])) {
			$filtro = $_GET['term'];
		}else{
			$filtro = $this->input->get("filtro");
		}

		$datos = $this->Maquinas_model->get_maquinas_by_criterio($filtro);

		if (isset($_GET['term'])) {
			
			foreach ($datos as $dato) {
				$new_row['label']=htmlentities(stripslashes($dato['desc_maquina']));
				$new_row['value']=htmlentities(stripslashes($dato['idmaquina']));
				$new_row['seccion']=htmlentities(stripslashes($dato['desc_seccion']));
				$row_set[] = $new_row; //build an array
			}
		
			echo json_encode($row_set);

		}else{
			
			echo json_encode($datos);
		}
	}

	function check_default($valor_post){
		if($valor_post == '0'){ 
      		return FALSE;
    	}else{
  			return TRUE;
  		}
	}

}