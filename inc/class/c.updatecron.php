<?php
class updateCron {

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

    function insertTeneciaWallet($tWallet_wallet, $tWallet_tenencia, $tWallet_user) {
        $db_handle = new DBController();
        $query = "INSERT INTO inversion_tenenciawallet (tWallet_wallet, tWallet_tenencia, tWallet_user) values (?, ?, ?)";
        $db_handle->insert($query, array($tWallet_wallet, $tWallet_tenencia, $tWallet_user));
    }

}
?>