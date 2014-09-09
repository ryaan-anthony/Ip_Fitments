<?php

class Ip_Fitments_Model_Drivetrain extends Ip_Fitments_Core_Entity
{
    public $type_name = "Drivetrain";
    public $is_required = false;

    protected function _construct()
    {
        $this->_init('fitments/drivetrain');
    }

}