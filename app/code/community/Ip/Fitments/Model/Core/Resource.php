<?php

class Ip_Fitments_Model_Core_Resource
{
    public $table_names = array(
        'mk' => 'make',
        'md' => 'model',
        'yr' => 'year',
        'sm' => 'submodel',
        'en' => 'engine',
        'dr' => 'drivetrain',
        'tr' => 'transmission',
        'nt' => 'note',
    );

    /**
     * Get product fitments as array
     * @param $product_id
     * @return array
     */
    public function getFitmentsArray($product_id)
    {
        $results = array();
        foreach($this->getFitmentsCollection($product_id) as $item){
            $fits = array();
            foreach($this->table_names as $fitment){
                $fits[$fitment] = array(
                    'id' => $item->getData($fitment.'_id'),
                    'value' => $item->getData($fitment),
                );
            }
            $results[] = $fits;
        }
        return $results;
    }

    /**
     * Get product fitments as collection
     * @param $product_id
     * @return Ip_Fitments_Core_Collection
     */
    public function getFitmentsCollection($product_id = null, $options = array())
    {
        /**
         * @var Ip_Fitments_Core_Collection $collection
         */
        $collection = Mage::getModel('fitments/fitment')->getCollection();

        // apply product filter
        if($product_id){
            $collection->addFieldToFilter('product_id', array('eq' => $product_id));
        }

        // join all fitment tables
        $this->joinFitmentTables($collection);

        // apply fitment filters
        if($options){
            foreach($this->table_names as $alias => $fitment){
                if(isset($options[$fitment]) && $options[$fitment] != -1){
                    $collection->getSelect()->where($alias.'.id = ?', $options[$fitment]);
                }
            }
        }

        return $collection;
    }

    public function joinFitmentTables($collection, $limit = array())
    {
        foreach($this->table_names as $alias => $fitment){
            if(!$limit || in_array($fitment, $limit)){
                $collection->getSelect()->joinLeft(
                    array($alias => 'fitment_entity_'.$fitment),
                    $alias.'.id=main_table.'.$fitment.'_id',
                    array($fitment => 'value')
                );
            }
        }
    }


    public function filterParams($params)
    {
        $keys = array_keys($params);
        foreach($keys as $key){
            if(!in_array($key, $this->table_names) && $key != 'q'){
                unset($params[$key]);
            }
        }
        return $params;
    }


    public function getVehicleFromParams($params)
    {
        unset($params['q']);
        $collection = $this->getFitmentsCollection(null, $params);
        $collection->getSelect()->reset(Zend_Db_Select::COLUMNS);

        foreach($params as $key => $val){
            // get $alias for $type to set columns
            $alias = array_search($key, $this->table_names);
            $collection->getSelect()->columns($alias.'.value as '.$key);
        }

        // unset all parts that aren't $type or in $options
        $fromPart = $collection->getSelect()->getPart(Zend_Db_Select::FROM);
        $protected = array_keys($params);
        foreach($this->table_names as $alias => $table){
            if(!in_array($table, $protected)){
                unset($fromPart[$alias]);
            }
        }
        $collection->getSelect()->setPart(Zend_Db_Select::FROM, $fromPart);

        $item = $collection->getFirstItem();

        $vehicle = array();
        foreach($this->table_names as $part){
            if($item->hasData($part)){
                $vehicle[$part] = $item->getData($part);
            }
        }
        return $vehicle;
    }

}