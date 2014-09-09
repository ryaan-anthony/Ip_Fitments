<?php

class Ip_Fitments_Model_Year extends Ip_Fitments_Core_Entity
{
    public $type_name = "Year";
    public $is_required = true;

    protected function _construct()
    {
        $this->_init('fitments/year');
    }

}