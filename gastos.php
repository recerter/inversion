<?php require ("header.php");
require_once TS_CLASS.'c.gasto.php';
$cGasto = new gasto(); 
if(!isset($_GET["gastoOpc"])){
    $_GET["gastoOpc"] = "inicio";
}
$Meses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
       if(isset($_GET["mes"])){
           $mesBusqueda = $_GET["mes"];
       }else{
        $mesBusqueda = date('Y-m');
       }

    if (isset($_POST["agregarConsumo"])) {
        $monto = $_POST["monto"];
        $monto = str_replace(",", '.', $monto);
        switch ($_POST["agregarConsumo"]) {
            case 'insertGastoDiario':
                $cGasto->insertGastodiario($user->userData()["user_id"], $_POST["descripcion"], $_POST["imagen"], $monto);
                break;
            case 'insertGastoFijo':
                $cGasto->insertGastofijo($user->userData()["user_id"], $_POST["descripcion"], $_POST["imagen"], $monto);
                break;
        case 'agregarConsumoTarjeta':
                $cGasto->insertTarjetaMovimiento($_POST["tarjeta"], $_POST["descripcion"], $monto, $_POST["fecha"], $_POST["tipoTarjeta"]);
                break;

        }
    }
	
       switch ($_GET["gastoOpc"]) {
        case 'diario':
            if(isset($_GET["opc"]) && isset($_GET["id"])){
                if($_GET["opc"] = "eliminar"){
                    $cGasto->deletGastodiario($_GET["id"], $user->userData()["user_id"]);
                }
                
            }
            break;
        case 'fijos':
        if(isset($_POST["modificarConsumo"])){
            $monto = str_replace ( ",", '.', $_POST["monto"]);
            $cGasto->updateGastofijo($_POST["id"], $user->userData()["user_id"], $monto);
            $util->redirect2("gastos?gastoOpc=fijos");
        }
    if(isset($_GET["opc"]) && isset($_GET["id"])){
        if($_GET["opc"] == "eliminar"){
            $cGasto->deletGastofijo($_GET["id"], $user->userData()["user_id"]);
        }
        
    }
    break;
    case 'tarjeta':
        if(isset($_POST["agregar"])){
	$cGasto->insertTarjeta($user->userData()["user_id"], $_POST["ultimosDigitos"], $_POST["vencimiento"], $_POST["nombreBanco"], $_POST["tipoTarjeta"], $_POST["limite"]);
        }
        break;

        default:
            # code...
            break;
       }

?>
        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <?php 
            switch ($_GET["gastoOpc"]) {
                case 'diario':
                    echo's
                    <div class="container-fluid">
				<div class="form-head mb-4 mb-sm-5 d-flex  flex-wrap align-items-center ">
					<h2 class="font-w600 mb-0 me-auto">Gastos Diarios</h2>
				</div>
				<div class="row">
				<div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Añadir Nuevo Gasto</h4>
                            </div>
							<form method="POST" action="'.$_SERVER["PHP_SELF"].'">
                            <div class="card-body">
                                <div class="row form-material">
                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                        <label class="form-label">Seleccione Icono</label>
                                		<div id="DZ_W_TimeLine" class="widget-timeline dz-scroll height100 width130 ps ps--active-y">';
                                        for($i=1;$i<=49;$i++){
												echo '<div class="radio">
                                                <label><input type="radio" name="imagen" value="'.$i.'"'; if($i == 1){ echo' checked'; } echo '> <img src="images/icons2/icon ('.$i.').png" width="20"> Icon'.$i.' </label>
                                            </div> ';
										}
                                echo'</div>
                         
                                    </div>
                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                        <label class="form-label">Descripcion</label>
                                        <input class="form-control" id="timepicker" placeholder="Descripcion" name="descripcion" data-dtp="dtp_9g2aT">
                                    </div>
									<div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                        <label class="form-label">Monto a pagar</label>
                                        <input class="form-control" id="timepicker" placeholder="Monto" name="monto" data-dtp="dtp_9g2aT">
                                    </div>
									
                                    <div class="col-xl-3 col-xxl-6 col-md-6">
                                        <label class="form-label"></label>
                                        <button name="agregarConsumo" type="submit" value="insertGastoDiario" class="btn btn-primary btn-block">Agregar</button>
                                    </div>
                                </div>
								
                            </div>
                        </div>
						</form>
                    </div>
					
					<div class="col-xl-12">
						<div class="table-responsive table-hover fs-14 ">
							<div id="example6_wrapper" class="dataTables_wrapper no-footer"><table class="table display mb-4 dataTablesCard font-w600 border-no card-table text-black dataTable no-footer" id="example6" role="grid" aria-describedby="example6_info">
								<thead>
									<tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example6" rowspan="1" colspan="1" aria-label="Rank: activate to sort column descending" style="width: 101.422px;" aria-sort="ascending"></th>
                                        <th class="sorting" tabindex="0" aria-controls="example6" rowspan="1" colspan="1" aria-label="Coin: activate to sort column ascending" style="width: 194.234px;">Detalle</th>
                                        <th class="sorting" tabindex="0" aria-controls="example6" rowspan="1" colspan="1" aria-label="Last Price: activate to sort column ascending" style="width: 139.484px;">Monto</th>
                                        <th class="sorting" tabindex="0" aria-controls="example6" rowspan="1" colspan="1" aria-label="Change (24h): activate to sort column ascending" style="width: 182.203px;">Porcentaje Respecto al sueldo</th>
                                        <th class="sorting" tabindex="0" aria-controls="example6" rowspan="1" colspan="1" aria-label="Volume (24h): activate to sort column ascending" style="width: 205.844px;">Fecha de modificacion</th>
                                        <th class="bg-none width50 sorting" tabindex="0" aria-controls="example6" rowspan="1" colspan="1" aria-label=": activate to sort column ascending" style="width: 50px;"></th>
                                    </tr>
								</thead>
								<tbody>';
								$contador = 0;
                                $gastoDiarios = $cGasto->gastosDariosListado($user->userData()["user_id"]);
							    while ($gDiario = $gastoDiarios->fetch(PDO::FETCH_ASSOC)) { 
								    $contador++;
								    echo'<tr role="row" class="odd">
										<td class="sorting_1">
											<span class="bgl-secondary rank-ic fs-20">#'.$contador.'</span>
										</td>
										<td class="wspace-no">
										<img src="images/icons2/icon ('.$gDiario["Gdiarios_imagen"].').png" class="rounded-lg mr-2" width="24" alt="">
											<span class="text-black">'.$gDiario["Gdiarios_descripcion"].'</span>	
										</td>
										<td class="">$'.$gDiario["Gdiarios_monto"].'</td>
										<td class="">0,00%</td>
										<td class="">'.$gDiario["Gdiarios_fecha"].'</td>
										<td>					
												<div class="d-flex">
                                                        <a href="gastos?gastoOpc=diario&opc=eliminar&id='.$gDiario["Gdiarios_id"].'" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                                    </div>
										</td>
									</tr>';
                                    }
                                echo'</tbody>
							</table></div>	
						</div>		
					</div>
				</div>
			</div>';
                     break;
                case 'fijos':
                    echo '<div class="container-fluid">
                    <div class="form-head mb-4 mb-sm-5 d-flex  flex-wrap align-items-center ">
                        <h2 class="font-w600 mb-0 me-auto">Gastos Fijos</h2>
                    </div>
                    <div class="row">';
                        if(isset($_GET["opc"]) && isset($_GET["id"]) && $_GET["gastoOpc"] == "fijos" && $_GET["opc"] == "editar"){
                    echo'<div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Modificar Monto</h4>
                                </div>
                                <form method="POST" action="gastos?gastoOpc=fijos">
                                <div class="card-body">
                                    <div class="row form-material">
                                        <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                        <input type="hidden" value="'.$_GET["id"].'" name="id">
                                            <label class="form-label">Monto a pagar</label>
                                            <input class="form-control" id="timepicker" placeholder="Monto" name="monto" data-dtp="dtp_9g2aT">
                                        </div>
                                        
                                        <div class="col-xl-3 col-xxl-6 col-md-6">
                                            <label class="form-label"></label>
                                            <button name="modificarConsumo" type="submit" value="insertGastoFijo" class="btn btn-primary btn-block">Modificar</button>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            </form>
                        </div>';
                            }
                    echo'<div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Añadir Nuevo Gasto</h4>
                                </div>
                                <form method="POST" action="'.$_SERVER["PHP_SELF"].'">
                                <div class="card-body">
                                    <div class="row form-material">
                                        <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                            <label class="form-label">Seleccione Icono</label>
                                            <div id="DZ_W_TimeLine" class="widget-timeline dz-scroll height100 width130 ps ps--active-y">';
                                            for($i=1;$i<=24;$i++){
                                                    echo '<div class="radio">
                                                    <label><input type="radio" name="imagen" value="'.$i.'"'; if($i == 1){ echo' checked'; } echo '> <img src="images/icons/icon ('.$i.').png" width="20"> Icon'.$i.' </label>
                                                </div> ';
                                            }
                                    echo'</div>
                             
                                        </div>
                                        <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                            <label class="form-label">Descripcion</label>
                                            <input class="form-control" id="timepicker" placeholder="Descripcion" name="descripcion" data-dtp="dtp_9g2aT">
                                        </div>
                                        <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                            <label class="form-label">Monto a pagar</label>
                                            <input class="form-control" id="timepicker" placeholder="Monto" name="monto" data-dtp="dtp_9g2aT">
                                        </div>
                                        
                                        <div class="col-xl-3 col-xxl-6 col-md-6">
                                            <label class="form-label"></label>
                                            <button name="agregarConsumo" type="submit" value="insertGastoFijo" class="btn btn-primary btn-block">Agregar</button>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            </form>
                        </div>
                        
                        <div class="col-xl-12">
                            <div class="table-responsive table-hover fs-14 ">
                                <div id="example6_wrapper" class="dataTables_wrapper no-footer"><table class="table display mb-4 dataTablesCard font-w600 border-no card-table text-black dataTable no-footer" id="example6" role="grid" aria-describedby="example6_info">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting_asc" tabindex="0" aria-controls="example6" rowspan="1" colspan="1" aria-label="Rank: activate to sort column descending" style="width: 101.422px;" aria-sort="ascending"></th>
                                            <th class="sorting" tabindex="0" aria-controls="example6" rowspan="1" colspan="1" aria-label="Coin: activate to sort column ascending" style="width: 194.234px;">Detalle</th>
                                            <th class="sorting" tabindex="0" aria-controls="example6" rowspan="1" colspan="1" aria-label="Last Price: activate to sort column ascending" style="width: 139.484px;">Monto</th>
                                            <th class="sorting" tabindex="0" aria-controls="example6" rowspan="1" colspan="1" aria-label="Change (24h): activate to sort column ascending" style="width: 182.203px;">Porcentaje Respecto al sueldo</th>
                                            <th class="sorting" tabindex="0" aria-controls="example6" rowspan="1" colspan="1" aria-label="Volume (24h): activate to sort column ascending" style="width: 205.844px;">Fecha de modificacion</th>
                                            <th class="bg-none width50 sorting" tabindex="0" aria-controls="example6" rowspan="1" colspan="1" aria-label=": activate to sort column ascending" style="width: 50px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                    $contador = 0;
                                    $gastosFijos = $cGasto->gastosFijosListado($user->userData()["user_id"]);
                                while ($gFijo = $gastosFijos->fetch(PDO::FETCH_ASSOC)) { 
                                    $contador++;
                                    echo'<tr role="row" class="odd">
                                            <td class="sorting_1">
                                                <span class="bgl-secondary rank-ic fs-20">#'.$contador.'</span>
                                            </td>
                                            <td class="wspace-no">
                                            <img src="images/icons/icon ('.$gFijo["Gfijos_imagen"].').png" class="rounded-lg mr-2" width="24" alt="">
                                                <span class="text-black">'.$gFijo["Gfijos_descripcion"].'</span>	
                                            </td>
                                            <td class="">$'.$gFijo["Gfijos_monto"].'</td>
                                            <td class="">0,00%</td>
                                            <td class="">'.$gFijo["Gfijos_fecha"].'</td>
                                            <td>					
                                                    <div class="d-flex">
                                                            <a href="gastos?gastoOpc=fijos&opc=editar&id='.$gFijo["Gfijos_id"].'" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                                            <a href="gastos?gastoOpc=fijos&opc=eliminar&id='.$gFijo["Gfijos_id"].'" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                                        </div>
                                            </td>
                                        </tr>';
                                        }
                                    echo'</tbody>
                                </table></div>	
                            </div>		
                        </div>
                    </div>
                </div>';
                    break;
                case 'tarjeta':
                    if (isset($_GET["tarjeta"])) {
                        $tarjeta_datos = $cGasto->getTarjetaById($_GET["tarjeta"]);
                        if ($tarjeta_datos[0]["tarjeta_user"] != $user->userData()["user_id"]) {
                            $util->redirect2("gastos?gastoOpc=tarjeta");
                        }
                    }
                    echo'
                    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
                    <link href="vendor/swiper/css/swiper-bundle.min.css" rel="stylesheet">
                    <div class="container-fluid">
                    <div class="form-head mb-sm-5 mb-3 d-flex align-items-center flex-wrap">
                        <h2 class="font-w600 mb-0 mr-auto mb-2 text-black">Mis Tarjetas</h2>';
                        if (isset($_GET["tarjeta"])) {
                            echo '<a href="gastos?gastoOpc=tarjeta&tarjeta=' . $_GET["tarjeta"] . '&consumo=add" class="btn btn-secondary mr-3 mb-2">+ Añadir Consumo</a>';
                        }
                        echo'<a href="gastos?gastoOpc=tarjeta&add=true" class="btn btn-secondary mb-2">+ Añadir Tarjeta</a>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 col-xxl-4">
                            <div class="swiper-box">
                                <div class="swiper-container card-swiper">
                                    <div class="swiper-wrapper">';
                                        $tarjetas = $cGasto->gastosTarjetaListado($user->userData()["user_id"]);
                                        while ($tarjeta = $tarjetas->fetch(PDO::FETCH_ASSOC)) {
                                            $gastosTotal = $cGasto->gettarjetaGastos($tarjeta["tarjeta_id"]);
                                            echo '<div class="swiper-slide">
                                                <a href="gastos?gastoOpc=tarjeta&tarjeta=' . $tarjeta["tarjeta_id"] . '">
                                                    <div class="card-bx stacked card">
                                                        <img src="' . $tarjeta["tarjeta_imagen"] . '" alt="">
                                                        <div class="card-info">
                                                            <p class="mb-1 text-white fs-14">Total Gastado</p>
                                                            <div class="d-flex justify-content-between">
                                                                <h2 class="num-text text-white mb-5 font-w600">$' . number_format($cGasto->gettarjetaGastos($tarjeta["tarjeta_id"])[0]["sum(Tmovimientos_monto)"], 2) . '</h2>
                                                                <svg width="55" height="34" viewbox="0 0 55 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <circle cx="38.0091" cy="16.7788" r="16.7788" fill="white" fill-opacity="0.67"></circle>
                                                                    <circle cx="17.4636" cy="16.7788" r="16.7788" fill="white" fill-opacity="0.67"></circle>
                                                                </svg>
                                                            </div>
                                                            <div class="d-flex">
                                                                <div class="mr-4 text-white">
                                                                    <p class="fs-12 mb-1 op6">Vencimiento</p>
                                                                    <span>'.$tarjeta["tarjeta_vencimiento"].'</span>
                                                                </div>
                                                                <div class="text-white">
                                                                    <p class="fs-12 mb-1 op6">Banco '.$tarjeta["tarjeta_banco"] . '</p>
                                                                    <span>'.$tarjeta["tarjeta_tipo"]." *".$tarjeta["tarjeta_ultimosdigitos"] . '</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </a>
                                                </div>';
                                        }
                                    echo'</div>
                                    <!-- Add Scroll Bar -->
                                    <div class="swiper-scrollbar"></div>
                                </div>
                            </div>
                        </div>';
                        if (isset($_GET["tarjeta"])) {
                            echo '<div class="col-xl-9 col-xxl-8">
                                <div class="row">';
                                     if (isset($_GET["consumo"])){
                                        echo '
                                        <div class="col-lg-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h4 class="card-title">Añadir Nuevo Consumo en '.$tarjeta_datos[0]["tarjeta_banco"].' *'.$tarjeta_datos[0]["tarjeta_ultimosdigitos"].'</h4>
                                                    </div>
                                                <div class="card-body">
                                                <div class="table-responsive">
                                                <form method="POST" action="'.$_SERVER["PHP_SELF"].'">
                                                <input type="hidden" value="'.$_GET["tarjeta"].'" name="tarjeta">
                                <div class="form-group">
                                    Descripcion consumo
                                    <input type="text" class="form-control input-default " placeholder="Descripcion" name="descripcion">
                                </div>
                                <div class="form-group mb-0">
                                Tipo Operacion
                                <div class="radio">
                                    <label><input type="radio" name="tipoTarjeta" value="compra" checked> Compra</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="tipoTarjeta" value="reintegro"> Reintegro</label>
                                </div>
                            </div>
                            Monto
                            <div class="input-group mb-3">
                            <span class="input-group-text">$</span>
                            <span class="input-group-text">0.00</span>
                            <input type="text" class="form-control" name="monto">
                        </div>
                        <div class="form-group">
                        Fecha de Compra
                    <input class="form-control input-default " autocomplete="off" type="text" placeholder="YY/MM/DD" name="fecha" id="campofecha">
                    </div>
                                <div class="text-center mt-4">
                                    <button name="agregarConsumo" type="submit" value="agregarConsumoTarjeta" class="btn btn-primary btn-block">Agregar</button>
                                </div>
                            </form>
                                </div>
                                </div>
                                </div>
                                </div>'; }
                                    echo'<div class="col-lg-12">
                                        <div class="d-block d-sm-flex mb-4">
                                            <h4 class="mb-0 text-black fs-20 mr-auto">Detalles de la tarjeta</h4>
                                        </div>
                                    </div>
            
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row align-items-end">
                                                    <div class="col-xl-6 col-lg-12 col-xxl-12">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="mb-4">
                                                                    <p class="mb-2">Tipo</p>
                                                                    <h4 class="text-black">'.$tarjeta_datos[0]["tarjeta_tipo"].'</h4>
                                                                </div>
                                                                <div class="mb-4">
                                                                    <p class="mb-2">Vencimiento</p>
                                                                    <h4 class="text-black"><?php echo $tarjeta_datos[0]["tarjeta_vencimiento"]; ?></h4>
                                                                </div>
                                                                <div>
                                                                    <p class="mb-2">Numero</p>
                                                                    <h4 class="text-black">**** **** **** <?php echo $tarjeta_datos[0]["tarjeta_ultimosdigitos"]; ?></h4>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="mb-4">
                                                                    <p class="mb-2">Banco</p>
                                                                    <h4 class="text-black"><?php echo $tarjeta_datos[0]["tarjeta_banco"]; ?></h4>
                                                                </div>
                                                                <div class="mb-4">
                                                                    <p class="mb-2">Titular</p>
                                                                    <h4 class="text-black">'.$user->userData()["user_nombre"] . ' ' . $user->userData()["user_apellido"].'</h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-12 col-xxl-12 mb-lg-0 mb-3">
                                                        <p>Limite Mensual</p>
                                                        <div class="row">
                                                            <div class="col-sm-4 mb-sm-0 mb-4 text-center">
                                                                <div class="d-inline-block position-relative donut-chart-sale mb-3">';
                                                                    if (!empty($tarjeta_datos[0]["tarjeta_limite"])) {
                                                                        $gastos = $cGasto->gettarjetaGastos($tarjeta_datos[0]["tarjeta_id"])[0]["sum(Tmovimientos_monto)"];
                                                                        $gastos_porcentaje = ($gastos * 100) / $tarjeta_datos[0]["tarjeta_limite"];
                                                                    } else {
                                                                        $gastos_porcentaje = 0;
                                                                    }?>
                                                                    <span class="donut1" data-peity='{ "fill": ["rgb(255, 104, 38)", "rgba(240, 240, 240)"],   "innerRadius": 40, "radius": 10}'><?php echo $gastos_porcentaje; ?>/100</span>
                                                                    <small><?php echo number_format($gastos_porcentaje, 2, '.', ''); ?>%</small>
                                                                </div>
                                                                <h5 class="fs-18 text-black">Limites</h5>
                                                                <span>$<?php echo $tarjeta_datos[0]["tarjeta_limite"];?></span>
                                                            </div>
            
                                                            <div class="col-sm-4 text-center">
                                                                <div class="d-inline-block position-relative donut-chart-sale mb-3">
                                                                    <span class="donut1" data-peity='{ "fill": ["rgb(158, 158, 158)", "rgba(240, 240, 240)"],   "innerRadius": 40, "radius": 10}'>2/100</span>
                                                                    <small>0%</small>
                                                                </div>
                                                                <h5 class="fs-18 text-black">Ahorro</h5>
                                                                <span>$0</span>
                                                                <?php
                                                            echo'</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Movimientos del mes</h4>
                                                <div class="d-flex align-items-center">
                                                    <select class="style-1 btn-secondary default-select">
                                                        <option>'.$Meses[date('n') - 1].'(2023)</option>
                                                    </select>
                                                    <button name="transaccion" type="submit" value="transaccion" class="btn btn-secondary btn-rounded"><img height="20" src="https://cdn.pixabay.com/photo/2017/01/13/01/22/magnifying-glass-1976105_960_720.png"></button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table header-border table-responsive-sm">
                                                        <thead>
                                                            <tr>
                                                                <th>Fecha</th>
                                                                <th>Comercio</th>
                                                                <th>Monto</th>
                                                                <th>Status</th>
            
                                                            </tr>
                                                        </thead>
                                                        <tbody>';
                                                            $mes = "";
                                                            $ano = "";
                                                                $tarjeta_movimientos = $cGasto->tarjetaMovimiento($_GET["tarjeta"]);
                                                            while ($movimientos = $tarjeta_movimientos->fetch(PDO::FETCH_ASSOC)) {
                                                                echo '<tr>
                                                            <td><a href="javascript:void(0)">' . $movimientos["Tmovimientos_fecha"] . '</a></td>
                                                            <td>' . $movimientos["Tmovimientos_descripcion"] . '</td>
                                                            <td>' . $movimientos["Tmovimientos_monto"] . '</td>
                                                            <td>';
                                                                if ($movimientos["Tmovimientos_operacion"] == "compra") {
                                                                    echo '<span class="badge badge-success">Compra</span>';
                                                                } else {
                                                                    echo '<span class="badge badge-danger">Reintegro</span>';
                                                                }
                                                                echo '</td>
                                                        </tr>';
                                                            }
                                                        echo'</tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                                } else {
                                    echo '<div class="col-xl-9 col-xxl-8">';
                                    if(isset($_GET["add"])){
                                    echo '
                                            <div class="col-lg-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h4 class="card-title">Añadir Nueva Tarjeta</h4>
                                                    </div>
                                                <div class="card-body">
                                                <div class="table-responsive">
                                                <form method="POST" action="gastos?gastoOpc=tarjeta">
                                <div class="form-group">
                                    Nombre del Banco
                                    <input type="text" class="form-control input-default " placeholder="Nombre" name="nombreBanco">
                                </div>
                                <div class="form-group mb-0">
                                Tipo de tarjeta
                                <div class="radio">
                                    <label><input type="radio" name="tipoTarjeta" value="Debito" checked> Debito</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="tipoTarjeta" value="Credito"> Credito</label>
                                </div>
                            </div>
                            Ultimos 4 digitos de la tarjeta
                                <div class="input-group mb-3">
                                    <span class="input-group-text">**** **** ****</span>
                                    <input type="text" class="form-control" maxlength="4" name="ultimosDigitos">
                                 </div>
                                 <div class="form-group">
                                    vencimiento
                                    <input type="text" class="form-control input-default " placeholder="MM/AA" name="vencimiento">
                                </div>
                                <div class="form-group">
                                    Limite(dejar en blanco en caso que no tenga limite)
                                    <input type="text" class="form-control input-default " placeholder="Limite" name="limite">
                                </div>
                                <div class="text-center mt-4">
                                    <button name="agregar" type="submit" value="agregar" class="btn btn-primary btn-block">Agregar</button>
                                </div>
                            </form>
                                </div>
                                </div>
                                </div>';
                                    }
                                echo '
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Movimientos del mes En todas Tus tarjetas</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table header-border table-responsive-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>Fecha</th>
                                                            <th>Comercio</th>
                                                            <th>Monto</th>
                                                            <th>Status</th>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>';
                                $gastos_tarjeta_all = $cGasto->gastoTarjetasAll($user->userData()["user_id"]);
                                while ($tarjetaGasto_all = $gastos_tarjeta_all->fetch(PDO::FETCH_ASSOC)) {
                                    echo '
                                                        <tr>
                                                            <td><a href="javascript:void(0)">' . $tarjetaGasto_all["Tmovimientos_fecha"] . '</a></td>
                                                            <td>' . $tarjetaGasto_all["Tmovimientos_descripcion"] . ' *' . $tarjetaGasto_all["tarjeta_tipo"] . ' ' . $tarjetaGasto_all["tarjeta_ultimosdigitos"] . '</td>
                                                            <td>$' . $tarjetaGasto_all["Tmovimientos_monto"] . '</td>
                                                            <td>';
                                    if ($tarjetaGasto_all["Tmovimientos_operacion"] == "compra") {
                                        echo '<span class="badge badge-success">Compra</span>';
                                    } else {
                                        echo '<span class="badge badge-danger">Reintegro</span>';
                                    }
                                    echo '</td>
                                                        </tr>';
                                }
                                echo '
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>';
                                echo'</div>';
                            }
                                echo'</div>
                            </div>
            
                    </div>
                </div>
            </div>
            <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  $( function() {
	$( "#campofecha" ).datepicker({
	  numberOfMonths: 1,
	  dateFormat: "yy-mm-dd",
	  showButtonPanel: true
	});
  } );
  </script>';
                    break;

                default: 
                    $registro = date('Y-m', strtotime($user->userData()["user_registro"]));
                    $hoy = date('Y-m');?>
                    <!-- container starts -->
            <div class="container-fluid">
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Analisis de Gastos</h4>
                            <span></span>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Gastos</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Inicio</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->
                <!-- Row starts -->
                <div class="row">
                	<div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Gastos</h4>
                            </div>
                            <div class="card-body">
                                <div class="row form-material">
                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                        <label class="form-label">Mes A buscar</label>
                                        <div class="input-group mb-3">
                                            <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                        <select class="selectpicker" data-show-subtext="true" name="mes">
                                         <?php while($registro != $hoy){
                                             echo '<option data-subtext="'.$Meses[(date('m', strtotime($hoy)))-1].'">'.$hoy.'</option>';
                                             $hoy = date('Y-m', strtotime($hoy.'- 1 month'));
                                         } 
                                         echo '<option data-subtext="'.$Meses[(date('m', strtotime($registro)))-1].'">'.$registro.'</option>';
                                         ?>
                                         
                                    </select>
											<button type="submit" class="btn btn-primary">Buscar</button>
                                        </div>
                                        </form>
                                    </div>
                                    <div class="col-xl-3 col-xxl-6 col-md-6">
                                        <label class="form-label">Total a cobrar este mes</label>
                                        <div class="input-group mb-3">
                                            <input type="text" name="sueldo" placeholder="0" class="form-control">
											<button class="btn btn-primary" type="button">Actualizar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-xxl-4 col-lg-6 col-sm-6">
                        <a href="gastos?gastoOpc=tarjeta">
                        <div class="widget-stat card">
							<div class="card-body p-4">
								<div class="media ai-icon">
									<span class="mr-3 bgl-warning text-warning">
                                    <svg id="icon-revenue" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign">
											<line x1="12" y1="1" x2="12" y2="23"></line>
											<path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
										</svg>
									</span>
									<div class="media-body">
										<p class="mb-1">Gastos Tarjetas</p>
										<h4 class="mb-0">$<?php echo $gastoTarjeta = 0+$cGasto->getgastos('tarjeta', $mesBusqueda, $user->userData()["user_id"]); ?></h4>
										<span class="badge badge-warning">0%</span>
									</div>
								</div>
							</div>
						</div>
                        </a>
                    </div>
                    
                    <div class="col-xl-3 col-xxl-4 col-lg-6 col-sm-6">
                    <a href="gastos?gastoOpc=fijos">
                        <div class="widget-stat card">
							<div class="card-body  p-4">
								<div class="media ai-icon">
									<span class="mr-3 bgl-danger text-danger">
										<svg id="icon-revenue" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign">
											<line x1="12" y1="1" x2="12" y2="23"></line>
											<path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
										</svg>
									</span>
									<div class="media-body">
										<p class="mb-1">Gastos Fijos</p>
										<h4 class="mb-0">$<?php echo $gastoFijo = 0+$cGasto->getgastos('fijo', $mesBusqueda, $user->userData()["user_id"]); ?></h4>
										<span class="badge badge-danger"><?php $gastoFijoAnterior = 0+$cGasto->getgastos('fijo', date('Y-m', strtotime($mesBusqueda.'- 1 month')), $user->userData()["user_id"]); 
                                        echo number_format((((1+$gastoFijo)/(1+$gastoFijoAnterior))*100)-100, 2); ?>%</span>
									</div>
								</div>
							</div>
						</div>
                        </a>
                    </div>
                    <div class="col-xl-3 col-xxl-4 col-lg-6 col-sm-6">
                    <a href="gastos?gastoOpc=diario">
                        <div class="widget-stat card">
							<div class="card-body p-4">
								<div class="media ai-icon">
									<span class="mr-3 bgl-success text-success">
                                    <svg id="icon-revenue" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign">
											<line x1="12" y1="1" x2="12" y2="23"></line>
											<path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
										</svg>
									</span>
									<div class="media-body">
										<p class="mb-1">Gastos Diarios</p>
										<h4 class="mb-0">$<?php echo $gastoDiario = 0+$cGasto->getgastos('diario', $mesBusqueda, $user->userData()["user_id"]); ?></h4>
										<span class="badge badge-success"><?php $gastoDiarioAnterior = 0+$cGasto->getgastos('diario', date('Y-m', strtotime($mesBusqueda.'- 1 month')), $user->userData()["user_id"]); 
                                        echo number_format((((1+$gastoDiario)/(1+$gastoDiarioAnterior))*100)-100, 2); ?>%</span>
									</div>
								</div>
							</div>
						</div>
                    </a>
                    </div>
                    <div class="col-xl-3 col-xxl-4 col-lg-6 col-sm-6">
						<div class="widget-stat card">
							<div class="card-body p-4">
								<div class="media ai-icon">
									<span class="mr-3 bgl-primary text-primary">
                                    <svg id="icon-database-widget" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-database">
											<ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
											<path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
											<path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
										</svg>
									</span>
									<div class="media-body">
										<p class="mb-1">Gastos Totales</p>
										<h4 class="mb-0">$<?php echo $gastoDiario+$gastoFijo+$gastoTarjeta; ?></h4>
										<span class="badge badge-primary">0%</span>
									</div>
								</div>
							</div>
						</div>
                    </div>
                    <!--
					<div class="col-xl-12 col-lg-12 col-xxl-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Gastos Recientes</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive recentOrderTable">
                                    <table class="table verticle-middle table-responsive-md">
                                        <thead>
                                            <tr>
                                                <th scope="col">Ward No.</th>
                                                <th scope="col">Patient</th>
                                                <th scope="col">Dr Name</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Bills</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>12</td>
												<td>Mr. Bobby</td>
                                                <td>Dr. Jackson</td>
                                                <td>01 August 2020</td>
                                                <td><span class="badge badge-rounded badge-primary">Checkin</span></td>
                                                <td>$120</td>
                                                <td>
                                                    <div class="dropdown custom-dropdown mb-0">
                                                        <div class="btn sharp btn-primary tp-btn" data-toggle="dropdown">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewbox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="12" cy="5" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="19" r="2"></circle></g></svg>
														</div>
														<div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="javascript:void(0);">Details</a>
                                                            <a class="dropdown-item text-danger" href="javascript:void(0);">Cancel</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>10 </td>
                                                <td>Mr. Dexter</td>
                                                <td>Dr. Charles</td>
												<td>31 July 2020</td>
                                                <td><span class="badge badge-rounded badge-warning">Panding</span></td>
                                                <td>$540</td>
                                                <td>
                                                    <div class="dropdown custom-dropdown mb-0">
                                                        <div class="btn sharp btn-primary tp-btn" data-toggle="dropdown">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewbox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="12" cy="5" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="19" r="2"></circle></g></svg>
														</div>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="javascript:void(0);">Details</a>
                                                            <a class="dropdown-item text-danger" href="javascript:void(0);">Cancel</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>03 </td>
                                                <td>Mr. Nathan</td>
                                                <td>Dr. Frederick</td>
												<td>30 July 2020</td>
                                                <td><span class="badge badge-rounded badge-danger">Canceled</span></td>
                                                <td>$301</td>
                                                <td>
                                                    <div class="dropdown custom-dropdown mb-0">
                                                        <div class="btn sharp btn-primary tp-btn" data-toggle="dropdown">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewbox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="12" cy="5" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="19" r="2"></circle></g></svg>
														</div>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="javascript:void(0);">Details</a>
                                                            <a class="dropdown-item text-danger" href="javascript:void(0);">Cancel</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>05</td>
                                                <td>Mr. Aurora</td>
                                                <td>Dr. Roman</td>
												<td>29 July 2020</td>
                                                <td><span class="badge badge-rounded badge-success">Checkin</span></td>
                                                <td>$099</td>
                                                <td>
                                                    <div class="dropdown custom-dropdown mb-0">
														<div class="btn sharp btn-primary tp-btn" data-toggle="dropdown">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewbox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="12" cy="5" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="19" r="2"></circle></g></svg>
														</div>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="javascript:void(0);">Details</a>
                                                            <a class="dropdown-item text-danger" href="javascript:void(0);">Cancel</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>06</td>
                                                <td>Mr. Matthew</td>
                                                <td>Dr. Samantha</td>
												<td>28 July 2020</td>
                                                <td><span class="badge badge-rounded badge-success">Checkin</span></td>
                                                <td>$520</td>
                                                <td>
                                                    <div class="dropdown custom-dropdown mb-0">
														<div class="btn sharp btn-primary tp-btn" data-toggle="dropdown">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewbox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="12" cy="5" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="19" r="2"></circle></g></svg>
														</div>
														<div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="javascript:void(0);">Details</a>
                                                            <a class="dropdown-item text-danger" href="javascript:void(0);">Cancel</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-6 col-sm-6">
						<div class="widget-stat card">
							<div class="card-body p-4">
								<h4 class="card-title">Total Students</h4>
								<h3>3280</h3>
								<div class="progress mb-2">
									<div class="progress-bar progress-animated bg-primary" style="width: 80%"></div>
								</div>
								<small>80% Increase in 20 Days</small>
							</div>
						</div>
                    </div>
					<div class="col-xl-3 col-lg-6 col-sm-6">
						<div class="widget-stat card">
							<div class="card-body p-4">
								<h4 class="card-title">New Students</h4>
								<h3>245</h3>
								<div class="progress mb-2">
									<div class="progress-bar progress-animated bg-warning" style="width: 50%"></div>
								</div>
								<small>50% Increase in 25 Days</small>
							</div>
						</div>
                    </div>
					<div class="col-xl-3 col-lg-6 col-sm-6">
						<div class="widget-stat card">
							<div class="card-body p-4">
								<h4 class="card-title">Total Course</h4>
								<h3>28</h3>
								<div class="progress mb-2">
									<div class="progress-bar progress-animated bg-red" style="width: 76%"></div>
								</div>
								<small>76% Increase in 20 Days</small>
							</div>
						</div>
                    </div>
					<div class="col-xl-3 col-lg-6 col-sm-6">
						<div class="widget-stat card">
							<div class="card-body p-4">
								<h4 class="card-title">Fees Collection</h4>
								<h3>25160$</h3>
								<div class="progress mb-2">
									<div class="progress-bar progress-animated bg-success" style="width: 30%"></div>
								</div>
								<small>30% Increase in 30 Days</small>
							</div>
						</div>
                    </div>
                    -->
                </div>
                <!-- Row ends -->
            </div>
            <!-- container ends -->
                   <?php break;
            }
            ?>
        
        </div>
        <!--**********************************
                Content body end
            ***********************************-->
<?php require("footer.php"); ?>
