<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
			<header id="header-main" class="border-boxed expanded">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-right">
							<a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/res/logo.png" class="img-circle" height="80px" alt="logo"></a>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-2 hidden-xs text-center">
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 hidden-xs text-center">
							<a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/res/heading.png" alt="heading"></a>
						</div>
						<div class="col-lg-5 col-md-5 col-sm-6 col-xs-10 text-center">
<?php if (isset($actor) && $actor != null) { ?>
							<div class="row" style="height: 40px; padding-top: 3px;">
								<div class="col-lg-5 col-md-5 col-sm-5 col-xs-3 text-center">
								</div>
								<div class="col-lg-7 col-md-7 col-sm-7 col-xs-9 text-left">
									<button id="notifications-2" type="button" class="btn btn-md btn-link btn-link-light" data-toggle="popover" data-html="true" data-placement="bottom" data-trigger="focus"><span class="glyphicon glyphicon-pushpin"></span> Noty (1)</button>
									<a class="btn btn-md btn-link btn-link-light" href="<?php echo base_url(); ?>Guest/profile/<?php echo $actor->getId(); ?>"><span class="glyphicon glyphicon-user"></span> Profile</a>
								</div>
							</div>
							<div class="row" style="height: 40px; padding-top: 3px;">
								<div class="col-lg-5 col-md-5 col-sm-5 col-xs-3 text-center">
								</div>
								<div class="col-lg-7 col-md-7 col-sm-7 col-xs-9 text-left">
									<button type="button" class="btn btn-md btn-link btn-link-light" data-toggle="popover" data-html="true" data-placement="bottom" data-trigger="focus"
										data-content=
										'
											<div class="list-group no-margin">
<?php if (Privilege::has($actor->getRawRank(), 'CreateSubject')) { ?>
												<a class="cursor-pointer list-group-item list-group-item-action" onclick="createSubjectPopupFeed.Toggle(0);">Create Subject</a>
<?php } if (Privilege::has($actor->getRawRank(), 'CreateSection')) { ?>
												<a class="cursor-pointer list-group-item list-group-item-action" onclick="createSectionPopupFeed.Toggle(0);">Create Section</a>
<?php } if (Privilege::has($actor->getRawRank(), 'BuyTokens')) { ?>
												<a class="cursor-pointer list-group-item list-group-item-action" onclick="buyTokensPopupFeed.Toggle(0);">Buy Tokens</a>
<?php } if (Privilege::has($actor->getRawRank(), 'SellTokens')) { ?>
												<a class="cursor-pointer list-group-item list-group-item-action" onclick="sellTokensPopupFeed.Toggle(0);">Sell Tokens</a>
<?php } if (Privilege::has($actor->getRawRank(), 'CreatePost')) { ?>
												<a class="cursor-pointer list-group-item list-group-item-action" href="<?php echo base_url(); ?>User/create-post">Create Post</a>
<?php } ?>
												<a class="cursor-pointer list-group-item list-group-item-action" href="<?php echo base_url(); ?>User/req_promotion">Submit Request</a>
											</div>
										'
									><span class="glyphicon glyphicon-wrench"></span> Tools</button>
									<a class="btn btn-md btn-link btn-link-light" onclick="logout();"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
								</div>
							</div>
<?php } else { ?>
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
<?php } ?>
						</div>
					</div>
				</div>
			</header>