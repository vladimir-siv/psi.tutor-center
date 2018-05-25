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
			$actor = $this->loader->findActor($this->input->get('username'), $this->input->get('password'));
			
			if ($actor === null)
			{
				echo '#Error: Username or password is not valid!';
				return;
			}
			
			$this->session->set_userdata('actor', $actor);
			
			echo 'Success! User is: '.$this->session->actor->getFirstname();
		}
		public function logout()
		{
			$this->session_unset_userdata('actor');
			$this->session->sess_destroy();
			redirect("Utility/index");
		}
		
		public function try1()
		{
			$this->session->set_userdata('ok', 'radi');
			echo 'cool';
		}
		
		public function try2()
		{
			echo 'hello "'.$this->session->userdata('ok').'"';
		}
		
		private function insertUser()
		{
			$this->loader->loadEntities();
			$actor = Actor::New('Dejan', 'Dejanovic', 'ddd@gmail.com', 'deja1', 'deja', new \DateTime('now'), Rank::Tutor);
			//$actor->loadReferences();
			$em = $this->loader->getEntityManager();
			$em->persist($actor);
			$em->flush();
		}
		
		public function showAllTutors()
		{
			// UNIMPLEMENTED: tutor description
			$this->loader->loadEntities();
			$qb = $this->loader->getEntityManager()->createQueryBuilder();
			$qb->select('a')->from('Actor', 'a')->where('a.actorrank > 2');
			$query = $qb->getQuery();
			$tutors = $query->getResult();
			$numOfWorkpost = array();
			foreach($tutors as $tutor)
			{
				$qb = $this->loader->getEntityManager()->createQueryBuilder();
				$qb->select('count(w.id)')->from('Workpost', 'w')->where('w.worker = :tutorid')->setParameter('tutorid', $tutor->getId());
				$query = $qb->getQuery();
				$workpostsCount = $query->getSingleScalarResult();
				$numOfWorkpost[$tutor->getId()] = $workpostsCount;
			}
			$this->loader->loadPage('tutors.php', array('tutors' => $tutors, 'numOfWorkpost' => $numOfWorkpost), 'Tutors', array('scripts'=>'assets/js/tutors.js'));
		}
	}
?>