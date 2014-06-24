<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of education_obj
 *
 * @author mayoori
 */
class education_obj {
    var $id;
    var $edu_level;
    
    public function getId() {
        return $this->id;
    }

    public function getEdu_level() {
        return $this->edu_level;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setEdu_level($edu_level) {
        $this->edu_level = $edu_level;
    }


}
