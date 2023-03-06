<?php 
class mercados{
    function mercadoGanadores($limite){
        $db_handle = new DBController();
        $con = $db_handle->connectDB();
        return $con->query("SELECT * FROM inversion_instrumentos ORDER BY instrumento_ultimoPrecioCambio DESC LIMIT $limite");
    }
    function mercadoPerdedores($limite){
        $db_handle = new DBController();
        $con = $db_handle->connectDB();
        return $con->query("SELECT * FROM inversion_instrumentos ORDER BY instrumento_ultimoPrecioCambio ASC LIMIT $limite");
    }
}