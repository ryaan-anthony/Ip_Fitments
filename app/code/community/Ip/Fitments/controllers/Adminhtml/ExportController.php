<?php

class Ip_Fitments_Adminhtml_ExportController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function executeAction()
    {
        $data = $this->getRequest()->getPost();
        if($data){
            /** @var $export Ip_Fitments_Model_ImportExport_Export */
            $export = Mage::getModel('fitments/importExport_export')->setData($data);
            $file = $export->exportFitments();
            $this->_prepareDownloadResponse($file, file_get_contents(Mage::getBaseDir('export').'/'.$file));
        } else {
            $this->_getSession()->addError($this->__('Invalid Request'));
            $this->_redirect('*/*/index');
        }
    }


}