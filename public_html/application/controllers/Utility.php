<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	require_once 'application/models/Entities.php';
	
	class Utility extends CI_Controller
	{
		/*
		 *  copyAvatar() - kopira sliku iz jednog fajla u novi fajl
		 *  @param int $id : identifikator korisnika koji se registrovao
		 */
		private function copyAvatar($id)
		{
			$src= FCPATH.'assets\res\avatar.png';
			$dest=FCPATH.'assets\storage\users\\'.$id;
			return copy($src, $dest.'\avatar.png');
		}
		
		/*
		 *	createFolderSubject() - kreira folder za subject
		 *	@param int $id : identifikator kategorije
		 */
		private function createFolderSubject($id)
		{
			$src= FCPATH.'assets\res\icon.png';
			$dest=FCPATH.'assets\storage\subjects\\'.$id;
			return copy($src, $dest.'\icon.png');                    
		}
		
		/*
		 *	createFolderSection() - kreira folder za section
		 *	@param int $subject : identifikator kategorije
		 *	@param int $section : identifikator oblasti
		 */
		private function createFolderSection($subject, $section)
		{
			$src= FCPATH.'assets\res\icon.png';
			$dest=FCPATH.'assets\storage\subjects\\'.$subject.'\sections\\'.$section;
			return copy($src, $dest.'\icon.png');                    
		}
		
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
		 *	index() - pocetna test strana kontrolera
		 */
		public function index()
		{
			if ($this->session->actor !== null) echo 'Success! User is: '.$this->session->actor->getFirstname();
			else echo 'No one is logged in';
		}
		
		/*
		 *  register() - registracija korsnika
		 *  proverava se validnost podataka
		 *  kreira se i ubacuje u bazu novi korisnik
		 *  kreira se novi folder sa korisnickim $id-em
		 *  kopira se podrazumevajuca slika pomocu funkcije
		 *  copyAvatar()
		 */
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
					if (mkdir(FCPATH.'assets\storage\users\\'.$actor->getId()) == false)
					{
						echo '#Error: We don\'t create folder';
						return;
					}
					if ($this->copyAvatar($actor->getId()) == false)
					{
						echo 'We don\'t create image';
					}
					echo 'Success!';
				}
				catch (Exception $ex) { echo '#Error: Username/Email already in use.'; }
			}
			else echo '#Error: Data not valid.';
		}
		
		/*
		 *  login() - login korisnika
		 *  provarava se validnost Username-a i Password-a
		 */
		public function login()
		{
			$actor = Actor::findByUsernameAndPassword($this->input->post('username'), $this->input->post('password'));
			
			if ($actor === null)
			{
				echo '#Error: Username or password is not valid or you are banned!';
				return;
			}
			
			$this->session->set_userdata('actor', $actor);
			
			echo 'Success!';
		}
		
		/*
		 *  logut() - logout korisnika
		 */
		public function logout()
		{
			if (isset($this->session->actor)) $this->session->unset_userdata('actor');
			$this->session->sess_destroy();
			echo 'Success!';
		}
		
		/*
		 * createSubject() - kreiranje predmeta
		 * ispituje validnost podataka
		 * kreira se novi subject u bazi
		 */
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
					
					$subjects = Subject::findByName($name);
					if (count($subjects) == 1)
					{
						if ($subjects[0]->getDeleted() != 1) 
						{
							echo '#Error: Subject with this name exist\'s!';
							return;
						}
						
						$em = $this->loader->getEntityManager();
						$subjects[0]->setDeleted(0);
						$subjects[0]->setDescription($description);
						$em->flush();
						echo 'Success!';
						return;
					}
					
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
					}
					catch (Exception $ex) { echo '#Error: Could not create the subject.'; }
					
					if (mkdir(FCPATH.'assets/storage/subjects/'.$subject->getId()) === false)
					{
						echo '#Error: We don\'t create folder';
						return;
					}
					if (mkdir(FCPATH.'assets\storage\subjects\\'.$subject->getId().'\sections') === false)
					{
					   echo '#Error: We don\'t create folder1';
					   return;
					}
					if ($this->createFolderSubject($subject->getId()) === false)
					{
						echo 'We don\'t create image';
					}
					echo 'Success!';
				}
				else echo '#Error: Data not valid.';
			}
		}
		
		/*
		 * createSection() - kreiranje sekcije
		 * provara validnosti podataka
		 * provera da li postoji subject sa tim imenom
		 * provera da li postoji section sa tim imenom
		 */
		public function createSection()
		{
			if (isset($this->session->actor) && Privilege::has($this->session->actor->getRawRank(), 'CreateSection'))
			{
				$this->load->library('form_validation');
				
				$this->form_validation->set_rules('name', 'Name', 'required');
				$this->form_validation->set_rules('subject', 'Subject', 'required');
				$this->form_validation->set_rules('description', 'Description', 'required');
				
				if ($this->form_validation->run())
				{
					$name = $this->input->post('name');
					$subject= $this->input->post('subject');
					$description = $this->input->post('description');
					
					$subjects = Subject::findByName($subject);
					if (count($subjects) == 0)
					{
						echo '#Error: Subject with this name not exist!';
						return;
					}
					
					if (count($subjects) != 1)
					{
						echo '#Error: More then one subject with that name exist!';
						return;
					}
					
					$sections = Section::findByName($name);
					if (count($sections) == 1)
					{
						 if ($sections[0]->getDeleted() != 1 || $sections[0]->getSubject() != $subjects[0]->getId()) 
						{
							echo '#Error: Section with this name exist\'s!';
							return;
						}
						$em = $this->loader->getEntityManager();
						$sections[0]->setDeleted(0);
						$sections[0]->setDescription($description);
						$em->flush();
						echo 'Success!';
						return;
					}
								
					$section = Section::New
					(
						$name,
						$description,
						$subjects[0]->getId()
					);
					
					try
					{
						$em = $this->loader->getEntityManager();
						$em->persist($section);
						$em->flush();
					}
					catch (Exception $ex) { echo '#Error: Could not create the subject.'; }
								
					if (mkdir(FCPATH.'assets/storage/subjects/'.$subjects[0]->getId().'/sections/'.$section->getId()) === false)
					{
						echo '#Error: We don\'t create folder';
						return;
					}
					
					if ($this->createFolderSection($subjects[0]->getId(), $section->getId()) === false)
					{
						echo 'We don\'t create image';
					}
					echo 'Success!';
				}
				else echo '#Error: Data is not valid.';                      
			}
		}
		
		/*
		 *	sellTokens() - prodaja tokena kroz dijalog
		 */
		public function sellTokens()
		{
			if (isset($this->session->actor) && Privilege::has($this->session->actor->getRawRank(), 'SellTokens'))
			{
				$this->load->library('form_validation');

				$this->form_validation->set_rules('accountnumber', 'Acountnumber', 'required');
				$this->form_validation->set_rules('amountTokens', 'AmountTokens', 'required');
				
				if ($this->form_validation->run() && preg_match("/^\d+$/", $this->input->post('accountnumber')) == true
										&& preg_match("/^\d+$/", $this->input->post('amountTokens')) == true)
				{
					$accountnumber = $this->input->post('accountnumber');
					$amountTokens = $this->input->post('amountTokens');
					
					$em = $this->loader->getEntityManager();
					
					//$qb = $this->loader->getEntityManager()->createQueryBuilder();
					//$qb->select('a')->from('Actor', 'a')->where('a.id = :id')->setParameter('id', $this->session->actor->getId());
					//$query = $qb->getQuery();
					//$actor = $query->getSingleResult();
					
					$actor = $em->find('Actor', $this->session->actor->getId());
					
					$tokens = $actor->getTokens();
					
					if ($amountTokens > $tokens)
					{
						echo '#Error: Not enough tokens!';
						return;
					}
					
					$tokens -= $amountTokens;
					$actor->setTokens($tokens);
					$em->flush();
					
					echo 'Success!';
				}
				else echo '#Error: Data is not valid.';
			}
		}
		
		/*
		 *	buyTokens() - kupovina tokena kroz dijalog
		 */
		public function buyTokens()
		{
			if (isset($this->session->actor) && Privilege::has($this->session->actor->getRawRank(), 'BuyTokens'))
			{
				$this->load->library('form_validation');

				$this->form_validation->set_rules('accountnumber', 'Acountnumber', 'required');
				$this->form_validation->set_rules('amountEuro', 'AmountEuro', 'required');
				
				if ($this->form_validation->run() && preg_match("/^\d+$/", $this->input->post('accountnumber')) == true
										&& preg_match("/^\d+$/", $this->input->post('amountEuro')) == true)
				{
					$accountnumber = $this->input->post('accountnumber');
					$amountEuro = $this->input->post('amountEuro');
					
					$em = $this->loader->getEntityManager();
					
					//$qb = $this->loader->getEntityManager()->createQueryBuilder();
					//$qb->select('a')->from('Actor', 'a')->where('a.id = :id')->setParameter('id', $this->session->actor->getId());
					//$query = $qb->getQuery();
					//$actor = $query->getSingleResult();
					
					$actor = $em->find('Actor', $this->session->actor->getId());
					
					$tokens = $actor->getTokens();
					$tokens += $amountEuro * ActorBalanceMetrix::TOKEN_RATE;
					
					$actor->setTokens($tokens);
					$em->flush();
					echo 'Success!';
				}
				else echo '#Error: Data is not valid.';
			}
		}
		
		/*
		 *	createPost() - kreiranje posta
		 */
		public function createPost()
		{
			if (isset($this->session->actor) && Privilege::has($this->session->actor->getRawRank(), 'CreatePost'))
			{
				$this->load->library('form_validation');
				
				$this->form_validation->set_rules('post-title', 'Title', 'required');
				$this->form_validation->set_rules('section', 'Post Sections', 'required');
				$this->form_validation->set_rules('post-type', 'Type', 'required');
				// Needed for both WorkPost & QAPost (if new one is added, should be considered to move to another place)
				$this->form_validation->set_rules('post-description', 'Description', 'required');
				
				if ($this->form_validation->run())
				{
					$em = $this->loader->getEntityManager();
					$sections = array();
					$post = null;
					$sectionidarray = explode(",", $this->input->post('section'));
					
					foreach($sectionidarray as $sectionid)
					{
						$section = $em->find('Section', $sectionid);
						$sections[] = $section;
					}
					
					if($this->input->post('post-type')==='QA')
					{
						$post = array
						(
						'type' => 'qapost',
						'title' => $this->input->post('post-title'),
						'postedon' => new \DateTime('now'),
						'originalposter' => $this->session->actor->getId(),
						'description' => $this->input->post('post-description'),
						'acceptedanswer' => null,
						'postsections' => $sections
						);
					}
					else if($this->input->post('post-type')==='Work')
					{
						$post = array
						(
						'type' => 'workpost',
						'title' => $this->input->post('post-title'),
						'postedon' => new \DateTime('now'),
						'originalposter' => $this->session->actor->getId(),
						'description' => $this->input->post('post-description'),
						'worker' => null,
						'comittedtokens' => null,
						'workeraccepted' => 0,
						'postsections' => $sections
						);
					}
					
					$posts = array($post);
					$insertedpost = $this->loader->insertPosts($posts);
					$postid = $insertedpost[0][0]->getId();
					$this->load->helper(array('form', 'url'));
					$this->load->library('upload', array
					(
						'upload_path'	=> FCPATH.'assets/storage/posts/'.$postid.'/',
						'allowed_types'	=> 'txt|doc|docx|pdf|jpg|png',
						'max_size'		=> 102400
					));

					if(!is_dir(FCPATH.'assets/storage/posts/'.$postid.'/')) mkdir(FCPATH.'assets/storage/posts/'.$postid.'/', 0777, TRUE);

					$uploadedall = true;
					
					foreach ($_FILES as $id => $file)
					{
						if (!$this->upload->do_upload($id))
						{
							$uploadedall = false;
						}
					}
					
					if ($uploadedall) echo '<b>Success!</b> Your post has been created!';
					else echo '#Warning: <b>Success!</b> Your post has been created, but some of the files could not be uploaded!';
				}
				else echo '#Error: Data not valid.';
			}
		}
		
		/*
		 *	searchdb() - pretraga baze po raznim kategorijama
		 *	! Trenutno postoji samo pretraga oblasti koja se koristi
		 *	! kod selektovanja pripadnosti kod kreiranja posta
		 */
		public function searchdb()
		{
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('domain', 'Domain', 'required');
			$this->form_validation->set_rules('params', 'Params', 'required');
			
			if ($this->form_validation->run())
			{
				$domain = $this->input->post('domain');
				$format = $this->input->post('format');
				$params = json_decode($this->input->post('params'));
				
				if ($domain === 'subject-section') echo Section::searchSubjectSection($params[0], $params[1], $format);
			}
			else '#Error: Provided data does not match any valid database search.';
		}
		
		/*
		 *	subscribeTutor() - subscribe-uje tutora na datu oblast
		 */
		public function subscribeTutor()
		{
			if (isset($this->session->actor) && $this->session->actor->getRawRank() >= Rank::Tutor)
			{
				try
				{
					$em = $this->loader->getEntityManager();
					$subscription = $this->session->actor->getSubscription($this->input->post('section'));
					
					if (count($subscription) > 0)
					{
						$em->remove($subscription[0]);
						echo 'Successfully unsubscribed!';
					}
					else
					{
						$subscription = SectionSubscription::New($this->session->actor->getId(), $this->input->post('section'));
						$em->persist($subscription);
						echo 'Successfully subscribed!';
					}
					
					$em->flush();
				}
				catch (Exception $ex) { echo '#Error: Unknown internal error.'; }
			}
		}
		
		/*
		 *	toggleSeen() - togluje sina
		 */
		public function toggleSeen()
		{
			if (isset($this->session->actor))
			{
				
				$this->load->library('form_validation');
				
				$this->form_validation->set_rules('notificationid', 'notificationid', 'required');

				if($this->form_validation->run())
				{
					$em = $this->loader->getEntityManager();
					$notification = $em->find('Notification', $this->input->post('notificationid'));
					if($notification != null && $notification->getActor() == $this->session->actor->getId())
					{
						$notification->setSeen(!$notification->getSeen());
						$em->flush();
					}
				}
			}
		}
		
		/*
		 *	deleteSubject() - logicki brise kategoriju
		 */
		public function deleteSubject()
		{
			if (isset($this->session->actor) && Privilege::has($this->session->actor->getRawRank(), 'DeleteSubject'))
			{
				$subjectid = $this->input->post('subjectid');
				$em = $this->loader->getEntityManager();
				$subject = $em->find('Subject', $subjectid);
				
				if ($subject != null)
				{
					$subject->setDeleted(true);
					
					//$sections = $em->createQuery('SELECT s FROM Section s WHERE s.subject = :subjectid')
					//				->setParameter('subjectid', $subject->getId())
					//				->getResult();
					
					$sections = Section::findBySubjectId($subject->getId());
					
					foreach ($sections as $section)
					{
						$section->setDeleted(true);
						
						//$postssections = $em->createQuery('SELECT ps FROM PostSection ps WHERE ps.section = :sectionid')
						//					->setParameter('sectionid', $section->getId())
						//					->getResult();
						
						$postssections = PostSection::findBySectionId($section->getId());
						
						foreach ($postssections as $postsection)
						{
							$post = $em->find('Post', $postsection->getPost());
							$post->setDeleted(true);
							
							//$replies = $em->createQuery('SELECT r FROM Reply r WHERE r.post = :postid')
							//			->setParameter('postid', $post->getId())
							//			->getResult();
							
							$replies = Reply::findByPostId($post->getId());
							
							foreach ($replies as $reply)
							{
								$reply->setDeleted(true);
							}
						}
					}
					
					$em->flush();
					echo '<b>Success!</b> You have successfully deleted subject!';
				}
				else echo '#Error: Data not valid.';
			}
			else echo '#Error: You don\'t have permission to delete subject.';
		}
		
		/*
		 *	deleteSection() - logicki brise oblast
		 */
		public function deleteSection()
		{
			if (isset($this->session->actor) && Privilege::has($this->session->actor->getRawRank(), 'DeleteSection'))
			{
				$sectionid = $this->input->post('sectionid');
				$em = $this->loader->getEntityManager();
				$section = $em->find('Section', $sectionid);
				
				if ($section != null)
				{
					$section->setDeleted(true);
					
					//$postssections = $em->createQuery('SELECT ps FROM PostSection ps WHERE ps.section = :sectionid')
					//					->setParameter('sectionid', $section->getId())
					//					->getResult();
					
					$postssections = PostSection::findBySectionId($section->getId());
					
					foreach ($postssections as $postsection)
					{
						$post = $em->find('Post', $postsection->getPost());
						$post->setDeleted(true);
						
						//$replies = $em->createQuery('SELECT r FROM Reply r WHERE r.post = :postid')
						//				->setParameter('postid', $post->getId())
						//				->getResult();
						
						$replies = Reply::findByPostId($post->getId());
						
						foreach ($replies as $reply)
						{
							$reply->setDeleted(true);
						}
					}
					
					$em->flush();
					echo '<b>Success!</b> You have successfully deleted section!';
				}
				else echo '#Error: Data not valid.';
			}
			else echo '#Error: You don\'t have permission to delete section.';
		}
		
		/*
		 *	deletePost() - logicki brise post
		 */
		public function deletePost()
		{
			if (isset($this->session->actor) && Privilege::has($this->session->actor->getRawRank(), 'DeletePost'))
			{
				$postid = $this->input->post('postid');
				$em = $this->loader->getEntityManager();
				$post = $em->find('Post', $postid);
				
				if ($post != null)
				{
					$post->setDeleted(true);
					
					//$replies = $em->createQuery('SELECT r FROM Reply r WHERE r.post = :postid')
					//				->setParameter('postid', $post->getId())
					//				->getResult();
					
					$replies = Reply::findByPostId($post->getId());
					
					foreach($replies as $reply)
					{
						$reply->setDeleted(true);
					}
					
					$em->flush();
					echo '<b>Success!</b> You have successfully deleted post!';
				}
				else echo '#Error: Data not valid.';
			}
			else echo '#Error: You don\'t have permission to delete section.';
		}
		
		/*
		 *	deletePost() - logicki brise reply
		 */
		public function deleteReply()
		{
			if (isset($this->session->actor) && Privilege::has($this->session->actor->getRawRank(), 'DeleteReply'))
			{
				$replyid = $this->input->post('replyid');
				$em = $this->loader->getEntityManager();
				$reply = $em->find('Reply', $replyid);
				
				if ($reply != null)
				{
					$post = $em->find('Post', $reply->getPost());
					
					if (Qapost::isReplyAccepted($post, $reply))
					{
						//$qapost = $em->createQuery('SELECT qap from Qapost qap WHERE qap.id = :postid')
						//				->setParameter('postid', $post->getId())
						//				->getSingleResult();
						
						$qapost = $em->find('Qapost', $post->getId());
						
						$qapost->setAcceptedanswer(null);
					}
					
					$reply->setDeleted(true);
					$em->flush();
					echo '<b>Success!</b> You have successfully deleted reply!';
				}
				else echo '#Error: Data not valid.';
			}
			else echo '#Error: You don\'t have permission to delete reply.';
		}
		
		/*
		 *	acceptReply() - prihvata odgovor na QAPost-u
		 */
		public function acceptReply()
		{
			$postid = $this->input->post('postid');
			$replyid = $this->input->post('replyid');
			$em = $this->loader->getEntityManager();
			$reply = $em->find('Reply', $replyid);
			$qapost = $em->find('Qapost', $postid);
			$post = $em->find('Post', $postid);
			
			if (isset($this->session->actor) && $this->session->actor->getId() == $post->getOriginalposter())
			{
				if ($reply != null && $qapost != null)
				{
					$qapost->setAcceptedanswer($replyid);
					$em->flush();
					
					$notification = array
					(
						'title' => 'Reply accepted',
						'content' => 'Review <a href=\"'.base_url().'Guest/post/'.$postid.'\">post</a>.',
						'actorid' => $reply->getActor()
					);
					
					$this->loader->insertNotification($notification['title'], $notification['content'], $notification['actorid']);
					echo '<b>Success!</b> You have successfully accepted reply!';
				}
				else echo '#Error: Data not valid.';
			}
			else echo '#Error: You don\'t have permission to accept reply.';
		}
		
		/*
		 *	createReply() - creates a new reply (replies on post)
		 */
		public function createReply()
		{
			if (isset($this->session->actor) && Privilege::has($this->session->actor->getRawRank(), 'Reply'))
			{
				$replymsg = $this->input->post('replymsg');
				$postid = $this->input->post('postid');
				$replierid = $this->input->post('replierid');
				$em = $this->loader->getEntityManager();
				$post = $em->find('Post', $postid);
				
				$reply = array
				(
					'message' => $replymsg,
					'postedon' => new \DateTime('now'),
					'deleted' => 0,
					'post' => $postid,
					'actor' => $replierid
				);
				
				$replies = array($reply);
				
				$this->loader->insertReplies($replies);
				
				$notification = array
				(
					'title' => 'Someone replied to your post',
					'content' => 'Review <a href=\"'.base_url().'Guest/post/'.$postid.'\">post</a>.',
					'actorid' => $post->getOriginalposter()
				);
				
				if ($replierid != $post->getOriginalposter()) $this->loader->insertNotification($notification['title'], $notification['content'], $notification['actorid']);
				echo 'You have successfuly replied to post.';
			}
			else echo '#Error: You don\'t have permission to delete reply.';
		}
		
		/*
		 *	acceptPromotion() - accepts a promotion request
		 */
		public function acceptPromotion()
		{
			if (isset($this->session->actor) && $this->session->actor->getRawRank() == Rank::Administrator) // == 5 !!!
			{
				$reqid = $this->input->post('reqid');
				$em = $this->loader->getEntityManager();
				$promotionrequest = $em->find('PromotionRequest', $reqid);
				$actor = $em->find('Actor', $promotionrequest->getActor());
				
				if ($promotionrequest != null)
				{
					$promotionrequest->setAccepted(1);
					$actor->setActorRank($actor->getActorRank()+1);
					$em->flush();
					$notification = array
					(
						'title' => 'Promotion accepted',
						'content' => 'You have been promoted. Congratulations!',
						'actorid' => $actor->getId()
					);
					
					$this->loader->insertNotification($notification['title'], $notification['content'], $notification['actorid']);
					echo '<b>Success!</b> You have successfully accepted promotion request!';
				}
				else echo '#Error: Data not valid.';
			}
			else echo '#Error: You don\'t have permission to accept promotion request.';
		}
		
		/*
		 *	rejectPromotion() - rejects a promotion request
		 */
		public function rejectPromotion()
		{
			if (isset($this->session->actor) && $this->session->actor->getRawRank() == Rank::Administrator) // == 5 !!!
			{
				$reqid = $this->input->post('reqid');
				$em = $this->loader->getEntityManager();
				$promotionrequest = $em->find('PromotionRequest', $reqid);
				$actor = $em->find('Actor', $promotionrequest->getActor());
				
				if ($promotionrequest != null)
				{
					$promotionrequest->setAccepted(0);
					$em->flush();
					$notification = array
					(
						'title' => 'Promotion rejected',
						'content' => 'Your promotion request has been rejected.',
						'actorid' => $actor->getId()
					);
					
					$this->loader->insertNotification($notification['title'], $notification['content'], $notification['actorid']);
					echo '<b>Success!</b> You have successfully rejected promotion request!';
				}
				else echo '#Error: Data not valid.';
			}
			else echo '#Error: You don\'t have permission to rejected promotion request.';
		}
		
		/*
		 *	banUser() - bans a user
		 */
		public function banUser()
		{
			if (isset($this->session->actor) && Privilege::has($this->session->actor->getRawRank(), 'BanUser'))
			{
				$em = $this->loader->getEntityManager();
				
				//$user = $em->createQuery('SELECT a FROM Actor a WHERE a.id = :id')
				//			->setParameter('id', $this->input->post('id'))
				//			->getSingleResult();
				
				$user = $em->find('Actor', $this->input->post('id'));
				
				$user->setBanned(1);
				$em->flush();
				echo 'Success!';
			}
			else echo '#Error: Error!';
		}
            
		/*
		 *	unbanUser() - unbans a user
		 */
		public function unbanUser()
		{
			if (isset($this->session->actor) && Privilege::has($this->session->actor->getRawRank(), 'BanUser'))
			{
				$em = $this->loader->getEntityManager();
				
				//$user = $em->createQuery('SELECT a FROM Actor a WHERE a.id = :id')
				//			->setParameter('id', $this->input->post('id'))
				//			->getSingleResult();
				
				$user = $em->find('Actor', $this->input->post('id'));
				
				$user->setBanned(0);
				$em->flush();
				echo 'Success!';
			}
			else echo '#Error: Error!';
		}
		
		/*
		 *	lockWorkPost() - zakljucava WorkPost
		 */
		public function lockWorkPost()
		{
			if (isset($this->session->actor))
			{
				$this->load->library('form_validation');
				
				$this->form_validation->set_rules('postid', 'Post ID', 'required');
				
				if ($this->form_validation->run())
				{
					$em = $this->loader->getEntityManager();
					
					$wpost = $em->find('Workpost', $this->input->post('postid'));
					
					if (isset($wpost))
					{
						$post = $em->find('Post', $wpost->getId());
						
						if ($post->getOriginalPosterId() != $this->session->actor->getId() && Privilege::has($this->session->actor->getRawRank(), 'LockPost'))
						{
							if ($wpost->getWorker() === null)
							{
								$wpost->setWorker($this->session->actor->getId());
								$em->flush();
								$notification = array
								(
									'title' => 'Your post has been locked',
									'content' => 'Review <a href=\"'.base_url().'Guest/post/'.$this->input->post('postid').'\">post</a>.',
									'actorid' => $post->getOriginalposter()
								);
								$this->loader->insertNotification($notification['title'], $notification['content'], $notification['actorid']);
								echo 'The post is locked successfully.';
							}
							else echo '#Warning: The post is already locked. Be aware that it might get unlocked soon.';
						}
						else echo '#Error: You cannot lock the post.';
					}
					else echo '#Error: Invalid post.';
				}
				else echo '#Error: Post id not provided.';
			}
		}
		
		/*
		 *	releaseWorkPost() - otkljucava WorkPost
		 */
		public function releaseWorkPost()
		{
			if (isset($this->session->actor))
			{
				$this->load->library('form_validation');
				
				$this->form_validation->set_rules('postid', 'Post ID', 'required');
				
				if ($this->form_validation->run())
				{
					$em = $this->loader->getEntityManager();
					
					$wpost = $em->find('Workpost', $this->input->post('postid'));
					
					if (isset($wpost))
					{
						$post = $em->find('Post', $wpost->getId());
						
						if ($post->getOriginalPosterId() === $this->session->actor->getId() || $wpost->getWorkerId() === $this->session->actor->getId())
						{
							$op = $post->getOriginalPosterReference();
							$tokens = $wpost->getComittedtokens();
							$tokens += $op->getTokens();
							$op->setTokens($tokens);
							$actor = $this->session->actor->getId() == $post->getOriginalPosterId() ? $wpost->getWorkerId() : $post->getOriginalPosterId();
							$notification = array
							(
								'title' => 'Post has been unlocked',
								'content' => 'Review <a href=\"'.base_url().'Guest/post/'.$this->input->post('postid').'\">post</a>.',
								'actorid' => $actor
							);
							$this->loader->insertNotification($notification['title'], $notification['content'], $notification['actorid']);
							$wpost->setWorker(null);
							$wpost->setComittedtokens(null);
							$wpost->setWorkeraccepted(false);
							
							$em->flush();
							echo 'The post has been released.';
						}
						else echo '#Error: You cannot lock the post.';
					}
					else echo '#Error: Invalid post.';
				}
				else echo '#Error: Post id not provided.';
			}
		}
		
		/*
		 *	review() - review-ovanje
		 */
 		public function review()
		{
			if (isset($this->session->actor) && Privilege::has($this->session->actor->getRawRank(), 'Review'))
			{
				$this->load->library('form_validation');
				
				$this->form_validation->set_rules('grade', 'Grade', 'required');
				$this->form_validation->set_rules('description', 'Description', 'required');
				
				$grade = $this->input->post('grade');
				$description = $this->input->post('description');
				$id = $this->input->post('postID');
				
				$em = $this->loader->getEntityManager();
				
				//$qb = $this->loader->getEntityManager()->createQueryBuilder();
				//$qb->select('w')->from('Workpost', 'w')->where('w.id = :id')->setParameter('id', $id);
				//$query = $qb->getQuery();
				//$workpost = $query->getSingleResult();
				
				$workpost = $em->find('Workpost', $id);
				
				if ($this->form_validation->run() && preg_match("/^\d$/", $grade) == true && $grade >= 1 && $grade <= 5)
				{
					$review = Actorreview::New
					(
						$grade,
						$description,
						$this->session->actor->getId(),
						$workpost->getWorker()
					);
					
					try
					{
						$em->persist($review);
						$em->flush();
						
						$notification = array
						(
							'title' => 'You have been reviewed',
							'content' => 'Go to your profile to see review.',
							'actorid' => $workpost->getWorker()
						);
						
						$this->loader->insertNotification($notification['title'], $notification['content'], $notification['actorid']);
						echo 'Success';
					}
					catch (Exception $ex) { echo '#Error: Date not valid'; }
				}
				else echo '#Error: Data not valid.';
			}
		}
		
		/*
		 *	submitTokensToWorkPost() - postavlja tokene na workpost
		 */
        public function submitTokensToWorkPost()
		{
			if (isset($this->session->actor))
			{
				$this->load->library('form_validation');
				
				$this->form_validation->set_rules('tokens', 'Tokens', 'required');
				
				if ($this->form_validation->run() && preg_match("/^\d+$/", $this->input->post('tokens')) == true)
				{
					$em = $this->loader->getEntityManager();
					
					$wpost = $em->find('Workpost', $this->input->post('postid'));
					
					if (isset($wpost))
					{
						$post = $em->find('Post', $wpost->getId());
						
						//if ($post->getOriginalPosterId() === $this->session->actor->getId())
						{
							$op = $post->getOriginalPosterReference();
							$tokens = $this->input->post('tokens');
							if ($op->getTokens() >= $tokens)
							{
								$op->setTokens($op->getTokens() - $tokens);
								$wpost->setComittedtokens($this->input->post('tokens'));
								$em->flush();
								$notification = array
								(
									'title' => 'OP has submmited tokens',
									'content' => 'Review <a href=\"'.base_url().'Guest/post/'.$post->getId().'\">post</a>.',
									'actorid' => $wpost->getWorker()
								);
								$this->loader->insertNotification($notification['title'], $notification['content'], $notification['actorid']);
								echo 'Success!';
							}
							else echo '#Error: You dont\' have enough tokens!';
						}
					}
					else echo '#Error: Invalid post.';
				}
				else echo '#Error: Invalid data.';
			}
		}
	}
?>