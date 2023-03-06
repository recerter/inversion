<?php 
require ("header.php"); 
require_once TS_CLASS.'c.instrumento.php';
if($user->userData()["user_rango"] != 2){
    $util->redirect2("index.php");
}
if (! empty($_POST["agregar"])) {
    $cInstrumento = new instrumento();
    $usuario_id = $user->userData()["user_id"];
    $cInstrumento->agregarInstrumento($usuario_id, $_POST["nombre"], $_POST["moneda"], $_POST["sigla_api"], $_POST["sigla"], $_POST["tipo"], $_POST["descripcion"], $_POST["imagen"]);
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
                            <h4>Agregar instrumento</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Form</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Agregar Instrumento</a></li>
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
                                        <div class="form-group">
                                        	Nombre
                                            <input type="text" class="form-control input-default " placeholder="Nombre" name="nombre">
                                        </div>
                                        <div class="form-group">
                                        	Moneda
                                            <select class="form-control default-select form-control-lg" name="moneda">
                                                <option value="$">Pesos</option>
                                                <option value="U$D">Dolares</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                        	Sigla
                                            <input type="text" class="form-control input-default " placeholder="Sigla" name="sigla">
                                        </div>
                                        <div class="form-group">
                                        	Sigla API
                                            <input type="text" class="form-control input-default " placeholder="Sigla API" name="sigla_api">
                                        </div>
                                        <div class="form-group">
                                        	Tipo
                                            <select class="form-control default-select form-control-lg" name="tipo">
                                                <option value="cedear">Cedear</option>
                                                <option value="criptomoneda">Criptomoneda</option>
                                                <option value="acciones">Acciones Argentinas</option>
                                                <option value="fondos">Fondos</option>
                                                <option value="indice">Indices</option>
                                                <option value="commodities">Materias Primas</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                        	Imagen
                                            <input type="text" class="form-control input-default " placeholder="http://" name="imagen">
                                        </div>
                                        <div class="form-group">
                                        	Descripcion
                                            <textarea class="form-control" rows="4" id="descripcion" name="descripcion"></textarea>
                                        </div>
                                        <div class="text-center mt-4">
                                            <button name="agregar" type="submit" value="agregar" class="btn btn-primary btn-block">Agregar</button>
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