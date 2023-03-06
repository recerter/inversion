<?php require ("header.php");
require_once TS_CLASS.'c.wallet.php';
require_once TS_CLASS.'c.instrumento.php';
$cWallet = new wallet(); 
$cInstrumento = new instrumento();
$precio = new precio();
$usuario_id = $user->userData()["user_id"];
$db_handle = new DBController();
		  $con = $db_handle->connectDB();
if(isset($_GET["objetivo"])){
	if(!$cWallet->walletPerteneceUser($usuario_id, $_GET["objetivo"]))
		$util->redirect2("wallet");
}
if(isset($_GET["opc"])){
	$opc = $_GET["opc"];
}else{
	$opc = FALSE;
}
if (! empty($_POST["form"])) {
switch ($_POST["form"]) {
	case 'agregar':
		$cWallet->walletOpcionAgregar($user->userData()["user_id"], $_POST["nombre"], $_POST["imagen"]);
		break;
	case 'transaccion':
		$cWallet->walletOpcionTransaccion($user->userData()["user_id"], $_POST["objetivo"], $_POST["instrumento"], $_POST["operacion"], $_POST["cantidad"], $_POST["precio"], $_POST["comisiones"], $_POST["fecha"]);
		break;
	case 'eliminar':
		$cWallet->walletEliminar($_POST["objetivo"], $user->userData()["user_contrasena"], $_POST["password"]);
		break;
		
	case 'transferir':
		$cWallet->walletTransferirInsrumento($usuario_id, $_POST["instrumento"], $_POST["cantidad"], $_POST["walletOrigen"], $_POST["walletDestino"]);
		break;
	default:
		# code...
		break;
}
}
?>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link href="vendor/swiper/css/swiper-bundle.min.css" rel="stylesheet">
	<div class="content-body">
		<div class="container-fluid">
			<div class="form-head mb-sm-5 mb-3 d-flex align-items-center flex-wrap">
				<h2 class="font-w600 mb-0 mr-auto mb-2 text-black">Mis Objetivos</h2>
				<?php if(isset($_GET["objetivo"]) & $opc=='wallet'){
				echo '<a href="wallet?opc=transaccion&objetivo='.$_GET["objetivo"].'&transaccion=true" class="btn btn-secondary mb-2">+ Añadir Transaccion</a>';
				} ?>
				</div>
			<div class="row">
				<div class="col-xl-3 col-xxl-4">
					<div class="swiper-box">
						<div class="swiper-container card-swiper">
							<div class="swiper-wrapper">
									<?php
									$wallets = $cWallet->selectWalletsByUser($usuario_id);
									while ($wallet = $wallets->fetch(PDO::FETCH_ASSOC)) { ?>
								<div class="swiper-slide">
								<a href="wallet?opc=wallet&objetivo=<?php echo $wallet["wallet_id"]; ?>">
									<div class="card-bx stacked card">
										<img src="<?php echo $util->reemplazar_imagen($wallet["wallet_imagen"],"http://inversiones.ovitec.com.ar/images/card/card1.jpg"); ?>" alt="">
										<div class="card-info">
							<p class="mb-1 text-white fs-14">Balance</p>
								<div class="d-flex justify-content-between">
									<h2 class="num-text text-white mb-5 font-w600">$ <?php echo $cWallet->getWalletSaldo($wallet["wallet_id"], '$'); ?> <br> U$D <?php echo $cWallet->getWalletSaldo($wallet["wallet_id"], 'U$D'); ?></h2>
												</div>
												<div class="d-flex">
													<div class="mr-4 text-white">
														<p class="fs-12 mb-1 op6">Creado</p>
														<span><?php echo date( "d/m/Y", strtotime($wallet["wallet_creado"]) ); ?></span>
													</div>
													<div class="text-white">
														<p class="fs-12 mb-1 op6">Nombre</p>
														<span><?php echo $wallet["wallet_nombre"]; ?></span>
													</div>
												</div>
											</div>
										</div>
									</a>
								</div>
									<?php } ?>
							</div>

							<!-- Add Scroll Bar -->
								<div class="swiper-scrollbar"></div>
							</div>
						</div>
					</div>
					
					<div class="col-xl-9 col-xxl-8">
						<div class="row">
							<div class="col-xl-12">
								<div class="d-block d-sm-flex mb-4">
									<h4 class="mb-0 text-black fs-20 mr-auto">Detalles</h4>
									<?php if(isset($_GET["objetivo"])  & $opc=='wallet'){ ?>
									<div class="d-flex mt-sm-0">
										<a href="javascript:void(0);" class="btn-link me-3 underline">Editar -</a>
										<a href="wallet?opc=eliminar&objetivo=<?php echo $_GET["objetivo"];?>" class="btn-link underline">- Eliminar</a>
									</div>
									
								<?php } ?>
								</div>
							</div>
							
							<div class="col-xl-12">
								<div class="card">
									<div class="card-body">
									<?php switch ($opc) {
						case 'wallet':
							$datos_wallet = $cWallet->getWalletId($_GET["objetivo"]);
							$totalPesos = $cWallet->getWalletSaldo($_GET["objetivo"], '$');
							$totalDolares = $cWallet->getWalletSaldo($_GET["objetivo"], 'U$D');
							$precioDolar = $precio->precioCotizacion("dolarblue")["cotizacion_venta"];

							if ($precioDolar == 0) {
								$CountDolares = 0;
							} else {
								$CountPesos = number_format($totalPesos + ($totalDolares * $precioDolar), 2, '.', '');
								$CountDolares = number_format($totalDolares + ($totalPesos / $precioDolar), 2, '.', '');
							}
							
							echo'<div class="row align-items-end">
							<div class="col-xl-6 col-lg-12 col-xxl-12">
								<div class="row">
									<div class="col-sm-6">
										<div class="mb-4">
											<p class="mb-2">Nombre</p>
											<h4 class="text-black">'.$datos_wallet["wallet_nombre"].'</h4>
										</div>
										<div class="mb-4">
											<p class="mb-2">Creado</p>
											<h4 class="text-black">'.$datos_wallet["wallet_creado"].'</h4>
										</div>
										<div>
											<p class="mb-2">Fecha Finalizacion</p>
											<h4 class="text-black">***/</h4>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="mb-4">';
											echo'<p class="mb-2">Tenencia Reexpresada en Pesos</p>
											<h4 class="text-black">$ '.$CountPesos.'</h4>
										</div>
										<div class="mb-4">
											<p class="mb-2">Tenencia Reexpresada en Dolares</p>
											<h4 class="text-black">U$D '.$CountDolares.'</h4>
										</div>

									</div>
								</div>
							</div>
							<div class="col-xl-6 col-lg-12 col-xxl-12 mb-lg-0 mb-3">
								<p>Distribucion</p>';
								$walletDistribucion = $cWallet->distribucionWallet($_GET["objetivo"]);
								echo'<div class="row">
									<div class="col-sm-4 mb-sm-0 mb-4 text-center">
										<div class="d-inline-block position-relative donut-chart-sale mb-3">
											<span class="donut1" data-peity="{ "fill": ["rgb(255, 104, 38)", "rgba(240, 240, 240)"],   "innerRadius": 40, "radius": 10}">'.$walletDistribucion["totalAcciones"]["totalPorcentaje"].'/100</span>
											<small>'.$walletDistribucion["totalAcciones"]["totalPorcentaje"].'%</small>
										</div>
										<h5 class="fs-18 text-black">Acciones</h5>
										<span>$'.$walletDistribucion["totalAcciones"]["totalSaldo"].'</span>
									</div>
									<div class="col-sm-4 mb-sm-0 mb-4 text-center">
										<div class="d-inline-block position-relative donut-chart-sale mb-3">
											<span class="donut1" data-peity="{ "fill": ["rgb(255, 104, 38)", "rgba(240, 240, 240)"],   "innerRadius": 40, "radius": 10}">'.$walletDistribucion["totalCriptomonedas"]["totalPorcentaje"].'/100</span>
											<small>'.$walletDistribucion["totalCriptomonedas"]["totalPorcentaje"].'%</small>
										</div>
										<h5 class="fs-18 text-black">Criptomonedas</h5>
										<span>$'.$walletDistribucion["totalCriptomonedas"]["totalSaldo"].'</span>
									</div>
									<div class="col-sm-4 text-center">
										<div class="d-inline-block position-relative donut-chart-sale mb-3">
											<span class="donut1" data-peity="{ "fill": ["rgb(158, 158, 158)", "rgba(240, 240, 240)"],   "innerRadius": 40, "radius": 10}">'.$walletDistribucion["totalFondos"]["totalPorcentaje"].'/100</span>
											<small>'.$walletDistribucion["totalFondos"]["totalPorcentaje"].'%</small>
										</div>
										<h5 class="fs-18 text-black">Fondos</h5>
										<span>$'.$walletDistribucion["totalFondos"]["totalSaldo"].'</span>
									</div>
								</div>
							</div>
						</div>';
							break;

						case 'transaccion':
							echo '<form method="POST" action="'.$_SERVER["PHP_SELF"].'">
							<input type="hidden" value="'.$_GET["objetivo"].'" name="objetivo">
							<div class="form-group">
								Instrumento
						<select class="selectpicker" data-show-subtext="true" data-live-search="true" name="instrumento">';
							$instrumentoListado = $cInstrumento->listadoinstrumentoTradeable();
							while($getInstrumento = $instrumentoListado->fetch(PDO::FETCH_ASSOC)){
							echo'<option data-subtext="'.$getInstrumento["instrumento_nombre"].'"> '.$getInstrumento["instrumento_sigla"].'</option>';
							}
						echo'</select>
						</div>
							<div class="form-group mb-0">
								Tipo De operacion
								<div class="radio">
									<label><input type="radio" name="operacion" value="compra" checked> Compra</label>
								</div>
								<div class="radio">
									<label><input type="radio" name="operacion" value="venta"> Venta</label>
								</div>
							</div>
							<div class="form-group">
								Precio de compra
								<input type="text" class="form-control input-default " autocomplete="off" placeholder="precio" name="precio">
							</div>
							<div class="form-group">
								Comisiones Totales
								<input type="text" class="form-control input-default " placeholder="comisiones" name="comisiones">
							</div>
							<div class="form-group">
								Cantidad
								<input type="text" class="form-control input-default " autocomplete="off" placeholder="cantidad" name="cantidad">
							</div>
							<div class="form-group">
								Fecha de Compra
							<input class="form-control input-default " autocomplete="off" type="text" placeholder="'.date("Y-m-d").'" name="fecha" id="campofecha">
							</div>
							<div class="text-center mt-4">
								<button name="form" type="submit" value="transaccion" class="btn btn-primary btn-block">Agregar</button>
							</div>
						</form>';
							break;
						case 'add':
							echo '<form method="POST" action="'.$_SERVER["PHP_SELF"].'">
											<h4 class="mb-0 text-black fs-20 mr-auto">Agregar un Nuevo Objetivo</h4>
										<div class="form-group">
											Nombre
											<input type="text" class="form-control input-default " placeholder="Nombre" name="nombre">
										</div>


										<div class="form-group">
											Imagen
											<input type="text" class="form-control input-default " placeholder="http://" name="imagen">
										</div>

										<div class="text-center mt-4">
											<button name="form" type="submit" value="agregar" class="btn btn-primary btn-block">Agregar</button>
										</div>
									</form>';
							break;	
						case 'error':
							echo'<div class="alert alert-danger solid alert-rounded "><strong>Error!</strong> Hubo un error al procesar esa solicitud, '.$_GET["error"].'.</div>';
							break;
							
							case 'eliminar':
								$datos_wallet = $cWallet->getWalletId($_GET["objetivo"]);
								echo'<div class="basic-form">
								<p>Para continuar ingrese su contraseña. Se Eliminara <code>"'.$datos_wallet["wallet_nombre"].'"</code></p>
								<form class="d-flex align-items-center" method="POST" action="'.$_SERVER["PHP_SELF"].'">
								<input id="objetivo" name="objetivo" type="hidden" value='.$_GET["objetivo"].'">

									<div class="mb-3 mb-2">
										<label class="sr-only">Email</label>
										<input type="text" readonly="" name="email" class="form-control-plaintext" value="'.$user->userData()["user_email"].'">
									</div>
									<div class="mb-2 mx-sm-3">
										<label class="sr-only">Password</label>
										<input type="password" name="password" class="form-control" placeholder="Contraseña">
									</div>
									<button type="submit" name="form" value="eliminar" class="btn btn-primary mb-2">Confirmar ideantidad</button>
								</form>
							</div>';
							break;

							case 'transferir':
								$datos_wallet = $cWallet->getWalletId($_GET["objetivo"]);
								echo'<div class="basic-form">
								<p>Para continuar ingrese la wallet destino para mover el instrumento '.$_GET["instrumento"].' de <code>"'.$datos_wallet["wallet_nombre"].'"</code></p>
								<form class="d-flex align-items-center" method="POST" action="'.$_SERVER["PHP_SELF"].'">
								<input id="walletOrigen" name="walletOrigen" type="hidden" value="'.$_GET["objetivo"].'">
								<input id="instrumento" name="instrumento" type="hidden" value="'.$_GET["instrumento"].'">
								<div class="form-group">
								Wallet Destino
						<select class="selectpicker" data-show-subtext="true" data-live-search="true" name="walletDestino">';
						$walletDestino = $cWallet->selectWalletsByUser($usuario_id);
						while($wDestino = $walletDestino->fetch(PDO::FETCH_ASSOC)){
							echo'<option value="'.$wDestino["wallet_id"].'"> '.$wDestino["wallet_nombre"].'</option>';
							}
						echo'</select>
						</div>
									<div class="mb-3 mb-2">
										<label class="sr-only">Email</label>
										<input type="text" readonly="" name="email" class="form-control-plaintext" value="">
									</div>
									<div class="mb-2 mx-sm-3">
										<label class="sr-only">Cantidad</label>
										<input type="text" name="cantidad" class="form-control" placeholder="Cantidad">
									</div>
									<button type="submit" name="form" value="transferir" class="btn btn-primary mb-2">Confirmar</button>
								</form>
							</div>';
							break;
							
						
						default:
						echo '<h4 class="mb-0 text-black fs-20 mr-auto">Para continuar Seleccione un objetivo o <a href="wallet?opc=add">cree uno nuevo</a></h4>';
							break;
					}?>
									</div>
								</div>
							</div>
							<?php if(isset($_GET["objetivo"]) & $opc=='wallet'){ ?>
								<div class="col-xl-12">
								<div class="card">
							<div class="card-header border-0 flex-wrap pb-0">
								<div class="mb-3">
									<h4 class="fs-20 text-black">Tenencia Total</h4>
									<p class="mb-0 fs-12 text-black">Tenencia total del objetivo</p>
								</div>
								
								<p class="mb-0 fs-14">
								<?php
			$fechaAyer = date('d-m-Y', strtotime('-1 day'));
			$fecha_day = date('d', strtotime($fechaAyer));
			$fecha_month = date('m', strtotime($fechaAyer));
			$fecha_year = date('Y', strtotime($fechaAyer));
			
			$tenenciawallets = $con->query("SELECT * FROM inversion_tenenciawallet WHERE YEAR(tWallet_fecha) = $fecha_year AND DAY(tWallet_fecha) = $fecha_day AND MONTH(tWallet_fecha) = $fecha_month AND tWallet_wallet = ".$_GET["objetivo"]."");
			$tenenciaTotalAyer = ($tenenciawallet = $tenenciawallets->fetch(PDO::FETCH_ASSOC)) ? $tenenciawallet["tWallet_tenencia"] : 0;
			
			$porcentajeDiarioCartera = ($tenenciaTotalAyer != 0) ? number_format((($CountPesos*100)/$tenenciaTotalAyer)-100, 2, '.', '') : 100;
			
			echo '<p class="card-text">';
			echo '<span class="', ($porcentajeDiarioCartera < 0) ? 'text-danger' : 'text-success', ' mr-1">', $porcentajeDiarioCartera.'% ('.number_format($CountPesos-$tenenciaTotalAyer, 2, ',', '.').' $)</span> Cartera en 24hs</p>';
			?>
							</div>
							<div class="card-body pb-2 px-3">
								<div id="marketChart" class="market-line"></div>
							</div>
						</div>
								</div>
							
						</div>
					</div>
					<?php if(isset($_GET["objetivo"]) & $opc=='wallet'){ ?>
					<div class="col-xl-6  mt-4">

					<div class="col-xl-12">
						<div class="card">
									<div class="card-header pb-2 d-block d-sm-flex flex-wrap border-0">
										<div class="mb-3">
											<h4 class="fs-20 text-black">Ultimos movimientos</h4>
											<p class="mb-0 fs-13">Movimientos de objetivo</p>
										</div>

									</div>
									<div class="card-body tab-content p-0">
										<div class="tab-pane active show fade" id="monthly">
											<div class="table-responsive">
												<table class="table shadow-hover card-table border-no tbl-btn short-one">
													<tbody>
									<?php
									 $walletMovimiento = $cWallet->walletMovimientos($_GET["objetivo"], '6');
										while($walletM = $walletMovimiento->fetch(PDO::FETCH_ASSOC)){
											$walletMInstrumento = $cInstrumento->getInstrumentoSigla($walletM["Wmovimientos_instrumento"]);
											?>
														<tr>
															<td>
																<span>
																	<svg width="50" height="50" viewbox="0 0 63 63" fill="none" xmlns="http://www.w3.org/2000/svg">
																		<rect width="63" height="63" rx="14" fill="#625794"></rect>
																		<?php if($walletM["Wmovimientos_operacion"] == "compra"){
																			echo '<path d="M25.4813 24.6343L25.4813 24.6343L30.3544 19.7376C30.3571 19.7348 30.3596 19.7323 30.3619 19.7301M25.4813 24.6343L30.7116 20.0875L30.3587 19.7333C30.368 19.7241 30.3756 19.7172 30.3789 19.7143L30.38 19.7133C30.3775 19.7155 30.3709 19.7214 30.3627 19.7293C30.3625 19.7295 30.3622 19.7298 30.3619 19.7301M25.4813 24.6343C24.9214 25.197 24.9234 26.1071 25.4862 26.6672C26.0489 27.2273 26.9591 27.2251 27.5191 26.6624L27.5192 26.6624L29.9377 24.232M25.4813 24.6343L29.9377 24.232M30.3619 19.7301C30.9212 19.1741 31.8279 19.1724 32.389 19.7304C32.3902 19.7316 32.3914 19.7329 32.3927 19.7341L32.3941 19.7356L32.4062 19.7477L37.2691 24.6342L36.9147 24.9869L37.2692 24.6342C37.829 25.1968 37.8271 26.107 37.2642 26.6672C36.7015 27.2272 35.7914 27.225 35.2314 26.6623L35.2313 26.6623L32.8127 24.232L32.8127 42.875C32.8127 43.6689 32.1692 44.3125 31.3752 44.3125C30.5813 44.3125 29.9377 43.6689 29.9377 42.875L29.9377 24.232M30.3619 19.7301C30.3605 19.7315 30.3591 19.7329 30.3577 19.7343L29.9377 24.232M32.3927 19.7342C32.3932 19.7347 32.3937 19.7351 32.3941 19.7356L32.3927 19.7342Z" fill="white" stroke="white"></path>';
																		}else{
																			echo '<path d="M37.2692 38.9908L37.2692 38.9908L32.3961 43.8874C32.3934 43.8902 32.3909 43.8927 32.3885 43.895M37.2692 38.9908L32.0389 43.5375L32.3918 43.8917C32.3825 43.9009 32.3749 43.9078 32.3716 43.9107L32.3705 43.9117C32.373 43.9095 32.3796 43.9036 32.3877 43.8957C32.388 43.8955 32.3883 43.8952 32.3885 43.895M37.2692 38.9908C37.8291 38.4281 37.827 37.5179 37.2643 36.9578C36.7016 36.3978 35.7914 36.3999 35.2314 36.9626L35.2313 36.9627L32.8127 39.393M37.2692 38.9908L32.8127 39.393M32.3885 43.895C31.8292 44.4509 30.9226 44.4526 30.3615 43.8946C30.3603 43.8934 30.3591 43.8922 30.3578 43.8909L30.3563 43.8894L30.3442 43.8773L25.4813 38.9908L25.8357 38.6381L25.4813 38.9908C24.9215 38.4282 24.9234 37.518 25.4862 36.9578C26.049 36.3978 26.9591 36.4 27.5191 36.9627L27.5192 36.9627L29.9377 39.393L29.9377 20.75C29.9377 19.9561 30.5813 19.3125 31.3752 19.3125C32.1692 19.3125 32.8127 19.9561 32.8127 20.75L32.8127 39.393M32.3885 43.895C32.39 43.8935 32.3914 43.8921 32.3928 43.8907L32.8127 39.393M30.3577 43.8908C30.3573 43.8903 30.3568 43.8899 30.3564 43.8894L30.3577 43.8908Z" fill="white" stroke="white"></path>';
																		}?>

																	</svg>
																</span>
															</td>
															<td>
																<span class="font-w600 text-black"><?php echo $walletM["Wmovimientos_operacion"]; ?></span>
															</td>
															<td>
																<span class="text-black"><?php echo $walletM["Wmovimientos_fecha"]; ?></span>
															</td>
															<td>
																<a href="monedaDetalle?instrumento=<?php echo $walletM["Wmovimientos_instrumento"]; ?>" class="font-w600 text-black"><?php echo $walletM["Wmovimientos_instrumento"]; ?></a>
															</td>
															<td><a class="btn-link text-<?php if($walletM["Wmovimientos_operacion"] == "compra"){
																			echo 'success';
																		}else{
																			echo 'danger';
																		}?> float-right" href="javascript:void(0);"><?php echo $walletMInstrumento["instrumento_moneda"]." "; echo $walletM["Wmovimientos_precio"]; ?> (<?php echo $walletM["Wmovimientos_cantidad"]; ?>)</a></td>
														</tr>
													<?php } ?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<div class="card-footer border-0 p-0 caret">
										<a href="wallet-all?objetivo=<?php echo $_GET['objetivo']; ?>" class="btn-link mt-1"><i class="fa fa-caret-down" aria-hidden="true"></i></a>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
					<div class="col-xl-6 mt-4">
							<div class="col-xl-12">
						<div class="card border-0 pb-0">
							<div class="card-header border-0 pb-0">
								<h4 class="card-title">Portfolio</h4>
							</div>
							<div class="card-body">
								<div id="DZ_W_Todo3" class="widget-media dz-scroll height370 ps ps--active-y">
									<ul class="timeline">
										<?php
										 $walletPortfolio = $cWallet->walletGetInstrumentos($_GET['objetivo']);
										while($walletP = $walletPortfolio->fetch(PDO::FETCH_ASSOC)){
											$precioFinal = $walletP["instrumento_ultimoPrecio"]*$walletP["Wportfolio_cantidad"];
										echo '<li>
											<div class="timeline-panel">
												<div class="me-2">
													<img alt="image" width="50" src="'.$walletP["instrumento_imagen"].'">
												</div>
												<div class="media-body ">
													<h5 class="mb-1">'.$walletP["instrumento_nombre"].'</h5>

													<a href="wallet?opc=transaccion&objetivo='.$_GET["objetivo"].'&transaccion=true" class="btn btn-primary btn-xxs shadow">Comprar/Vender</a>
													<a href="wallet?opc=transferir&objetivo='.$_GET["objetivo"].'&instrumento='.$walletP["instrumento_sigla"].'" class="btn btn-outline-danger btn-xxs">Transferir</a>
												</div>
												<div >
													<h5 class="mb-1">'.$walletP["Wportfolio_instrumento"].' '.$walletP["Wportfolio_cantidad"].' <small class="text-muted">'.$walletP["instrumento_moneda"].''.$precioFinal.' ('.$walletP["instrumento_moneda"].''.$walletP["instrumento_ultimoPrecio"].')</small></h5>
												</div>
											</div>
										</li>
										';
									}
										?>
									</ul>
								<div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; height: 370px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 222px;"></div></div></div>
							</div>
						</div>
							</div>

					</div>
					<?php } ?>
				</div>
			</div>
		</div>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>

<?php require ("footer.php"); ?>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<?php if(isset($_GET["objetivo"])){ ?>
 <script>
  $( function() {
	$( "#campofecha" ).datepicker({
	  numberOfMonths: 1,
	  dateFormat: "yy-mm-dd",
	  showButtonPanel: true
	});
  } );
  </script>

  <?php if(isset($CountPesos)){ ?>
  <script>
			(function($) {
    "use strict"

 var dzChartlist = function(){
	
	var screenWidth = $(window).width();
	var marketChart = function(){
		 var options = {
          series: [{
          name: 'Tenencia',
          data: [<?php
		  $tenencias = array();
		  $fecha_inicial = date('Y-m-d', strtotime('-29 days'));
		  $fecha_final = date('Y-m-d');
		  $tenenciawallets = $con->query("SELECT tWallet_fecha, tWallet_tenencia FROM inversion_tenenciawallet WHERE tWallet_fecha BETWEEN '$fecha_inicial' AND '$fecha_final' AND tWallet_wallet = ".$_GET["objetivo"]." ORDER BY tWallet_fecha ASC");
		  while ($tenenciawallet = $tenenciawallets->fetch(PDO::FETCH_ASSOC)) {
			  $fecha = date('d-m-Y', strtotime($tenenciawallet['tWallet_fecha']));
			  $tenencia = $tenenciawallet['tWallet_tenencia'];
			  $tenencias[$fecha] = $tenencia;
		  }
		  
		  for($i = 29; $i >= 1; $i--) {
			  $fecha = date('d-m-Y', strtotime('-'.$i.' days'));
			  if (isset($tenencias[$fecha])) {
				  $tenencia = $tenencias[$fecha];
			  } else {
				  $tenencia = 0;
			  }
			  echo '"'.number_format($tenencia, 2, '.', '').'",';
		  }
		  
		  echo number_format($totalPesos + ($totalDolares * $precioDolar), 2, '.', '');?>]
        }],
          chart: {
          height: 300,
          type: 'area',
		  toolbar:{
			  show:false
		  }
        },
		colors:["#FFAB2D","#00ADA3"],
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'smooth',
		  width:3
        },
		legend:{
			show:false
		},
		grid:{
			show:false,
			strokeDashArray: 6,
			borderColor: '#dadada',
		},
		yaxis: {
		  labels: {
			style: {
				colors: '#B5B5C3',
				fontSize: '12px',
				fontFamily: 'Poppins',
				fontWeight: 400
				
			},
			formatter: function (value) {
			  return value + "$";
			}
		  },
		},
        xaxis: {
          categories: [<?php
		 $fecha_actual = date_create();
		 for ($i = 29; $i >= 0; $i--) {
			 $fecha = date_modify(clone $fecha_actual, "-$i days");
			 echo '"' . date_format($fecha, 'd-m-Y') . '",';
		 }?>],
		  labels:{
			  style: {
				colors: '#B5B5C3',
				fontSize: '12px',
				fontFamily: 'Poppins',
				fontWeight: 400
				
			},
		  }
        },
		fill:{
			type:'solid',
			opacity:0.05
		},
        tooltip: {
          x: {
            format: 'dd/MM/yy HH:mm'
          },
        },
        };

        var chart = new ApexCharts(document.querySelector("#marketChart"), options);
        chart.render();
	}
	var currentChart = function(){
		 var options = {
          series: [85, 60, 67, 50],
          chart: {
          height: 315,
          type: 'radialBar',
        },
        plotOptions: {
          radialBar: {
				startAngle:-90,
			   endAngle: 90,
            dataLabels: {
              name: {
                fontSize: '22px',
              },
              value: {
                fontSize: '16px',
              },
            }
          },
        },
		stroke:{
			 lineCap: 'round',
		},
        labels: ['Income', 'Income', 'Imcome', 'Income'],
		 colors:['#ec8153', '#70b944','#498bd9','#6647bf'],
        };

        var chart = new ApexCharts(document.querySelector("#currentChart"), options);
        chart.render();
	}
	/* Function ============ */
		return {
			init:function(){
			},
			
			
			load:function(){
					marketChart();
					currentChart();
					recentContact();
					
			},
			
			resize:function(){
			}
		}
	
	}();

	
		
	jQuery(window).on('load',function(){
		setTimeout(function(){
			dzChartlist.load();
		}, 1000); 
		
	});

	jQuery(window).on('resize',function(){
		
		
	});     

})(jQuery);
		</script>
		<?php } } ?>