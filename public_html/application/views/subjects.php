<div class="jumbotron no-padding-bottom font-rammetto-one text-center" style="background-color: inherit;">
        <h1><span class="cursor-pointer text-primary" onclick="searchSubjectsPopupFeed.Toggle(0);">S</span>ubjects</h1>
</div>
<section id="section-main" class="border-boxed expanded no-margin no-padding">
        <?php foreach($subjects as $subject)
        {
          echo '<div class="row">';
                echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
                        echo '<a class="hover-text-decor-none" href="'.base_url().'Guest\subject\\'.$subject->getId().'">'; 
                                echo '<article id="article-1" class="border-boxed expanded no-margin padding-sm solid-border border-xs border-gray edged no-border-bottom text-center" style="height: 100px;">';
                                       echo '<img src="'.base_url().'assets\storage\subjects\\'.$subject->getName().'\icon.png" width="40" height="40"/><p name="id" class="font-times-new-roman font-sm">'.$subject->getName().'</p>';
                                echo '</article>';
                        echo '</a>';
                echo '</div>';
          echo '</div>';
        }
        ?>
</section>
<section id="section-info" class="jumbotron border-boxed expanded no-margin no-padding padding-top-lg padding-bottom-lg solid-border border-xs border-gray super-edged no-border-bottom">
        <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h2 class="font-times-new-roman">Our competition covers just a few academic fields.</h2>
                        <p class="font-times-new-roman">
                                Right now we handle a certain number of different academic fields that span a moderate number of individual subjects.
                                Of course we’re adding more all the time.
                                Take a look at our subjects and browse through them using our search function (click on the "S" on the beginning of the page)!
                                To clear the search filter, search again without any filter!<br/>
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