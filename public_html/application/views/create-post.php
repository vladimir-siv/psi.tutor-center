<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
				<div class="jumbotron no-padding-bottom font-rammetto-one text-center" style="background-color: inherit;">
					<h1><span class="text-primary">C</span>reate a post</h1>
				</div>
				<section id="section-main" class="border-boxed expanded no-margin no-padding">
					<article id="post-title-info" class="border-boxed expanded">
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-header"></i></span>
							<input id="post-title" type="text" class="form-control" name="post-title" data-collectable="#" placeholder="Title">
						</div>
					</article>
					<article id="section-choosing" class="border-boxed expanded margin-top-md margin-bottom-md">
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
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
								<button type="button" class="btn btn-primary btn-sm btn-block" onclick="callbackParameters = [$('#section-main #section-choosing #search-sections-result-popover')[0], new ActiveSectionSearchResult('__onResultClick')]; searchdb('subject-section:replace', [$('#section-main #section-choosing #search-subject')[0].value, $('#section-main #section-choosing #search-section')[0].value], FeedPopover);">Search</button>
								<script type="text/javascript">
									function _hide_popover() { $("#section-main #section-choosing #search-sections-result-popover").popover("hide"); }
									var __result = new LinkSectionSearchResult();
									function __onResultClick(sender, e)
									{
										var __resultDisplay = $("#section-main #section-choosing #chosen-sections");
										if (__resultDisplay.find("span[value=\"" + e.id + "\"]").length == 0)
										{
											__result.Feed(e);
											__resultDisplay.append(__result.AsView());
										}
										$(sender).remove();
									}
								</script>
								<div id="search-sections-result-popover" class="border-boxed expanded" data-toggle="popover" data-html="true" data-placement="bottom" data-trigger="focus"
									title=
									'
										<h4 class="d-inline-block font-times-new-roman">Results</h4>
										&emsp;
										<button type="button" class="d-inline-block close" aria-label="close" onclick="_hide_popover();">&times;</button>
									'
									>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div id="chosen-sections" class="border-boxed expanded font-rammetto-one font-xs text-align-left padding-xs" style="line-height: 200%;">
								</div>
							</div>
						</div>
					</article>
					<article id="post-details" class="border-boxed expanded margin-bottom-sm">
						<script type="text/javascript">
							var shown = null;
							function __switch(select)
							{
								if (shown != null) shown.collapse("hide");
								else $("#section-main #post-create").collapse("show");
								shown = $("#section-main #post-details #details-" + select.value);
								shown.collapse("show");
							}
						</script>
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-flag"></i></span>
							<select id="post-type" class="form-control" name="post-type" data-collectable="#" placeholder="Post Type" onchange="__switch(this);">
								<option disabled selected value style="display: none;">-- Select post type --</option>
								<option value="QA">QA</option>
								<option value="Work">Work</option>
							</select>
						</div>
						
						<div id="details-QA" class="border-boxed expanded collapse margin-top-sm margin-bottom-sm">
							<div class="border-boxed expanded solid-border border-xs border-gray no-border-left no-border-right rounded-xs padding-xs" style="line-height: 0;">
								<textarea id="QA-post-description" name="post-description" data-collectable="QA" class="border-boxed expanded font-times-new-roman padding-xs" style="line-height: 20px; min-height: 200px; resize: none;" placeholder="Describe the question you are posting here. Be specific, so that people can understand what you are asking and will be able to provide a better/suitable answer."></textarea>
							</div>
						</div>
						<div id="details-Work" class="border-boxed expanded collapse margin-top-sm margin-bottom-sm">
							<div class="border-boxed expanded solid-border border-xs border-gray no-border-left no-border-right rounded-xs padding-xs" style="line-height: 0;">
								<textarea id="Work-post-description" name="post-description" data-collectable="Work" class="border-boxed expanded font-times-new-roman padding-xs" style="line-height: 20px; min-height: 200px; resize: none;" placeholder="Describe the problem you have here. Be specific, so that people can understand what you are asking and will be able to provide a better/suitable solution."></textarea>
							</div>
							<div class="border-boxed expanded padding-xs">
								<button id="attach" type="button" class="btn btn-info" onclick="$('#attach-files').click();"><i class="fa fa-file-zip-o"></i> Attach file(s)...</button>
								<input id="attach-files" name="post-attachment" data-collectable="Work" data-collect="files" type="file" style="display: none;" multiple>
								<p id="attached-files-display" class="font-times-new-roman font-xs"></p>
								<script type="text/javascript">
									$("#details-Work #attach-files").change(function(event)
									{
										var names = $.map($(this).prop("files"), function(val) { return val.name; });
										
										var filenames = "";
										for (var i = 0; i < names.length; i++)
											filenames += names[i] + " | ";
										$("#details-Work #attached-files-display").html(filenames.substring(0, filenames.length - 3));
									});
								</script>
							</div>
						</div>
						
					</article>
					<article id="post-create" class="border-boxed expanded margin-bottom-md collapse">
						<button type="button" class="btn btn-primary btn-md" onclick="post($('#section-main #post-details #post-type')[0].value);">Post!</button>
					</article>
				</section>
				<section id="section-info" class="jumbotron border-boxed expanded no-margin no-padding padding-top-lg padding-bottom-lg solid-border border-xs border-gray super-edged no-border-bottom">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<h2 class="font-times-new-roman">Post your problem now and await to see tutors coming to help you!</h2>
							<p class="font-times-new-roman">
								Creating a post will notify certain tutors that you have created a post and need their help!
								This increases the chance that they will see your post, as well as you getting the help you need!
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<h2 class="font-times-new-roman">Which tutors will be notified?</h2>
							<p class="font-times-new-roman">
								While creating a post, you can choose which sections will it belong to. Once you have chosen your
								desired sections (can be from different/multiple subjects), all tutors who are at least in one
								of those sections will be notified, making sure that all of those qualified will at least know
								that you have posted!
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<h2 class="font-times-new-roman">Which tutor is going to help me?</h2>
							<p class="font-times-new-roman">
								Depends on who comes first. He will lock your post and then you can come to an agreement.
								If not, both of you can release the lock, so that another tutor can do the same, and so on. You
								are the one in the end who chooses which tutor is going to help you!
								<br>
								In case you are creating a simple QA post, you will receive many answers. In the end, you can
								tick one as the accepted answer.
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