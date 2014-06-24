<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of poll_settings
 *
 * @author mayoori
 */

class poll_settings_model extends CI_Model{
    
    function __construct()
    {
            parent::__construct();

            $this->load->database();			
            $this->config->load('dbtables', TRUE);
    }
		
        
    function getFirstPollPoints()
    {
        $this->db->select("first_poll");
        $queryResult = $this->db->get($this->config->item('tbl_Settings','dbtables'));
       
        if ($queryResult->num_rows() > 0)
        {
            $row = $queryResult->row();
            return $row->first_poll;		
        } 
        else
        {
            return 0;
        }
    }
}
