<?php
/* @var $this Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */
$this->startSetup();
$this->run("
        DROP TABLE IF EXISTS {$this->getTable('fitmentsearch/query')};
        CREATE TABLE {$this->getTable('fitmentsearch/query')} (
            `query_id` int(10) UNSIGNED NOT NULL auto_increment,
            `make_id` int(10) NOT NULL,
            `model_id` int(10) NOT NULL,
            `year_id` int(10) NOT NULL,
            `submodel_id` int(10),
            `engine_id` int(10),
            `drivetrain_id` int(10),
            `transmission_id` int(10),

            `num_results` int(10) UNSIGNED NOT NULL DEFAULT 0,
            `popularity` int(10) UNSIGNED NOT NULL DEFAULT 0,
            `redirect` varchar(255),
            `synonym_for` varchar(255),
            `store_id` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
            `display_in_terms` smallint(6) NOT NULL DEFAULT 1,
            `is_active` smallint(6) DEFAULT 1,
            `is_processed` smallint(6) DEFAULT 0,
            `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

            PRIMARY KEY (`query_id`),
            FOREIGN KEY (make_id) REFERENCES {$this->getTable('fitments/make')}(id) ON DELETE CASCADE,
            FOREIGN KEY (model_id) REFERENCES {$this->getTable('fitments/model')}(id) ON DELETE CASCADE,
            FOREIGN KEY (year_id) REFERENCES {$this->getTable('fitments/year')}(id) ON DELETE CASCADE,
            FOREIGN KEY (submodel_id) REFERENCES {$this->getTable('fitments/submodel')}(id) ON DELETE CASCADE,
            FOREIGN KEY (engine_id) REFERENCES {$this->getTable('fitments/engine')}(id) ON DELETE CASCADE,
            FOREIGN KEY (drivetrain_id) REFERENCES {$this->getTable('fitments/drivetrain')}(id) ON DELETE CASCADE,
            FOREIGN KEY (transmission_id) REFERENCES {$this->getTable('fitments/transmission')}(id) ON DELETE CASCADE,
            FOREIGN KEY (store_id) REFERENCES {$this->getTable('core/store')}(store_id) ON DELETE CASCADE
        ) ENGINE=InnoDB;
    ");
$this->endSetup();