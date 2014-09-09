<?php

/**
 * Class Ip_Fitments_Block_Adminhtml_Catalog_Product_Tab_Template
 *
 * @method array getFitment()
 *
 */
class Ip_Fitments_Block_Adminhtml_Catalog_Product_Tab_Template extends Mage_Adminhtml_Block_Template
{

    protected $fitment_schema = array(
        'make' => array('id' => '#{make-id}', 'value' => '#{make}'),
        'model' => array('id' => '#{model-id}', 'value' => '#{model}'),
        'year' => array('id' => '#{year-id}', 'value' => '#{year}'),
        'submodel' => array('id' => '#{submodel-id}', 'value' => '#{submodel}'),
        'transmission' => array('id' => '#{transmission-id}', 'value' => '#{transmission}'),
        'engine' => array('id' => '#{engine-id}', 'value' => '#{engine}'),
        'drivetrain' => array('id' => '#{drivetrain-id}', 'value' => '#{drivetrain}'),
        'note' => array('id' => '-1', 'value' => '#{note}'),
    );

    protected function _toHtml()
    {
        if(!$this->hasData('id')){
            $this->setId('#{id}');
        }
        if(!$this->hasData('fitment')){
            $this->setFitment($this->fitment_schema);
        } else {
            $this->setFitment(array_merge(array_fill_keys(array_keys($this->fitment_schema), null), $this->getFitment()));
        }
        return parent::_toHtml();
    }

}

