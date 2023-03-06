<?php
set_time_limit(1000);
require_once("inc/php/DBController.php");
require_once 'inc/ext/inversionPrecio.php';
$db_handle = new DBController();
$con = $db_handle->connectDB();
$moneda = new precio();
$instrumentos = $con->query("SELECT * FROM inversion_instrumentos WHERE instrumento_tipo = 'fondos'");
    while($instrumento = $instrumentos->fetch(PDO::FETCH_ASSOC)){ 
            $instrumento_sigla_api = $instrumento["instrumento_sigla_api"];
            switch($instrumento["instrumento_sigla"]){
                case 'ARM_FCI':
                    $valores = $moneda->precioFondoInversionAlamerica($instrumento["instrumento_sigla_api"]);
                break;
                default:
                $valores = $moneda->precioFondoInversionSantander($instrumento["instrumento_sigla_api"]);
            }
            
            $moneda_precio = $valores["valor"];
            $moneda_variacion = $valores["variacion"];
            if($moneda_precio != 0){
                $moneda->updateInstrumentoPrecio($instrumento_sigla_api, $moneda_precio, $moneda_variacion);
            }
        }