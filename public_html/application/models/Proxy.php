<?php

require_once APPPATH.'libraries/Loader.php';

class Proxy
{
	private static $initialized;
	protected static $_loader;
	protected static $_em;
	
	public static function __init__()
	{
		if (isset($initialized) && !empty($initialized)) return;
		
		self::$_loader = Loader::instance();
		self::$_em = self::$_loader->getEntityManager();
		
		$initialized = true;
	}
	
	protected $loader = null;
	protected $em = null;
	protected $refLoaded = false;
	
	public function __construct()
	{
		$this->loader = Loader::instance();
		$this->em = $this->loader->getEntityManager();
	}
	
	public function reloadbase()
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