<?php
require_once('./db.php');

class Migrate {
    private $original_table;
    private $migrate_table;
    private $db;

    public function __construct($original_table, $migrate_table, Database $db)
    {
        $this->db = $db;
        $this->migrate_table = $migrate_table;
        $this->original_table = $original_table;
    }

    public function migrateDb()
    {
        $mysqli = $this->db->connect();

        $result = $mysqli->query("INSERT INTO ".$this->migrate_table." ( sku, name )
                SELECT concat_ws ( '_', IF(gender LIKE '%m%', 'men', 'women') ,product_code ), product_label FROM ".$this->original_table);

        if($result)
        {
            echo 'Migration Successful';
        }
        else
        {
            die('Error in migration');
        }
        
    }
}

$migration  = new Migrate('original_data', 'migrated_data', Database::getInstance());
$migration->migrateDb();