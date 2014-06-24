<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of region_obj
 *
 * @author mayoori
 */
class region_obj{
    
    var $id;
    var $region;
    var $country_id;
    
    public function getId() {
        return $this->id;
    }

    public function getRegion() {
        return $this->region;
    }

    public function getCountry_id() {
        return $this->country_id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setRegion($region) {
        $this->region = $region;
    }

    public function setCountry_id($country_id) {
        $this->country_id = $country_id;
    }


}
