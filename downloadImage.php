<?php 
class download{

function download_image_with_name($image_url, $save_path, $new_name) {
    $extension = pathinfo(parse_url($image_url, PHP_URL_PATH), PATHINFO_EXTENSION);
    $new_name = $new_name . '.' . $extension;
    $save_path = $save_path . '/' . $new_name;
    $ch = curl_init($image_url);
    $fp = fopen($save_path, 'wb');
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_exec($ch);
    curl_close($ch);
    fclose($fp);
}
}

require_once("includes/DBController.php");
$db_handle = new DBController();
$con = $db_handle->connectDB();
$download = new download();
$instrumentos = $con->query("SELECT * FROM inversion_instrumentos");
while($instrumento = $instrumentos->fetch(PDO::FETCH_ASSOC)){
    $download->download_image_with_name($instrumento["instrumento_imagen"], "images/instrumentos", $instrumento["instrumento_sigla"]);
}

 
  
