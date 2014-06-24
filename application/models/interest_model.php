<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of interest_model
 *
 * @author mayoori
 */
class interest_model extends CI_Model{
    function __construct()
    {
        parent::__construct();
        $this->load->library('interest_obj');
        $this->load->library('interest_category_obj');
        $this->config->load('dbtables', TRUE);
    }

    function getInterestList_old()
    {
        $this->db->select("*");
        $this->db->limit(5);
        $queryResult = $this->db->get($this->config->item('tbl_interest','dbtables'));

        if( $queryResult->num_rows() > 0 ){

        $dataObjArr	= array();

        foreach ($queryResult->result() as $row)
        {
            $dataObj = new $this->interest_obj;			   	

            $dataObj->setId($row->id);				
            $dataObj->setInterest($row->interest);
            $dataObj->setInterestCategory_id($row->interestCategory_id);

            $dataObjArr[] = $dataObj;
        }

        return $dataObjArr;

    } else {	    
      return null;   // None
    }
    }
    
    function getInterestList()
    {
        $this->db->select("tp_interest.id,interest,name,tp_interestcategory.id as interest_category_id");
        $this->db->from($this->config->item('tbl_interest','dbtables'));
        $this->db->join($this->config->item('tbl_interestCategory','dbtables'), "interest_category_id = tp_interestcategory.id");

        $queryResult = $this->db->get();
        
        if( $queryResult->num_rows() > 0 ){

        $dataObjArr	= array();

        $old_interest_category_id = "0";
        $interestObjArr = array();
        foreach ($queryResult->result() as $row)
        {
            
            $dataObj = new $this->interest_obj;			   	

            $dataObj->setId($row->id);				
            $dataObj->setInterest($row->interest);
            $dataObj->setInterest_category_id($row->interest_category_id);
        
            if($old_interest_category_id != "0" && ($row->interest_category_id != $old_interest_category_id))
            {
//            $categoryDataObj = new $this->interest_category_obj;	
//            $categoryDataObj->setId($row->interest_category_id);
//            $categoryDataObj->setName($row->name);
//            
//            $categoryDataArr[] = $categoryDataObj;
            
              $dataObjArr[$row->name] = $interestObjArr;
              $interestObjArr = array();
            }
            else
            {
                array_push($interestObjArr,$dataObj);
            }
            $old_interest_category_id = $row->interest_category_id;
                    
//            $interestObjArr[] = $dataObj;
              //$dataObjArr [] = $interestObjArr;
        }
        
//        $dataObjArr ['interest'] = $interestObjArr;
//        $dataObjArr['interest_category'] = $categoryDataArr;
//            echo "<pre>";
//            print_r($dataObjArr);
//            echo "</pre>";
//            exit;
             
        return $dataObjArr;

    } else {	    
      return null;   // None
    }
    }
}
