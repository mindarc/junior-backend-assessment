<?php
require_once('./db.php');
class ImageUploader
{
    private $src = './media/';
    private $file;
    private $tmp;
    private $uploadFile;
    private $db;
    private $id;

    public function __construct($form, Database $db)
    {
        $this->db = $db;
        $this->id = $_POST['row'];
        $this->file = $_FILES["file"]["name"];
        $this->tmp = $_FILES["file"]["tmp_name"];
        $this->uploadFile = $this->src . time() .'_'. basename($this->file);
    }

    public function updateTable()
    {
        $mysqli = $this->db->connect();
        $result = $mysqli->query("UPDATE migrated_data SET image_url='".$this->uploadFile."' WHERE product_id = ".$this->id);
        return $result;
    }

    public function uploadFile()
    {
        if(move_uploaded_file($this->tmp, $this->uploadFile))
        {
            $result = $this->updateTable();
            if($result)
            {
                echo 'File upload successful';
            }
        }
    }

}

if(isset($_POST['submit']))
{
    $uploader = new ImageUploader($_POST, Database::getInstance());
    $uploader->uploadFile();
}

function getRows()
{
    $db = Database::getInstance();
    $mysqli = $db->connect();
    $rows = $mysqli->query("SELECT product_id, name from migrated_data");
    return $rows;
}
$migratedRows = getRows();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="#" method="post" enctype="multipart/form-data">
        <input type="file" name="file" required="yes"/>
        <select name="row">
            <?php
            foreach($migratedRows as $row)
            {
                echo '<option value='.$row['product_id'].'>'.$row['name'].'</option>';
            }
            ?>
        </select>
        <input type="submit" value="Submit" name="submit"/>
    </form>
</body>
</html>