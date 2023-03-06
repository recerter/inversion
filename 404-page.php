<?php 
require_once('inc/php/core.php');
$mainCore = new mainCore();
 ?>
<!DOCTYPE html>
<html lang="es" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="">
	<meta name="author" content="">
	<meta name="robots" content="">
    <meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="format-detection" content="telephone=no">
    <title><?php echo $mainCore->getWebNombre(); ?>Ovitec : Page Error </title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $mainCore->getWebUrl();?>images/favicon.png">
    <link href="<?php echo $mainCore->getWebUrl();?>css/style.css" rel="stylesheet">
    
</head>

<body class="vh-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-8">
                    <div class="form-input-content text-center error-page">
                        <h1 class="error-text font-weight-bold">404</h1>
                        <h4><i class="fa fa-exclamation-triangle text-warning"></i> The page you were looking for is not found!</h4>
                        <p>You may have mistyped the address or the page may have moved.</p>
						<div>
                            <a class="btn btn-primary" href="<?php echo $mainCore->getWebUrl();?>">Back to Home</a>
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
<script src="<?php echo $mainCore->getWebUrl();?>vendor/global/global.min.js"></script>
<script src="<?php echo $mainCore->getWebUrl();?>vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<script src="<?php echo $mainCore->getWebUrl();?>js/custom.min.js"></script>
<script src="<?php echo $mainCore->getWebUrl();?>js/deznav-init.js"></script>
</body>
</html>