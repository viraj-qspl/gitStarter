<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of province_model
 *
 * @author mayoori
 */
class province_model extends CI_Model{
    
    public function __construct() {
        parent::__construct();
        
        $this->load->database();
        $this->load->library('province_obj');
        $this->config->load('dbtables', TRUE);
    }
    
    //get list of all the regions
    function getProvinceList()
    {
        $this->db->select('*');
        $queryResult = $this->db->get($this->config->item('tbl_province','dbtables'));

        
        if( $queryResult->num_rows() > 0 ){

            $dataObjArr	= array();

            foreach ($queryResult->result() as $row)
            {
                $dataObj = new $this->province_obj;			   	

                $dataObj->setId($row->id);				
                $dataObj->setProvince($row->province);
                $dataObj->setCountry_id($row->country_id);
                $dataObj->setRegion_id($row->region_id);
                
                $dataObjArr[] = $dataObj;
            }

            return $dataObjArr;

        } else {	    
          return null;   // None
        }
    }
    
    //get list of all the regions
    function getProvinceListByRegionId($regionId = null)
    {
        $qry = "SELECT id, province, country_id, region_id  FROM " . $this->config->item('tbl_province','dbtables') . " WHERE region_id = ? ";
		
		 if ($regionId == null){
			return null;
		 }
		
		$dataBindArr[] =  $regionId;	
		
		$queryResult = $this->db->query($qry, $dataBindArr);		
	    
		if( $queryResult->num_rows() > 0 ){

            $dataObjArr	= array();

            foreach ($queryResult->result() as $row)
            {
                $dataObj = new $this->province_obj;			   	

                $dataObj->setId($row->id);				
                $dataObj->setProvince($row->province);
                $dataObj->setCountry_id($row->country_id);
                $dataObj->setRegion_id($row->region_id);
                
                $dataObjArr[] = $dataObj;
            }

            return $dataObjArr;

        } else {	    
          return null;   // None
        }

    }	
}