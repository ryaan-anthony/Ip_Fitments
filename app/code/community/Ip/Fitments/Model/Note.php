<?php

class Ip_Fitments_Model_Note extends Ip_Fitments_Core_Entity
{
    public $type_name = "Note";
    public $is_required = false;

    protected function _construct()
    {
        $this->_init('fitments/note');
    }

}