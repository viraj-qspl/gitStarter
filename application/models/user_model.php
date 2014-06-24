<?php

class User_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->database();
		$this->load->library('user_obj');	
                $this->load->library('education_obj');
                $this->load->library('jobfunction_obj');
                $this->load->library('jobstatus_obj');
                $this->load->library('relationship_obj');
                $this->load->library('family_status_obj');
                $this->load->library('income_obj');
		$this->config->load('dbtables', TRUE);
	}
		
        
	// Get single or all categories
	// This will return array with two elements, 1st element will have count (total records without limit for paging), 2nd element will have list of records (with limit)
	function getList($argDataObj = null)
	{					
		// Define return array variable
		$returnArr = array();
		
		// Prepare Query - using Query Binding concept from CodeIgnitor
		$queryDataArr 	= array(); //used for data binding
		
		// SELECT and FROM table
		$selectStmt 	= " SELECT * ";
		$fromTable		= " FROM " . $this->config->item('tbl_n_user','dbtables');		
		$queryStmt 		= $selectStmt . $fromTable;		
				
		$sortFieldIndex	= $argDataObj->getSortFieldIndex();
                $sortOrder 		= $argDataObj->getSortOrder();		  
                $searchField 	= $argDataObj->getSearchField();
                $searchText 	= $argDataObj->getSearchText();		    			
                $limitRows 		= $argDataObj->getLimitRows();
                $limitOffset 	= $argDataObj->getLimitOffset();	    	    
	    
	    // Add WHERE condition		
	    $queryStmt 		.=  " WHERE (1) "; 
	    
		// Add Search condition if any
		if ($searchField != "" && $searchText != ""){
			// Query Example: SELECT id, name, city_id, STATUS FROM mp_city WHERE city_id =0 AND name LIKE 'buy%' 			
	    	$queryStmt 		.= " AND {$searchField} LIKE ? "; 	
			$queryDataArr[]	= $searchText  . "%"; // Add % symbol at the end of data itself			
		}
		
		// Execute query, pass the data to query parameters and get result set			
		$queryResult =  $this->db->query($queryStmt, $queryDataArr); 

	    // Add count to returnArr
	    $returnArr['totalRecords'] = $queryResult->num_rows();
		
	    // Now add Order by, limit and run the query again
		// Add ORDER BY - field and order
		$sortFieldArr 	= $argDataObj->getSortFieldArr();
		
		// Get only the key values
		$sortFieldNameArr	=	array_keys($sortFieldArr);
		
		$queryStmt 		= $queryStmt . " ORDER  BY ".$sortFieldNameArr[$sortFieldIndex]." ".$sortOrder." "; 					
	    		    
		// Add LIMIT 
		if ($limitRows>0){		
			$queryStmt 		= $queryStmt . " LIMIT {$limitOffset}, {$limitRows} "; 					
		}			
		
		// Execute Query once again
	    $queryResult =  $this->db->query($queryStmt, $queryDataArr); 

	    
	    // Define array to store result
	     $dataObjArr = array();
	    
	    if($queryResult->num_rows() > 0){	
 		   foreach ($queryResult->result() as $row)
		   {
	      		$dataObj = new $this->user_obj;			   	
	      		
				$dataObj->setId($row->id);				
				$dataObj->setUserType($row->user_type);
				$dataObj->setEmail($row->email);
				$dataObj->setPassword($row->password);
				$dataObj->setFacebookId($row->facebook_id);
				$dataObj->setFirstName($row->first_name);
				$dataObj->setLastName($row->last_name);
				$dataObj->setDisplayName($row->display_name);
				$dataObj->setgender($row->gender);
				$dataObj->setbirthDate($row->birth_date);
				$dataObj->setprofileImageFilename($row->profile_image_filename);
				$dataObj->setaddress($row->address);
				$dataObj->setLandmark($row->landmark);
				$dataObj->setCountryId($row->country_id);
				$dataObj->setStateId($row->state_id);
				$dataObj->setCityId($row->city_id);
				$dataObj->setAreaId($row->area_id);
				$dataObj->setPincode($row->pincode);
				$dataObj->setPhone($row->phone);
				$dataObj->setCreatedDate($row->created_date);
				$dataObj->setUpdatedDate($row->updated_date);
				$dataObj->setLastLoginDate($row->last_login_date);
				$dataObj->setStatus($row->status);
				$dataObj->setLogDetails($row->log_details);				
				
				$dataObjArr[] = $dataObj;					
		   }
	    } 	
	    
		// Add array of objects to return array		    
	    $returnArr['dbDataArr'] = $dataObjArr;
	    		
	   //return array
	   return $returnArr;
		    
	}
	
	function getRecords($id = null, $email = null)
	{ 
		// Prepare Query - using Query Binding concept from CodeIgnitor
		$queryDataArr 	= array(); //used for data binding
				
		// SELECT and FROM table
		$selectStmt 	= " SELECT * ";
		$fromTable		= " FROM " . $this->config->item('tbl_n_user','dbtables');		
		$queryStmt 		= $selectStmt . $fromTable;		
		 $queryStmt 	.= " WHERE (1) ";
		
		// Getting only ONE row
		if ($id != null){
		    $queryStmt 		.= " AND id = ? "; 
			$queryDataArr[]	= $id;			
		}
		
		if($email != null){
		    $queryStmt 		.= " AND email = ? "; 
			$queryDataArr[]	= $email;			
		}
				
	    // Add order by clause
	    $queryStmt 		.= " ORDER BY name ";	    
		
		// Execute query
	    $queryResult = $this->db->query($queryStmt, $queryDataArr);
	    	   
            
	    if( $queryResult->num_rows() > 0 ){
	       
	       $dataObjArr	= array();
	       		   	
 		   foreach ($queryResult->result() as $row)
		   {
	      		$dataObj = new $this->user_obj;			   	
	      		
				$dataObj->setId($row->id);				
				$dataObj->setUser_type($row->user_type);
				$dataObj->setEmail($row->email);
				$dataObj->setPassword($row->password);
				$dataObj->setGender($row->gender);
				$dataObj->setDob($row->dob);
                                $dataObj->setFirst_poll($row->first_poll);
				$dataObjArr[] = $dataObj;
		   }
                   
		   if ($id != null && count($dataObjArr)>0){
		   	return $dataObjArr[0];
		   }
		   
		   return $dataObjArr;
		      
	    } else {	    
	      return null;   // None
	    }			

	}	
	
	function getName($id){
		$qry = "SELECT id, name, last_name FROM " . $this->config->item('tbl_n_user','dbtables') . " WHERE id=?";
		
		$dataBindArr[] =  $id;	
		
		$queryResult = $this->db->query($qry, $dataBindArr);		
	    
		$name = "";
 		if ($queryResult->num_rows() > 0){ 			
 		 	foreach ($queryResult->result() as $row){
					$name = $row->name ." ". $row->last_name;
			   }	
		}

		return $name;
		
	}
	
	function getTotalRecords(){		
		return $this->db->count_all($this->config->item('tbl_n_user','dbtables'));
	}
	
	//check for duplicate email
	function isEmailPresent($argEmail)
	{	
		$qry = "SELECT id FROM " . $this->config->item('tbl_n_user','dbtables') . " WHERE email = ? ";
		$dataBindArr[] =  $argEmail;						
		
		$queryResult = $this->db->query($qry, $dataBindArr);		
	    $flag = false;
 		if ($queryResult->num_rows() > 0){
	    	$flag = true;			
		} 

		return $flag;	
	}
        
         //get id by email address
        function getIdFromEmail($argEmail)
        {	
                $qry = "SELECT id FROM " . $this->config->item('tbl_n_user','dbtables') . " WHERE email = ? ";
                $dataBindArr[] =  $argEmail;						

                $queryResult = $this->db->query($qry, $dataBindArr);		

                if ($queryResult->num_rows() > 0)
                {
                    $row = $queryResult->row(); 
                    return $row->id;		
                } 
                else
                {
                    return 0;
                }
        }
        
         //get id by email address
        function getIdFromFacebookId($argFacebookId)
        {	
                $qry = "SELECT id FROM " . $this->config->item('tbl_n_user','dbtables') . " WHERE facebook_id = ? ";
                $dataBindArr[] =  $argFacebookId;						

                $queryResult = $this->db->query($qry, $dataBindArr);		

                if ($queryResult->num_rows() > 0)
                {
                    $row = $queryResult->row(); 
                    return $row->id;		
                } 
                else
                {
                    return 0;
                }
        }
        
        
        function getRegionIdByUserId($argUserId)
        {
            $qry = "SELECT region_id FROM " . $this->config->item('tbl_n_user','dbtables') . " WHERE id = ? ";
                $dataBindArr[] =  $argUserId;						

                $queryResult = $this->db->query($qry, $dataBindArr);		

                if ($queryResult->num_rows() > 0)
                {
                    $row = $queryResult->row(); 
                    return $row->region_id;		
                } 
                else
                {
                    return 0;
                }
        }
        
        function getLastAnsweredQuestion($argUserId)
        {
            $qry = "SELECT last_answered_question FROM " . $this->config->item('tbl_n_user','dbtables') . " WHERE id = ? ";
                $dataBindArr[] =  $argUserId;						

                $queryResult = $this->db->query($qry, $dataBindArr);		

                if ($queryResult->num_rows() > 0)
                {
                    $row = $queryResult->row(); 
                    return $row->last_answered_question;		
                } 
                else
                {
                    return 0;
                }
        }
        
        
	// save (insert/update) record
	function save($argRecordObj)
	{
            
log_message("info", " ===========> model save " );
           
		$queryResult = FALSE;
		
//		//Create common data array for Add/Edit
//		$data = array( // field => value pair - other than primary key
//                                   
//				   'user_type' => $argRecordObj->getUser_type(),
//				   'email' => $argRecordObj->getEmail(),
//				   'password' => $argRecordObj->getPassword(),
//				   'gender' => $argRecordObj->getGender(),
//				   'dob' => $argRecordObj->getDob(),
//                                   'first_poll' => $argRecordObj->getFirst_poll(),
//                                   'created_date' => $argRecordObj->getCreated_date()
//				);

log_message("info", " ===========> model save " );
  
                
		// Check operation type based on Id					
		if ($argRecordObj->getId() == NULL){ // Add operation

			//$queryResult = $this->db->insert($this->config->item('tbl_n_user','dbtables'), $data);
                        $queryResult = $this->db->insert($this->config->item('tbl_n_user','dbtables'), (array)$argRecordObj);
		
		} else if ($argRecordObj->getId() > 0){ // Edit Operation
			
			$this->db->where('id', $argRecordObj->getId());
			$queryResult = $this->db->update($this->config->item('tbl_n_user','dbtables'), (array)$argRecordObj);
			  						
		}
		
		// write to log if update operation was not processed
		if ($queryResult == FALSE){
			log_message("info", "Failed to perform Add/Edit operation on:" . $argRecordObj->getName());			
		}
                
		return $queryResult;
	
	}		
	
        // save (insert/update) record
	function saveLoginDetailsFromFacebook($argRecordObj)
	{
            log_message("info", " ===========> model save " );
           
		$queryResult = FALSE;
                
//		//Create common data array for Add/Edit
//		$data = array( // field => value pair - other than primary key
//                                   
//				   'user_type' => $argRecordObj->getUser_type(),
//				   'email' => $argRecordObj->getEmail(),
//				   'gender' => $argRecordObj->getGender(),
//                                   'name' =>$argRecordObj->getName(),
//                                   'last_name'=> $argRecordObj->getLast_name(),
//                                   'facebook_id' =>$argRecordObj-getFacebook_id(),
//                                   'first_poll' => $argRecordObj->getFirst_poll(),
//                                   'created_date' => $argRecordObj->getCreated_date()
//				);

log_message("info", " ===========> model save " );
  
                
		// Check operation type based on Id					
		if ($argRecordObj->getId() == NULL){ // Add operation

			$queryResult = $this->db->insert($this->config->item('tbl_n_user','dbtables'), (array)$argRecordObj);			  						
		
		} else if ($argRecordObj->getId() > 0){ // Edit Operation
			
			$this->db->where('id', $argRecordObj->getId());
			$queryResult = $this->db->update($this->config->item('tbl_n_user','dbtables'), (array)$argRecordObj);
			  						
		}
		
		// write to log if update operation was not processed
		if ($queryResult == FALSE){
			log_message("info", "Failed to perform Add/Edit operation on:" . $argRecordObj->getName());			
		}
                
		return $queryResult;
	
	}	
        
        //update password, email id of particular user.
        function updatePassword($argRecordObj)
        {
            log_message("info", " ===========> model password,email update. " );
            
            $data = array( // field => value pair - other than primary key
				   'email' => $argRecordObj->getEmail(),
				   'password' => md5($argRecordObj->getPassword())
				);
            
           
            
            if ($argRecordObj->getId() > 0){ // Edit Operation
			
			$this->db->where('id', $argRecordObj->getId());
			$queryResult = $this->db->update($this->config->item('tbl_n_user','dbtables'), $data); 						
		}
                
		// write to log if update operation was not processed
		if ($queryResult == FALSE){
			log_message("info", "Failed to perform update password operation on:" . $argRecordObj->getEmail());			
		}
                
		return $queryResult;
                
        }
        
        function updateUserInterest($argRecordObjArr, $argRecordObj)
        {        
            $data = array('last_answered_question' => $argRecordObj->getLast_answered_question(),
                          'last_updated' => date('Y-m-d H:m:s'));
            
            if ($argRecordObj->getId() > 0){ 
			$this->db->where('id', $argRecordObj->getId());
			$queryResult = $this->db->update($this->config->item('tbl_n_user','dbtables'), $data); 						
            }
                
            $queryResult = $this->db->insert_batch($this->config->item('tbl_user_interest','dbtables'), $argRecordObjArr);	  
            return $queryResult;
        }
        
        function updateFirstPollDetails($argRecordObj, $fieldname)
        {
             log_message("info", " ===========> model password,email update. " );
        
              $objectVar = "";
              
             switch ($fieldname) {
              case REGION:
                $objectVar = $argRecordObj->getRegion_id();
                break;
            
              case PROVINCE:
                $objectVar = $argRecordObj->getProvince_id();
                break;
              
            case GENDER:
                $objectVar = $argRecordObj->getGender();
                break;
            
            case DOB:
                $objectVar = $argRecordObj->getDob();
                break;
            
            case EDUCATION:
                $objectVar = $argRecordObj->getEducation_id();
                break;
            
            case INCOME:
                $objectVar = $argRecordObj->getIncome_group_id();
                break;
            
            case JOBFUNCTION: 
                $objectVar = $argRecordObj->getJob_function_id();
                break;
                
            case JOBSTATUS: 
                $objectVar = $argRecordObj->getJob_status_id();
                break;
                
            case RELATIONSHIPSTATUS:
                $objectVar = $argRecordObj->getRelationship_id();
                break;
            
            case FAMILYSTATUS:
                $objectVar = $argRecordObj->getFamily_status_id();
                break;
            }
            
            $data = array('last_answered_question' => $argRecordObj->getLast_answered_question(),'last_updated' => date('Y-m-d H:m:s'),$fieldname => $objectVar);
            
            if ($argRecordObj->getId() > 0){ // Edit Operation
			
			$this->db->where('id', $argRecordObj->getId());
			$queryResult = $this->db->update($this->config->item('tbl_n_user','dbtables'), $data); 						
		}
             
		// write to log if update operation was not processed
		if ($queryResult == FALSE){
			log_message("info", "Failed to perform update first poll details operation on:" . $argRecordObj->getId());			
		}
                
		return $queryResult;
        }
        
        function changeFirstPoll($argRecordObj)
        {
             // field => value pair - other than primary key
            $data = array('first_poll' => $argRecordObj->getFirst_poll());
             $queryResult = "";
            if ($argRecordObj->getId() > 0){ // Edit Operation
			
			$this->db->where('id', $argRecordObj->getId());
			$queryResult = $this->db->update($this->config->item('tbl_n_user','dbtables'), $data); 						
		}
             
		// write to log if update operation was not processed
		if ($queryResult == FALSE){
			log_message("info", "Failed to perform update first poll details operation on:" . $argRecordObj->getId());			
		}
                
		return $queryResult;
        }
        
	//Delete record
	function delete($argIds){
		$queryResult = $this->db->query( "DELETE FROM " . $this->config->item('tbl_n_user','dbtables') . " WHERE id IN (" . $argIds . ")" );
		return $queryResult;
	}
	
        function getEducationList()
        {
            $this->db->select("*");
            $queryResult = $this->db->get($this->config->item('tbl_education','dbtables'));
            
            if( $queryResult->num_rows() > 0 ){

            $dataObjArr	= array();

            foreach ($queryResult->result() as $row)
            {
                $dataObj = new $this->education_obj;			   	

                $dataObj->setId($row->id);				
                $dataObj->setEdu_level($row->edu_level);
                
                $dataObjArr[] = $dataObj;
            }

            return $dataObjArr;

        } else {	    
          return null;   // None
        }
            
        }
        
        function getJobFunctionList()
        {
            $this->db->select("*");
            $queryResult = $this->db->get($this->config->item('tbl_jobFunction','dbtables'));
            
            if( $queryResult->num_rows() > 0 ){

            $dataObjArr	= array();

            foreach ($queryResult->result() as $row)
            {
                $dataObj = new $this->jobfunction_obj;			   	

                $dataObj->setId($row->id);				
                $dataObj->setJob_function($row->job_function);
                
                $dataObjArr[] = $dataObj;
            }

            return $dataObjArr;

        } else {	    
          return null;   // None
        }
        }
        
        function getJobStatusList()
        {
            $this->db->select("*");
            $queryResult = $this->db->get($this->config->item('tbl_jobStatus','dbtables'));
            
            if( $queryResult->num_rows() > 0 ){

            $dataObjArr	= array();

            foreach ($queryResult->result() as $row)
            {
                $dataObj = new $this->jobstatus_obj;			   	

                $dataObj->setId($row->id);				
                $dataObj->setJob_status($row->job_status);
                $dataObj->setJob_status_label($row->job_status_label);
                
                $dataObjArr[] = $dataObj;
            }

            return $dataObjArr;

        } else {	    
          return null;   // None
        }
        }
        
        function getRelationshipStatusList()
        {
            $this->db->select("*");
            $queryResult = $this->db->get($this->config->item('tbl_relationship','dbtables'));
            
            if( $queryResult->num_rows() > 0 ){

            $dataObjArr	= array();

            foreach ($queryResult->result() as $row)
            {
                $dataObj = new $this->relationship_obj;			   	

                $dataObj->setId($row->id);				
                $dataObj->setRelationship($row->relationship);
                $dataObj->setRelationship_label($row->relationship_label);
                
                $dataObjArr[] = $dataObj;
            }

            return $dataObjArr;

        } else {	    
          return null;   // None
        }
        }
        
        
        function getFamilyStatusList()
        { 
            $this->db->select("*");
            $queryResult = $this->db->get($this->config->item('tbl_familyStatus','dbtables'));
           
            if( $queryResult->num_rows() > 0 ){

            $dataObjArr	= array();

            foreach ($queryResult->result() as $row)
            {
                $dataObj = new $this->family_status_obj;			   	

                $dataObj->setId($row->id);				
                $dataObj->setFamily_status($row->family_status);
                $dataObj->setFamily_status_label($row->family_status_label);
                
                $dataObjArr[] = $dataObj;
            }

            return $dataObjArr;

        } else {	    
          return null;   // None
        }
        }
        
        function getIncomeList()
        {
            $this->db->select("*");
            $queryResult = $this->db->get($this->config->item('tbl_income','dbtables'));
            
             log_message("INFO", " in if == > if ==> last query:   ".$this->db->last_query());
            if( $queryResult->num_rows() > 0 ){

            $dataObjArr	= array();

            foreach ($queryResult->result() as $row)
            {
                $dataObj = new $this->income_obj;			   	

                $dataObj->setId($row->id);				
                $dataObj->setStart_income($row->start_income);
                $dataObj->setEnd_income($row->end_income);
                $dataObj->setLabel($row->label);
                
                $dataObjArr[] = $dataObj;
            }
            return $dataObjArr;

        } else {	    
          return null;   // None
        }
        }
}	
/*end of file*/	