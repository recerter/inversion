<?php
require ("header.php"); 
require_once TS_CLASS.'c.favorito.php';
require_once TS_CLASS.'c.instrumento.php';
$cFavorito = new favorito(); 
$cInstrumento = new instrumento();
if (!empty($_POST["modificar"])) { 
    $cFavorito->updateFavoritosInicio($user->userData()["user_id"], $_POST["instrumento1"], $_POST["instrumento2"], $_POST["instrumento3"], $_POST["instrumento4"]);
}
if(isset($_POST["addFav"])){
    $cFavorito->insertarFavorito($user->userData()["user_id"], $_POST["instrumento"]);
}
?>
<div class="content-body">
            <div class="container-fluid">
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Listado de Favoritos</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Table</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Listado de Favoritos</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Favoritos Del Inicio</h4>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <div class="row form-material">
                                    <?php for ($i = 1; $i <= 4; $i++){
                                        echo '<div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                        <select class="selectpicker" data-show-subtext="true" data-live-search="true" name="instrumento'.$i.'">';
                                     $usuario_favoritos = $cUsuario->getMemberInversionById($user->userData()["user_id"]);
                                     $moneda_buscar = $cInstrumento->getInstrumentoId($usuario_favoritos["iUsuarios_favorito$i"]);
                                     echo '<option value="'.$moneda_buscar["instrumento_id"].'" data-subtext="'.$moneda_buscar["instrumento_nombre"].'"> '.$moneda_buscar["instrumento_sigla"].'</option> ';
                                     $listadoInstrumentos = $cInstrumento->listadoinstrumentoTradeable();
                                     while($instrumento = $listadoInstrumentos->fetch(PDO::FETCH_ASSOC)){
                                     echo '<option value="'.$instrumento["instrumento_id"].'" data-subtext="'.$instrumento["instrumento_nombre"].'"> '.$instrumento["instrumento_sigla"].'</option>';
                                     }
                                     echo'</select>
                                     <img src="'.$moneda_buscar["instrumento_imagen"].'" class="rounded-lg mr-2" width="24" alt="">
                                     </div>';
                                }?>
                                    <div class="col-xl-5 col-xxl-7 col-7">
                                        <div class="form-check custom-checkbox mb-3 checkbox-info">
                                            
                                        </div>
                                    </div>
                                    <div class="mt-0">                              
                                <button name="modificar" type="submit" value="modificar" class="btn btn-primary btn-lg btn-block">Actualizar</button>
                                    </div>
                                </form>
                                </div> 
                            </div>
                        </div>
                    </div>
                <?php if(isset($_GET["opcion"])){ ?>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Añadir Nuevo Favorito</h4>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <div class="row form-material">
                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                    <div class="form-group">
                                            Instrumento
                                    <select class="selectpicker" data-show-subtext="true" data-live-search="true" name="instrumento">
                                    <?php
                                    $listadoInstrumentos = $cInstrumento->listadoinstrumentoTradeable();
                                    while($instrumento = $listadoInstrumentos->fetch(PDO::FETCH_ASSOC)){?>
                                    <option data-subtext="<?php echo $instrumento["instrumento_nombre"]; ?>"> <?php echo $instrumento["instrumento_sigla"]; ?></option>
                                    <?php }?>          
                                    </select>
                                    </div>
                                    </div>
                                    <div class="mt-0">                              
                                <button name="addFav" type="submit" value="addFav" class="btn btn-primary btn-lg btn-block">Añadir</button>
                                    </div>
                                </form>
                                </div> 
                            </div>
                        </div>
                    </div>
                <?php } ?>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Instrumentos en Favoritos</h4>
                            </div>
                            <div class="card-body">
                                    
                                <div class="table-responsive">

                                    <table class="table table-responsive-md">
                                        <thead>
                                            <tr>
                                                <th><strong>ID</strong></th>
                                                <th><strong>Nombre</strong></th>
                                                <th><strong>Precio</strong></th>
                                                <th><strong>Variacion</strong></th>
                                                <th><strong>Tipo</strong></th>
                                                <th><strong>Status</strong></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if(isset($_GET["tenencia"])){
                                                $instrumentos = $cFavorito->listadoTenecia($user->userData()['user_id']);
                                            }else{
                                                $instrumentos = $cFavorito->listadoFavoritos($user->userData()['user_id']);
                                            }
                                            while($instrumento = $instrumentos->fetch(PDO::FETCH_ASSOC)){ 
                                                if(isset($_GET["tenencia"])){
                                                    $instrumentoBuscar = $instrumento["Wportfolio_instrumento"];
                                                }else{
                                                    $instrumentoBuscar = $instrumento["fav_instrumento"];
                                                }
                                                $moneda_buscar = $cInstrumento->getInstrumentoSigla($instrumentoBuscar);
                                                ?>
                                            <tr>
                                                <td><strong><?php echo $moneda_buscar["instrumento_id"]; ?></strong></td>
                                                <td><div class="d-flex align-items-center"><a href="monedaDetalle?instrumento=<?php echo $moneda_buscar["instrumento_sigla"]; ?>"><img src="<?php echo $moneda_buscar["instrumento_imagen"]; ?>" class="rounded-lg mr-2" width="24" alt=""> <span class="w-space-no">[<?php echo $moneda_buscar["instrumento_sigla"]; ?>] <?php echo $moneda_buscar["instrumento_nombre"]; ?></span></a></div></td>

                                                <td><?php echo $moneda_buscar["instrumento_moneda"]; ?> <?php echo $moneda_buscar["instrumento_ultimoPrecio"]; ?></td>
                                                <?php if($moneda_buscar["instrumento_ultimoPrecioCambio"]>0){
                                                    echo '<td><p class="text-success">'.number_format((float)$moneda_buscar["instrumento_ultimoPrecioCambio"], 2, ".", "").'%</p></td>';
                                                }elseif($moneda_buscar["instrumento_ultimoPrecioCambio"]<0){
                                                    echo '<td><p class="text-danger">'.number_format((float)$moneda_buscar["instrumento_ultimoPrecioCambio"], 2, ".", "").'%</p></td>';
                                                }else{
                                                    echo '<td>'.number_format((float)$moneda_buscar["instrumento_ultimoPrecioCambio"], 2, ".", "").'%</td>';
                                                }?>
                                                <td><?php echo $moneda_buscar["instrumento_tipo"]; ?></td>
                                                <td><div class="d-flex align-items-center"><i class="fa fa-circle text-success mr-1"></i>Activo</div></td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="#" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                                        <a href="#" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                                    </div>
                                                </td>
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
<?php include("footer.php"); ?>