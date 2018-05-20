<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Utility extends CI_Controller
	{
		public function index()
		{
			echo "Home";
		}
		
		public function insertRanks()
		{
			$this->load->library('doctrine');
			require_once 'application/models/Action.php';
			require_once 'application/models/ActorRank.php';
			$em = $this->doctrine->em;
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
		
		public function generate()
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
			$connectionParams = array(
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
			print 'Done!';
		}
	}
?>