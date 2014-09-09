<?php

/**
 * Dashboard vehicle query column renderer
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 */
class Ip_Fitments_Block_Adminhtml_Dashboard_Widget_Renderer_Vehicle
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $value = $row->getData($this->getColumn()->getIndex());
        //todo do stuff maybe..
        return $value;
    }
}
