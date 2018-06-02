<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
posts =
[
<?php
	if($posts != null)
	{
		$count = 0;
		foreach ($posts as $post)
		{
            $type = Qapost::checkIfPostIsQA($post) ? 'QA' : 'WP';
			echo 'new Post('.$post->getId().', "'. $type .'", "'.$post->getTitle().'", "'.$post->getPostedon()->format('d.m.Y.').'", "'.$actors[$post->getId()]->getFirstName().' '.$actors[$post->getId()]->getLastName().'", '.$actors[$post->getId()]->getId().')';
			$count++; 
			if($count !== count($actors)) echo ', ';
		}
	}
?>
];