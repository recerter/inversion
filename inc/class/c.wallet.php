<?php
require_once TS_CLASS.'c.instrumento.php';
require_once TS_EXT.'inversionPrecio.php';
require_once TS_CLASS.'c.util.php';
class wallet{
    function getWalletId($walletId){
        $db_handle = new DBController();
        $query = "Select * from inversion_wallet where wallet_id = ?";
        $result = $db_handle->runQuery($query,  array($walletId));
        return $result[0];
    }

    function insertWallet($wallet_user, $wallet_nombre, $wallet_imagen) {
        $db_handle = new DBController();
        $query = "INSERT INTO inversion_wallet (wallet_user, wallet_nombre, wallet_imagen) values (?, ?, ?)";
        $db_handle->insert($query, array($wallet_user, $wallet_nombre, $wallet_imagen));

    }
    function walletPerteneceUser($usuario_id, $walletId){
        $objetivo = $this->getWalletId($walletId);
        if($objetivo["wallet_user"] == $usuario_id)
	        return true;
        else
            return false;
    }
    function selectWalletsByUser($usuario_id){
        $db_handle = new DBController();
        $con = $db_handle->connectDB();
        return $con->query("SELECT * FROM inversion_wallet WHERE wallet_user = $usuario_id");
    }
    function walletEliminar($walletId, $passwordUser, $passForm){
        $db_handle = new DBController();
        $util = new Util();
    
        // Verificar si hay instrumentos en la cartera antes de eliminarla
        $instrumentos = self::walletGetInstrumentos($walletId);
        if($instrumentos->rowCount() > 0){
            $util->redirect2("wallet?opc=error&error=Compruebe que el objetivo este vacio antes de eliminarlo");
            return false;
        }
    
        // Verificar la contraseña
        if (!password_verify($passForm, $passwordUser)) {
            $util->redirect2("wallet?opc=error&error=Contraseña Incorrecta");
            return false;
        }
    
        // Eliminar la billetera y los registros de la cartera asociados
        $query = "DELETE FROM inversion_walletportfolio WHERE Wportfolio_wallet = ?";
        $db_handle->delete($query, array($walletId));
        $query = "DELETE FROM inversion_wallet WHERE wallet_id = ?";
        $db_handle->delete($query, array($walletId));
    
        return true;
    }

    function walletMovimientos($walletId, $limit){
        $db_handle = new DBController();
        $con = $db_handle->connectDB();
        return $con->query("SELECT * FROM inversion_walletmovimientos WHERE Wmovimientos_wallet = $walletId ORDER BY Wmovimientos_fecha DESC, Wmovimientos_id DESC LIMIT $limit");
    }

    function walletGetInstrumentos($walletId){
        $db_handle = new DBController();
        $con = $db_handle->connectDB();
        return $con->query("SELECT wp.Wportfolio_instrumento, wp.Wportfolio_cantidad, wp.Wportfolio_wallet, i.instrumento_sigla, i.instrumento_nombre, i.instrumento_imagen, i.instrumento_ultimoPrecio, i.instrumento_moneda 
        FROM inversion_walletportfolio wp 
        INNER JOIN inversion_instrumentos i ON wp.Wportfolio_instrumento = i.instrumento_sigla 
        WHERE wp.Wportfolio_cantidad > 0 AND wp.Wportfolio_wallet = '$walletId' 
        ORDER BY i.instrumento_nombre
        ");
    }

    function distribucionWallet($walletId){
        $moneda = new precio();
        $precioDolar = $moneda->precioCotizacion("dolarblue")["cotizacion_venta"];
        
        $totalCedear = $this->getWalletSaldoTipo($walletId, 'cedear');
        $totalAcciones = $totalCedear + $this->getWalletSaldoTipo($walletId, 'acciones');
        $totalCriptomonedas = round($this->getWalletSaldoTipo($walletId, 'criptomoneda') * $precioDolar, 2);
        $totalFondos = $this->getWalletSaldoTipo($walletId, 'fondos');
        $totalTenencia = $totalAcciones + $totalCriptomonedas + $totalFondos;
    
        $porcentajeAcciones = ($totalTenencia == 0) ? 0 : round(($totalAcciones / $totalTenencia) * 100, 2);
        $porcentajeCriptomonedas = ($totalTenencia == 0) ? 0 : round(($totalCriptomonedas / $totalTenencia) * 100, 2);
        $porcentajeFondos = ($totalTenencia == 0) ? 0 : round(($totalFondos / $totalTenencia) * 100, 2);
    
        return array(
            'totalTenencia' => round($totalTenencia, 2),
            "totalAcciones" => array("totalSaldo" => round($totalAcciones, 2), "totalPorcentaje" => $porcentajeAcciones),
            "totalCriptomonedas" => array("totalSaldo" => round($totalCriptomonedas, 2), "totalPorcentaje" => $porcentajeCriptomonedas),
            "totalFondos" => array("totalSaldo" => round($totalFondos, 2), "totalPorcentaje" => $porcentajeFondos)
        );
    }

    function walletOpcionAgregar($user_id, $nombreWallet, $imagenWallet){
        $cUtil = new Util();
		if(empty($imagenWallet)){
			$imagenWallet = "http://inversiones.ovitec.com.ar/images/card/card1.jpg";
		}
		$this->insertWallet($user_id, $nombreWallet, $imagenWallet);
		$descripcion = "Creo el Objetivo ".$nombreWallet;
		$cUtil->insertLog($user_id, $descripcion);
    }

    function walletOpcionTransaccion($user_id, $wallet, $instrumento, $tipoOperacion, $cantidad, $precioOperacion, $comision, $fechaOperacion) {
        $cUtil = new Util();
        $cInstrumento = new instrumento();
    
        $cantidad = str_replace(",", ".", $cantidad);
        $comision = str_replace(",", ".", $comision);
        $precioOperacion = str_replace(",", ".", $precioOperacion);
    
        $comision = $comision ?: 0;
        $fechaOperacion = $fechaOperacion ?: date("Y-m-d");
        $precioOperacion = $precioOperacion ?: $cInstrumento->getInstrumentoSigla($instrumento)["instrumento_ultimoPrecio"];
    
        $detalleWallet = $this->getWalletId($wallet);
    
        if ($tipoOperacion === "compra") {
            $this->insertWalletPortfolioCompra($user_id, $instrumento, $wallet, $cantidad);
        } elseif ($tipoOperacion === "venta") {
            $walletVenta = $this->insertWalletPortfolioVenta($instrumento, $wallet, $cantidad);
            if (!$walletVenta) {
                $cUtil->redirect2("wallet?opc=error&error=Compruebe los datos");
            }
        }
    
        $this->insertWalletMovimientos($wallet, $tipoOperacion, $instrumento, $cantidad, $precioOperacion, $comision, $fechaOperacion);
        $descripcion = "{$tipoOperacion} de {$instrumento} en el Objetivo {$detalleWallet["wallet_nombre"]}";
        $cUtil->insertLog($user_id, $descripcion);
    
        $cUtil->redirect2("wallet?opc=wallet&objetivo={$wallet}");
    }

    function walletTransferirInsrumento($user_id, $instrumento, $cantidad, $walletOrigen, $walletDestino) {
        $cInstrumento = new instrumento();
        $cUtil = new Util();
        
        // Obtenemos los datos del instrumento
        $datosInstrumento = $cInstrumento->getInstrumentoSigla($instrumento);
        $precioOperacion = $datosInstrumento["instrumento_ultimoPrecio"];
        $fechaOperacion = date("Y-m-d");
        
        // Vendemos los instrumentos en el wallet de origen
        $ventaExitosa = $this->insertWalletPortfolioVenta($instrumento, $walletOrigen, $cantidad);
        if (!$ventaExitosa) {
            $cUtil->redirect2("wallet?opc=error&error=Compruebe los datos");
            return;
        }
        
        // Transferimos los instrumentos al wallet de destino
        $this->insertWalletPortfolioCompra($user_id, $instrumento, $walletDestino, $cantidad);
        
        // Registramos las operaciones en ambos wallets
        $this->insertWalletMovimientos($walletOrigen, 'venta', $instrumento, $cantidad, $precioOperacion, '0', $fechaOperacion);
        $this->insertWalletMovimientos($walletDestino, 'compra', $instrumento, $cantidad, $precioOperacion, '0', $fechaOperacion);
        
        // Registramos la operación en los logs
        $descripcion = "Movio ".$cantidad." ".$instrumento." de ".$this->getWalletId($walletOrigen)["wallet_nombre"]." hacia ".$this->getWalletId($walletDestino)["wallet_nombre"];
        $cUtil->insertLog($user_id, $descripcion);
        
        // Redirigimos a la página de detalles del wallet de origen
        $cUtil->redirect2("wallet?opc=wallet&objetivo=".$walletOrigen); 
    }

    function getSaldoTotal($user) {
        $moneda = new precio();
        $db_handle = new DBController();
        $con = $db_handle->connectDB();
        $precioTotalPesos = 0;
        $precioTotalDolares = 0;
        $dolar = 'U$D';
        
        $stmt = $con->prepare("SELECT * FROM inversion_walletportfolio, inversion_instrumentos  
                               WHERE (inversion_instrumentos.instrumento_moneda = '$' OR inversion_instrumentos.instrumento_moneda = '$dolar') 
                               AND inversion_instrumentos.instrumento_sigla = inversion_walletportfolio.Wportfolio_instrumento AND Wportfolio_user = :user");
        
        $stmt->bindParam(":user", $user);
        $stmt->execute();
        $wallets = $stmt->fetchAll();
        
        foreach($wallets as $wallet) {
            $moneda_precio = $wallet["instrumento_ultimoPrecio"];
            $cantidad = $wallet["Wportfolio_cantidad"];
            
            if ($wallet["instrumento_moneda"] == '$') {
                $precioTotalPesos += ($moneda_precio * $cantidad);
            } else {
                $precioTotalDolares += ($moneda_precio * $cantidad);
            }
        }
        
        $precioTotalEnDolares = $precioTotalDolares * $moneda->precioCotizacion("dolarblue")["cotizacion_compra"];
        return number_format($precioTotalPesos + $precioTotalEnDolares, 2, '.', '');
    }

    function getWalletSaldo($Wportfolio_wallet, $Wmoneda) {
        $db_handle = new DBController();
        $con = $db_handle->connectDB();
        $stmt = $con->prepare("SELECT SUM(inversion_instrumentos.instrumento_ultimoPrecio * inversion_walletportfolio.Wportfolio_cantidad) as total 
                                FROM inversion_walletportfolio 
                                JOIN inversion_instrumentos ON inversion_walletportfolio.Wportfolio_instrumento = inversion_instrumentos.instrumento_sigla 
                                WHERE inversion_walletportfolio.Wportfolio_wallet = :Wportfolio_wallet AND inversion_instrumentos.instrumento_moneda = :Wmoneda");
        $stmt->bindValue(':Wportfolio_wallet', $Wportfolio_wallet, PDO::PARAM_INT);
        $stmt->bindValue(':Wmoneda', $Wmoneda, PDO::PARAM_STR);
        $stmt->execute();
        $total = $stmt->fetchColumn();
        $stmt->closeCursor();
        return number_format($total, 2, '.', '');
    }

    function insertWalletMovimientos($Wmovimientos_wallet, $Wmovimientos_operacion, $Wmovimientos_instrumento, $Wmovimientos_cantidad, $Wmovimientos_precio, $Wmovimientos_comision, $Wmovimientos_fecha) {
        $db_handle = new DBController();
        $query = "INSERT INTO inversion_walletmovimientos (Wmovimientos_wallet, Wmovimientos_operacion, Wmovimientos_instrumento, Wmovimientos_cantidad, Wmovimientos_precio, Wmovimientos_comision, Wmovimientos_fecha) values (?, ?, ?, ?, ?, ?, ?)";
        return $db_handle->insert($query, array($Wmovimientos_wallet, $Wmovimientos_operacion, $Wmovimientos_instrumento, $Wmovimientos_cantidad, $Wmovimientos_precio, $Wmovimientos_comision, $Wmovimientos_fecha));
    }
    function insertWalletPortfolioCompra($Wportfolio_user, $Wportfolio_instrumento, $Wportfolio_wallet, $Wportfolio_cantidad) {
        $db_handle = new DBController();
        $query = "Select * from inversion_walletportfolio where Wportfolio_instrumento = ? and Wportfolio_wallet = ?";
        $result = $db_handle->runQuery($query, array($Wportfolio_instrumento, $Wportfolio_wallet));
        if($result){
            $query = "UPDATE inversion_walletportfolio SET Wportfolio_cantidad = Wportfolio_cantidad+? WHERE Wportfolio_wallet = ? AND Wportfolio_instrumento = ?";
            $db_handle->update($query, array($Wportfolio_cantidad, $Wportfolio_wallet, $Wportfolio_instrumento));
            return $result;
        }else{
            $query = "INSERT INTO inversion_walletportfolio (Wportfolio_user, Wportfolio_instrumento, Wportfolio_wallet, Wportfolio_cantidad) values (?, ?, ?, ?)";
            return $db_handle->insert($query, array($Wportfolio_user, $Wportfolio_instrumento, $Wportfolio_wallet, $Wportfolio_cantidad)); 
        }
    }

    function insertWalletPortfolioVenta($Wportfolio_instrumento, $Wportfolio_wallet, $Wportfolio_cantidad) {
        $db_handle = new DBController();
        $query = "UPDATE inversion_walletportfolio SET Wportfolio_cantidad = Wportfolio_cantidad-? WHERE Wportfolio_wallet = ? AND Wportfolio_instrumento = ? AND Wportfolio_cantidad >= ?";
        $numRows = $db_handle->update($query, array($Wportfolio_cantidad, $Wportfolio_wallet, $Wportfolio_instrumento, $Wportfolio_cantidad));
        return ($numRows > 0) ? true : false;
    }

    function getWalletSaldoTipo($Wportfolio_wallet, $Wtipo) {
        $db_handle = new DBController();
        $con = $db_handle->connectDB();
        $query = "SELECT SUM(inversion_instrumentos.instrumento_ultimoPrecio*inversion_walletportfolio.Wportfolio_cantidad) AS precioTotal FROM inversion_walletportfolio INNER JOIN inversion_instrumentos ON inversion_instrumentos.instrumento_sigla = inversion_walletportfolio.Wportfolio_instrumento WHERE inversion_walletportfolio.Wportfolio_wallet = ? AND inversion_instrumentos.instrumento_tipo = ?";
    $stmt = $con->prepare($query);
    $stmt->bindParam(1, $Wportfolio_wallet, PDO::PARAM_STR);
    $stmt->bindParam(2, $Wtipo, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return number_format($result['precioTotal'], 2, '.', '');
    }

    function getWalletMovimientos($wallet_id){
        $db_handle = new DBController();
        $con = $db_handle->connectDB();
        return $con->query("SELECT * FROM inversion_walletmovimientos WHERE Wmovimientos_wallet = ".$wallet_id." ORDER BY Wmovimientos_fecha DESC, Wmovimientos_id DESC");
    }
}