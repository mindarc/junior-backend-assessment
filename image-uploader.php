<?php
//run if $_FILES exist
if(!empty($_FILES)){
    include __DIR__.'/pop-table.php';
    $up = new UploadFile();
    $result = $up -> handleUploadFile($_FILES, $_POST);
    echo $result;

}

/**
 * Class UploadFile for handle upload
 *
 */
Class UploadFile{

    private $columns = ['image_url'];
    private $table = 'migrated_data';

    public function handleUploadFile($files, $post){
        $file = $files["upload-file"];
        $imgType = array("png","jpg","jpeg");

        if ($file["error"] == 0) {
            $typeArr = explode("/", $file["type"]);
            if($typeArr[0] != "image"){
                return json_encode([
                    'error' => 'wrong image type',
                ]);
            }
            if(!in_array($typeArr[1], $imgType)){
                return json_encode([
                    'error' => 'wrong image suffix',
                ]);
            }
            if(strlen($file['name'])>200){
                return json_encode([
                    'error' => 'image name too long',
                ]);
            }
            if(!isset($post['id']) || empty($post['id'])){
                return json_encode([
                    'error' => 'product id can not find',
                ]);
            }
            //filter and save files
            $file_name = filter_var($file['name'], FILTER_SANITIZE_STRING);
            $file_name = time().'_'.$file_name;
            $img_name = "media/".$file_name;

            $data = [
                'filename' => $file_name,
                'id' => $post['id'],
            ];
            $re = DB::getInstance()->updateImagePathToDatabase($data, $this->columns, $this->table);
            if($re === 'miss') return json_encode(['message' => 'product does not exist',]);
            if($re === 'fail') return json_encode(['message' => 'update image url fail',]);
            //save to
            $bol = move_uploaded_file($file["tmp_name"], $img_name);
            if($bol){
                return json_encode([
                    'message' => 'success',
                ]);
            } else {
                return json_encode([
                    'error' => 'fail to upload',
                ]);
            };

        }else{
            return json_encode([
                "error" => "no files selected"
            ]);
        }
    }

}


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>

<body>

    <form method="post" action="/image-uploader.php" enctype="multipart/form-data">
        <label>upload a file</label>
        <input type="file" name="upload-file"><br>
        <label>product id</label>
        <input type="text" name="id"><br>
        <input type="submit" value="upload">
    </form>
</body>



</html>
