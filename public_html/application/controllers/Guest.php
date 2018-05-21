<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Guest extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->library('loader');
			$this->load->library('doctrine');
		}
		
		public function index()
		{
			$this->loader->loadSimplePage($this);
		}
	}
?>