<?php 
session_start();
require_once('inc/php/core.php');
$mainCore = new mainCore();
require_once TS_EXT.'authCookieSessionValidate.php';
require_once TS_CLASS.'c.global.php';
require_once TS_CLASS.'c.usuario.php';
require_once TS_CLASS.'u.usuario.php';
$cUsuario = new classUsuario();
$util = new Util();
if ($isLoggedIn) {
    $util->redirect("index.php");
}

if (!empty($_POST["ingreso"])) {
    $isAuthenticated = false;
    $email = $_POST["email"];
    $password = $_POST["contrasena"];
    if($_POST["contrasena"] != "" && $_POST["email"] != ""){
    $user = $cUsuario->getMemberByEmail($email);
    $username = $user[0]["user_id"];

    if (password_verify($password, $user[0]["user_contrasena"])) {
        $isAuthenticated = true;
    }
    }
    if ($isAuthenticated) {
        $_SESSION["member_id"] = $user[0]["user_id"];
        $user = new Usuario();
        // Set Auth Cookies if 'Remember Me' checked
        if (! empty($_POST["remember"])) {
            setcookie("member_login", $username, $cookie_expiration_time);
            
            $random_password = $util->getToken(16);
            setcookie("random_password", $random_password, $cookie_expiration_time);
            
            $random_selector = $util->getToken(32);
            setcookie("random_selector", $random_selector, $cookie_expiration_time);
            
            $random_password_hash = password_hash($random_password, PASSWORD_DEFAULT);
            $random_selector_hash = password_hash($random_selector, PASSWORD_DEFAULT);
            
            $expiry_date = date("Y-m-d H:i:s", $cookie_expiration_time);
            
            // Insert new token
            $cUsuario->insertToken($username, $random_password_hash, $random_selector_hash, $expiry_date);
        } else {
            $util->clearAuthCookie();
        }
        $util->redirect("index.php");
    } else {
        $mensaje = "Invalid Login";
    }
}
?>
<!DOCTYPE html>
<html lang="es" class="h-100">
<head>
    <meta charset="utf-8">
    <title><?php echo $mainCore->getWebNombre(); ?> - Login</title>
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
                                    <h4 class="text-center mb-4">Ingresa a tu cuenta</h4>
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
                                            <label class="mb-1"><strong>Email</strong></label>
                                            <input type="email" class="form-control" value="" name="email">
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Contraseña</strong></label>
                                            <input type="password" class="form-control" value="" name="contrasena">
                                        </div>
                                        <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                            <div class="form-group">
                                               <div class="custom-control custom-checkbox ml-1">
													<input type="checkbox" class="custom-control-input" id="basic_checkbox_1" name="remember">
													<label class="custom-control-label" for="basic_checkbox_1" >Recordar</label>
												</div>
                                            </div>
                                            <div class="form-group">
                                                <a href="#">¿Has olvidado tu contraseña?</a>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button name="ingreso" type="submit" value="ingreso" class="btn btn-primary btn-block">Ingresar</button>
                                        </div>
                                    </form>
                                    <div class="new-account mt-3">
                                        <p>¿No tienes una cuenta? <a class="text-primary" href="registro.php">Registrarse</a></p>
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