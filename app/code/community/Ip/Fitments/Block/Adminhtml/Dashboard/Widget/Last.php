<?php

class Ip_Fitments_Block_Adminhtml_Dashboard_Widget_Last extends Mage_Adminhtml_Block_Dashboard_Grid
{
    protected $_collection;

    public function __construct()
    {
        parent::__construct();
        $this->setId('lastVehicleGrid');
    }

    protected function _prepareCollection()
    {
        $this->_collection = Mage::getModel('fitmentsearch/query')
            ->getCollection();

        if ($this->getRequest()->getParam('store')) {
            $this->_collection->addFieldToFilter('store_id', $this->getRequest()->getParam('store'));
        } else if ($this->getRequest()->getParam('website')){
            $storeIds = Mage::app()->getWebsite($this->getRequest()->getParam('website'))->getStoreIds();
            $this->_collection->addFieldToFilter('store_id', array('in' => $storeIds));
        } else if ($this->getRequest()->getParam('group')){
            $storeIds = Mage::app()->getGroup($this->getRequest()->getParam('group'))->getStoreIds();
            $this->_collection->addFieldToFilter('store_id', array('in' => $storeIds));
        }

        //set latest filter
        $this->_collection->setOrder('updated_at', 'DESC');

        //let limit
        $this->_collection->getPageSize(5);

        //get values
        Mage::getModel('fitments/core_resource')->joinFitmentTables($this->_collection, array('year', 'make', 'model', 'submodel', 'engine'));

        //format the vehicle
        $this->_collection->getSelect()->columns("CONCAT(yr.value,' ',mk.value,' ',md.value,' ',IFNULL(sm.value,''),' ',IFNULL(en.value,'')) as vehicle");

        $this->setCollection($this->_collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('vehicle', array(
            'header'    => $this->__('Vehicle'),
            'sortable'  => false,
            'index'     => 'vehicle',
            'renderer'  => 'fitments/adminhtml_dashboard_widget_renderer_vehicle',
        ));

        $this->addColumn('num_results', array(
            'header'    => $this->__('Results'),
            'sortable'  => false,
            'index'     => 'num_results',
            'type'      => 'number'
        ));

        $this->addColumn('popularity', array(
            'header'    => $this->__('Number of Uses'),
            'sortable'  => false,
            'index'     => 'popularity',
            'type'      => 'number'
        ));

        $this->setFilterVisibility(false);
        $this->setPagerVisibility(false);

        return parent::_prepareColumns();
    }

//    public function getRowUrl($row)
//    {
//        return $this->getUrl('*/catalog_search/edit', array('id'=>$row->getId()));
//    }
}
