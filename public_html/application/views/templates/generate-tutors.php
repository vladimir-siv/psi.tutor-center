<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
tutors =
[
<?php
	if($tutors != null)
	{
		$count = 0;
		foreach ($tutors as $tutor)
		{
			$description = $tutor->getDescription() != null ? $tutor->getDescription() : 'Tutor';
			echo 'new Tutor('.$tutor->getId().', '. $numOfWorkpost[$tutor->getId()] .', "'.$description.'", "'.$tutor->getFirstname().'", "'.$tutor->getLastName().'")';
			$count++; 
			if($count !== count($tutors)) echo ', ';
		}
	}
?>
];