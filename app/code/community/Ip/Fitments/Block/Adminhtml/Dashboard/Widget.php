<?php

class Ip_Fitments_Block_Adminhtml_Dashboard_Widget extends Mage_Adminhtml_Block_Template
{


    protected function _prepareLayout()
    {

        $this->setChild('topVehicles',
            $this->getLayout()->createBlock('fitments/adminhtml_dashboard_widget_top')
        );

        $this->setChild('lastVehicles',
            $this->getLayout()->createBlock('fitments/adminhtml_dashboard_widget_last')
        );

        parent::_prepareLayout();
    }




}