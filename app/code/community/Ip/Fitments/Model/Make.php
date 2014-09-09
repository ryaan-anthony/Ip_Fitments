<?php

class Ip_Fitments_Model_Make extends Ip_Fitments_Core_Entity
{
    public $type_name = "Make";
    public $is_required = true;

    protected function _construct()
    {
        $this->_init('fitments/make');
    }

}