<?php

class Ip_Fitments_Model_Resource_Fitment extends Mage_Core_Model_Resource_Db_Abstract
{

    protected function _construct()
    {
        $this->_init('fitments/fitment', 'id');
    }

}