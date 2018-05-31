<div class="jumbotron no-padding-bottom font-rammetto-one text-center" style="background-color: inherit;">
    <h1><span class="text-primary">P</span>romotion request</h1>
</div>
<section id="section-main" class="border-boxed expanded no-margin no-padding margin-bottom-md">
    <article id="promotion" class="border-boxed expanded no-margin padding-sm solid-border border-xs border-gray edged" style="min-height: 100px;">
        <div class="row padding-left-sm padding-right-sm font-times-new-roman fonts-xs text-justify">
<?php
    echo '<a href="'.base_url().'User/profile/'.$promotionrequest->getActor().'">';
?>
                <img class="margin-right-sm" src="<?php echo base_url().'assets/storage/users/'.$promotionrequest->getActor().'/avatar.png'; ?>" width="120" height="120" style="float: left;"/>
            </a>
            <a class="hover-text-decor-none" href="#">
                <h3 class="font-times-new-roman font-sm no-margin-top no-padding-top"><?php echo $promotionrequest->getTitle(); ?></h3>
            </a>
            <p class="text-justify no-margin no-padding">
                <?php echo $promotionrequest->getDescription(); ?>
            </p>
        </div>
        <div class="row margin-top-xs padding-left-sm padding-right-sm">
        <?php
            echo 'User: <a class="hover-text-decor-none" href="'.base_url().'User/profile/'.$promotionrequest->getActor().'">'.$actor->getFirstname().' '.$actor->getLastname().'</a><br>';
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
        ?>
            <p class="no-margin no-padding margin-top-xs">
                Attachments:
                <a class="btn btn-primary btn-sm hover-text-decor-none" href="storage/requests/1/diploma1.docx" target="_blank">diploma1.docx</a>
                <a class="btn btn-primary btn-sm hover-text-decor-none" href="storage/requests/1/diploma2.docx" target="_blank">diploma2.docx</a>
                <a class="btn btn-primary btn-sm hover-text-decor-none" href="storage/requests/1/diploma3.docx" target="_blank">diploma3.docx</a>
                <a class="btn btn-primary btn-sm hover-text-decor-none" href="storage/requests/1/diploma4.docx" target="_blank">diploma4.docx</a>
            </p>
        </div>
        <div class="row margin-top-md padding-left-sm padding-right-sm">
        <?php
            if($promotionrequest->getAccepted()===null){
            echo '<button type="button" class="btn btn-success btn-sm" onclick="acceptPromotion('.$promotionrequest->getId().');">Accept</button>
            <button type="button" class="btn btn-danger btn-sm" onclick="rejectPromotion('.$promotionrequest->getId().');">Reject</button>';
            }
        ?>
        </div>
    </article>
</section>