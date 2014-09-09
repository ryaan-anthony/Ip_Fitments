<?php

class Ip_Fitments_Block_Adminhtml_Abstract_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $data = Mage::registry('fitment_data');

        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method' => 'post',
            'enctype' => 'multipart/form-data',
        ));

        $form->setUseContainer(true);

        $this->setForm($form);

        $fieldset = $form->addFieldset('fitment_form', array(
            'legend' => "",
        ));


        $fieldset->addField('value', 'text', array(
            'label'     => $this->__('Value'),
            'class'     => 'required-entry',
            'style'     =>  'width:700px;',
            'required'  => true,
            'name'      => 'value',
        ));


        $fieldset->addField('position', 'text', array(
            'label'     => $this->__('Position'),
            'style'     =>  'width:700px;',
            'required'  => false,
            'name'      => 'position',
        ));

        $form->setValues($data);

        return parent::_prepareForm();
    }

}