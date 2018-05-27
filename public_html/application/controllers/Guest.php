<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	require_once 'application/models/Entities.php';
	
	class Guest extends CI_Controller
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
		
                /*
                 * index() - poziva se funkcija za otvaranje stranice index.php
                 */
		public function index()
		{
		        $this->loader->loadPage('index.php', null, 'Index', 0);
		}
		
                /*
                 * subjects() - dohvata sve predmete i salje ih stranici subjects.php
                 * koju i otvara
                 */
		public function subjects()
		{
			$subjects = $this->loader->getEntityManager()->createQuery('SELECT s FROM Subject s')->getResult();
			$this->loader->loadPage('subjects.php', array('subjects' => $subjects), 'Subjects', 1);
		}
		
                /*
                 *  tutors() - dohvata sve tutore i broj domacih koji su oni uradili i 
                 *  salje ih stranici subjects.php koju i otvara
                 */
		public function tutors()
		{
			$qb = $this->loader->getEntityManager()->createQueryBuilder();
			$qb->select('a')->from('Actor', 'a')->where('a.actorrank > 2');
			$query = $qb->getQuery();
			$tutors = $query->getResult();
			
			$numOfWorkpost = array();
			foreach ($tutors as $tutor)
			{
				$qb = $this->loader->getEntityManager()->createQueryBuilder();
				$qb->select('count(w.id)')->from('Workpost', 'w')->where('w.worker = :tutorid')->setParameter('tutorid', $tutor->getId());
				$query = $qb->getQuery();
				$workpostsCount = $query->getSingleScalarResult();
				$numOfWorkpost[$tutor->getId()] = $workpostsCount;
			}
			
			$tutorsvms = $this->load->view('templates/generate-tutors.php', array('tutors' => $tutors, 'numOfWorkpost' => $numOfWorkpost), true);
			$this->loader->loadPage('tutors.php', null, 'Tutors', 2, array('scripts' => 'assets/js/tutors.js'), $tutorsvms);
		}
               
                /*
                 *  about() - poziva se funkcija za otvaranje about.php
                 */
		public function about()
		{
			$this->loader->loadPage('about.php', null, 'About', 4);                    
		}
		
                /*
                 *  subject() - dohvata sve section-e u okviru tog subject-a
                 *  i salje ih stranici subject.php koju i otvara
                 *  @param int $id : identifikator subject-a
                 */
		public function subject($id)
		{
			$qb = $this->loader->getEntityManager()->createQueryBuilder();
			$qb->select('s')->from('Subject', 's')->where('s.id = :id')->setParameter('id', $id);
			$query = $qb->getQuery();
			$subject = $query->getSingleResult();
			
			$qb = $this->loader->getEntityManager()->createQueryBuilder();
			$qb->select('s')->from('Section', 's')->where('s.subject = :id')->setParameter('id', $id);
			$query = $qb->getQuery();
			$sections = $query->getResult();
			$this->loader->loadPage('subject.php', array('subject' => $subject, 'sections' => $sections), 'Sections');
		}
                
                /*
                 *  section() - dohvata sve tutor-e subscribe-ovanih
                 *  na tu sekciju i broj postova koji su oni
                 *  do sad odradili
                 *  @param int $id : identifikator section-a
                 */
		public function section($id)
		{
			$section = $this->loader->getEntityManager()->find('Section', $id);
			$tutors = $section->getSubscribers();
			
			$numOfWorkpost = array();
			foreach ($tutors as $tutor)
			{
				$qb = $this->loader->getEntityManager()->createQueryBuilder();
				$qb->select('count(w.id)')->from('Workpost', 'w')->where('w.worker = :tutorid')->setParameter('tutorid', $tutor->getId());
				$query = $qb->getQuery();
				$workpostsCount = $query->getSingleScalarResult();
				$numOfWorkpost[$tutor->getId()] = $workpostsCount;
			}
			
			$tutorsvms = $this->load->view('templates/generate-tutors.php', array('tutors' => $tutors, 'numOfWorkpost' => $numOfWorkpost), true);
			$this->loader->loadPage('section.php', array('section' => $section), 'Sections', -1, array('scripts' => 'assets/js/tutors.js'), $tutorsvms);
		}
	}
?>