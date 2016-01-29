<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EnviarCorreos extends CI_controller
{
	
	public function __construct(){
		parent::__construct();
		$this->load->library("email");
	}

	public function send_correo_solicitud(){
		 
		$configGmail = array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.gmail.com',
			'smtp_port' => 465,
			'smtp_user' => 'info@pjsas.co',
			'smtp_pass' => 'informacion12345',
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n"
		); 

		$html = "<h3>Solicitud de Mantenimiento N ". $this->input->get("id") ."</h3><br>";
		$html .= "<p><strong>Solicitante:</strong> ". $this->input->get("solicita") ."</p><br>";
		$html .= "<p><strong>Detalle:</strong> ". $this->input->get("detalle") ."</p><br>";
 
		//cargamos la configuración para enviar con gmail
		$this->email->initialize($configGmail);
 
		$this->email->from('info@pjsas.co');
		$this->email->to("sistemas@pjsas.co,mantenimiento@pjsas.co,asistente_mantenimiento@ipcaribe.com");
		$this->email->subject('Nueva solicitud de Mantenimiento # '. $this->input->get("id"));
		$this->email->message($html);
		$this->email->send();
		//con esto podemos ver el resultado
		//var_dump($this->email->print_debugger());
	}

}