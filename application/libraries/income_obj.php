<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of income_obj
 *
 * @author mayoori
 */
class income_obj {
    var $id;
    var $start_income;
    var $end_income;
    var $label;
    
    public function getId() {
        return $this->id;
    }

    public function getStart_income() {
        return $this->start_income;
    }

    public function getEnd_income() {
        return $this->end_income;
    }

    public function getLabel() {
        return $this->label;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setStart_income($start_income) {
        $this->start_income = $start_income;
    }

    public function setEnd_income($end_income) {
        $this->end_income = $end_income;
    }

    public function setLabel($label) {
        $this->label = $label;
    }


}
