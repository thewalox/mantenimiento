<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model("Usuarios_model");
		$this->load->library('form_validation');
	}

	function index(){
		$datos["titulo"] = " .: Mantenimiento :.";
		
		if ($this->session->userdata('sess_id_user')) {
		   	redirect("home");
		}else{
			$this->load->view("login", $datos);	
			//print_r($this->session->all_userdata());
		} 
	    
	}

	function validar_usuario(){
		if (isset($_POST["clave"])) {
			//print_r($_POST);
			$res = $this->Usuarios_model->login($this->input->post("usuario"), $this->input->post("clave"));
			
			if($res){
				$sesiones = array();
				$sesiones["sess_id_user"] = $res->login;
				$sesiones["sess_name_user"] = $res->nombre_completo;
				$sesiones["sess_perfil"] = $res->perfil;
				$this->session->set_userdata($sesiones);
				echo "ok";
			}else{
				echo "error";
			}
		}
	}

	function form_cambio_clave(){
		$datos["titulo"] = " .: Mantenimiento :.";
		
		if (!$this->session->userdata('sess_id_user')) {
		   redirect("login");
		}else{
			$this->load->view("header", $datos);
			$this->load->view("cambiar_clave", $datos);	
			$this->load->view("footer", $datos);
		    $this->load->view("fin", $datos);
		}
	}

	function cambiar_clave(){
		$this->form_validation->set_rules('clavenueva', 'Clave Nueva', 'required|min_length[5]|max_length[10]');
		$this->form_validation->set_rules('clavenuevaconf', 'Confirmacion Clave Nueva', 'required|min_length[5]|max_length[10]|matches[clavenueva]');

		$this->form_validation->set_message('required','El campo %s es obligatorio');
		$this->form_validation->set_message('min_length','La longitud del campo %s no puede ser menor a %s caracteres');
		$this->form_validation->set_message('max_length','La longitud del campo %s no puede ser mayor a %s caracteres');
		$this->form_validation->set_message('matches','El campo %s no coincide con %s');

	    if($this->form_validation->run()!=false){
			$datos["mensaje"] = $this->Usuarios_model->edit_clave($this->input->post("claveencrypt"), $this->input->post("usuario"));
			//$datos["mensaje"] = 'ok';
		}else{
			$datos["mensaje"] = validation_errors(); //incorrecto
		}

		echo json_encode($datos);
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect("login");
	}

}