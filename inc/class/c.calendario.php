<?php
class calendario{
    function getMovimentosInstrumentos($usuario_id) {
        $db_handle = new DBController();
        $conn = $db_handle->connectDB();
        $stmt = $conn->prepare("SELECT w.Wmovimientos_instrumento, w.Wmovimientos_wallet, w.Wmovimientos_operacion, w.Wmovimientos_fecha 
                                FROM inversion_walletmovimientos w 
                                JOIN inversion_wallet iw ON w.Wmovimientos_wallet = iw.wallet_id 
                                WHERE iw.wallet_user = ?");
        $stmt->bindParam(1, $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function getMovimientosWallet($usuario_id){
        $db_handle = new DBController();
        $con = $db_handle->connectDB();
        return $con->query("SELECT * FROM inversion_wallet WHERE wallet_user = ".$usuario_id."");
    }

    function getCalendarioGlobal(){
        $db_handle = new DBController();
        $con = $db_handle->connectDB();
        return $con->query("SELECT * FROM inversion_calendarioglobal");
    }
}