<?php

class Ip_Fitments_Search_ResultController extends Mage_Core_Controller_Front_Action
{

    public function indexAction()
    {
        /* @var Ip_Fitments_Model_Search_Query $query */
        $query = Mage::getSingleton('fitmentsearch/query');
        $query->setStoreId(Mage::app()->getStore()->getId());
        $original_params = $this->getRequest()->getParams();
        $params = Mage::getModel('fitments/core_resource')->filterParams($original_params);
        $query->setQueryParams($params);
        if(isset($params['q'])){
            unset($params['q']);
        }
        if(isset($original_params['cat'])){
            $category = Mage::getModel('catalog/category')->load($original_params['cat']);
            Mage::register('current_category', $category);
        }
        Mage::getSingleton('customer/session')->setVehicleParams($params);

        // render the view
        $this->loadLayout();
        $url = Mage::helper('core/url')->getCurrentUrl();
        $this->getLayout()->getBlock('head')->addLinkRel('canonical', $url);
        $this->_initLayoutMessages('catalog/session');
        $this->_initLayoutMessages('checkout/session');
        $this->renderLayout();
    }

}