<?php


//class Country_obj extends Base_master {
class Country_obj {
	// This class takes all the required properties from Base_master
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
/*end of file*/