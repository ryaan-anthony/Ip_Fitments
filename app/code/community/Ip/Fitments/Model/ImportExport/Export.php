<?php


class Ip_Fitments_Model_ImportExport_Export extends Mage_Core_Model_Abstract
{

    const ENCLOSURE = '"';
    const DELIMITER = ',';
    const PAGE_LIMIT = 5000;

    protected $fp;

    public function exportFitments()
    {
        $originalStore = Mage::app()->getStore();
        Mage::app()->setCurrentStore('default');
        $fileName = $this->getEntity().'_export_'.str_replace(',','_',$this->getCount()).'_'.date("Ymd_His").'.csv';
        $this->fp = fopen(Mage::getBaseDir('export').'/'.$fileName, 'w');
        if($this->getEntity() == 'fitments'){
            // all fitments
            $header = false;
            $collection = Mage::getModel('fitments/core_resource')->getFitmentsCollection();
            $count = explode(',',$this->getCount());
            $page_size = $count[1] - $count[0];
            $page_num = $count[0] > 0 ? intval($count[0] / self::PAGE_LIMIT) + 1 : 1;
            $collection->setPageSize($page_size)->setCurPage($page_num);
            foreach($collection as $item){
                $data = $this->formatItem($item->getData());
                if(!$header){
                    $header = array_keys($data);
                    $this->writeCsv($header);
                }
                $this->writeCsv($data);
            }
        }
        Mage::app()->setCurrentStore($originalStore->getId());
        fclose($this->fp);
        return $fileName;
    }

    protected function writeCsv($data){
        fputcsv($this->fp, $data, self::DELIMITER, self::ENCLOSURE);
    }

    protected function formatItem($data)
    {
        $results = array();
        foreach($data as $key => $value){
            if($key == 'product_id'){
                $product = Mage::getModel('catalog/product')->load($value);
                $results['product'] = $product->getSku();
            } elseif(stristr($key, 'id') === false) {
                $results[$key] = $value;
            }
        }
        return $results;
    }

}

