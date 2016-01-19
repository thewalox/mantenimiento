<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empleados extends CI_controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model("Empleados_model");
		$this->load->model("Departamentos_model");

		$this->load->library('form_validation');

	}

	function form_crear(){

		if (!$this->session->userdata('sess_id_user')) {
		   	redirect("login");
		}else{
			$datos["titulo"] = " .: Mantenimiento :.";

			$datos["departamento"] = $this->Departamentos_model->get_departamentos(0, 0);

		    $this->load->view("header", $datos);
		    $this->load->view("empleados/crear_empleados", $datos);
		    $this->load->view("footer", $datos);
		    $this->load->view("fin", $datos);
		}
		
	}

	function crear_empleado(){
		$datos["titulo"] = " .: Mantenimiento :.";

		$this->form_validation->set_rules('cedula', 'Cedula', 'required');
		$this->form_validation->set_rules('nombre', 'Nombre', 'required');

		$this->form_validation->set_rules('dep', 'Departamento', 'required|callback_check_default');

		$this->form_validation->set_message('required','El campo %s es obligatorio');
		$this->form_validation->set_message('check_default','Seleccione un valor para el campo %s');

	    if($this->form_validation->run()!=false){
			$datos["mensaje"] = $this->Empleados_model->add_empleado($this->input->post("cedula"), $this->input->post("nombre"), $this->input->post("dep"));
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
			$config['base_url'] = base_url().'empleados/form_buscar/';
			$config['total_rows'] = $this->Empleados_model->get_total_empleados();
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

			$datos["empleado"] = $this->Empleados_model->get_empleados($config['per_page'], $desde);

			$this->pagination->initialize($config);

		    $this->load->view("header", $datos);
		    $this->load->view("empleados/buscar_empleado", $datos);
		    $this->load->view("footer", $datos);
		    $this->load->view("fin", $datos);
		}
		
	}

	function form_editar($id){

		if (!$this->session->userdata('sess_id_user')) {
		   	redirect("login");
		}else{
			$datos["titulo"] = " .: Mantenimiento :.";

			$datos["empleado"] = $this->Empleados_model->get_empleado_by_id($id);
			$datos["departamento"] = $this->Departamentos_model->get_departamentos(0, 0);
			//print_r($datos);

		    $this->load->view("header", $datos);
		    $this->load->view("empleados/editar_empleado", $datos);
		    $this->load->view("footer", $datos);
		    $this->load->view("fin", $datos);
		}
		
	}

	function editar_empleado(){

		$this->form_validation->set_rules('cedula', 'Cedula', 'required');
		$this->form_validation->set_rules('nombre', 'Nombre', 'required');

		$this->form_validation->set_rules('dep', 'Departamento', 'required|callback_check_default');

		$this->form_validation->set_message('required','El campo %s es obligatorio');
		$this->form_validation->set_message('check_default','Seleccione un valor para el campo %s');

	    if($this->form_validation->run()!=false){
			$datos["mensaje"] = $this->Empleados_model->edit_empleado($this->input->post("cedula"), $this->input->post("nombre"), $this->input->post("dep"));
		}else{
			$datos["mensaje"] = validation_errors(); //incorrecto
		}

		echo json_encode($datos);

		//$this->form_editar($this->input->post("id"));	
	    
	}

	function eliminar_empleado($id){
		
		$datos["mensaje"] = $this->Empleados_model->elimina_empleado($id);
		redirect('empleados/form_buscar');
	}

	function get_empleados_criterio(){

		//se valida la variable get term para las busquedas que se realizan a traves de jquey UI

		if (isset($_GET['term'])) {
			$filtro = $_GET['term'];
		}else{
			$filtro = $this->input->get("filtro");
		}

		$datos = $this->Empleados_model->get_empleados_by_criterio($filtro);

		if (isset($_GET['term'])) {
			
			foreach ($datos as $dato) {
				$new_row['label']=htmlentities(stripslashes($dato['nombre']));
				$new_row['value']=htmlentities(stripslashes($dato['idempleado']));
				$new_row['dpto']=htmlentities(stripslashes($dato['desc_departamento']));
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