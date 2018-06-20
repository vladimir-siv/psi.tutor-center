<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	require_once 'application/models/Entities.php';
	
	/*
	 *	Development - used only for development & debugging
	 */
	class Development extends CI_Controller
	{
		/*
		 *	Konstruktor
		 */
		public function __construct()
		{
			parent::__construct();
			$this->load->library('doctrine');
			
			$this->load->library('loader');
			$this->loader->setController($this);
			$this->loader->setEntityManager($this->doctrine->em);
			Proxy::__init__();
		}
		
		/*
		 *	Index
		 */
		public function index()
		{
			echo 'Development controller.';
		}
		
		/*
		 *	testPrivilege() - testira da li ulogovani aktor ima privilegije za datom akcijom
		 *	@param string $action: akcija za proveru
		 */
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
		
		/*
		 *	initdb() - inicijalizuje bazu podataka sa rankovima,
		 *	administratorima i akcijama
		 */
		public function initdb()
		{
			echo 'Initializing database . . .<br/>';
			$this->loader->initializeDatabase();
			echo 'Database initialized!<br/>';
		}
		
		/*
		 *	insertSubjects() - insert-uje kategorije u bazu
		 *	! NE KREIRA FOLDERE
		 */
		public function insertSubjects()
		{
			$subjects = array
			(
				'Computer Science' => 'A computer science subject',
				'Architecture' => 'I draw like a boss',
				'Engineering' => 'Trust me I\'m an engineer ;)'
			);
			
			$this->loader->insertSubjects($subjects);
			
			echo 'Subjects inserted!<br/>';
		}
		
		/*
		 *	insertSections() - insert-uje oblasti u bazu
		 *	! NE KREIRA FOLDERE
		 */
		public function insertSections()
		{
			$subject = Subject::findByName('Computer Science')[0];
			
			$sections = array
			(
				'C#' => 'This language is GOAT',
				'C++' => 'I\'m sexy and I know it'
			);
			
			$this->loader->insertSections($subject, $sections);
			
			echo 'Sections inserted!<br/>';
		}
		
		/*
		 *	subscribeTutors() - subscribe-uje tutore na sekcije
		 */
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
			
			echo 'Tutors subscribed!<br/>';
		}
		
		/*
		 *	insertPosts() - insert-uje postove u bazu
		 *	! NE KREIRA FOLDERE
		 */
		public function insertPosts()
		{
			$sectionCS = Section::findByName('C#')[0];
			$sectionCPP = Section::findByName('C++')[0];
			$sections = array($sectionCS, $sectionCPP);
			
			$qapost = array
			(
				'type' => 'qapost',
				'title' => 'SampleTitleQApost',
				'postedon' => new \DateTime('now'),
				'originalposter' => 1,
				'description' => 'SampleDescriptionQApost',
				'acceptedanswer' => null,
				'postsections' => $sections
			);
			
			$workpost = array
			(
				'type' => 'workpost',
				'title' => 'SampleTitleWorkpost',
				'postedon' => new \DateTime('now'),
				'originalposter' => 3,
				'description' => 'SampleDescriptionWorkpost',
				'worker' => 1,
				'comittedtokens' => 99,
				'workeraccepted' => 1,
				'postsections' => array($sectionCS)
			);
			
			$posts = array($qapost, $workpost);
			$this->loader->insertPosts($posts);
			
			echo 'Posts inserted!<br/>';
		}
		
		/*
		 *	insertReplies() - insert-uje reply-eve
		 */
		public function insertReplies()
		{
			$reply1 = array
			(
				'message' => 'SampleReply',
				'postedon' => new \DateTime('now'),
				'deleted' => 0,
				'post' => 1,
				'actor' => 1
			);
			$replies = array($reply1);
			$this->loader->insertReplies($replies);
			
			echo 'Replies inserted!<br/>';
		}
		
		/*
		 *	insertPromotionRequests() - insert-uje zahteve za unapredjenje
		 *	! NE KREIRA FOLDERE
		 */
		public function insertPromotionRequests()
		{
			$request1 = array
			(
				'title' => 'Prijava za tutora',
				'description' => 'Zeleo bih da postanem tutor',
				'submittedon' => new \DateTime('now'),
				'accepted' => 0,
				'actor' => 1
			);
			$requests = array($request1);
			$this->loader->insertPromotionRequests($requests);
			
			echo 'Requests inserted!<br/>';
		}
		
		/*
		 *	initWholeDb() - inicijalizuje citavu bazu
		 */
		public function initWholeDb()
		{
			$this->initdb();
			$this->insertSubjects();
			$this->insertSections();
			$this->subscribeTutors();
			$this->insertPosts();
			$this->insertReplies();
			$this->insertPromotionRequests();
		}
	}
?>