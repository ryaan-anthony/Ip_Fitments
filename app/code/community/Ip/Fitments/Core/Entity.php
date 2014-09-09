<?php

class Ip_Fitments_Core_Entity extends Mage_Core_Model_Abstract
{

    public function getOptions($placeholder = '- select -', $value = '', $selected = '', $options = array())
    {
        $fitment = strtolower($this->type_name);
        if($options){
            $collection = $this->getAvailableOptions($fitment, $options, true);
        } else {
            $collection = $this->getCollection();
        }
        $this->addSort($fitment, $collection);
        $html = $this->getOption($value, $placeholder, $selected);
        foreach($collection as $item){
            $html .= $this->getOption($item->getId(), $item->getValue(), $selected);
        }
        return $html;
    }

    public function getOptionsArray($collection, $placeholder = '- select -')
    {
        $json = array();
        $json[] = array('id' => '-1', 'value' => $placeholder);
        foreach($collection as $item){
            if($item->getValue()){
                $json[] = array('id' => $item->getId(), 'value' => $item->getValue());
            }
        }
        return $json;
    }

    public function getOption($value, $label, $selected)
    {
        $template = Mage::app()->getLayout()->createBlock('core/template');
        $template->setIsSelected($value == $selected);
        $template->setValue($value);
        $template->setLabel($label);
        if(Mage::app()->getStore()->getCode() == 'admin'){
            $template->setTemplate('fitments/catalog/product/tab/template/option.phtml');
        } else {
            $template->setTemplate('fitments/selector/form/option.phtml');
        }
        return $template->toHtml();
    }

    /**
     * Get available dropdown options for the selected $type and filter by previously selected $options
     * @param string $type (make, model, year, etc)
     * @param array $options [type => id, ...]
     * @param mixed $return true = collection; false = array
     * @return array options for select
     */
    public function getAvailableOptions($type, $options, $return = false)
    {
        /**
         * @var Ip_Fitments_Model_Core_Resource $fitments
         */
        $fitments = Mage::getModel('fitments/core_resource');
        $collection = $fitments->getFitmentsCollection(null, $options);

        // get $alias for $type to set columns
        $alias = array_search($type, $fitments->table_names);
        $collection->getSelect()
            ->reset(Zend_Db_Select::COLUMNS)
            ->columns($alias.'.id')
            ->columns($alias.'.value')
            ->distinct(true);

        // unset all parts that aren't $type or in $options
        $fromPart = $collection->getSelect()->getPart(Zend_Db_Select::FROM);
        $protected = array_keys($options);
        $protected[] = $type;
        foreach($fitments->table_names as $alias => $table){
            $found = array_search($table, $protected);
            if($found === false || (isset($options[$table]) && $options[$table] == -1)){
                unset($fromPart[$alias]);
            } else {
                $this->addSort($table, $collection, $alias);
            }
        }
        $collection->getSelect()->setPart(Zend_Db_Select::FROM, $fromPart);
        // return options array
        if($return){
            return $collection;
        }
        return $this->getOptionsArray($collection, strtoupper($this->type_name));
    }

    /**
     * Load object data and create if doesnt exist
     *
     * @param   integer $id
     * @return  Mage_Core_Model_Abstract
     */
    public function createIfDoesntExist($id, $field=null)
    {
        $this->load($id, $field);
        if(!$this->getId()){
            $this->setData($field, $id);
            $this->save();
        }
        return $this;
    }

    protected function addSort($type, $collection, $alias = '')
    {
        $field = Mage::getStoreConfig('fitments/selector/'.$type.'_sort_field');
        $dir = Mage::getStoreConfig('fitments/selector/'.$type.'_sort_dir');
        if($field && $dir){
            $collection->getSelect()->order(($alias ? $alias.'.' : '')."{$field} {$dir}");
        }
    }

}