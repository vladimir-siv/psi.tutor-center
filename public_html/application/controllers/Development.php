<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	require_once 'application/models/Entities.php';
	
	class Development extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->library('doctrine');
			
			$this->load->library('loader');
			$this->loader->setController($this);
			$this->loader->setEntityManager($this->doctrine->em);
			Proxy::__init__();
		}
		
		public function index()
		{
			echo 'Development controller.';
		}
		
		public function initdb()
		{
			echo 'Initializing database . . . ';
			$this->loader->initializeDatabase();
			echo 'Database initialized!';
		}
		
		public function testPrivilege($action)
		{
			if (!isset($this->session->actor))
			{
				echo 'Please, log in!';
				return;
			}
			
			$actor = $this->session->actor;
			echo Privilege::has($actor->getRawRank(), $action) ? 'has' : 'not'; 
		}
	}
?>