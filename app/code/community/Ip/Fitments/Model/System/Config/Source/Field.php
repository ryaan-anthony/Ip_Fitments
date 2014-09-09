<?php

class Ip_Fitments_Model_System_Config_Source_Field
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 'id', 'label'=>Mage::helper('adminhtml')->__('Default')),
            array('value' => 'value', 'label'=>Mage::helper('adminhtml')->__('Title')),
            array('value' => 'position', 'label'=>Mage::helper('adminhtml')->__('Position')),
        );
    }

}
