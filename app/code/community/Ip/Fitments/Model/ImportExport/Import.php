<?php

// @TODO add support for BEHAVIOR_DELETE

class Ip_Fitments_Model_ImportExport_Import extends Varien_Object
{

    /**
     * Import behavior.
     */
    const BEHAVIOR_APPEND  = 'append';
    const BEHAVIOR_REPLACE = 'replace';

    /**
     * Form field names (and IDs)
     */
    const FIELD_NAME_SOURCE_FILE = 'import_file';

    /**
     * Import/Export working directory (source files, result files, lock files etc.).
     *
     * @return string
     */
    public static function getWorkingDir()
    {
        return Mage::getBaseDir('var') . DS . 'fitments' . DS;
    }

    /**
     * Returns source adapter object.
     *
     * @param string $sourceFile Full path to source file
     * @return Mage_ImportExport_Model_Import_Adapter_Abstract
     */
    protected function _getSourceAdapter($sourceFile)
    {
        return Mage_ImportExport_Model_Import_Adapter::findAdapterFor($sourceFile);
    }

    /**
     * Move uploaded file and create source adapter instance.
     *
     * @throws Mage_Core_Exception
     * @return string Source file path
     */
    public function uploadSource()
    {
        $entity    = $this->getEntity();
        $uploader  = Mage::getModel('core/file_uploader', self::FIELD_NAME_SOURCE_FILE);
        $uploader->skipDbProcessing(true);
        $result    = $uploader->save(self::getWorkingDir());
        $extension = pathinfo($result['file'], PATHINFO_EXTENSION);

        $uploadedFile = $result['path'] . $result['file'];
        if (!$extension) {
            unlink($uploadedFile);
            Mage::throwException(Mage::helper('importexport')->__('Uploaded file has no extension'));
        }
        $sourceFile = self::getWorkingDir() . $entity;

        $sourceFile .= '.' . $extension;

        if(strtolower($uploadedFile) != strtolower($sourceFile)) {
            if (file_exists($sourceFile)) {
                unlink($sourceFile);
            }

            if (!@rename($uploadedFile, $sourceFile)) {
                Mage::throwException(Mage::helper('importexport')->__('Source file moving failed'));
            }
        }
        try {
            $this->importSource($sourceFile);
        } catch (Exception $e) {
            unlink($sourceFile);
            Mage::throwException($e->getMessage());
        }
        return $sourceFile;
    }

    /**
     * Import source file structure to DB.
     *
     * @return bool
     */
    public function importSource($sourceFile)
    {
        $contents = $this->readSource($sourceFile);
        $importer = Mage::getModel('fitments/importExport_import_'.$this->getEntity());
        if($this->getBehavior() == self::BEHAVIOR_REPLACE){
            $importer->deleteAll(array_keys($contents[0]));
        }
        foreach($contents as $row){
            $importer->addNew($row);
        }
        $this->setSuccessMessage($importer->getSuccessMessage());
    }

    /**
     * Read source file structure to associative array.
     *
     * @return bool
     */
    public function readSource($sourceFile)
    {
        $count = 0;
        $columns = array();
        $master = array();
        $file = fopen($sourceFile, "r");
        while ($data = fgetcsv($file)) {
            if(!$count++){
                $columns = $data;
                continue;
            }
            $results = array();
            foreach($data as $key => $item){
                $col = $columns[$key];
                $results[$col] = $item;
            }
            $master[] = $results;
        }
        fclose($file);
        return $master;
    }

}

