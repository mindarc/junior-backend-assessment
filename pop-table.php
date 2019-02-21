<?php
// require the db connection class
require_once('./db.php');

class PopTable
{
    protected $file;
    protected $db;

    public function __construct( $file, Database $db )
    {
        $this->file = $file;
        $this->db = $db;
    }

    public function saveCSVtoDB()
    {
        $fp = fopen($this->file, 'r');
        
        $mysqli = $this->db->connect();

        $result = $mysqli->query("LOAD DATA LOCAL INFILE 'sample-data.csv'
            INTO TABLE original_data
            FIELDS TERMINATED BY ','
            LINES TERMINATED BY '\n'
            IGNORE 1 LINES
            (product_code, product_label, gender)
            SET product_id=null");
        
        if($result) {
            echo 'Data uploaded successfully';
        } else {
            die('Error occured during data upload');
        }
    }
    
}

$parser = new PopTable('sample-data.csv', Database::getInstance() );
$parser->saveCSVtoDB();
