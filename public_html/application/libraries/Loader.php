<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Loader - usluzna klasa za laksi rad (poput utility klase)
 *
 * @version 1.0
 */
class Loader
{
	/* ============== VIEWS ============== */
	
	/*
	 * loadHead() - ucitava head
	 *	@param CI_Controller $component: komponenta u koju da se ucita
	 *	@param string $title: titl stranice
	 *	@param array $scripts: niz dodatnih skripti koje treba ucitati
	 *	@return: void
	 */
	public function loadHead($component, $title = 'Page', $scripts = null)
	{
		$component->load->view('templates/head.php', array('title' => $title, 'scripts' => $scripts));
	}
	
	/*
	 * loadFixedHeader() - ucitava fiksni header
	 *	@param CI_Controller $component: komponenta u koju da se ucita
	 *	@return: void
	 *
	 *	@special: $component mora da ima ucitane sesije
	 */
	public function loadFixedHeader($component)
	{
		$component->load->view('templates/header-fixed.php');
		
	}
	
	/*
	 * loadHeader() - ucitava header
	 *	@param CI_Controller $component: komponenta u koju da se ucita
	 *	@return: void
	 *
	 *	@special: $component mora da ima ucitane sesije
	 */
	public function loadHeader($component)
	{
		$component->load->view('templates/header.php');
		
	}
	
	/*
	 * loadNavbar() - ucitava navbar
	 *	@param CI_Controller $component: komponenta u koju da se ucita
	 *	@param int $active: indeks aktivnog linka u okviru navbara
	 *	@return: void
	 */
	public function loadNavbar($component, $active = -1)
	{
		$component->load->view('templates/navbar.php', array('active' => $active));
	}
	
	/*
	 * contentStart() - zapocinje sadrzaj stranice
	 *	@param CI_Controller $component: komponenta u koju da se ucita
	 *	@return: void
	 */
	public function contentStart($component)
	{
		$component->load->view('templates/content-start.php');
	}
	
	/*
	 * contentEnd() - zavrsava sadrzaj stranice
	 *	@param CI_Controller $component: komponenta u koju da se ucita
	 *	@return: void
	 */
	public function contentEnd($component)
	{
		$component->load->view('templates/content-end.php');
	}
	
	/*
	 * loadFooter() - ucitava footer
	 *	@param CI_Controller $component: komponenta u koju da se ucita
	 *	@return: void
	 */
	public function loadFooter($component)
	{
		$component->load->view('templates/footer.php');
	}
	
	/*
	 * loadFoot() - ucitava foot
	 *	@param CI_Controller $component: komponenta u koju da se ucita
	 *	@return: void
	 */
	public function loadFoot($component)
	{
		$component->load->view('templates/foot.php');
	}
	
	/*
	 * loadSimplePage() - ucitava jednostavnu stranicu
	 *	@param CI_Controller $component: komponenta u koju da se ucita
	 *	@param string $content: sadrzaj stranice
	 *	@param string $title: titl stranice
	 *	@param array $scripts: niz dodatnih skripti koje treba ucitati
	 *	@return: void
	 */
	public function loadSimplePage($component, $content = '', $title = 'Page', $scripts = null)
	{
		$this->loadHead($component, $title, $scripts);
		$this->loadFixedHeader($component);
		$this->loadHeader($component);
		$this->loadNavbar($component);
		$this->contentStart($component);
		echo $content;
		$this->contentEnd($component);
		$this->loadFooter($component);
		$this->loadFoot($component);
	}
	
	/* ============== MODELS ============== */
	
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
	
	/*
	 * loadEntities() - ucitava sve entitete (modele)
	 *	@return: void
	 */
	public function loadEntities()
	{
		require_once 'application/models/Action.php';
		require_once 'application/models/Actor.php';
		require_once 'application/models/ActorRank.php';
		require_once 'application/models/ActorReview.php';
		require_once 'application/models/Notification.php';
		require_once 'application/models/Post.php';
		require_once 'application/models/PromotionRequest.php';
		require_once 'application/models/QAPost.php';
		require_once 'application/models/Reply.php';
		require_once 'application/models/Section.php';
		require_once 'application/models/Subject.php';
		require_once 'application/models/WorkPost.php';
	}
	
	/* ============== DB SELECT ============== */
	
	/*
	 * getRank() - dohvata trazeni rank
	 *	@param EntityManager $em: veza sa bazom
	 *	@param Rank $rank: rank
	 *	@return: ActorRank
	 */
	public function getRank($em, $rank)
	{
		$this->loadEntities();
		return $em->find('ActorRank', $rank);
	}
	
	/* ============== DB INSERT ============== */
	
	/*
	 * insertRanks() - insert-uje rankove predviđene u bazu (test funkcija)
	 *	@param EntityManager $em: veza sa bazom
	 *	@return: void
	 */
	public function insertRanks($em)
	{
		$this->loadEntities();
		$rank1 = ActorRank::New('Guest', 1);
		$rank2 = ActorRank::New('User', 2);
		$rank3 = ActorRank::New('Tutor', 3);
		$rank4 = ActorRank::New('Moderator', 4);
		$rank5 = ActorRank::New('Administrator', 5);
		$em->persist($rank1);
		$em->persist($rank2);
		$em->persist($rank3);
		$em->persist($rank4);
		$em->persist($rank5);
		$em->flush();
	}
	
	/*
	 * insertAdmins() - insert-uje predvidjene administratore
	 *	@param EntityManager $em: veza sa bazom
	 *	@return: void
	 */
	public function insertAdmins($em)
	{
		$this->loadEntities();
		$adminRank = $this->getRank($em, Rank::Administrator);
		$admin1 = Actor::New('Vladimir', 'Sivčev', 'vladimirsi@nordeus.com', 'sivi', 'sivi', new \DateTime('now'), $adminRank);
		$admin2 = Actor::New('Predrag', 'Mitrović', 'pedja1996@gmail.com', 'djape', 'djape', new \DateTime('now'), $adminRank);
		$admin3 = Actor::New('Miodrag', 'Milošević', 'miodragmilosevic@gmail.com', 'shrd', 'buddy', new \DateTime('now'), $adminRank);
		$em->persist($admin1);
		$em->persist($admin2);
		$em->persist($admin3);
		$em->flush();
	}
}

?>