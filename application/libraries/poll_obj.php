<?php


class Poll_obj {

	var $id;
	var $user_id;
	var $title;
	var $image;
	var $descp;	
	var $pollCategory_id;
	var $pollPackage_id;
	var $poll_type;
	var $status;
	var $visibility;
	var $gender;
	var $relationship;
	var $family_status;
	var $job_status;
	var $create_date;
	var $expire_date;
	var $expired;
	var $template_id;
	
	var $data = array();

	function __construct(){	}
	


	public function __call($index,$value)					// Use magic method to get and set variables
	{
		if(substr($index,0,3) == 'set')
		{
			$varName = lcfirst(substr($index,3));			
			$this->$varName = $value[0];
		
		}
		elseif( substr($index,0,3) == 'get')
		{
			$varName = lcfirst(substr($index,3));
			return $this->$varName;							
		}
	}

}
/*end of file*/