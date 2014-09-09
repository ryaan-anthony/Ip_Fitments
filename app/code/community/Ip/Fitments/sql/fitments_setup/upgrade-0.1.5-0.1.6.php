<?php
/* @var $this Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */
$this->startSetup();

$this->run("
   alter table {$this->getTable('fitmentsearch/query')}
   add column `query_text` varchar(255);
");

$this->endSetup();