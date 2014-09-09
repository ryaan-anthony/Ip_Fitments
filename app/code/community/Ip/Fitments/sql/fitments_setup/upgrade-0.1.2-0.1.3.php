<?php
/* @var $this Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */
$this->startSetup();
$this->run("
        DROP TABLE IF EXISTS {$this->getTable('fitmentsearch/result')};
        CREATE TABLE {$this->getTable('fitmentsearch/result')} (
            `result_id` int(10) UNSIGNED NOT NULL auto_increment,
            `query_id` int(10) UNSIGNED NOT NULL,
            `product_id` int(10) UNSIGNED NOT NULL,
            `relevance` decimal(20,4) NOT NULL,
            PRIMARY KEY (`result_id`),
            FOREIGN KEY (query_id) REFERENCES {$this->getTable('fitmentsearch/query')}(query_id) ON DELETE CASCADE,
            FOREIGN KEY (product_id) REFERENCES {$this->getTable('catalog/product')}(entity_id) ON DELETE CASCADE
        ) ENGINE=InnoDB;
    ");
$this->endSetup();