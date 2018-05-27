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
		
		public function insertSubjects()
		{
			$subjects = array
			(
				'Computer Science' => 'A computer science subject',
				'Architecture' => 'I draw like a boss',
				'Engineering' => 'Trust me I\'m an engineer ;)'
			);
			
			$this->loader->insertSubjects($subjects);
			
			echo 'Ok';
		}
		
		public function insertSections()
		{
			$subject = Subject::findByName('Computer Science')[0];
			
			$sections = array
			(
				'C#' => 'This language is GOAT',
				'C++' => 'I\'m sexy and I know it'
			);
			
			$this->loader->insertSections($subject, $sections);
			
			echo 'Ok';
		}
		
		public function subscribeTutors()
		{
			$sectionCS = Section::findByName('C#')[0];
			$sectionCPP = Section::findByName('C++')[0];
			
			$em = $this->loader->getEntityManager();
			
			$tutorsCS = array
			(
				$em->find('Actor', 1),
				$em->find('Actor', 2)
			);
			
			$tutorsCPP = array
			(
				$em->find('Actor', 3)
			);
			
			$sections = array
			(
				'C#' => 'This language is GOAT',
				'C++' => 'I\'m sexy and I know it'
			);
			
			$this->loader->subscribeTutors($sectionCS, $tutorsCS);
			$this->loader->subscribeTutors($sectionCPP, $tutorsCPP);
			
			echo 'Ok';
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