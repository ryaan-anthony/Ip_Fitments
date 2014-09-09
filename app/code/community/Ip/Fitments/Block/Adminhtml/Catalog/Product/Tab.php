<?php

class Ip_Fitments_Block_Adminhtml_Catalog_Product_Tab
    extends Mage_Adminhtml_Block_Template
    implements Mage_Adminhtml_Block_Widget_Tab_Interface {

    protected $_source;
    /**
     * Set the template for the block
     *
     */
    public function _construct()
    {
        parent::_construct();

        $this->setTemplate('fitments/catalog/product/tab.phtml');
        /**
         * @var Ip_Fitments_Model_Core_Resource $fitments
         */
        $product_id = $this->_getProduct()->getId();
        $fitments = Mage::getModel('fitments/core_resource');
        $this->setFitments($fitments->getFitmentsArray($product_id));
    }

    public function isUniversal()
    {
        return $this->_getProduct()->getIsUniversal();
    }

    /**
     * Retrieve currently edited product model
     *
     * @return Mage_Catalog_Model_Product
     */
    protected function _getProduct()
    {
        return Mage::registry('current_product');
    }

    public function getSource($type)
    {
        if(!isset($this->_source[$type])){
            $this->_source[$type] = Mage::getModel('fitments/'.$type);
        }
        return $this->_source[$type];
    }

    public function getFitmentTemplate($data = null)
    {
        $template = $this->getLayout()->createBlock('fitments/adminhtml_catalog_product_tab_template');
        $template->setData($data);
        $template->setTemplate('fitments/catalog/product/tab/template.phtml');
        return $template->toHtml();
    }

    /**
     * Retrieve the label used for the tab relating to this block
     *
     * @return string
     */
    public function getTabLabel()
    {
        return $this->__('Vehicle Fits');
    }

    /**
     * Retrieve the title used by this tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->getTabLabel();
    }

    /**
     * Determines whether to display the tab
     * Add logic here to decide whether you want the tab to display
     *
     * @return bool
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Stops the tab being hidden
     *
     * @return bool
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * AJAX TAB's
     * If you want to use an AJAX tab, uncomment the following functions
     * Please note that you will need to setup a controller to recieve
     * the tab content request
     *
     */
    /**
     * Retrieve the class name of the tab
     * Return 'ajax' here if you want the tab to be loaded via Ajax
     *
     * return string
     */
#   public function getTabClass()
#   {
#       return 'my-custom-tab';
#   }

    /**
     * Determine whether to generate content on load or via AJAX
     * If true, the tab's content won't be loaded until the tab is clicked
     * You will need to setup a controller to handle the tab request
     *
     * @return bool
     */
#   public function getSkipGenerateContent()
#   {
#       return false;
#   }

    /**
     * Retrieve the URL used to load the tab content
     * Return the URL here used to load the content by Ajax
     * see self::getSkipGenerateContent & self::getTabClass
     *
     * @return string
     */
#   public function getTabUrl()
#   {
#       return null;
#   }
}