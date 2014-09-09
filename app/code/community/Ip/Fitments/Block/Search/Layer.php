<?php

/**
 * Layered Navigation block for vehicle search
 *
 */
class Ip_Fitments_Block_Search_Layer extends Mage_CatalogSearch_Block_Layer
{

    /**
     * Get layer object
     *
     * @return Mage_Catalog_Model_Layer
     */
    public function getLayer()
    {
        return Mage::getSingleton('fitmentsearch/layer');
    }
}
