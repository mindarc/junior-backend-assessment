<?php
include __DIR__.'/pop-table.php';

Class Migrate{

    private $link;

    //save instance
    private static $instance;

    private $original_table = 'original_data';
    private $migrated_table = 'migrated_data';
    private $original_columns = [
        'product_code',
        'product_label',
        'gender',
    ];

    private $transfer_columns = [
        'sku',
        'name',
    ];

    private function __clone(){}

    private function __construct()
    {
        $this->link = DB::getInstance()->getLink();
    }

    /**
     * @return mixed
     */
    public static function getInstance(){
        if(!self::$instance instanceof self){
            self::$instance = new Migrate();
        }
        return self::$instance;
    }

    /**
     * @param bool $init
     * @return string
     * main function here
     */
    public function run($init=true){
        //1.get connection
        $connection = $this->link;
        if(empty($connection))
            return json_encode([
                'message' => 'db connection failed',
                'code' => '4001'
            ]);


        //2.read data from db
        $data = $this->readDataFromDb(
            $this->original_columns,$this->original_table,$connection);
        if(empty($data)) {
            return json_encode([
                'message' => 'fail to read data from original table',
                'code'=>'4006',
            ]);
        }

        //3.clear migrate db
        if($init === true){
            $re = DB::getInstance()->clearTable($this->migrated_table);
            if(!$re) return json_encode([
                'message' => 'initial table failed',
                'code' => '4002'
            ]);
        }
        //4.build sql
        $sql = DB::getInstance()->buildInsertSql($this->transfer_columns, $data, $this->migrated_table);
        if($sql === false) {
            return json_encode([
                'message' => 'fail to build sql',
                'code' => '4003',
            ]);
        }
        //5.save data in db, run the sql
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
     * @return array
     * read data from original table
     */
    private function readDataFromDb($columns, $table, $link){
        //build sql
        $cols = implode(",",$columns);
        $sql = "SELECT $cols FROM $table";
        //build return data
        $return_array = [];
        $result = mysqli_query($link,$sql);

        if(mysqli_num_rows($result) > 0){
            $i = 0;//index
            while($row = mysqli_fetch_assoc($result)){
                $gender = $row['gender'];
                $filter_gender = $this->filterGender($gender);
                $return_array[$i]['sku'] =$filter_gender.'_'.$row['product_code'];
                $return_array[$i]['name'] = $row['product_label'];
                $i++;
            }
        }

        return $return_array;
    }

    /**
     * @param $gender
     * @return string
     * process gender
     */
    private function filterGender($gender){
        if(empty($gender)) return 'women';
        switch (strtoupper($gender)){
            case 'F': return "women";
            case 'M': return "men";
            default: return "women";
        }
    }
}

Migrate::getInstance()->run();