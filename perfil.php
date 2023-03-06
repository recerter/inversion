 <?php require ("header.php"); 
require_once TS_CLASS.'c.instrumento.php';
require_once TS_CLASS.'c.publicaciones.php';
$cInstrumento = new instrumento();
$cPublicaciones = new publicaciones();
if(isset($_GET["id"])){
	$perfil = $_GET["id"];
}else{
	$perfil = $user->userData()["user_id"];
}
$perfil_activo = $cUsuario->getMemberById($perfil);
if (! empty($_POST["post"])) {
	$imagen = "NULL";
	$cPublicaciones->nuevoPost($user->userData()["user_id"], $_POST["contenido"], $imagen);
}
if(isset($_GET["opc"])){
	$opcionActiva = $_GET["opc"];
}else{
	$opcionActiva = "posts";
}
	?>
    	<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
			<div class="container-fluid">
                <!-- row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="profile card card-body px-3 pt-3 pb-0">
                            <div class="profile-head">
                                <div class="photo-content">
                                    <div class="cover-photo"></div>
                                </div>
                                <div class="profile-info">
									<div class="profile-photo">
										<img src="<?php echo $perfil_activo[0]["user_avatar"];?>" class="img-fluid rounded-circle" alt="">
									</div>
									<div class="profile-details">
										<div class="profile-name px-3 pt-2">
											<h4 class="text-primary mb-0"><?php echo $perfil_activo[0]["user_nombre"]." ".$perfil_activo[0]["user_apellido"];?></h4>
											<p><?php echo $cUsuario->getRangoNombre($perfil_activo[0]["user_rango"]); ?></p>
										</div>
										<?php if($user->getRango() == 2){
											echo '<div class="dropdown ml-auto">
											<a href="#" class="btn btn-primary light sharp" data-toggle="dropdown" aria-expanded="true"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewbox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg></a>
											<ul class="dropdown-menu dropdown-menu-right">
												<li class="dropdown-item"><i class="fa fa-user-circle text-primary mr-2"></i> View profile</li>
												<li class="dropdown-item"><i class="fa fa-users text-primary mr-2"></i> Add to close friends</li>
												<li class="dropdown-item"><i class="fa fa-plus text-primary mr-2"></i> Add to group</li>
												<li class="dropdown-item"><i class="fa fa-ban text-primary mr-2"></i> Block</li>
											</ul>
										</div>';
										}?>
										
									</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4">
						<div class="row">
							<div class="col-xl-12">
								<div class="card">
									<div class="card-body">
										<div class="profile-statistics">
											<div class="text-center">
												<div class="row">
													<div class="col">
														<h3 class="m-b-0">0</h3><span>Seguidores</span>
													</div>
													<div class="col">
														<h3 class="m-b-0"><?php echo $cPublicaciones->countPublicaciones($perfil);?></h3><span>Post</span>
													</div>
													<div class="col">
														<h3 class="m-b-0">0</h3><span>Comentarios</span>
													</div>
												</div>
												<div class="mt-4">
													<a href="javascript:void(0);" class="btn btn-primary mb-1 mr-1">Seguir</a> 
													<a href="javascript:void(0);" class="btn btn-primary mb-1" >Enviar Mensaje</a>
												</div>
											</div>
											<!-- Modal -->
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-12">
								<div class="card">
									<div class="card-body">
										<div class="profile-news">
											<h5 class="text-primary d-inline">En que invierte el usuario</h5>
											<?php $instrumentos = $cUsuario->instrumentoInvierteListado($perfil,15); 
											while($instrumento = $instrumentos->fetch(PDO::FETCH_ASSOC)){
												$moneda_buscar = $cInstrumento->getInstrumentoSigla($instrumento["Wportfolio_instrumento"]);?>
											<div class="media pt-3 pb-3">
												<img src="<?php echo $moneda_buscar["instrumento_imagen"]; ?>" alt="image" class="mr-3 rounded" width="75">
												<div class="media-body">
													<h5 class="m-b-5"><a href="monedaDetalle?instrumento=<?php echo $moneda_buscar["instrumento_sigla"]; ?>" class="text-black"><?php echo $moneda_buscar["instrumento_nombre"]; ?></a></h5>
													<p class="mb-0"><?php echo $moneda_buscar["instrumento_tipo"]; ?></p>
												</div>
											</div>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
						</div>
                    </div>
                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="profile-tab">
                                    <div class="custom-tab-1">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item"><a href="?id=<?php echo $perfil;?>&opc=posts" class="nav-link">Posts</a>
                                            </li>
											<?php if($user->userData()["user_id"] == $perfil){
												echo '<li class="nav-item"><a href="?opc=settings" class="nav-link">Configuracion</a>
												</li>
												<li class="nav-item"><a href="?opc=sessiones" class="nav-link">Sessiones</a>
												</li>';
											} ?>
                                        </ul>
                                        <div class="tab-content">
												<?php 
												switch ($opcionActiva) {
													case 'posts':
														echo '<div id="my-posts" class="tab-pane fade active show">
														<div class="my-post-content pt-3">
															<form action="'.$_SERVER['PHP_SELF'].'" method="post">
															<div class="post-input">
																<textarea name="contenido" id="contenido" cols="30" rows="5" class="form-control bg-transparent" placeholder="Escribe un comentario...."></textarea> 
		
																<!-- Modal -->
																<button name="post" type="submit" value="post" class="btn btn-primary btn-block">Post</button>
																<!-- Modal -->
															</div>
															</form>';
															$listadoPost = $cPublicaciones->listarPosts($perfil);
																	while ($lPost = $listadoPost->fetch(PDO::FETCH_ASSOC)) { 
																		
															echo'<div class="profile-uoloaded-post border-bottom-1 pb-5">';
																if($lPost["post_imagen"] != "NULL"){
																	echo '<img src="'.$lPost["post_imagen"].'" alt="" class="img-fluid w-100">';
																}
																echo'<a class="post-title" href="post?id='.$lPost["post_id"].'">
																<p>'.$lPost["post_contenido"].'</p></a>
																<button class="btn btn-primary mr-2"><span class="mr-2"><i class="fa fa-heart"></i></span>Like</button>
																<button class="btn btn-secondary"><span class="mr-2"><i class="fa fa-reply"></i></span>Comentar</button>
															</div>';
															}
														echo'</div>
													</div>';
														break;
													case 'settings':
														if($user->userData()["user_id"] != $perfil)
															$util->redirect2("perfil");
														echo '<div id="profile-settings" class="tab-pane fade active show">
														<div class="pt-3">
															<div class="settings-form">
																<h4 class="text-primary">Configuracion</h4>
																<form>
																	<div class="form-row">
																		<div class="form-group col-md-6">
																			<label>Email</label>
																			<input type="email" placeholder="Email" class="form-control">
																		</div>
																		<div class="form-group col-md-6">
																			<label>Password</label>
																			<input type="password" placeholder="Password" class="form-control">
																		</div>
																	</div>
																	<div class="form-group">
																		<label>Direccion</label>
																		<input type="text" placeholder="1234 Main St" class="form-control">
																	</div>
																	<div class="form-group">
																		<label>Direccion 2</label>
																		<input type="text" placeholder="Apartment, studio, or floor" class="form-control">
																	</div>
																	<div class="form-row">
																		<div class="form-group col-md-6">
																			<label>Ciudad</label>
																			<input type="text" class="form-control">
																		</div>
																		<div class="form-group col-md-4">
																			<label>Provincia</label>
																			<select class="form-control default-select" id="inputState">
																				<option selected="">Choose...</option>
																				<option>Option 1</option>
																				<option>Option 2</option>
																				<option>Option 3</option>
																			</select>
																		</div>
																		<div class="form-group col-md-2">
																			<label>Zip</label>
																			<input type="text" class="form-control">
																		</div>
																	</div>
																	<button class="btn btn-primary" type="submit">Modificar</button>
																</form>
															</div>
														</div>
													</div>';
														break;

													case 'sessiones':
														if($user->userData()["user_id"] != $perfil)
															$util->redirect2("perfil");
														echo '<div id="profile-settings" class="tab-pane fade active show">
														<div class="pt-3">
															<div class="settings-form">
																<h4 class="text-primary">Sessiones Activas</h4>
																<table class="table verticle-middle table-responsive-md">
                                        <thead>
                                            <tr>
                                                <th scope="col">Navegador</th>
                                                <th scope="col">IP</th>
                                                <th scope="col">Fecha</th>
                                                <th scope="col">Estado</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
										';
										$listadoSessiones = $user->sessionesActivas();
										while ($lSessiones = $listadoSessiones->fetch(PDO::FETCH_ASSOC)) { 
                                          echo'<tr>
                                                <td>'.$lSessiones["navegador"].'</td>
                                                <td>'.$lSessiones["ip"].'</td>
                                                <td>'.date("Y-m-d H:i:s",strtotime($lSessiones["expiry_date"]."- 30 days")).'</td>';
												if($lSessiones["is_expired"] == 1){
													echo'<td><span class="badge badge-danger">Expirada</span></td>';
												}else{
													echo'<td><span class="badge badge-success">Activa</span></td>';
												}
                                                
                                                echo '<td>
                                                    Eliminar
                                                </td>
                                            </tr>';
										}
                                            

											echo'</tbody>
                                    </table>
															</div>
														</div>
													</div>';
														break;
												
													default:
													$util->redirect2("perfil");
														break;
												} ?>
                                        </div>
                                    </div>
									<!-- Modal -->
									<div class="modal fade" id="replyModal">
										<div class="modal-dialog modal-dialog-centered" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title">Post Reply</h5>
													<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
												</div>
												<div class="modal-body">
													<form>
														<textarea class="form-control" rows="4">Message</textarea>
													</form>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
													<button type="button" class="btn btn-primary">Reply</button>
												</div>
											</div>
										</div>
									</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<?php require ("footer.php"); ?>