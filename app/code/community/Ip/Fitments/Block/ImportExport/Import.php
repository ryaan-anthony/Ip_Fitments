<?php

class Ip_Fitments_Block_ImportExport_Import extends Mage_Adminhtml_Block_Widget_Form_Container
{

    /*
     * Form = $this->_blockGroup . '/' . $this->_controller . '_' . $this->_mode . '_form'
     */
    protected $_blockGroup = 'fitments';
    protected $_controller = 'importExport';
    protected $_mode = 'import';


    public function __construct()
    {
        parent::__construct();

        $this->removeButton('back')
            ->removeButton('reset')
            ->_updateButton('save', 'label', $this->__('Run Import'))
            ->_updateButton('save', 'id', 'upload_button')
            ->_updateButton('save', 'onclick', 'editForm.submit();');
    }


    public function getHeaderText()
    {
        return Mage::helper('adminhtml')->__('Fitments: Import');
    }
}
