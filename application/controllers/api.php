<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Api
 *
 * @author mayoori
 */
class Api extends CI_Controller {

    public function __construct() { //default constructor
        parent::__construct(); //call to default constructor of CI_Controller

        $this->load->database();

        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('services_json');
        $this->load->library('common_method'); //user defined class					
        $this->load->library('user_obj');
        $this->load->library('settings_obj');
        $this->load->library('education_obj');
        $this->load->library('income_obj');
        $this->load->library('interest_obj');
        $this->load->library('email');
        $this->config->load('dbtables', TRUE);

        //Define array that will store values to be sent to view page
        $passArg = array();
    }

    /*
     * function login to handle user login request
     * @param: none
     * @return: array of userdata
     * @since: 24th july 2012 	
     */

    function login() {
        //instantiate JSON obj
        $json = new $this->services_json;

        $eEmail = "";
        $ePassword = "";

        if (!isset($_POST['email']) || (isset($_POST['email']) && $_POST['email'] == '')) {
            echo $json->encode(array("response" => array("errorCode" => "1", "message" => 'Please enter valid email id')));
            exit;
        } else {
            $eEmail = trim($_POST['email']);
        }

        if (!isset($_POST['password']) || (isset($_POST['password']) && ($_POST['password'] == '' || $_POST['password'] == "(null)" ))) {
            echo $json->encode(array("response" => array("errorCode" => "2", "message" => 'Please enter password')));
            exit;
        } else {
            $ePassword = trim($_POST['password']);
        }

        $this->load->model('login_model'); //loginModel model is used for validation	
        //Create user obj and set email and password parameters
        $userObj = new $this->user_obj;

        $userObj->setEmail($eEmail);
        $userObj->setPassword($ePassword);

        //check for valid user in database.
        $resArr = $this->login_model->loginCheck($userObj);

        if (count($resArr) > 0) {
            foreach ($resArr as $Objectkey => $object) {
                if ($object->first_poll == "N") {
                    //get poll points from poll model
                    $this->load->model('poll_settings_model');
                    $firstPollRewardPoints = $this->poll_settings_model->getFirstPollPoints();

                    $this->load->library('settings_obj');
                    $settings_recordObj = new $this->settings_obj;
                    $settings_recordObj->setFirst_poll($firstPollRewardPoints);

                    $object->firstPollRewardPoints = $firstPollRewardPoints;    //adding firstPollRewardPoints field to object and passing the value.
                }

                //convert user std class object to string
                $userJsonString = json_encode($object);

                //there was request from mobile team to replace null by "" in json string
                $userNotNullString = str_replace("null", "\"\"", $userJsonString);

                //convert string to associative array
                $userNotNullObjArr = json_decode($userNotNullString, true);
            }

            //Send UserDetails array to iphone device
            // error code = 0 for success and error msg = ""
            echo str_replace('\\/', '/', $json->encode(array("response" => array("errorCode" => '0', 'respData' => $userNotNullObjArr, 'message' => ""))));
            exit;
        } else {
            echo json_encode(array("response" => array("errorCode" => '1', 'message' => " Invalid Login Details ")));
            exit;
        }
    }

    //to register user details in database and provide json response

    function register() {
        //instantiate JSON obj
        $json = new $this->services_json;

        $eEmail = "";
        $ePassword = "";
        $eGender = "";
        $eBirthDate = "";           //yyyy/mm/dd format
        //data is sent using json array hence input is read using post and not using headers
        if (!isset($_POST['email']) || (isset($_POST['email']) && $_POST['email'] == '') || (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == FALSE)) {
            echo $json->encode(array("response" => array("errorCode" => "1", "message" => 'Please enter valid email id')));
            exit;
        } else {
            $eEmail = trim($_POST['email']);
        }

        if (!isset($_POST['password']) || (isset($_POST['password']) && ($_POST['password'] == '' || $_POST['password'] == "(null)" ))) {
            echo $json->encode(array("response" => array("errorCode" => "1", "message" => 'Please enter password')));
            exit;
        } else {
            $ePassword = trim($_POST['password']);
        }

        if (!isset($_POST['gender']) || (isset($_POST['gender']) && ($_POST['gender'] == '' || $_POST['gender'] == "(null)" ))) {
            echo $json->encode(array("response" => array("errorCode" => "1", "message" => 'Please select gender')));
            exit;
        } else {
            $eGender = trim($_POST['gender']);
        }

        if (!isset($_POST['birthdate']) || (isset($_POST['birthdate']) && ($_POST['birthdate'] == '' || $_POST['birthdate'] == "(null)" ))) {
            echo $json->encode(array("response" => array("errorCode" => "1", "message" => 'Please select birthdate')));
            exit;
        } else {
            $eBirthDate = trim($_POST['birthdate']);
        }

        $this->load->model('user_model'); //loginModel model is used for validation	
        $flag = $this->user_model->isEmailPresent($eEmail);

        if ($flag) {
            echo str_replace('\\/', '/', $json->encode(array("response" => array("errorCode" => '1', 'message' => $this->lang->line("info.duplicate.email")))));
            exit;
        } else {
            //Create user obj and set email and password parameters
            $userObj = new $this->user_obj;

            $userObj->setEmail($eEmail);
            $userObj->setPassword(md5($ePassword));
            $userObj->setGender($eGender);
            $userObj->setDob($eBirthDate);
            $userObj->setUser_type(USER);
            $userObj->setFirst_poll("N");        //since user havenot answered the poll
            //check for valid user in database.
            $resArr = $this->user_model->save($userObj);

            //get poll points from poll model
            $this->load->model('poll_settings_model');
            $firstPollRewardPoints = $this->poll_settings_model->getFirstPollPoints();

            $settings_recordObj = new $this->settings_obj;
            $settings_recordObj->setFirst_poll($firstPollRewardPoints);

            $userArr = array();
            $id = null;

            //if record found
            if (count($resArr) > 0) {
                $userArr = $this->user_model->getRecords($id, $userObj->getEmail());

                foreach ($userArr as $Objectkey => $object) {
                    $object->firstPollRewardPoints = $firstPollRewardPoints;
                    //convert user object to string
                    $userJsonString = json_encode($object);

                    //replace null bye "" in json string
                    $userNotNullString = str_replace("null", "\"\"", $userJsonString);

                    //convert string to associative array
                    $userNotNullObjArr = json_decode($userNotNullString, true);
                }
                //Send UserDetails array to iphone device
                echo str_replace('\\/', '/', $json->encode(array("response" => array("errorCode" => '0', 'respData' => $userNotNullObjArr, 'message' => ""))));
                exit;
            } else {
                echo json_encode(array("response" => array("errorCode" => '1', 'message' => "User cannot be created.")));
                exit;
            }
        }
    }

     // This function will validate user email-id, if found, will generate new password and send it as email.
    function forgotPassword() {
        //instantiate JSON obj
        $json = new $this->services_json;

        $eEmail = "";
        $user_id = 0;

        //data is sent using json array hence input is read using post and not using headers
        if (!isset($_POST['email']) || (isset($_POST['email']) && $_POST['email'] == '')) {
            echo $json->encode(array("response" => array("errorCode" => "1", "message" => 'Please enter valid email id')));
            exit;
        } else {
            $eEmail = trim($_POST['email']);
        }

        $this->load->model('user_model');
        $user_id = $this->user_model->getIdFromEmail($eEmail);

        if ($user_id > 0) {
            // User found
            //Create user obj and set email and password parameters
            $recordObj = new $this->user_obj;
            $recordObj->setEmail($eEmail);
            $recordObj->setId($user_id);

            $randomPassword = random_string('alnum', 6);

            $recordObj->setPassword($randomPassword);

            //update password to database
            $status = $this->user_model->updatePassword($recordObj);


            if ($status == TRUE) {

                //calling send mail method from common_method
                // $sentStatus =  $this->common_method->sendEmail($recordObj);
                // Sandeep - for some reasons, mail code in common-methods is not working, hence brought back here.
                $config['protocol'] = 'mail';
                $config['charset'] = 'iso-8859-1';
                $config['mailtype'] = 'html';
                $config['wordwrap'] = FALSE;
                $config['newline'] = "\r\n";
                $config['fromName'] = "Thaipoll";
                $config['fromEmail'] = "mayoori.dessai@quagnitia.com";

                $this->email->initialize($config);

                $this->email->clear(TRUE);

                $this->email->from($this->config->item('fromEmail'), $this->config->item('fromName'));
                $this->email->to($recordObj->getEmail());

                $this->email->subject('New Password On User Request');

                $templateName = "forgotpassword";
                $templateData = array("email" => $recordObj->getEmail(), "password" => $recordObj->getPassword(), "user_id" => $recordObj->getId());
                $email_message = $this->load->view('emailtemplates/' . $templateName, $templateData, TRUE);

                $this->email->message($email_message);

                //$status = $this->email->send(); // there is some error with sendng email, if mail is failed, response is nul
                // echo json_encode(array("response" =>array("errorCode"=>'0','message'=>" About to send email...")));
                //  exit; 


                /* if($this->email->send())
                  {
                  echo json_encode(array("response" =>array("errorCode"=>'0','message'=>" New password is sent to your email.")));
                  exit;
                  }
                  else
                  {

                  echo json_encode(array("response" =>array("errorCode"=>'8','message'=>"Sending Mail Failed")));
                  exit;
                  } */

                // if the email send function return NULL
                echo json_encode(array("response" => array("errorCode" => '0', 'message' => " New password is sent to your email.", "code" => $this->email->send())));
                exit;
            } else {
                echo json_encode(array("response" => array("errorCode" => '9', 'message' => " Password update failed.")));
                exit;
            }
        } else { // user not found
            echo json_encode(array("response" => array("errorCode" => '10', 'message' => " Email-Id does not exist ")));
            exit;
        }
    }
    
    // This function will validate user email-id, if found, will generate new password and send it as email.
    function forgotPassword_test() {
        //instantiate JSON obj
        $json = new $this->services_json;

        $eEmail = "";
        //$user_id = 0;

        //data is sent using json array hence input is read using post and not using headers
    if (!isset($_POST['email']) || ((isset($_POST['email']) && $_POST['email'] == '')) || filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == FALSE) {
            echo $json->encode(array("response" => array("errorCode" => "1", "message" => 'Please enter valid email id')));
            exit;
        } else {
            $eEmail = trim($_POST['email']);
        }

        $this->load->model('user_model');
        $user_id = $this->user_model->getIdFromEmail($eEmail);

        if ($user_id > 0) {
            // User found
            //Create user obj and set email and password parameters
            $recordObj = new $this->user_obj;
            $recordObj->setEmail($eEmail);
            $recordObj->setId($user_id);

            $randomPassword = random_string('alnum', 6);

            $recordObj->setPassword($randomPassword);

            //update password to database
            $status = $this->user_model->updatePassword($recordObj);


            if ($status == TRUE) {

                //calling send mail method from common_method
                // $sentStatus =  $this->common_method->sendEmail($recordObj);
                // Sandeep - for some reasons, mail code in common-methods is not working, hence brought back here.
                $config['protocol'] = 'mail';
                $config['charset'] = 'iso-8859-1';
                $config['mailtype'] = 'html';
                $config['wordwrap'] = FALSE;
                $config['newline'] = "\r\n";
                $config['fromName'] = "Thaipoll";
                $config['fromEmail'] = "mayoori.dessai@quagnitia.com";

                $this->email->initialize($config);

                $this->email->clear(TRUE);

                $this->email->from($this->config->item('fromEmail'), $this->config->item('fromName'));
                $this->email->to($recordObj->getEmail());

                $this->email->subject('New Password On User Request');

                $templateName = "forgotpassword";
                $templateData = array("email" => $recordObj->getEmail(), "password" => $recordObj->getPassword(), "user_id" => $recordObj->getId());
                $email_message = $this->load->view('emailtemplates/' . $templateName, $templateData, TRUE);

                $this->email->message($email_message);

                //$status = $this->email->send(); // there is some error with sendng email, if mail is failed, response is nul
                // echo json_encode(array("response" =>array("errorCode"=>'0','message'=>" About to send email...")));
                //  exit; 


                /* if($this->email->send())
                  {
                  echo json_encode(array("response" =>array("errorCode"=>'0','message'=>" New password is sent to your email.")));
                  exit;
                  }
                  else
                  {

                  echo json_encode(array("response" =>array("errorCode"=>'8','message'=>"Sending Mail Failed")));
                  exit;
                  } */

                // if the email send function return NULL
                echo json_encode(array("response" => array("errorCode" => '0', 'message' => " New password is sent to your email.", "code" => $this->email->send())));
                exit;
            } else {
                echo json_encode(array("response" => array("errorCode" => '1', 'message' => " Password update failed.")));
                exit;
            }
        } else { // user not found
            echo json_encode(array("response" => array("errorCode" => '1', 'message' => " Email-Id does not exist ")));
            exit;
        }
    }

    function getProvinceListByRegionId() {
        //instantiate JSON obj
        $json = new $this->services_json;

        if (!isset($_POST['region_id'])) {
            echo $json->encode(array("response" => array("errorCode" => "1", "message" => 'Please provide region_id')));
            exit;
        }

        // Go ahead and get list of province based on region_id
        $this->load->model('province_model');
        $dataObjArr = $this->province_model->getProvinceListByRegionId($_POST['region_id']);

        $dataJSONArr = $json->encode($dataObjArr);

        echo(json_encode(array("response" => array("errorCode" => '0', 'provinceList' => $dataObjArr, 'message' => ""))));
        exit;
    }

   function createRegistrationQuestionList() {
        $this->load->model('region_model');
        $regionDataArr = $this->region_model->getRegionList();

        $this->load->model('province_model');
        $provinceDataArr = $this->province_model->getProvinceList();

        $this->load->model('user_model');
        $educationDataArr = $this->user_model->getEducationList();

        $jobFunctionDataArr = $this->user_model->getJobFunctionList();

        $jobStatusDataArr = $this->user_model->getJobStatusList();

        $relationshipStatusDataArr = $this->user_model->getRelationshipStatusList();

        $familyStatusDataArr = $this->user_model->getFamilyStatusList();

        $incomeDataArr = $this->user_model->getIncomeList();

        $this->load->model('interest_model');
        $interestDataArr = $this->interest_model->getInterestList();

        $questions_list = $this->config->item('questions');


        $output_question_set_array = array();

        foreach ($questions_list as $question_id => $question_set) {
            $output_question_array = array();

            if ($question_id != 'a') {
                $output_question_array['q_id'] = $question_id;
                $output_question_array['text'] = $question_set[0];
                $output_question_array['type'] = $question_set[1];
            }
            $answer_array = array();
            $subquestions_array = array();

            if ($question_id == "1") {
                foreach ($regionDataArr as $regionData) {
                    $option_array['ans_id'] = $regionData->id;
                    $option_array['ans_text'] = $regionData->region;
                    array_push($answer_array, $option_array);
                }
                $output_question_array['answer'] = $answer_array;
                $output_question_array['subQuestions'] = $subquestions_array;
            }

            if ($question_id == "2") {
                foreach ($provinceDataArr as $provinceData) {
                    $option_array['ans_id'] = $provinceData->id;
                    $option_array['ans_text'] = $provinceData->province;
                    array_push($answer_array, $option_array);
                }
                $output_question_array['answer'] = $answer_array;
                $output_question_array['subQuestions'] = $subquestions_array;
            }

            if ($question_id == "3") {
                $option_array['ans_id'] = "1";
                $option_array['ans_text'] = FEMALE;
                array_push($answer_array, $option_array);

                $option_array['ans_id'] = "2";
                $option_array['ans_text'] = MALE;
                array_push($answer_array, $option_array);
                $output_question_array['answer'] = $answer_array;
                $output_question_array['subQuestions'] = $subquestions_array;
            }

            //For this, the expected response from mobile team is:
            /*
              {"q_id":"q4","text":"Your date of birth","type":"single","answer":[]},
             */

            if ($question_id == "4") {
                $answer_array = array();
                $output_question_array['answer'] = $answer_array;
                $output_question_array['subQuestions'] = $subquestions_array;
            }

            if ($question_id == "5") {
                foreach ($educationDataArr as $educationData) {
                    $option_array['ans_id'] = $educationData->id;
                    $option_array['ans_text'] = $educationData->edu_level;
                    array_push($answer_array, $option_array);
                }
                $output_question_array['answer'] = $answer_array;
                $output_question_array['subQuestions'] = $subquestions_array;
            }

            if ($question_id == "6") {
               
                foreach ($incomeDataArr as $incomeData) {
                    $option_array['ans_id'] = $incomeData->id;
                    $option_array['ans_text'] = $incomeData->label;
                    
                    array_push($answer_array, $option_array);
                }
                $output_question_array['answer'] = $answer_array;
                $output_question_array['subQuestions'] = $subquestions_array;
            }

            if ($question_id == "7") {
                foreach ($jobFunctionDataArr as $jobfunctionData) {
                    $option_array['ans_id'] = $jobfunctionData->id;
                    $option_array['ans_text'] = $jobfunctionData->job_function;

                    array_push($answer_array, $option_array);
                }

                $output_question_array['answer'] = $answer_array;

                $subquestions_array['subQ_id'] = 'a';
                $subquestions_array['text'] = $questions_list['a'][0];
                $subquestions_array['type'] = $questions_list['a'][1];

                $sub_answer_array = array();

                foreach ($jobStatusDataArr as $jobStatusData) {
                    $option_array['ans_id'] = $jobStatusData->id;
                    $option_array['ans_text'] = $jobStatusData->job_status_label;
                    array_push($sub_answer_array, $option_array);
                }

                $subquestions_array['answer'] = $sub_answer_array;

                //this is done to convert $subquestions_array to array rather then json object
                $sub_answer_array_final = array();
                array_push($sub_answer_array_final, $subquestions_array);

                $output_question_array['subQuestions'] = $sub_answer_array_final;
            }

            if ($question_id == "8") {
                $answer_array = array();
                foreach ($relationshipStatusDataArr as $relationshipData) {
                    $option_array['ans_id'] = $relationshipData->id;
                    $option_array['ans_text'] = $relationshipData->relationship_label;
                    array_push($answer_array, $option_array);
                }

                $output_question_array['answer'] = $answer_array;
                $output_question_array['subQuestions'] = $subquestions_array;
            }

            if ($question_id == "9") {
                $answer_array = array();
                foreach ($familyStatusDataArr as $familyStatusData) {
                    $option_array['ans_id'] = $familyStatusData->id;
                    $option_array['ans_text'] = $familyStatusData->family_status_label;
                    array_push($answer_array, $option_array);
                }
                $output_question_array['answer'] = $answer_array;
                $output_question_array['subQuestions'] = $subquestions_array;
            }

            if ($question_id == "10") {
                $answer_array = array();
                
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
                
                $output_question_array['answer'] = $main_array;
                $output_question_array['subQuestions'] = $subquestions_array;
            }

            if ($question_id != 'a') {
                array_push($output_question_set_array, $output_question_array);
            }
        }
        echo json_encode(array("response" => array("errorCode" => '0', 'firstPollArray' => $output_question_set_array, 'message' => "")));
        exit;
    }

    //for testing new interest functionality
    function createRegistrationQuestionList_test() {
        $this->load->model('region_model');
        $regionDataArr = $this->region_model->getRegionList();

        $this->load->model('province_model');
        $provinceDataArr = $this->province_model->getProvinceList();

        $this->load->model('user_model');
        $educationDataArr = $this->user_model->getEducationList();

        $jobFunctionDataArr = $this->user_model->getJobFunctionList();

        $jobStatusDataArr = $this->user_model->getJobStatusList();

        $relationshipStatusDataArr = $this->user_model->getRelationshipStatusList();

        $familyStatusDataArr = $this->user_model->getFamilyStatusList();

        $incomeDataArr = $this->user_model->getIncomeList();

        $this->load->model('interest_model');
        $interestDataArr = $this->interest_model->getInterestList();

        $questions_list = $this->config->item('questions');


        $output_question_set_array = array();

        foreach ($questions_list as $question_id => $question_set) {
            $output_question_array = array();

            if ($question_id != 'a') {
                $output_question_array['q_id'] = $question_id;
                $output_question_array['text'] = $question_set[0];
                $output_question_array['type'] = $question_set[1];
            }
            $answer_array = array();
            $subquestions_array = array();

            if ($question_id == "1") {
                foreach ($regionDataArr as $regionData) {
                    $option_array['ans_id'] = $regionData->id;
                    $option_array['ans_text'] = $regionData->region;
                    array_push($answer_array, $option_array);
                }
                $output_question_array['answer'] = $answer_array;
                $output_question_array['subQuestions'] = $subquestions_array;
            }

            if ($question_id == "2") {
                foreach ($provinceDataArr as $provinceData) {
                    $option_array['ans_id'] = $provinceData->id;
                    $option_array['ans_text'] = $provinceData->province;
                    array_push($answer_array, $option_array);
                }
                $output_question_array['answer'] = $answer_array;
                $output_question_array['subQuestions'] = $subquestions_array;
            }

            if ($question_id == "3") {
                $option_array['ans_id'] = "1";
                $option_array['ans_text'] = MALE;
                array_push($answer_array, $option_array);

                $option_array['ans_id'] = "2";
                $option_array['ans_text'] = FEMALE;
                array_push($answer_array, $option_array);
                $output_question_array['answer'] = $answer_array;
                $output_question_array['subQuestions'] = $subquestions_array;
            }

            //For this, the expected response from mobile team is:
            /*
              {"q_id":"q4","text":"Your date of birth","type":"single","answer":[]},
             */

            if ($question_id == "4") {
                $answer_array = array();
                $output_question_array['answer'] = $answer_array;
                $output_question_array['subQuestions'] = $subquestions_array;
            }

            if ($question_id == "5") {
                foreach ($educationDataArr as $educationData) {
                    $option_array['ans_id'] = $educationData->id;
                    $option_array['ans_text'] = $educationData->edu_level;
                    array_push($answer_array, $option_array);
                }
                $output_question_array['answer'] = $answer_array;
                $output_question_array['subQuestions'] = $subquestions_array;
            }

            if ($question_id == "6") {
                 
                foreach ($incomeDataArr as $incomeData) {
                    $option_array['ans_id'] = $incomeData->id;
                    $option_array['ans_text'] = $incomeData->label;
                    array_push($answer_array, $option_array);
                }
                $output_question_array['answer'] = $answer_array;
                $output_question_array['subQuestions'] = $subquestions_array;
            }

            if ($question_id == "7") {
                foreach ($jobFunctionDataArr as $jobfunctionData) {
                    $option_array['ans_id'] = $jobfunctionData->id;
                    $option_array['ans_text'] = $jobfunctionData->job_function;

                    array_push($answer_array, $option_array);
                }

                $output_question_array['answer'] = $answer_array;

                $subquestions_array['subQ_id'] = 'a';
                $subquestions_array['text'] = $questions_list['a'][0];
                $subquestions_array['type'] = $questions_list['a'][1];

                $sub_answer_array = array();

                foreach ($jobStatusDataArr as $jobStatusData) {
                    $option_array['ans_id'] = $jobStatusData->id;
                    $option_array['ans_text'] = $jobStatusData->job_status_label;
                    array_push($sub_answer_array, $option_array);
                }

                $subquestions_array['answer'] = $sub_answer_array;

                //this is done to convert $subquestions_array to array rather then json object
                $sub_answer_array_final = array();
                array_push($sub_answer_array_final, $subquestions_array);

                $output_question_array['subQuestions'] = $sub_answer_array_final;
            }

            if ($question_id == "8") {
                $answer_array = array();
                foreach ($relationshipStatusDataArr as $relationshipData) {
                    $option_array['ans_id'] = $relationshipData->id;
                    $option_array['ans_text'] = $relationshipData->relationship_label;
                    array_push($answer_array, $option_array);
                }

                $output_question_array['answer'] = $answer_array;
                $output_question_array['subQuestions'] = $subquestions_array;
            }

            if ($question_id == "9") {
                $answer_array = array();
                foreach ($familyStatusDataArr as $familyStatusData) {
                    $option_array['ans_id'] = $familyStatusData->id;
                    $option_array['ans_text'] = $familyStatusData->family_status_label;
                    array_push($answer_array, $option_array);
                }
                $output_question_array['answer'] = $answer_array;
                $output_question_array['subQuestions'] = $subquestions_array;
            }

            if ($question_id == "10") {
                $main_category = array();
                
                foreach($interestDataArr as $key => $interestData)
                {                          
                    foreach($interestData as $interestObj)
                    {
                  
                    $option_array['ans_id'] = $interestObj->id;
                    $option_array['ans_text'] = $interestObj->interest;
                    array_push($answer_array, $option_array);
                    
                    }
                    $main_array[$key] = $answer_array;
                    $answer_array =  array();
                }
//                echo "<pre>";
//                    print_r($main_array); echo "</pre>"; exit;
//                $answer_array = array();
//                foreach ($interestDataArr as $interestData) {
//                    $option_array['ans_id'] = $interestData->id;
//                    $option_array['ans_text'] = $interestData->interest;
//                    array_push($answer_array, $option_array);
//                }
                $output_question_array['answer'] = $main_array;
                $output_question_array['subQuestions'] = $subquestions_array;
            }
            if ($question_id != 'a') {
                array_push($output_question_set_array, $output_question_array);
            }
        }
            
        echo json_encode(array("response" => array("errorCode" => '0', 'firstPollArray' => $output_question_set_array, 'message' => "")));
        exit;
    }
    
    
    function saveFirstPollDetails() {
        //instantiate JSON obj
        $json = new $this->services_json;

        $param = json_decode(file_get_contents('php://input'), true);

        $userId = $param['userId'];
        $firstPollResult = $param["firstPollResult"];


        if (!isset($userId) || (isset($userId) && $userId == '')) {
            echo $json->encode(array("response" => array("errorCode" => "1", 'q_id'=> "", "message" => 'Please enter user id.')));
            exit;
        }

        if (!isset($firstPollResult) || (isset($firstPollResult) && count($firstPollResult) == 0 )) {
            echo $json->encode(array("response" => array("errorCode" => "1",  'q_id'=> "", "message" => 'Please enter firstPollResult.')));
            exit;
        }

        $questions_field_mapping = $this->config->item('questions_field_mapping');

        // Prepare Query - using Query Binding concept from CodeIgnitor
        $queryDataArr = array(); //used for data binding

        $update_statement = "UPDATE " . $this->config->item('tbl_n_user', 'dbtables') . " SET last_updated = ?  ";

        $queryDataArr[] = date('Y-m-d H:m:s');

        $recordObj = new $this->user_obj;
        $recordObj->setId($userId);

        $question_id = 1; // Set $question_id as 1 by default

        $question_anwered_cnt = 0;
        
        foreach ($firstPollResult as $key => $value) {
            $question_id = $value['q_id'];

            $fieldname = $questions_field_mapping[$question_id];

            if (count($value['selectedAnsId']) > 0) {
                $question_anwered_cnt++;
                
                switch ($fieldname) {
                    case REGION:
                        $recordObj->setRegion_id($value['selectedAnsId'][0]);
                        $update_statement .= " , " . REGION . " =  ? ";
                        $queryDataArr[] = $value['selectedAnsId'][0];
                        break;

                    case PROVINCE:
                        $recordObj->setProvince_id($value['selectedAnsId'][0]);
                        $update_statement .= " , " . PROVINCE . " = ? ";
                        $queryDataArr[] = $value['selectedAnsId'][0];
                        break;

                    case GENDER:
                        $recordObj->setGender($value['selectedAnsId'][0]);
                        $update_statement .= " , " . GENDER . " =  ? ";
                        $queryDataArr[] = $value['selectedAnsId'][0];
                        break;

                    case DOB:
                        $recordObj->setDob($value['selectedAnsId'][0]);
                        $update_statement .= " , " . DOB . " =  ? ";
                        $queryDataArr[] = $value['selectedAnsId'][0];
                        break;

                    case EDUCATION:
                        $recordObj->setEducation_id($value['selectedAnsId'][0]);
                        $update_statement .= " , " . EDUCATION . " =  ? ";
                        $queryDataArr[] = $value['selectedAnsId'][0];
                        break;

                    case INCOME:
                        $recordObj->setIncome_group_id($value['selectedAnsId'][0]);
                        $update_statement .= " , " . INCOME . " =  ? ";
                        $queryDataArr[] = $value['selectedAnsId'][0];
                        break;

                    case INTEREST:
                        //selectedSubQuestionAnsId will contain list of user selected sub interest category.
                        //selectedAnsId will contain list of user selected main interest category which is not saved in db.
                        if (count($value['selectedSubQuestionAnsId']) > 0) 
                        {
                            $record_interest_Obj = new $this->user_interest_obj;
                            $user_interest_arr = array();
                            
                            foreach($value['selectedSubQuestionAnsId'] as $answer){
                                $record_interest_Obj->setUser_id($userId);
                                $record_interest_Obj->setInterest_id($answer);
                                array_push($user_interest_arr, $record_interest_Obj);
                            }
                            
                            //insert_batch helps to insert all the rows at once, either array or object array should be passed.
                            $interest_status = $this->db->insert_batch($this->config->item('tbl_user_interest','dbtables'),$user_interest_arr);
                            
                            if(!$interest_status)
                            {
                                echo $json->encode(array("response" => array("errorCode" => "1", 'q_id'=> $question_id, "message" => "Saving user interest failed.")));
                                exit;
                            }
                        }
                        else
                        {
                            echo $json->encode(array("response" => array("errorCode" => "1", "q_id" => "", "message" => "Please answer question no: ". $question_id . " on field ". INTEREST)));
                            exit;
                        }
                        
                        break;
                    
                        /* old functionality
                        $recordObj->setInterest_id($value['selectedAnsId'][0]);
                        $update_statement .= " , " . INTEREST . " =  ? ";
                        $queryDataArr[] = $value['selectedAnsId'][0];
                        break;*/

                    case JOBFUNCTION:
                        $recordObj->setJob_funtion_id($value['selectedAnsId'][0]);
                        $update_statement .= " , " . JOBFUNCTION . " =  ? ";
                        $queryDataArr[] = $value['selectedAnsId'][0];
                        
                        if (count($value['selectedSubQuestionAnsId']) > 0) {
                            $recordObj->setJob_status($value['selectedSubQuestionAnsId'][0]);
                            $update_statement .= " , " . JOBSTATUS . " =  ? ";
                            $queryDataArr[] = $value['selectedAnsId'][0];
                        }
                        else
                        {
                            echo $json->encode(array("response" => array("errorCode" => "1", 'q_id'=> $question_id, "message" => 'Please answer sub question for question no: '. $question_id . " on field ". JOBSTATUS)));
                            exit;
                        }
                        
                        break;
                        
                    case RELATIONSHIPSTATUS:
                        $recordObj->setRelationship($value['selectedAnsId'][0]);
                        $update_statement .= " , " . RELATIONSHIPSTATUS . " =  ? ";
                        $queryDataArr[] = $value['selectedAnsId'][0];
                        break;

                    case FAMILYSTATUS:
                        $recordObj->setFamily_status($value['selectedAnsId'][0]);
                        $update_statement .= " , " . FAMILYSTATUS . " =  ? ";
                        $queryDataArr[] = $value['selectedAnsId'][0];
                        break;
                }                
            }
            else
            {
                echo $json->encode(array("response" => array("errorCode" => "1" , 'q_id'=> $question_id, "message" => 'Please answer question no: '. $question_id . " on field ". $fieldname)));
                exit;
            }
        }
                
        $recordObj->setLast_answered_question($question_id);

        $update_statement = $update_statement . " WHERE id =  ? ";
        $queryDataArr[] = $userId;

        // this query is to update the user records and returns true or false
        $update_status = $this->db->query($update_statement, $queryDataArr);

        if ($update_status) {
            
            $this->load->model('poll_settings_model');
            $firstPollRewardPoints = $this->poll_settings_model->getFirstPollPoints();
            
            $this->load->library('settings_obj');
            $settings_recordObj = new $this->settings_obj;
            $settings_recordObj->setFirst_poll($firstPollRewardPoints);
            
            $recordObj = new $this->user_obj;
            
            $recordObj->setId($userId);
            $this->session->set_userdata('user_id',$userId);
                    
            if($question_anwered_cnt != LASTQUESTION)
            {
                $this->session->set_userdata('first_poll', INCOMPLETE);
                $recordObj->setFirst_poll(INCOMPLETE);
            }
            else
            {
                $this->session->set_userdata('first_poll', YES);
                $recordObj->setFirst_poll(YES);
            }
                        
            $this->load->model('user_model');
            $query_result = $this->user_model->changeFirstPoll($recordObj);
            
            if($query_result)
            {
                echo $json->encode(array("response" => array("errorCode" => "0" , 'q_id'=> "","message" => 'Registration Successfull.' , "resData" => $firstPollRewardPoints)));
                exit; 
            }
            else
            {
                echo $json->encode(array("response" => array("errorCode" => "1", 'q_id'=> "", "message" => 'Change first poll status failed.')));
                exit;
            }
            
        } else {
            echo $json->encode(array("response" => array("errorCode" => "1", 'q_id'=> "" ,"message" => 'Profile update failed.')));
            exit;
        }
    }
    
  // Send the Poll Category List to the User on the App 	
  function getpollCategoryList() {
        //instantiate JSON obj
        $json = new $this->services_json;
		
		$message = '';
		
        $this->load->model('poll_model');
        $dataObjArr = $this->poll_model->getPollCategories();
		
		if(count($dataObjArr) == 0){
			$message = 'Poll Category List is empty';
			$errorCode = 1;
		}	
		else{
			$errorCode = 0;
		}
		
		$pollCategory = array();
		
		foreach($dataObjArr as $key=>$value){
			$pollCategory[$key]['catid'] = $value->id;
			$pollCategory[$key]['catname'] = $value->category_name;
		
			
			
		}

        $dataJSONArr = $json->encode($pollCategory);

        echo(json_encode(array("response" => array("errorCode" => $errorCode, 'pollCategoryArray' => $pollCategory, 'message' => $message))));
        exit;
    }
	
	// Send the Poll Package List to the User on the App
	  function getpollPackageList() {
        //instantiate JSON obj
        $json = new $this->services_json;
		
		$message = '';
		
        $this->load->model('poll_model');
        $dataObjArr = $this->poll_model->getPollPackage();
		
		if(count($dataObjArr) == 0){
			$message = 'Poll Package List is empty';
			$errorCode = 1;
		}	
		else{
			$errorCode = 0;
		}
		
		$pollPackageList = array();
		
		foreach($dataObjArr as $key=>$value){
			$pollPackage[$key]['id'] = $value->id;
			$pollPackage[$key]['packageName'] = $value->name;
			$pollPackage[$key]['value'] = $value->amount;		
			$pollPackage[$key]['num_polls'] = $value->num_polls;
			$pollPackage[$key]['discount'] = $value->discount;
			$pollPackage[$key]['final_amount'] = trim(" ".$value->amount - ($value->amount * $value->discount/100)." ");
			
		}

        $dataJSONArr = $json->encode($pollPackage);

        echo(json_encode(array("response" => array("errorCode" => $errorCode, 'pollPackageArray' => $pollPackage, 'message' => $message))));
        exit;
    }	
	
   // Send all teh visibilty params (age, gender, location, etc ) to the user on the app to set the visibility while creating a poll.	
	function getVisibilityList() {
	
		//instantiate JSON obj
        $json = new $this->services_json;
		
		$message = '';
		
        $this->load->model('filter_model');
        $dataObjArr = $this->filter_model->getAllFilters();
		
		extract($dataObjArr);
		
		$pollVisibilityArray = array();
		
		
		/** SET AGE GROUP **/
		
		
		$pollVisibilityArray[1] = array();
		$pollVisibilityArray[1]["id"] = "1";
		$pollVisibilityArray[1]["title"] = "By Age";
		$pollVisibilityArray[1]["type"] = "multiple-selection";
		$pollVisibilityArray[1]["ans"] = array();
		
		foreach($ageGroup as $key=>$value){
		$pollVisibilityArray[1]["ans"][$key]["ansid"] = trim($value->id);	
		$pollVisibilityArray[1]["ans"][$key]["text"] = $value->title;
		}
		
		/** SET GENDER **/
		$pollVisibilityArray[2] = array();	
		$pollVisibilityArray[2]["id"] = "2";
		$pollVisibilityArray[2]["title"] = "By Gender";
		$pollVisibilityArray[2]["type"] = "single-selection";
		$pollVisibilityArray[2]["ans"] = array();
		
		$z=0;
		foreach($gender as $key=>$value){
			$pollVisibilityArray[2]["ans"][$z]["ansid"] = trim(($z+1));	
			$pollVisibilityArray[2]["ans"][$z]["text"] = $value;	
			$z++;
		}
		
		
		
		/** SET COUNTRY AND PROVINCE **/
		$pollVisibilityArray[3] = array();	
		$pollVisibilityArray[3]["id"] = "3";
		$pollVisibilityArray[3]["title"] = "By Location";
		$pollVisibilityArray[3]["type"] = "multiple-check";
		$pollVisibilityArray[3]["ans"] = array();
		
		foreach($country as $key=>$value){
			$pollVisibilityArray[3]["ans"][$key]["ansid"] = trim($value->id);
			$pollVisibilityArray[3]["ans"][$key]["text"] = trim($value->country);
			$pollVisibilityArray[3]["ans"][$key]["province"] = array();
			
			foreach($value->province as $k=>$v){
				$pollVisibilityArray[3]["ans"][$key]["province"][$k]["ansid"] = trim($v->id);
				$pollVisibilityArray[3]["ans"][$key]["province"][$k]["text"] = trim($v->province);
			}
		
		}
		
		/** SET RELATIONSHIP **/
		$pollVisibilityArray[4] = array();	
		$pollVisibilityArray[4]["id"] = "4";
		$pollVisibilityArray[4]["title"] = "By RelationShip Status";
		$pollVisibilityArray[4]["type"] = "multiple-selection";
		$pollVisibilityArray[4]["ans"] = array();
		
		foreach($relationship as $key=>$value){
			$pollVisibilityArray[4]["ans"][$key]["ansid"] = trim($value->id);
			$pollVisibilityArray[4]["ans"][$key]["text"] = trim($value->relationship_label);			
		}
			

		/** SET EDUCATION LEVEL **/
		$pollVisibilityArray[5] = array();	
		$pollVisibilityArray[5]["id"] = "5";
		$pollVisibilityArray[5]["title"] = "By Education Level";
		$pollVisibilityArray[5]["type"] = "multiple-selection";
		$pollVisibilityArray[5]["ans"] = array();
		
		foreach($education as $key=>$value){
			$pollVisibilityArray[5]["ans"][$key]["ansid"] = trim($value->id);
			$pollVisibilityArray[5]["ans"][$key]["text"] = trim($value->edu_level);			
		}
		
		/** SET INCOME GROUP **/
		$pollVisibilityArray[6] = array();			
		$pollVisibilityArray[6]["id"] = "6";
		$pollVisibilityArray[6]["title"] = "By Income Group";
		$pollVisibilityArray[6]["type"] = "multiple-selection";
		$pollVisibilityArray[6]["ans"] = array();
		
		foreach($income as $key=>$value){
			$pollVisibilityArray[6]["ans"][$key]["ansid"] = trim($value->id);
			$pollVisibilityArray[6]["ans"][$key]["text"] = trim($value->label);			
		}		

		/** SET JOB FUNCTION **/
		$pollVisibilityArray[7] = array();			
		$pollVisibilityArray[7]["id"] = "7";
		$pollVisibilityArray[7]["title"] = "By Job Function";
		$pollVisibilityArray[7]["type"] = "multiple-selection";
		$pollVisibilityArray[7]["ans"] = array();
		
		foreach($jobFunction as $key=>$value){
			$pollVisibilityArray[7]["ans"][$key]["ansid"] = trim($value->id);
			$pollVisibilityArray[7]["ans"][$key]["text"] = trim($value->job_function);			
		}			
		
		/** SET JOB STATUS **/	
		$pollVisibilityArray[8] = array();			
		$pollVisibilityArray[8]["id"] = "8";
		$pollVisibilityArray[8]["title"] = "By Job Status";
		$pollVisibilityArray[8]["type"] = "multiple-selection";
		$pollVisibilityArray[8]["ans"] = array();
		
		foreach($jobStatus as $key=>$value){
			$pollVisibilityArray[8]["ans"][$key]["ansid"] = trim($value->id);
			$pollVisibilityArray[8]["ans"][$key]["text"] = trim($value->job_status_label);			
		}
		
		/** SET FAMILY STATUS **/
		$pollVisibilityArray[9] = array();			
		$pollVisibilityArray[9]["id"] = "9";
		$pollVisibilityArray[9]["title"] = "By Family Status";
		$pollVisibilityArray[9]["type"] = "multiple-selection";
		$pollVisibilityArray[9]["ans"] = array();
		
		foreach($familyStatus as $key=>$value){
			$pollVisibilityArray[9]["ans"][$key]["ansid"] = trim($value->id);
			$pollVisibilityArray[9]["ans"][$key]["text"] = trim($value->family_status_label);			
		}	


		/** SET INTEREST CATEGORY & INTEREST **/
		$pollVisibilityArray[10] = array();		
		$pollVisibilityArray[10]["id"] = "10";
		$pollVisibilityArray[10]["title"] = "By Interest";
		$pollVisibilityArray[10]["type"] = "multiple-check";
		$pollVisibilityArray[10]["ans"] = array();
		
		foreach($interestCategory as $key=>$value){
			$pollVisibilityArray[10]["ans"][$key]["ansid"] = trim($value->id);
			$pollVisibilityArray[10]["ans"][$key]["text"] = trim($value->name);
			$pollVisibilityArray[10]["ans"][$key]["interest"] = array();
			
			foreach($value->interest as $k=>$v){
				$pollVisibilityArray[10]["ans"][$key]["interest"][$k]["ansid"] = trim($v->id);
				$pollVisibilityArray[10]["ans"][$key]["interest"][$k]["text"] = trim($v->interest);
			}
		
		}
		
		$pollVisibilityArray2 = array();
		
		foreach($pollVisibilityArray as $key=>$value){
			array_push($pollVisibilityArray2,$value);		
		}
		
		$pollVisibilityArray = $pollVisibilityArray2;
		
		if(count($dataObjArr) == 0){
			$message = 'Visibility List is empty';
			$errorCode = 1;
		}	
		else{
			$errorCode = 0;
		}
		

       $dataJSONArr = $json->encode($pollVisibilityArray);
	 
        echo($json->encode(array("response" => array("errorCode" => $errorCode, 'pollVisibilityArray' => $pollVisibilityArray, 'message' => $message)),JSON_FORCE_OBJECT));
        exit;
	
	}
	
	
	
	// Save the first poll Details
	
	   function savePollDetails() {
        //instantiate JSON obj
        $json = new $this->services_json;
		$this->load->model('poll_model');
		
		
		$message = '';

        $userId = "";
		$pollTitle = "";
		$pollCategoryId = "";
		$pollDescription = "";
		
		

        //data is sent using json array hence input is read using post and not using headers
        if (!isset($_POST['userId']) || (isset($_POST['userId']) && $_POST['userId'] == '') ) {
            echo $json->encode(array("response" => array("errorCode" => "1", "message" => 'UserId absent')));
            exit;
        } else {
            $userId = trim($_POST['userId']);
        }
		
        if (!isset($_POST['pollTitle']) || (isset($_POST['pollTitle']) && $_POST['pollTitle'] == '') ) {
            echo $json->encode(array("response" => array("errorCode" => "1", "message" => 'Please enter the Poll Title')));
            exit;
        } else {
            $pollTitle = trim($_POST['pollTitle']);
        }		
		
        if (!isset($_POST['pollDescription']) || (isset($_POST['pollDescription']) && $_POST['pollDescription'] == '') ) {
            echo $json->encode(array("response" => array("errorCode" => "1", "message" => 'Please enter the Poll Description')));
            exit;
        } else {
            $pollDescription = trim($_POST['pollDescription']);
        }	
		
		
        if (!isset($_POST['pollCategoryId']) || (isset($_POST['pollCategoryId']) && $_POST['pollCategoryId'] == '') ) {
            echo $json->encode(array("response" => array("errorCode" => "1", "message" => 'Please enter the Poll Title')));
            exit;
        } else {
            $pollCategoryId = trim($_POST['pollCategoryId']);
        }		
		
		
		$id = $this->poll_model->wbSavePollDetails($userId,$pollTitle,$pollCategoryId,$pollDescription);
		
		if($id)
			echo $json->encode(array("response" => array("errorCode" => "0", "message" => 'Poll Successfully Inserted','pollId'=>$id)));
		else
			echo $json->encode(array("response" => array("errorCode" => "1", "message" => 'There was an error saving the Poll')));
    }
	
	
	
	
	// Save the first poll Image
	
	   function savePollImage() {
        //instantiate JSON obj
        $json = new $this->services_json;
		$this->load->model('poll_model');
		

		$message = "";
		$pollId = "";
		$pollImageName = "";
		$pollImageBinaryData = "";
		


		
		

        //data is sent using json array hence input is read using post and not using headers
        if (!isset($_POST['pollId']) || (isset($_POST['pollId']) && $_POST['pollId'] == '') ) {
            echo $json->encode(array("response" => array("errorCode" => "1", "message" => 'PollId absent')));
            exit;
        } else {
            $pollId = trim($_POST['pollId']);
        }
		
        if (!isset($_POST['pollImageName']) || (isset($_POST['pollImageName']) && $_POST['pollImageName'] == '') ) {
            echo $json->encode(array("response" => array("errorCode" => "1", "message" => 'Poll Image name is absent')));
            exit;
        } else {
            $pollImageName = trim($_POST['pollImageName']);
        }		
		
         if (!isset($_POST['pollImageBinaryData']) || (isset($_POST['pollImageBinaryData']) && $_POST['pollImageBinaryData'] == '') ) {
            echo $json->encode(array("response" => array("errorCode" => "1", "message" => 'Poll Image Binary Data is not present ')));
            exit;
        } else {
            $pollImageBinaryData = base64_decode(trim($_POST['pollImageBinaryData']));
        }	

		$fileopen = fopen($this->config->item('base_path').'/uploads/'.$pollImageName,"w+");
		fwrite($fileopen,$pollImageBinaryData);
		fclose($fileopen);

		$flag = $this->poll_model->wbSavePollImage($pollId,$pollImageName);
		
		if($flag)
			echo $json->encode(array("response" => array("errorCode" => "0", "message" => 'Poll Image Successfully Saved')));
		else
			echo $json->encode(array("response" => array("errorCode" => "1", "message" => 'There was an error saving the Poll Image')));
			
    }	
	
	function savePollQuestions(){
        //instantiate JSON obj
        $json = new $this->services_json;
		$this->load->model('poll_model');	
	
	
	
	
	}
	
	
	
	
	
	
	
}
