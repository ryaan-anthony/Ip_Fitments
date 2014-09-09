<?php

$tables = array(
    'make',
    'model',
    'year',
    'submodel',
    'engine',
    'drivetrain',
    'transmission',
);


foreach($tables as $fitment){
    /**
     * @var Ip_Fitments_Core_Collection $collection
     */
    $collection = Mage::getModel('fitments/'.$fitment)->getCollection();
    $collection->getSelect()->where('value like ?', 'Fits Any%');
    foreach($collection as $item){
        $fitments = Mage::getModel('fitments/fitment')->getCollection();
        $fitments->getSelect()->where($fitment.'_id = ?', $item->getId());
        foreach($fitments as $fit){
            $fit->setData($fitment.'_id', null);
            $fit->save();
        }
        $item->delete();
    }
}