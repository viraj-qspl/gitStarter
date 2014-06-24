<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of province_obj
 *
 * @author mayoori
 */
class province_obj {
    var $id;
    var $province;
    var $country_id;
    var $region_id;
    
    public function getId() {
        return $this->id;
    }

    public function getProvince() {
        return $this->province;
    }

    public function getCountry_id() {
        return $this->country_id;
    }

    public function getRegion_id() {
        return $this->region_id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setProvince($province) {
        $this->province = $province;
    }

    public function setCountry_id($country_id) {
        $this->country_id = $country_id;
    }

    public function setRegion_id($region_id) {
        $this->region_id = $region_id;
    }


}
