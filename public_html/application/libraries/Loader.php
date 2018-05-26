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
	 *	@return: void
	 */
	public function loadHead($title = 'Page', $scripts = null)
	{
		$this->controller->load->view('templates/head.php', array('title' => $title, 'scripts' => $scripts));
	}
	
	/*
	 * loadFixedHeader() - ucitava fiksni header
	 *	@return: void
	 *
	 *	@special: $this->controller mora da ima ucitane sesije
	 */
	public function loadFixedHeader()
	{
		$this->controller->load->view('templates/header-fixed.php');
		
	}
	
	/*
	 * loadHeader() - ucitava header
	 *	@return: void
	 *
	 *	@special: $this->controller mora da ima ucitane sesije
	 */
	public function loadHeader()
	{
		$this->controller->load->view('templates/header.php');
		
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
	 *	@param array $scripts: niz dodatnih skripti koje treba ucitati
	 *	@param int $active: indeks aktivnog linka u okviru navbara
	 *	@return: void
	 */
	public function loadSimplePage($content = '', $title = 'Page', $scripts = null, $active = -1)
	{
		$this->loadHead($title, $scripts);
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
	 *	@param array $scripts: niz dodatnih skripti koje treba ucitati
	 *	@param int $active: indeks aktivnog linka u okviru navbara
	 *	@return: void
	 */
	public function loadPage($page = '', $data = null, $title = 'Page', $scripts = null, $active = -1)
	{
		if (!file_exists(APPPATH.'views/'.$page))
		{
			$data = array('heading' => '404', 'message' => 'Page not found');
			$this->controller->load->view('errors/cli/error_404', $data);
			return;
		}
		
		$this->loadHead($title, $scripts);
		$this->loadFixedHeader();
		$this->loadHeader();
		$this->loadNavbar($active);
		$this->contentStart();
		$this->controller->load->view($page, $data);
		$this->contentEnd();
		$this->loadFooter();
		$this->loadFoot();
	}
	
	/* ============== DB SELECT ============== */
	
	/*
	 * getRank() - dohvata trazeni rank
	 *	@param EntityManager $em: veza sa bazom
	 *	@param Rank $rank: rank
	 *	@return: ActorRank
	 */
	public function getRank($rank)
	{
		return $this->em->find('ActorRank', $rank);
	}
	
	/*
	 * findActor() - dohvata aktora
	 *	@param string $username: korisnicko ime
	 *	@param string $password: lozinka
	 *	@return: Actor
	 */
	public function findActor($username, $password)
	{
		$users = $this->em->getRepository(Actor::class)->findBy(array
		(
			'username' => $username,
			'password' => MD5($password)
		));
		
		if ($users == NULL || count($users) > 1) return NULL;
		
		return $users[0];
	}
	
	/* ============== DB INSERT ============== */
	
	/*
	 * insertRanks() - insert-uje rankove predviđene u bazu (test funkcija)
	 *	@param EntityManager $em: veza sa bazom
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
	 *	@param EntityManager $em: veza sa bazom
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
	 * initializeDatabase() - inicijalizuje bazu podataka
	 *	@return void
	 */
	public function initializeDatabase()
	{
		$this->loader->insertRanks();
		$this->loader->insertAdmins();
	}
}

?>