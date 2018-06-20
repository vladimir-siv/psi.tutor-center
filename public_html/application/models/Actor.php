<?php

/**
 * Actor
 *
 * @Table(name="actor", uniqueConstraints={@UniqueConstraint(name="Email", columns={"Email"}), @UniqueConstraint(name="Username", columns={"Username"})}, indexes={@Index(name="ActorRank", columns={"ActorRank"})})
 * @Entity
 */

class Actor extends Proxy
{
	/* ================= STATIC ================= */
	
	/*
	 * get() - dohvata trazenog aktora
	 *	@param int $id: id
	 *	@return: Actor
	 */
	public static function get($id)
	{
		return parent::$_em->find('Actor', $id);
	}
	
	/*
	 * getAllUsers() - dohvata sve Actor-e sa actorrank = 2
	 *	@return: Collection
	 */
	public static function getAllUsers()
	{
		return parent::$_em->createQuery('SELECT a FROM Actor a WHERE a.actorrank = 2')->getResult();
	}
	
	/*
	 * getAllTutors() - dohvata sve Actor-e sa actorrank > 2
	 *	@return: Collection
	 */
	public static function getAllTutors()
	{
		return parent::$_em->createQuery('SELECT a FROM Actor a WHERE a.actorrank > 2')->getResult();
	}
	
	/*
	 * workpostsCount() - dohvata broj Workpost-ova odradjenih od strane Actor-a sa actorid
	 *	@param int $actorid: id aktora
	 *	@return: int
	 */
	public static function workpostsCount($actorid)
	{
		return parent::$_em->createQuery('SELECT count(w.id) FROM Workpost w WHERE w.worker = :actorid AND w.workeraccepted = true')
							->setParameter('actorid', $actorid)
							->getSingleScalarResult();
	}
	
	/*
	 * getAllSubscriptions() - dohvata sve Subscription-e od Actor-a sa zadatim id
	 *	@param int $actorid: id aktora
	 *	@return: Collection
	 */
	public static function getAllSubscriptions($actorid)
	{
		return parent::$_em->createQuery('SELECT s FROM SectionSubscription s WHERE s.actor = :id')
							->setParameter('id', $actorid)
							->getResult();
	}
	
	/*
	 * getAllReviews() - dohvata Review-ove od Actor-a sa zadatim id
	 *	@param int $actorid: id aktora
	 *	@return: Actor
	 */
	public static function getAllReviews($actorid)
	{
		return parent::$_em->createQuery('SELECT a FROM ActorReview a WHERE a.reviewee = :id')
							->setParameter('id', $actorid)
							->getResult();
	}
	
	/*
	 * findActorByUsernameAndPassword() - dohvata aktora po korisnickom imenu i lozinci
	 *	@param string $username: korisnicko ime
	 *	@param string $password: lozinka
	 *	@return: Actor
	 */
	public static function findByUsernameAndPassword($username, $password)
	{
		$actors = parent::$_em->getRepository(Actor::class)->findBy(array
		(
			'username' => $username,
			'password' => MD5($password),
                        'banned' => 0
		));
		
		if ($actors == NULL || count($actors) > 1) return NULL;
		return $actors[0];
	}
	
	/*
	 * findActorByUsername() - pronalazi aktora po korisnickom imenu
	 *	@param string $username: korisnicko ime
	 *	@return: Actor
	 */
	public static function findByUsername($username)
	{
		$actors = parent::$_em->getRepository(Actor::class)->findBy(array
		(
			'username' => $username
		));
		
		if ($actors == NULL || count($actors) > 1) return NULL;
		return $actors[0];
	}
	
	/*
	 * findActorByEmail() - pronalazi aktora po e-mail-u
	 *	@param string $email: e-mail
	 *	@return: Actor
	 */
	public static function findByEmail($email)
	{
		$actors = parent::$_em->getRepository(Actor::class)->findBy(array
		(
			'email' => $email
		));
		
		if ($actors == NULL || count($actors) > 1) return NULL;
		return $actors[0];
	}
	
	/* ================ INSTANCE ================ */
	
    /**
     * @var integer
     *
     * @Column(name="ID", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;
	
    /**
     * @var string
     *
     * @Column(name="FirstName", type="string", length=64, nullable=false)
     */
    private $firstname;
	
    /**
     * @var string
     *
     * @Column(name="LastName", type="string", length=64, nullable=false)
     */
    private $lastname;
	
    /**
     * @var string
     *
     * @Column(name="Email", type="string", length=64, nullable=false)
     */
    private $email;
	
    /**
     * @var string
     *
     * @Column(name="Username", type="string", length=64, nullable=false)
     */
    private $username;
	
    /**
     * @var string
     *
     * @Column(name="Password", type="string", length=64, nullable=false)
     */
    private $password;
	
    /**
     * @var \DateTime
     *
     * @Column(name="BirthDate", type="date", nullable=false)
     */
    private $birthdate;
	
    /**
     * @var string
     *
     * @Column(name="Description", type="string", length=256, nullable=true)
     */
    private $description = null;
	
    /**
     * @var string
     *
     * @Column(name="Tokens", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $tokens = '0';
	
    /**
     * @var boolean
     *
     * @Column(name="Banned", type="boolean", nullable=false)
     */
    private $banned = '0';
	
    /**
     * @var integer
     *
     * @Column(name="ActorRank", type="integer", nullable=false)
     */
    private $actorrank;
	
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->section = new \Doctrine\Common\Collections\ArrayCollection();
    }
	
	/*
	 * New() - kreira novog korisnika
	 *	@param string $firstname: ime korisnika
	 *	@param string $lastname: prezime korisnika
	 *	@param string $email: e-posta korisnika
	 *	@param string $username: korisnicko ime korisnika
	 *	@param string $password: lozinka korisnika
	 *	@param DateTime $birthdate: datum rodjenja korisnika
	 *	@param ActorRank $actorrank: rank
	 *	@param int $tokens: inicijalno stanje korisnika
	 *	@param bool $banned: inicijalno banovano stanje
	 *	@return: Actor
	 */
	public static function New($firstname, $lastname, $email, $username, $password, $birthdate, $actorrank, $description = null, $tokens = 0, $banned = false)
	{
		$instance = new Actor();
		$instance->firstname = $firstname;
		$instance->lastname = $lastname;
		$instance->email = $email;
		$instance->username = $username;
		$instance->password = MD5($password);
		$instance->birthdate = $birthdate;
		$instance->description = $description;
		$instance->tokens = $tokens;
		$instance->banned = $banned;
		$instance->actorrank = $actorrank;
		return $instance;
	}
    
    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
	
    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Actor
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }
	
    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }
	
    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return Actor
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }
	
    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }
	
    /**
     * Set email
     *
     * @param string $email
     *
     * @return Actor
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }
	
    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
	
    /**
     * Set username
     *
     * @param string $username
     *
     * @return Actor
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }
	
    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
	
    /**
     * Set password
     *
     * @param string $password
     *
     * @return Actor
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }
	
    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
	
    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
     *
     * @return Actor
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }
	
    /**
     * Get birthdate
     *
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }
	
    /**
     * Set description
     *
     * @param string $description
     *
     * @return Actor
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }
	
    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
	
    /**
     * Set tokens
     *
     * @param string $tokens
     *
     * @return Actor
     */
    public function setTokens($tokens)
    {
        $this->tokens = $tokens;

        return $this;
    }
	
    /**
     * Get tokens
     *
     * @return string
     */
    public function getTokens()
    {
        return $this->tokens;
    }
	
    /**
     * Set banned
     *
     * @param boolean $banned
     *
     * @return Actor
     */
    public function setBanned($banned)
    {
        $this->banned = $banned;

        return $this;
    }
	
    /**
     * Get banned
     *
     * @return boolean
     */
    public function getBanned()
    {
        return $this->banned;
    }
	
    /**
     * Set actorrank
     *
     * @param integer $actorrank
     *
     * @return Actor
     */
    public function setActorRank($actorrank = null)
    {
        $this->actorrank = $actorrank;
		
        return $this;
    }
	
    /**
     * Get actorrank
     *
     * @return integer
     */
    public function getActorRank()
    {
        return $this->actorrank;
    }
	
    /**
     * Get raw rank
     *
     * @return integer
     */
	public function getRawRank()
	{
		if (parent::refsAreLoaded()) return $this->actorrank->getRank();
		else return $this->actorrank;
	}
	
    /**
     * Checks if actor is subscribed to a section
     * @param integer $sectionid: section id
     * @return integer
     */
	public function isSubscribed($sectionid)
	{
		return parent::$_em->createQuery('SELECT count(s.actor) FROM SectionSubscription s WHERE s.actor = :actor AND s.section = :section')
							->setParameter('actor', $this->getId())
							->setParameter('section', $sectionid)
							->getSingleScalarResult();
	}
	
	/**
     * Gets the full subscription object
     * @param integer $sectionid: section id
     * @return SectionSubscription
     */
	public function getSubscription($sectionid)
	{
		return parent::$_em->createQuery('SELECT s FROM SectionSubscription s WHERE s.actor = :actor AND s.section = :section')
							->setParameter('actor', $this->getId())
							->setParameter('section', $sectionid)
							->getResult();
	}
	
	/* ============== PROXY ============== */
	
	public function loadReferences()
	{
		if (parent::refsAreLoaded()) return;
		
		$this->actorrank = $this->em->find('ActorRank', $this->actorrank);
		
		parent::loadReferences();
	}
	public function unloadReferences()
	{
		if (!parent::refsAreLoaded()) return;
		
		$this->actorrank = $this->actorrank->getId();
		
		parent::unloadReferences();
	}
}

abstract class ActorBalanceMetrix
{
	const TOKEN_RATE = 1;
	const HIGH_TRANSFER_RATE = 0.8;
	const LOW_TRANSFER_RATE = 0.55;
}
