<?php

class Ip_Fitments_Model_Search_Indexer extends Mage_Index_Model_Indexer_Abstract
{
    protected $_matchedEntities = array(
        'fitmentsearch_entity' => array(
            Mage_Index_Model_Event::TYPE_SAVE
        )
    );

    // var to protect multiple runs
    protected $_registered = false;
    protected $_processed = false;

    /**
     * @param Mage_Index_Model_Event $event
     * @return bool
     */
    public function matchEvent(Mage_Index_Model_Event $event)
    {
        return Mage::getModel('catalog/category_indexer_product')->matchEvent($event);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return Mage::helper('adminhtml')->__('Vehicle Search Index');
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return Mage::helper('adminhtml')->__('Refresh product collection for vehicle searches.');
    }

    /**
     * @param Mage_Index_Model_Event $event
     * @return $this
     */
    protected function _registerEvent(Mage_Index_Model_Event $event)
    {
        // if event was already registered once, then no need to register again.
        if($this->_registered) return $this;

        $entity = $event->getEntity();
        switch ($entity) {
            case Mage_Catalog_Model_Product::ENTITY:
                $this->_registerProductEvent($event);
                break;
        }
        $this->_registered = true;
        return $this;
    }

    /**
     * Register event data during product save process
     *
     * @param Mage_Index_Model_Event $event
     */
    protected function _registerProductEvent(Mage_Index_Model_Event $event)
    {
        $eventType = $event->getType();
        if ($eventType == Mage_Index_Model_Event::TYPE_SAVE || $eventType == Mage_Index_Model_Event::TYPE_MASS_ACTION) {
            $process = $event->getProcess();
            $process->changeStatus(Mage_Index_Model_Process::STATUS_REQUIRE_REINDEX);
        }
    }

    /**
     * @param Mage_Index_Model_Event $event
     */
    protected function _processEvent(Mage_Index_Model_Event $event)
    {
        // process index event
        if(!$this->_processed){
            $this->_processed = true;
        }
    }

    /**
     * Run the indexer
     */
    public function reindexAll()
    {
        $collection = Mage::getModel('fitmentsearch/query')->getCollection();
        $collection->delete();
    }
}