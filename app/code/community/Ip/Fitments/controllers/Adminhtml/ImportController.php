<?php

class Ip_Fitments_Adminhtml_ImportController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
        $maxUploadSize = Mage::helper('importexport')->getMaxUploadSize();
        $this->_getSession()->addNotice(
            $this->__('Total size of uploadable files must not exceed %s', $maxUploadSize)
        );
        $this->loadLayout();
        $this->renderLayout();
    }

    public function executeAction()
    {
        $data = $this->getRequest()->getPost();
        if($data){
            /** @var $import Ip_Fitments_Model_ImportExport_Import */
            $import = Mage::getModel('fitments/importExport_import');
            $import->setData($data)->uploadSource();
            $this->_getSession()->addSuccess(
                $import->getSuccessMessage()
            );
        } else {
            $this->_getSession()->addError($this->__('Data is invalid or file is not uploaded'));
        }
        $this->_redirect('*/*/index');
    }


}