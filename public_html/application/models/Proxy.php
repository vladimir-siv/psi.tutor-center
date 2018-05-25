<?php

require_once APPPATH.'libraries/Loader.php';

class Proxy
{
	protected $loader = null;
	protected $em = null;
	protected $refLoaded = false;
	
	public function __construct()
	{
		$this->loader = Loader::instance();
		$this->em = $this->loader->getEntityManager();
	}
	
	public function loadReferences() { $this->refLoaded = true; }
	public function unloadReferences() { $this->refLoaded = false; }
	public function refsAreLoaded() { return $this->refLoaded; }
	
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