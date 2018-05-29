<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
				<div class="jumbotron no-padding-bottom font-rammetto-one text-center" style="background-color: inherit;">
					<h1><span class="text-primary">L</span>ibrary</h1>
				</div>
				<section id="section-main" class="border-boxed expanded no-margin no-padding margin-bottom-md">
					<article id="search-filters">
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="input-group">
									<span class="input-group-addon"><i class="	glyphicon glyphicon-book"></i></span>
									<input id="search-subject" type="text" class="form-control" name="search-subject" placeholder="Subject">
								</div>
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-th-list"></i></span>
									<input id="search-section" type="text" class="form-control" name="search-section" placeholder="Section">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<button type="button" class="btn btn-primary btn-sm btn-block" onclick="callbackParameters = [$('#section-main #search-filters #search-sections-result-display')[0], new LinkSectionSearchResult()]; searchdb('subject-section:replace', [$('#section-main #search-filters #search-subject')[0].value, $('#section-main #search-filters #search-section')[0].value]);">Search</button>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div id="search-sections-result-display" class="border-boxed expanded padding-xs padding-top-md" style="line-height: 200%;">
								</div>
							</div>
						</div>
					</article>
				</section>
				<section id="section-info" class="jumbotron border-boxed expanded no-margin no-padding padding-top-lg padding-bottom-lg solid-border border-xs border-gray super-edged no-border-bottom">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<h2 class="font-times-new-roman">Solutions at your fingertips!</h2>
							<p class="font-times-new-roman">
								The Homework Library is a database of solved homework problems created by our tutors over many years.
								They are not original, and therefore are made available for study and learning purposes only.
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<h2 class="font-times-new-roman">How do I find what I need?</h2>
							<p class="font-times-new-roman">
								You can search for the subjects and their sections by their names and then browse through the results.
								You can search for the solutions using keywords which can reduce your span of results!
								When you find something that seems interesting, click on it and you’ll get more information about that solution.
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<h2 class="font-times-new-roman">The information that matters</h2>
							<p class="font-times-new-roman">
								The solutions will include information such as who was the author of the solution,
								the original question, and sometimes a preview of the solution itself.
								When you are ready to purchase a solution just click on it and it will be yours.
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