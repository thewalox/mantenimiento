<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Plantas_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public function get_plantas(){
		$sql = "SELECT *
				FROM plantas
				WHERE estado = 'A'";

		
		//echo $sql;

		$res = $this->db->query($sql);
		return $res->result_array();
		
	}


}