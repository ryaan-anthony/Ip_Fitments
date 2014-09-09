<?php

class Ip_Fitments_Model_Search_Resource_Query extends Mage_Core_Model_Resource_Db_Abstract
{

    protected function _construct()
    {
        $this->_init('fitmentsearch/query', 'query_id');
    }


    public function loadByQuery(Mage_Core_Model_Abstract $object, $values)
    {
        $select = $this->_getReadAdapter()->select()
            ->from($this->getMainTable())
            ->where('store_id=?', $object->getStoreId());
        foreach($values as $key => $value){
            if($value){
                $select->where($key.'=?', $value);
            } else {
                $select->where($key.' IS NULL');
            }
        }
        $select->limit(1);
        if ($data = $this->_getReadAdapter()->fetchRow($select)) {
            $object->setData($data);
            $this->_afterLoad($object);
        }
        return $this;
    }

}