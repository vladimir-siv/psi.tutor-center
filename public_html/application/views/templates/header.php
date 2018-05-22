<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
			<header id="header-main" class="border-boxed expanded">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-right">
							<a href="index.html"><img src="<?php echo base_url(); ?>assets/res/logo.png" class="img-circle" height="80px" alt="logo"></a>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-2 hidden-xs text-center">
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 hidden-xs text-center">
							<a href="index.html"><img src="<?php echo base_url(); ?>assets/res/heading.png" alt="heading"></a>
						</div>
						<div class="col-lg-5 col-md-5 col-sm-6 col-xs-10 text-center">
							<div class="row" style="height: 40px; padding-top: 3px;">
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center">
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center">
									<a class="btn btn-md btn-link btn-link-light" onclick="registerPopupFeed.Toggle(0);"><span class="glyphicon glyphicon-user"></span> Sign Up</a>
								</div>
							</div>
							<div class="row" style="height: 40px; padding-top: 3px;">
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center">
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center">
									<a class="btn btn-md btn-link btn-link-light" onclick="loginPopupFeed.Toggle(0);"><span class="glyphicon glyphicon-log-in"></span> Login</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</header>