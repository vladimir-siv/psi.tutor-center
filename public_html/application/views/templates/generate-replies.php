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
			echo 'new Reply('.$reply->getId().', '. $replyposter[$reply->getId()]->getId().', "'.$replyposter[$reply->getId()]->getUsername().'", "'.$reply->getMessage().'", "'.$reply->getPostedon()->format('d.m.Y.').'", '.($op->getId()===$replyposter[$reply->getId()]->getId()?'true':'false').', '.($enableDeleteButton?'true':'false').')';
			$count++; 
			if($count !== count($replies)) echo ', ';
		}
	}
?>
];

<?php if(isset($actor) && $actor!==null){?>
	isActorOP = <?php echo $actor->getId()===$op->getId()?'true':'false';?>;
	isActorModerator = <?php echo $actor->getRawRank()>=Rank::Moderator?'true':'false';?>;
<?php } ?>

<!--acceptedAnswer = 4;-->