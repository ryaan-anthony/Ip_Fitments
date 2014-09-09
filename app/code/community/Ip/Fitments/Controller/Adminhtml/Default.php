<?php

class Ip_Fitments_Controller_Adminhtml_Default extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $fitment = $this->getRequest()->getControllerName();
        $model = Mage::getModel('fitments/'.$fitment);
        if($id = $this->getRequest()->getParam('id', null)){
            $model->load((int) $id);
        }
        Mage::register('fitment_data', $model);
        $this->loadLayout();
        $this->renderLayout();
    }

    public function saveAction()
    {
        $fitment = $this->getRequest()->getControllerName();
        $_session = Mage::getSingleton('adminhtml/session');
        if ($data = $this->getRequest()->getPost()){
            $model = Mage::getModel('fitments/'.$fitment);
            /* check if it already exists */
            $check = $model->load($data['value'], 'value');
            if($check->getId()){
                $_session->addNotice($this->__('This '.$fitment.' already exists!'));
                $this->_redirectReferer();
                return;
            }
            /* set all post data */
            $model->setValue($data['value']);
            /* set the id instead of loading for simplicity */
            if($entity_id = $this->getRequest()->getParam('id', null)){
                $model->setId($entity_id);
            }
            $_session->setFormData($data);
            try {
                $model->save();
                $_session->setFormData(false);
                $_session->addSuccess($this->__('Fitment was successfully saved.'));
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                } else {
                    $this->_redirect('*/*/new');
                }
                return;
            }
            catch (Mage_Core_Exception $e) {
                $_session->addError($e->getMessage());
            }
            catch (Exception $e) {
                var_dump($e->getMessage());
                $_session->addError($this->__('An error occurred while saving this fitment.'));
            }
        } else {
            $_session->addError($this->__('No fitment found.'));
        }
        $this->_redirectReferer();
    }

    public function deleteAction()
    {
        if($id = $this->getRequest()->getParam('id')) {
            try {
                $fitment = $this->getRequest()->getControllerName();
                $model = Mage::getSingleton('fitments/'.$fitment);
                $model->setId($id)->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Fitment post was successfully deleted'));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $id));
            }
        }
        $this->_redirect('*');
    }



}