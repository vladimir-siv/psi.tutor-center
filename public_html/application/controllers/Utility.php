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
			Proxy::__init__();
		}
		
		public function index()
		{
			if ($this->session->actor !== null) echo 'Success! User is: '.$this->session->actor->getFirstname();
			else echo 'No one is logged in';
		}
		   
		public function register()
		{
			// TODO: REGEX sa cirilicnim slovima
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('email', 'E-mail', 'required|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'required');
			$this->form_validation->set_rules('firstname', 'First Name', 'required');
			$this->form_validation->set_rules('lastname', 'Last Name', 'required');
			$this->form_validation->set_rules('birthdate', 'Birth date', 'required');
			
			$firstname= $this->input->post('firstname');
			$lastname = $this->input->post('lastname');
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$email = $this->input->post('email');
			
			if ($this->form_validation->run() && preg_match("/^[a-zA-Z]*$/", $firstname) == true && preg_match("/^[a-zA-Z]*$/", $lastname) == true 
				&& preg_match("/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|1[0-9]|2[0-9]|3(0|1))$/", $this->input->post('birthdate')) == true)
			{
				$birthdate = new \DateTime($this->input->post('birthdate'));
				$actor = Actor::New
				(
					$firstname,
					$lastname,
					$email,
					$username,
					$password,
					$birthdate,
					Rank::User
				);
				
				try
				{
					$em = $this->loader->getEntityManager();
					$em->persist($actor);
					$em->flush();
					echo 'Success!';
				}
				catch (Exception $ex) { echo '#Error: Username/Email already in use.'; }
			}
			else echo '#Error: Data is not valid.';
		}
        
		public function login()
		{
			$actor = Actor::findByUsernameAndPassword($this->input->post('username'), $this->input->post('password'));
			
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
			echo 'Success!';
		}
		
		public function createSubject()
		{
			if (isset($this->session->actor) && Privilege::has($this->session->actor->getRawRank(), 'CreateSubject'))
			{
				$this->load->library('form_validation');
				
				$this->form_validation->set_rules('name', 'Name', 'required');
				$this->form_validation->set_rules('description', 'Description', 'required');
				
				if ($this->form_validation->run())
				{
					$name = $this->input->post('name');
					$description = $this->input->post('description');
					
					$subject = Subject::New
					(
						$name,
						$description
					);
					
					try
					{
						$em = $this->loader->getEntityManager();
						$em->persist($subject);
						$em->flush();
						echo 'Success!';
					}
					catch (Exception $ex) { echo '#Error: Could not create the subject.'; }
				}
				else echo '#Error: Data is not valid.';
			}
		}
	}
?>