<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user_interest_obj
 *
 * @author mayoori
 */
class user_interest_obj {
    var $user_id;
    var $interest_id;
    
    public function getUser_id() {
        return $this->user_id;
    }

    public function getInterest_id() {
        return $this->interest_id;
    }

    public function setUser_id($user_id) {
        $this->user_id = $user_id;
    }

    public function setInterest_id($interest_id) {
        $this->interest_id = $interest_id;
    }


}
