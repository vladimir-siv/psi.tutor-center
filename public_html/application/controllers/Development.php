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
	}
?>