<div class = "row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="media">
                        <div class="col-lg-3 col-md-3 hidden-sm hidden-xs text-center"> 
                                <img class="mr-3" src=<?php echo '"'.base_url().'assets/storage/subjects/'.$subject->getName().'/icon.png"' ?> style="width:80px">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center">
                                <h1 class="mt-0 font-rammetto-one font-md" style="padding-top:10px; ">Computer Science</h1>
                        </div>
                        <div class="col-lg-3 col-md-3 hidden-sm hidden-xs text-center">
                                <img class="mr-3" src=<?php echo '"'.base_url().'assets/storage/subjects/'.$subject->getName().'/icon.png"' ?> style="width:80px">
                        </div>
                </div>
        </div>
</div>
<div class = "row font-sm">
        <div class = "col-lg-12 col-md-12 col-sm-12 col-xs-12">
           <p class="font-times-new-roman text-justify">
                 <?php echo $subject->getDescription() ?>
           </p>
        </div>
</div>
<section id="section-main" class="border-boxed expanded no-margin no-padding">
   <div class="row">
                <?php 
                   foreach($sections as $section)
                   {
                        echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';       
                            echo '<a class="hover-text-decor-none" href="'.base_url().'Guest\showOneSection\\'.$section->getId().'" >';
                                 echo '<article id="article" class="border-boxed expanded no-margin padding-sm solid-border border-xs border-gray edged no-border-bottom text-center" style="height: 100px;">';
                                       echo '<img src="'.base_url().'assets/storage/subjects/'.$subject->getName().'/sections/'.$section->getName().'/icon.png" width="40" height="40"/><p name="id" class="font-times-new-roman font-sm">'.$section->getName().'</p>';
                                 echo '</article>';
                            echo '</a>';
                        echo '</div>';
                   }
                ?>
   </div>
</section>
<section id="section-info" class="jumbotron border-boxed expanded no-margin no-padding padding-top-lg padding-bottom-lg solid-border border-xs border-gray super-edged no-border-bottom">
<div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2 class="font-times-new-roman">Our competition covers just a few academic fields.</h2>
                <p class="font-times-new-roman">
                        Right now we handle a certain number of different academic fields that span a moderate number of individual subjects.
                        Of course we’re adding more all the time.
                        Tutor Center is the best place to get help with any subject that you need!<br/>
                </p>
        </div>
</div>
<div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2 class="font-times-new-roman">Only experts, no one else!</h2>
                <p class="font-times-new-roman">
                        Most of our tutors hold advanced degrees in their fields of study, not just master’s degrees in education.
                        When you’re on Tutor Center browsing through the subject listings, rest assured we have tutors who really know each subject!
                </p>
        </div>
</div>
<div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2 class="font-times-new-roman">Missing something?</h2>
                <p class="font-times-new-roman">
                        If you're searching for a subject and can't find it in our list, get in touch with us.
                        We’ll find the right tutor for it and add it to our list. We'll take care of you!
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