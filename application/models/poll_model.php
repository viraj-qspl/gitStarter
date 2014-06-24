<?php

ini_set('dusplay_errors',1);
error_reporting(E_ALL);

class Poll_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->database();
		$this->load->library(array('user_obj','pollCategory_obj'));					
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
		$fromTable		= " FROM " . $this->config->item('tbl_poll','dbtables');		
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


	

	
	function getName($id){
		$qry = "SELECT id, first_name, last_name FROM " . $this->config->item('tbl_user','dbtables') . " WHERE id=?";
		
		$dataBindArr[] =  $id;	
		
		$queryResult = $this->db->query($qry, $dataBindArr);		
	    
		$name = "";
 		if ($queryResult->num_rows() > 0){ 			
 		 	foreach ($queryResult->result() as $row){
					$name = $row->first_name ." ". $row->last_name;
			   }	
		}

		return $name;
		
	}
	
	function getTotalRecords(){		
		return $this->db->count_all($this->config->item('tbl_user','dbtables'));
	}
	
	//check for duplicate email
	function isEmailPresent($argEmail)
	{		
		
		$qry = "SELECT id FROM " . $this->config->item('tbl_user','dbtables') . " WHERE email = ? ";
		$dataBindArr[] =  $argEmail;						
		
		$queryResult = $this->db->query($qry, $dataBindArr);		
	    $flag = false;
 		if ($queryResult->num_rows() > 0){
	    	$flag = true;			
		} 

		return $flag;	
	}
	

	//Delete record
	function delete($argIds){
		$queryResult = $this->db->query( "DELETE FROM " . $this->config->item('tbl_user','dbtables') . " WHERE id IN (" . $argIds . ")" );
		return $queryResult;
	}
	
	
	/** Poll Model and its new methods start here **/

	function getPoll($id = NULL){
		$qry = "SELECT * FROM " . $this->config->item('tbl_poll','dbtables') . " WHERE id=?";
		
		$dataBindArr[] =  $id;	
		
		$queryResult = $this->db->query($qry, $dataBindArr);

		  $dataObj = NULL;
	    
	    if( $queryResult->num_rows() > 0 ){
		   
		   $dataObj = new $this->poll_obj;	
	       		   	
 		   foreach ($queryResult->result() as $row)
		   {      				        		
				foreach($row as $key=>$value)
					$dataObj->$key = $value;		   	
		   }
		}
		
		return $dataObj;	
	}

	function initPoll()
	{
		$this->db->insert($this->config->item('tbl_poll','dbtables'),array('title'=>''));
	
		$this->session->set_userdata('poll_id',$this->db->insert_id());
		
		return;
	
	}
	
	function setType($type)
	{
		$this->db->where('id',$this->session->userdata('poll_id'));
		$this->db->update($this->config->item('tbl_poll','dbtables'),array('poll_type'=>$type));
		
		return;
		
	}
	
	function getPollCategories()
	{
		$dataObj = NULL;
		$dataObjArr = array();
		
		$categories = $this->db->get($this->config->item('tbl_pollCategory','dbtables'));
	
		if($categories->num_rows() == 0)
			return array();		
		else 
		{
			$result = $categories->result();
			foreach($result as $row)
			{
				$dataObj = new pollCategory_obj;
				foreach($row as $key=>$value)
					$dataObj->$key = $value;
				
				$dataObjArr[] = $dataObj; 
					
			}

			
			
			return $dataObjArr;
			
		}		
	}
	
	
	
	function getRecords($id = null, $status = null)
	{ 
		// Prepare Query - using Query Binding concept from CodeIgnitor
		$queryDataArr 	= array(); //used for data binding
				
		// SELECT and FROM table
		$selectStmt 	= " SELECT * ";
		$fromTable		= " FROM " . $this->config->item('tbl_poll','dbtables');		
		$queryStmt 		= $selectStmt . $fromTable;		
		$queryStmt 	.= " WHERE (1) ";
		
		// Getting only ONE row
		if ($id >= 0 ){					//Zero id will be passed to get records for the add entry form
		   
		   if($id==0){
				return NULL;
			}	
		
		
		   $queryStmt 		.= " AND id = ? "; 
			$queryDataArr[]	= $id;			
		}
		
		if($status != null){
		    $queryStmt 		.= " AND status = ? "; 
			$queryDataArr[]	= $status;			
		}
				
	    // Add order by clause
	    $queryStmt 		.= " ORDER BY id ";

			echo $queryStmt;exit;
		
		// Execute query
	    $queryResult = $this->db->query($queryStmt, $queryDataArr);
	    	    
	    if( $queryResult->num_rows() > 0 ){
	       
	       $dataObjArr	= array();
	       		   	
 		   foreach ($queryResult->result() as $row)
		   {
	      		$dataObj = new $this->poll_obj;			   	
	      		
				foreach($row as $key=>$value)
					$dataObj->$key = $value;
				
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
	
	// save (insert/update) record
	function save($argRecordObj)
	{			
		$queryResult = FALSE;
		
		//Create common data array for Add/Edit
		$data = array( // field => value pair - other than primary key
				   'title' => $argRecordObj->getTitle(),
				   'descp' => $argRecordObj->getDescp(),
				   'poll_category_id' => $argRecordObj->getPollCategory_id(),
				   'image'=>$argRecordObj->getImage(),
				   'poll_type'=>'POLL',
				   'create_date'=>date('Y-m-d'),
				   'user_id'=>$argRecordObj->getUser_id()
				);
			
	
				
						
		// Check operation type based on Id					
		if ($argRecordObj->getId() == NULL){ // Add operation

			$queryResult = $this->db->insert($this->config->item('tbl_poll','dbtables'), $data);			  						


		} 
		
			
		
		// write to log if update operation was not processed
		if ($queryResult == FALSE){
			log_message("info", "Failed to perform Add/Edit operation on:" . $argRecordObj->getTitle());			
		}
		else{
			$this->session->set_userdata('create_poll_id',$this->db->insert_id());
				
			if($argRecordObj->getPoll_type() == 'TEMPLATE'){	

				$this->copyPollDetails($this->session->userdata('create_poll_id'),$argRecordObj->getTemplate_id());
			}	
			
		}	
				
		return $queryResult;
	
	}		
	
	/**
		function to save a question to the databse
	**/	
	
	public function addQuestion($pollId,$questionType,$question,$allow_text,$status='DRAFT',$ans_reqd,$options,$allow_text,$options_label,$scale_sub_ques,$txt) {
	
		
	
		$data = array(
			'poll_id'=>$pollId,
			'question'=>$question,
			'allow_text'=>$allow_text,
			'required'=>$ans_reqd,
			'type'=>$questionType,
			'status'=>$status,
			'filter_ques'=>'N'
		);

		
		
	
		
		$success = true;
		
		$temp_success =  $this->db->insert($this->config->item('tbl_pollQuestion','dbtables'),$data);
		$success = $success && $temp_success;
		
		
		if(!$success)
			GOTO remove_question;
		else
			$questionId = $this->db->insert_id();

		
		switch($questionType) {
			case 'SINGLE':
			foreach($options as $key=>$value) {
				$data = array(
					'poll_question_id'=> $questionId,
					'answer'=>$value,
					'label'=>'',
					'text'=>$txt
				);
				$temp_success =  $this->db->insert($this->config->item('tbl_pollAnswer','dbtables'),$data);
				$success = $success && $temp_success;
			}
			
			break;
			
			case 'MULTIPLE':
			foreach($options as $key=>$value) {
				$data = array(
					'poll_question_id'=> $questionId,
					'answer'=>$value,
					'label'=>'',
					'text'=>$txt
				);	
				$temp_success = $this->db->insert($this->config->item('tbl_pollAnswer','dbtables'),$data);
				$success = $success && $temp_success;
			}
						
			break;
			
			case 'SCALE':
				foreach($options as $key=>$value)
				{
					$data=array(
					'poll_question_id'=> $questionId,
					'answer'=>$value,
					'label'=>$options_label[$key],
					'text'=>$txt			
					);
					$temp_success = $this->db->insert($this->config->item('tbl_pollAnswer','dbtables'),$data);
					$success = $success && $temp_success;
				}
				
				
				
				foreach($scale_sub_ques as $key=>$value)
				{
					$data = array(
						'poll_question_id'=>$questionId,
						'scale_question'=>$value
					);
				$temp_success = $this->db->insert($this->config->item('tbl_scaleQuestion','dbtables'),$data);
				$success = $success && $temp_success;
				}
			
			break;
			
			case 'TEXT':
			if($txt=='N') {
				foreach($options as $key=>$value) {
					$data = array(
						'poll_question_id'=>$questionId,
						'answer'=>$value,
						'label'=>$options_label[$key],
						'text'=>$txt
					);
					$temp_success = $this->db->insert($this->config->item('tbl_pollAnswer','dbtables'),$data);	
					$success = $success && $temp_success;				
				}		
			}
			elseif($txt=='Y')
			{
				$data = array (
					'poll_question_id'=>$questionId,
					'answer'=>'',
					'label'=>'',
					'text'=>$txt
				);
				$temp_success =  $this->db->insert($this->config->item('tbl_pollAnswer','dbtables'),$data);
				$success = $success && $temp_success;
			}
			break;
		}
		
		
	if($success)
		return success;

	
	remove_question:
		return false;
		
		
		
		
		
		
	}
	
	
	
	
	public function updateQuestion($questionId,$questionType,$question,$allow_text,$status='DRAFT',$ans_reqd,$options,$allow_text,$options_label,$scale_sub_ques,$txt) {
	
		
	
		$data = array(
			'question'=>$question,
			'allow_text'=>$allow_text,
			'required'=>$ans_reqd,
			'type'=>$questionType,
			'status'=>$status,
			'filter_ques'=>'N'
		);

		
		
	
		
		$success = true;
		
		$this->db->where('id',$questionId);
		$temp_success =  $this->db->update($this->config->item('tbl_pollQuestion','dbtables'),$data);
		$success = $success && $temp_success;
		


		
		
		
		
		if(!$success)
			GOTO remove_question;

		$this->db->delete($this->config->item('tbl_pollAnswer','dbtables'),array('poll_question_id'=>$questionId));
		$this->db->delete($this->config->item('tbl_scaleQuestion','dbtables'),array('poll_question_id'=>$questionId));
		
		switch($questionType) {
			case 'SINGLE':
			foreach($options as $key=>$value) {
				$data = array(
					'poll_question_id'=> $questionId,
					'answer'=>$value,
					'label'=>'',
					'text'=>$txt
				);
				$temp_success =  $this->db->insert($this->config->item('tbl_pollAnswer','dbtables'),$data);
				$success = $success && $temp_success;
			}
			
			break;
			
			case 'MULTIPLE':
			foreach($options as $key=>$value) {
				$data = array(
					'poll_question_id'=> $questionId,
					'answer'=>$value,
					'label'=>'',
					'text'=>$txt
				);	
				$temp_success = $this->db->insert($this->config->item('tbl_pollAnswer','dbtables'),$data);
				$success = $success && $temp_success;
			}
						
			break;
			
			case 'SCALE':
				foreach($options as $key=>$value)
				{
					$data=array(
					'poll_question_id'=> $questionId,
					'answer'=>$value,
					'label'=>$options_label[$key],
					'text'=>$txt			
					);
					$temp_success = $this->db->insert($this->config->item('tbl_pollAnswer','dbtables'),$data);
					$success = $success && $temp_success;
				}
				
				
				
				foreach($scale_sub_ques as $key=>$value)
				{
					$data = array(
						'poll_question_id'=>$questionId,
						'scale_question'=>$value
					);
				$temp_success = $this->db->insert($this->config->item('tbl_scaleQuestion','dbtables'),$data);
				$success = $success && $temp_success;
				}
			
			break;
			
			case 'TEXT':
			if($txt=='N') {
				foreach($options as $key=>$value) {
					$data = array(
						'poll_question_id'=>$questionId,
						'answer'=>$value,
						'label'=>$options_label[$key],
						'text'=>$txt
					);
					$temp_success = $this->db->insert($this->config->item('tbl_pollAnswer','dbtables'),$data);	
					$success = $success && $temp_success;				
				}		
			}
			elseif($txt=='Y')
			{
				$data = array (
					'poll_question_id'=>$questionId,
					'answer'=>'',
					'label'=>'',
					'text'=>$txt
				);
				$temp_success =  $this->db->insert($this->config->item('tbl_pollAnswer','dbtables'),$data);
				$success = $success && $temp_success;
			}
			break;
		}
		
		
	if($success)
		return success;

	
	remove_question:
		return false;
		
		
		
	}	
	
	
	
	
	public function addfilterQuestion($id,$questionType,$question,$ans_reqd,$options,$continue) {
	
		
	
		$data = array(
			'poll_id'=>$id,
			'question'=>$question,
			'required'=>$ans_reqd,
			'type'=>$questionType,
		);

	
	
		
		$success = true;
		
		$temp_success =  $this->db->insert($this->config->item('tbl_filterQuestion','dbtables'),$data);
		$success = $success && $temp_success;
		
		
		
		if(!$success)
			GOTO remove_question;
		else
			$questionId = $this->db->insert_id();

		
			
		
		switch($questionType) {
			case 'SINGLE':
			foreach($options as $key=>$value) {
				$data = array(
					'filter_question_id'=> $questionId,
					'answer'=>$value,
					'continue_poll'=>$continue[$key]
				);
				$temp_success =  $this->db->insert($this->config->item('tbl_filterQuestionAnswer','dbtables'),$data);
				$success = $success && $temp_success;
			}
			
			break;
			
			case 'MULTIPLE':
			foreach($options as $key=>$value) {
				$data = array(
					'filter_question_id'=> $questionId,
					'answer'=>$value,
					'continue_poll'=>$continue[$key]
				);
				$temp_success =  $this->db->insert($this->config->item('tbl_filterQuestionAnswer','dbtables'),$data);
				$success = $success && $temp_success;
			}
						
			break;
			
	}	
		
	if($success)
		return success;

	
	remove_question:
		return false;
		

		
}	
	
	
	public function updateFilterQuestion($id,$questionType,$question,$ans_reqd,$options,$continue) {
	
		
	
		$data = array(
			'question'=>$question,
			'required'=>$ans_reqd,
			'type'=>$questionType,
		);

	
	
		
		$success = true;
		
		$this->db->where('id',$id);
		$temp_success =  $this->db->update($this->config->item('tbl_filterQuestion','dbtables'),$data);
		$success = $success && $temp_success;
		
		$this->db->where('filter_question_id',$id);
		$this->db->delete($this->config->item('tbl_filterQuestionAnswer','dbtables'));
		$questionId = $id;

		
			
		
		switch($questionType) {
			case 'SINGLE':
			foreach($options as $key=>$value) {
				$data = array(
					'filter_question_id'=> $questionId,
					'answer'=>$value,
					'continue_poll'=>$continue[$key]
				);
				$temp_success =  $this->db->insert($this->config->item('tbl_filterQuestionAnswer','dbtables'),$data);
				$success = $success && $temp_success;
			}
			
			break;
			
			case 'MULTIPLE':
			foreach($options as $key=>$value) {
				$data = array(
					'filter_question_id'=> $questionId,
					'answer'=>$value,
					'continue_poll'=>$continue[$key]
				);
				$temp_success =  $this->db->insert($this->config->item('tbl_filterQuestionAnswer','dbtables'),$data);
				$success = $success && $temp_success;
			}
						
			break;
			
	}	
		
	if($success)
		return success;

	
	remove_question:
		return false;
		

		
}	
	
	
	
	public function saveFilters($id,$ageGroup,$gender,$country,$province,$relationship,$familyStatus,$educationLevel,$incomeGroup,$jobFunction,$jobStatus,$interest) {
	
	
	$reset_tables = array($this->config->item('tbl_ageGroupFilter','dbtables'),$this->config->item('tbl_countryFilter','dbtables'),$this->config->item('tbl_provinceFilter','dbtables'),$this->config->item('tbl_relationshipFilter','dbtables'),$this->config->item('tbl_familyStatusFilter','dbtables'),$this->config->item('tbl_educationFilter','dbtables'),$this->config->item('tbl_incomeGroupFilter','dbtables'),$this->config->item('tbl_jobFunctionFilter','dbtables'),$this->config->item('tbl_jobStatusFilter','dbtables'),$this->config->item('tbl_interestFilter','dbtables'));
	
	
	foreach($reset_tables as $key=>$value){
		$this->db->where('poll_id',$id);
		$this->db->delete($value);
	
	}
	
	
	
	if(is_array($ageGroup)){
		foreach($ageGroup as $value)		// Save AgeGroup Filter for poll
			$this->db->insert($this->config->item('tbl_ageGroupFilter','dbtables'),array('poll_id'=>$id,'age_group_id'=>$value));
	
	}
	
	$this->db->where('id',$id);			// SAVE GENDER DEMOGRAPHICS FOR POLL
	$this->db->update($this->config->item('tbl_poll','dbtables'),array('gender'=>$gender));

	
	if(is_array($country)) {
		foreach($country as $value)		// Save country filters for poll
			$this->db->insert($this->config->item('tbl_countryFilter','dbtables'),array('poll_id'=>$id,'country_id'=>$value));
	}
	

	if(is_array($province)) {	
		foreach($province as $value) {	// Save province filter for poll
			$countryInfo = $this->db->get_where($this->config->item('tbl_province','dbtables'),array('id'=>$value))->row();				// get a country for a province
			

			
			$this->db->insert($this->config->item('tbl_provinceFilter','dbtables'),array('poll_id'=>$id,'country_id'=>$countryInfo->country_id,'province_id'=>$value));	// set the country for the province
		}
	}	
		
	
	if(is_array($relationship)) {
		foreach($relationship as $value) {	// save relationship filters for a poll	
			$this->db->insert($this->config->item('tbl_relationshipFilter','dbtables'),array('poll_id'=>$id,'relationship_id'=>$value));
		}
	}	
	if(is_array($familyStatus)) {
		foreach($familyStatus as $value) {	// save family status filters for a poll	
			$this->db->insert($this->config->item('tbl_familyStatusFilter','dbtables'),array('poll_id'=>$id,'family_status_id'=>$value));
		}
	}		
	
	if(is_array($educationLevel)) {	
		foreach($educationLevel as $value) { // save education filters for a poll	
			$this->db->insert($this->config->item('tbl_educationFilter','dbtables'),array('poll_id'=>$id,'education_id'=>$value));
		}
	}		
	
	if(is_array($incomeGroup)) {	
		foreach($incomeGroup as $value) {	// save income group filters for a poll
			$this->db->insert($this->config->item('tbl_incomeGroupFilter','dbtables'),array('poll_id'=>$id,'income_group_id'=>$value));
		}
	}
	
	
	if(is_array($jobFunction)) {	
		foreach($jobFunction as $value) {	// save job function filters for a poll	
			$this->db->insert($this->config->item('tbl_jobFunctionFilter','dbtables'),array('poll_id'=>$id,'job_function_id'=>$value));
		}
	}	
	if(is_array($jobStatus)) {
		foreach($jobStatus as $value) {		// save jobs status filters for a poll
			$this->db->insert($this->config->item('tbl_jobStatusFilter','dbtables'),array('poll_id'=>$id,'job_status_id'=>$value));
		}
	}
	
	if(is_array($interest)) {
		foreach($interest as $value) {		// save interest filters for a poll
			$this->db->insert($this->config->item('tbl_interestFilter','dbtables'),array('poll_id'=>$id,'interest_id'=>$value));
		}
	}	
	
	
	return;
	
	
	}
	
	function getPollPackage() {		
		return $this->db->get($this->config->item('tbl_pollPackage','dbtables'))->result();	
	}
	
	function getPollQuestions($pollId,$singleRecord=false) {
	
		if($singleRecord){
		
			
			$question =  $this->db->query('select *, NULL as answers,NULL as scaleQuestions from '.$this->config->item('tbl_pollQuestion','dbtables').' where id='.$singleRecord)->row();

			$question->answers = $this->db->get_where($this->config->item('tbl_pollAnswer','dbtables'),array('poll_question_id'=>$singleRecord))->result();
			
			$question->scaleQuestions = $this->db->get_where($this->config->item('tbl_scaleQuestion','dbtables'),array('poll_question_id'=>$singleRecord))->result();
			
			return $question;
			
			
		}
		else {
		
			return $this->db->get_where($this->config->item('tbl_pollQuestion','dbtables'),array('poll_id'=>$pollId))->result();
		
		
		}
	
	
	}
	
	
	function getDepQuestion($id){
	
		$this->db->select();
		$this->db->from($this->config->item('tbl_pollQuestion','dbtables'));
		$this->db->where('poll_id',$id);
		$this->db->order_by('id','DESC');
		$this->db->limit(1);
		$totalQuestions = $this->db->get()->result();
		
		
		$this->db->select(
		$this->config->item('tbl_pollQuestion','dbtables').".id,".
		$this->config->item('tbl_pollQuestion','dbtables').".question,".
		$this->config->item('tbl_pollAnswer','dbtables').".answer,".
		$this->config->item('tbl_pollAnswer','dbtables').".id as answer_id,"

		);
		$this->db->from($this->config->item('tbl_pollQuestion','dbtables'));
		$this->db->where('poll_id',$id);
		$this->db->where_in('type',array('SINGLE','MULTIPLE'));
		$this->db->join($this->config->item('tbl_pollAnswer','dbtables'),$this->config->item('tbl_pollAnswer','dbtables').".poll_question_id=".$this->config->item('tbl_pollQuestion','dbtables').".id");
		$this->db->group_by($this->config->item('tbl_pollQuestion','dbtables').".id,".$this->config->item('tbl_pollAnswer','dbtables').".id");
		$this->db->order_by($this->config->item('tbl_pollQuestion','dbtables').".id",$this->config->item('tbl_pollAnswer','dbtables').".id");

		$result = $this->db->get()->result();
		
		$questions_id = array();
		foreach($result as $key=>$value){
			if(!in_array($value->id,$questions_id))
				$questions_id[] = $value->id;
		}
		
		
		$last = end($questions_id);
		
		foreach($result as $key=>$value){	
		if($value->id == $last)
			unset($result[$key]);
		
		}
		
		return $result;
		
	}
	
	public function getOtherQuestions($id,$poll_id) {
	
	
	
		$this->db->select();
		$this->db->from($this->config->item('tbl_pollQuestion','dbtables'));
		$this->db->where('id !=',$id);
		$this->db->where('poll_id',$poll_id);
		$this->db->where('id >',$id);
		return $this->db->get()->result();
	
	}
	
	
	public function saveSkipLogic($id,$question,$answers,$dependentQuestions) {
	
	
	
	$this->db->insert($this->config->item('tbl_skipLogic','dbtables'),array('poll_question_id'=>$question,'poll_id'=>$id));
	
	
	
	$skipLogicId = $this->db->insert_id();
	
	foreach($answers as $key=>$value){
		$this->db->insert($this->config->item('tbl_skipLogicAnswers','dbtables'),array('skip_logic_id'=>$skipLogicId,'poll_answer_id'=>$value));
	}
	
	foreach($dependentQuestions as $key=>$value){
		$this->db->insert($this->config->item('tbl_skipLogicQuestions','dbtables'),array('skip_logic_id'=>$skipLogicId,'poll_question_id'=>$value));
	}
	
	return;
	
	
	}
	
	
public function updateSkipLogic($id,$question,$answers,$dependentQuestions) {

	

	$skipLogicId = $id;
	
	
	$this->db->query('delete from '.$this->config->item('tbl_skipLogicAnswers','dbtables').' where skip_logic_id = '.$skipLogicId);
	$this->db->query('delete from '.$this->config->item('tbl_skipLogicQuestions','dbtables').' where skip_logic_id = '.$skipLogicId);
	

	
	foreach($answers as $key=>$value){
		$this->db->insert($this->config->item('tbl_skipLogicAnswers','dbtables'),array('skip_logic_id'=>$skipLogicId,'poll_answer_id'=>$value));
	}
	
	foreach($dependentQuestions as $key=>$value){
		$this->db->insert($this->config->item('tbl_skipLogicQuestions','dbtables'),array('skip_logic_id'=>$skipLogicId,'poll_question_id'=>$value));
	}
	
	return;
	
	
	}

	
	public function getSkipLogics($id='',$skipId='') {
	
	
	if($id!='')
		return $this->db->query('select * from '.$this->config->item('tbl_skipLogic','dbtables').' where poll_id='.$id.' order by id')->result();
	else
	{
			$skip = $this->db->query('select *,NULL as answers,NULL as questions from '.$this->config->item('tbl_skipLogic','dbtables').' where id='.$skipId)->row();

				
				$skip->answers = $this->db->get_where($this->config->item('tbl_skipLogicAnswers','dbtables'),array('skip_logic_id'=>$skip->id))->result();
				$skip->questions = $this->db->get_where($this->config->item('tbl_skipLogicQuestions','dbtables'),array('skip_logic_id'=>$skip->id))->result();		
			
			return $skip;
		
		
	
	}
}	
	public function getIncompletePolls($userId)					// Get all Incomplete Polls
	{
		$this->db->select();
		$this->db->from($this->config->item('tbl_poll','dbtables'));
		$this->db->where('user_id',$userId);
		$this->db->where('status','DRAFT');
		$this->db->or_where('status','INCOMPLETE');
		return $this->db->get()->result();
		
		
	}
	
	
	public function savePollStat($pollId,$visibility) {
	
		
		
		$this->db->where('id',$pollId);
		$this->db->update($this->config->item('tbl_poll','dbtables'),array('visibility'=>$visibility));
	
		return;
	}
	
	
	public function getPollInfo($id){
	
		return $this->db->get_where($this->config->item('tbl_poll','dbtables'),array('id'=>$id))->row();
	
	}
	
	
	public function getPackageInfo($package) {
	
		return $this->db->get_where($this->config->item('tbl_pollPackage','dbtables'),array('id'=>$package))->row();
	
	}
	
	public function pollPaymentInit($pollId,$amount,$package){	
		$this->db->insert($this->config->item('tbl_pollPayments','dbtables'),array('poll_id'=>$pollId,'amount'=>$amount,'package'=>$package));
		return $this->db->insert_id();	
	}
	
	public function getOrderDetails($orderId) {
		return $this->db->get_where($this->config->item('tbl_pollPayments','dbtables'),array('id'=>$orderId))->row();
	}
	
	public function publishPoll($orderId,$pollId,$package) {
	
		$this->db->where('id',$orderId);
		$this->db->update($this->config->item('tbl_pollPayments','dbtables'),array('status'=>'COMPLETE'));
		
		$this->db->where('id',$pollId);
		$this->db->update($this->config->item('tbl_poll','dbtables'),array('pollPackage_id'=>$package,'status'=>'PUBLISHED'));
		
		return;

	}
	
	public function paymentFailed($orderId) {
		$this->db->where('id',$orderId);
		$this->db->update($this->config->item('tbl_pollPayments','dbtables'),array('status'=>'FAILED'));	
		return;
	
	}
	
	public function getCompletePollDetails($id,$recurse = false){
	
		$pollTable = $this->config->item('tbl_poll','dbtables');
		$questionTable = $this->config->item('tbl_pollQuestion','dbtables');
		$answerTable = $this->config->item('tbl_pollAnswer','dbtables');
		
		
	if(!$recurse){	
		$this->db->select($pollTable.'.id as poll_id, '.$pollTable.'.title as poll_title, '.$questionTable.'.id as question_id, '.$questionTable.'.question, '.
		$questionTable.'.allow_text, '.$questionTable.'.type, '.$answerTable.'.answer, '.$answerTable.'.label, '.$answerTable.'.text, '.$this->config->item('tbl_scaleQuestion','dbtables').'.scale_question');
		$this->db->from($pollTable);
		$this->db->join($questionTable,$pollTable.'.id = '.$questionTable.'.poll_id','LEFT');
		$this->db->join($answerTable,$questionTable.'.id = '.$answerTable.' .poll_question_id','LEFT');
		$this->db->join($this->config->item('tbl_scaleQuestion','dbtables'),$questionTable.'.id = '.$this->config->item('tbl_scaleQuestion','dbtables').' .poll_question_id','LEFT');
		$this->db->where($pollTable.'.id',$id);		
		$this->db->group_by(array($questionTable.'.id',$this->config->item('tbl_scaleQuestion','dbtables').'.id',$answerTable.'.id'));
		
		return $result = $this->db->get()->result();
	}
	else{
	
			$pollDetails = $this->db->query('select *,NULL as questions from '.$pollTable.' where id='.$id)->row();
			
			$pollDetails->questions = $this->db->query('select *, NULL as answers,NULL as scaleQuestions  from '.$questionTable.' where poll_id='.$id)->result();
			
			foreach($pollDetails->questions as $k=>$v){	
				$pollDetails->questions[$k]->answers = $this->db->query('select * from '.$answerTable.' where poll_question_Id='.$v->id)->result();	

				if($v->type == 'SCALE'){
					$pollDetails->questions[$k]->scaleQuestions =  $this->db->query('select * from '.$this->config->item('tbl_scaleQuestion','dbtables').' where poll_question_Id='.$v->id)->result(); 
				
				}
			}		
			return $pollDetails;
		}
	
}


	
	
	
	
	
	public function getFilterQuestions($id){
	
	
		$this->db->select($this->config->item('tbl_filterQuestion','dbtables').'.id, '.$this->config->item('tbl_filterQuestion','dbtables').'.question, '.$this->config->item('tbl_filterQuestion','dbtables').'.type, '.$this->config->item('tbl_filterQuestion','dbtables').'.required');
		$this->db->from($this->config->item('tbl_filterQuestion','dbtables'));
		$this->db->where($this->config->item('tbl_filterQuestion','dbtables').'.poll_id',$id);
		
		return $this->db->get()->result();
		
	
	
	
	}
	
	public function getsingleFilterQuestion($id){
	
			$this->db->select($this->config->item('tbl_filterQuestion','dbtables').'.id, '.$this->config->item('tbl_filterQuestion','dbtables').'.question, '.$this->config->item('tbl_filterQuestion','dbtables').'.type, '.$this->config->item('tbl_filterQuestion','dbtables').'.required,'.$this->config->item('tbl_filterQuestionAnswer','dbtables').'.answer,'.$this->config->item('tbl_filterQuestionAnswer','dbtables').'.continue_poll');
		$this->db->from($this->config->item('tbl_filterQuestion','dbtables'));
		$this->db->join($this->config->item('tbl_filterQuestionAnswer','dbtables'),$this->config->item('tbl_filterQuestion','dbtables').'.id='.$this->config->item('tbl_filterQuestionAnswer','dbtables').'.filter_question_id','left');
		$this->db->group_by($this->config->item('tbl_filterQuestionAnswer','dbtables').'.id',$this->config->item('tbl_filterQuestion','dbtables').'.id');
		$this->db->order_by($this->config->item('tbl_filterQuestionAnswer','dbtables').'.id',$this->config->item('tbl_filterQuestion','dbtables').'.id');
		$this->db->where($this->config->item('tbl_filterQuestion','dbtables').'.id',$id);

		return $this->db->get()->result();
	
	}
	
	public function getPollTemplates() {
	
		$pollCategory = $this->db->query('select id as pollCategory_id, category_name as pollCategoryName, NULL as polls from '.$this->config->item('tbl_pollCategory','dbtables'))->result();
		
		
		foreach($pollCategory as $key=>$value){
		
			$pollCategory[$key]->polls = $this->db->query('select * from '.$this->config->item('tbl_poll','dbtables').' where poll_category_id = '.$value->pollCategory_id.' and poll_type="TEMPLATE" and status="PUBLISHED"')->result();

		}
		
		return $pollCategory;
	
	
	}
	
	
	public function copyPollDetails($pollId,$templateId){
	
	//get questions
	
	// get answers
	

	$pollDetails = $this->getCompletePollDetails($templateId,true);
	
	
	
	foreach($pollDetails->questions as $key=>$value){
	
		$value->poll_id = $pollId;

		$this->db->insert($this->config->item('tbl_pollQuestion','dbtables'),	
			array(
			'poll_id'=>$pollId,
			'question'=>$value->question,
			'required'=>$value->required,
			'allow_text'=>$value->allow_text,
			'type'=>$value->type,
			'status'=>$value->status,
			'filter_ques'=>$value->filter_ques
			)
		
		);
		
		$questionId = $this->db->insert_id();echo '<br/>';
		
		
		foreach($value->answers as $k=>$v){
			$v->pollQuestion_id = $questionId;
			
			$this->db->insert($this->config->item('tbl_pollAnswer','dbtables'),array(
			'poll_question_Id'=>$v->pollQuestion_id,
			'answer'=>$v->answer,
			'label'=>$v->label,
			'text'=>$v->text
			));
		}
		
		if($value->type == 'SCALE'){
			foreach($value->scaleQuestions as $k=>$v ){
				$v->pollQuestion_id = $questionId;			
				$this->db->insert($this->config->item('tbl_scaleQuestion','dbtables'),array(
					'poll_question_Id'=>$v->pollQuestion_id,
					'scale_question'=>$v->scale_question
				));
			}
		}
	}

	
	
	}
	
	
	
	
}	
	
/*end of file*/	