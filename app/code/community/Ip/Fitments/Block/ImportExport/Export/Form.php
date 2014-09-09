<?php

class Ip_Fitments_Block_ImportExport_Export_Form extends Mage_Adminhtml_Block_Widget_Form
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
            //'enctype' => 'multipart/form-data'
        ));
        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('importexport')->__('Export Settings')));
        $fieldset->addField('entity', 'select', array(
            'name'     => 'entity',
            'title'    => Mage::helper('importexport')->__('Entity Type'),
            'label'    => Mage::helper('importexport')->__('Entity Type'),
            'required' => true,
            'values'   => array(
                //array('value' => 'vehicles', 'label' => 'Vehicles Only'),
                array('value' => 'fitments', 'label' => 'Product Fitments'),
            )
        ));
        $fieldset->addField('count', 'select', array(
            'name'     => 'count',
            'title'    => Mage::helper('importexport')->__('Row Count'),
            'label'    => Mage::helper('importexport')->__('Row Count'),
            'required' => true,
            'values'   => $this->getCountOptions()
        ));

        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

    protected function getCountOptions()
    {
        $options = array();
        $limit = Ip_Fitments_Model_ImportExport_Export::PAGE_LIMIT;
        $count = Mage::getModel('fitments/core_resource')->getFitmentsCollection()->getSize();
        $last_max = 0;
        for($i = 0; $i < $count; $i+=$limit){
            if(!$i){continue;}
            $min = $i - $limit;
            $max = $i > $count ? $count : $i;
            $options[] = array('value' => $min.','.$max, 'label' => $min.' - '.$max);
            $last_max = $max;
        }
        $options[] = array('value' => $last_max.','.$count, 'label' => $last_max.' - '.$count);
        return $options;
    }
}
