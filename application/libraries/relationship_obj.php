<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of relationship_obj
 *
 * @author mayoori
 */
class relationship_obj {
   var $id;
   var $relationship;
   var $relationship_label;
   
   public function getId() {
       return $this->id;
   }

   public function getRelationship() {
       return $this->relationship;
   }

   public function getRelationship_label() {
       return $this->relationship_label;
   }

   public function setId($id) {
       $this->id = $id;
   }

   public function setRelationship($relationship) {
       $this->relationship = $relationship;
   }

   public function setRelationship_label($relationship_label) {
       $this->relationship_label = $relationship_label;
   }


}
