<?php
/**
 * Vehicle search query model
 *
 * @method array getQueryParams()
 * @method Ip_Fitments_Model_Search_Query setQueryText()
 */
class Ip_Fitments_Model_Search_Query extends Mage_Core_Model_Abstract
{

    public $columns = array(
        'make' => 'make_id',
        'model' => 'model_id',
        'year' => 'year_id',
        'submodel' => 'submodel_id',
        'engine' => 'engine_id',
        'drivetrain' => 'drivetrain_id',
        'transmission' => 'transmission_id',
        'q' => 'query_text',
    );

    protected function _construct()
    {
        $this->_init('fitmentsearch/query');
    }

    public function setQueryParams($params)
    {
        $values = array();
        foreach($this->columns as $index => $column){
            $values[$column] = isset($params[$index]) ? $params[$index] : null;
            $this->setData($column, $values[$column]);
        }
        $this->getResource()->loadByQuery($this, $values);
        if(!$this->getId()){
            $this->save();
        }
        $this->setData('query_params', $params);
    }

    public function getQueryText()
    {
        if (!$this->getData('query_text')) {
            /**
             * @var Ip_Fitments_Model_Core_Resource $fitments
             */
            $fitments = Mage::getModel('fitments/core_resource');
            $query_text = $fitments->getVehicleFromParams($this->getQueryParams());
            $this->setQueryText($query_text);
        } elseif(is_string($this->getData('query_text'))){
            /**
             * @var Ip_Fitments_Model_Core_Resource $fitments
             */
            $fitments = Mage::getModel('fitments/core_resource');
            $query_text = $fitments->getVehicleFromParams($this->getQueryParams());
            $query_text['query'] = $this->getData('query_text');
            $this->setQueryText($query_text);
        }
        return $this->getData('query_text');
    }

    public function loadResultCollection(Ip_Fitments_Model_Resource_Product_Collection $collection)
    {
        $collection->getSelect()->join(
            array('results' => Mage::getSingleton('core/resource')->getTableName('fitmentsearch/result')),
            'results.product_id = e.entity_id'
        )->where('results.query_id = ?', $this->getId());
    }

    public function setResultCollection($collection)
    {
        foreach($collection as $item){
            $result = Mage::getModel('fitmentsearch/result');
            $result->addData(
                array(
                    'query_id' => $this->getId(),
                    'product_id' => $item->getId(),
                    'relevance' => 0, //@todo apply relevance score
                )
            );
            $result->save();
        }
        $this->setNumResults($collection->count());
        $this->setIsProcessed(true);
        $this->save();
    }


}