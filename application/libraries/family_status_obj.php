<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of family_status_obj
 *
 * @author mayoori
 */
class family_status_obj {
    var $id;
    var $family_status;
    var $family_status_label;
    
    public function getId() {
        return $this->id;
    }

    public function getFamily_status() {
        return $this->family_status;
    }

    public function getFamily_status_label() {
        return $this->family_status_label;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setFamily_status($family_status) {
        $this->family_status = $family_status;
    }

    public function setFamily_status_label($family_status_label) {
        $this->family_status_label = $family_status_label;
    }


}
