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
			$actor = $this->loader->findActor($this->input->post('username'), $this->input->post('password'));
			
			if ($actor === null)
			{
				echo '#Error: Username or password is not valid!';
				return;
			}
			
			$actor->setEntityManager($this->loader->getEntityManager());
			//$this->session->set_userdata('actor', json_encode($actor));
			
			echo json_encode($actor);
			
			//echo 'Success! User is: '.$actor->getActorRankRef()->getName();
		}
		
		public function logout()
		{
			$this->session_unset_userdata('actor');
			$this->session->sess_destroy();
			redirect("Utility/index");
		}
		
		public function insertActor()
		{
			$this->loader->loadEntities();
			$actor = Actor::New('Marko', 'Markovic', 'mm@gmail.com', 'mm123', 'mm123', '2018-05-02', Rank::User);
			$actor->setEntityManager($this->loader->getEntityManager());
			$actor->persist();
			echo 'cool';
		}
	}
?>