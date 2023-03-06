<?php 
require ("header.php"); 
require_once TS_CLASS.'c.wallet.php';
require_once TS_CLASS.'c.usuario.php';
$cWallet = new wallet();
$cUsuario = new classUsuario();
if($user->userData()["user_rango"]=='0'){
    $cUsuario->UpdateRango($user->userData()["user_id"], 1);
    $cUsuario->insertInvertirUsuario($user->userData()["user_id"]);
    $cWallet->walletOpcionAgregar($user->userData()["user_id"], "Ahorro Sin Objetivo", "images/card/card1.jpg");
    $util->redirect2("index.php");
if (! empty($_POST["agregar"])) {
    $encuesta_edad = "";
    $encuesta_sexo = "";
    $encuesta_antiguedad = "";
    $invirtio = "";
    $encuesta_invirtio = "";
    $encuesta_favorito = "";
    $encuesta_otro = "";

	$encuesta_edad = $_POST["edad"];
	$encuesta_sexo = $_POST["sexo"];
    $encuesta_favorito = $_POST["intrumento"];
    $encuesta_otro = $_POST["instrumento_otro"];
	$encuesta_antiguedad = $_POST["antiguedad"];
    
    if(isset($_POST["invirtio_fondos"])){
        $invirtio = ''.$invirtio.' '.$_POST["invirtio_fondos"].'';
    }
    if(isset($_POST["invirtio_acciones"])){
        $invirtio = ''.$invirtio.' '.$_POST["invirtio_acciones"].'';
    }
    if(isset($_POST["invirtio_criptomonedas"])){
        $invirtio = ''.$invirtio.' '.$_POST["invirtio_criptomonedas"].'';
    }
	$encuesta_invirtio = $invirtio;
	$authRegistro = new AuthRegistro();
    $authRegistro->insertEncuesta($user->userData()["user_id"], $encuesta_edad, $encuesta_sexo, $encuesta_antiguedad, $encuesta_invirtio, $encuesta_otro, $encuesta_favorito);
    //Agregar WAllet por default
    $AuthWallet->insertWallet($user->userData()["user_id"], "Ahorro Sin Objetivo", "images/card/card1.jpg");
    $descripcion = "Creo el Objetivo Ahorro Sin Objetivo";
    $auth->insertLog($user->userData()["user_id"], $descripcion);

    if(! empty($_POST["user_avatar"])){
        $user->updateAvatar($_POST["user_avatar"]);
    }
    $util->redirect2("index.php");
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
                            <h4>Terminar Registro</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Form</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Terminar Registro</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Completar Registro</h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                        <div class="form-group">
                                            Edad
                                            <input type="text" class="form-control input-default " placeholder="Edad" name="edad">
                                        </div>

                                        <div class="form-group mb-0">
                                            Sexo
                                            <div class="radio">
                                                <label><input type="radio" name="sexo" value="masculino"> Masculino</label>
                                            </div>
                                            <div class="radio">
                                                <label><input type="radio" name="sexo" value="femenino"> Femenino</label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            Hace Cuanto Invertis en los mercados financieros
                                            <select class="form-control default-select form-control-lg" name="antiguedad">
                                                <option value="nunca">Nunca</option>
                                                <option value="1">Menos de un Año</option>
                                                <option value="1-3">1-3 Años</option>
                                                <option value="4-6">4-6 Años</option>
                                                <option value="7">Mas de 7 Años</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            ¿Invirtio en algunos de estos elementos alguna vez?
                                            <div class="form-check mb-2">
                                                <input type="checkbox" class="form-check-input" id="check1" name="invirtio_fondos" value="fondos">
                                                <label class="form-check-label" for="check1" >Fondos Comunes de inversion</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input type="checkbox" class="form-check-input" name="invirtio_acciones" id="check2" value="acciones">
                                                <label class="form-check-label" for="check2" >Acciones/Cedears</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input type="checkbox" class="form-check-input" name="invirtio_criptomonedas" id="check3" value="criptomonedas">
                                                <label class="form-check-label" for="check2" >Criptomonedas</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            Tipo de instrumento favorito(En caso que invierta)
                                            <select class="form-control default-select form-control-lg" name="intrumento">
                                                <option value="fondos">Fondos Comunes de inversion</option>
                                                <option value="acciones">Acciones/Cedears</option>
                                                <option value="criptomonedas">Criptomonedas</option>
                                                <option value="otro">Otro</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            En caso de Otro especificar
                                            <input type="text" class="form-control input-default " placeholder="Otro instrumento" name="instrumento_otro">
                                        </div>
                                        <div class="form-group">
                                            Cargar una nueva imagen de perfil(opcional)
                                            <input type="text" class="form-control input-default " placeholder="http://" name="user_avatar">
                                        </div>
                                        
                                        <div class="text-center mt-4">
                                            <button name="agregar" type="submit" value="agregar" class="btn btn-primary btn-block">Finalizar</button>
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
<?php
}else{
    $util->redirect2("index.php");
} require("footer.php"); ?>