<?php

class Ip_Fitments_Model_Search_Resource_Result extends Mage_Core_Model_Resource_Db_Abstract
{

    protected function _construct()
    {
        $this->_init('fitmentsearch/result', 'result_id');
    }

}