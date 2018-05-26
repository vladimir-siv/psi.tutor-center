<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	require_once 'application/models/Entities.php';
	
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
			if ($this->session->actor !== null) echo 'Success! User is: '.$this->session->actor->getFirstname();
			else echo 'No one is logged in';
		}
		
		public function register()
		{
			
		}
        
		public function login()
		{
			$actor = $this->loader->findActor($this->input->post('username'), $this->input->post('password'));

			if ($actor === null)
			{
				echo '#Error: Username or password is not valid!';
				return;
			}

			$this->session->set_userdata('actor', $actor);

			echo 'Success!';
		}
		
		public function logout()
		{
			if (isset($this->session->actor)) $this->session->unset_userdata('actor');
			$this->session->sess_destroy();
			echo 'Success';
		}
	}
?>