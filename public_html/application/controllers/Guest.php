<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	//require_once 'application/models/Actor.php';

        class Guest extends CI_Controller
	{
                
                private function view($page, $data)
                {
                   $this->load->view($page, $data);
                }
                
		public function __construct()
		{
                    parent::__construct();
                    $this->load->library('loader');
                    $this->load->library('doctrine');
		}
		
                private function loadModels()
                {
                    $this->load->model('Action');
                    $this->load->model('Actor');
                    $this->load->model('ActorRank');
                    $this->load->model('ActorReview');
                    $this->load->model('Notification');
                    $this->load->model('Post');
                    $this->load->model('PromotionRequest');
                    $this->load->model('QAPost');
                    $this->load->model('Reply');
                    $this->load->model('Section');
                    $this->load->model('Subject');
                    $this->load->model('WorkPost');
                }
                
		public function index()
		{
	           $this->loader->loadSimplePage($this);
		}
                
                public function login()
                {
                   $this->loader->loadEntities();
                   $em = $this->doctrine->em;
                   $q = $em->createQuery("SELECT a.username, a.password FROM Actor a WHERE a.username = :username AND a.password = :password");
                   $q->setParameter('username', $this->input->post('username'));
                   $q->setParameter('password', md5($this->input->post('password')));
                   $result = $q->getResult();
                   if (count($result) == 1) echo "SUCCESS";
                   else echo "#Error: Username or password is not valid!";
                }
                
                public function logout()
                {
                    $this->session_unset_userdata('actor');
                    $this->session->sess_destroy();
                    redirect("Utility/index");
                }
                
	}
?>