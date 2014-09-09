<?php
/* @var $this Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */
$this->startSetup();
$tables = array(
    'make' => 50,
    'model' => 50,
    'year' => 4,
    'submodel' => 50,
    'engine' => 50,
    'drivetrain' => 50,
    'transmission' => 50,
    'note' => 500,
);
foreach($tables as $table => $size){
    $this->run("
        DROP TABLE IF EXISTS {$this->getTable('fitments/'.$table)};
        CREATE TABLE {$this->getTable('fitments/'.$table)} (
            `id` int(10) NOT NULL auto_increment,
            `value` varchar({$size}) NOT NULL UNIQUE,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB;
    ");
}
$this->run("
        DROP TABLE IF EXISTS {$this->getTable('fitments/fitment')};
        CREATE TABLE {$this->getTable('fitments/fitment')} (
            `id` int(10) NOT NULL auto_increment,
            `make_id` int(10) NOT NULL,
            `model_id` int(10) NOT NULL,
            `year_id` int(10) NOT NULL,
            `submodel_id` int(10),
            `engine_id` int(10),
            `drivetrain_id` int(10),
            `transmission_id` int(10),
            `note_id` int(10),
            `product_id` int(10) UNSIGNED NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (make_id) REFERENCES {$this->getTable('fitments/make')}(id) ON DELETE CASCADE,
            FOREIGN KEY (model_id) REFERENCES {$this->getTable('fitments/model')}(id) ON DELETE CASCADE,
            FOREIGN KEY (year_id) REFERENCES {$this->getTable('fitments/year')}(id) ON DELETE CASCADE,
            FOREIGN KEY (submodel_id) REFERENCES {$this->getTable('fitments/submodel')}(id) ON DELETE CASCADE,
            FOREIGN KEY (engine_id) REFERENCES {$this->getTable('fitments/engine')}(id) ON DELETE CASCADE,
            FOREIGN KEY (drivetrain_id) REFERENCES {$this->getTable('fitments/drivetrain')}(id) ON DELETE CASCADE,
            FOREIGN KEY (transmission_id) REFERENCES {$this->getTable('fitments/transmission')}(id) ON DELETE CASCADE,
            FOREIGN KEY (note_id) REFERENCES {$this->getTable('fitments/note')}(id) ON DELETE CASCADE,
            FOREIGN KEY (product_id) REFERENCES {$this->getTable('catalog/product')}(entity_id) ON DELETE CASCADE
        ) ENGINE=InnoDB;
    ");
$this->endSetup();