<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of jobfunction_obj
 *
 * @author mayoori
 */
class jobfunction_obj {
    
    var $id;
    var $job_function;

    public function getId() {
        return $this->id;
    }

    public function getJob_function() {
        return $this->job_function;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setJob_function($job_function) {
        $this->job_function = $job_function;
    }


}
