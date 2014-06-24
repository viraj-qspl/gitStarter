<?php

ini_set('dusplay_errors',1);
error_reporting(E_ALL);

class filter_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->database();					
		$this->config->load('dbtables', TRUE);
	}
	
	
	public function getAllFilters()
	{
		$agegroup = $this->db->get($this->config->item('tbl_ageGroup','dbtables'))->result();
		
		$gender = $this->config->item('gender');
		
		$country = $this->db->query('select *,NULL as province from '.$this->config->item('tbl_country','dbtables').' ')->result();
		
		foreach($country as $key=>$value){
			$country[$key]->province = $this->db->query('select *,NULL as city from '.$this->config->item('tbl_province','dbtables').' where country_id='.$value->id)->result();	

			
			
			foreach($country[$key]->province as $k=>$v) {
				$country[$key]->province[$k]->city = $this->db->query('select *   from '.$this->config->item('tbl_city','dbtables').' where province_id='.$v->id)->result();
			}
			
		}
	
	
		
		
		$relationship = $this->db->query('select * from '.$this->config->item('tbl_relationship','dbtables'))->result();
		
		$education = $this->db->get($this->config->item('tbl_education','dbtables'))->result();
		
		$income = $this->db->get($this->config->item('tbl_income','dbtables'))->result();
		
		$jobFunction = $this->db->get($this->config->item('tbl_jobFunction','dbtables'))->result();
		
		$jobStatus = $this->db->get($this->config->item('tbl_jobStatus','dbtables'))->result();
		
		
		
		$familyStatus = $this->db->get($this->config->item('tbl_familyStatus','dbtables'))->result();
		

		
		$interestCategory = $this->db->query('select *,NULL as interest from '.$this->config->item('tbl_interestCategory','dbtables'))->result();
		
		foreach($interestCategory as $key=>$value) {
			$interestCategory[$key]->interest = $this->db->query('select * from '.$this->config->item('tbl_interest','dbtables').' where interest_category_id='.$value->id)->result();
		}
		
		
		
		
		$interest = $this->db->get($this->config->item('tbl_interest','dbtables'))->result();
		
		
		
		return array('ageGroup'=>$agegroup,'gender'=>$gender,'country'=>$country,'relationship'=>$relationship,'education'=>$education,'income'=>$income,'jobFunction'=>$jobFunction,'jobStatus'=>$jobStatus,'interestCategory'=>$interestCategory,'familyStatus'=>$familyStatus);
	
	
	
	}
	
	
	public function getSavedFilters($pollId) {
	
		$savedFilters = array();
		
		$savedFilters['ageGroupFilter'] = $this->db->get_where($this->config->item('tbl_ageGroupFilter','dbtables'),array('poll_id'=>$pollId))->result();
		$savedFilters['countryFilter'] = $this->db->get_where($this->config->item('tbl_countryFilter','dbtables'),array('poll_id'=>$pollId))->result();
		$savedFilters['regionFilter'] = $this->db->get_where($this->config->item('tbl_regionFilter','dbtables'),array('poll_id'=>$pollId))->result();
		$savedFilters['provinceFilter'] = $this->db->get_where($this->config->item('tbl_provinceFilter','dbtables'),array('poll_id'=>$pollId))->result();
		$savedFilters['incomeGroupFilter'] = $this->db->get_where($this->config->item('tbl_incomeGroupFilter','dbtables'),array('poll_id'=>$pollId))->result();
		$savedFilters['educationFilter'] = $this->db->get_where($this->config->item('tbl_educationFilter','dbtables'),array('poll_id'=>$pollId))->result();
		$savedFilters['jobFunctionFilter'] = $this->db->get_where($this->config->item('tbl_jobFunctionFilter','dbtables'),array('poll_id'=>$pollId))->result();
		$savedFilters['interestFilter'] = $this->db->get_where($this->config->item('tbl_interestFilter','dbtables'),array('poll_id'=>$pollId))->result();
		$savedFilters['jobStatusFilter'] = $this->db->get_where($this->config->item('tbl_jobStatusFilter','dbtables'),array('poll_id'=>$pollId))->result();
		$savedFilters['familyStatusFilter'] = $this->db->get_where($this->config->item('tbl_familyStatusFilter','dbtables'),array('poll_id'=>$pollId))->result();
		$savedFilters['relationshipFilter'] = $this->db->get_where($this->config->item('tbl_relationshipFilter','dbtables'),array('poll_id'=>$pollId))->result();
		
		$pollInfo = $this->db->get_where($this->config->item('tbl_poll','dbtables'),array('id'=>$pollId))->row();
		$savedFilters['genderFilter'] = $pollInfo->gender;
		
		return $savedFilters;

	
	}
	
	
	
	
	
	
}	
	
/*end of file*/	