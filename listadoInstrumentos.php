<?php
require ("header.php"); 
require_once TS_CLASS.'c.instrumento.php';
require_once TS_EXT.'inversionPrecio.php';
$cInstrumento = new instrumento();
$moneda = new precio();
$resultadosPorPagina = 25;

if(isset($_GET["pagina"])){
    $pagina = ($_GET["pagina"] - 1) * $resultadosPorPagina;
}else{
    $_GET["pagina"] = 1;
    $pagina = 0;
}
?>
<div class="content-body">
            <div class="container-fluid">
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Listado de Instrumentos</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Table</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Listado de instrumentos</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Instrumentos Disponibles para operar</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-responsive-md">
                                        <thead>
                                            <tr>
                                                <th><strong>ID</strong></th>
                                                <th><strong>Nombre</strong></th>
                                                <th><strong>Precio</strong></th>
                                                <th><strong>Variación</strong></th>
                                                <th><strong>Tipo</strong></th>
                                                <th><strong>Status</strong></th>
                                                <th><strong>Ultima Actualización</strong></th>
                                                <?php if($user->getRango() == 2){ echo '<th></th>'; } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $db_handle = new DBController();
                                        $pdo = $db_handle->connectDB();
                                        if(isset($_GET["tipo"])){
                                            // La clave "tipo" está definida en el array $_GET
                                            $instrumentos = $cInstrumento->getInstrumentoTipo($_GET['tipo'], array($pagina, $resultadosPorPagina));
                                        } else {
                                            // La clave "tipo" no está definida en el array $_GET
                                            $_GET['tipo'] = NULL;
                                            $instrumentos = $cInstrumento->getInstrumentoTipo($_GET['tipo'], array($pagina, $resultadosPorPagina));
                                        }
                                                                                
                                                                                // Obtenemos la página actual
                                        $pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
                                        if ($pagina < 1) {
                                            $pagina = 1;
                                        }

                                        // Calculamos los valores de offset y limit para la consulta
                                        $offset = ($pagina - 1) * $resultadosPorPagina;
                                        $limit = $resultadosPorPagina;

                                        // Preparamos la consulta SQL con los parámetros de offset y limit
                                        $sql = "SELECT * FROM inversion_instrumentos WHERE 1=1 LIMIT :offset, :limit";
                                        $stmt = $pdo->prepare($sql);
                                        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
                                        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);

                                        // Ejecutamos la consulta y obtenemos los resultados
                                        $stmt->execute();
                                        $instrumentosArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        $rowCount = count($instrumentosArray);

                                        foreach ($instrumentos as $instrumento) {
                                            $moneda_buscar = $cInstrumento->getInstrumentoId($instrumento["instrumento_id"]);
                                            // código para mostrar cada instrumento
?>
                                            <tr>
                                                <td><strong><?php echo $instrumento["instrumento_id"]; ?></strong></td>
                                                <td><div class="d-flex align-items-center"><a href="monedaDetalle?instrumento=<?php echo $instrumento["instrumento_sigla"]; ?>"><img src="<?php echo $util->reemplazar_imagen($instrumento["instrumento_imagen"],"http://inversiones.ovitec.com.ar/images/card/card1.jpg"); ?>" class="rounded-lg mr-2" width="24" alt=""> <span class="w-space-no">[<?php echo $instrumento["instrumento_sigla"]; ?>] <?php echo $instrumento["instrumento_nombre"]; ?></span></a></div></td>

                                                <td><?php echo $instrumento["instrumento_moneda"]; ?> <?php echo $moneda_buscar["instrumento_ultimoPrecio"]; ?></td>
                                                <?php if($instrumento["instrumento_ultimoPrecioCambio"]>0){
                                                    echo '<td><p class="text-success">'.number_format((float)$instrumento["instrumento_ultimoPrecioCambio"], 2, ".", "").'%</p></td>';
                                                }elseif($instrumento["instrumento_ultimoPrecioCambio"]<0){
                                                    echo '<td><p class="text-danger">'.number_format((float)$instrumento["instrumento_ultimoPrecioCambio"], 2, ".", "").'%</p></td>';
                                                }else{
                                                    echo '<td><p class="text-dark">'.number_format((float)$instrumento["instrumento_ultimoPrecioCambio"], 2, ".", "").'%</p></td>';
                                                }?>
                                                <td><?php echo $instrumento["instrumento_tipo"]; ?></td>
                                                <td><div class="d-flex align-items-center"><i class="fa fa-circle text-success mr-1"></i>Activo</div></td>
                                                <td><?php echo $instrumento["instrumento_ultimoPrecioFecha"]; ?></td>
                                                <?php if($user->getRango() == 2){ ?>
                                                    <td>
                                                    <div class="d-flex">
                                                        <a href="#" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                                        <a href="#" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                                    </div>
                                                    </td>
                                                    <?php } ?>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>

                                <nav>
                                    <ul class="pagination pagination-gutter">
                                        <li class="page-item page-indicator">
                                            <a class="page-link" href="listadoInstrumentos?<?php if(isset($_GET["tipo"])){ echo"tipo=".$_GET['tipo']."&"; } ?>pagina=<?php echo $_GET["pagina"]-1; ?>">
                                                <i class="la la-angle-left"></i></a>
                                                <?php
                                                $paginasTotal = ($rowCount/$resultadosPorPagina)+1;
                                                for($i=1; $i <= $paginasTotal; $i++){ ?>
                                                    </li>
                                        <li class="page-item <?php if($_GET["pagina"] == $i){ echo'active'; }?>"><a class="page-link" href="listadoInstrumentos?<?php if(isset($_GET["tipo"])){ echo"tipo=".$_GET['tipo']."&"; } ?>pagina=<?php echo $i;?>"><?php echo $i;?></a>
                                        </li>
                                                <?php } ?>
                                        <li class="page-item page-indicator">
                                            <a class="page-link" href="listadoInstrumentos?<?php if(isset($_GET["tipo"])){ echo"tipo=".$_GET['tipo']."&"; } ?>pagina=<?php echo $_GET["pagina"]+1; ?>">
                                                <i class="la la-angle-right"></i></a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php include("footer.php"); ?>