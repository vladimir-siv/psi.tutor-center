<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require_once 'application/models/Entities.php';
?>
replies =
[
<?php
	if($replies != null)
	{
		$count = 0;
		foreach ($replies as $reply)
		{
			echo 'new Reply('.$reply->getId().', '. $replyposter[$reply->getId()]->getId().', "'.$replyposter[$reply->getId()]->getUsername().'", "'.$reply->getMessage().'", "'.$reply->getPostedon()->format('d.m.Y.').'", '.($op->getId()===$replyposter[$reply->getId()]->getId()?'true':'false').', '.($enableDeleteButton?'true':'false').', '.(isset($this->session->actor) && $this->session->actor->getId()==$op->getId() && $acceptedreply==null && Qapost::checkIfPostIsQA($post)?'true':'false').', '.$post->getId().')';
			$count++; 
			if($count !== count($replies)) echo ', ';
		}
	}
?>
];

<?php if(isset($this->session->actor) && $this->session->actor!==null){?>
	isActorOP = <?php echo $this->session->actor->getId()===$op->getId()?'true':'false';?>;
	isActorModerator = <?php echo $this->session->actor->getRawRank()>=Rank::Moderator?'true':'false';?>;
	acceptedAnswer = <?php echo $acceptedreply != null ? $acceptedreply : 'null';?>;
<?php } ?>