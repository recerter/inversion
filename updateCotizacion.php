<?php
set_time_limit(1000);
require_once("inc/php/DBController.php");
require_once 'inc/ext/inversionPrecio.php';
$db_handle = new DBController();
$con = $db_handle->connectDB();
$moneda = new precio(); 
$cotizaciones = $con->query("SELECT * FROM inversion_cotizaciones ");
    while($rowCotizacion = $cotizaciones->fetch(PDO::FETCH_ASSOC)){
        $cotizacion_compra = NULL;
        $cotizacion_venta = NULL;
        $cotizacion_valor = NULL;

        switch ($rowCotizacion["cotizacion_api"]) {
            case 'dolaroficial':
                $valorCotizacion = $moneda->precioDolar('oficial');
                if(!empty($valorCotizacion->compra)){
                    $cotizacion_compra = floatval($valorCotizacion->compra);
                }
                if(!empty($valorCotizacion->venta)){
                    $cotizacion_venta = floatval($valorCotizacion->venta);
                }
                break;
            case 'dolarblue':
                $valorCotizacion = $moneda->precioDolar('informal');
                if(!empty($valorCotizacion->compra)){
                    $cotizacion_compra = floatval($valorCotizacion->compra);
                }
                if(!empty($valorCotizacion->venta)){
                    $cotizacion_venta = floatval($valorCotizacion->venta);
                }
                break;
            
            default:
                $valorCotizacion = $moneda->precioDolar2($rowCotizacion["cotizacion_api"]);
                if(!empty($valorCotizacion->compra)){
                    $cotizacion_compra = floatval($valorCotizacion->compra);
                }
                if(!empty($valorCotizacion->venta)){
                    $cotizacion_venta = floatval($valorCotizacion->venta);
                }
                if(!empty($valorCotizacion->valor)){
                    $cotizacion_valor = floatval($valorCotizacion->valor);
                }
                break;
        }
                $moneda->updateCotizacion($rowCotizacion["cotizacion_api"], $cotizacion_compra, $cotizacion_venta, $cotizacion_valor);            
    }
?>