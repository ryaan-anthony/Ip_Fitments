<?php

class Ip_Fitments_Block_Adminhtml_Abstract_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public $_fitmentType;

    public function __construct()
    {
        //do this before parent constructor to enable delete button
        $this->_objectId = 'id';

        parent::__construct();

        $this->_removeButton('back');

        $this->_addButton('back', array(
            'label'     => Mage::helper('adminhtml')->__('Manage Fitments'),
            'onclick'   => 'setLocation(\'' . $this->getBackUrl() . '\')',
            'class'     => 'back',
        ), -1);

        $this->_blockGroup = 'fitments';
        $this->_controller = 'adminhtml_'.$this->_fitmentType;
        $this->_mode = 'edit';

        $this->_addButton('save_and_continue', array(
            'label' => $this->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('form_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'edit_form');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'edit_form');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        $fitment = ucwords($this->_fitmentType);
        if (Mage::registry('fitment_data') && Mage::registry('fitment_data')->getId()){
            return 'Edit '.$fitment;
        } else {
            $this->_removeButton('save_and_continue');
            return 'Add New '.$fitment;
        }
    }

    public function getBackUrl()
    {
        return $this->getUrl('*');
    }

}