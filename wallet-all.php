<?php require ("header.php"); 
require_once TS_CLASS.'c.wallet.php';
require_once TS_CLASS.'c.instrumento.php';
$cWallet = new wallet(); 
$cInstrumento = new instrumento();
$objetivo = $cWallet->getWalletId($_GET["objetivo"]);
if(isset($_GET["objetivo"])){
	if(!$cWallet->walletPerteneceUser($user->userData()["user_id"], $_GET["objetivo"]))
		$util->redirect2("wallet");
}?>
        <div class="content-body">
			<div class="container-fluid">
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Movimientos Del objetivo</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Objetivo</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Movimientos</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"><?php echo $objetivo["wallet_nombre"];?></h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table header-border table-responsive-sm">
                                        <thead>
                                            <tr>
                                                <th>Orden</th>
                                                <th>Instrumento</th>
                                                <th>Fecha</th>
                                                <th>Precio</th>
                                                <th>Operacion</th>
                                                <th>Cantidad</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<?php  $walletMovimiento = $cWallet->getWalletMovimientos($_GET["objetivo"]);
                                    	while($walletM = $walletMovimiento->fetch(PDO::FETCH_ASSOC)){ 
                                    		$walletMInstrumento = $cInstrumento->getInstrumentoSigla($walletM["Wmovimientos_instrumento"]);?>
                                            <tr>
                                                <td><a href="javascript:void(0)">Orden #<?php echo $walletM["Wmovimientos_id"]; ?></a>
                                                </td>
                                                <td><?php echo $walletM["Wmovimientos_instrumento"]; ?></td>
                                                <td><span class="text-muted"><?php echo $walletM["Wmovimientos_fecha"]; ?></span>
                                                </td>
                                                <td>$<?php echo $walletM["Wmovimientos_precio"]; ?></td>
                                                <?php if($walletM["Wmovimientos_operacion"] == "compra"){
																			echo '<td><span class="badge badge-success">Compra</span></td>';
																		}else{
																			echo '<td><span class="badge badge-danger light">Venta</span></td>';
																		}?>
                                                
                                                <td><?php echo $walletM["Wmovimientos_cantidad"]; ?></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
<?php require("footer.php"); ?>