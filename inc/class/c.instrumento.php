<?php
require_once TS_CLASS."c.util.php";
class instrumento{
    private $db_handle;
    private $con;
    function __construct() {
        $this->db_handle = new DBController();
        $this->con = $this->db_handle->connectDB();
	}
    function agregarInstrumento($user_id, $instrumento_nombre, $instrumento_moneda, $instrumento_sigla_api, $instrumento_sigla, $instrumento_tipo, $instrumento_descripcion, $instrumento_imagen){
        $util = new Util();
        $query = "INSERT INTO inversion_instrumentos (instrumento_nombre, instrumento_moneda, instrumento_sigla_api, instrumento_sigla, instrumento_tipo, instrumento_descripcion, instrumento_imagen) values (?, ?, ?, ?, ?, ?, ?)";
        $this->db_handle->insert($query, array($instrumento_nombre, $instrumento_moneda, $instrumento_sigla_api, $instrumento_sigla, $instrumento_tipo, $instrumento_descripcion, $instrumento_imagen));
        $descripcion = "Agrego un nuevo instrumento $instrumento_sigla";
        $util->insertLog($user_id, $descripcion);
    }

    function getInstrumentoSigla($sigla){
        $query = "Select * from inversion_instrumentos where instrumento_sigla = ?";
        $result = $this->db_handle->runQuery($query, array($sigla));
        return $result[0];
    }

    function getInstrumentoId($id){
        $query = "Select * from inversion_instrumentos where instrumento_id = ?";
        $result = $this->db_handle->runQuery($query, array($id));
        return $result[0];
    }

    function getWalletByInstrumento($user_id, $instrumento){
        return $this->con->query("SELECT * FROM inversion_walletportfolio, inversion_wallet, inversion_instrumentos WHERE inversion_walletportfolio.Wportfolio_user = $user_id AND inversion_wallet.wallet_id = inversion_walletportfolio.Wportfolio_wallet AND inversion_walletportfolio.Wportfolio_instrumento = '$instrumento' AND inversion_instrumentos.instrumento_sigla = inversion_walletportfolio.Wportfolio_instrumento AND inversion_walletportfolio.Wportfolio_cantidad > 0");
    }

    function getMovimientosByInstrumento($user_id, $instrumento){
        return $this->con->query("SELECT * FROM inversion_wallet, inversion_walletmovimientos WHERE inversion_walletmovimientos.Wmovimientos_wallet = inversion_wallet.wallet_id AND inversion_wallet.wallet_user = $user_id AND inversion_walletmovimientos.Wmovimientos_instrumento = '$instrumento' ORDER BY inversion_walletmovimientos.Wmovimientos_fecha DESC");
    }

    function listadoinstrumentoTradeable(){
        return $this->con->query("SELECT * FROM inversion_instrumentos WHERE instrumento_tipo = 'criptomoneda' OR instrumento_tipo = 'cedear' OR instrumento_tipo = 'acciones' OR instrumento_tipo = 'fondos' ORDER BY instrumento_sigla");
    }
    function getInstrumentoTipo($tipo,$arrayLimit){
        if(empty($tipo)){
            return $this->con->query("SELECT * FROM inversion_instrumentos ORDER BY instrumento_sigla LIMIT $arrayLimit[0], $arrayLimit[1]");
        }else{
            return $this->con->query("SELECT * FROM inversion_instrumentos WHERE instrumento_tipo = '$tipo' ORDER BY instrumento_sigla LIMIT $arrayLimit[0], $arrayLimit[1]");
        }
        
    }

    function setSplit($instrumento_id, $instrumento_cantidad) {
        $query = "UPDATE inversion_walletportfolio SET Wportfolio_cantidad = Wportfolio_cantidad* ? WHERE Wportfolio_instrumento = ?";
        $this->db_handle->update($query, array($instrumento_cantidad, $instrumento_id));
    }
}
?>