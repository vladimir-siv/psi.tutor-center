<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Utility extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->library('doctrine');
			
			$this->load->library('loader');
			$this->loader->setController($this);
			$this->loader->setEntityManager($this->doctrine->em);
		}
		
		public function index()
		{
                        echo FCPATH;
			echo "OK";
		}

	}
?>