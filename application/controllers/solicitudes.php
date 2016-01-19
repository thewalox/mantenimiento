<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Solicitudes extends CI_controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model("Solicitudes_model");
		$this->load->model("Maquinas_model");

		$this->load->library('form_validation');
		$this->load->library('pdf');

	}

	function form_crear(){

		
			$datos["titulo"] = " .: Mantenimiento :.";

			$datos["maquina"] = $this->Maquinas_model->get_maquinas(0,0);

		    $this->load->view("header", $datos);
		    $this->load->view("solicitudes/crear_solicitudes", $datos);
		    $this->load->view("footer", $datos);
		    $this->load->view("fin", $datos);
		
		
	}

	function crear_solicitud(){
		$datos["titulo"] = " .: Mantenimiento :.";

		$this->form_validation->set_rules('fecdoc', 'fecha de la Solicitud', 'required');
		$this->form_validation->set_rules('cedula', 'Cedula del Solicitante', 'required');
		$this->form_validation->set_rules('detalle', 'Detalle', 'required');

		$this->form_validation->set_rules('servicio', 'Caracter del Servicio', 'required|callback_check_default');
		$this->form_validation->set_rules('tipo', 'Tipo de Mantenimiento', 'required|callback_check_default');

		$this->form_validation->set_message('required','El campo %s es obligatorio');
		$this->form_validation->set_message('check_default','Seleccione un valor para el campo %s');

	    if($this->form_validation->run()!=false){
			$datos["mensaje"] = $this->Solicitudes_model->add_solicitud($this->input->post("fecdoc"), $this->input->post("cedula"), $this->input->post("servicio"), $this->input->post("tipo"), $this->input->post("maquina"), $this->input->post("orden"), $this->input->post("detalle"));
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
			$config['base_url'] = base_url().'solicitudes/form_buscar/';
			$config['total_rows'] = $this->Solicitudes_model->get_total_solicitudes();
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

			$datos["solicitud"] = $this->Solicitudes_model->get_solicitudes($config['per_page'], $desde);

			$this->pagination->initialize($config);

		    $this->load->view("header", $datos);
		    $this->load->view("solicitudes/buscar_solicitud", $datos);
		    $this->load->view("footer", $datos);
		    $this->load->view("fin", $datos);
		}
		
	}

	function form_editar($id){

		if (!$this->session->userdata('sess_id_user')) {
		   	redirect("login");
		}else{
			$datos["titulo"] = " .: Mantenimiento :.";

			$datos["solicitud"] = $this->Solicitudes_model->get_solicitud_by_id($id, 1);
			//$datos["seccion"] = $this->Secciones_model->get_secciones(0,0);
			//print_r($datos);

		    $this->load->view("header", $datos);
		    $this->load->view("Solicitudes/editar_solicitud", $datos);
		    $this->load->view("footer", $datos);
		    $this->load->view("fin", $datos);
		}
		
	}

	function cerrar_solicitud(){

		$this->form_validation->set_rules('diagnostico', 'Diagnostico', 'required');
		$this->form_validation->set_rules('solucion', 'Solucion', 'required');

		$this->form_validation->set_rules('tiposol', 'Tipo de Solucion', 'required|callback_check_default');

		$this->form_validation->set_message('required','El campo %s es obligatorio');
		$this->form_validation->set_message('check_default','Seleccione un valor para el campo %s');

	    if($this->form_validation->run()!=false){
			$datos["mensaje"] = $this->Solicitudes_model->cerrar_solicitud($this->input->post("id"), $this->input->post("usuario"), $this->input->post("tiposol"), $this->input->post("dias"), $this->input->post("diagnostico"), $this->input->post("solucion"));
		}else{
			$datos["mensaje"] = validation_errors(); //incorrecto
		}

		echo json_encode($datos);

		//$this->form_editar($this->input->post("id"));	
	    
	}

	function form_ver($id){

		if (!$this->session->userdata('sess_id_user')) {
		   	redirect("login");
		}else{
			$datos["titulo"] = " .: Mantenimiento :.";

			$datos["solicitud"] = $this->Solicitudes_model->get_solicitud_by_id($id, 0);
			//$datos["seccion"] = $this->Secciones_model->get_secciones(0,0);
			//print_r($datos);

		    $this->load->view("header", $datos);
		    $this->load->view("solicitudes/ver_solicitud", $datos);
		    $this->load->view("footer", $datos);
		    $this->load->view("fin", $datos);
		}
		
	}

	function eliminar_maquina($id){
		
		$datos["mensaje"] = $this->Solicitudes_model->elimina_maquina($id);
		redirect('Solicitudes/form_buscar');
	}

	function get_solicitudes_criterio(){
		$datos = $this->Solicitudes_model->get_solicitudes_by_criterio($this->input->get("filtro"));
		echo json_encode($datos);
	}

	function imprimir_solicitud($id){
		$solicitud = $this->Solicitudes_model->get_solicitud_by_id($id, 0);

		// Creacion del PDF
 
        /*
         * Se crea un objeto de la clase Pdf, recuerda que la clase Pdf
         */
        $this->pdf = new Pdf();
        // Agregamos una página
        $this->pdf->AddPage();
        // Define el alias para el número de página que se imprimirá en el pie
        $this->pdf->AliasNbPages();
 
        /* Se define el titulo, márgenes izquierdo, derecho y
         * el color de relleno predeterminado
         */
        $this->pdf->SetTitle("Solicitud de Mantenimiento # ". $solicitud->idsolicitud);
        $this->pdf->SetLeftMargin(15);
        $this->pdf->SetRightMargin(15);
        $this->pdf->SetFillColor(200,200,200);
 
        // Se define el formato de fuente: Arial, negritas, tamaño 9
        $this->pdf->SetFont('Arial', 'B', 9);
        /*
         * TITULOS DE COLUMNAS
         *
         * $this->pdf->Cell(Ancho, Alto,texto,borde,posición,alineación,relleno);
         */
 		$this->pdf->Cell(90,7,'Solicitud N: '. $solicitud->idsolicitud,'TBL',0,'L','1');
 		$this->pdf->Cell(90,7,'','TBR',0,'C','1');
 		$this->pdf->Ln(10);
        /*$this->pdf->Cell(15,7,'NUM','TBL',0,'C','1');
        $this->pdf->Cell(25,7,'PATERNO','TB',0,'L','1');
        $this->pdf->Cell(25,7,'MATERNO','TB',0,'L','1');
        $this->pdf->Cell(25,7,'NOMBRE','TB',0,'L','1');
        $this->pdf->Cell(40,7,'FECHA DE NACIMIENTO','TB',0,'C','1');
        $this->pdf->Cell(25,7,'GRADO','TB',0,'L','1');
        $this->pdf->Cell(25,7,'GRUPO','TBR',0,'C','1');
        $this->pdf->Ln(7);*/
        // La variable $x se utiliza para mostrar un número consecutivo


            $this->pdf->Cell(90,7, 'Fecha: '. $solicitud->fecha_solicitud,'',0,'L',0);
            $this->pdf->Cell(45,7, 'O.P : '. $solicitud->orden_prod,'',0,'L',0);
            $this->pdf->Cell(45,7, 'Estado: '. $solicitud->estado,'',0,'L',0);
            //Se agrega un salto de linea
            $this->pdf->Ln(7);
            $this->pdf->Cell(90,7, 'Maquina: '. $solicitud->idmaquina .' - '. $solicitud->desc_maquina,'',0,'L',0);
            $this->pdf->Cell(45,7, 'Seccion: '. $solicitud->desc_seccion,'',0,'L',0);
            $this->pdf->Cell(45,7, 'Planta: '. $solicitud->desc_planta,'',0,'L',0);
            //Se agrega un salto de linea
            $this->pdf->Ln(7);
            $this->pdf->Cell(90,7, 'Solicitante: '. $solicitud->idempleado .' - '. $solicitud->nombre,'',0,'L',0);
            $this->pdf->Cell(90,7, 'Dpto: '. $solicitud->desc_departamento,'',0,'L',0);
            //Se agrega un salto de linea
            $this->pdf->Ln(7);
            $this->pdf->Cell(90,7, 'Tipo Mtto: '. $solicitud->tipo_mtto,'',0,'L',0);
            $this->pdf->Cell(90,7, 'Tipo Servicio: '. $solicitud->servicio,'',0,'L',0);
            $this->pdf->Ln(7);
            $this->pdf->Cell(180,7, 'Detalle','',0,'L',0);
            $this->pdf->Ln(7);
            $this->pdf->MultiCell(180,5,utf8_decode($solicitud->detalle), 1);
            //Se agrega un salto de linea
            $this->pdf->Ln(7);
            //Solucion
            $this->pdf->Cell(90,7,'Solucion','TBL',0,'L','1');
	 		$this->pdf->Cell(90,7,'','TBR',0,'C','1');
	 		$this->pdf->Ln(10);
            $this->pdf->Cell(90,7, 'Fecha Solucion: '. $solicitud->fecha_solucion,'',0,'L',0);
            $this->pdf->Cell(45,7, 'Tipo Solucion : '. $solicitud->tipo_solucion,'',0,'L',0);
            $this->pdf->Cell(45,7, 'Dias: '. $solicitud->dias,'',0,'R',0);
            //Se agrega un salto de linea
            $this->pdf->Ln(7);
            $this->pdf->Cell(180,7, 'Diagnostico','',0,'L',0);
            $this->pdf->Ln(7);
            $this->pdf->MultiCell(180,5,utf8_decode($solicitud->diagnostico), 1);
            //Se agrega un salto de linea
            $this->pdf->Ln(7);
            $this->pdf->Cell(180,7, 'Solucion','',0,'L',0);
            $this->pdf->Ln(7);
            $this->pdf->MultiCell(180,5,utf8_decode($solicitud->solucion), 1);
            /*$this->pdf->Cell(25,7,$solicitud->servicio,'B',0,'L',0);
            $this->pdf->Cell(40,7,$solicitud->tipo_mtto,'B',0,'C',0);
            $this->pdf->Cell(25,7,$solicitud->estado,'B',0,'L',0);
            $this->pdf->Cell(25,7,$solicitud->idempleado,'BR',0,'C',0);*/
            
        
        /*
         * Se manda el pdf al navegador
         *
         * $this->pdf->Output(nombredelarchivo, destino);
         *
         * I = Muestra el pdf en el navegador
         * D = Envia el pdf para descarga
         *
         */
        $this->pdf->Output("Solicitud de Mantenimiento.pdf", 'I');
	}

	function check_default($valor_post){
		if($valor_post == '0'){ 
      		return FALSE;
    	}else{
  			return TRUE;
  		}
	}

}