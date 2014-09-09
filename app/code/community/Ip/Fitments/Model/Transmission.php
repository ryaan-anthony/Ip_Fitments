<?php

class Ip_Fitments_Model_Transmission extends Ip_Fitments_Core_Entity
{
    public $type_name = "Transmission";
    public $is_required = false;

    protected function _construct()
    {
        $this->_init('fitments/transmission');
    }

}