<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
users =
[
<?php
	if($users != null)
	{
		$count = 0;
		foreach ($users as $user)
		{
			$description = $user->getDescription() != null ? $user->getDescription() : 'User';
			echo 'new User('.$user->getId().', "'.$description.'", "'.$user->getFirstname().'", "'.$user->getLastName().'")';
			$count++; 
			if($count !== count($users)) echo ', ';
		}
	}
?>
];