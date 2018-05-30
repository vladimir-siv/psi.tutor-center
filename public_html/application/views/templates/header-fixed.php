<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
			<div id="top-content-fixed" class="border-boxed expanded p-fixed on-top">
				<header id="header-fixed" class="border-boxed expanded p-fixed top-trans-fast">
					<div class="container-fluid">
						<div class="row">
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-right">
								<a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/res/logo.png" class="img-circle" height="40px" alt="logo"></a>
							</div>
<?php if (isset($actor) && $actor != null) { ?>
							<div class="col-lg-5 col-md-6 col-sm-2 col-xs-2 text-center"></div>
							<div class="col-lg-4 col-md-4 col-sm-8 col-xs-8 text-center">
								<button id="notifications-1" type="button" class="btn btn-xs btn-link btn-link-light" data-toggle="popover" data-html="true" data-placement="bottom" data-trigger="focus"><span class="glyphicon glyphicon-pushpin"></span> Noty (0)</button>
								<button type="button" class="btn btn-xs btn-link btn-link-light" data-toggle="popover" data-html="true" data-placement="bottom" data-trigger="focus"
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
											<a class="cursor-pointer list-group-item list-group-item-action" href="<?php echo base_url(); ?>User/req-promotion">Submit Request</a>
										</div>
									'
								><span class="glyphicon glyphicon-wrench"></span> Tools</button>
								<a class="btn btn-xs btn-link btn-link-light" href="<?php echo base_url(); ?>Guest/profile/<?php echo $actor->getId(); ?>"><span class="glyphicon glyphicon-user"></span> Profile</a>
								<a class="btn btn-xs btn-link btn-link-light" onclick="logout();"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
							</div>
<?php } else { ?>
							<div class="col-lg-7 col-md-8 col-sm-6 col-xs-6 text-center"></div>
							<div class="col-lg-2 col-md-2 col-sm-4 col-xs-4 text-center">
								<a class="btn btn-xs btn-link btn-link-light" onclick="registerPopupFeed.Toggle(0);"><span class="glyphicon glyphicon-user"></span> Sign Up</a>
								<a class="btn btn-xs btn-link btn-link-light" onclick="loginPopupFeed.Toggle(0);"><span class="glyphicon glyphicon-log-in"></span> Login</a>
							</div>
<?php } ?>
							<div class="col-lg-1 hidden-md hidden-sm hidden-xs"></div>
						</div>
					</div>
				</header>
			</div>