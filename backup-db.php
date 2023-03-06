<?php
require ("header.php");
$db_handle = new DBController();
if(isset($_GET["backup"])){
    $db_handle->exportarTablas();
}
if($user->userData()["user_rango"] != 2){
    $util->redirect2("index.php");
}
?>		
		<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
			<div class="container-fluid">
				<div class="project-nav">
					<div class="card-action card-tabs  mr-auto">

					</div>
					<a href="?backup=true" class="btn btn-primary">+Nuevo BackUP </a>
				</div>
				<div class="tab-content project-list-group" id="myTabContent">	
					<div class="tab-pane fade active show" id="navpills-1">
                        <?php
                        $ruta = "respaldos";
                        if (is_dir($ruta)){
        // Abre un gestor de directorios para la ruta indicada
        $gestor = opendir($ruta);

        // Recorre todos los elementos del directorio
        while (($archivo = readdir($gestor)) !== false)  {
                
            $ruta_completa = $ruta . "/" . $archivo;

            // Se muestran todos los archivos y carpetas excepto "." y ".."
            if ($archivo != "." && $archivo != ".." && $archivo != "index.html") {
                echo '<div class="card">
                <div class="project-info">
                    <div class="col-xl-4 my-2 col-lg-4 col-sm-6">
                        <p class="text-primary mb-1">#'.substr($archivo, 20, 13).'</p>
                        <h5 class="title font-w600 mb-2"><a href="'.$ruta.'/'.$archivo.'" class="text-black">'.$archivo.'</a></h5>
                        <div class="text-dark"><i class="fa fa-calendar-o mr-3" aria-hidden="true"></i>Creado '.substr($archivo, 9, 10).'</div>
                    </div>
                    <div class="col-xl-2 my-2 col-lg-6 col-sm-6">
                        <div class="d-flex project-status align-items-center">
                            <span class="btn bgl-success text-success status-btn mr-3">Completado</span>
                        </div>
                    </div>
                </div>
            </div>';                
            }
        }
        // Cierra el gestor de directorios
        closedir($gestor);
    }
        ?>			
				</div>
			</div>
		</div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
        <?php require("footer.php"); ?>