<?php


class User_obj {

	var $id;
        var $email;
	var $password;
	var $name;
	var $last_name;
        var $phone;
        var $address;
        var $country_id;
        var $province_id;
        var $city_id;
        var $zip;
        var $language;
        var $dob;           //yyyy-mm-dd
        var $gender;
        var $education_id;
        var $income_group_id;
        var $relationship_id;
        var $family_status_id;
        var $job_function_id;
        var $job_status_id;
        var $facebook_id;
	var $user_type; //superadmin/admin/user
	var $first_poll; // whether first poll is answered or not
        var $region_id;
        var $last_answered_question;
        var $last_updated;
        var $created_date;
        
	function __construct(){	}
        
        public function getId() {
            return $this->id;
        }

        public function getEmail() {
            return $this->email;
        }

        public function getPassword() {
            return $this->password;
        }

        public function getName() {
            return $this->name;
        }

        public function getLast_name() {
            return $this->last_name;
        }

        public function getPhone() {
            return $this->phone;
        }

        public function getAddress() {
            return $this->address;
        }

        public function getCountry_id() {
            return $this->country_id;
        }

        public function getProvince_id() {
            return $this->province_id;
        }

        public function getCity_id() {
            return $this->city_id;
        }

        public function getZip() {
            return $this->zip;
        }

        public function getLanguage() {
            return $this->language;
        }

        public function getDob() {
            return $this->dob;
        }

        public function getGender() {
            return $this->gender;
        }

        public function getEducation_id() {
            return $this->education_id;
        }

        public function getIncome_group_id() {
            return $this->income_group_id;
        }

        public function getRelationship_id() {
            return $this->relationship_id;
        }

        public function getFamily_status_id() {
            return $this->family_status_id;
        }

        public function getJob_function_id() {
            return $this->job_funtion_id;
        }

        public function getJob_status_id() {
            return $this->job_status_id;
        }

        public function getFacebook_id() {
            return $this->facebook_id;
        }

        public function getUser_type() {
            return $this->user_type;
        }

        public function getFirst_poll() {
            return $this->first_poll;
        }

        public function getRegion_id() {
            return $this->region_id;
        }

        public function getLast_answered_question() {
            return $this->last_answered_question;
        }

        public function getLast_updated() {
            return $this->last_updated;
        }

        public function getCreated_date() {
            return $this->created_date;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function setEmail($email) {
            $this->email = $email;
        }

        public function setPassword($password) {
            $this->password = $password;
        }

        public function setName($name) {
            $this->name = $name;
        }

        public function setLast_name($last_name) {
            $this->last_name = $last_name;
        }

        public function setPhone($phone) {
            $this->phone = $phone;
        }

        public function setAddress($address) {
            $this->address = $address;
        }

        public function setCountry_id($country_id) {
            $this->country_id = $country_id;
        }

        public function setProvince_id($province_id) {
            $this->province_id = $province_id;
        }

        public function setCity_id($city_id) {
            $this->city_id = $city_id;
        }

        public function setZip($zip) {
            $this->zip = $zip;
        }

        public function setLanguage($language) {
            $this->language = $language;
        }

        public function setDob($dob) {
            $this->dob = $dob;
        }

        public function setGender($gender) {
            $this->gender = $gender;
        }

        public function setEducation_id($education_id) {
            $this->education_id = $education_id;
        }

        public function setIncome_group_id($income_group_id) {
            $this->income_group_id = $income_group_id;
        }

        public function setRelationship_id($relationship_id) {
            $this->relationship_id = $relationship_id;
        }

        public function setFamily_status_id($family_status_id) {
            $this->family_status_id = $family_status_id;
        }

        public function setJob_function_id($job_funtion_id) {
            $this->job_funtion_id = $job_funtion_id;
        }

        public function setJob_status_id($job_status_id) {
            $this->job_status_id = $job_status_id;
        }

        public function setFacebook_id($facebook_id) {
            $this->facebook_id = $facebook_id;
        }

        public function setUser_type($user_type) {
            $this->user_type = $user_type;
        }

        public function setFirst_poll($first_poll) {
            $this->first_poll = $first_poll;
        }

        public function setRegion_id($region_id) {
            $this->region_id = $region_id;
        }

        public function setLast_answered_question($last_answered_question) {
            $this->last_answered_question = $last_answered_question;
        }

        public function setLast_updated($last_updated) {
            $this->last_updated = $last_updated;
        }

        public function setCreated_date($created_date) {
            $this->created_date = $created_date;
        }



}
/*end of file*/