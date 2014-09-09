<?php

class Ip_Fitments_Model_Model extends Ip_Fitments_Core_Entity
{
    public $type_name = "Model";
    public $is_required = true;

    protected function _construct()
    {
        $this->_init('fitments/model');
    }

}