<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require_once 'application/models/Entities.php';
    $workpost = $post->getWorkpost();
    function generateLinks($files){
        $edited = array();
        foreach($files as $file){
            $link = '<a href="'.base_url().$file.'" target="_blank">'.substr($file, strrpos($file, '/') + 1).'</a>';
            $edited[] = $link;
        }
        return $edited;
    }
?>
                <div class="border-boxed expanded padding-bottom-md" style="background-color: inherit;">
                    <h1 id="post-title" class="font-rammetto-one font-lg text-center padding-top-sm padding-bottom-sm">
                        <?php echo $post->getTitle(); ?>
                    </h1>
                    <div id="post-content" class="border-boxed expanded font-times-new-roman font-sm text-justify solid-border-top border-top-xs border-top-gray solid-border-bottom border-bottom-xs border-bottom-gray padding-md padding-top-sm">
                        <p>
<?php 
    if(Qapost::checkIfPostIsQA($post))
    {
        $description = Qapost::getDescriptionForPost($post);
    }
    else
    {
        $description = Workpost::getDescriptionForPost($post);
    }
    if($description!=null) echo $description;
?>
                        </p>
<?php if (isset($workpost)) { ?>
                        <div id="post-controls" class="border-boxed expanded">
	<?php if ($workpost->getWorker()===null && isset($this->session->actor) && $this->session->actor->getId()!==$post->getOriginalPosterId() && $this->session->actor->getRawRank() >= Rank::Tutor && $post->getActive()) { ?>
                            <button id="post-lock" type="button" class="btn btn-primary btn-sm font-xs" onclick="lockWorkPost(<?php echo $post->getId(); ?>);"><i class="fa fa-key"></i> Lock</button>
	<?php } if ($workpost->getWorker()!==null && isset($this->session->actor) && ($this->session->actor->getId() === $post->getOriginalPosterId() || $workpost->getWorkerId() === $this->session->actor->getId()) && $post->getActive()) { ?>
                            <button id="post-release" type="button" class="btn btn-warning btn-sm font-xs" onclick="releaseWorkPost(<?php echo $post->getId(); ?>);"><i class="fa fa-unlock-alt"></i> Release</button>
	<?php } if ($workpost->getWorker()!==null && isset($this->session->actor) && $this->session->actor->getId() === $post->getOriginalPosterId() && $post->getActive()) { ?>
        <button id="post-submit-tokens" type="button" class="btn btn-success btn-sm font-xs" onclick="submitTokensPopupFeed.setPostID(<?php echo $post->getId(); ?>);submitTokensPopupFeed.Toggle(0);"><i class="fa fa-money"></i> Submit Tokens</button>
    <?php } if (isset($this->session->actor) && !$post->getActive() && $this->session->actor->getId()==$post->getOriginalposter()) { ?>
							<button id="post-review" type="button" class="btn btn-warning btn-sm font-xs" onclick="reviewPopupFeed.setPostID(<?php echo $post->getId(); ?>); reviewPopupFeed.Toggle(0);"><i class="fa fa-star"></i> Review</button>
	<?php } if ($enableDeleteButton) { ?>
							<button class="btn btn-danger btn-sm font-xs" onclick="deletePost(<?php echo $post->getId(); ?>)">Delete</button>
	<?php } ?>
                            <br>
	<?php if ($post->getActive() && $workpost->getWorker()!==null && isset($this->session->actor) && $workpost->getComittedtokens()!==null && $workpost->getWorkerId() === $this->session->actor->getId()) { ?>
                            <button id="attach" type="button" class="btn btn-info" onclick="$('#attach-files').click();"><i class="fa fa-file-zip-o"></i> Attach file(s)</button>
                            <input id="attach-files" type="file" style="display: none;" multiple>
                            <script type="text/javascript">
                                $("#post-controls #attach-files").change(function(event)
                                {
                                    var names = $.map($(this).prop("files"), function(val) { return val.name; });
                                    
                                    var filenames = "";
                                    for (var i = 0; i < names.length; i++)
                                        filenames += names[i] + " | ";
                                    $("#post-controls #attached-files-display").html(filenames.substring(0, filenames.length - 3));

                                    var postData = new FormData();
	                                $.each($('#attach-files').prop("files"), function(index, file) { postData.append('+file-' + index, file, file.name); });
                                    postData.append("workpostid", <?php echo $workpost->getId(); ?>);
                                    $.ajax
                                    ({
                                        url: "http://" + window.location.host + "/User/attachWorkerFiles",
                                        method: "POST",
                                        data: postData,
                                        processData: false,
                                        contentType: false,
                                        dataType: "html"
                                    })
                                    .done(function(response)
                                    {
                                        if (response.startsWith("#Error: "))
                                        {
                                            var success = new AlertPopupFeed(Alert.New("danger", response.substring(8), true, "modal"));
                                            success.Subscribe(alertPopup);
                                            success.Show(0);
                                        }
                                        else
                                        {
                                            var type = "success";
                                            
                                            if (response.startsWith("#Warning: "))
                                            {
                                                type = "warning";
                                                response = response.substring(10);
                                            }
                                            
                                            var success = new AlertPopupFeed(Alert.New(type, response, true, "modal"));
                                            success.Subscribe(alertPopup);
                                            success.Show(0);
                                        }
                                    });
                                });
                            </script>
	<?php } ?>
                            <p id="post-info" class="font-times-new-roman font-xs">
                                Locked by: <?php echo $workpost->getWorker()===null ? '&lt;none&gt;' : $workpost->getWorkerReference()->getUsername(); ?>
                                <br>
                                Submitted tokens: <?php $t = $workpost->getComittedtokens(); echo (isset($t) ? $t : '0.00').'t'; ?>
                                <br>
                                Attached files: <?php echo '&lt; '.implode(' | ', generateLinks(glob('assets/storage/posts/'.$post->getId().'/*.*'))).' &gt;'; ?>
                            </p>
                        </div>
<?php } ?>
                    </div>
                    <div class="border-boxed expanded font-rammetto-one font-xs text-align-left padding-xs" style="line-height: 200%;">
<?php 
    foreach($sections as $section)
    {
        echo '<a href="'.base_url().'User/section/'. $section->getId() . '" class="hover-text-decor-none bg-lightblue padding-left-xs padding-right-xs"><span class="bg-secondary">'. $section->getName().'</span></a>&nbsp;';
    }
?>
                    </div>
                    <div class="row">
                        <div class="col-lg-10 col-md-9 col-sm-8 col-xs-8"></div>
                        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4">
                            <div class="border-boxed text-center padding-xs bg-lightblue rounded-xxs">
                                <p class="font-times-new-roman font-xs no-margin">Posted on: <i id="post-date"><?php echo $post->getPostedon()->format('d.m.Y.');?></i></p>
                                <?php 
                                if ($post->getActive()) echo '<b id="active-indicator" class="font-times-new-roman text-success no-margin">active</b><br>';
                                else echo '<b id="active-indicator" class="font-times-new-roman text-danger no-margin">inactive</b><br>';
                                ?>
                                <a href="<?php echo base_url(); ?>Guest/profile/<?php echo $post->getOriginalPosterReference()->getId(); ?>">
                                <?php echo '<img class="edged" src="'.base_url().'assets/storage/users/'. $post->getOriginalPosterReference()->getId() . '/avatar.png" width="50" height="50">';?>
                                </a><br>
                                <a href="<?php echo base_url(); ?>Guest/profile/<?php echo $post->getOriginalPosterReference()->getId(); ?>" class="hover-text-decor-none"><?php echo $post->getOriginalPosterReference()->getUsername(); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <section id="section-main" class="border-boxed expanded padding-left-md padding-right-md">
                </section>
<?php if(isset($actor) && $actor!==null){?>
                <div class="border-boxed expanded font-times-new-roman">
                    <article name="reply" class="border-boxed expanded no-margin padding-sm">
                        <div class="row">
                            <div class="col-lg-1 col-md-1 col-sm-2 col-xs-4 text-right">
                                <a href="<?php echo base_url(); ?>/Guest/profile/<?php echo $actor->getId(); ?>" class="font-times-new-roman hover-text-decor-none">
                                    <img src="<?php echo base_url(); ?>assets/storage/users/<?php echo $actor->getId(); ?>/avatar.png" width="60" height="60"><br>
                                    <?php echo $actor->getUsername(); ?>
                                </a>
                                <p class="font-times-new-roman">Posted on: <i><?php echo (new \DateTime('now'))->format('d.m.Y.');?></i></p>
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-4">
                                <div class="border-boxed expanded solid-border border-xs border-gray no-border-left no-border-right rounded-xs padding-xs" style="line-height: 0;">
                                    <textarea class="border-boxed expanded padding-xs" style="line-height: 20px; height: 100px; resize: none;" onkeydown="<?php echo 'onReplyKeydown(this, event, '.$post->getId().', '.$this->session->actor->getId().')'; ?>"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-2 col-xs-4 text-left">
                            </div>
                        </div>
                    </article>
                </div>
<?php } ?>