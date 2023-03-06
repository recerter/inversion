<?php require ("header.php");
if($user->getRango() != 2){
    $util->redirect2("index.php");
}
require_once TS_CLASS.'c.wallet.php';
require_once TS_CLASS.'c.usuario.php';
$cUsuario = new classUsuario();
$cWallet = new wallet();
?>
		<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
			<div class="container-fluid">
				<div class="card">
					<div class="card-header d-sm-flex d-block">
						<div class="mr-auto mb-sm-0 mb-3">
							<h4 class="card-title mb-2">Lista de Usuarios</h4>
						</div>
						<a href="javascript:void(0);" class="btn btn-info light mr-3"><i class="las la-download scale3 mr-2"></i>Import Csv</a>
						<a href="javascript:void(0);" class="btn btn-info">+ Add Customer</a>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table style-1" id="ListDatatableView">
								<thead>
									<tr>
										<th>#</th>
										<th>Nombre</th>
										<th>Tenencia Total</th>
										<th>Registro</th>
										<th>Rango</th>
										<th>Ultima Conexion</th>
										<th>ACTION</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$listadoUsuarios = $cUsuario->listadoUsuarios();
									while ($lUsuario = $listadoUsuarios->fetch(PDO::FETCH_ASSOC)) { 
									echo'
									<tr>
										<td>
											<h6>'.$lUsuario["user_id"].'.</h6>
										</td>
										<td>
											<div class="media style-1">
												<img src="'.$lUsuario["user_avatar"].'" class="img-fluid mr-2" alt="">
												<div class="media-body">
													<h6>'.$lUsuario["user_nombre"].' '.$lUsuario["user_apellido"].'</h6>
													<span>'.$lUsuario["user_email"].'</span>
												</div>
											</div>
										</td>
										<td>
											<div>
												<h6>$'.$tenenciaTotalHoy = number_format($cWallet->getSaldoTotal($lUsuario["user_id"]), 2, '.', '').'</h6>
												<span>Tenencia en pesos</span>
											</div>
										</td>
										<td>
											<div>
												<h6 class="text-primary">'.$lUsuario["user_registro"].'</h6>
												<span>AR</span>
											</div>
										</td>
										<td>
										'.$cUsuario->getRangoNombre($lUsuario["user_rango"]).' 
										</td>
										<td>'; 
										if($cUsuario->comprobarOnlineUsuario($lUsuario["user_id"])){
											echo '<span class="badge badge-warning">'.date("Y-m-d H:i:s",$lUsuario["user_ultimaConexion"]).'</span>'; 
										}else{
											echo '<span class="badge badge-success">Online</span>'; 
										}
											echo '</td>
										<td>
											<div class="d-flex action-button">
												<a href="perfil?id='.$lUsuario["user_id"].'" class="btn btn-dark btn-xs light px-2">
												<i class="flaticon-381-user-7"></i>
												</a>
												<a href="javascript:void(0);" class="ml-2 btn btn-info btn-xs px-2 light px-2">
												<i class="flaticon-381-edit-1"></i>
												</a>
												<a href="javascript:void(0);" class="ml-2 btn btn-xs px-2 light btn-danger">
												<i class="flaticon-381-trash"></i>
												</a>
											</div>
										</td>
									</tr>';
									} ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
        <!--**********************************
            Content body end
        ***********************************-->
<?php require("footer.php");?>