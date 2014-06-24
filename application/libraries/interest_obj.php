<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of interest_obj
 *
 * @author mayoori
 */
class interest_obj {
    var $id;
    var $interest;
    var $interest_category_id;
    
    public function getId() {
        return $this->id;
    }

    public function getInterest() {
        return $this->interest;
    }

    public function getInterest_category_id() {
        return $this->interest_category_id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setInterest($interest) {
        $this->interest = $interest;
    }

    public function setInterest_category_id($interest_category_id) {
        $this->interest_category_id = $interest_category_id;
    }


    
}
