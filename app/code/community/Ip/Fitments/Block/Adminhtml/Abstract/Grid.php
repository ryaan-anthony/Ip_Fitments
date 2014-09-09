<?php

class Ip_Fitments_Block_Adminhtml_Abstract_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('fitment_grid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('desc');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('fitments/'.$this->getParentBlock()->_fitmentType)
            ->getCollection()
            ->addFieldToSelect('*');
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('value', array(
            'header'    => ucwords($this->getParentBlock()->_fitmentType),
            'align'     => 'left',
            'width'     => '50px',
            'index'     => 'value',
        ));
        $this->addColumn('position', array(
            'header'    => 'Position',
            'align'     => 'left',
            'width'     => '50px',
            'index'     => 'position',
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId(), 'type' => $this->getParentBlock()->_fitmentType));
    }
}