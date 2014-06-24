<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of region_list
 *
 * @author mayoori
 */
class region_list extends Base_list{
    
    // Define parameters specific to this class
    private $countryObj;
        
    function __construct(){	}

    // ---- Define getter methods
    function getCountryObj(){ return $this->countryObj; }	
        
    public function assignMoreData($argData = array()){	
		// Store values in properties defined for this class
		
		$CI =& get_instance(); 		// Get reference to CodeIgniter instance		
		
		// read the value from URI and store it in class variable		
		$regionId = $CI->uri->segment(URI_ID);
                $countryId = $CI->uri->segment(URI_OTHER_PARAMS);
                
		if ($countryId == null && $regionId == null){					
			if (is_array($argData) && isset($argData["countryId"]) && isset($argData["regionId"])){
				$countryId = 	$argData["countryId"];
                                $regionId = $argData["regionId"];
			}else{			
				// Set it to default
				$countryId = DEFAULT_COUNTRY_ID;
                                $regionId = DEFAULT_REGION_ID;
			}
		}
		
        // Write to log file
 		log_message('info', '--------------> Sub_category_list,  categoryId = ' . $countryId ." regionId = " .$regionId);		
		
		//Using $categoryId, get the category object and store it in this class for future reference
		$this->countryObj = $CI->country_model->getRecords($countryId);
    }

    public function getInstance($argData = array()){
		// Call parent method and set the values to the object
		parent::assignData($argData);	
				
		// Set values for properties defined in this class
		$this->assignMoreData($argData);
		
		// Set values specific to this feature
		$CI =& get_instance(); 		// Get reference to CodeIgniter instance		
		parent::setOtherParams($this->createOtherParams());	
		parent::setActionUrl($CI->config->item('userRegistrationQuestions'));
//		parent::setSearchFieldArr($CI->config->item('stateSearchFieldBeArr'));
//		parent::setDbFieldArr($CI->config->item('stateDbFieldBeArr'));
		parent::setBreadCrumb($this->creatBreadCrumb());
		
		// Now, since all properties are defined - store value for sortFieldArr 
		parent::computeSortFieldArr();
		
		// Return the object		
		return $this; 
    }
	
    // Method that will compute Other parameters to be sent over URL
    function createOtherParams(){

            return $this->getCountryObj()->getId();
    }	


    // This method will create required breadCrumb (lable with link)	
    function creatBreadCrumb(){

            $CI =& get_instance(); 		// Get reference to CodeIgniter instance		

            $breadCrumb = "";
            // BreadCrumb format required: Category > selected-country-name > List

            $breadCrumb .= "<a href='".$CI->config->item('userRegistrationQuestions')."' >";
//            $breadCrumb .= "".$CI->lang->line('lable.locations');
            $breadCrumb .= "</a>";

            $breadCrumb .= " > ";

            $breadCrumb .= "<a href='".$CI->config->item('userRegistrationQuestions')."/".$this->getUrlParams()."' >";
            $breadCrumb .= "".$this->getCountryObj()->getName();
            $breadCrumb .= "</a>";

            return $breadCrumb;

    }
}
