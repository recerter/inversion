<?php
set_time_limit(1000);
require_once("inc/php/DBController.php");
require_once 'inc/ext/inversionPrecio.php';
$db_handle = new DBController();
$con = $db_handle->connectDB();
$moneda = new precio(); 
$instrumentos = $con->query("SELECT * FROM inversion_instrumentos WHERE instrumento_tipo = 'indice' OR instrumento_tipo = 'commodities'");
while($instrumento = $instrumentos->fetch(PDO::FETCH_ASSOC)){
    $instrumento_sigla_api = $instrumento["instrumento_sigla_api"];
    $ticker = $moneda->apiYahooFinance($instrumento_sigla_api);
    if($ticker != null){
        $moneda->updateInstrumentoPrecio($instrumento_sigla_api, $ticker["currentPrice"], $ticker["percentChange"]);
    }
}
?>