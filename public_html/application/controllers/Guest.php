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
			$this->loader->loadPage('index.php', null, 'Home Page', 0);
		}
		
               
                /*
                 * subjects() - dohvata sve predmete i salje ih stranici subjects.php
                 * koju i otvara
                 */
		public function subjects()
		{
			$subjects = $this->loader->getEntityManager()->createQuery('SELECT s FROM Subject s WHERE s.deleted = 0')->getResult();
			$this->loader->loadPage('subjects.php', array('subjects' => $subjects), 'Subjects', 1);
		}
		
                public function users()
                {
                        $qb = $this->loader->getEntityManager()->createQueryBuilder();
			$qb->select('a')->from('Actor', 'a')->where('a.actorrank = 2');
			$query = $qb->getQuery();
			$users = $query->getResult();

			$usersvms = $this->load->view('templates/generate-users.php', array('users' => $users), true);
			$this->loader->loadPage('users.php', null, 'Users', 5, array('assets/js/users.js'), $usersvms);
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
			$this->loader->loadPage('tutors.php', null, 'Tutors', 2, array('assets/js/tutors.js'), $tutorsvms);
		}
		
		public function library()
		{
			$this->loader->loadPage('library.php', null, 'Library', 3, array('assets/ajax/search.ajax.js'));
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
			$subject = null;
			try
			{
			$subject = $query->getSingleResult();
			}
			catch(Exception $e)
			{ 
				$data = array('heading' => '', 'message' => 'The subject you are looking doesn\'t exist.');
				$this->loader->loadPage($page = 'errors/cli/error_general.php', $data, $title = 'Page', $active = -1, $scripts = null, $scriptAddon = null); 
				return;
			}
			if($subject->getDeleted()){
				$data = array('heading' => '', 'message' => 'The subject you are looking for has been deleted.');
				$this->loader->loadPage($page = 'errors/cli/error_general.php', $data, $title = 'Page', $active = -1, $scripts = null, $scriptAddon = null);
				return;
			}
			$qb = $this->loader->getEntityManager()->createQueryBuilder();
			$qb->select('s')->from('Section', 's')->where('s.subject = :id')->andWhere('s.deleted = 0')->setParameter('id', $id);
			$query = $qb->getQuery();
			$sections = $query->getResult();
			$enableDeleteButton = false;
			if (isset($this->session->actor) && Privilege::has($this->session->actor->getRawRank(), 'DeleteSubject')) $enableDeleteButton = true;
			$this->loader->loadPage('subject.php', array('subject' => $subject, 'sections' => $sections, 'enableDeleteButton' => $enableDeleteButton), 'Sections');
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
			if($section==null) {
				$data = array('heading' => '', 'message' => 'The section you are looking for doesn\'t exist.');
				$this->loader->loadPage($page = 'errors/cli/error_general.php', $data, $title = 'Page', $active = -1, $scripts = null, $scriptAddon = null);
				return;
			}
			if($section->getDeleted()){
				$data = array('heading' => '', 'message' => 'The section you are looking for has been deleted.');
				$this->loader->loadPage($page = 'errors/cli/error_general.php', $data, $title = 'Page', $active = -1, $scripts = null, $scriptAddon = null);
				return;
			}

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
			$enableDeleteButton = false;
			if (isset($this->session->actor) && Privilege::has($this->session->actor->getRawRank(), 'DeleteSection')) $enableDeleteButton = true;
			$this->loader->loadPage('section.php', array('section' => $section, 'enableDeleteButton' => $enableDeleteButton), 'Sections', -1, array('assets/js/tutors.js'), $tutorsvms);
		}
		
		public function post($postid)
		{
			$em = $this->loader->getEntityManager();
			$post = $em->find('Post', $postid);
			if($post==null) {
				$data = array('heading' => '', 'message' => 'The post you are looking for doesn\'t exist.');
				$this->loader->loadPage($page = 'errors/cli/error_general.php', $data, $title = 'Page', $active = -1, $scripts = null, $scriptAddon = null);
				return;
			}
			if($post->getDeleted()){
				$data = array('heading' => '', 'message' => 'The post you are looking for has been deleted.');
				$this->loader->loadPage($page = 'errors/cli/error_general.php', $data, $title = 'Page', $active = -1, $scripts = null, $scriptAddon = null);
				return;
			}
			$replies = $em->createQuery('SELECT r FROM Reply r WHERE r.deleted = false AND r.post = :id')
							->setParameter('id', $post->getId())
							->getResult();
			$postsections = $em->createQuery('SELECT ps FROM PostSection ps WHERE ps.post = :postid')
			->setParameter('postid', $post->getId())
			->getResult();
			$sections = array();
			foreach($postsections as $postsection)
			{
				$currentsection = $em->createQuery('SELECT s FROM Section s WHERE s.id = :sectionid')
							->setParameter('sectionid', $postsection->getSection())
							->getSingleResult();
				$sections[] = $currentsection;
			}
			$replyposter = array();
			$replyaccepted = array();
			foreach($replies as $reply)
			{
				$actor = $em->find('Actor', $reply->getActor());
				$replyposter[$reply->getId()] = $actor;
				if(Qapost::checkIfPostIsQA($post))
				{
					$replyaccepted[$reply->getId()] = Qapost::isReplyAccepted($post, $reply);
				}
			}
			$enableDeleteButton = false;
			if (isset($this->session->actor) && Privilege::has($this->session->actor->getRawRank(), 'DeleteReply')) $enableDeleteButton = true;
			$repliesvms = $this->load->view('templates/generate-replies.php', array('op' => $post->getOriginalPosterReference(), 'replies' => $replies, 'replyposter' => $replyposter, 'replyaccepted' => $replyaccepted, 'sections' => $sections, 'enableDeleteButton' => $enableDeleteButton), true);
			$enableDeleteButton = false;
			if (isset($this->session->actor) && Privilege::has($this->session->actor->getRawRank(), 'DeletePost')) $enableDeleteButton = true;	
			$this->loader->loadPage('post.php', array('post' => $post,'actor' => $this->session->actor, 'enableDeleteButton' => $enableDeleteButton), 'Post', -1, array('assets/js/posts.js', 'assets/js/reviews.js'), $repliesvms);
		}
                
		public function profile($id)
		{
			$em = $this->loader->getEntityManager();
			$actor = $em->find('Actor', $id);
			if($actor==null) {
				$data = array('heading' => '', 'message' => 'The actor you are looking for doesn\'t exist.');
				$this->loader->loadPage($page = 'errors/cli/error_general.php', $data, $title = 'Page', $active = -1, $scripts = null, $scriptAddon = null);
				return;
			}
			$result = $em->createQuery('SELECT s FROM SectionSubscription s WHERE s.actor = :id')
						->setParameter('id', $id)
						->getResult();
			$sections = array();
			foreach ($result as $res)
			{
				$sections[] = $em->createQuery('SELECT s FROM Section s WHERE s.id = :id')
							  ->setParameter('id', $res->getSection())
							  ->getSingleResult();
			}

			$reviews = $em->createQuery('SELECT a FROM ActorReview a WHERE a.reviewee = :id')
							  ->setParameter('id', $id)
							  ->getResult();
			$avg = 0;
			$count = 0;
			foreach($reviews as $review)
			{
				$avg += $review->getGrade();
				$count++;
			}
			
			if ($count === 0) $avg = 0;
			else $avg /= $count;
			$qb = $this->loader->getEntityManager()->createQueryBuilder();
			$qb->select('count(w.id)')->from('Workpost', 'w')->where('w.worker = :tutorid')->setParameter('tutorid', $actor->getId());
			$query = $qb->getQuery();
			$workpostsCount = $query->getSingleScalarResult();
			$degree = $workpostsCount;
			$this->loader->loadPage('profile.php', array('actor' => $actor, 'sections' => $sections, 'avg' => $avg, 'reviews' => $reviews, 'degree' => $degree), 'Profile', -1, array('assets/js/profile.js'));
		}
		public function promotions()
		{
			$em = $this->loader->getEntityManager();
			$promotionrequests = $em->createQuery('SELECT pr FROM PromotionRequest pr')
						->getResult();
			$actors = array();
			foreach($promotionrequests as $promotionrequest){
				$actors[$promotionrequest->getActor()] = $em->find('Actor', $promotionrequest->getActor());
			}
			$this->loader->loadPage('promotions.php', array('promotionrequests' => $promotionrequests, 'actors' => $actors), 'PromotionRequests', -1, null);
		}
		public function request($reqid)
		{
			$em = $this->loader->getEntityManager();
			$promotionrequest = $em->find('PromotionRequest', $reqid);
			if($promotionrequest!=null){
				$actor = $em->find('Actor', $promotionrequest->getActor());
				$this->loader->loadPage('request.php', array('promotionrequest' => $promotionrequest, 'actor' => $actor), 'PromotionRequest', -1, null);
			}
		}
		public function posts()
		{
			$em = $this->loader->getEntityManager();
			$posts = $em->createQuery('SELECT p FROM Post p WHERE p.deleted = 0 ORDER BY p.postedon DESC')
						->getResult();
			foreach($posts as $post){
				$actors[$post->getId()] = $em->find('Actor', $post->getOriginalposter());
			}
			$postsvms = $this->load->view('templates/generate-posts.php', array('posts' => $posts, 'actors' => $actors), true);
			$this->loader->loadPage('posts.php', null, 'Posts', -1, array('assets/js/partialpost.js'), $postsvms);
		} 
	}
?>