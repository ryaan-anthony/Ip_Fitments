<?php


class Ip_Fitments_Block_Adminhtml_Index extends Ip_Fitments_Block_Adminhtml_Abstract
{
    public $_fitmentType = 'index';

    public function __construct()
    {
        parent::__construct();
        $this->_controller = 'adminhtml_'.$this->_fitmentType;
        $this->_blockGroup = 'fitments';
        $this->_headerText = $this->__('Manage Fitments');
        $this->_removeButton('add');
        $this->_addButton('add_make', array(
            'label'     => 'Make',
            'onclick'   => 'setLocation(\'' . $this->getUrl('*/make/new') .'\')',
            'class'     => 'add',
        ));
        $this->_addButton('add_model', array(
            'label'     => 'Model',
            'onclick'   => 'setLocation(\'' . $this->getUrl('*/model/new') .'\')',
            'class'     => 'add',
        ));
        $this->_addButton('add_year', array(
            'label'     => 'Year',
            'onclick'   => 'setLocation(\'' . $this->getUrl('*/year/new') .'\')',
            'class'     => 'add',
        ));
        $this->_addButton('add_submodel', array(
            'label'     => 'Submodel',
            'onclick'   => 'setLocation(\'' . $this->getUrl('*/submodel/new') .'\')',
            'class'     => 'add',
        ));
        $this->_addButton('add_engine', array(
            'label'     => 'Engine',
            'onclick'   => 'setLocation(\'' . $this->getUrl('*/engine/new') .'\')',
            'class'     => 'add',
        ));
        $this->_addButton('add_drivetrain', array(
            'label'     => 'Drivetrain',
            'onclick'   => 'setLocation(\'' . $this->getUrl('*/drivetrain/new') .'\')',
            'class'     => 'add',
        ));
        $this->_addButton('add_transmission', array(
            'label'     => 'Transmission',
            'onclick'   => 'setLocation(\'' . $this->getUrl('*/transmission/new') .'\')',
            'class'     => 'add',
        ));
    }
}