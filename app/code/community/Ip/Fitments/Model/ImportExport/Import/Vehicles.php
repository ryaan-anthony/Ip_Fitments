<?php

class Ip_Fitments_Model_ImportExport_Import_Vehicles
{

    protected $already_added;

    public function addNew($row)
    {
        foreach($row as $col => $data){
            if(!isset($this->already_added[$col][$data])){
                /** @var Ip_Fitments_Core_Entity $model */
                $model = Mage::getModel('fitments/'.$col)->load($data, 'value');
                if(!$model->hasData('id')){
                    $model->setValue($data);
                    $model->save();
                    $this->already_added[$col][$data] = true;
                } else {
                    $this->already_added[$col][$data] = false;
                }

            }
        }
    }

    public function deleteAll($cols)
    {
        foreach($cols as $col){
            /** @var Ip_Fitments_Core_Collection $collection */
            $collection = Mage::getModel('fitments/'.$col)->getCollection();
            $collection->delete();
        }
    }

    public function getSuccessMessage()
    {
        $success = array();
        foreach($this->already_added as $col => $val){
            $val = array_filter($val);
            $success[] = Mage::helper('adminhtml')->__(' &nbsp; %s %ss were created.', count($val), $col);
        }
        return Mage::helper('adminhtml')->__('Vehicle import successful!<br>%s',implode('<br>',$success));
    }

}