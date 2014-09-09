<?php

class Ip_Fitments_Block_Catalog_Product_View_Fitments extends Mage_Core_Block_Template
{
    protected $_product = null;

    function getProduct()
    {
        if (!$this->_product) {
            $this->_product = Mage::registry('product');
        }
        return $this->_product;
    }

    public function getFitments()
    {
        /**
         * @var Ip_Fitments_Model_Core_Resource $fitments
         */
        $fitments = Mage::getModel('fitments/core_resource');
        return $fitments->getFitmentsCollection($this->getProduct()->getId());
    }

}