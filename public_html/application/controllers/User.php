<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	require_once 'application/models/Entities.php';
	require_once 'application/controllers/Guest.php';
	
	class User extends Guest
	{
		public function __construct()
		{
			parent::__construct();
		}
		
		public function create_post()
		{
			$this->loader->loadPage('create-post.php', null, 'Create Post', -1, array('assets/js/posts.js', 'assets/ajax/search.ajax.js'));
		}
		
		public function req_promotion()
		{
			throw new Exception('Not Yet Implemented');
		}
                
                public function changeAbout()
                {
                    if (isset($this->session->actor) && Privilege::has($this->session->actor->getRawRank(), 'ChangeAbout'))
                    {
                                $this->load->library('form_validation');
				
				$this->form_validation->set_rules('description', 'Description', 'required');
                                
                                if ($this->form_validation->run())
                                {
                                        $description = $this->input->post('description');
                                        $qb = $this->loader->getEntityManager()->createQueryBuilder();
                                        $qb->select('a')->from('Actor', 'a')->where('a.id = :id')->setParameter('id', $this->session->actor->getId());
                                        $query = $qb->getQuery();
                                        $actor = $query->getSingleResult();
                                        $tokens = $actor->getTokens();
                                        $em = $this->loader->getEntityManager();
                                        $actor->setDescription($description);
                                        $em->flush();
                                        echo 'Success!';
                                }
                                else echo '#Error: Data is not valid.';
			}
                }
                
                public function changeDatails()
                {
                    if (isset($this->session->actor) && Privilege::has($this->session->actor->getRawRank(), 'ChangeDetails'))
                    {
                                $this->load->library('form_validation');
				
                                $firstname = $this->input->post('firstname');
                                $lastname = $this->input->post('lastname');
                                $email = $this->input->post('email');
                                $birthdate = $this->input->post('birthdate');
                                
                                if (isset($email) && !empty($email)) $this->form_validation->set_rules('email', 'Email', 'valid_email');
                                
                                if (isset($firstname) && !empty($firstname))
                                {
                                    if (preg_match("/^[a-zA-Z]*$/", $firstname) == false)
                                    {
                                        echo '#Error: Data is not valid.';
                                        return;
                                    }
                                }
                                if (isset($lastname) && !empty($lastname))
                                {
                                    if (preg_match("/^[a-zA-Z]*$/", $lastname) == false)
                                    {
                                        echo '#Error: Data is not valid.';
                                        return;
                                    }
                                }
                                if (isset($birthdate) && !empty($birthdate))
                                {
                                    if (preg_match("/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|1[0-9]|2[0-9]|3(0|1))$/", $this->input->post('birthdate')) == false)
                                    {
                                        echo '#Error: Data is not valid.';
                                        return;
                                    }
                                }
                                $run = true;
                                if (isset($email) && !empty($email)) $run = $this->form_validation->run();
                                if ($run)
                                {
                                        $qb = $this->loader->getEntityManager()->createQueryBuilder();
                                        $qb->select('a')->from('Actor', 'a')->where('a.id = :id')->setParameter('id', $this->session->actor->getId());
                                        $query = $qb->getQuery();
                                        $actor = $query->getSingleResult();
                                        $em = $this->loader->getEntityManager();
                                        if ($firstname != "") $actor->setFirstname($firstname);
                                        if ($lastname != "") $actor->setLastname($lastname);
                                        if ($email != "") $actor->setEmail($email);
                                        if ($birthdate != "")
                                        {
                                            $birthdate = new \DateTime($birthdate);
                                            $actor->setBirthdate($birthdate);
                                        }
                                        $em->flush();
                                        echo 'Success!';
                                }
                                else echo '#Error: Data is not valid.';
			}                   
                }
                
	}
?>