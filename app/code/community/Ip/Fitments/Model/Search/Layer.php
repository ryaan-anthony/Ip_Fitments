<?php

/**
 * Fitments vehicle search layer model
 */
class Ip_Fitments_Model_Search_Layer extends Mage_Catalog_Model_Layer
{

    /**
     * Retrieve current layer product collection
     *
     * @return Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Collection
     */
    public function getProductCollection()
    {
        if (isset($this->_productCollections[$this->getCurrentCategory()->getId()])) {

            $collection = $this->_productCollections[$this->getCurrentCategory()->getId()];

        } else {

            /**
             * @var Ip_Fitments_Model_Resource_Product_Collection $collection
             */
            $collection = Mage::getResourceModel('fitments/product_collection');

            /**
             * @var Ip_Fitments_Model_Search_Query $query
             */
            $query = Mage::getSingleton('fitmentsearch/query');
            $params = $query->getQueryParams();

            // load from cache
            if($query->getIsProcessed()){
                $query->loadResultCollection($collection);
            } else {
                // add universal fits
                $collection->addAttributeToFilter('is_universal', array('eq' => 1), 'left');
                $collection->setOrder('is_universal', Varien_Data_Collection_Db::SORT_ORDER_ASC);

                // join fitment tables
                $collection->prepareFitments($params);

                // prevent duplicates
                $collection->getSelect()->group('e.entity_id');

                // cache result collection
                $query->setResultCollection($collection);
                $collection->clear();

            }

            $query->unsetData('updated_at');
            $query->setPopularity($query->getPopularity() + 1);
            $query->save();

            $this->prepareProductCollection($collection);


            // join catalogsearch query/result
            if(isset($params['q'])){
                $catalogsearch_query = Mage::getModel('catalogsearch/query')->setQueryText($params['q'])->prepare();
                Mage::getResourceModel('catalogsearch/fulltext')->prepareResult(
                    Mage::getModel('catalogsearch/fulltext'),
                    $params['q'],
                    $catalogsearch_query
                );
                $collection->getSelect()->joinInner(
                    array('search_result' => $collection->getTable('catalogsearch/result')),
                    $collection->getConnection()->quoteInto(
                        'search_result.product_id=e.entity_id AND search_result.query_id=?',
                        $catalogsearch_query->getId()
                    ),
                    array('relevance' => 'relevance')
                );
                $collection->getSelect()->group('e.entity_id');
                $query->setResultCollection($collection);
                $collection->clear();
            }

            $this->_productCollections[$this->getCurrentCategory()->getId()] = $collection;

        }

        return $collection;
    }

    /**
     * Initialize product collection
     *
     * @param Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Collection $collection
     * @return Mage_Catalog_Model_Layer
     */
    public function prepareProductCollection($collection)
    {
        $collection
            ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
            ->addMinimalPrice()
            ->addFinalPrice()
            ->addTaxPercents()
            ->addUrlRewrite($this->getCurrentCategory()->getId());

        return $this;
    }

}
