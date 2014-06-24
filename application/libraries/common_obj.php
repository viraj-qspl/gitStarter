
<?php
// This class will hold all commonly used functions across the application
class Common_obj {
	
	function __construct(){	}
	
	function isAdminLogged(){
            $CI =& get_instance(); //This is required as common is a custom class and not codeIgnitors controller or model		
            $CI->load->library('session');			
		
            //Get data from session
            if ($CI->session->userdata("session_id") != "") {
                if ($CI->session->userdata("userId") != "" && $CI->session->userdata("userType") == "2") {
                    return true;
                }
            }
            return false;
        }
	
	function validateAdminAccess(){
		$CI =& get_instance(); //This is required as common is a custom class		
		$CI->load->helper('url');	
						
		//check if admin has logged in or not
		if( $this->isAdminLogged() == true ){
			;//ok
		}else{
			//take user to login page
			redirect($CI->config->item('loginBeAction'), 'refresh');		
		}	
	}

	function getMessageFormatted($argData){
		$msg = "";
		if (is_array($argData) && count($argData)>0 ){
			// Check for any message
			if(!empty($argData['message']) && !empty($argData['oprStatus'])) {				
				// format message with success div
				if ($argData['oprStatus'] == OPR_SUCCESS){
					$msg = "<div id='successMsg' >" . $argData['message'] . "</div>";		
				}							
				// format message with error div			
				if ($argData['oprStatus'] == OPR_FAILED){
					$msg = "<div id='errorMsg' >" . $argData['message'] . "</div>";		
				}				
			}			
		}
		return $msg;
	}
	
	
	function test(){
		return "test";
	}
	
	/**
	 * function generateEmailMatter for Home controller to check unique email id 
	 * 
	 * @param String argArray array of arguements passed to teh function
	 * @return Array emailArgs with list of emial paramters emailid, messagebody,subject 
	 * */
	function generateEmailMatter($argArray)
	{
		$CI =& get_instance();
		
		$passEmailArgs=array();		
			
		$fromName=$CI->config->item('fromName');
		$fromEmail=$CI->config->item('fromEmail');
		//echo $argArray['emailType'];
		switch($argArray['emailType']){
		
			case 'SEND_MESSAGE_TO_USER':
				$viewArr['to'] 	= $fromName;
				$viewArr['toName']= $argArray['toName'];
				$viewArr['message'] 	= $argArray['message'];
				$message=$CI->load->view('emails/emailTemplate',$viewArr,true);
				$CI->load->library('email');
				$config['charset'] = 'utf-8';
				$config['wordwrap'] = TRUE;
				$config['mailtype'] = 'html';
				$CI->email->initialize($config);
				$CI->email->from($fromName);
				$CI->email->to($fromEmail);
				//$CI->email->cc('another@another-example.com');
				//$CI->email->bcc('them@their-example.com');
				$CI->email->subject($argArray['subject']);
				$CI->email->message($message);
				$CI->email->send();
				
			break;
			
			case 'SEND_REG_APP_MAIL':
				
				$viewArr['to'] 	= $fromName;
				$viewArr['toName']= $argArray['toName'];
				$viewArr['message'] 	= $argArray['message'];
				$message=$CI->load->view('emails/emailTemplate',$viewArr,true);
				$CI->load->library('email');
				$config['charset'] = 'utf-8';
				$config['wordwrap'] = TRUE;
				$config['mailtype'] = 'html';
				$CI->email->initialize($config);
				$CI->email->from($fromName);
				$CI->email->to($fromEmail);
				//$CI->email->cc('another@another-example.com');
				//$CI->email->bcc('them@their-example.com');
				$CI->email->subject($argArray['subject']);
				$CI->email->message($message);
				$CI->email->send();
			break;
		
			
			default:
			break;
		} 
		
	    return $passEmailArgs;
	}
	
	//getFormattedHeaders to get headers in prefromatted format.
	function getFormattedHeaders(){
		
		//get headers variable
		$headers = array();
               
		if(!function_exists('apache_request_headers')) {
			function apache_request_headers() {
				foreach($_SERVER as $key => $value) {
					if(substr($key, 0, 5) == 'HTTP_') {
						$headers[str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))))] = $value;
					}
				}
				return $headers;
			}
		}
		else{
			$headers = apache_request_headers();
		}

		$headers = apache_request_headers();
		foreach($headers as $key => $value) 
		{					
		   $headers[str_replace('-', '_', strtolower($key))] = $value;			
		}		
		return $headers;	
	}
}
