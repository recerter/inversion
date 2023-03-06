<?php
set_time_limit(1000);
require_once("inc/php/DBController.php");
require_once 'inc/ext/inversionPrecio.php';
$db_handle = new DBController();
$con = $db_handle->connectDB();
$moneda = new precio(); 
$instrumentos = $con->query("SELECT * FROM inversion_instrumentos WHERE instrumento_tipo = 'criptomoneda'");
    while($instrumento = $instrumentos->fetch(PDO::FETCH_ASSOC)){ 
            $instrumento_sigla_api = $instrumento["instrumento_sigla_api"];
    $monedaCrypto = $moneda->precioCrypto($instrumento["instrumento_sigla_api"]);
        if (!empty($monedaCrypto)) {
            if(isset($monedaCrypto["current_price"])){
                $moneda_precio = $monedaCrypto["current_price"];
                $moneda_variacion = $monedaCrypto["price_change_percentage_24h"];
                if ($moneda_precio != 0) {
                    $moneda->updateInstrumentoPrecio($instrumento_sigla_api, $moneda_precio, $moneda_variacion);
                    sleep(5);
                }
            }
            }
    }
?>