<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Guest extends CI_Controller
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
			$this->loader->loadSimplePage();
		}
        
		public function login()
		{
			//$q = $em->createQuery("SELECT a.username, a.password FROM Actor a WHERE a.username = :username AND a.password = :password");
			//$q->setParameter('username', $this->input->post('username'));
			//$q->setParameter('password', md5($this->input->post('password')));
			//$result = $q->getResult();
			
			$actor = $this->loader->findActor($this->input->get('username'), $this->input->get('password'));
			
			if ($actor === null) echo '#Error: Username or password is not valid!';
			else echo 'SUCCESS';
		}
		
		public function logout()
		{
			$this->session_unset_userdata('actor');
			$this->session->sess_destroy();
			redirect("Utility/index");
		}
	}
?>