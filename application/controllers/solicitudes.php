<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Solicitudes extends CI_controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model("Solicitudes_model");
		$this->load->model("Maquinas_model");
		$this->load->model("Empleados_model");

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
			$datos["tecnicos"] = $this->Empleados_model->get_tecnicos();
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
		$this->form_validation->set_rules('tecnico', 'Tecnico', 'required|callback_check_default');

		$this->form_validation->set_message('required','El campo %s es obligatorio');
		$this->form_validation->set_message('check_default','Seleccione un valor para el campo %s');

		if ($this->input->post("pendiente") == "") {
			$estado_pendiente = "N";
		}else{
			$estado_pendiente = "P";
		}

	    if($this->form_validation->run()!=false){
			$datos["mensaje"] = $this->Solicitudes_model->cerrar_solicitud($this->input->post("id"), $this->input->post("usuario"), $this->input->post("tiposol"), $this->input->post("dias"), $this->input->post("diagnostico"), $this->input->post("solucion"), $this->input->post("tecnico"), $this->input->post("pendiente"), $estado_pendiente);
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

	function eliminar_solicitud($id){
		
		$datos["mensaje"] = $this->Solicitudes_model->elimina_solicitud($id);
		redirect('solicitudes/form_buscar');
	}

	function get_solicitudes_criterio(){
		$datos = $this->Solicitudes_model->get_solicitudes_by_criterio($this->input->get("id"), $this->input->get("fecsol"), $this->input->get("estado"), $this->input->get("servicio"), $this->input->get("tipo"), $this->input->get("idmaq"));
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
            //Se agrega un salto de linea
            $this->pdf->Ln(7);
            $this->pdf->Cell(180,7, 'Tarea Pendiente','',0,'L',0);
            $this->pdf->Ln(7);
            $this->pdf->MultiCell(180,5,utf8_decode($solicitud->pendiente), 1);
            //Se agrega un salto de linea
            $this->pdf->Ln(7);
            $this->pdf->Cell(90,7, 'Estado Tarea: '. $solicitud->estado_pendiente,'',0,'L',0);
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

	function form_buscar_tareas(){

		if (!$this->session->userdata('sess_id_user')) {
		   	redirect("login");
		}else{
			$this->load->library('pagination');

			/*Se personaliza la paginación para que se adapte a bootstrap*/
			$config['base_url'] = base_url().'solicitudes/form_buscar_tareas/';
			$config['total_rows'] = $this->Solicitudes_model->get_total_pendientes();
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

			$datos["pendientes"] = $this->Solicitudes_model->get_pendientes($config['per_page'], $desde);

			$this->pagination->initialize($config);

		    $this->load->view("header", $datos);
		    $this->load->view("solicitudes/buscar_pendiente", $datos);
		    $this->load->view("footer", $datos);
		    $this->load->view("fin", $datos);
		}
		
	}

	function get_pendientes_criterio(){
		$datos = $this->Solicitudes_model->get_pendientes_by_criterio($this->input->get("id"), $this->input->get("fecsol"), $this->input->get("idmaq"));
		echo json_encode($datos);
	}

	function form_editar_pendientes($id){

		if (!$this->session->userdata('sess_id_user')) {
		   	redirect("login");
		}else{
			$datos["titulo"] = " .: Mantenimiento :.";

			$datos["pendiente"] = $this->Solicitudes_model->get_pendientes_by_id($id);
			
		    $this->load->view("header", $datos);
		    $this->load->view("Solicitudes/editar_pendientes", $datos);
		    $this->load->view("footer", $datos);
		    $this->load->view("fin", $datos);
		}
		
	}

	function cerrar_pendiente(){
		$datos["mensaje"] = $this->Solicitudes_model->cerrar_pendiente($this->input->get("id"));
		echo json_encode($datos);
	}

	function exportar(){
		$this->load->library("PHPExcel");
		$objPHPExcel = new PHPExcel();

		$objPHPExcel->setActiveSheetIndex(0);
        //name the worksheet
        $objPHPExcel->getActiveSheet()->setTitle('Solicitudes');
        //set cell A1 content with some text
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Reporte de Solicitudes');
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Id');
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Fecha');
        $objPHPExcel->getActiveSheet()->setCellValue('C3', 'Servicio');
        $objPHPExcel->getActiveSheet()->setCellValue('D3', 'Tipo Mantenimiento');
        $objPHPExcel->getActiveSheet()->setCellValue('E3', 'Estado');
        $objPHPExcel->getActiveSheet()->setCellValue('F3', 'Evento');
        $objPHPExcel->getActiveSheet()->setCellValue('G3', 'Id Maquina');
        $objPHPExcel->getActiveSheet()->setCellValue('H3', 'Desc. Maquina');
        $objPHPExcel->getActiveSheet()->setCellValue('I3', 'Detalle');
        //merge cell A1 until C1
        $objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
        //set aligment to center for that merged cell (A1 to C1)
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //make the font become bold
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('E3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('F3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('G3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('H3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('I3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');

       	for($col = ord('A'); $col <= ord('H'); $col++){
        	//set column dimension
            $objPHPExcel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
            //change the font size
            $objPHPExcel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
                 
            $objPHPExcel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }
                //retrive contries table data
        $solicitudes = $this->Solicitudes_model->get_solicitudes(0, 0);
        $exceldata="";

        foreach ($solicitudes as $sol){
        	$exceldata[] = $sol;
        }
        
        //Fill data 
        $objPHPExcel->getActiveSheet()->fromArray($exceldata, null, 'A4');
                 
        $objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                 
        $filename='Solicitudes.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
 
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
	}

	function check_default($valor_post){
		if($valor_post == '0'){ 
      		return FALSE;
    	}else{
  			return TRUE;
  		}
	}

}