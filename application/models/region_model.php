<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of region_model
 *
 * @author mayoori
 */
class region_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        
        $this->load->database();
        $this->load->library('region_obj');
        $this->config->load('dbtables', TRUE);
    }
    
    //get list of all the regions
    function getRegionList()
    {
        $this->db->select('*');
        $queryResult = $this->db->get($this->config->item('tbl_region','dbtables'));

        if( $queryResult->num_rows() > 0 ){

            $dataObjArr	= array();

            foreach ($queryResult->result() as $row)
            {
                $dataObj = new $this->region_obj;			   	

                $dataObj->setId($row->id);				
                $dataObj->setRegion($row->region);
                $dataObj->setCountry_id($row->country_id);

                $dataObjArr[] = $dataObj;
            }

            return $dataObjArr;

        } else {	    
          return null;   // None
        }
    }
}
