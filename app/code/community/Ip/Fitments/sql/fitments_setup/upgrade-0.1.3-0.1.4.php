<?php
/* @var $this Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */
$this->startSetup();

$tables = array(
    'make',
    'model',
    'year',
    'submodel',
    'engine',
    'drivetrain',
    'transmission',
);
foreach($tables as $table){
    $this->run("
       alter table {$this->getTable('fitments/'.$table)}
       add column `position` int(10) UNSIGNED  DEFAULT 0 NOT NULL;
    ");
}

$this->endSetup();