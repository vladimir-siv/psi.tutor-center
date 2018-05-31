    <div class="jumbotron no-padding-bottom font-rammetto-one text-center" style="background-color: inherit;">
        <h1><span class="text-primary">P</span>romotion requests</h1>
    </div>
    <section id="section-main" class="border-boxed expanded no-margin no-padding">
<?php
    if($promotionrequests!=null){
        foreach($promotionrequests as $promotionrequest){
            echo '<article id="article-1" class="border-boxed expanded no-margin padding-sm solid-border border-xs border-gray edged no-border-bottom" style="min-height: 100px;">';
            echo '<a href="'.base_url().'User/profile/'.$promotionrequest->getActor().'">';
            echo '<img class="margin-right-sm" src="'.base_url().'assets/storage/users/'.$promotionrequest->getActor().'/avatar.png" width="120" height="120" style="float: left;"/></a><br>';
            echo '<a class="hover-text-decor-none" href="'.base_url().'Guest/request/'.$promotionrequest->getId().'" target="_blank">';
            echo '<p class="font-times-new-roman font-sm">'.$promotionrequest->getTitle().'</p></a>';
            echo '<p class="font-times-new-roman font-xs no-margin no-padding">';
            echo 'User: <a class="hover-text-decor-none" href="'.base_url().'User/profile/'.$promotionrequest->getActor().'">'.$actors[$promotionrequest->getActor()]->getFirstname().' '.$actors[$promotionrequest->getActor()]->getLastname().'</a><br>';
            if($promotionrequest->getAccepted()===null){
                echo ' Status: <span class="text-warning"><b>Awaiting</b></span><br>';
            }
            else if($promotionrequest->getAccepted()===false){
                echo ' Status: <span class="text-danger"><b>Rejected</b></span><br>';
            }
            else if($promotionrequest->getAccepted()===true){
                echo ' Status: <span class="text-success"><b>Accepted</b></span><br>';
            }
            echo ' Submitted on: '. $promotionrequest->getSubmittedon()->format('d.m.Y.');
            echo '</p></article>';
        }
    }
?>
    </section>
    <section id="section-info" class="jumbotron border-boxed expanded no-margin no-padding padding-top-lg padding-bottom-lg solid-border border-xs border-gray super-edged no-border-bottom">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2 class="font-times-new-roman">Here you can view all the promotion requests submitted by other users.</h2>
                <p class="font-times-new-roman">
                    Select a certain promotion request and review it carefully! Once you accept the promotion,
                    the user will be promoted to higher ranking, granting him more access to the system! Choose wisely!
                </p>
            </div>
        </div>
    </section>