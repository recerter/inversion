<?php 
session_start();
require_once('inc/php/core.php');
$mainCore = new mainCore();
require_once TS_CLASS.'c.global.php';
require_once TS_CLASS.'c.usuario.php';
require_once TS_CLASS.'u.usuario.php';
require_once TS_EXT.'authCookieSessionValidate.php';
$cGlobal = new classGlobal();
$user = new Usuario();
$cUsuario = new classUsuario();
$web_nombre = $mainCore->getWebNombre();
$web_url = $mainCore->getWebUrl();
$util = new Util();
if (!$isLoggedIn) {
    $util->redirect("login.php");
}
$user->updateUltimaConexion();
echo '<!DOCTYPE html>
<html lang="es">
<head>
	<meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″ />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>'.$web_nombre.'- Inversiones</title>
	<!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="'.$web_url.'images/favicon.png">
	<link href="'.$web_url.'css/style.css" rel="stylesheet">
	<link rel="stylesheet" href="'.$web_url.'vendor/chartist/css/chartist.min.css">
    <link href="'.$web_url.'vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="'.$web_url.'vendor/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
	<link href="'.$web_url.'vendor/owl-carousel/owl.carousel.css" rel="stylesheet">
	<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-DJJVGZ60BN"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag("js", new Date());

  gtag("config", "G-DJJVGZ60BN");
</script>
</head>
<body>
<!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
		<a href="'.$web_url.'index.php" class="brand-logo">
                <svg class="logo-abbr" width="50" height="50" viewbox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<rect class="svg-logo-rect" width="50" height="50" rx="6" fill="#EB8153"></rect>
					<path class="svg-logo-path" d="M17.5158 25.8619L19.8088 25.2475L14.8746 11.1774C14.5189 9.84988 15.8701 9.0998 16.8205 9.75055L33.0924 22.2055C33.7045 22.5589 33.8512 24.0717 32.6444 24.3951L30.3514 25.0095L35.2856 39.0796C35.6973 40.1334 34.4431 41.2455 33.3397 40.5064L17.0678 28.0515C16.2057 27.2477 16.5504 26.1205 17.5158 25.8619ZM18.685 14.2955L22.2224 24.6007L29.4633 22.6605L18.685 14.2955ZM31.4751 35.9615L27.8171 25.6886L20.5762 27.6288L31.4751 35.9615Z" fill="white"></path>
				</svg>
                <img class="brand-title" src="images/logo-text.png">
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

		<!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
							<div class="input-group search-area right d-lg-inline-flex d-none">
								<input type="text" class="form-control" placeholder="Buscar...">
								<div class="input-group-append">
									<span class="input-group-text">
										<a href="javascript:void(0)">
											<i class="flaticon-381-search-2"></i>
										</a>
									</span>
								</div>
							</div>
                        </div>
                        <ul class="navbar-nav header-right main-notification">
							<li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link bell dz-fullscreen" href="#">
                                    <svg id="icon-full" viewbox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3" style="stroke-dasharray: 37, 57; stroke-dashoffset: 0;"></path></svg>
                                    <svg id="icon-minimize" width="20" height="20" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minimize"><path d="M8 3v3a2 2 0 0 1-2 2H3m18 0h-3a2 2 0 0 1-2-2V3m0 18v-3a2 2 0 0 1 2-2h3M3 16h3a2 2 0 0 1 2 2v3" style="stroke-dasharray: 37, 57; stroke-dashoffset: 0;"></path></svg>
                                </a>
							</li>
							<li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link  ai-icon" href="javascript:void(0)" role="button" data-toggle="dropdown">
                                   <svg class="bell-icon" width="24" height="24" viewbox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M22.75 15.8385V13.0463C22.7471 10.8855 21.9385 8.80353 20.4821 7.20735C19.0258 5.61116 17.0264 4.61555 14.875 4.41516V2.625C14.875 2.39294 14.7828 2.17038 14.6187 2.00628C14.4546 1.84219 14.2321 1.75 14 1.75C13.7679 1.75 13.5454 1.84219 13.3813 2.00628C13.2172 2.17038 13.125 2.39294 13.125 2.625V4.41534C10.9736 4.61572 8.97429 5.61131 7.51794 7.20746C6.06159 8.80361 5.25291 10.8855 5.25 13.0463V15.8383C4.26257 16.0412 3.37529 16.5784 2.73774 17.3593C2.10019 18.1401 1.75134 19.1169 1.75 20.125C1.75076 20.821 2.02757 21.4882 2.51969 21.9803C3.01181 22.4724 3.67904 22.7492 4.375 22.75H9.71346C9.91521 23.738 10.452 24.6259 11.2331 25.2636C12.0142 25.9013 12.9916 26.2497 14 26.2497C15.0084 26.2497 15.9858 25.9013 16.7669 25.2636C17.548 24.6259 18.0848 23.738 18.2865 22.75H23.625C24.321 22.7492 24.9882 22.4724 25.4803 21.9803C25.9724 21.4882 26.2492 20.821 26.25 20.125C26.2486 19.117 25.8998 18.1402 25.2622 17.3594C24.6247 16.5786 23.7374 16.0414 22.75 15.8385ZM7 13.0463C7.00232 11.2113 7.73226 9.45223 9.02974 8.15474C10.3272 6.85726 12.0863 6.12732 13.9212 6.125H14.0788C15.9137 6.12732 17.6728 6.85726 18.9703 8.15474C20.2677 9.45223 20.9977 11.2113 21 13.0463V15.75H7V13.0463ZM14 24.5C13.4589 24.4983 12.9316 24.3292 12.4905 24.0159C12.0493 23.7026 11.716 23.2604 11.5363 22.75H16.4637C16.284 23.2604 15.9507 23.7026 15.5095 24.0159C15.0684 24.3292 14.5411 24.4983 14 24.5ZM23.625 21H4.375C4.14298 20.9999 3.9205 20.9076 3.75644 20.7436C3.59237 20.5795 3.50014 20.357 3.5 20.125C3.50076 19.429 3.77757 18.7618 4.26969 18.2697C4.76181 17.7776 5.42904 17.5008 6.125 17.5H21.875C22.571 17.5008 23.2382 17.7776 23.7303 18.2697C24.2224 18.7618 24.4992 19.429 24.5 20.125C24.4999 20.357 24.4076 20.5795 24.2436 20.7436C24.0795 20.9076 23.857 20.9999 23.625 21Z" fill="#EB8153"></path>
									</svg>
									<div class="pulse-css"></div>
                                </a>
								<!--
								<div class="dropdown-menu dropdown-menu-right">
                                    <div id="dlab_W_Notification1" class="widget-media dz-scroll p-3 height380">
										<ul class="timeline">
											<li>
												<div class="timeline-panel">
													<div class="media mr-2">
														<img alt="image" width="50" src="images/avatar/1.jpg">
													</div>
													<div class="media-body">
														<h6 class="mb-1">Dr sultads Send you Photo</h6>
														<small class="d-block">29 July 2020 - 02:26 PM</small>
													</div>
												</div>
											</li>
											<li>
												<div class="timeline-panel">
													<div class="media mr-2 media-info">
														KG
													</div>
													<div class="media-body">
														<h6 class="mb-1">Resport created successfully</h6>
														<small class="d-block">29 July 2020 - 02:26 PM</small>
													</div>
												</div>
											</li>
											<li>
												<div class="timeline-panel">
													<div class="media mr-2 media-success">
														<i class="fa fa-home"></i>
													</div>
													<div class="media-body">
														<h6 class="mb-1">Reminder : Treatment Time!</h6>
														<small class="d-block">29 July 2020 - 02:26 PM</small>
													</div>
												</div>
											</li>
											 <li>
												<div class="timeline-panel">
													<div class="media mr-2">
														<img alt="image" width="50" src="images/avatar/1.jpg">
													</div>
													<div class="media-body">
														<h6 class="mb-1">Dr sultads Send you Photo</h6>
														<small class="d-block">29 July 2020 - 02:26 PM</small>
													</div>
												</div>
											</li>
											<li>
												<div class="timeline-panel">
													<div class="media mr-2 media-danger">
														KG
													</div>
													<div class="media-body">
														<h6 class="mb-1">Resport created successfully</h6>
														<small class="d-block">29 July 2020 - 02:26 PM</small>
													</div>
												</div>
											</li>
											<li>
												<div class="timeline-panel">
													<div class="media mr-2 media-primary">
														<i class="fa fa-home"></i>
													</div>
													<div class="media-body">
														<h6 class="mb-1">Reminder : Treatment Time!</h6>
														<small class="d-block">29 July 2020 - 02:26 PM</small>
													</div>
												</div>
											</li>
										</ul>
									</div>
                                    <a class="all-notification" href="javascript:void(0)">See all notifications <i class="ti-arrow-right"></i></a>
                                </div> -->
							</li>
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                    <img src="'.$user->userData()["user_avatar"].'" width="20" alt="">
									<div class="header-info">
										<span>'.$user->userData()["user_nombre"].'</span>
										<small>'.$cUsuario->getRangoNombre($user->getRango()).'</small>
									</div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
								<a href="'.$web_url.'perfil" class="dropdown-item ai-icon">
                                        <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        <span class="ml-2">Perfil</span>
                                    </a>
                                    <a href="salir.php" class="dropdown-item ai-icon">
                                        <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                        <span class="ml-2">Salir</span>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
				<div class="sub-header">
					<div class="d-flex align-items-center flex-wrap mr-auto">
						<h5 class="dashboard_bar">Dashboard</h5>
					</div>
				</div>
			</div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="deznav">
            <div class="deznav-scroll">
				<div class="main-profile">
					<div class="image-bx">
						<img src="'.$user->userData()["user_avatar"].'" alt="">
						<a href="'.$web_url.'perfil?opc=settings"><i class="fa fa-cog" aria-hidden="true"></i></a>
					</div>
					<h5 class="name"><span class="font-w400">Hola,</span> '.$user->userData()["user_nombre"].'</h5>
					<p class="email">'.$user->userData()["user_email"].'</p>
				</div>
				<ul class="metismenu" id="menu">
					<li class="nav-label first">Menu Principal</li>
                     <li><a href="index.php" class="ai-icon" aria-expanded="false">
							<i class="flaticon-144-layout"></i>
							<span class="nav-text">Dashboard</span>
						</a>
					</li>
					<li><a href="mercados" class="ai-icon" aria-expanded="false">
							<i class="flaticon-004-bar-chart"></i>
							<span class="nav-text">Mercados</span>
						</a>
					</li>
					<li class="nav-label">Apps</li>
					<li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-077-menu-1"></i>
								<span class="nav-text">Instrumentos</span>
							</a>
							<ul aria-expanded="false">
								<li><a href="listadoInstrumentos">Inicio</a></li>
								<li><a href="listadoInstrumentos?tipo=acciones">Acciones</a></li>
								<li><a href="listadoInstrumentos?tipo=cedear">Cedears</a></li>
								<li><a href="listadoInstrumentos?tipo=criptomoneda">Criptomonedas</a></li>
								<li><a href="listadoInstrumentos?tipo=fondos">Fondos</a></li>
							</ul>
						</li>
                    <li><a href="calendario" class="ai-icon" aria-expanded="false">
							<i class="flaticon-381-calendar-1"></i>
							<span class="nav-text">Calendario</span>
						</a>
					</li>
					<li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-008-credit-card"></i>
							<span class="nav-text">Inversiones</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="wallet">Wallet</a></li>
                            <li><a href="wallet?opc=add">Añadir Wallet</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-053-heart"></i>
							<span class="nav-text">Favoritos</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="favoritos">Listado</a></li>
							<li><a href="favoritos?tenencia=true">En Tenencia</a></li>
                            <li><a href="favoritos?opcion=add">Agregar</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-381-network"></i>
							<span class="nav-text">Gastos</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="gastos">Inicio</a></li>
                            <li><a href="gastos?gastoOpc=diario">Diarios</a></li>
                            <li><a href="gastos?gastoOpc=fijos">Fijos</a></li>
                            <li><a href="gastos?gastoOpc=tarjeta">Tarjetas</a></li>
                        </ul>
                    </li>';
					if($user->getRango() == 2){
						echo '<li class="nav-label">Administracion</li>
						<li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-077-menu-1"></i>
								<span class="nav-text">Intrumentos</span>
							</a>
							<ul aria-expanded="false">
								<li><a href="agregarInstrumento">Agregar Instrumento</a></li>
								<li><a href="split">Split</a></li>
							</ul>
						</li>
						<li><a href="listadoUsuarios" class="ai-icon" aria-expanded="false">
								<i class="flaticon-381-user-9"></i>
								<span class="nav-text">Lista Usuarios</span>
							</a>
						</li>
						<li><a href="backup-db.php" class="ai-icon" aria-expanded="false">
								<i class="flaticon-381-cloud-computing"></i>
								<span class="nav-text">Base de Datos</span>
							</a>
						</li>
						<li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
								<i class="flaticon-003-diamond"></i>
								<span class="nav-text">Noticias</span>
							</a>
							<ul aria-expanded="false">
								<li><a href="ui-accordion.html">Accordion</a></li>
								<li><a href="ui-alert.html">Alert</a></li>
								<li><a href="ui-badge.html">Badge</a></li>
								<li><a href="ui-button.html">Button</a></li>
								<li><a href="ui-modal.html">Modal</a></li>
								<li><a href="ui-button-group.html">Button Group</a></li>
								<li><a href="ui-list-group.html">List Group</a></li>
								<li><a href="ui-media-object.html">Media Object</a></li>
								<li><a href="ui-card.html">Cards</a></li>
								<li><a href="ui-carousel.html">Carousel</a></li>
								<li><a href="ui-dropdown.html">Dropdown</a></li>
								<li><a href="ui-popover.html">Popover</a></li>
								<li><a href="ui-progressbar.html">Progressbar</a></li>
								<li><a href="ui-tab.html">Tab</a></li>
								<li><a href="ui-typography.html">Typography</a></li>
								<li><a href="ui-pagination.html">Pagination</a></li>
								<li><a href="ui-grid.html">Grid</a></li>
	
							</ul>
						</li>
						
						
						<li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
								<i class="flaticon-044-file"></i>
								<span class="nav-text">Comunidades</span>
							</a>
							<ul aria-expanded="false">
								<li><a href="form-element.html">Form Elements</a></li>
								<li><a href="form-wizard.html">Wizard</a></li>
								<li><a href="form-editor-summernote.html">Summernote</a></li>
								<li><a href="form-pickers.html">Pickers</a></li>
								<li><a href="form-validation-jquery.html">Jquery Validate</a></li>
							</ul>
						</li>
						
						<li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
								<i class="flaticon-049-copy"></i>
								<span class="nav-text">Tiquets</span>
							</a>
							<ul aria-expanded="false">
								<li><a href="page-register.html">Register</a></li>
								<li><a href="page-login.html">Login</a></li>
								<li><a class="has-arrow" href="javascript:void()" aria-expanded="false">Error</a>
									<ul aria-expanded="false">
										<li><a href="page-error-400.html">Error 400</a></li>
										<li><a href="page-error-403.html">Error 403</a></li>
										<li><a href="page-error-404.html">Error 404</a></li>
										<li><a href="page-error-500.html">Error 500</a></li>
										<li><a href="page-error-503.html">Error 503</a></li>
									</ul>
								</li>
								<li><a href="page-lock-screen.html">Lock Screen</a></li>
							</ul>
						</li>';
					}
                echo '</ul>
			</div>
        </div>';
?>            