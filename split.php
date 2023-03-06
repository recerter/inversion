<?php 
require ("header.php");
require_once TS_CLASS.'c.instrumento.php';
$cInstrumento = new instrumento();
if($user->userData()["user_rango"] != 2){
    $util->redirect2("index.php");
}
if (! empty($_POST["agregar"])) {
	$instrumento_sigla = $_POST["instrumento"];
	$instrumento_cantidad = $_POST["cantidad"];
    $cInstrumento->setSplit($instrumento_sigla, $instrumento_cantidad);
    $descripcion = "Hizo un split $instrumento_sigla";
    $auth->insertLog($user->userData()["user_id"], $descripcion);
}
?>
<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
			<div class="container-fluid">
				<!-- Add Project -->
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Agregar Splt</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Form</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Agregar Split</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Agregar Nuevo Instrumento</h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
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
                                    <div class="form-group">
                                        	Cantidad
                                            <input type="text" class="form-control input-default " placeholder="cantidad" name="cantidad">
                                        </div>
                                    </div>
                                            <button name="agregar" type="submit" value="agregar" class="btn btn-primary btn-lg btn-block">Añadir</button>
                                        </div>                 
                                </form>
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