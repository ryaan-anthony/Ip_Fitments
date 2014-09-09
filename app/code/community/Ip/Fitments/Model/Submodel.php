<?php

class Ip_Fitments_Model_Submodel extends Ip_Fitments_Core_Entity
{
    public $type_name = "Submodel";
    public $is_required = false;

    protected function _construct()
    {
        $this->_init('fitments/submodel');
    }

}