<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	require_once 'application/models/Entities.php';
	require_once 'application/controllers/Guest.php';
	
	class User extends Guest
	{
		/*
		 * Konstruktor
		 */
		public function __construct()
		{
			parent::__construct();
		}

		/*
		* create_post() - otvara stranicu create-post.php
		*/
		public function create_post()
		{
			$this->loader->loadPage('create-post.php', null, 'Create Post', -1, array('assets/js/posts.js', 'assets/ajax/search.ajax.js'));
		}

		/*
		* req_promotion() - otvara stranicu reqpromotion.php
		*/
		public function req_promotion()
		{
			$this->loader->loadPage('reqpromotion.php', null, 'PromotionRequest', -1, null, null);
		}

		/*
		* requestPromotion() - obradjuje zahtev za promociju
		*/
		public function requestPromotion()
		{
			if (isset($this->session->actor))
			{
				$this->load->library('form_validation');
				
				$this->form_validation->set_rules('position', 'Position', 'required');
				$this->form_validation->set_rules('description', 'Description', 'required');
				
				$position= $this->input->post('position');
				$description = $this->input->post('description');
				if ($this->form_validation->run())
				{
                    $em = $this->loader->getEntityManager();
                    if ($this->session->actor->getRawRank()==Rank::Administrator)
                    {
                        echo '#Error: You have already acquired maximum rank.';
                        return;
                    }
                    //$existing_request = $em->createQuery('SELECT pr FROM PromotionRequest pr WHERE pr.actor = :actorid AND pr.accepted IS NULL')
                    //        ->setParameter('actorid', $this->session->actor->getId())
					//		->getResult();
					$existing_request = PromotionRequest::getAwaitingRequest($this->session->actor->getId());
                    if ($existing_request != null)
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
					$insertedrequest = $this->loader->insertPromotionRequests(array($request));
					$requestid = $insertedrequest[0]->getId();
					$this->load->helper(array('form', 'url'));
					$this->load->library('upload', array
					(
						'upload_path'	=> FCPATH.'assets/storage/requests/'.$requestid.'/',
						'allowed_types'	=> 'txt|doc|docx|pdf|jpg|png',
						'max_size'		=> 102400
					));

					if (!is_dir(FCPATH.'assets/storage/requests/'.$requestid.'/')) mkdir(FCPATH.'assets/storage/requests/'.$requestid.'/', 0777, TRUE);

					$uploadedall = true;
					
					foreach ($_FILES as $id => $file)
					{
						if (!$this->upload->do_upload($id))
						{
							$uploadedall = false;
						}
					}
					
					if ($uploadedall) echo '<b>Success!</b> Your promotion request has been sent!';
					else echo '#Warning: <b>Success!</b> Your promotion request has been sent, but some of the files could not be uploaded!';
				}
				else echo '#Error: Data not valid.';
			}
		}

		/*
		* changeAbout() - obradjuje zahtev za promenu description-a u okviru profile-a
		*/
		public function changeAbout()
		{
			if (isset($this->session->actor) && Privilege::has($this->session->actor->getRawRank(), 'ChangeAbout'))
			{
				$this->load->library('form_validation');

				$this->form_validation->set_rules('description', 'Description', 'required');
				
				if ($this->form_validation->run())
				{
					$description = $this->input->post('description');
					//$qb = $this->loader->getEntityManager()->createQueryBuilder();
					//$qb->select('a')->from('Actor', 'a')->where('a.id = :id')->setParameter('id', $this->session->actor->getId());
					//$query = $qb->getQuery();
					//$actor = $query->getSingleResult();
					$em = $this->loader->getEntityManager();
					$actor = $em->find('Actor', $this->session->actor->getId());
					$tokens = $actor->getTokens();
					$em = $this->loader->getEntityManager();
					$actor->setDescription($description);
					$em->flush();
					echo 'Success!';
				}
				else echo '#Error: Data is not valid.';
			}
		}

		/*
		* changeDatails() - obradjuje zahtev za promenu licnih informacija u okviru profila
		*/
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
						//$qb = $this->loader->getEntityManager()->createQueryBuilder();
						//$qb->select('a')->from('Actor', 'a')->where('a.id = :id')->setParameter('id', $this->session->actor->getId());
						//$query = $qb->getQuery();
						//$actor = $query->getSingleResult();
						$em = $this->loader->getEntityManager();
						$actor = $em->find('Actor', $this->session->actor->getId());
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

		/*
		* changeProfilePic() - obradjuje zahtev za promenu profilne slike
		*/
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
        
		/*
		* changeSubjectPic() - obradjuje zahtev za promenu slike subject-a
		*/
        public function changeSubjectPic()
		{
			if (isset($this->session->actor) && $this->session->actor->getRawRank() == Rank::Administrator)
			{
				if (isset($_FILES['+subject-pic']))
				{
					$this->load->helper(array('form', 'url'));
					$this->load->library('upload', array
					(
						'upload_path'	=> FCPATH.'assets/storage/subjects/'.$this->input->post('id').'/',
						'allowed_types'	=> 'png',
						'max_size'		=> 102400,
						'file_name'		=> 'icon.png',
						'overwrite'		=> true
					));
					
					if ($this->upload->do_upload('+subject-pic')) echo '<b>Success!</b> Your profile picture has been changed!';
					else echo '#Error: <b>Error!</b> Profile picture could not be uploaded!';
				}
				else echo '#Error: <b>Error!</b> Profile picture could not be uploaded!';
			}
		}
        
		/*
		* changeSectionPic() - obradjuje zahtev za promenu slike section-a
		*/          
        public function changeSectionPic()
		{
			if (isset($this->session->actor) && $this->session->actor->getRawRank() == Rank::Administrator)
			{
				if (isset($_FILES['+section-pic']))
				{
					$this->load->helper(array('form', 'url'));
					$this->load->library('upload', array
					(
						'upload_path'	=> FCPATH.'assets/storage/subjects/'.$this->input->post('id1').'/sections/'.$this->input->post('id2').'/',
						'allowed_types'	=> 'png',
                                                'max_size'		=> 102400,
                                                'file_name'		=> 'icon.png',
                                                'overwrite'		=> true
					));
					
					if ($this->upload->do_upload('+section-pic')) echo '<b>Success!</b> Your profile picture has been changed!';
					else echo '#Error: <b>Error!</b> Profile picture could not be uploaded!';
				}
				else echo '#Error: <b>Error!</b> Profile picture could not be uploaded!';
			}
            else echo '#Error: Error';
		}
		
		/*
		* attachWorkerFiles() - obradjuje zahtev za upload-ovanje file-ova od strane tutor-a
		*/  
		public function attachWorkerFiles()
		{
			if (isset($this->session->actor)){
				$workpostid = $this->input->post('workpostid');
				$em = $this->loader->getEntityManager();
				$workpost = $em->find('Workpost', $workpostid);
				$post = $em->find('Post', $workpostid);
				$worker = $em->find('Actor', $workpost->getWorker());
				if ($workpost == null || $post == null)
				{
					echo '#Error: Data not valid.';
					return;
				}
				if (!$post->getActive())
				{
					echo '#Error: Post is not active anymore.';
					return;
				}
				$workpost->setWorkeraccepted('1');
				$worker->setTokens($worker->getTokens() + ActorBalanceMetrix::LOW_TRANSFER_RATE * $workpost->getComittedtokens());
				$notification = array
				(
						'title' => 'Tokens earned',
						'content' => 'Thank you. Tokens have been transfered to your account.',
						'actorid' => $worker->getId()
				);
				$this->loader->insertNotification($notification['title'], $notification['content'], $notification['actorid']);
				$post->setActive('0');
				$em->flush();
				$this->load->helper(array('form', 'url'));
				$this->load->library('upload', array
				(
					'upload_path'	=> FCPATH.'assets/storage/posts/'.$workpostid.'/',
					'allowed_types'	=> 'txt|doc|docx|pdf|jpg|png',
					'max_size'		=> 102400
				));

				if (!is_dir(FCPATH.'assets/storage/posts/'.$workpostid.'/')) mkdir(FCPATH.'assets/storage/posts/'.$workpostid.'/', 0777, TRUE);

				$uploadedall = true;
				
				foreach ($_FILES as $id => $file)
				{
					if (!$this->upload->do_upload($id))
					{
						$uploadedall = false;
					}
				}
				$notification = array
				(
						'title' => 'Worker attached files to your post',
						'content' => 'Review <a href=\"'.base_url().'Guest/post/'.$workpostid.'\">post</a>.',
						'actorid' => $post->getOriginalposter()
				);
				$this->loader->insertNotification($notification['title'], $notification['content'], $notification['actorid']);
				if ($uploadedall) echo '<b>Success!</b> Your files have been uploaded!';
				else echo '#Warning: <b>Success!</b> Some of the files could not be uploaded!';
			}
		}
	}
?>