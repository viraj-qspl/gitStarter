<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of settings
 *
 * @author mayoori
 */
class Settings_obj {
    var $id;
    var $first_poll;
    var $invite_friend;
    var $each_poll;
    var $admin_poll;
    var $points;
    var $cash;
    var $age_fil;
    var $gender_fil;
    var $loc_filter;
    var $rel_filter;
    var $edu_fil;
    var $inc_fil;
    var $job_func_fil;
    var $job_stat_fil;
    var $int_fil;
    var $vat;
    var $facebook_url;
    var $facebook_app_id;
    var $twitter_url;
    var $admin_email;
    var $approve_message;
    var $reject_message;
    
    public function getId() {
        return $this->id;
    }

    public function getFirst_poll() {
        return $this->first_poll;
    }

    public function getInvite_friend() {
        return $this->invite_friend;
    }

    public function getEach_poll() {
        return $this->each_poll;
    }

    public function getAdmin_poll() {
        return $this->admin_poll;
    }

    public function getPoints() {
        return $this->points;
    }

    public function getCash() {
        return $this->cash;
    }

    public function getAge_fil() {
        return $this->age_fil;
    }

    public function getGender_fil() {
        return $this->gender_fil;
    }

    public function getLoc_filter() {
        return $this->loc_filter;
    }

    public function getRel_filter() {
        return $this->rel_filter;
    }

    public function getEdu_fil() {
        return $this->edu_fil;
    }

    public function getInc_fil() {
        return $this->inc_fil;
    }

    public function getJob_func_fil() {
        return $this->job_func_fil;
    }

    public function getJob_stat_fil() {
        return $this->job_stat_fil;
    }

    public function getInt_fil() {
        return $this->int_fil;
    }

    public function getVat() {
        return $this->vat;
    }

    public function getFacebook_url() {
        return $this->facebook_url;
    }

    public function getFacebook_app_id() {
        return $this->facebook_app_id;
    }

    public function getTwitter_url() {
        return $this->twitter_url;
    }

    public function getAdmin_email() {
        return $this->admin_email;
    }

    public function getApprove_message() {
        return $this->approve_message;
    }

    public function getReject_message() {
        return $this->reject_message;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setFirst_poll($first_poll) {
        $this->first_poll = $first_poll;
    }

    public function setInvite_friend($invite_friend) {
        $this->invite_friend = $invite_friend;
    }

    public function setEach_poll($each_poll) {
        $this->each_poll = $each_poll;
    }

    public function setAdmin_poll($admin_poll) {
        $this->admin_poll = $admin_poll;
    }

    public function setPoints($points) {
        $this->points = $points;
    }

    public function setCash($cash) {
        $this->cash = $cash;
    }

    public function setAge_fil($age_fil) {
        $this->age_fil = $age_fil;
    }

    public function setGender_fil($gender_fil) {
        $this->gender_fil = $gender_fil;
    }

    public function setLoc_filter($loc_filter) {
        $this->loc_filter = $loc_filter;
    }

    public function setRel_filter($rel_filter) {
        $this->rel_filter = $rel_filter;
    }

    public function setEdu_fil($edu_fil) {
        $this->edu_fil = $edu_fil;
    }

    public function setInc_fil($inc_fil) {
        $this->inc_fil = $inc_fil;
    }

    public function setJob_func_fil($job_func_fil) {
        $this->job_func_fil = $job_func_fil;
    }

    public function setJob_stat_fil($job_stat_fil) {
        $this->job_stat_fil = $job_stat_fil;
    }

    public function setInt_fil($int_fil) {
        $this->int_fil = $int_fil;
    }

    public function setVat($vat) {
        $this->vat = $vat;
    }

    public function setFacebook_url($facebook_url) {
        $this->facebook_url = $facebook_url;
    }

    public function setFacebook_app_id($facebook_app_id) {
        $this->facebook_app_id = $facebook_app_id;
    }

    public function setTwitter_url($twitter_url) {
        $this->twitter_url = $twitter_url;
    }

    public function setAdmin_email($admin_email) {
        $this->admin_email = $admin_email;
    }

    public function setApprove_message($approve_message) {
        $this->approve_message = $approve_message;
    }

    public function setReject_message($reject_message) {
        $this->reject_message = $reject_message;
    }



}
