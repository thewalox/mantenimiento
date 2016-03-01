<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_model extends CI_Model{

	public function __construct()
	{
		parent::__construct();
	}

	public function login($user, $pass){
		$sql = "SELECT * FROM usuarios WHERE login = ". $this->db->escape($user) ." 
				AND pass = ". $this->db->escape(md5($pass)) ." and estado = 'A'";
		//echo $sql;		
		$res = $this->db->query($sql);
		return $res->row();
	}

	public function edit_clave($pass, $user){
		$sql = "UPDATE usuarios SET pass = ". $this->db->escape(md5($pass)) ."
				WHERE login = ". $this->db->escape($user);
		//echo $sql;			
		if ($this->db->simple_query($sql)){
        	return true; //Exito
		}else{
        	return false; //Error
		}
		
	}

}