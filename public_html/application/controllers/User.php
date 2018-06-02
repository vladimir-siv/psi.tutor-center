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
			$this->loader->loadPage('reqpromotion.php', null, 'PromotionRequest', -1, null, null);
		}
		public function requestPromotion()
		{
			if (isset($this->session->actor)){
				// TODO: REGEX sa cirilicnim slovima
				$this->load->library('form_validation');
				
				$this->form_validation->set_rules('position', 'Position', 'required');
				$this->form_validation->set_rules('description', 'Description', 'required');
				
				$position= $this->input->post('position');
				$description = $this->input->post('description');
				if ($this->form_validation->run())
				{
                    $em = $this->loader->getEntityManager();
                    if($this->session->actor->getRawRank()==Rank::Administrator)
                    {
                        echo '#Error: You have already acquired maximum rank.';
                        return;
                    }
                    $existing_request = $em->createQuery('SELECT pr FROM PromotionRequest pr WHERE pr.actor = :actorid AND pr.accepted IS NULL')
                            ->setParameter('actorid', $this->session->actor->getId())
                            ->getResult();
                    if($existing_request != null)
                    {
                        echo '#Error: You have already posted request which is awaiting review.';
                        return;
                    }
					$request = array
					(
					'title' => $position,
					'description' => $description,
					'submittedon' => new \DateTime('now'),
					'accepted' => null,
					'actor' => $this->session->actor->getId()
					);
					$this->loader->insertPromotionRequests(array($request));
					echo 'Success';
				}
				else echo '#Error: Data not valid.';
			}
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
		
		public function changeProfilePic()
		{
			if (isset($this->session->actor))
			{
				if (isset($_FILES['+profile-pic']))
				{
					$this->load->helper(array('form', 'url'));
					$this->load->library('upload', array
					(
						'upload_path'	=> FCPATH.'assets/storage/users/'.$this->session->actor->getId().'/',
						'allowed_types'	=> 'png',
						'max_size'		=> 102400,
						'file_name'		=> 'avatar.png',
						'overwrite'		=> true
					));
					
					if ($this->upload->do_upload('+profile-pic')) echo '<b>Success!</b> Your profile picture has been changed!';
					else echo '#Error: <b>Error!</b> Profile picture could not be uploaded!';
				}
				else echo '#Error: <b>Error!</b> Profile picture could not be uploaded!';
			}
		}
	}
?>