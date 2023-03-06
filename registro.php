<?php 
session_start();
require_once('inc/php/core.php');
$mainCore = new mainCore();
require_once TS_EXT.'authCookieSessionValidate.php';
require_once TS_CLASS.'c.usuario.php';
$cUsuario = new classUsuario();
if ($isLoggedIn) {
    $util->redirect("index.php");
}
if (! empty($_POST["registro"])) {
    $isAuthenticated = false;
    $pass = $_POST["contrasena"];
    if($pass != ""){
    $pass = password_hash($_POST["contrasena"], PASSWORD_DEFAULT);
    }
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $emailExistente = $cUsuario->getMemberByEmail($email);
    $emailvalido =  $util->comprobar_email($email);
            if(!$emailExistente){
                if($pass != ""){
                    $cUsuario->insertUsuario($nombre, $pass, $email);
                    $util->redirect("login.php");
                }else{
                    $mensaje = "La contraseña no puede estar en blanco";
                }
            }else{
                $mensaje = "El Email Ya existe en la base de datos";
            }
    
}
?>
<!DOCTYPE html>
<html lang="es" class="h-100">
<head>
    <meta charset="utf-8">
    <title><?php echo $mainCore->getWebNombre(); ?> - Registro</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.ico">
	<link href="vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-DJJVGZ60BN"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-DJJVGZ60BN');
</script>
</head>

<body class="vh-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
									<div class="text-center mb-3">
										<img src="images/logo-full.png" alt="">
									</div>
                                    <h4 class="text-center mb-4">Registrar Cuenta</h4>
                                    <?php if (isset($mensaje)){
                                        echo '<div class="alert alert-danger alert-dismissible fade show">
                                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                                    <strong>Error!</strong> '.$mensaje.'.
                                    <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                    </button>
                                </div>';
                            }?>
                                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Nombre</strong></label>
                                            <input type="text" class="form-control" placeholder="nombre" name="nombre">
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Email</strong></label>
                                            <input type="email" class="form-control" placeholder="hello@example.com" name="email">
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Contraseña</strong></label>
                                            <input type="password" class="form-control" value="" name="contrasena">
                                        </div>
                                        <div class="text-center mt-4">
                                            <button name="registro" type="submit" value="registro" class="btn btn-primary btn-block">Registrarme</button>
                                        </div>
                                    </form>
                                    <div class="new-account mt-3">
                                        <p>¿Ya tienes una cuenta? <a class="text-primary" href="login.php">Ingresa</a></p>
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
	Scripts
***********************************-->
<!-- Required vendors -->
<script src="vendor/global/global.min.js"></script>
<script src="vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<script src="js/custom.min.js"></script>
<script src="js/deznav-init.js"></script>
<script src="js/demo.js"></script>
</body>
</html>