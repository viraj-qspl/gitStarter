<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of interest_category
 *
 * @author mayuri
 */
class interest_category_obj {
   var $id;
   var $name; 
   
   public function getId() {
       return $this->id;
   }

   public function getName() {
       return $this->name;
   }

   public function setId($id) {
       $this->id = $id;
   }

   public function setName($name) {
       $this->name = $name;
   }


}
