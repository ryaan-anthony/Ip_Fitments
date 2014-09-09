<?php


class Ip_Fitments_Block_Adminhtml_Abstract extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    protected $_fitmentType;
    protected $_addButtonLabel = '';

    public function __construct()
    {
        parent::__construct();
        $this->_controller = 'adminhtml_'.$this->_fitmentType;
        $this->_blockGroup = 'fitments';
        $this->_headerText = 'View All '.ucwords($this->_fitmentType).'s';
        $this->_removeButton('add');
    }

    public function getCreateUrl()
    {
        return $this->getUrl('*/*/new');
    }

}