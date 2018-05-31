<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	require_once 'application/models/Entities.php';
	
	class Utility extends CI_Controller
	{
		private function addSlidesToPath($id)
		{
			$src= FCPATH.'assets\res\avatar.png';
			$dest=FCPATH.'assets\storage\users\\'.$id;
			return copy($src, $dest.'\avatar.png');
		}
		
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
                
                
                /*
                 *  addSlidesToPath() - kopira sliku iz jednog fajla u novi fajl
                 *  @Param int $id : identifikator korisnika koji se registrovao
                 */
                /*
                 *  register() - registracija korsnika
                 *  proverava se validnost podataka
                 *  kreira se i ubacuje u bazu novi korisnik
                 *  kreira se novi folder sa korisnickim $id-em
                 *  kopira se podrazumevajuca slika pomocu funkcije
                 *  addSlidesToPath() 
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
						echo FCPATH.'assets\storage\users\\'.$actor->getId();
						echo '#Error: We don\'t create folder';
						return;
					}
					if ($this->addSlidesToPath($actor->getId()) == false)
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
                        // UNIMPLEMENTED: nedostaje da se doda u popup slika i kreiranje fajla u odgovarajucem folederu
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
						echo 'Success!';
					}
					catch (Exception $ex) { echo '#Error: Could not create the subject.'; }
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
                    // UNIMPLEMENTED: nedostaje da se doda u popup slika i kreiranje fajla u odgovarajucem folederu
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
						echo 'Success!';
					}
					catch (Exception $ex) { echo '#Error: Could not create the subject.'; }
                                }
                                else echo '#Error: Data is not valid.';                      
                    }
                }
				
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
                                        
                                        $qb = $this->loader->getEntityManager()->createQueryBuilder();
                                        $qb->select('a')->from('Actor', 'a')->where('a.id = :id')->setParameter('id', $this->session->actor->getId());
                                        $query = $qb->getQuery();
                                        $actor = $query->getSingleResult();
                                        $tokens = $actor->getTokens();
                                        if ($amountTokens > $tokens)
                                        {
                                            echo '#Error: Not enough tokens!';
                                            return;
                                        }
                                        $tokens -= $amountTokens;
                                        $em = $this->loader->getEntityManager();
                                        $actor->setTokens($tokens);
                                        $em->flush();
                                        echo 'Success!';
                                }
                                else echo '#Error: Data is not valid.';
                    }
                }
                
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
                                        $qb = $this->loader->getEntityManager()->createQueryBuilder();
                                        $qb->select('a')->from('Actor', 'a')->where('a.id = :id')->setParameter('id', $this->session->actor->getId());
                                        $query = $qb->getQuery();
                                        $actor = $query->getSingleResult();
                                        $tokens = $actor->getTokens();
                                        $tokens += $amountEuro * ActorBalanceMetrix::TOKEN_RATE;
                                        $em = $this->loader->getEntityManager();
                                        $actor->setTokens($tokens);
                                        $em->flush();
                                        echo 'Success!';
                                }
                                else echo '#Error: Data is not valid.';
			}
		}
		
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
					// Create post here
					$postid = 1;
					
					$this->load->helper(array('form', 'url'));
					$this->load->library('upload', array
					(
						'upload_path'	=> FCPATH.'assets/storage/posts/'.$postid.'/',
						'allowed_types'	=> 'txt|doc|docx|pdf|jpg|png',
						'max_size'		=> 102400
					));
					
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
		
		//Server sakriva kategoriju, pripadajuće oblasti i odgovarajuće postove i odgovore
		public function deleteSubject(){
			if (isset($this->session->actor) && Privilege::has($this->session->actor->getRawRank(), 'DeleteSubject')){
				
				$subjectid = $this->input->post('subjectid');
				$em = $this->loader->getEntityManager();
				$subject = $em->find('Subject', $subjectid);
				
				if ($subject != null)
				{
					$subject->setDeleted(true);
					$sections = $em->createQuery('SELECT s FROM Section s WHERE s.subject = :subjectid')
							  ->setParameter('subjectid', $subject->getId())
							  ->getResult();
					foreach($sections as $section){
						$section->setDeleted(true);
						$postssections = $em->createQuery('SELECT ps FROM PostSection ps WHERE ps.section = :sectionid')
						->setParameter('sectionid', $section->getId())
						->getResult();
						foreach($postssections as $postsection){
							$post = $em->find('Post', $postsection->getPost());
							$post->setDeleted(true);
							$replies = $em->createQuery('SELECT r FROM Reply r WHERE r.post = :postid')
							->setParameter('postid', $post->getId())
							->getResult();
							foreach($replies as $reply){
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
		public function deleteSection(){
			if (isset($this->session->actor) && Privilege::has($this->session->actor->getRawRank(), 'DeleteSection')){
				
				$sectionid = $this->input->post('sectionid');
				$em = $this->loader->getEntityManager();
				$section = $em->find('Section', $sectionid);
				
				if ($section != null)
				{
					$section->setDeleted(true);
					$postssections = $em->createQuery('SELECT ps FROM PostSection ps WHERE ps.section = :sectionid')
					->setParameter('sectionid', $section->getId())
					->getResult();
					foreach($postssections as $postsection){
						$post = $em->find('Post', $postsection->getPost());
						$post->setDeleted(true);
						$replies = $em->createQuery('SELECT r FROM Reply r WHERE r.post = :postid')
						->setParameter('postid', $post->getId())
						->getResult();
						foreach($replies as $reply){
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
		public function deletePost(){
			if (isset($this->session->actor) && Privilege::has($this->session->actor->getRawRank(), 'DeletePost')){
				
				$postid = $this->input->post('postid');
				$em = $this->loader->getEntityManager();
				$post = $em->find('Post', $postid);
				
				if ($post != null)
				{
					$post->setDeleted(true);
					$replies = $em->createQuery('SELECT r FROM Reply r WHERE r.post = :postid')
					->setParameter('postid', $post->getId())
					->getResult();
					foreach($replies as $reply){
						$reply->setDeleted(true);
					}
					$em->flush();
					echo '<b>Success!</b> You have successfully deleted post!';
				}
				else echo '#Error: Data not valid.';
			}
			else echo '#Error: You don\'t have permission to delete section.';
		}
		public function deleteReply(){
			if (isset($this->session->actor) && Privilege::has($this->session->actor->getRawRank(), 'DeleteReply')){
				
				$replyid = $this->input->post('replyid');
				$em = $this->loader->getEntityManager();
				$reply = $em->find('Reply', $replyid);
				
				if ($reply != null)
				{
					$reply->setDeleted(true);
					$em->flush();
					echo '<b>Success!</b> You have successfully deleted reply!';
				}
				else echo '#Error: Data not valid.';
			}
			else echo '#Error: You don\'t have permission to delete reply.';
		}
		public function createReply(){
			if (isset($this->session->actor) && Privilege::has($this->session->actor->getRawRank(), 'Reply')){
				$replymsg = $this->input->post('replymsg');
				$postid = $this->input->post('postid');
				$replierid = $this->input->post('replierid');
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
				echo 'You have successfuly replied to post.';
			}
			else echo '#Error: You don\'t have permission to delete reply.';
		}
                
                public function banUser()
                {
                      if (isset($this->session->actor) && Privilege::has($this->session->actor->getRawRank(), 'BanUser'))
                      {
                          	$em = $this->loader->getEntityManager();
                                $user = $em->createQuery('SELECT a FROM Actor a WHERE a.id = :id')
                                ->setParameter('id', $this->input->post('id'))
                                ->getSingleResult();
                                $user->setBanned(1);
                                $em->flush();
                                echo 'Success!';
                      }
                      else echo '#Error: Error!';
                }
                
                public function unbanUser()
                {
                      if (isset($this->session->actor) && Privilege::has($this->session->actor->getRawRank(), 'BanUser'))
                      {
                          	$em = $this->loader->getEntityManager();
                                $user = $em->createQuery('SELECT a FROM Actor a WHERE a.id = :id')
                                ->setParameter('id', $this->input->post('id'))
                                ->getSingleResult();
                                $user->setBanned(0);
                                $em->flush();
                                echo 'Success!';
                      }
                      else echo '#Error: Error!';
                }
                
	}
?>