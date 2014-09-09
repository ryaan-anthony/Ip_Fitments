<?php

class Ip_Fitments_Block_ImportExport_Import_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Add fieldset
     *
     * @return Mage_ImportExport_Block_Adminhtml_Import_Edit_Form
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id'      => 'edit_form',
            'action'  => $this->getUrl('*/*/execute'),
            'method'  => 'post',
            'enctype' => 'multipart/form-data'
        ));
        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('importexport')->__('Import Settings')));
        $fieldset->addField('entity', 'select', array(
            'name'     => 'entity',
            'title'    => Mage::helper('importexport')->__('Entity Type'),
            'label'    => Mage::helper('importexport')->__('Entity Type'),
            'required' => true,
            'values'   => array(
                array('value' => 'vehicles', 'label' => 'Vehicles Only'),
                array('value' => 'fitments', 'label' => 'Product Fitments'),
            )
        ));
        $fieldset->addField('behavior', 'select', array(
            'name'     => 'behavior',
            'title'    => Mage::helper('importexport')->__('Import Behavior'),
            'label'    => Mage::helper('importexport')->__('Import Behavior'),
            'required' => true,
            'values'   => array(
                array('value' => Ip_Fitments_Model_ImportExport_Import::BEHAVIOR_APPEND, 'label' => 'Append Complex Data'),
                array('value' => Ip_Fitments_Model_ImportExport_Import::BEHAVIOR_REPLACE, 'label' => 'Replace Existing Complex Data'),
            )
        ));
        $fieldset->addField(Ip_Fitments_Model_ImportExport_Import::FIELD_NAME_SOURCE_FILE, 'file', array(
            'name'     => Ip_Fitments_Model_ImportExport_Import::FIELD_NAME_SOURCE_FILE,
            'label'    => Mage::helper('importexport')->__('Select File to Import'),
            'title'    => Mage::helper('importexport')->__('Select File to Import'),
            'required' => true
        ));

        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
