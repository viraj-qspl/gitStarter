<?php

class Home extends CI_Controller { 
//Class names must have the first letter capitalized with the rest of the name lowercase. The filename will be a lower case version of your class name.
//    static $question_anwered_cnt;
    
    function __construct() 
    {
    	// Call to Controller constructor
        parent::__construct(); 
	// parse_str( $_SERVER['QUERY_STRING'], $_REQUEST );
		//$CI = & get_instance();
       // $CI->config->load("facebook",TRUE);
//         $config = $CI->config->item('facebook');
        $this->config->load("facebook",TRUE);
        $config = $this->config->item('facebook');
        $this->load->library('Facebook', $config);
        
        $this->load->model('user_model');
    }

	function index($passArg = array())
	{            
            // Try to get the user's id on Facebook
		$userId = $this->facebook->getUser();
               
		// If user is not yet authenticated, the id will be zero
		if($userId == 0){
                        $this->session->sess_destroy();
                        
			// Generate a login url
			$passArg['url'] = $this->facebook->getLoginUrl(array('scope'=>'email'));
                        
                        $this->load->view('/layout',$passArg);
                        
		} else {
                    
//                    if($this->user_model->getIdFromFacebookId($userId))
//                    {
//                        $this->facebookLogout();
//                    }
//                    else
//                    {
                         // Get user's data and print it
			$user = $this->facebook->api('/me');
                        
                        if($user)
                        {
                            $this->loginWithFacebook($user);
                        }
                        else
                        {
                            $this->facebookLogout();
                        }
//                    }
                }
               
	}
        
        function facebookLogout() {
            $this->facebook->destroySession();
            $this->session->sess_destroy();

            $logout_url = $this->facebook->getLogoutUrl(array('scope'=>'email'));
            redirect($logout_url);
        }
        
	function login()
	{
		$this->load->model('login_model');
                
		$resArr = $this->login_model->loginCheck();
		
 		if(count($resArr)>0)
		{ 
			// Login Correct
			$this->session->sess_create();
			foreach ($resArr as $row)
			{
				$sessArr= array(
						   'user_id'  	=> $row->id,				
						   'email'     	=> $row->email,
                                                   'first_poll' => $row->first_poll,
						   'user_type'   => USER
						);
                                
				$this->session->set_userdata($sessArr);
				
                                if($this->session->userdata('first_poll')== YES)
                                {
                                    $viewArr['viewPage'] = "newhome";      //show home page
                                }
                                else
                                {
                                    $last_answered_question = $this->user_model->getLastAnsweredQuestion($this->session->userdata('user_id'));
                                    $viewArr['last_question_answered'] =  $last_answered_question + 1;
                                    $viewArr['viewPage'] = "first_poll";
                                }
                                
                                $this->load->view('/layout', $viewArr);
			}
		}
                else
		{ 
                    // Login In-correct
                    $passArg['login_errorMsg']  = "Invalid login. Please try again.";
                    $this->index($passArg);
		} 
	}
        
        function loginWithFacebook($user)
        {
            $this->load->library('user_obj');

            $recordObj = new $this->user_obj;
            $recordObj->setEmail($user['email']);
            $recordObj->setUser_type(USER);
            $recordObj->setFirst_poll(NO);
            $recordObj->setFacebook_id($user['id']);
            $recordObj->setGender($user['gender']);
            $recordObj->setLast_name($user['last_name']);
            $recordObj->setName($user['first_name']);

            $id =  $this->user_model->getIdFromEmail($user['email']);
            if(isset($id))
            {
                $recordObj->setId($id);
                $recordObj->setLast_updated(date('Y-m-d H:m:s'));   //if email present then update
            }
            else
            {
                $recordObj->setCreated_date(date('Y-m-d H:m:s')); //else insert
            }

            $queryFlag = $this->user_model->saveLoginDetailsFromFacebook($recordObj);           

            //since after registration user is not directed to login, save email, user_id in session for further use.
            $user_id = $this->user_model->getIdFromEmail($recordObj->getEmail());
            $recordObj->setId($user_id);

            $this->session->sess_create();

            $sessArr= array(
                               'user_id'  	=> $recordObj->getId(),				
                               'email'     	=> $recordObj->getEmail(),
                               'user_type'   => USER,
                               'first_poll' => NO
                            );

            $this->session->set_userdata($sessArr);

            if($this->session->userdata('first_poll')== YES)
            {
                $viewArr['viewPage'] = "newhome";      //show home page
            }
            else
            {
                $last_answered_question = $this->user_model->getLastAnsweredQuestion($this->session->userdata('user_id'));
                if($last_answered_question)
                {
                    $last_answered_question = 0;
                }
                $viewArr['last_question_answered'] =  $last_answered_question + 1;
                $viewArr['viewPage'] = "first_poll";
            }

            $viewArr['logout_url'] = $this->facebook->getLogoutUrl(array('scope'=>'email'));
            $this->load->view('/layout', $viewArr);
        }
        
        /**
     * 
     * This function performs add and edit operations. For add operation, record will be inserted while for edit operation, record will be updated.
     */
    function save() {
        // Load form validation library 
        $this->load->library('form_validation');

        // Set operation type
        $dataArr['oprType'] = $this->input->post('oprType');
        
        // Set validation rules	
        $this->setFormValidationRules($dataArr);
       
        // Create buy_sell object based on user input
                   
        // Validate data 
            
        if ($this->form_validation->run() == FALSE) { //Validation failed
            // Show add/edit form with recordObj
            //log_message("info", " ===========> form_validation false " );

            //$this->addEditForm($recordObj);
           
            $passArg['viewPage'] = "newhome";
            $passArg['signup_errorMsg'] = validation_errors();  // form validation error will be displayed and not from language file.
            $this->load->view('layout', $passArg);
            
            
        } else {  // Validation successful

            $recordObj = $this->createRecordObj();
     
        if($this->user_model->isEmailPresent($recordObj->getEmail()))
        {
            $passArg['viewPage'] = "newhome";
            $passArg['signup_errorMsg']  = $this->lang->line('info.duplicate.email');
            $this->load->view('layout',$passArg);
        }
        else
        {   
            $queryFlag = $this->user_model->save($recordObj);           
            
//            $dataArr['oprStatus'] = ($queryFlag == true) ? OPR_SUCCESS : OPR_FAILED; // oprStatus is used to apply CSS formating when message (success/failed) is shown to user
//            $dataArr['oprMessage'] = $this->common_method->getMessage($dataArr['oprType'], $queryFlag); // Operation message, eg: Add Success or Edit Success etc
//           
            //since after registration user is not directed to login, save email, user_id in session for further use.
            $user_id = $this->user_model->getIdFromEmail($recordObj->getEmail());
            $recordObj->setId($user_id);
                    
            $this->session->sess_create();
            
            $sessArr= array(
                               'user_id'  	=> $recordObj->getId(),				
                               'email'     	=> $recordObj->getEmail(),
                               'user_type'   => USER,
                               'first_poll' => NO
                            );
            $this->session->set_userdata($sessArr);
          
//           print_r($this->session->all_userdata()); exit;
            //get poll points from poll model
            $this->load->model('poll_settings_model');
            $firstPollRewardPoints = $this->poll_settings_model->getFirstPollPoints();
            
            $this->load->library('settings_obj');
            $settings_recordObj = new $this->settings_obj;
            $settings_recordObj->setFirst_poll($firstPollRewardPoints);
            
            //load first poll view
            $viewArr['viewPage'] = "registration_successfull";
            $viewArr['pollPoints']  = $firstPollRewardPoints;
            
            $this->load->view('/layout', $viewArr);

            // Write to log file	
            log_message('info', 'Login Form - displayed');
        }            
        }
    }
    
    
    function setFormValidationRules($argViewArr) {
        // Check for non-empty, min and max length
        $this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[5]|xss_clean|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[1]|xss_clean');
        $this->form_validation->set_rules('day', 'Birth Date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('month', 'Birth Date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('year', 'Birth Date', 'trim|required|xss_clean');
        
        $this->form_validation->set_rules('gender', 'Gender', 'trim|required|xss_clean');

        // Add more form validation rules here...
        // Set the error delims to a nice styled red hint under the fields
        $this->form_validation->set_error_delimiters('<div id="errorMsg">', '</div>');
    }
    
     /**
     * This function creates buy_sell object having data provided by user.
     */
    function createRecordObj() {  
        $this->load->library('user_obj');
        // Create buy_sell object, set values
        $recordObj = new $this->user_obj;
        
        // Check if id is "X", which is for Add operation. If "X", set id to NULL.
        $id = ($this->input->post('id') == "X") ? NULL : $this->input->post('id');
        $recordObj->setId($id);
        
        $recordObj->setUser_type( $this->input->post('user_type'));
        $recordObj->setEmail($this->input->post('email'));
        $recordObj->setPassword(md5($this->input->post('password')));
       
        $recordObj->setFirst_poll(NO);
        $recordObj->setGender($this->input->post('gender'));
       
        $birthDate = $this->input->post('year') . "/" .$this->input->post('month') . "/" . $this->input->post('day');
        $recordObj->setDob($birthDate);
       
        $recordObj->setCreated_date(date("Y-m-d H:m:s"));
        return $recordObj;
    }
    
    /**
     * 
     * This function displays form to Add or Edit record
     */
    function addEditForm($argRecordObj = null) {
        $this->load->library('user_list');
        // Get data object and execute query
        $listDataObj = $this->user_list->getInstance();

        // Check if this function is called from form-validation with parameter
        if (is_object($argRecordObj) && $argRecordObj != NULL) {
            // call from Validation form
           
            $recordObj = $argRecordObj;
        }
        else {
            // New call for either Add or Edit data
            $recordObj = $this->user_model->getRecords($listDataObj->getId()); 
        }

        // Based on recordObj set other parameters		
        if ($recordObj == NULL) { // Add operation
            $dataArr['oprType'] = OPR_ADD;
            $recordObj = new $this->user_obj;
        } 
        else { // Edit operation	
            $dataArr['oprType'] = OPR_EDIT;
        }

        // Set values in dataObj
        $listDataObj->setOprType($dataArr['oprType']);
        $listDataObj->setDbDataArr(array($recordObj));

        // Pass data to view/template
        $viewArr['listDataObj'] = $listDataObj;
         
        // Display output page		
        $viewArr['viewPage'] = "newhome";
        $this->load->view('/layout', $viewArr);

        // Write to log file	
        log_message('info', 'Add/Edit Form - displayed');
    }

    public function forgotPassword() {
        $toEmail = $this->input->post('email');
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('email', 'email', 'required|max_length[100]|valid_email');

        if ($this->form_validation->run() == FALSE) {
            $passArg['viewPage'] = "newhome";
            $passArg['$forgot_password_errorMsg'] = validation_errors();  // form validation error will be displayed and not from language file.
            $this->load->view('layout', $passArg);
//          $passArg['errorMsg']  = $this->lang->line('info.empty.email');
        } 
        else
        {
            $this->load->model('user_model');
            $user_id = $this->user_model->getIdFromEmail($toEmail);
            
            if($user_id == 0)
            {
                $passArg['viewPage'] = "newhome";
                $passArg['forgot_password_errorMsg'] = $this->lang->line('info.invalid.userid');
                $this->load->view('layout', $passArg);
            }
            else
            {
                $recordObj = new $this->user_obj;
                $recordObj->setEmail($toEmail);
                $recordObj->setId($user_id);

                $randomPassword = random_string('alnum', 6);
                
                $recordObj->setPassword($randomPassword);
                
                //update password to database
                $status = $this->user_model->updatePassword($recordObj);
                
                if($status)
                {
                    $sentStatus =  $this->common_method->sendEmail($recordObj);

                    if($sentStatus)
                    {
                        $passArg['$forgot_password_successMsg']  = $this->lang->line('info.sent.email');
                    }
                    else
                    {
                        $passArg['$forgot_password_errorMsg']  = $this->lang->line('info.notsent.email');
                    }

                    $passArg['viewPage'] = "newhome";
                    $this->load->view('layout',$passArg);
                }
                else {
                    $passArg['viewPage'] = "newhome";
                    $passArg['$forgot_password_errorMsg'] = $this->lang->line('info.password.update.falied');
                    $this->load->view('layout', $passArg);
                }
            }
        }
    }
    
    function contactUsMail()
    {
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('name', 'name', 'required');
        $this->form_validation->set_rules('email', 'email', 'required|valid_email');
        $this->form_validation->set_rules('subject', 'subject', 'required');
        $this->form_validation->set_rules('message', 'message', 'required');

        if ($this->form_validation->run() == FALSE) {
            $passArg['viewPage'] = "contact_us";
            $passArg['$errorMsg'] = validation_errors();  // form validation error will be displayed and not from language file.
            $this->load->view('layout', $passArg);
        } 
        else
        {
            $this->load->model('user_model');
            $fromEmail =  $this->input->post('email');
            $fromName = $this->input->post('name');
            $subject =  $this->input->post('subject');
            $message = $this->input->post('message');
            
            $user_id = $this->user_model->getIdFromEmail($fromEmail);
            
            if($user_id == 0)
            {
                $passArg['viewPage'] = "contact_us";
                $passArg['forgot_password_errorMsg'] = $this->lang->line('info.invalid.userid');
                $this->load->view('layout', $passArg);
            }
            else
            {                
                $this->load->library('email');
                
                $config = array('mailtype' => 'html');
                $this->email->initialize($config);

                $this->email->clear(TRUE);

                $this->email->from($fromEmail, $fromName);
                $this->email->to($this->config->item('fromEmail')); 

                $this->email->subject($subject);

//                $templateName = "conctactUs";
//                $templateData = array("email" => $fromEmail, "password" => $argObj->getPassword(), "user_id" => $argObj->getId()); 
//                $email_message = $CI->load->view('emailtemplates/' . $templateName, $templateData, TRUE);

                $this->email->message($message);	

                $sentStatus = $this->email->send();

                if($sentStatus)
                {
                    $passArg['$successMsg']  = $this->lang->line('info.sent.email');
                }
                else
                {
                    $passArg['$errorMsg']  = $this->lang->line('info.notsent.email');
                }

                $passArg['viewPage'] = "newhome";
                $this->load->view('layout',$passArg);
                
            }
        }
    }
    
    function createRegistrationQuestions($question_id)
    {
        $questions_list = $this->config->item('questions');
        
        $this->load->model('user_model');
            
        $output_question_array = array();
        $dataObjArr = "";
        $subquestions_array = "";
        
        log_message("INFO", " in if == > question_id:   $question_id");
            
            $output_question_array['q_id'] = $question_id;
            $output_question_array['text'] = $questions_list[$question_id][0];
            $output_question_array['type'] = $questions_list[$question_id][1];
       
            $answer_array = array();
                
            if($question_id == "1")
            {
                log_message("INFO", " in if == > if ==> question_id:   $question_id");
                $this->load->model('region_model');
                $regionDataArr = $this->region_model->getRegionList();
       
                foreach ($regionDataArr as $regionData) {
                    $option_array['ans_id'] = $regionData->id;
                    $option_array['ans_text'] = $regionData->region;

                    array_push($answer_array, $option_array);
                }
              
            $dataObjArr = "regionObjArr";
            $output_question_array['answer'] = $answer_array;
            $output_question_array['subQuestions'] = $subquestions_array;  
            }
           
            if($question_id == "2")
            {      
                 log_message("INFO", " in if == > if ==> question_id:   $question_id");
                $user_id = $this->session->userdata('user_id');
                $region_id = $this->user_model->getRegionIdByUserId($user_id);
                
                $this->load->model('province_model');
                $provinceDataArr = $this->province_model->getProvinceListByRegionId($region_id);
                
                foreach ($provinceDataArr as $provinceData) {
                    $option_array['ans_id'] = $provinceData->id;
                    $option_array['ans_text'] = $provinceData->province;
                 
                    array_push($answer_array, $option_array);
                }
                
                $output_question_array['answer'] = $answer_array;
                $output_question_array['subQuestions'] = $subquestions_array;
                $dataObjArr = "provinceObjArr";
            }
            
            if($question_id == "3")
            {
                log_message("INFO", " in if == > if ==> question_id:   $question_id");
                $answer_array = array();
                $option_array['ans_id'] = 1;
                $option_array['ans_text'] = MALE;
                array_push($answer_array, $option_array);
                
                $option_array['ans_id'] = 2;
                $option_array['ans_text'] = FEMALE;
                array_push($answer_array, $option_array);
            
                $output_question_array['answer'] = $answer_array;
                $output_question_array['subQuestions'] = $subquestions_array;
                
                $dataObjArr = "genderObjArr";
            }
            
            //q4 date of birth
            if($question_id == "4")
            {
                log_message("INFO", " in if == > if ==> question_id:   $question_id");
                $answer_array = array();
                $output_question_array['answer'] = $answer_array;
                $output_question_array['subQuestions'] = $subquestions_array;
                $dataObjArr = "dobObjArr";
            }
            
            if($question_id == "5")
            {
                log_message("INFO", " in if == > if ==> question_id:   $question_id");
                $educationDataArr = $this->user_model->getEducationList();
                
                $answer_array = array();
                foreach ($educationDataArr as $educationData) {
                    $option_array['ans_id'] = $educationData->id;
                    $option_array['ans_text'] = $educationData->edu_level;
                    
                    array_push($answer_array, $option_array);
                }
                
                $output_question_array['answer'] = $answer_array;
                $output_question_array['subQuestions'] = $subquestions_array;
                $dataObjArr = "educationObjArr";
            }
            
            if($question_id == "6")
            {
                log_message("INFO", " in if == > if ==> question_id:   $question_id");
                $incomeDataArr =  $this->user_model->getIncomeList();
                
                $answer_array = array();
                foreach ($incomeDataArr as $incomeData) {
                    $option_array['ans_id'] = $incomeData->id;
                    $option_array['ans_text'] = $incomeData->label;
                    
                    array_push($answer_array, $option_array);
                }
                
                $output_question_array['answer'] = $answer_array;
                $output_question_array['subQuestions'] = $subquestions_array;
                $dataObjArr = "incomeObjArr";
            }
            
            if($question_id == "7")
            {
                log_message("INFO", " in if == > if ==> question_id:   $question_id");
                $jobFunctionDataArr = $this->user_model->getJobFunctionList();
        
                $answer_array = array();
                foreach ($jobFunctionDataArr as $jobfunctionData) {
                    $option_array['ans_id'] = $jobfunctionData->id;
                    $option_array['ans_text'] = $jobfunctionData->job_function;
                  
                    array_push($answer_array, $option_array);
                }
                
                $dataObjArr = "jobFucntionObjArr";
                
                $output_question_array['answer'] = $answer_array;
                
                $jobStatusDataArr = $this->user_model->getJobStatusList();
       
                $subquestions_array['subQ_id'] = 'a' ;
                $subquestions_array['text'] = $questions_list['a'][0];
                $subquestions_array['type'] = $questions_list['a'][1];

                $sub_answer_array = array();
                
                foreach ($jobStatusDataArr as $jobStatusData) {
                    $option_array['ans_id'] = $jobStatusData->id;
                    $option_array['ans_text'] = $jobStatusData->job_status_label;
                    array_push($sub_answer_array, $option_array);
                }

                $subquestions_array['answer'] = $sub_answer_array;

                $output_question_array['subQuestions'] = $subquestions_array;
            }
            
            if($question_id == "8")
            {
                log_message("INFO", " in if == > if ==> question_id:   $question_id");
                $relationshipStatusDataArr = $this->user_model->getRelationshipStatusList();
                
                $answer_array = array();
                foreach ($relationshipStatusDataArr as $relationshipData) {
                    $option_array['ans_id'] = $relationshipData->id;
                    $option_array['ans_text'] = $relationshipData->relationship_label;
                 
                    array_push($answer_array, $option_array);
                }
               
                $dataObjArr = "relationshipStatusObjArr";
                $output_question_array['answer'] = $answer_array;
                $output_question_array['subQuestions'] = $subquestions_array;
            }
            
            if($question_id == "9")
            {
                log_message("INFO", " in if == > if ==> question_id:   $question_id");
                $familyStatusDataArr = $this->user_model->getFamilyStatusList();
                 
                $answer_array = array();
                foreach ($familyStatusDataArr as $familyStatusData) {
                    $option_array['ans_id'] = $familyStatusData->id;
                    $option_array['ans_text'] = $familyStatusData->family_status_label;
                    
                    array_push($answer_array, $option_array);
                }
                
                $dataObjArr = "familyStatusObjArr";
                $output_question_array['answer'] = $answer_array;
                $output_question_array['subQuestions'] = $subquestions_array;
            }
            
            if($question_id == "10")
            {
                log_message("INFO", " in if == > if ==> question_id:   $question_id");
                $this->load->model('interest_model');
                $interestDataArr =  $this->interest_model->getInterestList();
//                echo "<pre>"; print_r($interestDataArr); echo "<pre/>" ; exit;
                foreach($interestDataArr as $main_category => $sub_category_array)
                {                          
                    foreach($sub_category_array as $sub_category)
                    {
                        $option_array['ans_id'] = $sub_category->id;
                        $option_array['ans_text'] = $sub_category->interest;
                        array_push($answer_array, $option_array);
                    }
                    $main_array[$main_category] = $answer_array;
                    $answer_array =  array();
                }
                
                $dataObjArr = "interestObjArr";
                $output_question_array['answer'] = $main_array;
                $output_question_array['subQuestions'] = $subquestions_array;
            }
            
            $passArg[$dataObjArr] = $output_question_array;
            return $passArg;
    }
    
    function showRegistrationQuestions($question_id = null)
    {
        log_message("INFO", "====================== question_id:   $question_id");
           
        if(isset($question_id) && $question_id <= LASTQUESTION)
        { 
            $passArg = $this->createRegistrationQuestions($question_id);
            $passArg['viewPage'] = "registration_question";
            $passArg['qn_count'] =  $question_id;

            $this->load->view('layout', $passArg);
        }
        else if(isset($_POST['q_id']) && isset($_POST['field']) && $question_id <= LASTQUESTION)
        {  
             $question_id = $this->input->post('q_id');
             $field_name = $this->input->post('field');
             
//             $this->load->library('form_validation');             
//             
//             switch ($field_name) {
//                 case DOB:
//                     $this->form_validation->set_rules(YEAR, YEAR, 'required');
//                     $this->form_validation->set_rules(MONTH, MONTH, 'required');
//                     $this->form_validation->set_rules(DAY, DAY, 'required');
//
//                     break;
//
//                 case PROVINCE:
//                     
//
//                     break;
//                 
//                 case JOBFUNCTION:
//
//
//                     break;
//                 
//                 case JOBSTATUS:
//
//
//                     break;
//                 
//                 default:
//                     $this->form_validation->set_rules($field_name, $field_name, 'required');
//                     break;
//             }
//             
//             
//             if ($this->form_validation->run() == FALSE) {
//                $passArg = $this->createRegistrationQuestions($question_id);
//                $passArg['viewPage'] = "registration_question";
//                $passArg['errorMsg'] = validation_errors();  // form validation error will be displayed and not from language file.
//                $this->load->view('layout', $passArg);
//    //          $passArg['errorMsg']  = $this->lang->line('info.empty.email');
//             } else {
                 if($question_id == "7"){
                      $sub_field_name = $this->input->post('sub_field');

                      log_message("INFO", " post <======> question_id:   $question_id filedname: $field_name sub_field_name: $sub_field_name");

                      $this->saveRegistrationQuestion($question_id,$field_name,$sub_field_name);
                 } else {                 
                     log_message("INFO", " post  >==========<  question_id:   $question_id filedname: $field_name");
                     $this->saveRegistrationQuestion($question_id,$field_name);
                 }
//             }
        }
        else if($question_id > LASTQUESTION)
        {
            log_message("INFO", " in  compare else == >");

            $this->load->model('poll_settings_model');
            $firstPollRewardPoints = $this->poll_settings_model->getFirstPollPoints();

            $this->load->library('settings_obj');
            $settings_recordObj = new $this->settings_obj;
            $settings_recordObj->setFirst_poll($firstPollRewardPoints);

            $recordObj = new $this->user_obj;
            
//            print_r($this->question_anwered_cnt); exit;
//            if($this->question_anwered_cnt == LASTQUESTION)
//            {
                $this->session->set_userdata('first_poll', YES);
                $recordObj->setId($this->session->userdata('user_id'));
                $recordObj->setFirst_poll(YES);
//            } else {
//                $this->session->set_userdata('first_poll', INCOMPLETE);
//                $recordObj->setId($this->session->userdata('user_id'));
//                $recordObj->setFirst_poll(INCOMPLETE);
//            }
            
            $query_result = $this->user_model->changeFirstPoll($recordObj);
            
            log_message("INFO", " in  compare else == > query_result". $query_result); 
            $passArg['viewPage'] = "poll_successfull";
            $passArg['firstPollRewardPoints'] = $firstPollRewardPoints;

            $this->load->view('layout', $passArg);
        }
    }
        
    function saveRegistrationQuestion($question_id , $fieldname, $sub_field_name = null) {
   
        $this->load->model('user_model');
        
        $recordObj = new $this->user_obj;

        $recordObj->setId($this->session->userdata('user_id'));
        $recordObj->setLast_answered_question($question_id);

        switch ($fieldname) {
          case REGION:
            $objectVar = $this->input->post(REGION);
            $recordObj->setRegion_id($objectVar);
            break;

          case PROVINCE:
            $objectVar = $this->input->post(PROVINCE);
            $recordObj->setProvince_id($objectVar);
            break;

        case GENDER:
            $objectVar = $this->input->post(GENDER);
            $recordObj->setGender($objectVar);
            break;

        case DOB:
            $day = $this->input->post("day");
            $month = $this->input->post("month");
            $year = $this->input->post("year");
            $dob = $year."-".$month."-".$day;

            $recordObj->setDob($dob);
            break;

        case EDUCATION:
            $objectVar = $this->input->post(EDUCATION);
            $recordObj->setEducation_id($objectVar); 
            break;

        case INCOME:
            $objectVar = $this->input->post(INCOME);
            $recordObj->setIncome_group_id($objectVar);
            break;

        case INTEREST:
            $objectArr = $this->input->post(INTEREST); 

            if (count($objectArr) > 0) 
            {
                $this->load->library("user_interest_obj"); 
                $user_interest_arr = array();

                foreach($objectArr as $answer){
                    $record_interest_Obj = new $this->user_interest_obj;
                    $record_interest_Obj->setUser_id($this->session->userdata('user_id'));
                    $record_interest_Obj->setInterest_id($answer);
                    array_push($user_interest_arr, (array)$record_interest_Obj);
                }

                $status = $this->user_model->updateUserInterest($user_interest_arr, $recordObj);
            }    
            break;

        case JOBFUNCTION:
            $objectVar = $this->input->post(JOBFUNCTION);
            $recordObj->setJob_function_id($objectVar);

            $sub_objectVar = $this->input->post(JOBSTATUS);
            $recordObj->setJob_status_id($sub_objectVar);
            $status = $this->user_model->updateFirstPollDetails($recordObj,$sub_field_name);
            break;

        case RELATIONSHIPSTATUS:
            $objectVar = $this->input->post(RELATIONSHIPSTATUS);
            $recordObj->setRelationship_id($objectVar);
            break;

        case FAMILYSTATUS:
            $objectVar = $this->input->post(FAMILYSTATUS);
            $recordObj->setFamily_status_id($objectVar);
            break;
        }

        if($question_id < LASTQUESTION)
        {
            //update password to database
            $status = $this->user_model->updateFirstPollDetails($recordObj,$fieldname);
            log_message("INFO", " updateto db === > status" .$status); 
        }

        if($status){
            $question_id = $question_id + 1;
            
            //set count of answered question to check for poll completeness.       
          
            log_message("INFO", " save registration details === > show question" .$question_id); 
            $this->showRegistrationQuestions($question_id);
        } else {
            log_message("INFO", $this->lang->line('info.update.falied')); 
            $passArg['viewPage'] = "registration_question";
            $passArg['errorMsg'] = $this->lang->line('info.update.falied');
            $this->load->view('layout', $passArg);
        }
    }
    
    function aboutUs()
    {
         $passArg['viewPage'] = "about_us";
         $this->load->view('layout', $passArg);
    }
    
    function contactUs()
    {
         $passArg['viewPage'] = "contact_us";
         $this->load->view('layout', $passArg);
    }
    
    function faq()
    {
         $passArg['viewPage'] = "faq";
         $this->load->view('layout', $passArg);
    }
}
