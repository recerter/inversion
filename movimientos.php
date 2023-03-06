<?php require ("header.php"); 
if(isset($_GET["pagina"])){
    if($_GET["pagina"] == 1){
        $pagina = 0;
    }else{
        $pagina = $_GET["pagina"];
        $pagina = ($pagina*25)-25;
    }
}else{
    $_GET["pagina"] = 1;
    $pagina = 0;
}
?>
        <div class="content-body">
			<div class="container-fluid">
				<div class="form-head d-flex align-items-center flex-wrap mb-sm-5 mb-3">
					<h2 class="font-w600 mb-0 text-black">Mis Movimientos</h2>
				</div>
				<div class="row">
					<div class="col-xl-12">
						<div class="table-responsive table-hover fs-14">
							<table class="table display mb-4 dataTablesCard short-one card-table text-black" id="example5">
								<thead>
									<tr>
										<th>TRASCID</th>
										<th>Fecha</th>
										<th>Note</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
										<?php
										$usuario = $user->userData()["user_id"];
                                            $inversion_log = $user->getLog();
                                            while($log = $inversion_log->fetch(PDO::FETCH_ASSOC)){ ?>
									<tr>
										<th>#<?php  echo $log["log_id"];?></th>
										<td><?php  echo $log["log_fecha"];?></td>
										<td>
											<p class="mb-0 text-dark"><?php echo $log["log_descripcion"];?></p>
										</td>
										<td>
											<a class="btn-link text-success float-right">COMPLETED</a>
										</td>
									</tr>
								<?php } ?>
								</tbody>
							</table>
							<nav>
                                    <ul class="pagination pagination-gutter">
                                        <li class="page-item page-indicator">
                                            <a class="page-link" href="movimientos?pagina=<?php echo $_GET["pagina"]-1; ?>">
                                                <i class="la la-angle-left"></i></a>
                                                <?php
                                                 for($i=1; $i <=8; $i++){ ?>
                                                    </li>
                                        <li class="page-item <?php if($_GET["pagina"] == $i){ echo'active'; }?>"><a class="page-link" href="movimientos?pagina=<?php echo $i;?>"><?php echo $i;?></a>
                                        </li>
                                                <?php } ?>
                                        <li class="page-item page-indicator">
                                            <a class="page-link" href="movimientos?pagina=<?php echo $_GET["pagina"]+1; ?>">
                                                <i class="la la-angle-right"></i></a>
                                        </li>
                                    </ul>
                                </nav>
						</div>	
					</div>
				</div>
			</div>
		</div>
<?php require ("footer.php"); ?>