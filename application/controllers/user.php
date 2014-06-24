<?php

class User extends CI_Controller {

    /**
     * 
     * This is default constructor
     */
    function __construct() {
        // Write to log file
        log_message('info', '--------------> User - construct() called');

        // Call to Controller constructor
        parent::__construct();

        // Load helpers, models and library - autoload.php has defined common loads
        $this->load->library(array('user_obj', 'user_list'));
        $this->load->model('user_model');
//        $this->load->model('country_model');
//        $this->load->model('state_model');
//        $this->load->model('city_model');
//        $this->load->model('area_model');

        // Check for admin login, this function will automatically redirect to admin login page
        $this->common_method->adminAuthentication();

        // Define array that will store values to be sent to view page
        $viewArr = array();
    }

    /**
     * 
     * This is default function
     */
    function index() {
        // Display listing 		
        $this->listing();
    }

}
