<?php require ("header.php"); 
require_once TS_CLASS.'c.instrumento.php';
$cInstrumento = new instrumento();
$datosInstrumento = $cInstrumento->getInstrumentoSigla($_GET["instrumento"]);	
?>
<div class="content-body">
			<div class="container-fluid">
				<div class=" form-head d-flex flex-wrap mb-4 align-items-center">
					<h2 class="text-black mr-auto font-w600 mb-3">Detalle de la Moneda</h2>
				</div>
				<div class="tab-content">
					<div class="tab-pane fade show active">
						<div class="row">
							<div class="col-xl-3 col-xxl-4 mt-4">
								<div class="card">
									<div class="card-header pb-0 border-0">
										<h4 class="mb-0 text-black fs-20">Acerca</h4>
										<div class="dropdown custom-dropdown mb-0">
											<div class="btn sharp pr-0 tp-btn" data-toggle="dropdown">
												<svg width="25" height="24" viewbox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M12.0049 13C12.5572 13 13.0049 12.5523 13.0049 12C13.0049 11.4477 12.5572 11 12.0049 11C11.4526 11 11.0049 11.4477 11.0049 12C11.0049 12.5523 11.4526 13 12.0049 13Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
													<path d="M12.0049 6C12.5572 6 13.0049 5.55228 13.0049 5C13.0049 4.44772 12.5572 4 12.0049 4C11.4526 4 11.0049 4.44772 11.0049 5C11.0049 5.55228 11.4526 6 12.0049 6Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
													<path d="M12.0049 20C12.5572 20 13.0049 19.5523 13.0049 19C13.0049 18.4477 12.5572 18 12.0049 18C11.4526 18 11.0049 18.4477 11.0049 19C11.0049 19.5523 11.4526 20 12.0049 20Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
												</svg>
											</div>
											
										</div>
									</div>
									<div class="card-body height400 dz-scroll" id="about-1">
										<div class="d-flex align-items-start mb-3 about-coin">
											<div>
												<img width="154" height="154" src="<?php echo $datosInstrumento["instrumento_imagen"]; ?>" alt="">
											</div>
											<div class="ml-3">
												<h2 class="font-w600 text-black mb-0 title"><?php echo $datosInstrumento["instrumento_nombre"]; ?></h2>
												<p class="font-w600 text-black sub-title"><?php echo $datosInstrumento["instrumento_sigla"]; ?></p>
												<span>1 <?php echo $datosInstrumento["instrumento_sigla"]; ?> = <?php echo $datosInstrumento["instrumento_ultimoPrecio"]; ?> <?php echo $datosInstrumento["instrumento_moneda"]; ?></span>
											</div>	
										</div>
										<p class="fs-14"><?php echo $datosInstrumento["instrumento_descripcion"]; ?>.</p>
									</div>
									<div class="card-footer border-0 p-0 caret">
										<a href="" class="btn-link"><i class="fa fa-caret-down" aria-hidden="true"></i></a>
									</div>
								</div>
							</div>
							<div class="col-xl-9 col-xxl-8 mt-4">
								<div class="card">
									<div class="card-body pb-0 pt-sm-3 pt-0">
										<div class="row sp20 mb-4 align-items-center">
											<div class="col-lg-4 col-xxl-4 col-sm-4 d-flex flex-wrap align-items-center">
												<div class="px-2 info-group">
													<p class="fs-18 mb-1">Precio</p>
													<h2 class="fs-28 font-w600 text-black"><?php echo $datosInstrumento["instrumento_ultimoPrecio"]; ?> <?php echo $datosInstrumento["instrumento_moneda"]; ?></h2>
												</div>
											</div>
											<div class="d-flex col-lg-8 col-xxl-8 col-sm-8 align-items-center mt-sm-0 mt-3 justify-content-end">
												<div class="px-2 info-group">
													<p class="fs-14 mb-1">24h% Cambio</p>
													<?php if($datosInstrumento["instrumento_ultimoPrecioCambio"]>0){
														echo '<h3 class="fs-20 font-w600"><span class="text-success">'.$datosInstrumento["instrumento_ultimoPrecioCambio"].'%</span>
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
									</svg';
													}elseif($datosInstrumento["instrumento_ultimoPrecioCambio"]<0){
														echo '<h3 class="fs-20 font-w600"><span class="text-danger">'.$datosInstrumento["instrumento_ultimoPrecioCambio"].'%</span>
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
									</svg>';
													}else{
														echo '<h3 class="fs-20 font-w600"><span class="text-dark">'.$datosInstrumento["instrumento_ultimoPrecioCambio"].'%</span>
														<svg width="14" height="14" viewbox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
														
														</svg>';
													}?>
													</h3>
												</div>
												<div class="px-2 info-group">
													<p class="fs-14 mb-1">Volumen (24h)</p>
													<h3 class="fs-20 font-w600 text-black">$0</h3>
												</div>
												<div class="px-2 info-group">
													<p class="fs-14 mb-1">Market Cap</p>
													<h3 class="fs-20 font-w600 text-black">$0</h3>
												</div>
											</div>
										</div>
										<!-- TradingView Widget BEGIN -->
<div class="tradingview-widget-container">
  <div id="tradingview_6dd1f"></div>
  <div class="tradingview-widget-copyright"><a href="https://es.tradingview.com/" rel="noopener" target="_blank"><span class="blue-text"><?php echo $datosInstrumento["instrumento_sigla"]; ?> Gráfico</span></a> por TradingView</div>
  <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
  <script type="text/javascript">
  new TradingView.widget(
  {

  <?php if($datosInstrumento["instrumento_tipo"] == "criptomoneda"){ 
  echo '"symbol": "BINANCE:'.$datosInstrumento["instrumento_sigla"].'USDT",';
 }else{
 	echo '"symbol": "NASDAQ:'.$datosInstrumento["instrumento_sigla"].'"';
 } ?>,
  "interval": "D",
  "timezone": "Etc/UTC",
  "theme": "light",
  "style": "1",
  "locale": "es",
  "toolbar_bg": "#f1f3f6",
  "enable_publishing": false,
  "allow_symbol_change": true,
  "container_id": "tradingview_6dd1f"
}
  );
  </script>
</div>

<!-- TradingView Widget END -->
									</div>
								</div>
							</div>

							<div class="col-sm-6">
										<div class="card">
											<div class="card-header border-0 pb-0">
												<h4 class="mb-0 text-black fs-20">Moneda En Portfolio</h4>
											</div>
											<div class="card-body p-3">
												<div class="table-responsive">
													<table class="table text-center bg-success-hover tr-rounded order-tbl">
														<thead>
															<tr>
																<th class="text-start">Wallet</th>
																<th class="text-center">Cantidad</th>
																<th class="text-end">Total</th>
															</tr>
														</thead>
														<tbody>
  															<?php $listWallet = $cInstrumento->getWalletByInstrumento($user->userData()["user_id"], $_GET["instrumento"]) ;
															while ($lWallet = $listWallet->fetch(PDO::FETCH_ASSOC)) {
																echo '<tr>
																<td class="text-start"><a href="wallet?opc=wallet&objetivo='.$lWallet["wallet_id"].'">'.$lWallet["wallet_nombre"].'</a></td>
																<td>'.$lWallet["Wportfolio_cantidad"].'</td>
																<td class="text-end">'.$lWallet["instrumento_moneda"].' '.$lWallet["Wportfolio_cantidad"]*$lWallet["instrumento_ultimoPrecio"].'</td>
															</tr>';
																# code...
															}
																?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
									
									<div class="col-sm-6">
										<div class="card">
											<div class="card-header border-0 pb-0">
												<h4 class="mb-0 text-black fs-20">Ultimos movimientos</h4>
											</div>
											<div class="card-body p-3">
												<div class="table-responsive">
													<table class="table text-center tr-rounded order-tbl">
														<thead>
															<tr>
																<th class="text-start">Wallet</th>
																<th class="text-center">Cantidad</th>
																<th class="text-center">Operacion</th>
																<th class="text-end">Precio Operacion</th>
																<th class="text-end">Fecha</th>
															</tr>
														</thead>
														<tbody>
  															<?php $listMovimientos = $cInstrumento->getMovimientosByInstrumento($user->userData()["user_id"], $_GET["instrumento"]) ;
															while ($lMovimientos = $listMovimientos->fetch(PDO::FETCH_ASSOC)) {
																echo '<tr>
																<td class="text-start"><a href="wallet?opc=wallet&objetivo='.$lMovimientos["wallet_id"].'">'.$lMovimientos["wallet_nombre"].'</a></td>
																<td>'.$lMovimientos["Wmovimientos_cantidad"].'</td>
																<td class="text-end">'.$lMovimientos["Wmovimientos_operacion"].'</td>
																<td class="text-end">$'.$lMovimientos["Wmovimientos_precio"].'</td>
																<td class="text-end">'.$lMovimientos["Wmovimientos_fecha"].'</td>
															</tr>';
																# code...
															}
																?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>

						</div>
					</div>

				</div>
            </div>
		</div>

<?php require ("footer.php"); ?>