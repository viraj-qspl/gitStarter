<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of jobstatus_obj
 *
 * @author mayoori
 */
class jobstatus_obj {
    var $id;
    var $job_status;
    var $job_status_label;
    
    public function getId() {
        return $this->id;
    }

    public function getJob_status() {
        return $this->job_status;
    }

    public function getJob_status_label() {
        return $this->job_status_label;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setJob_status($job_status) {
        $this->job_status = $job_status;
    }

    public function setJob_status_label($job_status_label) {
        $this->job_status_label = $job_status_label;
    }


}
