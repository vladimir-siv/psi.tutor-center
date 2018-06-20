<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php require_once 'application/models/Entities.php'; ?>
<?php $section->reloadbase(); $wereLoaded = $section->refsAreLoaded(); $section->loadReferences(); ?>
				<div class="row margin-top-md">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="media">
							<div class="col-lg-3 col-md-3 hidden-sm hidden-xs text-center">
								<img class="mr-3" src="<?php echo base_url(); ?>assets/storage/subjects/<?php echo $section->getSubject()->getId(); ?>/sections/<?php echo $section->getId(); ?>/icon.png" style="width:80px"
                                                                     <?php if (isset($this->session->actor) && $this->session->actor->getRawRank() == Rank::Administrator) echo 'onclick="$(\'#attach-section-pic\').click();"'; ?> >
							</div>
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center">
								<h1 class="mt-0 font-rammetto-one font-md" style="padding-top:10px;"><?php echo $section->getName(); ?></h1>
							</div>
							<div class="col-lg-3 col-md-3 hidden-sm hidden-xs text-center">
								<img class="mr-3" src="<?php echo base_url(); ?>assets/storage/subjects/<?php echo $section->getSubject()->getId(); ?>/sections/<?php echo $section->getId(); ?>/icon.png" style="width:80px"
								<?php if (isset($this->session->actor) && $this->session->actor->getRawRank() == Rank::Administrator) echo 'onclick="$(\'#attach-section-pic\').click();"'; ?>>
							</div>
							<input id="attach-section-pic" type="file" style="display: none;">
							<script type="text/javascript">
								$("#attach-section-pic").change(function(event)
								{
										var files = [];
										$.each($("input#attach-section-pic").prop("files"), function(index, file) { files.push(file); });

										if (files.length === 1) changeSectionPic(files[0], <?php echo $section->getSubject()->getId(); ?>, <?php echo $section->getId(); ?>);
										//else Alert.New("You must select one file");
								});
							</script>
						</div>
					</div>
				</div>
				<div class = "row font-sm">
					<div class = "col-lg-12 col-md-12 col-sm-12 col-xs-12">
					   <p class="font-times-new-roman text-center">
							<?php echo $section->getDescription(); ?>
					   </p>
<?php
					if ($enableDeleteButton) echo '<center><button class="btn btn-danger" onclick="deleteSection('.$section->getId().')">Delete</button></center>';
					
					if (isset($this->session->actor) && $this->session->actor->getRawRank() >= Rank::Tutor)
					{
						if ($this->session->actor->isSubscribed($section->getId()))
							echo '<center><button class="btn btn-primary" onclick="subscribeTutor('.$section->getId().')">Unsubscribe</button></center>';
						else echo '<center><button class="btn btn-primary" onclick="subscribeTutor('.$section->getId().')">Subscribe</button></center>';
					}
?>
					</div>
				</div>
				<div class = "row font-sm text-center font-rammetto-one">
					<h1>Tutors:</h1>
				</div>
				<br/>
				<section id="section-main" data-type="tutors" class="border-boxed expanded no-margin no-padding">
					<div class="row solid-border-bottom border-bottom-xs border-bottom-gray edged no-margin-left no-margin-right text-center">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<ul data-type="pagination" class="pagination no-margin">
							</ul>
						</div>
					</div>
					<div class="row solid-border border-xs border-gray edged no-border-top no-margin-left no-margin-right">
						<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 no-margin no-padding">
							<article id="article-1" class="border-boxed expanded no-margin padding-sm solid-border border-xs border-gray edged text-center" style="height: 300px;">
							</article>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 no-margin no-padding">
							<article id="article-2" class="border-boxed expanded no-margin padding-sm solid-border border-xs border-gray edged text-center" style="height: 300px;">
							</article>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 no-margin no-padding">
							<article id="article-3" class="border-boxed expanded no-margin padding-sm solid-border border-xs border-gray edged text-center" style="height: 300px;">
							</article>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 no-margin no-padding">
							<article id="article-4" class="border-boxed expanded no-margin padding-sm solid-border border-xs border-gray edged text-center" style="height: 300px;">
							</article>
						</div>
					</div>
					<div class="row solid-border border-xs border-gray edged no-border-top no-margin-left no-margin-right">
						<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 no-margin no-padding">
							<article id="article-5" class="border-boxed expanded no-margin padding-sm solid-border border-xs border-gray edged text-center" style="height: 300px;">
							</article>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 no-margin no-padding">
							<article id="article-6" class="border-boxed expanded no-margin padding-sm solid-border border-xs border-gray edged text-center" style="height: 300px;">
							</article>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 no-margin no-padding">
							<article id="article-7" class="border-boxed expanded no-margin padding-sm solid-border border-xs border-gray edged text-center" style="height: 300px;">
							</article>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 no-margin no-padding">
							<article id="article-8" class="border-boxed expanded no-margin padding-sm solid-border border-xs border-gray edged text-center" style="height: 300px;">
							</article>
						</div>
					</div>
					<div class="row solid-border border-xs border-gray edged no-border-top no-margin-left no-margin-right">
						<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 no-margin no-padding">
							<article id="article-9" class="border-boxed expanded no-margin padding-sm solid-border border-xs border-gray edged text-center" style="height: 300px;">
							</article>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 no-margin no-padding">
							<article id="article-10" class="border-boxed expanded no-margin padding-sm solid-border border-xs border-gray edged text-center" style="height: 300px;">
							</article>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 no-margin no-padding">
							<article id="article-11" class="border-boxed expanded no-margin padding-sm solid-border border-xs border-gray edged text-center" style="height: 300px;">
							</article>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 no-margin no-padding">
							<article id="article-12" class="border-boxed expanded no-margin padding-sm solid-border border-xs border-gray edged text-center" style="height: 300px;">
							</article>
						</div>
					</div>
					<div class="row solid-border border-xs border-gray edged no-border-top no-margin-left no-margin-right">
						<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 no-margin no-padding">
							<article id="article-13" class="border-boxed expanded no-margin padding-sm solid-border border-xs border-gray edged text-center" style="height: 300px;">
							</article>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 no-margin no-padding">
							<article id="article-14" class="border-boxed expanded no-margin padding-sm solid-border border-xs border-gray edged text-center" style="height: 300px;">
							</article>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 no-margin no-padding">
							<article id="article-15" class="border-boxed expanded no-margin padding-sm solid-border border-xs border-gray edged text-center" style="height: 300px;">
							</article>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 no-margin no-padding">
							<article id="article-16" class="border-boxed expanded no-margin padding-sm solid-border border-xs border-gray edged text-center" style="height: 300px;">
							</article>
						</div>
					</div>
				</section>
				<section id="section-info" class="jumbotron border-boxed expanded no-margin no-padding padding-top-lg padding-bottom-lg solid-border border-xs border-gray super-edged no-border-bottom">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<h2 class="font-times-new-roman">How do I find a tutor?</h2>
							<p class="font-times-new-roman">
								You don't need to! Just submit a request (by creating a post) and tutors will find you!
								For that, you need to be logged in. Sign up now, it's free!
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<h2 class="font-times-new-roman">Experts at your disposal.</h2>
							<p class="font-times-new-roman">
								Our tutors have profiles with quite a bit of information in them.
								You’ll be able to find the subjects that they cover,
								when they started working with us,
								the number of their completed requests, and overall ratings!
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<h2 class="font-times-new-roman">Can I work with the same tutor again?</h2>
							<p class="font-times-new-roman">
								Of course! You can work with any tutor as many times as you want to!
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<h2 class="font-times-new-roman">Need help?</h2>
							<p class="font-times-new-roman">
								You can send us an email (dekanat@etf.bg.ac.rs) or get in touch with us by calling at +381 11/32-26-992.
							</p>
						</div>
					</div>
				</section>
<?php if (!$wereLoaded) $section->unloadReferences(); ?>