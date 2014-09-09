<?php

class Ip_Fitments_Model_Engine extends Ip_Fitments_Core_Entity
{
    public $type_name = "Engine";
    public $is_required = false;

    protected function _construct()
    {
        $this->_init('fitments/engine');
    }

}