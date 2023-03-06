<?php require_once("header.php");
require_once TS_EXT.'inversionPrecio.php';
require_once TS_CLASS.'c.mercados.php';
require_once TS_CLASS.'c.instrumento.php';
$cMercado = new mercados();
$cInstrumento = new instrumento();
$moneda = new precio();
 ?>
		<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
			<div class="container-fluid">
				<div class="form-head mb-5">
					<h2 class="font-w600 mb-0">Mercados</h2>
				</div>
				<div class="row">
					<div class="col-xl-9 col-xxl-8">
						<div class="row">
							<div class="col-xl-12">
								<div class="card">
									<div class="card-header border-0 pb-0">
										<h4 class="mb-0 fs-20 text-black">Datos del Mercado Argentino</h4>
									</div>
									<div class="card-body">
										<div class="bg-success coin-holding flex-wrap">
											<div class="mb-2 coin-bx">
												<div class="d-flex align-items-center">
													<div class="ml-3">
														<h4 class="coin-font font-w600 mb-0 text-white"><?php print_r($moneda->precioCotizacion("bcra/circulante")["cotizacion_nombre"]); ?></h4>
														<p class="mb-0 text-white op-6">ARS</p>
													</div>
												</div>
											</div>
											<div class="mb-2">
												<div class="d-flex align-items-center">
													<div class="coin-bx-one">
														<svg width="33" height="35" viewbox="0 0 33 35" fill="none" xmlns="http://www.w3.org/2000/svg">
															<rect width="4.71425" height="34.5712" rx="2.35713" transform="matrix(-1 0 0 1 33 0)" fill="white"></rect>
															<rect width="4.71425" height="25.1427" rx="2.35713" transform="matrix(-1 0 0 1 23.5713 9.42853)" fill="white"></rect>
															<rect width="4.71425" height="10.9999" rx="2.35713" transform="matrix(-1 0 0 1 14.1436 23.5713)" fill="white"></rect>
															<rect width="5.31864" height="21.2746" rx="2.65932" transform="matrix(-1 0 0 1 5.31836 13.2966)" fill="white"></rect>
														</svg>
													</div>	
													<div class="ml-3">
														<h2 class="mb-0 text-white coin-font-1">$<?php print_r($moneda->precioCotizacion("bcra/circulante")["cotizacion_valor"]); ?></h2>
													</div>
												</div>
											</div>

										</div>
										<div class="bg-secondary coin-holding mt-4 flex-wrap">
											<div class="mb-2 coin-bx">
												<div class="d-flex align-items-center">
													<div class="ml-3">
														<h4 class="coin-font font-w600 mb-0 text-white"><?php print_r($moneda->precioCotizacion("bcra/reservas")["cotizacion_nombre"]); ?></h4>
														<p class="mb-0 text-white">USD</p>
													</div>
												</div>
											</div>
											<div class="mb-2">
												<div class="d-flex align-items-center">
													<div class="coin-bx-one">
														<svg width="33" height="35" viewbox="0 0 33 35" fill="none" xmlns="http://www.w3.org/2000/svg">
															<rect width="4.71425" height="34.5712" rx="2.35713" transform="matrix(-1 0 0 1 33 0)" fill="white"></rect>
															<rect width="4.71425" height="25.1427" rx="2.35713" transform="matrix(-1 0 0 1 23.5713 9.42853)" fill="white"></rect>
															<rect width="4.71425" height="10.9999" rx="2.35713" transform="matrix(-1 0 0 1 14.1436 23.5713)" fill="white"></rect>
															<rect width="5.31864" height="21.2746" rx="2.65932" transform="matrix(-1 0 0 1 5.31836 13.2966)" fill="white"></rect>
														</svg>
													</div>	
													<div class="ml-3">
														<h2 class="mb-0 text-white coin-font-1">U$D<?php print_r($moneda->precioCotizacion("bcra/reservas")["cotizacion_valor"]); ?></h2>
													</div>
												</div>
											</div>
										</div>
										<!--<div class="bg-warning coin-holding mt-4 flex-wrap">
											<div class="mb-2 coin-bx">
												<div class="d-flex align-items-center">
													<div>
														<svg width="60" height="60" viewbox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
															<path d="M30 0C13.4312 0 0 13.4312 0 30C0 46.5688 13.4312 60 30 60C46.5688 60 60 46.5688 60 30C60 13.4312 46.5688 0 30 0ZM30 54.375C16.5587 54.375 5.625 43.44 5.625 30C5.625 16.56 16.5587 5.625 30 5.625C43.4413 5.625 54.375 16.5587 54.375 30C54.375 43.4413 43.44 54.375 30 54.375Z" fill="white"></path>
															<path d="M31.5488 30.9737H27.61V36.825H31.5488C32.3438 36.825 33.0813 36.5025 33.5988 35.9612C34.14 35.4425 34.4625 34.7062 34.4625 33.8875C34.4638 32.2862 33.15 30.9737 31.5488 30.9737Z" fill="white"></path>
															<path d="M30 8.12496C17.9375 8.12496 8.125 17.9375 8.125 30C8.125 42.0625 17.9375 51.875 30 51.875C42.0625 51.875 51.875 42.0612 51.875 30C51.875 17.9387 42.0612 8.12496 30 8.12496ZM34.4512 40.13H31.8712V44.185H29.165V40.13H27.6787V44.185H24.96V40.13H20.18V37.585H22.8175V22.335H20.18V19.79H24.96V15.8162H27.6787V19.79H29.165V15.8162H31.8712V19.79H34.2212C35.5337 19.79 36.7437 20.3312 37.6075 21.195C38.4712 22.0587 39.0125 23.2687 39.0125 24.5812C39.0125 27.15 36.985 29.2462 34.4512 29.3612C37.4225 29.3612 39.8187 31.78 39.8187 34.7512C39.8187 37.7112 37.4237 40.13 34.4512 40.13Z" fill="white"></path>
															<path d="M33.2888 27.38C33.7613 26.9075 34.0488 26.2737 34.0488 25.56C34.0488 24.1437 32.8975 22.9912 31.48 22.9912H27.61V28.14H31.48C32.1825 28.14 32.8275 27.84 33.2888 27.38Z" fill="white"></path>
														</svg>
													</div>
													<div class="ml-3">
														<h4 class="coin-font font-w600 mb-0 text-white">BitCoin</h4>
														<p class="mb-0 text-white">BTH</p>
													</div>
												</div>
											</div>
											<div class="mb-2">
												<div class="d-flex align-items-center">
													<div class="coin-bx-one">
														<svg width="33" height="35" viewbox="0 0 33 35" fill="none" xmlns="http://www.w3.org/2000/svg">
															<rect width="4.71425" height="34.5712" rx="2.35713" transform="matrix(-1 0 0 1 33 0)" fill="white"></rect>
															<rect width="4.71425" height="25.1427" rx="2.35713" transform="matrix(-1 0 0 1 23.5713 9.42853)" fill="white"></rect>
															<rect width="4.71425" height="10.9999" rx="2.35713" transform="matrix(-1 0 0 1 14.1436 23.5713)" fill="white"></rect>
															<rect width="5.31864" height="21.2746" rx="2.65932" transform="matrix(-1 0 0 1 5.31836 13.2966)" fill="white"></rect>
														</svg>
													</div>	
													<div class="ml-3">
														<h2 class="mb-0 text-white coin-font-1">$667,224</h2>
													</div>
												</div>
											</div>
											<div class="mb-2">
												<div class="d-flex align-items-center">
													<svg width="21" height="14" viewbox="0 0 21 14" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path d="M1 13C1.91797 11.9157 4.89728 8.72772 6.5 7L12.5 10L19.5 1" stroke="#2BC155" stroke-width="2" stroke-linecap="round"></path>
													</svg>
													<p class="mb-0 ml-2 text-success">45%</p>
													<p class="mb-0 ml-2 font-w400 text-white">This Week</p>	
												</div>
											</div>
										</div>
										<div class="bg-primary coin-holding mt-4 flex-wrap">
											<div class="mb-2 coin-bx">
												<div class="d-flex align-items-center">
													<div>
														<svg width="60" height="60" viewbox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
															<path d="M30.5438 0.00501884C13.9681 -0.294993 0.305031 12.893 0.00501884 29.4562C-0.294993 46.0194 12.893 59.695 29.4562 59.995C46.0194 60.295 59.695 47.107 59.995 30.5313C60.295 13.9681 47.107 0.292531 30.5438 0.00501884ZM29.5562 54.3698C16.1182 54.1197 5.38024 42.9943 5.63025 29.5562C5.86776 16.1182 16.9932 5.38024 30.4313 5.61775C43.8818 5.86776 54.6073 16.9932 54.3698 30.4313C54.1322 43.8693 42.9943 54.6073 29.5562 54.3698Z" fill="white"></path>
															<path d="M30.3938 8.11785C18.3308 7.90534 8.34286 17.5432 8.13035 29.6062C8.0591 33.4014 8.97039 36.9903 10.623 40.1354H17.4995V18.602C17.4995 17.2857 19.2883 16.867 19.8696 18.0483L30 38.5629L40.1304 18.0495C40.7117 16.867 42.5005 17.2857 42.5005 18.602V40.1354H49.3558C50.8934 37.2128 51.8084 33.9127 51.8696 30.3938C52.0822 18.3308 42.4568 8.34286 30.3938 8.11785Z" fill="white"></path>
															<path d="M40.0004 41.3855V23.9573L31.12 41.9392C30.7 42.793 29.2987 42.793 28.8787 41.9392L19.9996 23.9573V41.3855C19.9996 42.0755 19.4408 42.6355 18.7495 42.6355H12.1855C16.0744 48.0995 22.3972 51.7346 29.6062 51.8696C37.1028 52.0022 43.7931 48.327 47.8395 42.6355H41.2505C40.5592 42.6355 40.0004 42.0755 40.0004 41.3855Z" fill="white"></path>
														</svg>
													</div>
													<div class="ml-3">
														<h4 class="coin-font font-w600 mb-0 text-white">Monero</h4>
														<p class="mb-0 text-white">XMR</p>
													</div>
												</div>
											</div>
											<div class="mb-2">
												<div class="d-flex align-items-center">
													<div class="coin-bx-one">
														<svg width="33" height="35" viewbox="0 0 33 35" fill="none" xmlns="http://www.w3.org/2000/svg">
															<rect width="4.71425" height="34.5712" rx="2.35713" transform="matrix(-1 0 0 1 33 0)" fill="white"></rect>
															<rect width="4.71425" height="25.1427" rx="2.35713" transform="matrix(-1 0 0 1 23.5713 9.42853)" fill="white"></rect>
															<rect width="4.71425" height="10.9999" rx="2.35713" transform="matrix(-1 0 0 1 14.1436 23.5713)" fill="white"></rect>
															<rect width="5.31864" height="21.2746" rx="2.65932" transform="matrix(-1 0 0 1 5.31836 13.2966)" fill="white"></rect>
														</svg>
													</div>	
													<div class="ml-3">
														<h2 class="mb-0 text-white coin-font-1">$24,098</h2>
													</div>
												</div>
											</div>
											<div class="mb-2">
												<div class="d-flex align-items-center">
													<svg width="21" height="14" viewbox="0 0 21 14" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path d="M1 13C1.91797 11.9157 4.89728 8.72772 6.5 7L12.5 10L19.5 1" stroke="#2BC155" stroke-width="2" stroke-linecap="round"></path>
													</svg>
													<p class="mb-0 ml-2 text-success">45%</p>
													<p class="mb-0 ml-2 font-w400 text-white">This Week</p>	
												</div>
											</div>
										</div>-->
									</div>
								</div>
							</div>
							<div class="col-xl-8 col-xxl-12">
								<div class="card">
									<div class="card-header pb-2 d-block d-sm-flex flex-wrap border-0">
										<div class="mb-3">
											<h4 class="fs-20 text-black">Instrumentos</h4>
											<p class="mb-0 fs-13">Ordenados segun su variacion diaria</p>
										</div>  
										<div class="card-action card-tabs mb-3 style-1">
											<ul class="nav nav-tabs" role="tablist">
												<li class="nav-item">
													<a class="nav-link active" data-toggle="tab" href="#ganadores">
														Ganadores	
													</a>
												</li>
												<li class="nav-item">
													<a class="nav-link" data-toggle="tab" href="#perdedores">
														Perdedores
													</a>
												</li>
											</ul>
										</div>
									</div>
									<div class="card-body tab-content p-0">
										<div class="tab-pane active show fade" id="ganadores">
											<div class="table-responsive">
												<table class="table shadow-hover card-table border-no tbl-btn short-one">
													<tbody>
													<?php $listadoganadores = $cMercado->mercadoGanadores("6");
													while ($rowGanadores = $listadoganadores->fetch(PDO::FETCH_ASSOC)) { ?>
														<tr>
															<td>
																<span>
																<img alt="image" width="50" src="<?php echo $rowGanadores["instrumento_imagen"]; ?>">
																</span>
															</td>
															<td>
																<span class="font-w600 text-black"><?php echo $rowGanadores["instrumento_nombre"]; ?></span>
															</td>
															<td>
																<span class="text-black"><?php echo $rowGanadores["instrumento_tipo"]; ?></span>
															</td>
															<td>
																<span class="font-w600 text-black"><?php echo $rowGanadores["instrumento_moneda"]." ".$rowGanadores["instrumento_ultimoPrecio"]; ?></span>
															</td>
															<td><a class="btn-link text-success float-right" href="javascript:void(0);"><?php echo $rowGanadores["instrumento_ultimoPrecioCambio"]; ?>%</a></td>
														</tr>
														<?php } ?>	
													</tbody>
												</table>
											</div>
										</div>
										<div class="tab-pane fade" id="perdedores">
											<div class="table-responsive">
											<table class="table shadow-hover card-table border-no tbl-btn short-one">
													<tbody>
													<?php $listadoganadores = $cMercado->mercadoPerdedores("6");
													while ($rowGanadores = $listadoganadores->fetch(PDO::FETCH_ASSOC)) { ?>
														<tr>
															<td>
																<span>
																<img alt="image" width="50" src="<?php echo $rowGanadores["instrumento_imagen"]; ?>">
																</span>
															</td>
															<td>
																<span class="font-w600 text-black"><?php echo $rowGanadores["instrumento_nombre"]; ?></span>
															</td>
															<td>
																<span class="text-black"><?php echo $rowGanadores["instrumento_tipo"]; ?></span>
															</td>
															<td>
																<span class="font-w600 text-black"><?php echo $rowGanadores["instrumento_moneda"]." ".$rowGanadores["instrumento_ultimoPrecio"]; ?></span>
															</td>
															<td><a class="btn-link text-error float-right" href="javascript:void(0);"><?php echo $rowGanadores["instrumento_ultimoPrecioCambio"]; ?>%</a></td>
														</tr>
														<?php } ?>	
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<div class="card-footer border-0 p-0 caret mt-1">
										<a href="listadoInstrumentos" class="btn-link"><i class="fa fa-caret-down" aria-hidden="true"></i></a>
									</div>
								</div>	
							</div>
							<div class="col-xl-4 col-xxl-12">
								<div class="row">
									<div class="col-xl-12 m-t25">
										<div class="card">
											<div class="card-header border-0">
												<h4 class="mb-0 fs-20">Precio Dolar</h4>
											</div>
											<div class="card-body pb-0">
								<ul class="list-group list-group-flush">
									<li class="list-group-item d-flex px-0 justify-content-between">
										<strong>Tipo</strong>
										<span class="mb-0">Compra</span>
										<span class="mb-0">Venta</span>
									</li>
									<li class="list-group-item d-flex px-0 justify-content-between">
										<strong>Oficial</strong>
										<span class="mb-0"><?php print_r($moneda->precioCotizacion("dolaroficial")["cotizacion_compra"]); ?></span>
										<span class="mb-0"><?php print_r($moneda->precioCotizacion("dolaroficial")["cotizacion_venta"]); ?></span>
									</li>
									<li class="list-group-item d-flex px-0 justify-content-between">
										<strong>Turista</strong>
										<span class="mb-0"><?php print_r($moneda->precioCotizacion("dolarturista")["cotizacion_compra"]); ?></span>
										<span class="mb-0"><?php print_r($moneda->precioCotizacion("dolarturista")["cotizacion_venta"]); ?></span>
									</li>
									<li class="list-group-item d-flex px-0 justify-content-between">
										<strong>Blue</strong>
										<span class="mb-0"><?php print_r($moneda->precioCotizacion("dolarblue")["cotizacion_compra"]); ?></span>
										<span class="mb-0"><?php print_r($moneda->precioCotizacion("dolarblue")["cotizacion_venta"]); ?></span>
									</li>
									<li class="list-group-item d-flex px-0 justify-content-between">
										<strong>CCL</strong>
										<span class="mb-0"><?php print_r($moneda->precioCotizacion("contadoliqui")["cotizacion_compra"]); ?></span>
										<span class="mb-0"><?php print_r($moneda->precioCotizacion("contadoliqui")["cotizacion_venta"]); ?></span>
									</li>
									<li class="list-group-item d-flex px-0 justify-content-between">
										<strong>MEP</strong>
										<span class="mb-0"><?php print_r($moneda->precioCotizacion("dolarbolsa")["cotizacion_compra"]); ?></span>
										<span class="mb-0"><?php print_r($moneda->precioCotizacion("dolarbolsa")["cotizacion_venta"]); ?></span>
									</li>
								</ul>
                            </div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-xxl-4">
						<div class="row">
						<div class="col-xl-12 col-lg-6 col-sm-6">
                        		<div class="card border-0 pb-0">
                           			<div class="card-header border-0 pb-0">
                            		    <h4 class="card-title">iNDICES</h4>
                            		</div>
                            		<div class="card-body"> 
                                		<div id="DZ_W_Todo1" class="widget-media dz-scroll height370 ps ps--active-y">
                                    		<ul class="timeline">
												<?php $listadoindices = $cInstrumento->getInstrumentoTipo("indice",[0,20]);
													while ($rowIndice = $listadoindices->fetch(PDO::FETCH_ASSOC)) { ?>
                                        		<li>
                                            		<div class="timeline-panel">
														<div class="media me-2">
															<img alt="image" width="50" src="<?php echo $rowIndice["instrumento_imagen"]; ?>">
														</div>
                                                		<div class="media-body">
															<small class="mb-1"><?php echo "[".$rowIndice["instrumento_sigla"]."] ".$rowIndice["instrumento_nombre"]; ?></small>
														</div>
														
														<?php if($rowIndice["instrumento_ultimoPrecioCambio"]>0){
                                                    			echo '<div class="btn btn-success light sharp" data-bs-toggle="dropdown">'.$rowIndice["instrumento_moneda"].$rowIndice["instrumento_ultimoPrecio"].' ('.number_format((float)$rowIndice["instrumento_ultimoPrecioCambio"], 2, ".", "").'%)</div>';
                                                			}elseif($rowIndice["instrumento_ultimoPrecioCambio"]<0){
                                                   				 echo '<div class="btn btn-danger light sharp" data-bs-toggle="dropdown">'.$rowIndice["instrumento_moneda"].$rowIndice["instrumento_ultimoPrecio"].' ('.number_format((float)$rowIndice["instrumento_ultimoPrecioCambio"], 2, ".", "").'%)</div>';
                                                			}else{
                                                    			echo '<div class="btn btn-dark light sharp" data-bs-toggle="dropdown">'.$rowIndice["instrumento_moneda"].$rowIndice["instrumento_ultimoPrecio"].' ('.number_format((float)$rowIndice["instrumento_ultimoPrecioCambio"], 2, ".", "").'%)</div>';
                                                		}?>
														
													</div>
												</li>
												<?php } ?>
                                    		</ul>
                                		<div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; height: 370px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 299px;"></div></div></div>
                            		</div>
                        		</div>
						</div>
						<div class="col-xl-12 col-lg-6 col-sm-6">
                        		<div class="card border-0 pb-0">
                           			<div class="card-header border-0 pb-0">
                            		    <h4 class="card-title">COMMODITIES</h4>
                            		</div>
                            		<div class="card-body"> 
                                		<div id="DZ_W_Todo2" class="widget-media dz-scroll height370 ps ps--active-y">
                                    		<ul class="timeline">
											<?php $listadocommodities = $cInstrumento->getInstrumentoTipo("commodities",[0,20]);
													while ($rowCommodities = $listadocommodities->fetch(PDO::FETCH_ASSOC)) { ?>
                                        		<li>
                                            		<div class="timeline-panel">
														<div class="media me-2">
															<img alt="image" width="50" src="<?php echo $rowCommodities["instrumento_imagen"]; ?>">
														</div>
                                                		<div class="media-body">
															<small class="mb-1"><?php echo 
															$rowCommodities["instrumento_nombre"]; ?></small>
														</div>
														
														<?php if($rowCommodities["instrumento_ultimoPrecioCambio"]>0){
                                                    			echo '<div class="btn btn-success light sharp" data-bs-toggle="dropdown">'.$rowCommodities["instrumento_moneda"].$rowCommodities["instrumento_ultimoPrecio"].' ('.number_format((float)$rowCommodities["instrumento_ultimoPrecioCambio"], 2, ".", "").'%)</div>';
                                                			}elseif($rowCommodities["instrumento_ultimoPrecioCambio"]<0){
                                                   				 echo '<div class="btn btn-danger light sharp" data-bs-toggle="dropdown">'.$rowCommodities["instrumento_moneda"].$rowCommodities["instrumento_ultimoPrecio"].' ('.number_format((float)$rowCommodities["instrumento_ultimoPrecioCambio"], 2, ".", "").'%)</div>';
                                                			}else{
                                                    			echo '<div class="btn btn-dark light sharp" data-bs-toggle="dropdown">'.$rowCommodities["instrumento_moneda"].$rowCommodities["instrumento_ultimoPrecio"].' ('.number_format((float)$rowCommodities["instrumento_ultimoPrecioCambio"], 2, ".", "").'%)</div>';
                                                		}?>
														
													</div>
												</li>
												<?php } ?>
                                    		</ul>
                                		<div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; height: 370px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 299px;"></div></div></div>
                            		</div>
                        		</div>
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
<?php require_once("footer.php"); ?>