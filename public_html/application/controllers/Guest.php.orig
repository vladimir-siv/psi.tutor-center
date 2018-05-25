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
            }
            
            public function index()
            {
                $this->about();
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
			$this->session->unset_userdata('actor');
                $this->session->sess_destroy();
                redirect("Utility/index");
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
            
            public function showAllSubjects()
            {
                $this->loader->loadEntities();
                $qb = $this->loader->getEntityManager()->createQueryBuilder();
                $qb->select('s')->from('Subject', 's');
                $query = $qb->getQuery();
                $subjects = $query->getResult();
                $this->loader->loadPage('subjects.php', array('subjects' => $subjects, ), 'Subjects');
            }
            
            public function about()
            {
                $this->loader->loadEntities();
                $this->loader->loadPage('about.php', null, 'About');                    
            }
	}
?>