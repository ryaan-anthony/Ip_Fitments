<?php

class Ip_Fitments_Model_Core_Observer
{

    public function saveFitments(Varien_Event_Observer $observer)
    {
        $event = $observer->getEvent();
        $product = $event->getProduct();
        $this->deleteFitments($product);
        if($product->hasData('fitments') && $product->hasData('is_universal') && !$product->getIsUniversal()){
            foreach($product->getFitments() as $fitment){
                $fitment['product_id'] = $product->getId();
                $fitment = array_filter($fitment, 'strlen');
                if(isset($fitment['note'])){
                    $note = Mage::getModel('fitments/note')->createIfDoesntExist($fitment['note'], 'value');
                    if(!$note->getId()){
                        $note->setValue($fitment['note']);
                        $note->save();
                    }
                    $fitment['note_id'] = $note->getId();
                }
                $model = Mage::getModel('fitments/fitment');
                $model->setData($fitment);
                $model->save();
            }
        }
    }

    protected function deleteFitments(Mage_Catalog_Model_Product $product)
    {
        /** @var Ip_Fitments_Core_Collection $collection */
        $collection = Mage::getModel('fitments/fitment')->getCollection()
            ->addFieldToFilter('product_id', array('eq' => $product->getId()));
        $collection->delete();
    }


    public function displayDashboardWidget(Varien_Event_Observer $observer)
    {
        /** @var $_block Mage_Core_Block_Abstract */
        $_block = $observer->getBlock();
        if ($_block->getType() == 'adminhtml/dashboard_sales') {
            echo Mage::app()->getLayout()
                ->createBlock('fitments/adminhtml_dashboard_widget')
                ->setTemplate('fitments/dashboard/widget.phtml')
                ->toHtml();
        }
    }

    public function redirectCategory(Varien_Event_Observer $observer)
    {
        $event = $observer->getEvent();
        $category = $event->getCategory();
        if($params = Mage::getSingleton('customer/session')->getVehicleParams()){
            $_query = array(
                '_query' => array('cat' => $category->getId()),
                '_secure' => $observer->getControllerAction()->getRequest()->isSecure()
            );
            $query_params = array_merge($_query, $params);
            $redirect_url = Mage::getUrl('vehiclesearch/result', $query_params);
            $observer->getControllerAction()->getResponse()->setRedirect($redirect_url);
        }
    }

}