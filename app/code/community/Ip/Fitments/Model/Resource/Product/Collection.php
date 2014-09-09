<?php

class Ip_Fitments_Model_Resource_Product_Collection extends Mage_Catalog_Model_Resource_Product_Collection
{

    /**
     * Initialize resources
     *
     */
    public function prepareFitments($params)
    {
        $whereCond = array();
        $alias = 'fit';
        $selected = array_keys($params);
        /**
         * @var Ip_Fitments_Model_Core_Resource $fitments
         */
        $fitments = Mage::getModel('fitments/core_resource');
        foreach($fitments->table_names as $fitment){
            if(in_array($fitment, $selected)){
                $fitment_model = Mage::getModel('fitments/'.$fitment);
                $column = $alias.'.'.$fitment.'_id';
                if($fitment_model->is_required){
                    $whereCond[] = sprintf("{$column} = %d", (int)$params[$fitment]);
                } else {
                    $whereCond[] = sprintf("({$column} = %d or {$column} IS NULL)", (int)$params[$fitment]);
                }
            }
        }
        $this->getSelect()->joinLeft(
            array($alias => Mage::getSingleton('core/resource')->getTableName('fitments/fitment')),
            $alias.'.product_id = e.entity_id'
        )->orWhere(implode(' and ', $whereCond));
    }

    /**
     * Get SQL for get record count
     *
     * @return Varien_Db_Select
     */
    public function getSelectCountSql()
    {
        $this->_renderFilters();

        $countSelect = clone $this->getSelect();
        $countSelect->reset(Zend_Db_Select::ORDER);
        $countSelect->reset(Zend_Db_Select::LIMIT_COUNT);
        $countSelect->reset(Zend_Db_Select::LIMIT_OFFSET);
        $countSelect->reset(Zend_Db_Select::COLUMNS);
        $countSelect->reset(Zend_Db_Select::GROUP);

        $countSelect->columns('COUNT(DISTINCT e.entity_id)');

        return $countSelect;
    }

}