<?php require "header.php"; 
$id_POST = $_GET['id'];
require_once("includes/publicaciones.class.php");
require_once("includes/perfil.class.php");
$authPerfil = new AuthPerfil();
$authPublicaciones = new AuthPublicaciones();
$post = $authPublicaciones->getPost($id_POST)[0];
$autorPost = $auth->getMemberById($post["post_user"]);
?>
        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-4">
						<div class="row">
                        <div class="col-xl-12">
                        <div class="card">
									<div class="card-header border-0">
										<h4 class="mb-0 text-black fs-20">Autor</h4>
									</div>
									<div class="card-body">
										<div class="text-center">
											<div class="my-profile">
												<img src="<?php echo $autorPost[0]["user_avatar"];?>" alt="" class="rounded">
											</div>
											<h4 class="mt-3 font-w600 text-black mb-0 name-text"><?php echo $autorPost[0]["user_nombre"]." ".$autorPost[0]["user_apellido"];?></h4>
											<span>@</span>
										</div>
                                        <div class="profile-statistics">
											<div class="text-center">
												<div class="row">
													<div class="col">
														<h3 class="m-b-0">150</h3><span>Follower</span>
													</div>
													<div class="col">
														<h3 class="m-b-0"><?php echo $authPerfil->countPublicaciones($post["post_user"]);?></h3><span>Publicaciones</span>
													</div>
													<div class="col">
														<h3 class="m-b-0">45</h3><span>Reviews</span>
													</div>
												</div>
												<div class="mt-4">
													<a href="javascript:void();;" class="btn btn-primary mb-1 me-1">Follow</a> 
													<a href="javascript:void();;" class="btn btn-primary mb-1" data-bs-toggle="modal" data-bs-target="#sendMessageModal">Send Message</a>
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
										<div class="profile-blog">
											<h5 class="text-primary d-inline">Today Highlights</h5>
											<img src="images/profile/1.jpg" alt="" class="img-fluid mt-4 mb-4 w-100">
											<h4><a href="post-details.html" class="text-black">Darwin Creative Agency Theme</a></h4>
											<p class="mb-0">A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth.</p>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-12">
								<div class="card">
									<div class="card-body">
										<div class="profile-interest">
											<h5 class="text-primary d-inline">Interest</h5>
											<div class="row mt-4 sp4" id="lightgallery">
												<a href="images/profile/2.jpg" data-exthumbimage="images/profile/2.jpg" data-src="images/profile/2.jpg" class="mb-1 col-lg-4 col-xl-4 col-sm-4 col-6">
													<img src="images/profile/2.jpg" alt="" class="img-fluid">
												</a>
												<a href="images/profile/3.jpg" data-exthumbimage="images/profile/3.jpg" data-src="images/profile/3.jpg" class="mb-1 col-lg-4 col-xl-4 col-sm-4 col-6">
													<img src="images/profile/3.jpg" alt="" class="img-fluid">
												</a>
												<a href="images/profile/4.jpg" data-exthumbimage="images/profile/4.jpg" data-src="images/profile/4.jpg" class="mb-1 col-lg-4 col-xl-4 col-sm-4 col-6">
													<img src="images/profile/4.jpg" alt="" class="img-fluid">
												</a>
												<a href="images/profile/3.jpg" data-exthumbimage="images/profile/3.jpg" data-src="images/profile/3.jpg" class="mb-1 col-lg-4 col-xl-4 col-sm-4 col-6">
													<img src="images/profile/3.jpg" alt="" class="img-fluid">
												</a>
												<a href="images/profile/4.jpg" data-exthumbimage="images/profile/4.jpg" data-src="images/profile/4.jpg" class="mb-1 col-lg-4 col-xl-4 col-sm-4 col-6">
													<img src="images/profile/4.jpg" alt="" class="img-fluid">
												</a>
												<a href="images/profile/2.jpg" data-exthumbimage="images/profile/2.jpg" data-src="images/profile/2.jpg" class="mb-1 col-lg-4 col-xl-4 col-sm-4 col-6">
													<img src="images/profile/2.jpg" alt="" class="img-fluid">
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-12">
								<div class="card">
									<div class="card-body">
										<div class="profile-news">
											<h5 class="text-primary d-inline">Our Latest News</h5>
											<div class="media pt-3 pb-3">
												<img src="images/profile/5.jpg" alt="image" class="me-3 rounded" width="75">
												<div class="media-body">
													<h5 class="m-b-5"><a href="post-details.html" class="text-black">Collection of textile samples</a></h5>
													<p class="mb-0">I shared this on my fb wall a few months back, and I thought.</p>
												</div>
											</div>
											<div class="media pt-3 pb-3">
												<img src="images/profile/6.jpg" alt="image" class="me-3 rounded" width="75">
												<div class="media-body">
													<h5 class="m-b-5"><a href="post-details.html" class="text-black">Collection of textile samples</a></h5>
													<p class="mb-0">I shared this on my fb wall a few months back, and I thought.</p>
												</div>
											</div>
											<div class="media pt-3 pb-3">
												<img src="images/profile/7.jpg" alt="image" class="me-3 rounded" width="75">
												<div class="media-body">
													<h5 class="m-b-5"><a href="post-details.html" class="text-black">Collection of textile samples</a></h5>
													<p class="mb-0">I shared this on my fb wall a few months back, and I thought.</p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
                    </div>
                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-body">
								<div class="post-details">
									<h3 class="mb-2 text-black">Collection of textile samples lay spread</h3>
									<ul class="mb-4 post-meta d-flex flex-wrap">
										<li class="post-date me-3"><i class="far fa-calendar-plus me-2"></i><?php echo $post["post_fecha"];?></li>
										<li class="post-comment"><i class="far fa-comment me-2"></i>28</li>
									</ul>
									<img src="images/profile/8.jpg" alt="" class="img-fluid mb-3 w-100 rounded">
									<p><?php echo $post["post_contenido"]; ?></p>
									<div class="comment-respond" id="respond">
										<h4 class="comment-reply-title text-primary mb-3" id="reply-title">Comentar </h4>
										<form class="comment-form" id="commentform" method="post">
											<div class="row"> 
												<div class="col-lg-12">
													<div class="mb-3">
														<textarea rows="8" class="form-control" name="comment" placeholder="Comment" id="comment"></textarea>
													</div>
												</div>
												<div class="col-lg-12">
													<div class="mb-3">
														<input type="submit" value="Post Comment" class="submit btn btn-primary" id="submit" name="submit">
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       <?php require "footer.php"; ?>