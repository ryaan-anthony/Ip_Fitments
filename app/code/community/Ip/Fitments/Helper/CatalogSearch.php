<?php

class Ip_Fitments_Helper_CatalogSearch extends Mage_CatalogSearch_Helper_Data
{

    /**
     * Retrieve result page url and set "secure" param to avoid confirm
     * message when we submit form from secure page to unsecure
     *
     * @param   string $query
     * @return  string
     */
    public function getResultUrl($query = null)
    {
        if($params = Mage::getSingleton('customer/session')->getVehicleParams()){
            $_query = array(
                '_query' => array(self::QUERY_VAR_NAME => $query),
                '_secure' => Mage::app()->getFrontController()->getRequest()->isSecure()
            );
            $query_params = array_merge($_query, $params);
            return $this->_getUrl('vehiclesearch/result', $query_params);
        }
        return parent::getResultUrl($query);
    }

}