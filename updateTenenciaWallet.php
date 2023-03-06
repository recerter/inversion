<?php
require_once 'inc/php/DBController.php';
require_once 'inc/ext/inversionPrecio.php';
require_once 'inc/class/c.updatecron.php';
$db_handle = new DBController();
$con = $db_handle->connectDB();
$cUpdateCron = new updateCron();
$moneda = new precio();
$precioDolar = $title_out = str_replace ( ",", '.', $moneda->precioDolar("informal")->venta);
$wallets = $con->query("SELECT wallet_id, wallet_user FROM inversion_wallet");
while($wallet = $wallets->fetch(PDO::FETCH_ASSOC)){
    $totalPesos = $cUpdateCron->getWalletSaldo($wallet["wallet_id"], '$');
    $totalDolares = $cUpdateCron->getWalletSaldo($wallet["wallet_id"], 'U$D');
    $totalWallet = number_format($totalPesos+($totalDolares*$precioDolar), 2, '.', '');
    if($totalWallet != 0){
        $cUpdateCron->insertTeneciaWallet($wallet["wallet_id"], $totalWallet, $wallet["wallet_user"]);
    }
}

?>