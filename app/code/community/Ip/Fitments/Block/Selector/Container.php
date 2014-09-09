<?php

class Ip_Fitments_Block_Selector_Container extends Mage_Core_Block_Template
{
    protected $_cacheKey = "Ip_Fitments_Block_Selector_Container";

    function _construct()
    {
        $current_category = Mage::registry('current_category');
        $category = Mage::app()->getRequest()->getParam('cat', $current_category ? $current_category->getId() : null);
        $this->addData(array(
            'query' => Mage::app()->getRequest()->getParam('q', null),
            'category' => $category,
//            'cache_lifetime'=> false,
//            'cache_tags'    => array(
//                Mage_Core_Model_Store::CACHE_TAG,
//                Mage_Cms_Model_Block::CACHE_TAG
//            )
        ));
        $this->setTemplate('fitments/selector/container.phtml');
    }

    public function getOptions($type)
    {
        $label = strtoupper($type);
        if($selected = $this->getCurrentParams($type)){
            $options = $this->getCurrentOptions($type);
            $fit = Mage::getModel('fitments/'.$type);
            return $fit->getOptions($label, '-1', $selected, $options);
        } else {
            if($type == 'make'){
                /* @var Ip_Fitments_Model_Make $make */
                $make = Mage::getModel('fitments/make');
                return $make->getOptions('MAKE', '-1');
            } else {
                return '<option value="-1">'.$label.'</option>';
            }
        }
    }

    protected function getParamLabel($type, $param)
    {
        $collection = Mage::getModel('fitments/'.$type)->getCollection();
        $collection->addFieldToFilter('id', array('eq' => $param));
        $label = $collection->getFirstItem();
        return $label->getValue();

    }

    protected function getCurrentOptions($type)
    {
        $options = array();
        $params = Mage::getSingleton('customer/session')->getVehicleParams();
        foreach($params as $key => $param){
            if($key == $type){break;}
            $options[$key] = $param;
        }
        return $options;
    }

    protected function getCurrentParams($type)
    {
        $params = Mage::getSingleton('customer/session')->getVehicleParams();
        if(isset($params[$type])){
            return $params[$type];
        }
        return null;
    }

    public function getResetUrl()
    {
        return Mage::getUrl('fitments_selector/ajax/reset');
    }

    public function getUpdateUrl()
    {
        return Mage::getUrl('fitments_selector/ajax/update');
    }

    public function getPostUrl()
    {
        return Mage::getUrl('vehiclesearch/result/index');
    }

    /**
     * Get cache key informative items
     *
     * @return array
     */
//    public function getCacheKeyInfo()
//    {
//        return array(
//            $this->_cacheKey,
//            Mage::app()->getStore()->getId(),
//            (int)Mage::app()->getStore()->isCurrentlySecure(),
//            Mage::getDesign()->getPackageName(),
//            Mage::getDesign()->getTheme('template')
//        );
//    }

    /**
     * Retrieve child block HTML, sorted by default
     *
     * @param   string $name
     * @param   boolean $useCache
     * @return  string
     */
//    public function getChildHtml($name='', $useCache=true, $sorted=true)
//    {
//        return parent::getChildHtml($name, $useCache, $sorted);
//    }


}