<?php

class Login_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->config->load('dbtables', TRUE);
	}
	
	function loginCheck($argRecordObj = NULL)
	{		
            if(empty($argRecordObj))
            {
                $email = $this->input->post('email');
		$password   = $this->input->post('password');	
            }
            else
            {
                $email = $argRecordObj->getEmail();
                $password = $argRecordObj->getPassword();
            }
                
            $query  = " SELECT id, user_type, email, name, last_name,gender,first_poll ";
            $query .= " FROM " . $this->config->item('tbl_n_user','dbtables');
            $query .= " WHERE email = ? and password = ? ";
            $dataBindArr = array($email, md5($password));

            $res   = $this->db->query($query, $dataBindArr);

            $resArr = $res->result();	
           
            return $resArr;
	}
	
}	
	