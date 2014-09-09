<?php

class Ip_Fitments_Core_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    public function delete()
    {
        foreach($this as $item){
            $item->delete();
        }
    }

}