<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gestion_model extends CI_Model
{
	var $mssql;

	public function __construct()
	{
		parent::__construct();

		if ($this->session->userdata('sess_empresa') == "PJ") {
			$this->mssql = $this->load->database('mssql_pj', TRUE );
		}else{
			$this->mssql = $this->load->database('mssql_ipc', TRUE );
		}
		
	}

	public function borrar_log_estado_importacion(){
		$sql = "DELETE FROM log_estado_importacion WHERE empresa = '". $this->session->userdata('sess_empresa') ."'";
		$this->db->simple_query($sql);
		
	}

	public function facturas_sap_by_fecha($fechaini, $fechafin){
		if ($this->session->userdata('sess_empresa') == "PJ") {

			$sql = "SELECT F.DocDate, F.DocNum, DF.LineNum, F.CardCode, F.CardName, DF.ItemCode,DF.Dscription,  DF.unitMsr AS UM, 
				DF.WhsCode, DF.Quantity, DF.VatSum AS 'Iva', (DF.Quantity * DF.Price)- DF.DiscPrcnt AS 'SubTotal',
				((DF.Quantity * DF.Price)- DF.DiscPrcnt) + DF.VatSum AS Total_neto, C.City, o.LicTradNum AS Nit, F.Address2,   
				DF.LineTotal AS Total_linea ,I.U_cu_pesuni * Quantity AS 'Total_Kilos', I.U_NormaReparto, o2.SlpName, 
				o3.Pager AS 'Centro_Costo', I.U_cu_kls_emp, I.U_cu_um_log, I.U_cu_volumen_m3
				FROM OINV F
				INNER JOIN CRD1 C ON C.Address = F.ShipToCode AND C.CardCode = F.CardCode
				INNER JOIN INV1 DF ON DF.DocEntry = F.DocEntry
				INNER JOIN OITM I ON I.ItemCode = DF.ItemCode
				INNER JOIN OCRD o ON o.CardCode = F.CardCode
				INNER JOIN OSLP o2 ON o2.SlpCode = o.SlpCode
				LEFT JOIN OHEM o3 ON o3.salesPrson = o2.SlpCode
				WHERE F.DocDate BETWEEN (". $this->db->escape($fechaini) .") AND (". $this->db->escape($fechafin) .") 
				AND (F.Series = 4) AND (C.AdresType = 'S')";
		}else{

			$sql = "SELECT F.DocDate, F.DocNum, DF.LineNum, F.CardCode, F.CardName, DF.ItemCode,DF.Dscription,  DF.unitMsr AS UM, 
				DF.WhsCode, DF.Quantity, DF.VatSum AS 'Iva', (DF.Quantity * DF.Price)- DF.DiscPrcnt AS 'SubTotal',
				((DF.Quantity * DF.Price)- DF.DiscPrcnt) + DF.VatSum AS Total_neto, C.City, o.LicTradNum AS Nit, F.Address2,   
				DF.LineTotal AS Total_linea ,I.U_cu_pesuni * Quantity AS 'Total_Kilos', '' AS U_NormaReparto, o2.SlpName, 
				o3.Pager AS 'Centro_Costo'
				FROM OINV F
				INNER JOIN CRD1 C ON C.Address = F.ShipToCode AND C.CardCode = F.CardCode
				INNER JOIN INV1 DF ON DF.DocEntry = F.DocEntry
				INNER JOIN OITM I ON I.ItemCode = DF.ItemCode
				INNER JOIN OCRD o ON o.CardCode = F.CardCode
				INNER JOIN OSLP o2 ON o2.SlpCode = o.SlpCode
				LEFT JOIN OHEM o3 ON o3.salesPrson = o2.SlpCode
				WHERE F.DocDate BETWEEN (". $this->db->escape($fechaini) .") AND (". $this->db->escape($fechafin) .") 
				AND (F.Series = 4) AND (C.AdresType = 'S')";
		}
		

		//echo $sql;

		$res = $this->mssql->query($sql);
		return $res->result_array();
		
	}

	public function entregas_sap_by_fecha($fechaini, $fechafin){
		if ($this->session->userdata('sess_empresa') == "PJ") {

			$sql = "SELECT O.DocDate, O.DocNum, D.LineNum, O.CardCode, O.CardName, D.ItemCode, D.Dscription, D.unitMsr AS UM,
				D.WhsCode, D.Quantity, D.VatSum AS 'Iva', (D.Quantity * D.Price) - D.DiscPrcnt AS 'SubTotal',
				((D.Quantity * D.Price)- D.DiscPrcnt) + D.VatSum AS Total_neto, C.City, O.LicTradNum AS Nit, O.Address2,
				D.LineTotal AS Total_linea, I.U_cu_pesuni * D.Quantity AS 'Total_Kilos', I.U_NormaReparto, O2.SlpName,
				O3.pager AS 'Centro_Costo', I.U_cu_kls_emp, I.U_cu_um_log, I.U_cu_volumen_m3
				FROM ODLN O
				INNER JOIN CRD1 C ON C.Address = O.ShipToCode AND C.CardCode = O.CardCode
				INNER JOIN DLN1 D ON D.DocEntry = O.DocEntry
				INNER JOIN OITM I ON I.ItemCode = D.ItemCode
				INNER JOIN OCRD OC ON OC.CardCode = O.CardCode
				INNER JOIN OSLP O2 ON O2.SlpCode = OC.SlpCode
				LEFT JOIN OHEM O3 ON O3.salesPrson = O2.SlpCode
				WHERE O.DocDate BETWEEN (". $this->db->escape($fechaini) .") AND (". $this->db->escape($fechafin) .") 
				AND (C.AdresType = 'S')";
		}else{

			$sql = "SELECT O.DocDate, O.DocNum, D.LineNum, O.CardCode, O.CardName, D.ItemCode, D.Dscription, D.unitMsr AS UM,
				D.WhsCode, D.Quantity, D.VatSum AS 'Iva', (D.Quantity * D.Price) - D.DiscPrcnt AS 'SubTotal',
				((D.Quantity * D.Price)- D.DiscPrcnt) + D.VatSum AS Total_neto, C.City, O.LicTradNum AS Nit, O.Address2,
				D.LineTotal AS Total_linea, I.U_cu_pesuni * D.Quantity AS 'Total_Kilos', '' AS U_NormaReparto, O2.SlpName,
				O3.pager AS 'Centro_Costo'
				FROM ODLN O
				INNER JOIN CRD1 C ON C.Address = O.ShipToCode AND C.CardCode = O.CardCode
				INNER JOIN DLN1 D ON D.DocEntry = O.DocEntry
				INNER JOIN OITM I ON I.ItemCode = D.ItemCode
				INNER JOIN OCRD OC ON OC.CardCode = O.CardCode
				INNER JOIN OSLP O2 ON O2.SlpCode = OC.SlpCode
				LEFT JOIN OHEM O3 ON O3.salesPrson = O2.SlpCode
				WHERE O.DocDate BETWEEN (". $this->db->escape($fechaini) .") AND (". $this->db->escape($fechafin) .") 
				AND (C.AdresType = 'S')";
		}
		

		//echo $sql;

		$res = $this->mssql->query($sql);
		return $res->result_array();
		
	}

	public function importar_documentos_sap($DocDate,$DocNum,$LineNum,$tipodoc,$CardCode,$CardName,$ItemCode,$Dscription,$um,$WhsCode,$Quantity,$Iva,
    $SubTotal,$Total_neto,$City,$Nit,$Address2,$Total_line,$total_kilos,$norma_reparto,$SlpName,$Centro_costo, $kilos, $um2, $volumen){

		$empresa = $this->session->userdata('sess_empresa');

    	$sql = "SELECT * 
    			FROM log_facturas_sap 
    			WHERE empresa = '$empresa' AND docdate = '$DocDate' AND docnum = '$DocNum' 
    			AND linenum = '$LineNum' AND tipodoc='$tipodoc'";

    	$res = $this->db->query($sql);

    	$num = $res->num_rows();	
    	
    	if ($num > 0) {
    		$sql = "INSERT INTO log_estado_importacion (empresa, docdate, docnum, linenum, tipodoc, itemcode, itemdesc, estado, mensaje)
					VALUES ('$empresa','$DocDate', '$DocNum', '$LineNum', '$tipodoc', '$ItemCode', '$Dscription', 'danger','Registro Duplicado')";

			$this->db->simple_query($sql);
    	}else{
    		$sql = "INSERT INTO log_facturas_sap (empresa, docdate, docnum, linenum, tipodoc, cardcode, cardname, itemcode, itemdesc, 
				um, whscode, quantity, iva, subtotal, total_neto, city, nit, address2, total_line, total_kilos, 
				norma_reparto, slpname, centro_costo, estado_factura, kilos_emp, um2, volumen_m3, cantidad_real)
				VALUES ('$empresa','$DocDate', '$DocNum', '$LineNum', '$tipodoc', '$CardCode', '$CardName', '$ItemCode', '$Dscription', 
				'$um', '$WhsCode', '$Quantity', '$Iva', '$SubTotal', '$Total_neto', '$City', '$Nit', '$Address2', 
				'$Total_line', '$total_kilos', '$norma_reparto', '$SlpName', 'centro_costo', '0', '$kilos','$um2','$volumen','$Quantity');";
		
			$this->db->simple_query($sql);

			$sql = "INSERT INTO log_estado_importacion (empresa, docdate, docnum, linenum, tipodoc, itemcode, itemdesc, estado, mensaje)
					VALUES ('$empresa','$DocDate', '$DocNum', '$LineNum', '$tipodoc', '$ItemCode', '$Dscription', 'success','Registro Exitoso')";

			$this->db->simple_query($sql);
        	
    	}		

	}

	public function get_resultado_importacion(){
		$sql = "SELECT * FROM log_estado_importacion WHERE empresa = '". $this->session->userdata('sess_empresa') ."'";
		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function get_facturas_top200($limit, $segmento){
		$sql = "SELECT DISTINCT docdate, docnum, tipodoc, cardcode, cardname 
				FROM log_facturas_sap
				WHERE empresa = '". $this->session->userdata('sess_empresa') ."'
				ORDER BY docdate DESC, docnum DESC ";

		if($limit != 0){
			$sql .= "LIMIT ". $segmento ." , ". $limit;
		}
		//echo $sql;
		$res = $this->db->query($sql);
		return $res->result_array();
		
	}

	function get_total_facturas(){
		$sql = "SELECT DISTINCT docdate, docnum, tipodoc, cardcode, cardname
				FROM log_facturas_sap 
				WHERE empresa = '". $this->session->userdata('sess_empresa') ."'";
		$res = $this->db->query($sql);
		
		return $res->num_rows();
  	}

  	public function get_factura_by_id($numero){
		$sql = "SELECT * 
				FROM log_facturas_sap 
				WHERE docnum = '$numero' AND empresa = '". $this->session->userdata('sess_empresa') ."'";
		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function edit_factura($factura, $transp, $fecenv, $horaenv, $plan, $guia, $placa, $valseg, $gastos, $tiposer, $estfac, $obs, $dev, $recib, $fecharec, $items, $fletes){
		$sql = "UPDATE log_facturas_sap SET transportador = ". $this->db->escape($transp) .", fecha_envio = ". $this->db->escape($fecenv) .
				", hora_envio = ". $this->db->escape($horaenv) .", planilla = UPPER(". $this->db->escape($plan) . "), 
				guia = UPPER(". $this->db->escape($guia) ."), placa = UPPER(". $this->db->escape($placa) . "), 
				valor_seguro = ". $this->db->escape($valseg) .", otros_gastos = ". $this->db->escape($gastos) .
				", tipo_servicio = ". $this->db->escape($tiposer) .", estado_factura = ". $this->db->escape($estfac) .
				", observacion = UPPER(". $this->db->escape($obs) ."), devolucion = UPPER(". $this->db->escape($dev) . "), 
				recibido_por = UPPER(". $this->db->escape($recib) . "), 
				fecha_recibido = ". $this->db->escape($fecharec) .
				"  WHERE docnum = '$factura' AND empresa = '". $this->session->userdata('sess_empresa') ."'";

		$this->db->simple_query($sql);

		foreach ($items as $item) {
			$sql = "UPDATE log_facturas_sap SET cantidad_real = ". $this->db->escape($item["cantidad"]) ." 
			WHERE docnum = '$factura' AND itemcode = ". $this->db->escape($item["itemcode"]) ." 
			AND empresa = '". $this->session->userdata('sess_empresa') ."'";

			if ($this->db->simple_query($sql)){
        		$mensaje =  2; //Exito
			}else{
	        	$mensaje = 3; //Error
			}
		}

		if (isset($fletes)) {
			foreach ($fletes as $flete) {
				$sql = "UPDATE log_facturas_sap SET valor_flete = ". $this->db->escape($flete["valor_flete"]) .",
				cod_tarifa = ". $this->db->escape($flete["cod_tarifa"]) ." 
				WHERE docnum = '$factura' AND itemcode = ". $this->db->escape($flete["itemcode"]) ." 
				AND empresa = '". $this->session->userdata('sess_empresa') ."'";
				//echo $sql;
				if ($this->db->simple_query($sql)){
	        		$mensaje =  2; //Exito
				}else{
		        	$mensaje = 3; //Error
				}
			}
		}
				
		return $mensaje;
	}

	public function edit_facturas_lote($where, $transp, $fecenv, $horaenv, $plan, $guia, $placa, $valseg, $gastos, $tiposer, $estfac, $obs){
		$sql = "UPDATE log_facturas_sap SET transportador = ". $this->db->escape($transp) .
				", fecha_envio = ". $this->db->escape($fecenv) .
				", hora_envio = ". $this->db->escape($horaenv) .", planilla = UPPER(". $this->db->escape($plan) . "), 
				guia = UPPER(". $this->db->escape($guia) ."), placa = UPPER(". $this->db->escape($placa) . "), 
				valor_seguro = ". $this->db->escape($valseg) .", otros_gastos = ". $this->db->escape($gastos) .
				", tipo_servicio = ". $this->db->escape($tiposer) .", estado_factura = ". $this->db->escape($estfac) .
				", observacion = UPPER(". $this->db->escape($obs) . ") " .
				$where;

		//echo($sql);
		if ($this->db->simple_query($sql)){
        	$mensaje =  2; //Exito
		}else{
        	$mensaje = 3; //Error
		}

		return $mensaje;
	}

	public function elimina_factura($codigo){
		$sql = "DELETE FROM log_facturas_sap WHERE docnum = '$codigo' AND empresa = '". $this->session->userdata('sess_empresa') ."'";
		//echo $sql;			
		if ($this->db->simple_query($sql)){
        	$mensaje =  2; //Exito
		}else{
        	$mensaje = 3; //Error
		}

		return $mensaje;
		
	}

	public function get_facturas_by_criterio($filtro){
		$sql = "SELECT DISTINCT docdate, docnum, tipodoc, cardcode, cardname 
				FROM log_facturas_sap
				WHERE (docdate LIKE '%". $filtro ."%'
				OR docnum LIKE '%". $filtro ."%' 
				OR cardcode LIKE '%". $filtro ."%' 
				OR cardname like '%". $filtro ."%') AND empresa = '". $this->session->userdata('sess_empresa') ."'
				ORDER BY docdate DESC, docnum DESC";
				//echo($sql);
		$res = $this->db->query($sql);
		return $res->result_array();
		
	}

	public function calcula_flete($numero){
		$sql = "SELECT lf.itemcode, lf.itemdesc, lf.um2, lf.volumen_m3, 
				IFNULL(CONCAT(lf.transportador, lf.city , lf.um2), 'No Existe Tarifa') AS cod_tarifa, 
				IFNULL(lt.valor,0) AS tarifa, IFNULL(lf.cantidad_real * lt.valor,0) AS subtotal
				FROM log_facturas_sap lf
				LEFT JOIN log_tarifas lt ON lt.cod_tarifa = CONCAT(transportador, city , um2)
				WHERE docnum = '$numero' AND empresa = '". $this->session->userdata('sess_empresa') ."'";
		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function tiene_flete($numero){
		$sql = "SELECT SUM(valor_flete) flete
				FROM log_facturas_sap 
				WHERE docnum = '$numero' AND empresa = '". $this->session->userdata('sess_empresa') ."'";
		$res = $this->db->query($sql);

		return $res->row();
	}

}