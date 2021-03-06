<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	require_once 'application/models/Entities.php';

	/*
	 * Loader - usluzna klasa za laksi rad (poput utility klase)
	 *
	 * @version 1.0
	 */
	class Loader
	{
		/* ============== INSTANTIATION ============== */
		
		/*
		 * Global instance
		 */
		private static $I = null;
		
		/*
		 * Gets the global loader instance
		 */
		public static function instance() { return self::$I; }
		
		/*
		 * Constructor
		 */
		public function __construct() { if (self::$I === null) self::$I = $this; }
		
		/* ============== IOC ============== */
		
		/*
		 * CI_Controller $controller: pozivajuci kontroler
		 */
		private $controller = null;
		
		/*
		 * setController() - podesava pozivajuci kontroler
		 *	@param CI_Controller $controller: pozivajuci kontroler
		 *	@return: void
		 */
		public function setController($controller) { if ($this->controller === null) $this->controller = $controller; }
		
		/*
		 * getController() - dohvata pozivajuci kontroler
		 *	@return: CI_Controller $controller
		 */
		public function getController() { return $this->controller; }
		
		/*
		 * EntityManager $em: Globalni entity manager
		 */
		private $em = null;
		
		/*
		 * setEntityManager() - podesava globalni entity manager
		 *	@param EntityManager $em: entity manager
		 *	@return: void
		 */
		public function setEntityManager($em) { if ($this->em === null) $this->em = $em; }
		
		/*
		 * getEntityManager() - dohvata podesen globalni entity manager
		 *	@return: EntityManager $em
		 */
		public function getEntityManager() { return $this->em; }
		
		/* ============== VIEWS ============== */
		
		/*
		 * loadHead() - ucitava head
		 *	@param string $title: titl stranice
		 *	@param array $scripts: niz dodatnih skripti koje treba ucitati
		 *	@param string $scriptAddon: dodatni javascript u okviru stranice
		 *	@return: void
		 */
		public function loadHead($title = 'Page', $scripts = null, $scriptAddon = null)
		{
			if ($scripts === null) $scripts = array();
			if (isset($this->controller->session->actor))
			{
				$scripts[] = 'assets/js/tokens.js';
				$scripts[] = 'assets/js/notifications.js';
				
				if ($this->controller->session->actor->getRawRank() >= Rank::Moderator)
				{
					$scripts[] = 'assets/js/administration.js';
				}
				$notifications = $this->em->createQuery('SELECT n FROM Notification n WHERE n.actor = :actorid')
					->setParameter('actorid', $this->controller->session->actor->getId())
					->getResult();
				// load some notifications
				$notificationsstring = 'notifications = [';
				if($notifications != null)
				{
					$count = 0;
					foreach ($notifications as $notification)
					{
						$notificationsstring = $notificationsstring.'new Notification('.$notification->getId().', "'.$notification->getTitle().'", "'.$notification->getContent().'", '.($notification->getSeen()=='1'? 'true' : 'false').')';
						$count++; 
						if($count !== count($notifications)) $notificationsstring .= ', ';
					}
				}
				$notificationsstring = $notificationsstring.']';
				if ($scriptAddon === null) $scriptAddon = $notificationsstring;
				else $scriptAddon .= $notificationsstring;
			}
			$this->controller->load->view('templates/head.php', array('title' => $title, 'scripts' => $scripts, 'scriptAddon' => $scriptAddon));
		}
		
		/*
		 * loadFixedHeader() - ucitava fiksni header
		 *	@return: void
		 *
		 *	@special: $this->controller mora da ima ucitane sesije
		 */
		public function loadFixedHeader()
		{
			$this->controller->load->view('templates/header-fixed.php', array('actor' => $this->controller->session->actor));
		}
		
		/*
		 * loadHeader() - ucitava header
		 *	@return: void
		 *
		 *	@special: $this->controller mora da ima ucitane sesije
		 */
		public function loadHeader()
		{
			$this->controller->load->view('templates/header.php', array('actor' => $this->controller->session->actor));
			
		}
		
		/*
		 * loadNavbar() - ucitava navbar
		 *	@param int $active: indeks aktivnog linka u okviru navbara
		 *	@return: void
		 */
		public function loadNavbar($active = -1)
		{
			$this->controller->load->view('templates/navbar.php', array('active' => $active));
		}
		
		/*
		 * contentStart() - zapocinje sadrzaj stranice
		 *	@return: void
		 */
		public function contentStart()
		{
			$this->controller->load->view('templates/content-start.php');
		}
		
		/*
		 * contentEnd() - zavrsava sadrzaj stranice
		 *	@return: void
		 */
		public function contentEnd()
		{
			$this->controller->load->view('templates/content-end.php');
		}
		
		/*
		 * loadFooter() - ucitava footer
		 *	@return: void
		 */
		public function loadFooter()
		{
			$this->controller->load->view('templates/footer.php');
		}
		
		/*
		 * loadFoot() - ucitava foot
		 *	@return: void
		 */
		public function loadFoot()
		{
			$this->controller->load->view('templates/foot.php');
		}
		
		/*
		 * loadSimplePage() - ucitava jednostavnu stranicu
		 *	@param string $content: sadrzaj stranice
		 *	@param string $title: titl stranice
		 *	@param int $active: indeks aktivnog linka u okviru navbara
		 *	@param array $scripts: niz dodatnih skripti koje treba ucitati
		 *	@param string $scriptAddon: dodatni javascript u okviru stranice
		 *	@return: void
		 */
		public function loadSimplePage($content = '', $title = 'Page', $active = -1, $scripts = null, $scriptAddon = null)
		{
			$this->loadHead($title, $scripts, $scriptAddon);
			$this->loadFixedHeader();
			$this->loadHeader();
			$this->loadNavbar($active);
			$this->contentStart();
			echo $content;
			$this->contentEnd();
			$this->loadFooter();
			$this->loadFoot();
		}
		
		/*
		 * loadSimplePage() - ucitava jednostavnu stranicu
		 *	@param string $page: stranica koju treba ucitati
		 *	@param string $data: potrebni podaci za datu stranicu (wrapp-ovani)
		 *	@param string $title: titl stranice
		 *	@param int $active: indeks aktivnog linka u okviru navbara
		 *	@param array $scripts: niz dodatnih skripti koje treba ucitati
		 *	@param string $scriptAddon: dodatni javascript u okviru stranice
		 *	@return: void
		 */
		public function loadPage($page = '', $data = null, $title = 'Page', $active = -1, $scripts = null, $scriptAddon = null)
		{
			if (!file_exists(APPPATH.'views/'.$page))
			{
				$data = array('heading' => '404', 'message' => 'Page not found');
				$this->controller->load->view('errors/cli/error_404', $data);
				return;
			}
			
			$this->loadHead($title, $scripts, $scriptAddon);
			$this->loadFixedHeader();
			$this->loadHeader();
			$this->loadNavbar($active);
			$this->contentStart();
			$this->controller->load->view($page, $data);
			$this->contentEnd();
			$this->loadFooter();
			$this->loadFoot();
		}
		
		/* ============== ENTITIES ============== */
		
		/*
		 * generateEntities() - generise ORM entitete
		 *	@return: void
		 */
		public function generateEntities()
		{
			include 'vendor/autoload.php';
			$classLoader = new \Doctrine\Common\ClassLoader('Entities', __DIR__);
			$classLoader->register();
			$classLoader = new \Doctrine\Common\ClassLoader('Proxies', __DIR__);
			$classLoader->register();
			// config
			$config = new \Doctrine\Configuration();
			$config->setMetadataDriverImpl($config->newDefaultAnnotationDriver(__DIR__ . '/Entities'));
			$config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache);
			$config->setProxyDir(__DIR__ . '/Proxies');
			$config->setProxyNamespace('Proxies');
			$connectionParams = array
			(
				'driver' => 'pdo_mysql',
				'host' => 'localhost',
				'port' => '3306',
				'user' => 'root',
				'password' => '',
				'dbname' => 'psi.tutor-center',
				'charset' => 'utf8',
			);
			$em = \Doctrine\EntityManager::create($connectionParams, $config);
			// custom datatypes (not mapped for reverse engineering)
			$em->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('set', 'string');
			$em->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
			// fetch metadata
			$driver = new \Doctrine\Mapping\Driver\DatabaseDriver(
				$em->getConnection()->getSchemaManager()
			);
			$em->getConfiguration()->setMetadataDriverImpl($driver);
			$cmf = new \Doctrine\Tools\DisconnectedClassMetadataFactory($em);
			$cmf->setEntityManager($em);
			$classes = $driver->getAllClassNames();
			$metadata = $cmf->getAllMetadata();
			$generator = new Doctrine\Tools\EntityGenerator();
			$generator->setUpdateEntityIfExists(true);
			$generator->setGenerateStubMethods(true);
			$generator->setGenerateAnnotations(true);
			$generator->generate($metadata, __DIR__ . '/Entities');
		}
		
		/* ============== DB INITIALIZATION ============== */
		
		/*
		 * insertRanks() - insert-uje rankove predviđene u bazu (test funkcija)
		 *	@return: void
		 */
		public function insertRanks()
		{
			$rank1 = ActorRank::New('Guest', Rank::Guest);
			$rank2 = ActorRank::New('User', Rank::User);
			$rank3 = ActorRank::New('Tutor', Rank::Tutor);
			$rank4 = ActorRank::New('Moderator', Rank::Moderator);
			$rank5 = ActorRank::New('Administrator', Rank::Administrator);
			$this->em->persist($rank1);
			$this->em->persist($rank2);
			$this->em->persist($rank3);
			$this->em->persist($rank4);
			$this->em->persist($rank5);
			$this->em->flush();
		}
		
		/*
		 * insertAdmins() - insert-uje predvidjene administratore
		 *	@return: void
		 */
		public function insertAdmins()
		{
			$admin1 = Actor::New('Vladimir', 'Sivčev', 'vladimirsi@nordeus.com', 'sivi', 'sivi', new \DateTime('now'), Rank::Administrator);
			$admin2 = Actor::New('Predrag', 'Mitrović', 'pedja1996@gmail.com', 'djape', 'djape', new \DateTime('now'), Rank::Administrator);
			$admin3 = Actor::New('Miodrag', 'Milošević', 'miodragmilosevic@gmail.com', 'shrd', 'buddy', new \DateTime('now'), Rank::Administrator);
			$this->em->persist($admin1);
			$this->em->persist($admin2);
			$this->em->persist($admin3);
			$this->em->flush();
		}
		
		/*
		 * insertActions() - insert-uje dinamicke akcije, kao i privilegije za njih
		 *	@return void
		 */
		public function insertActions()
		{
			$ranks = array
			(
				ActorRank::get(Rank::Guest),
				ActorRank::get(Rank::User),
				ActorRank::get(Rank::Tutor),
				ActorRank::get(Rank::Moderator),
				ActorRank::get(Rank::Administrator)
			);
			
			$actions = array();
			
			foreach (Privileges::Enumerate() as $action => $rank) $this->em->persist($actions[] = Action::New($action, $ranks[$rank - 1]));
			$this->em->flush();
			
			foreach ($actions as $action) $this->em->persist($action->getPrivilege());
			$this->em->flush();
		}
		
		/*
		 * insertSubjects() - insert-uje kategorije
		 *	@param array $subjects: niz kategorija
		 *	@return void
		 */
		public function insertSubjects($subjects)
		{
			foreach ($subjects as $name => $description)
			{
				$subject = Subject::New($name, $description);
				$this->em->persist($subject);
			}
			
			$this->em->flush();
		}
		
		/*
		 * insertSection() - insert-uje oblasti
		 *	@param Subject $subject: kategorija
		 *	@param array $sections: niz oblasti
		 *	@return void
		 */
		public function insertSections($subject, $sections)
		{
			foreach ($sections as $name => $description)
			{
				$section = Section::New($name, $description, $subject->getId());
				$this->em->persist($section);
			}
			
			$this->em->flush();
		}
		
		/*
		 * subscribeTutors() - subscribe-uje tutore
		 *	@param Section $section: oblast
		 *	@param array $tutors: niz tutora
		 *	@return void
		 */
		public function subscribeTutors($section, $tutors)
		{
			foreach ($tutors as $tutor)
			{
				$subscription = SectionSubscription::New($tutor->getId(), $section->getId());
				$this->em->persist($subscription);
			}
			
			$this->em->flush();
		}
		
		/*
		 * insertPosts() - insert-uje postove
		 *	@param Subject $subject: kategorija
		 *	@param array $sections: niz oblasti
		 *	@return void
		 */
		public function insertPosts($posts)
		{
			$insertedposts = array();
			
			foreach ($posts as $post)
			{
				$currentpost = Post::New($post['title'], $post['postedon'], $post['originalposter'], '1', '0');
				$this->em->persist($currentpost);
				$this->em->flush();
				
				if($post['type']==='qapost')
				{
					$qapost = Qapost::New($post['description'], $currentpost->getId(), $post['acceptedanswer']);
					$this->em->persist($qapost);
					$this->em->flush();
					$insertedposts[] = array($currentpost, $qapost);
				}
				else if($post['type']==='workpost')
				{
					$workpost = Workpost::New($post['description'], $post['comittedtokens'], $post['workeraccepted'], $currentpost->getId(), $post['worker']);
					$this->em->persist($workpost);
					$this->em->flush();
					$insertedposts[] = array($currentpost, $workpost);
				}
				
				foreach($post['postsections'] as $section)
				{
					$postsection = PostSection::New($currentpost->getId(), $section->getId());
					$this->em->persist($postsection);
					$this->em->flush();
				}
			}
			
			return $insertedposts;
		}
		
		/*
		 * inserReplies() - insert-uje odgovore
		 *	@param array $replies: niz odgovora
		 *	@return void
		 */
		public function insertReplies($replies)
		{
			foreach ($replies as $reply)
			{
				$currentreply = Reply::New($reply['message'], $reply['postedon'], $reply['deleted'], $reply['post'], $reply['actor']);
				$this->em->persist($currentreply);
				$this->em->flush();
			}
		}
		
		/*
		 * insertRequests() - insert-uje zahteve za promociju
		 *	@param array $requests: niz zahteva
		 *	@return void
		 */
		public function insertPromotionRequests($requests)
		{
			$insertedrequests = array();
			foreach ($requests as $request)
			{
				$currentrequest = PromotionRequest::New($request['title'], $request['description'], $request['submittedon'], $request['accepted'], $request['actor']);
				$this->em->persist($currentrequest);
				$this->em->flush();
				$insertedrequests[] = $currentrequest;
			}
			return $insertedrequests;
		}
		
		/*
		 * insertNotification() - insert-uje notifikaciju
		 *	@param string $title: naslov notifikacije
		 *  @param string $content: sadrzaj notifikacije
		 *	@param integer $actorid: id actora kom je upucena notifikacija
		 *	@return void
		 */
		public function insertNotification($title, $content, $actorid)
		{
			$notification = Notification::New($title, $content, $actorid);
			$this->em->persist($notification);
			$this->em->flush();
		}
		
		/*
		 * initializeDatabase() - inicijalizuje bazu podataka
		 *	@return void
		 */
		public function initializeDatabase()
		{
			$this->insertRanks();
			$this->insertAdmins();
			$this->insertActions();
		}
	}
?>