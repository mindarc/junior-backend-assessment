<?php
//$pt = PopTable::getInstance()->run();
//echo $pt;

Class PopTable{
    //read filename
    private $filename = 'sample-data.csv';

    private static $instance;
    //db connection
    private $link;

    private $original_table = 'original_data';
    private $original_columns = [
        'product_code',
        'product_label',
        'gender',
    ];

    //refuse create obj outside
    private function __construct(){
        $this->link = DB::getInstance()->getLink();
    }
    //refuse clone new obj
    private function __clone(){}


    /**
     * @param bool $init
     * @return bool
     * main function
     */
    public function run($init = true){
        //1.get connection
        $connection = $this->link;
        if(empty($connection))
            return json_encode([
                'message' => 'db connection failed',
                'code' => '4001'
            ]);

        //2.clear or clear database
        if($init === true) {
            $re = DB::getInstance()->clearTable($this->original_table);
            if(!$re) return json_encode([
                'message' => 'initial table failed',
                'code' => '4002'
            ]);
        };

        //3.get data from csv
        $data = $this->getDataFromCsv();
        if($data === false){
            return json_encode([
                'message' => 'fail to read data from file',
                'code' => '4006',
            ]);
        }

        //4.build sql
        $sql = DB::getInstance()->buildInsertSql(
            $this->original_columns, $data, $this->original_table);
        if($sql === false) {
            return json_encode([
                'message' => 'fail to build sql',
                'code' => '4003',
            ]);
        }

        //5.run the sql
        return (mysqli_query($connection,$sql))?
            json_encode([
                'message'=> 'success',
                'code' => '2001'
                ])
            :
            json_encode([
                'message' => 'fail to insert data',
                'code'=> '4004',
            ]);
    }

    /**
     * @return PopTable
     * singleton obj
     */
    public static function getInstance(){
        if(!self::$instance instanceof self){
            self::$instance = new PopTable();
        }
        return self::$instance;
    }

    /**
     * @return array|bool
     * get data from csv
     */
    private function getDataFromCsv()
    {
        //check file
        if(!file_exists($this->filename)){
            return false;
        }
        return $this->readCsvFile($this->filename);

    }

    /**
     * @param $filename
     * @return array|bool
     * read a csv file
     */
    private function readCsvFile($filename){
        $file = fopen($filename,"r");
        if(!$file) return false;
        $array = [];
        while(! feof($file))
        {
            $array[] = fgetcsv($file);
        }
        fclose($file);
        //remove first line
        array_shift($array);
        return $array;
    }
}


/**
 * Class DB for DB operations
 */
Class DB{
    //should save in config file
    private $servername = '127.0.0.1';
    private $database = 'mindarc_assessment';
    private $password = 'root';
    private $username = 'root';

    //db connection
    private $link;

    private static $instance;

    /**
     * @return DB
     * singleton here
     */
    public static function getInstance(){
        if(!self::$instance instanceof self){
            self::$instance = new DB();
        }
        return self::$instance;
    }

    private function __construct(){
        $this->link = mysqli_connect(
            $this->servername, $this->username, $this->password, $this->database);

    }
    //refuse clone
    private function __clone(){}

    //get db connection for outside
    public function getLink(){
        return $this->link;
    }

    /**
     * @param $columns
     * @param $array
     * @return bool|string
     */
    public function buildInsertSql($columns, $array, $table){
        $cols = array_reduce($columns, function($carry, $item){
            //filter
            return $carry.'`'.$item.'`,';
        });
        //remove last comma
        $cols = substr($cols, 0, -1);
        $sql = "INSERT INTO "."`$table`"." ($cols) VALUES ";

        //check data
        if(!isset($array) || empty($array)) return false;

        //build sub sql
        $sub_sql = '';
        foreach($array as $key => $val){
            //skip wrong data
            if(!is_array($val)) continue;

            $vals = array_reduce($val, function($carry, $item){
                //filter
                $item = filter_var($item, FILTER_SANITIZE_STRING);
                return $carry."'".$item."',";
            });
            $vals = substr($vals, 0, -1);
            $sub_sql .= "($vals)".',';
        }
        $sql = $sql.substr_replace($sub_sql ,";", -1);
        return $sql;
    }

    /**
     * @param $table
     * @return bool
     * clear table
     */
    public function clearTable($table){
        $connection = $this->link;
        $sql = "TRUNCATE TABLE `$table`";
        return (mysqli_query($connection,$sql))?true : false;
    }

    /**
     * @param $data
     * @param $columns
     * @param $table
     * @return bool
     */
    public function updateImagePathToDatabase($data, $columns, $table){
        //filter
        $filename = filter_var($data['filename'], FILTER_SANITIZE_STRING);
        $id = filter_var($data['id'], FILTER_SANITIZE_STRING);

        $check = $this->isExistByID($id,$table);
        if(!$check) return "miss";

        $sql = "UPDATE `$table` SET $columns[0] = '".$filename."' WHERE product_id = ".$id;
        $connection = $this->link;
        return (mysqli_query($connection,$sql))? "success":"fail";

    }

    /**
     * @param $id
     * @param $table
     * @return bool
     * check if exist item by id
     */
    public function isExistByID($id, $table){
        $id = filter_var($id, FILTER_SANITIZE_STRING);
        $connection = $this->link;
        $sql = "SELECT * FROM $table WHERE product_id = ".$id;
        $result = mysqli_query($connection,$sql);
        if(mysqli_num_rows($result)>0) return true;
        return false;

    }
}