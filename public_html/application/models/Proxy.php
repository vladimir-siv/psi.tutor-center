<?php

class Proxy
{
	protected $em = null;
	
	public function setEntityManager($em) { if ($this->em === null) $this->em = $em; }
	
	protected function prepare($sql, $parameters)
	{
		foreach ($parameters as $key => $parameter)
		{
			$sql = str_replace(':'.$key.',', '\''.htmlentities($parameters[$key]).'\',', $sql);
			$sql = str_replace(':'.$key.')', '\''.htmlentities($parameters[$key]).'\')', $sql);
		}
		
		return $sql;
	}
}

?>