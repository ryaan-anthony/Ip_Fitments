<?php

/* @var Mage_Eav_Model_Entity_Setup $installer */
$installer = new Mage_Eav_Model_Entity_Setup('core_setup');
$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'is_universal', array(
    'type'              => 'int',
    'backend'           => '',
    'frontend'          => '',
    'label'             => 'Universal',
    'input'             => '',
    'class'             => '',
    'source'            => '',
    'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible'           => true,
    'required'          => false,
    'visible_on_front'  => false,
    'visible_in_advanced_search' => false,
    'searchable'        => false,
    'filterable'        => false,
));