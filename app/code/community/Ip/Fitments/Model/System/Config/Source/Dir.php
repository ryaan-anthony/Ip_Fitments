<?php

class Ip_Fitments_Model_System_Config_Source_Dir
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 'asc', 'label'=>Mage::helper('adminhtml')->__('Ascending')),
            array('value' => 'desc', 'label'=>Mage::helper('adminhtml')->__('Descending')),
        );
    }

}
