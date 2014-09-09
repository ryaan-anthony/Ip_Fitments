<?php

class Ip_Fitments_AjaxController extends Mage_Core_Controller_Front_Action
{

    public function updateAction()
    {
        $type = $this->getRequest()->getParam('type');
        $options = $this->getRequest()->getParams();
        /**
         * @var Ip_Fitments_Core_Entity $model
         */
        $model = Mage::getModel('fitments/'.$type);
        $output = $model->getAvailableOptions($type, $options);
        $jsonData = Mage::helper('core')->jsonEncode($output);
        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody($jsonData);
    }

    public function resetAction()
    {
        Mage::getSingleton('customer/session')->setVehicleParams(null);
        $q = $this->getRequest()->getParam('q');
        $cat = $this->getRequest()->getParam('cat');
        $url = Mage::getUrl('');
        if($q && $cat){
            $url = Mage::getUrl('catalogsearch/result', array(
                'q' => $q,
                'cat' => $cat,
            ));
        } elseif($q){
            $url = Mage::getUrl('catalogsearch/result', array(
                'q' => $q,
            ));

        } elseif($cat){
            $category = Mage::getModel('catalog/category')->load($cat);
            $url = Mage::helper('catalog/category')->getCategoryUrl($category);
        }
        $jsonData = Mage::helper('core')->jsonEncode(array("url" => $url));
        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody($jsonData);
    }



}