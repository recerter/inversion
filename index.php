<?php require ("header.php"); 
if($user->userData()["user_rango"]=='0'){
$util->redirect2("terminarRegistro.php");
}
require_once TS_CLASS.'c.instrumento.php';
require_once TS_CLASS.'c.wallet.php';
require_once TS_EXT.'inversionPrecio.php';
$cInstrumento = new instrumento();
$cWallet = new wallet();
$moneda = new precio();
$db_handle = new DBController();
$con = $db_handle->connectDB();
$hoy = date('d-m-Y');
?>
		<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
			<div class="container-fluid">
				<div class="form-head mb-sm-5 mb-3 d-flex flex-wrap align-items-center">
					<h2 class="font-w600 title mb-2 mr-auto ">Dashboard</h2>

					<div class="weather-btn mb-2">
						<span class="mr-3 font-w600 text-black">Riesgo Pais</span>
						<div class="style-1 default-select mr-3 "><?php print_r($moneda->precioCotizacion("riesgopais")["cotizacion_valor"]); ?></div>
					</div>

					<div class="weather-btn mb-2">
						<span class="mr-3 font-w600 text-black"><i class="fa fa-usd mr-2"></i>Dolar</span>
						<div class="style-1 default-select mr-3 "><?php print_r($moneda->precioCotizacion("dolaroficial")["cotizacion_venta"]); ?></div>
					</div>
					<div class="weather-btn mb-2">
						<span class="mr-3 font-w600 text-black"><i class="fa fa-usd mr-2"></i>Dolar Informal</span>
						<div class="style-1 default-select mr-3 "><?php print_r($moneda->precioCotizacion("dolarblue")["cotizacion_venta"]); ?></div>
					</div>

					<div class="weather-btn mb-2">
						<a href="favoritos.php"><span class="mr-3 font-w600 text-black"><i class="fa fa-cog mr-2"></i>Editar Favoritos</span></a>
					</div>
				</div>
				<div class="row">
					<?php 
					for($i=1; $i <=4; $i++){ 
						$usuario_favoritos = $cUsuario->getMemberInversionById($user->userData()["user_id"]);
						$moneda_buscar = $cInstrumento->getInstrumentoId($usuario_favoritos["iUsuarios_favorito$i"]);
						$moneda_precio = $moneda_buscar["instrumento_ultimoPrecio"];
						$moneda_variacion = $moneda_buscar["instrumento_ultimoPrecioCambio"];
						?>
						<div class="col-xl-3 col-sm-6 m-t35">
						<div class="card card-coin">
							<a href="monedaDetalle?instrumento=<?php echo $moneda_buscar["instrumento_sigla"];?>">
							<div class="card-body text-center">
								<img class="mb-3 currency-icon" width="80" height="80" src="<?php echo $moneda_buscar["instrumento_imagen"]?>">
								
								<h2 class="text-black mb-2 font-w600"><?php echo ''.$moneda_buscar["instrumento_moneda"].' '.$moneda_precio.''; ?></h2></a>
								<p class="mb-0 fs-14">
									<?php if ($moneda_variacion<0){ ?>
									<svg width="29" height="22" viewbox="0 0 29 22" fill="none" xmlns="http://www.w3.org/2000/svg">
										<g filter="url(#filter0_d4)">
										<path d="M5 4C5.91797 5.08433 8.89728 8.27228 10.5 10L16.5 7L23.5 16" stroke="#FF2E2E" stroke-width="2" stroke-linecap="round"></path>
										</g>
										<defs>
										<filter id="filter0_d4" x="-3.05176e-05" y="0" width="28.5001" height="22.0001" filterunits="userSpaceOnUse" color-interpolation-filters="sRGB">
										<feflood flood-opacity="0" result="BackgroundImageFix"></feflood>
										<fecolormatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"></fecolormatrix>
										<feoffset dy="1"></feoffset>
										<fegaussianblur stddeviation="2"></fegaussianblur>
										<fecolormatrix type="matrix" values="0 0 0 0 1 0 0 0 0 0.180392 0 0 0 0 0.180392 0 0 0 0.61 0"></fecolormatrix>
										<feblend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow"></feblend>
										<feblend mode="normal" in="SourceGraphic" in2="effect1_dropShadow" result="shape"></feblend>
										</filter>
										</defs>
									</svg>
								<?php }else{ ?>
									<svg width="29" height="22" viewbox="0 0 29 22" fill="none" xmlns="http://www.w3.org/2000/svg">
										<g filter="url(#filter0_d2)">
										<path d="M5 16C5.91797 14.9157 8.89728 11.7277 10.5 10L16.5 13L23.5 4" stroke="#2BC155" stroke-width="2" stroke-linecap="round"></path>
										</g>
										<defs>
										<filter id="filter0_d2" x="-3.05176e-05" y="-6.10352e-05" width="28.5001" height="22.0001" filterunits="userSpaceOnUse" color-interpolation-filters="sRGB">
										<feflood flood-opacity="0" result="BackgroundImageFix"></feflood>
										<fecolormatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"></fecolormatrix>
										<feoffset dy="1"></feoffset>
										<fegaussianblur stddeviation="2"></fegaussianblur>
										<fecolormatrix type="matrix" values="0 0 0 0 0.172549 0 0 0 0 0.72549 0 0 0 0 0.337255 0 0 0 0.61 0"></fecolormatrix>
										<feblend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow"></feblend>
										<feblend mode="normal" in="SourceGraphic" in2="effect1_dropShadow" result="shape"></feblend>
										</filter>
										</defs>
									</svg>
								<?php } ?>
									<?php 
										if ($moneda_variacion<0){
											echo '<span class="text-danger mr-1">';
										}else{
											echo '<span class="text-success mr-1">';
										} 
										echo number_format((float)$moneda_variacion, 2, '.', '');?>%</span>En 24Hs
								</p>	
							</div>
						</div>
					</div>
				
					<?php } ?>
				</div>
				<div class="row">
					<div class="col-xl-9 col-xxl-8">
						<div class="card">
							<div class="card-header border-0 flex-wrap pb-0">
								<div class="mb-3">
									<h4 class="fs-20 text-black">Tenencia Total</h4>
									<p class="mb-0 fs-12 text-black">Tenencia total de todos los objetivos</p>
								</div><p class="mb-0 fs-14">
								<?php
			$fecha = date('d-m-Y', strtotime($hoy.'- 1 days'));
			$fecha_day = date('d', strtotime($fecha));
			$fecha_month = date('m', strtotime($fecha));
			$fecha_year = date('Y', strtotime($fecha));
			
			$query = "SELECT sum(inversion_tenenciawallet.tWallet_tenencia) 
					  FROM inversion_tenenciawallet 
					  WHERE YEAR(inversion_tenenciawallet.tWallet_fecha) = :year 
					  AND DAY(inversion_tenenciawallet.tWallet_fecha) = :day 
					  AND MONTH(inversion_tenenciawallet.tWallet_fecha) = :month 
					  AND inversion_tenenciawallet.tWallet_user = :user_id";
			
			$stmt = $con->prepare($query);
			$stmt->bindParam(":year", $fecha_year);
			$stmt->bindParam(":day", $fecha_day);
			$stmt->bindParam(":month", $fecha_month);
			$stmt->bindParam(":user_id", $user->userData()["user_id"]);
			
			$stmt->execute();
			$tenenciawallet = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if ($tenenciawallet) {
				$tenenciaTotalAyer = $tenenciawallet["sum(inversion_tenenciawallet.tWallet_tenencia)"];
			} else {
				$tenenciaTotalAyer = 0;
			}
			
			$tenenciaTotalHoy = number_format($cWallet->getSaldoTotal($user->userData()["user_id"]), 2, '.', '');
			
			try {
				$porcentajeDiarioCartera = number_format((($tenenciaTotalHoy*100)/$tenenciaTotalAyer)-100, 2, '.', '');
			} catch (DivisionByZeroError $e) {
				$porcentajeDiarioCartera = 100;
			}
		  if ($porcentajeDiarioCartera<0){
			echo '<span class="text-danger mr-1">';
		}else{
			echo '<span class="text-success mr-1">';
		}  
		echo $porcentajeDiarioCartera.'% ('. number_format($tenenciaTotalHoy-$tenenciaTotalAyer, 2, ',', '.').' $)</span> Cartera en 24hs</p>';?></div>
							<div class="card-body pb-2 px-3">
								<div id="marketChart" class="market-line"></div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-xxl-4">
                        <div class="card">
                            <div class="card-header border-0 pb-0">
                                <h4 class="card-title">Panel de ultimos Movimientos</h4>
                            </div>
                            <div class="card-body">
                                <div id="DZ_W_TimeLine111" class="widget-timeline dz-scroll style-1 height370">
                                    <ul class="timeline">
									<?php
										$inversion_log = $con->prepare("SELECT * FROM inversion_log WHERE log_usuario = :user_id ORDER BY log_id DESC LIMIT 10");
										$inversion_log->bindParam(':user_id', $user->userData()['user_id'], PDO::PARAM_INT);
										$inversion_log->execute();
										while($log = $inversion_log->fetch(PDO::FETCH_ASSOC)){ ?>

                                        <li>
                                            <div class="timeline-badge primary"></div>
                                            <a class="timeline-panel text-muted" href="#">
                                                <span><?php
												 echo $util->time_elapsed_string($log["log_fecha"]); ?></span>
                                                <h6 class="mb-0"><?php echo $log["log_descripcion"];?>.</h6>
                                            </a>
                                        </li>
										<?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
					</div>
				</div>
				<div class="row">
					<div class="col-xl-6 col-xxl-12">
								<div class="card">
									<div class="card-header pb-2 d-block d-sm-flex flex-wrap border-0">
										<div class="mb-3">
											<h4 class="fs-20 text-black">Ultimos Movimientos en Wallet</h4>
											<p class="mb-0 fs-12"></p>
										</div>
									</div>
									<div class="card-body tab-content p-0">
										<div class="tab-pane active show fade" id="monthly">
											<div class="table-responsive">
												<table class="table shadow-hover card-table border-no tbl-btn short-one">
													<tbody>
														<?php
                                            $instrumentos = $con->prepare("SELECT inversion_walletmovimientos.Wmovimientos_instrumento, inversion_instrumentos.instrumento_sigla,inversion_walletmovimientos.Wmovimientos_wallet, inversion_wallet.wallet_id, inversion_walletmovimientos.Wmovimientos_operacion, inversion_walletmovimientos.Wmovimientos_instrumento, inversion_walletmovimientos.Wmovimientos_fecha, inversion_walletmovimientos.Wmovimientos_precio, inversion_walletmovimientos.Wmovimientos_cantidad, inversion_instrumentos.instrumento_moneda, inversion_instrumentos.instrumento_imagen FROM inversion_walletmovimientos, inversion_wallet, inversion_instrumentos WHERE inversion_walletmovimientos.Wmovimientos_instrumento = inversion_instrumentos.instrumento_sigla AND inversion_walletmovimientos.Wmovimientos_wallet = inversion_wallet.wallet_id AND inversion_wallet.wallet_user =  :user_id ORDER BY inversion_walletmovimientos.Wmovimientos_id DESC LIMIT 7");
											$instrumentos->bindParam(':user_id', $user->userData()['user_id'], PDO::PARAM_INT);
											$instrumentos->execute();
                                            while($instrumento = $instrumentos->fetch(PDO::FETCH_ASSOC)){  ?>
														<tr>
															<td>

																<span>
																	<?php if ($instrumento["Wmovimientos_operacion"] == "compra"){
																		echo '<svg width="50" height="50" viewbox="0 0 63 63" fill="none" xmlns="http://www.w3.org/2000/svg">
																		<rect width="63" height="63" rx="14" fill="#71B945"></rect>
																		<path d="M40.6186 32.7207L40.6186 32.7207L40.6353 39.6289C40.6354 39.6328 40.6354 39.6363 40.6353 39.6396M40.6186 32.7207L40.1353 39.6341L40.6353 39.635C40.6353 39.6481 40.6347 39.6583 40.6345 39.6627L40.6344 39.6642C40.6346 39.6609 40.6351 39.652 40.6353 39.6407C40.6353 39.6403 40.6353 39.64 40.6353 39.6396M40.6186 32.7207C40.6167 31.9268 39.9717 31.2847 39.1777 31.2866C38.3838 31.2885 37.7417 31.9336 37.7436 32.7275L37.7436 32.7275L37.7519 36.1563M40.6186 32.7207L37.7519 36.1563M40.6353 39.6396C40.6329 40.4282 39.9931 41.0705 39.2017 41.0726C39.2 41.0726 39.1983 41.0727 39.1965 41.0727L39.1944 41.0727L39.1773 41.0726L32.2834 41.056L32.2846 40.556L32.2834 41.056C31.4897 41.054 30.8474 40.4091 30.8494 39.615C30.8513 38.8211 31.4964 38.179 32.2903 38.1809L32.2903 38.1809L35.719 38.1892L22.5364 25.0066C21.975 24.4452 21.975 23.5351 22.5364 22.9737C23.0978 22.4123 24.0079 22.4123 24.5693 22.9737L37.7519 36.1563M40.6353 39.6396C40.6353 39.6376 40.6353 39.6356 40.6353 39.6336L37.7519 36.1563M39.1964 41.0726C39.1957 41.0726 39.1951 41.0726 39.1944 41.0726L39.1964 41.0726Z" fill="white" stroke="white"></path>
																	</svg>';
																	}else{
																		echo '<svg width="50" height="50" viewbox="0 0 63 63" fill="none" xmlns="http://www.w3.org/2000/svg">
																		<rect width="63" height="63" rx="14" fill="#FF5757"></rect>
																		<path d="M22.1318 30.9043L22.1318 30.9043L22.1151 23.9961C22.1151 23.9922 22.1151 23.9887 22.1152 23.9854M22.1318 30.9043L22.6152 23.9909L22.1152 23.99C22.1152 23.9769 22.1157 23.9667 22.116 23.9623L22.1161 23.9608C22.1159 23.9641 22.1154 23.973 22.1152 23.9843C22.1152 23.9847 22.1152 23.985 22.1152 23.9854M22.1318 30.9043C22.1338 31.6982 22.7788 32.3403 23.5728 32.3384C24.3667 32.3365 25.0088 31.6914 25.0069 30.8975L25.0069 30.8975L24.9986 27.4687M22.1318 30.9043L24.9986 27.4687M22.1152 23.9854C22.1176 23.1968 22.7574 22.5545 23.5488 22.5524C23.5504 22.5524 23.5522 22.5523 23.554 22.5523L23.5561 22.5523L23.5732 22.5524L30.4671 22.569L30.4658 23.069L30.4671 22.569C31.2608 22.571 31.903 23.2159 31.9011 24.01C31.8992 24.8039 31.2541 25.446 30.4602 25.4441L30.4602 25.4441L27.0315 25.4358L40.2141 38.6184C40.7755 39.1798 40.7755 40.0899 40.2141 40.6513C39.6527 41.2127 38.7426 41.2127 38.1812 40.6513L24.9986 27.4687M22.1152 23.9854C22.1152 23.9874 22.1152 23.9894 22.1152 23.9914L24.9986 27.4687M23.5541 22.5524C23.5547 22.5524 23.5554 22.5524 23.5561 22.5524L23.5541 22.5524Z" fill="white" stroke="white"></path>
																	</svg>';
																	} ?>
																</span>
															</td>
															<td class="wspace-no">
																<img width="40" src="<?php echo $instrumento["instrumento_imagen"];?>">
																<span class="font-w600 text-black"><?php echo $instrumento["Wmovimientos_instrumento"]; ?></span>
															</td>
															<td>
																<span class="text-black"><?php echo $instrumento["Wmovimientos_fecha"]; ?></span>
															</td>
															<td>
																<span class="font-w600 text-black"><?php echo $instrumento["instrumento_moneda"].' '.$instrumento["Wmovimientos_precio"]; ?> (<?php echo $instrumento["Wmovimientos_cantidad"]; ?>)</span>
															</td>
															<td><a class="btn btn-outline-success float-right" href="monedaDetalle?instrumento=<?php echo $instrumento["Wmovimientos_instrumento"];?>">Completado</a></td>
														</tr>
													<?php } ?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<div class="card-footer border-0 p-0 caret mt-1">
										<a href="movimientos" class="btn-link"><i class="fa fa-caret-down" aria-hidden="true"></i></a>
									</div>
								</div>
							
					</div>
					<div class="col-xl-6 col-xxl-12">
						<div class="row">
						<?php
						$user_id = $user->userData()['user_id'];
						$wallets = $con->prepare("SELECT * FROM inversion_wallet WHERE wallet_user = :user_id LIMIT 4");
						$wallets->bindParam(':user_id', $user_id);
						$wallets->execute();
						while($wallet = $wallets->fetch(PDO::FETCH_ASSOC)){ 
					?>
                            	<a href="wallet?opc=wallet&objetivo=<?php echo $wallet["wallet_id"]; ?>">
							<div class="col-sm-6">
								<div class="card-bx stacked card">
									<img src="<?php echo $util->reemplazar_imagen($wallet["wallet_imagen"],"http://inversiones.ovitec.com.ar/images/card/card1.jpg");?>" alt="">
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
									</a>
								</div>
							</div>
						<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
        <!--**********************************
            Content body end
        ***********************************-->
		
        <?php require("footer.php"); ?>
		<script>
			(function($) {
    "use strict"


 let dzChartlist = function(){
	
	let screenWidth = $(window).width();
	let marketChart = function(){
		 let options = {
          series: [{
          name: 'Tenencia',
          data: [<?php
$tenenciawallets = array();
for($i = 29; $i >= 1; $i--){
    $fecha = date('d-m-Y', strtotime($hoy.'- '.$i.' days'));
    $fecha_day = date('d', strtotime($fecha));
    $fecha_month = date('m', strtotime($fecha));
    $fecha_year = date('Y', strtotime($fecha));
    
    $stmt = $con->prepare("SELECT sum(inversion_tenenciawallet.tWallet_tenencia) 
                            FROM inversion_tenenciawallet 
                            WHERE YEAR(inversion_tenenciawallet.tWallet_fecha) = ? 
                              AND DAY(inversion_tenenciawallet.tWallet_fecha) = ? 
                              AND MONTH(inversion_tenenciawallet.tWallet_fecha) = ? 
                              AND inversion_tenenciawallet.tWallet_user = ?");
    $stmt->bindParam(1, $fecha_year, PDO::PARAM_INT);
    $stmt->bindParam(2, $fecha_day, PDO::PARAM_INT);
    $stmt->bindParam(3, $fecha_month, PDO::PARAM_INT);
    $stmt->bindParam(4, $user->userData()["user_id"], PDO::PARAM_INT);
    $stmt->execute();
    $tenenciawallet = $stmt->fetch(PDO::FETCH_NUM)[0] ?? 0;
    $stmt->closeCursor();

    $tenenciawallets[] = $tenenciawallet;
}
echo implode(',', array_map(function($tenencia) { 
    return '"' . number_format($tenencia, 2, '.', '') . '"'; 
}, $tenenciawallets)) . ", ".$tenenciaTotalHoy;



?>]
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
		  $hoy = date('d-m-Y');
		  for($i = 29; $i>=1; $i--){
			$fecha = date('d-m-Y', strtotime($hoy.'- '.$i.' days'));
			echo '"'.$fecha.'",';
		  } echo '"'.$hoy.'"';?>],
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

        let chart = new ApexCharts(document.querySelector("#currentChart"), options);
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