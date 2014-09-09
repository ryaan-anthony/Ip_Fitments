<?php


/**
 * Product search result block
 *
 * @category   Mage
 * @package    Mage_CatalogSearch
 * @module     Catalog
 */
class Ip_Fitments_Block_Search_Result extends Mage_CatalogSearch_Block_Result
{

    /**
     * Internal constructor, that is called from real constructor
     *
     */
    protected function _construct()
    {
        $category = Mage::registry('current_category');
        if($category && $category->getId()){
            $this->setCurrentCategory($category);
        }
        parent::_construct();
    }

    /**
     * Retrieve selected vehicle query
     *
     * @return Ip_Fitments_Model_Search_Query
     */
    protected function _getQuery()
    {
        return Mage::getSingleton('fitmentsearch/query');
    }

    /**
     * Retrieve search query text
     *
     * @return string
     */
    public function getQueryText()
    {
        $params = $this->_getQuery()->getQueryText();
        $query = isset($params['q']) ? ' (keyword: '.$params['q'].')' : null;
        return implode(' ', $params).$query;
    }

    /**
     * Retrieve HTML escaped search query
     *
     * @return string
     */
    public function getEscapedQueryText()
    {
        return $this->escapeHtml($this->getQueryText());
    }

    /**
     * Prepare layout
     *
     * @return $this|Mage_CatalogSearch_Block_Result
     */
    protected function _prepareLayout()
    {
        // add Home breadcrumb
        $breadcrumbs = $this->getLayout()->getBlock('breadcrumbs');
        if ($breadcrumbs) {
            $title = $this->__("Search results for: '%s'", $this->getQueryText());

            $breadcrumbs->addCrumb('home', array(
                'label' => $this->__('Home'),
                'title' => $this->__('Go to Home Page'),
                'link'  => Mage::getBaseUrl()
            ))->addCrumb('search', array(
                    'label' => $title,
                    'title' => $title
                ));
        }

        // modify page title
        $title = $this->__("Search results for: '%s'", $this->getEscapedQueryText());
        $this->getLayout()->getBlock('head')->setTitle($title);

        return $this;
    }

    /**
     * Retrieve No Result or Minimum query length Text
     *
     * @return string
     */
    public function getNoResultText()
    {
        return Mage::helper('catalogsearch')->__('No results were found for %s', $this->getQueryText());
    }

}
