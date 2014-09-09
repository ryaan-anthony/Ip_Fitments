<?php

class Ip_Fitments_Model_ImportExport_Import_Fitments
{

    protected $added = 0;
    protected $failed = 0;

    public function addNew($row)
    {
        // fix note column as imported from alternate sources
        $row['note'] = isset($row['notes']) ? $row['notes'] : $row['note'];
        // check if product exists
        if($idBySku = Mage::getModel('catalog/product')->getIdBySku($row['sku'])){
            /** @var Ip_Fitments_Model_Fitment $model */
            $fitment = Mage::getModel('fitments/fitment');
            $data = array(
                'product_id' => $idBySku,
                'make_id' => Mage::getModel('fitments/make')->createIfDoesntExist($row['make'], 'value')->getId(),
                'model_id' => Mage::getModel('fitments/model')->createIfDoesntExist($row['model'], 'value')->getId(),
                'year_id' => Mage::getModel('fitments/year')->createIfDoesntExist($row['year'], 'value')->getId(),
                'submodel_id' => Mage::getModel('fitments/submodel')->createIfDoesntExist($row['submodel'], 'value')->getId(),
                'engine_id' => Mage::getModel('fitments/engine')->createIfDoesntExist($row['engine'], 'value')->getId(),
                'drivetrain_id' => Mage::getModel('fitments/drivetrain')->createIfDoesntExist($row['drivetrain'], 'value')->getId(),
                'transmission_id' => Mage::getModel('fitments/transmission')->createIfDoesntExist($row['transmission'], 'value')->getId(),
                'note_id' => Mage::getModel('fitments/note')->createIfDoesntExist($row['note'], 'value')->getId(),
            );
            $fitment->setData($data);
            $fitment->save();
            $this->added++;
        } else {
            $this->failed++;
        }
    }

    public function deleteAll()
    {

    }

    public function getSuccessMessage()
    {
        return Mage::helper('adminhtml')->__('
            Fitment import successful!<br>
             &nbsp; %s fitments added.<br>
             &nbsp; %s fitments failed.',
            $this->added,
            $this->failed
        );
    }

}