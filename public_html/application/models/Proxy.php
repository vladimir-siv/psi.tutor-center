<?php

class Proxy
{
	protected $em = null;
	
	public function setEntityManager($em) { if ($this->em === null) $this->em = $em; }
}

?>